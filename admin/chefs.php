<?php
include __DIR__ . '/../inc/header_admin.php';
include __DIR__ . '/../config.php';

$res = $conn->query("SELECT * FROM chefs ORDER BY id");
?>

<div class="container animate-on-scroll" style="padding-top:6rem;">
  <h1 class="animate-on-scroll">Chefs</h1>
  <a href="add_chef.php" class="btn btn-sm animate-on-scroll">+ Add New Chef</a>

  <table class="admin-table animate-on-scroll">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Role</th><th>Specialty</th><th>Exp (yrs)</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($c = $res->fetch_assoc()): ?>
      <tr class="animate-on-scroll">
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td><?= htmlspecialchars($c['role']) ?></td>
        <td><?= htmlspecialchars($c['specialty']) ?></td>
        <td><?= (int)$c['experience_years'] ?></td>
        <td>
          <a href="edit_chef.php?id=<?= $c['id'] ?>"   class="btn btn-sm animate-on-scroll">Edit</a>
          <a href="delete_chef.php?id=<?= $c['id'] ?>" class="btn btn-sm animate-on-scroll"
             onclick="return confirm('Delete <?= htmlspecialchars($c['name']) ?>?')">
            Delete
          </a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
