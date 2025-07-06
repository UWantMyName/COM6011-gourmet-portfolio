<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/../config.php'; // Load DB first

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid recipe ID.");
}
$rid = (int)$_GET['id'];

// Fetch chefs for dropdown
$chefs = $conn->query("SELECT id, name FROM chefs ORDER BY name");

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

    $imgPath = basename($_POST['existing_image']);
    if (!empty($_FILES['image']['name'])) {
        $targetDir = __DIR__ . '/../images/recipes/';
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $newName = uniqid('img_') . '.' . $ext;
        $targetFile = $targetDir . $newName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imgPath = $newName;
        }
    }

    $stmt = $conn->prepare("
        UPDATE recipes
        SET title = ?, chef_id = ?, cuisine = ?, date_created = ?, ingredients = ?, description = ?, image_path = ?, prep_time_minutes = ?, cook_time_minutes = ?
        WHERE id = ?
    ");
    $stmt->bind_param(
        "sisssssiii",
        $title, $chef_id, $cuisine, $date, $ing, $desc, $imgPath, $prep, $cook, $rid
    );

    if ($stmt->execute()) {
        echo "<script>window.location.href = 'recipes.php';</script>";
        exit;
    } else {
        echo "<p style='color:red;'>Error: " . htmlspecialchars($stmt->error) . "</p>";
    }
}

// Fetch recipe AFTER handling POST
$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $rid);
$stmt->execute();
$rRes = $stmt->get_result();
if ($rRes->num_rows === 0) {
    die("Recipe not found.");
}
$recipe = $rRes->fetch_assoc();

// Only include HTML header now (after redirect logic)
include __DIR__ . '/../inc/header_admin.php';
?>
