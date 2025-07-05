<?php
// index.php
include __DIR__ . '/config.php';

// Fetch Executive & Head Chefs
$sql = "
  SELECT id,name,role,specialty
  FROM chefs
  WHERE role IN ('Executive Chef','Head Chef')
  ORDER BY FIELD(role,'Executive Chef','Head Chef'), name
";
$masters = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Michelinfolio • Home</title>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar">
    <div class="container">
      <a class="logo" href="index.php">Michelin<strong>folio</strong></a>
      <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="chefs.php">Chefs</a>
        <a href="recipes.php">Recipes</a>
      </div>
    </div>
  </nav>

  <!-- Slider Hero Section -->
  <header class="hero-slider">
    <div class="slides">
      <div class="slide" style="background-image:url('images/1.jpg')"></div>
      <div class="slide" style="background-image:url('images/2.jpg')"></div>
      <div class="slide" style="background-image:url('images/3.jpg')"></div>
      <div class="slide" style="background-image:url('images/4.jpg')"></div>
      <div class="slide" style="background-image:url('images/5.jpg')"></div>
      <div class="slide" style="background-image:url('images/6.jpg')"></div>
      <div class="slide" style="background-image:url('images/7.jpg')"></div>
    </div>
    <div class="overlay"></div>
    <div class="hero-content" data-aos="fade-up">
      <h1>Welcome to Michelinfolio</h1>
      <p>Discover the art and passion behind every Michelin-star worthy dish.</p>
      <a href="recipes.php" class="btn">Explore Recipes</a>
    </div>
  </header>

  <!-- About Section -->
  <section class="section about" data-aos="fade-up">
    <div class="container">
      <h2>Our Culinary Journey</h2>
      <p>At Michelinfolio, we curate the pinnacle of gastronomic excellence. Our chefs blend centuries-old traditions with modern innovation to craft dishes that look as stunning as they taste.</p>
      <p>Explore our curated team of Executive and Head Chefs—each a master of their craft, ready to inspire your next culinary adventure.</p>
    </div>
  </section>

  <!-- Dynamic “Our Master Chefs” -->
  <section class="section" id="featured-chefs" data-aos="fade-up">
    <div class="container">
      <h2 data-aos="fade-right">Our Master Chefs</h2>
      <div class="grid-3" data-aos="fade-up">
        <?php if ($masters && $masters->num_rows): ?>
          <?php while($chef = $masters->fetch_assoc()): ?>
            <a class="card" href="chef.php?id=<?= $chef['id'] ?>">
              <img src="images/chefs/<?= $chef['id'] ?>.jpg"
                   alt="<?= htmlspecialchars($chef['name']) ?>">
              <h3><?= htmlspecialchars($chef['name']) ?></h3>
              <p><strong><?= htmlspecialchars($chef['role']) ?></strong><br>
                 <em><?= htmlspecialchars($chef['specialty']) ?></em>
              </p>
            </a>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No master chefs found.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Michelinfolio. All rights reserved.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>AOS.init({ duration:800, once:true });</script>
</body>
</html>
