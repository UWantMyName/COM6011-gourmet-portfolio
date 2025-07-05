<?php
// admin/edit_recipe.php
include __DIR__ . '/../inc/header.php';
include __DIR__ . '/../config.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid recipe ID.");
}
$rid = (int)$_GET['id'];

// Fetch chefs for dropdown
$chefs = $conn->query("SELECT id,name FROM chefs ORDER BY name");

// Handle POST update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $conn->real_escape_string($_POST['title']);
    $chef_id = (int)$_POST['chef_id'];
    $cuisine = $conn->real_escape_string($_POST['cuisine']);
    $date    = $conn->real_escape_string($_POST['date_created']);
    $ing     = $conn->real_escape_string($_POST['ingredients']);
    $desc    = $conn->real_escape_string($_POST['description']);
    $prep    = (int)$_POST['prep_time_minutes'];
    $cook    = (int)$_POST['cook_time_minutes'];

    // Possibly update image
    $imgPath = $_POST['existing_image'];
    if (!empty($_FILES['image']['name'])) {
        $targetDir = __DIR__ . '/../images/';
        $fname     = basename($_FILES['image']['name']);
        $target    = $targetDir . uniqid() . '-' . $fname;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imgPath = 'images/' . basename($target);
        }
    }

    $stmt = $conn->prepare("
      UPDATE recipes
      SET title=?, chef_id=?, cuisine=?, date_created=?, ingredients=?, description=?, image_path=?, prep_time_minutes=?, cook_time_minutes=?
      WHERE id=?
    ");
    $stmt->bind_param(
      "sisssssiii",
      $title, $chef_id, $cuisine, $date, $ing, $desc, $imgPath, $prep, $cook, $rid
    );
    if ($stmt->execute()) {
        header("Location: recipes.php");
        exit;
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
}

// Fetch existing recipe
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $rid);
$stmt->execute();
$rRes = $stmt->get_result();
if ($rRes->num_rows === 0) {
    die("Recipe not found.");
}
$recipe = $rRes->fetch_assoc();
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <h1>Edit Recipe: <?= htmlspecialchars($recipe['title']) ?></h1>
  <form method="post" enctype="multipart/form-data" style="max-width:600px; margin-top:2rem;">
    <label>Title:<br>
      <input name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required class="form-input">
    </label><br><br>

    <label>Chef:<br>
      <select name="chef_id" required class="form-input">
        <?php while($c = $chefs->fetch_assoc()): ?>
          <?php $sel = $c['id']==$recipe['chef_id'] ? 'selected' : ''; ?>
          <option value="<?= $c['id'] ?>" <?= $sel ?>>
            <?= htmlspecialchars($c['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </label><br><br>

    <label>Cuisine:<br>
      <input name="cuisine" value="<?= htmlspecialchars($recipe['cuisine']) ?>" required class="form-input">
    </label><br><br>

    <label>Date Created:<br>
      <input type="date" name="date_created" 
             value="<?= htmlspecialchars($recipe['date_created']) ?>" 
             required class="form-input">
    </label><br><br>

    <label>Ingredients:<br>
      <textarea name="ingredients" rows="3" required class="form-input"><?= htmlspecialchars($recipe['ingredients']) ?></textarea>
    </label><br><br>

    <label>Description:<br>
      <textarea name="description" rows="4" required class="form-input"><?= htmlspecialchars($recipe['description']) ?></textarea>
    </label><br><br>

    <label>Prep Time (mins):<br>
      <input type="number" name="prep_time_minutes" min="0" 
             value="<?= (int)$recipe['prep_time_minutes'] ?>" required class="form-input">
    </label><br><br>

    <label>Cook Time (mins):<br>
      <input type="number" name="cook_time_minutes" min="0" 
             value="<?= (int)$recipe['cook_time_minutes'] ?>" required class="form-input">
    </label><br><br>

    <label>Current Image:<br>
      <?php if ($recipe['image_path']): ?>
        <img src="../<?= htmlspecialchars($recipe['image_path']) ?>" 
             alt="" style="max-width:100px; display:block; margin-bottom:0.5rem;">
      <?php else: ?>
        <em>No image uploaded</em><br>
      <?php endif; ?>
      <input type="hidden" name="existing_image" value="<?= htmlspecialchars($recipe['image_path']) ?>">
      Replace Image:<br>
      <input type="file" name="image" accept="image/*" class="form-input">
    </label><br><br>

    <button type="submit" class="btn">Save Changes</button>
    <a href="recipes.php" class="btn btn-sm">Cancel</a>
  </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
