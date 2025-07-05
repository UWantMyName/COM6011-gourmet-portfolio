<?php
// chefs.php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/config.php';

// Fetch all chefs
$sql = "SELECT * FROM chefs ORDER BY experience_years DESC";
$res = $conn->query($sql);
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <h1 data-aos="fade-right">Our Michelin Chefs</h1>

  <div class="grid-3" data-aos="fade-up" style="margin-top:2rem;">
    <?php if ($res && $res->num_rows): ?>
      <?php while($chef = $res->fetch_assoc()): ?>
        <a href="chef.php?id=<?= $chef['id'] ?>" class="card">
          <!-- Chef Photo (place at images/chefs/{id}.jpg) -->
          <img src="images/chefs/<?= $chef['id'] ?>.jpg"
               alt="<?= htmlspecialchars($chef['name']) ?>"
               style="height:180px; object-fit:cover;">
          <div style="padding:1rem;">
            <h3><?= htmlspecialchars($chef['name']) ?></h3>
            <p style="margin:0.3rem 0; color:#777;">
              <strong><?= htmlspecialchars($chef['role']) ?></strong><br>
              <em><?= htmlspecialchars($chef['specialty']) ?></em>
            </p>
            <p style="font-size:0.9rem; color:#555;">
              <?= (int)$chef['experience_years'] ?> years’ experience
            </p>
          </div>
        </a>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No chefs found.</p>
    <?php endif; ?>
  </div>
</div>

<?php
include __DIR__ . '/inc/footer.php';
?>
