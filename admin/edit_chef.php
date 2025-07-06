<?php
// admin/edit_chef.php
include __DIR__ . '/../inc/header.php';
include __DIR__ . '/../config.php';

// 1) Validate & fetch the chef ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid chef ID.");
}
$chef_id = (int)$_GET['id'];

// 2) On POST, process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name  = $conn->real_escape_string($_POST['name']);
    $role  = $conn->real_escape_string($_POST['role']);
    $spec  = $conn->real_escape_string($_POST['specialty']);
    $bio   = $conn->real_escape_string($_POST['biography']);
    $exp   = (int)$_POST['experience_years'];
    $guilt = $conn->real_escape_string($_POST['guilty_pleasure']);

    // 2a) Update all text fields first
    $stmt = $conn->prepare("
        UPDATE chefs
           SET name=?, role=?, specialty=?, biography=?, experience_years=?, guilty_pleasure=?
         WHERE id=?
    ");
    $stmt->bind_param(
        "ssssisi",
        $name,
        $role,
        $spec,
        $bio,
        $exp,
        $guilt,
        $chef_id
    );
    if (!$stmt->execute()) {
        die("Error updating chef: " . htmlspecialchars($stmt->error));
    }
    $stmt->close();

    // 2b) Handle new image upload if provided
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../images/chefs/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        // Remove old image if exists
        $old = $conn->query("SELECT image_path FROM chefs WHERE id = $chef_id")
                   ->fetch_assoc()['image_path'] ?? '';
        if ($old && file_exists(__DIR__ . '/../' . $old)) {
            @unlink(__DIR__ . '/../' . $old);
        }
        // Determine new filename based on chef_id
        $ext      = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $filename = $chef_id . '.' . $ext;
        $target   = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $newPath = 'images/chefs/' . $filename;
            $u2 = $conn->prepare("UPDATE chefs SET image_path = ? WHERE id = ?");
            $u2->bind_param("si", $newPath, $chef_id);
            $u2->execute();
            $u2->close();
        }
    }

    // Redirect back to chefs list
    header("Location: chefs.php");
    exit;
}

// 3) On GET, load existing chef data
$stmt = $conn->prepare("SELECT * FROM chefs WHERE id = ?");
$stmt->bind_param("i", $chef_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    die("Chef not found.");
}
$chef = $res->fetch_assoc();
$stmt->close();
?>

<div class="container animate-on-scroll" style="padding-top:6rem;">
  <h1 class="animate-on-scroll">Edit Chef: <?= htmlspecialchars($chef['name']) ?></h1>

  <form method="post" enctype="multipart/form-data"
        class="animate-on-scroll"
        style="max-width:600px; margin-top:2rem;">
    <!-- Name -->
    <label class="animate-on-scroll">Name:<br>
      <input type="text" name="name"
             value="<?= htmlspecialchars($chef['name']) ?>"
             required class="form-input">
    </label><br><br>

    <!-- Role -->
    <label class="animate-on-scroll">Role:<br>
      <select name="role" required class="form-input">
        <?php
        $roles = ['Executive Chef','Head Chef','Sous Chef','Chef de Partie','Commis Chef','Kitchen Porter'];
        foreach ($roles as $r) {
            $sel = $chef['role'] === $r ? 'selected' : '';
            echo "<option value=\"" . htmlspecialchars($r) . "\" $sel>" . htmlspecialchars($r) . "</option>";
        }
        ?>
      </select>
    </label><br><br>

    <!-- Specialty -->
    <label class="animate-on-scroll">Specialty:<br>
      <input type="text" name="specialty" maxlength="400"
             value="<?= htmlspecialchars($chef['specialty']) ?>"
             required class="form-input">
    </label><br><br>

    <!-- Experience -->
    <label class="animate-on-scroll">Experience (years):<br>
      <input type="number" name="experience_years" min="0"
             value="<?= (int)$chef['experience_years'] ?>"
             required class="form-input">
    </label><br><br>

    <!-- Biography -->
    <label class="animate-on-scroll">Biography:<br>
      <textarea name="biography" rows="4" class="form-input"><?= htmlspecialchars($chef['biography']) ?></textarea>
    </label><br><br>

    <!-- Guilty Pleasure -->
    <label class="animate-on-scroll">Guilty Pleasure:<br>
      <textarea name="guilty_pleasure" rows="2" class="form-input"><?= htmlspecialchars($chef['guilty_pleasure']) ?></textarea>
    </label><br><br>

    <!-- Current & New Photo -->
    <label class="animate-on-scroll">Chef Photo:<br>
      <?php if (!empty($chef['image_path'])): ?>
        <img src="../<?= htmlspecialchars($chef['image_path']) ?>"
             class="animate-on-scroll"
             style="max-width:120px; display:block; margin-bottom:0.5rem;"
             alt="Current Chef Photo">
      <?php endif; ?>
      <input type="file" name="image" accept="image/*" class="form-input">
      <small>(New upload will overwrite and be saved as <code><?= $chef_id ?>.&lt;ext&gt;</code>)</small>
    </label><br><br>

    <!-- Submit / Cancel -->
    <button type="submit" class="btn animate-on-scroll">Save Changes</button>
    <a href="chefs.php" class="btn btn-sm animate-on-scroll">Cancel</a>
  </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
