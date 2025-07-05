<?php
// chef.php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/config.php';

// Get & validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("Invalid chef ID.");
}
$chef_id = (int)$_GET['id'];

// Fetch chef
$stmt = $conn->prepare("SELECT * FROM chefs WHERE id = ?");
$stmt->bind_param("i", $chef_id);
$stmt->execute();
$cRes = $stmt->get_result();
if ($cRes->num_rows === 0) {
  die("Chef not found.");
}
$chef = $cRes->fetch_assoc();

// Fetch recipes by this chef
$rStmt = $conn->prepare("
  SELECT id, title, image_path 
  FROM recipes 
  WHERE chef_id = ? 
  ORDER BY date_created DESC
");
$rStmt->bind_param("i", $chef_id);
$rStmt->execute();
$rRes = $rStmt->get_result();
?>

<div class="hero-slider" style="height:40vh; margin-top:4rem;">
  <div class="slides">
    <!-- optional rotating background of chef at work -->
    <div class="slide" style="background-image:url('images/chefs/<?= $chef_id ?>.jpg')"></div>
    <!-- you can add more .slide divs here for multiple images -->
  </div>
  <div class="overlay"></div>
  <div class="hero-content" data-aos="fade-up">
    <h1><?= htmlspecialchars($chef['name']) ?></h1>
    <p class="chef-role"><?= htmlspecialchars($chef['role']) ?> • <em><?= htmlspecialchars($chef['specialty']) ?></em></p>
  </div>
</div>

<div class="container" data-aos="fade-up" style="padding:3rem 0;">
  <!-- Bio & Stats -->
  <div style="display:grid; grid-template-columns:1fr 2fr; gap:2rem; align-items:start;">
    <!-- Chef Portrait -->
    <div>
      <img src="images/chefs/<?= $chef_id ?>.jpg"
           alt="<?= htmlspecialchars($chef['name']) ?>"
           style="width:100%; border-radius:8px; object-fit:cover;">
    </div>
    <!-- Details -->
    <div>
      <h2>About <?= htmlspecialchars($chef['name']) ?></h2>
      <p><strong>Experience:</strong> <?= (int)$chef['experience_years'] ?> years</p>
      <p><?= nl2br(htmlspecialchars($chef['biography'])) ?></p>
      <p><strong>Guilty Pleasure:</strong> <?= htmlspecialchars($chef['guilty_pleasure']) ?></p>
    </div>
  </div>

  <!-- Chef’s Recipes -->
  <?php if ($rRes->num_rows): ?>
    <section style="margin-top:4rem;">
      <h2 data-aos="fade-right">Recipes by <?= htmlspecialchars($chef['name']) ?></h2>
      <div class="grid-3" data-aos="fade-up" style="margin-top:1rem;">
        <?php while($r = $rRes->fetch_assoc()): ?>
          <a href="recipe.php?id=<?= $r['id'] ?>" class="card">
            <img src="<?= htmlspecialchars($r['image_path']) ?>" alt="<?= htmlspecialchars($r['title']) ?>"
                 style="height:160px; object-fit:cover;">
            <h3><?= htmlspecialchars($r['title']) ?></h3>
          </a>
        <?php endwhile; ?>
      </div>
    </section>
  <?php else: ?>
    <p style="margin-top:2rem;">No recipes found for this chef.</p>
  <?php endif; ?>
</div>

<?php
include __DIR__ . '/inc/footer.php';
?>
