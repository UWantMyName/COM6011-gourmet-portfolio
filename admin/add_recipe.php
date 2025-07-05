<?php
// admin/add_recipe.php
include __DIR__ . '/../inc/header.php';
include __DIR__ . '/../config.php';

// Fetch chefs for dropdown
$chefs = $conn->query("SELECT id,name FROM chefs ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect & sanitize
    $title    = $conn->real_escape_string($_POST['title']);
    $chef_id  = (int)$_POST['chef_id'];
    $cuisine  = $conn->real_escape_string($_POST['cuisine']);
    $date     = $conn->real_escape_string($_POST['date_created']);
    $ing      = $conn->real_escape_string($_POST['ingredients']);
    $desc     = $conn->real_escape_string($_POST['description']);
    $prep     = (int)$_POST['prep_time_minutes'];
    $cook     = (int)$_POST['cook_time_minutes'];

    // Handle image upload
    $imgPath = '';
    if (!empty($_FILES['image']['name'])) {
        $targetDir = __DIR__ . '/../images/';
        $fname     = basename($_FILES['image']['name']);
        $target    = $targetDir . uniqid() . '-' . $fname;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imgPath = 'images/' . basename($target);
        }
    }

    // Insert
    $stmt = $conn->prepare("
      INSERT INTO recipes
      (title, chef_id, cuisine, date_created, ingredients, description, image_path, prep_time_minutes, cook_time_minutes)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
      "sisssssii",
      $title, $chef_id, $cuisine, $date, $ing, $desc, $imgPath, $prep, $cook
    );
    if ($stmt->execute()) {
        header("Location: recipes.php");
        exit;
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <h1>Add New Recipe</h1>
  <form method="post" enctype="multipart/form-data" style="max-width:600px; margin-top:2rem;">
    <label>Title:<br>
      <input name="title" required class="form-input">
    </label><br><br>

    <label>Chef:<br>
      <select name="chef_id" required class="form-input">
        <option value="">-- Select Chef --</option>
        <?php while($c = $chefs->fetch_assoc()): ?>
          <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endwhile; ?>
      </select>
    </label><br><br>

    <label>Cuisine:<br>
      <input name="cuisine" required class="form-input">
    </label><br><br>

    <label>Date Created:<br>
      <input type="date" name="date_created" required class="form-input">
    </label><br><br>

    <label>Ingredients:<br>
      <textarea name="ingredients" rows="3" required class="form-input"></textarea>
    </label><br><br>

    <label>Description:<br>
      <textarea name="description" rows="4" required class="form-input"></textarea>
    </label><br><br>

    <label>Prep Time (mins):<br>
      <input type="number" name="prep_time_minutes" min="0" required class="form-input">
    </label><br><br>

    <label>Cook Time (mins):<br>
      <input type="number" name="cook_time_minutes" min="0" required class="form-input">
    </label><br><br>

    <label>Image:<br>
      <input type="file" name="image" accept="image/*" class="form-input">
    </label><br><br>

    <button type="submit" class="btn">Save Recipe</button>
    <a href="recipes.php" class="btn btn-sm">Cancel</a>
  </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
