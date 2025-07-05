<?php
// admin/recipes.php
include __DIR__ . '/../inc/header.php';
include __DIR__ . '/../config.php';

// Fetch all recipes with chef name
$sql = "
  SELECT r.id, r.title, c.name AS chef_name, r.cuisine, r.date_created
  FROM recipes r
  JOIN chefs c ON r.chef_id = c.id
  ORDER BY r.date_created DESC
";
$res = $conn->query($sql);
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <h1>Recipes</h1>
  <a href="add_recipe.php" class="btn">+ Add New Recipe</a>

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Chef</th>
        <th>Cuisine</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['title']) ?></td>
        <td><?= htmlspecialchars($r['chef_name']) ?></td>
        <td><?= htmlspecialchars($r['cuisine']) ?></td>
        <td><?= htmlspecialchars($r['date_created']) ?></td>
        <td>
          <a href="edit_recipe.php?id=<?= $r['id'] ?>" class="btn btn-sm">Edit</a>
          <a href="delete_recipe.php?id=<?= $r['id'] ?>"
             class="btn btn-sm"
             onclick="return confirm('Delete <?= htmlspecialchars($r['title']) ?>?')">
             Delete
          </a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
