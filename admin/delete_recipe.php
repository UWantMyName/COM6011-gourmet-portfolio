<?php
// admin/delete_recipe.php
include __DIR__ . '/../config.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid recipe ID.");
}
$rid = (int)$_GET['id'];

// Optionally delete image file
$r = $conn->query("SELECT image_path FROM recipes WHERE id=$rid")->fetch_assoc();
if ($r['image_path'] && file_exists(__DIR__ . '/../' . $r['image_path'])) {
    unlink(__DIR__ . '/../' . $r['image_path']);
}

// Delete record
$stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
$stmt->bind_param("i", $rid);
$stmt->execute();

// Redirect
header("Location: recipes.php");
exit;
