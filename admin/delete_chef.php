<?php
// admin/delete_chef.php
include __DIR__ . '/../config.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid chef ID.");
}
$chef_id = (int)$_GET['id'];

// Perform delete
$stmt = $conn->prepare("DELETE FROM chefs WHERE id = ?");
$stmt->bind_param("i", $chef_id);
$stmt->execute();

// Redirect back to list
header("Location: chefs.php");
exit;
