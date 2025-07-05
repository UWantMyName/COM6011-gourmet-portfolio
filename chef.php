<?php
// chef.php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/config.php';

// Validate & fetch chef
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid chef ID.");
}
$chef_id = (int)$_GET['id'];

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

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <!-- Static Hero / Banner -->
  <div class="chef-hero" style="text-align:center; margin-bottom:2rem;">
    <!-- You can drop in a single banner image, or remove entirely -->
    <img src="images/chefs/<?= $chef_id ?>.jpg"
         alt="<?= htmlspecialchars($chef['name']) ?>"
         style="width:200px; height:200px; border-radius:50%; object-fit:cover;">
    <h1 style="margin-top:1rem;"><?= htmlspecialchars($chef['name']) ?></h1>
    <p class="chef-role" style="color:#777;">
      <?= htmlspecialchars($chef['role']) ?> • <em><?= htmlspecialchars($chef['specialty']) ?></em>
    </p>
  </div>

  <!-- Bio & Stats -->
  <div style="display:grid; grid-template-columns:1fr 2fr; gap:2rem; align-items:start; margin-bottom:4rem;">
    <div>
      <h2>About <?= htmlspecialchars($chef['name']) ?></h2>
      <p><strong>Experience:</strong> <?= (int)$chef['experience_years'] ?> years</p>
    </div>
    <div>
      <p><?= nl2br(htmlspecialchars($chef['biography'])) ?></p>
      <p><strong>Guilty Pleasure:</strong> <?= htmlspecialchars($chef['guilty_pleasure']) ?></p>
    </div>
  </div>

  <!-- Chef’s Recipes -->
  <?php if ($rRes->num_rows): ?>
    <section>
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
    <p>No recipes found for this chef.</p>
  <?php endif; ?>

  <p style="margin-top:3rem;">
    <a href="chefs.php" style="color:#0077cc;">← Back to All Chefs</a>
  </p>
</div>

<?php
include __DIR__ . '/inc/footer.php';
?>
