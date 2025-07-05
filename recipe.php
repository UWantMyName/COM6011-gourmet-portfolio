<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("Recipe ID is missing.");
}

$recipe_id = intval($_GET['id']);

$sql = "SELECT recipes.*, chefs.name AS chef_name, chefs.id AS chef_id 
        FROM recipes 
        JOIN chefs ON recipes.chef_id = chefs.id 
        WHERE recipes.id = $recipe_id";

$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("Recipe not found.");
}

$recipe = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($recipe['title']) ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: sans-serif;
            background: #f9f9f9;
            padding: 2rem;
            max-width: 800px;
            margin: auto;
        }
        img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
        h1 {
            margin-top: 1rem;
        }
        .meta {
            color: #555;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }
        .ingredients, .description {
            margin: 1.5rem 0;
        }
        .back-link {
            text-decoration: none;
            color: #0077cc;
            display: inline-block;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<img src="<?= htmlspecialchars($recipe['image_path']) ?>" alt="Recipe Image">

<h1><?= htmlspecialchars($recipe['title']) ?></h1>

<div class="meta">
    <strong>By:</strong> <a href="chef.php?id=<?= $recipe['chef_id'] ?>"><?= htmlspecialchars($recipe['chef_name']) ?></a><br>
    <strong>Cuisine:</strong> <?= htmlspecialchars($recipe['cuisine']) ?><br>
    <strong>Date Created:</strong> <?= htmlspecialchars($recipe['date_created']) ?><br>
    <strong>Prep Time:</strong> <?= $recipe['prep_time_minutes'] ?> mins<br>
    <strong>Cook Time:</strong> <?= $recipe['cook_time_minutes'] ?> mins
</div>

<div class="ingredients">
    <h3>Ingredients</h3>
    <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
</div>

<div class="description">
    <h3>Description</h3>
    <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
</div>

<a class="back-link" href="recipes.php">&larr; Back to Recipes</a>

</body>
</html>
