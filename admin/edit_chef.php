<?php
// admin/edit_chef.php
include __DIR__ . '/../inc/header.php';
include __DIR__ . '/../config.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid chef ID.");
}
$chef_id = (int)$_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $conn->real_escape_string($_POST['name']);
    $role  = $conn->real_escape_string($_POST['role']);
    $spec  = $conn->real_escape_string($_POST['specialty']);
    $bio   = $conn->real_escape_string($_POST['biography']);
    $exp   = (int)$_POST['experience_years'];
    $guilt = $conn->real_escape_string($_POST['guilty_pleasure']);

    $stmt = $conn->prepare("
        UPDATE chefs
        SET name=?, role=?, specialty=?, biography=?, experience_years=?, guilty_pleasure=?
        WHERE id=?
    ");
    $stmt->bind_param(
        "ssssisi",
        $name, $role, $spec, $bio, $exp, $guilt, $chef_id
    );

    if ($stmt->execute()) {
        header("Location: chefs.php");
        exit;
    } else {
        echo "<p style='color:red;'>Error updating: " . $conn->error . "</p>";
    }
}

// Fetch current chef data
$stmt = $conn->prepare("SELECT * FROM chefs WHERE id=?");
$stmt->bind_param("i", $chef_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    die("Chef not found.");
}
$chef = $res->fetch_assoc();
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <h1>Edit Chef: <?= htmlspecialchars($chef['name']) ?></h1>

  <form method="post" style="max-width:600px; margin-top:2rem;">
    <label>
      Name:<br>
      <input name="name" value="<?= htmlspecialchars($chef['name']) ?>" required class="form-input">
    </label><br><br>

    <label>
      Role:<br>
      <select name="role" required class="form-input">
        <?php
        $roles = ['Executive Chef','Head Chef','Sous Chef','Chef de Partie','Commis Chef','Kitchen Porter'];
        foreach ($roles as $r) {
          $sel = $chef['role'] === $r ? 'selected' : '';
          echo "<option value=\"$r\" $sel>$r</option>";
        }
        ?>
      </select>
    </label><br><br>

    <label>
      Specialty:<br>
      <input name="specialty" maxlength="400" 
             value="<?= htmlspecialchars($chef['specialty']) ?>" 
             required class="form-input">
    </label><br><br>

    <label>
      Experience (years):<br>
      <input type="number" name="experience_years" min="0" 
             value="<?= (int)$chef['experience_years'] ?>" 
             required class="form-input">
    </label><br><br>

    <label>
      Biography:<br>
      <textarea name="biography" rows="4" class="form-input"><?= htmlspecialchars($chef['biography']) ?></textarea>
    </label><br><br>

    <label>
      Guilty Pleasure:<br>
      <textarea name="guilty_pleasure" rows="2" class="form-input"><?= htmlspecialchars($chef['guilty_pleasure']) ?></textarea>
    </label><br><br>

    <button type="submit" class="btn">Save Changes</button>
    <a href="chefs.php" class="btn btn-sm">Cancel</a>
  </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
