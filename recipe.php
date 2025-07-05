<?php
// recipe.php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/config.php';

// Validate & fetch recipe
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid recipe ID.");
}
$id = (int)$_GET['id'];

$stmt = $conn->prepare("
  SELECT r.*, c.name AS chef_name 
  FROM recipes r
  JOIN chefs c ON r.chef_id = c.id
  WHERE r.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Recipe not found.");
}
$recipe = $res->fetch_assoc();

// Fetch other recipes by this chef
$other = $conn->prepare("
  SELECT id, title, image_path 
  FROM recipes 
  WHERE chef_id = ? AND id <> ?
  ORDER BY date_created DESC
  LIMIT 4
");
$other->bind_param("ii", $recipe['chef_id'], $id);
$other->execute();
$others = $other->get_result();
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">

  <!-- Recipe Hero Image -->
  <div style="position:relative; margin-bottom:2rem;">
    <img src="<?= htmlspecialchars($recipe['image_path']) ?>" alt="" style="width:100%; max-height:400px; object-fit:cover; border-radius:8px;">
    <div style="
      position:absolute; top:0; left:0;
      width:100%; height:100%;
      background:rgba(0,0,0,0.3);
      border-radius:8px;
    "></div>
    <h1 style="
      position:absolute; bottom:1rem; left:1rem;
      color:#fff; margin:0;
      text-shadow:0 2px 6px rgba(0,0,0,0.7);
    "><?= htmlspecialchars($recipe['title']) ?></h1>
  </div>

  <!-- Metadata -->
  <p><strong>By:</strong> <a href="chef.php?id=<?= $recipe['chef_id'] ?>" style="color:#b48b31;"><?= htmlspecialchars($recipe['chef_name']) ?></a></p>
  <p><strong>Cuisine:</strong> <?= htmlspecialchars($recipe['cuisine']) ?> &nbsp; | &nbsp;
     <strong>Date:</strong> <?= htmlspecialchars($recipe['date_created']) ?> &nbsp; | &nbsp;
     <strong>Prep:</strong> <?= (int)$recipe['prep_time_minutes'] ?>m &nbsp; | &nbsp;
     <strong>Cook:</strong> <?= (int)$recipe['cook_time_minutes'] ?>m
  </p>

  <!-- Ingredients & Description -->
  <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; margin-top:2rem;">
    <div>
      <h3>Ingredients</h3>
      <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
    </div>
    <div>
      <h3>Description</h3>
      <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
    </div>
  </div>

  <!-- More from this Chef -->
  <?php if ($others->num_rows): ?>
    <section style="margin-top:4rem;">
      <h2 data-aos="fade-right">More by <?= htmlspecialchars($recipe['chef_name']) ?></h2>
      <div class="grid-3" data-aos="fade-up" style="margin-top:1rem;">
        <?php while($o = $others->fetch_assoc()): ?>
          <a href="recipe.php?id=<?= $o['id'] ?>" class="card">
            <img src="<?= htmlspecialchars($o['image_path']) ?>" alt="" style="height:160px; object-fit:cover;">
            <h3><?= htmlspecialchars($o['title']) ?></h3>
          </a>
        <?php endwhile; ?>
      </div>
    </section>
  <?php endif; ?>

  <p style="margin-top:3rem;"><a href="recipes.php" style="color:#0077cc;">← Back to Recipes</a></p>
</div>

<?php
include __DIR__ . '/inc/footer.php';
?>
