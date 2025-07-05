<?php
include __DIR__ . '/../inc/header.php';
include __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $name  = $conn->real_escape_string($_POST['name']);
  $role  = $conn->real_escape_string($_POST['role']);
  $spec  = $conn->real_escape_string($_POST['specialty']);
  $bio   = $conn->real_escape_string($_POST['biography']);
  $exp   = (int)$_POST['experience_years'];
  $guilt = $conn->real_escape_string($_POST['guilty_pleasure']);

  $sql = "INSERT INTO chefs
    (name, role, specialty, biography, experience_years, guilty_pleasure)
    VALUES ('$name','$role','$spec','$bio',$exp,'$guilt')";
  if ($conn->query($sql)) {
    header("Location: chefs.php");
    exit;
  } else {
    echo "<p style='color:red;'>Error: ".$conn->error."</p>";
  }
}
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <h1>Add New Chef</h1>
  <form method="post">
    <label>Name:<br><input name="name" required></label><br><br>
    <label>Role:<br>
      <select name="role" required>
        <option>Executive Chef</option>
        <option>Head Chef</option>
        <option>Sous Chef</option>
        <option>Chef de Partie</option>
        <option>Commis Chef</option>
        <option>Kitchen Porter</option>
      </select>
    </label><br><br>
    <label>Specialty:<br>
      <input name="specialty" maxlength="400" required>
    </label><br><br>
    <label>Experience (years):<br><input type="number" name="experience_years" min="0" required></label><br><br>
    <label>Biography:<br><textarea name="biography" rows="4"></textarea></label><br><br>
    <label>Guilty Pleasure:<br><textarea name="guilty_pleasure" rows="2"></textarea></label><br><br>
    <button type="submit" class="btn">Save Chef</button>
    <a href="chefs.php" class="btn">Cancel</a>
  </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
