<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'inc/header.php';
require_once 'config.php';

// Ensure recipe ID is passed
if (!isset($_GET['id'])) {
    echo "<div class='container'><p>Recipe not found.</p></div>";
    include 'inc/footer.php';
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT r.*, c.name AS chef_name FROM recipes r 
          JOIN chefs c ON r.chef_id = c.id 
          WHERE r.id = $id";
$result = $conn->query($query);

// Recipe not found
if (!$result || $result->num_rows == 0) {
    echo "<div class='container'><p>Recipe not found.</p></div>";
    include 'inc/footer.php';
    exit;
}

$recipe = $result->fetch_assoc();
?>

<div class="container recipe-detail">
    <h1><?= htmlspecialchars($recipe['title']) ?></h1>

    <img src="/COM6011/images/recipes/<?= htmlspecialchars($recipe['image_path']) ?>"
     class="recipe-image"
     alt="<?= htmlspecialchars($recipe['title']) ?>">

    <div class="recipe-meta">
        <p>
            <strong>By:</strong> <?= htmlspecialchars($recipe['chef_name']) ?> |
            <strong>Cuisine:</strong> <?= htmlspecialchars($recipe['cuisine']) ?> |
            <strong>Date:</strong> <?= htmlspecialchars($recipe['date_created']) ?> |
            <strong>Prep:</strong> <?= (int)$recipe['prep_time_minutes'] ?>m |
            <strong>Cook:</strong> <?= (int)$recipe['cook_time_minutes'] ?>m
        </p>
    </div>

    <div class="recipe-section">
        <h3>Ingredients</h3>
        <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
    </div>

    <div class="recipe-section">
        <h3>Description</h3>
        <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
    </div>

    <a href="javascript:history.back()" class="btn back-btn">← Back</a>
</div>

<?php include 'inc/footer.php'; ?>
