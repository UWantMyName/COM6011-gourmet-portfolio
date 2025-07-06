<?php
// admin/dashboard.php
include __DIR__ . '/../inc/header_admin.php';
?>

<div class="container" style="padding-top:6rem;">
  <h1>Admin Dashboard</h1>

  <div class="admin-buttons">
    <a href="chefs.php" class="btn">Manage Chefs</a>
    <a href="recipes.php" class="btn">Manage Recipes</a>
  </div>
</div>

<?php
include __DIR__ . '/../inc/footer.php';
?>
