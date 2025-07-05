<?php
// chefs.php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/config.php';

// ─── Collect & Sanitize Inputs ───
$search = trim($_GET['q'] ?? '');
$filter = trim($_GET['role'] ?? '');

$allowedSort  = ['experience_years','name'];
$allowedOrder = ['ASC','DESC'];
$sort  = in_array($_GET['sort'] ?? '',  $allowedSort ) ? $_GET['sort']  : 'experience_years';
$order = in_array(strtoupper($_GET['order'] ?? ''), $allowedOrder) ? strtoupper($_GET['order']) : 'DESC';

// ─── Build WHERE Clauses ───
$where  = [];
$params = [];
$types  = '';

if ($search !== '') {
    $where[]  = "(name LIKE ? OR role LIKE ? OR specialty LIKE ?)";
    $like     = "%{$search}%";
    $params  += [$like, $like, $like];
    $types   .= 'sss';
}

if ($filter !== '') {
    $where[]   = "role = ?";
    $params[]  = $filter;
    $types    .= 's';
}

$whereSQL = $where ? 'WHERE '.implode(' AND ', $where) : '';

// ─── Fetch Distinct Roles for Filter Dropdown ───
$roleRes = $conn->query("SELECT DISTINCT role FROM chefs ORDER BY role");

// ─── Fetch Chefs ───
$sql  = "SELECT * FROM chefs $whereSQL ORDER BY $sort $order";
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...array_values($params));
}
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container" style="padding-top:6rem;" data-aos="fade-up">
  <h1 data-aos="fade-right">Our Michelin Chefs</h1>

  <!-- Search / Filter / Sort Form -->
  <form method="get" action="chefs.php" id="filterForm" data-aos="fade-up"
        style="display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:1rem; margin-top:1rem;">
    <!-- Search -->
    <input type="text" name="q"
           value="<?= htmlspecialchars($search) ?>"
           placeholder="Search chefs…"
           class="form-input"
           onkeypress="if(event.key==='Enter') this.form.submit()">

    <!-- Role Filter -->
    <select name="role" class="form-input" onchange="this.form.submit()">
      <option value="">— All Roles —</option>
      <?php while($r = $roleRes->fetch_assoc()): 
        $sel = $r['role'] === $filter ? 'selected' : '';
      ?>
        <option value="<?= htmlspecialchars($r['role']) ?>" <?= $sel ?>>
          <?= htmlspecialchars($r['role']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <!-- Sort Field -->
    <select name="sort" class="form-input" onchange="this.form.submit()">
      <option value="experience_years" <?= $sort==='experience_years' ? 'selected' : '' ?>>
        Experience
      </option>
      <option value="name" <?= $sort==='name' ? 'selected' : '' ?>>
        Name
      </option>
    </select>

    <!-- Order Direction -->
    <select name="order" class="form-input" onchange="this.form.submit()">
      <option value="DESC" <?= $order==='DESC' ? 'selected' : '' ?>>Descending</option>
      <option value="ASC"  <?= $order==='ASC'  ? 'selected' : '' ?>>Ascending</option>
    </select>
  </form>

  <!-- Chefs Grid -->
  <div class="grid-3" style="margin-top:2rem;" data-aos="fade-up">
    <?php if ($res && $res->num_rows): ?>
      <?php while($chef = $res->fetch_assoc()): ?>
        <a href="chef.php?id=<?= $chef['id'] ?>" class="card">
          <img src="images/chefs/<?= $chef['id'] ?>.jpg"
               alt="<?= htmlspecialchars($chef['name']) ?>">
          <h3><?= htmlspecialchars($chef['name']) ?></h3>
          <p><strong><?= htmlspecialchars($chef['role']) ?></strong></p>
          <p><em><?= htmlspecialchars($chef['specialty']) ?></em></p>
          <p><?= (int)$chef['experience_years'] ?> years</p>
        </a>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No chefs found.</p>
    <?php endif; ?>
  </div>
</div>

<?php
$stmt->close();
$conn->close();
include __DIR__ . '/inc/footer.php';
?>
