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

// Fetch 3 Most Recent Recipes
$recipesSql = "
  SELECT id, title, description, image_path
  FROM recipes
  ORDER BY date_created DESC
  LIMIT 3
";
$recentRecipes = $conn->query($recipesSql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Michelinfolio • Home</title>
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
    <div class="hero-content animate-on-scroll">
      <h1>Welcome to Michelinfolio</h1>
      <p>Discover the art and passion behind every Michelin-star worthy dish.</p>
      <a href="recipes.php" class="btn">Explore Recipes</a>
    </div>
  </header>

  <!-- About Section -->
  <section class="section about animate-on-scroll">
    <div class="container">
      <h2>Our Culinary Journey</h2>
      <p>At Michelinfolio, we curate the pinnacle of gastronomic excellence. Our chefs blend centuries-old traditions with modern innovation to craft dishes that look as stunning as they taste.</p>
      <p>Explore our curated team of Executive and Head Chefs—each a master of their craft, ready to inspire your next culinary adventure.</p>
    </div>
  </section>

  <!-- Dynamic “Our Master Chefs” -->
  <section class="section animate-on-scroll" id="featured-chefs">
    <div class="container">
      <h2 class="animate-on-scroll">Our Master Chefs</h2>
      <div class="grid-3 animate-on-scroll">
        <?php if ($masters && $masters->num_rows): ?>
          <?php while($chef = $masters->fetch_assoc()): ?>
            <a class="card" href="chef.php?id=<?= $chef['id'] ?>">
              <img src="images/chefs/<?= $chef['id'] ?>.jpg" alt="<?= htmlspecialchars($chef['name']) ?>">
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

  <!-- Dynamic “Our Recent Recipes” -->
  <section class="section animate-on-scroll" id="recent-recipes">
    <div class="container">
      <h2 class="animate-on-scroll">Our Recent Recipes</h2>
      <div class="grid-3 animate-on-scroll">
        <?php if ($recentRecipes && $recentRecipes->num_rows): ?>
          <?php while($recipe = $recentRecipes->fetch_assoc()): ?>
            <a class="card" href="recipe.php?id=<?= $recipe['id'] ?>">
              <img src="images/recipes/<?= htmlspecialchars($recipe['image_path']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>">
              <h3><?= htmlspecialchars($recipe['title']) ?></h3>
              <p><?= htmlspecialchars($recipe['description']) ?></p>
            </a>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No recent recipes found.</p>
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

  <!-- Manual scroll-triggered animations -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const scrollElems = document.querySelectorAll('.animate-on-scroll');
      const inView = (el, offset = 50) => {
        const top = el.getBoundingClientRect().top;
        return top <= (window.innerHeight - offset);
      };
      const show = el => el.classList.add('visible');
      const hide = el => el.classList.remove('visible');
      const run = () => {
        scrollElems.forEach(el => {
          if (inView(el)) show(el);
          else hide(el);
        });
      };
      window.addEventListener('scroll', run);
      run();
    });
  </script>
</body>
</html>
