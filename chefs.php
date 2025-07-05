<?php
// Enable full error reporting during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include DB config
include 'config.php';

// Run query to get chefs
$sql = "SELECT * FROM chefs";
$result = $conn->query($sql);

// Handle query failure
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Michelin Chefs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .chefs-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .chef-card {
            background: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 300px;
            padding: 20px;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }

        .chef-card h2 {
            margin-top: 0;
            color: #555;
        }

        .chef-role {
            font-weight: bold;
            color: #777;
        }

        .chef-specialty {
            font-style: italic;
            color: #999;
        }

        .chef-bio, .chef-guilt {
            margin-top: 10px;
            color: #333;
        }

        .chef-experience {
            margin-top: 8px;
            color: #444;
        }
    </style>
</head>
<body>

<h1>Our Michelin Chefs</h1>

<div class="chefs-container">
<?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="chef-card">
            <h2><?php echo htmlspecialchars($row['name']); ?></h2>
            <div class="chef-role"><?php echo htmlspecialchars($row['role']); ?></div>
            <div class="chef-specialty"><?php echo htmlspecialchars($row['specialty']); ?></div>
            <div class="chef-experience">Experience: <?php echo (int)$row['experience_years']; ?> years</div>
            <div class="chef-bio"><?php echo nl2br(htmlspecialchars($row['biography'])); ?></div>
            <div class="chef-guilt"><strong>Guilty Pleasure:</strong> <?php echo htmlspecialchars($row['guilty_pleasure']); ?></div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No chefs found.</p>
<?php endif; ?>
</div>

</body>
</html>
