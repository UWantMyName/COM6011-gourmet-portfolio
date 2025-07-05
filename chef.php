<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include DB config
include 'config.php';

// Get chef ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid chef ID.");
}

$chef_id = (int)$_GET['id'];

// Fetch chef from DB
$sql = "SELECT * FROM chefs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $chef_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Chef not found.");
}

$chef = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($chef['name']); ?> - Michelin Chef Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .profile-container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin-top: 0;
            color: #333;
        }

        .section-label {
            font-weight: bold;
            margin-top: 20px;
            color: #555;
        }

        .text-block {
            margin-top: 5px;
            color: #444;
        }

        .back-link {
            margin-top: 30px;
            display: inline-block;
            color: #0077cc;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h1><?php echo htmlspecialchars($chef['name']); ?></h1>
    <div class="section-label">Role:</div>
    <div class="text-block"><?php echo htmlspecialchars($chef['role']); ?></div>

    <div class="section-label">Specialty:</div>
    <div class="text-block"><?php echo htmlspecialchars($chef['specialty']); ?></div>

    <div class="section-label">Experience:</div>
    <div class="text-block"><?php echo (int)$chef['experience_years']; ?> years</div>

    <div class="section-label">Biography:</div>
    <div class="text-block"><?php echo nl2br(htmlspecialchars($chef['biography'])); ?></div>

    <div class="section-label">Guilty Pleasure:</div>
    <div class="text-block"><?php echo htmlspecialchars($chef['guilty_pleasure']); ?></div>

    <a href="chefs.php" class="back-link">← Back to Chefs</a>
</div>

</body>
</html>
