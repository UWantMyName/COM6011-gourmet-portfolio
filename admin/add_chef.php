<?php
// admin/add_chef.php
include __DIR__ . '/../inc/header_admin.php';
include __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Sanitize text inputs
    $name  = $conn->real_escape_string($_POST['name']);
    $role  = $conn->real_escape_string($_POST['role']);
    $spec  = $conn->real_escape_string($_POST['specialty']);
    $bio   = $conn->real_escape_string($_POST['biography']);
    $exp   = (int)$_POST['experience_years'];
    $guilt = $conn->real_escape_string($_POST['guilty_pleasure']);

    // 2) Insert chef without image_path
    $stmt = $conn->prepare("
        INSERT INTO chefs
          (name, role, specialty, biography, experience_years, guilty_pleasure)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssss", $name, $role, $spec, $bio, $exp, $guilt);
    if (!$stmt->execute()) {
        die("Error creating chef: " . htmlspecialchars($stmt->error));
    }
    // Grab the new chef ID
    $chef_id = $stmt->insert_id;
    $stmt->close();

    // 3) Handle image upload (now that we know $chef_id)
    $imgPath = null;
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../images/chefs/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        // Determine extension and set filename to the chef ID
        $ext      = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $filename = $chef_id . '.' . $ext;
        $target   = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imgPath = 'images/chefs/' . $filename;
        }
    }

    // 4) Update chef record with image_path (if uploaded)
    if ($imgPath) {
        $upd = $conn->prepare("
            UPDATE chefs
               SET image_path = ?
             WHERE id = ?
        ");
        $upd->bind_param("si", $imgPath, $chef_id);
        $upd->execute();
        $upd->close();
    }

    // 5) Redirect back to chef list
    header("Location: chefs.php");
    exit;
}
?>

<div class="container animate-on-scroll" style="padding-top:6rem;">
  <h1 class="animate-on-scroll">Add New Chef</h1>

  <form method="post" enctype="multipart/form-data"
        class="animate-on-scroll"
        style="max-width:600px; margin-top:2rem;">
    <!-- Name, Role, Specialty, etc. -->
    <label class="animate-on-scroll">Name:<br>
      <input type="text" name="name" required class="form-input">
    </label><br><br>

    <label class="animate-on-scroll">Role:<br>
      <select name="role" required class="form-input">
        <option>Executive Chef</option>
        <option>Head Chef</option>
        <option>Sous Chef</option>
        <option>Chef de Partie</option>
        <option>Commis Chef</option>
        <option>Kitchen Porter</option>
      </select>
    </label><br><br>

    <label class="animate-on-scroll">Specialty:<br>
      <input type="text" name="specialty" maxlength="400" required class="form-input">
    </label><br><br>

    <label class="animate-on-scroll">Experience (years):<br>
      <input type="number" name="experience_years" min="0" required class="form-input">
    </label><br><br>

    <label class="animate-on-scroll">Biography:<br>
      <textarea name="biography" rows="4" class="form-input"></textarea>
    </label><br><br>

    <label class="animate-on-scroll">Guilty Pleasure:<br>
      <textarea name="guilty_pleasure" rows="2" class="form-input"></textarea>
    </label><br><br>

    <!-- Chef Photo -->
    <label class="animate-on-scroll">Chef Photo:<br>
      <input type="file" name="image" accept="image/*" class="form-input">
      <small>(Will be saved as <code>images/chefs/&lt;chef_id&gt;.&lt;ext&gt;</code>)</small>
    </label><br><br>

    <button type="submit" class="admin-btn animate-on-scroll">Save Chef</button>
    <a href="chefs.php" class="admin-btn animate-on-scroll">Cancel</a>
  </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
