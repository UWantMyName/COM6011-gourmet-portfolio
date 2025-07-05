<?php
include __DIR__ . '/../inc/header.php';
include __DIR__ . '/../config.php';

$res = $conn->query("SELECT * FROM chefs ORDER BY id");
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <h1>Chefs</h1>
  <a href="add_chef.php" class="btn btn-sm">+ Add New Chef</a>

  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Role</th><th>Specialty</th><th>Exp (yrs)</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($c = $res->fetch_assoc()): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td><?= htmlspecialchars($c['role']) ?></td>
        <td><?= htmlspecialchars($c['specialty']) ?></td>
        <td><?= (int)$c['experience_years'] ?></td>
        <td>
          <a href="edit_chef.php?id=<?= $c['id'] ?>"   class="btn btn-sm">Edit</a>
          <a href="delete_chef.php?id=<?= $c['id'] ?>" class="btn btn-sm"
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
