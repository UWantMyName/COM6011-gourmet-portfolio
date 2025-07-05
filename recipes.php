<?php
include 'config.php';

$sql = "SELECT recipes.*, chefs.name AS chef_name 
        FROM recipes 
        JOIN chefs ON recipes.chef_id = chefs.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Signature Recipes</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 2rem;
        }
        h1 {
            text-align: center;
        }
        .recipe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 2rem auto;
        }
        .recipe-card {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .recipe-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .recipe-content {
            padding: 1rem;
        }
        .recipe-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .recipe-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        .chef-link {
            color: #0077cc;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h1>Our Signature Recipes</h1>

<div class="recipe-grid">
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="recipe-card">';
        echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Recipe Image">';
        echo '<div class="recipe-content">';
        echo '<div class="recipe-title">' . htmlspecialchars($row['title']) . '</div>';
        echo '<div class="recipe-meta">By <a class="chef-link" href="chef.php?id=' . $row['chef_id'] . '">' . htmlspecialchars($row['chef_name']) . '</a></div>';
        echo '<div class="recipe-meta">Cuisine: ' . htmlspecialchars($row['cuisine']) . '</div>';
        echo '<div class="recipe-meta">Prep: ' . $row['prep_time_minutes'] . ' mins | Cook: ' . $row['cook_time_minutes'] . ' mins</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<p>No recipes found.</p>";
}
$conn->close();
?>
</div>

</body>
</html>
