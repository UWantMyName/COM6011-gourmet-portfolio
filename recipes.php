<?php
  // recipes.php
  include __DIR__ . '/inc/header.php';
  include __DIR__ . '/config.php';

  // Build optional filter
  $where = '';
  if (!empty($_GET['cuisine'])) {
    $c = $conn->real_escape_string($_GET['cuisine']);
    $where = "WHERE cuisine='{$c}'";
  }

  // Fetch all cuisines for dropdown
  $cuisinesRes = $conn->query("SELECT DISTINCT cuisine FROM recipes");
  $cuisines = $cuisinesRes->fetch_all(MYSQLI_ASSOC);

  // Fetch recipes (with optional filter)
  $sql = "
    SELECT r.*, c.name AS chef_name 
    FROM recipes r
    JOIN chefs c ON r.chef_id = c.id
    {$where}
    ORDER BY r.date_created DESC
  ";
  $res = $conn->query($sql);
?>

<div class="container" style="padding-top:6rem;">

  <h1 data-aos="fade-right">Our Signature Recipes</h1>

  <!-- Cuisine Filter -->
  <form method="GET" action="recipes.php" data-aos="fade-up">
    <select name="cuisine" onchange="this.form.submit()" style="padding:0.5rem; font-size:1rem;">
      <option value="">— All Cuisines —</option>
      <?php foreach($cuisines as $row): ?>
        <?php $sel = ($_GET['cuisine'] ?? '') === $row['cuisine'] ? 'selected' : ''; ?>
        <option value="<?= htmlspecialchars($row['cuisine'])?>" <?= $sel ?>>
          <?= htmlspecialchars($row['cuisine'])?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <!-- Recipe Grid -->
  <div class="grid-3" style="margin-top:2rem;" data-aos="fade-up">
    <?php if ($res && $res->num_rows): ?>
      <?php while($r = $res->fetch_assoc()): ?>
        <a href="recipe.php?id=<?= $r['id'] ?>" class="card">
          <img src="<?= htmlspecialchars($r['image_path']) ?>" alt="<?= htmlspecialchars($r['title']) ?>">
          <h3><?= htmlspecialchars($r['title']) ?></h3>
          <p><em><?= htmlspecialchars($r['cuisine']) ?></em></p>
          <p>By <?= htmlspecialchars($r['chef_name']) ?></p>
          <p>Prep: <?= (int)$r['prep_time_minutes'] ?>m | Cook: <?= (int)$r['cook_time_minutes'] ?>m</p>
        </a>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No recipes found.</p>
    <?php endif; ?>
  </div>

</div>

<?php
  include __DIR__ . '/inc/footer.php';
?>
