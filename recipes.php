<?php
// recipes.php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/config.php';

// ────────────── Handle GET Inputs ──────────────
// 1. Search query
$search  = trim($_GET['q'] ?? '');
// 2. Cuisine filter
$filter  = trim($_GET['cuisine'] ?? '');
// 3. Sort field & direction (with whitelist)
$allowedSort  = ['date_created','prep_time_minutes','cook_time_minutes'];
$allowedOrder = ['ASC','DESC'];
$sort  = in_array($_GET['sort'] ?? '',  $allowedSort)  ? $_GET['sort']  : 'date_created';
$order = in_array(strtoupper($_GET['order'] ?? ''), $allowedOrder) ? strtoupper($_GET['order']) : 'DESC';

// ────────────── Build WHERE Clauses ──────────────
$where = [];
$params = [];
$types  = '';

if ($search !== '') {
    $where[]  = "(r.title LIKE ? OR c.name LIKE ? OR r.cuisine LIKE ?)";
    $like     = "%{$search}%";
    $params  += [$like, $like, $like];
    $types   .= 'sss';
}

if ($filter !== '') {
    $where[]  = "r.cuisine = ?";
    $params[] = $filter;
    $types   .= 's';
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// ────────────── Fetch Distinct Cuisines for Filter Dropdown ──────────────
$cuiRes = $conn->query("SELECT DISTINCT cuisine FROM recipes ORDER BY cuisine");

// ────────────── Prepare & Execute Main Query ──────────────
$sql = "
  SELECT r.*, c.name AS chef_name
  FROM recipes r
  JOIN chefs c ON r.chef_id = c.id
  {$whereSQL}
  ORDER BY {$sort} {$order}
";
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...array_values($params));
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container animate-on-scroll" style="padding-top:6rem;">
  <h1 class="animate-on-scroll">Our Signature Recipes</h1>

  <!-- ─── Search, Filter & Sort Controls ─── -->
  <form method="get" action="recipes.php" id="filterForm"
        class="animate-on-scroll"
        style="display:grid; gap:1rem; grid-template-columns:1fr 1fr 1fr 1fr; align-items:center; margin-top:1rem;">
    <!-- Search -->
    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>"
           placeholder="Search recipes…" class="form-input animate-on-scroll">

    <!-- Cuisine Filter -->
    <select name="cuisine" class="form-input animate-on-scroll">
      <option value="">— All Cuisines —</option>
      <?php while($c = $cuiRes->fetch_assoc()): ?>
        <?php $sel = $c['cuisine'] === $filter ? 'selected' : ''; ?>
        <option value="<?= htmlspecialchars($c['cuisine']) ?>" <?= $sel ?>>
          <?= htmlspecialchars($c['cuisine']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <!-- Sort Field -->
    <select name="sort" class="form-input animate-on-scroll">
      <option value="date_created"      <?= $sort==='date_created'       ? 'selected' : '' ?>>Date Created</option>
      <option value="prep_time_minutes" <?= $sort==='prep_time_minutes'  ? 'selected' : '' ?>>Prep Time</option>
      <option value="cook_time_minutes" <?= $sort==='cook_time_minutes'  ? 'selected' : '' ?>>Cook Time</option>
    </select>

    <!-- Order Direction -->
    <select name="order" class="form-input animate-on-scroll">
      <option value="ASC"  <?= $order==='ASC'  ? 'selected' : '' ?>>Ascending</option>
      <option value="DESC" <?= $order==='DESC' ? 'selected' : '' ?>>Descending</option>
    </select>
  </form>

  <!-- ─── Recipe Grid ─── -->
  <div class="grid-3 animate-on-scroll" style="margin-top:2rem;">
    <?php if ($result && $result->num_rows): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <a href="recipe.php?id=<?= $row['id'] ?>" class="card animate-on-scroll">
          <img src="images/recipes/<?= htmlspecialchars($row['image_path']) ?>"
               alt="<?= htmlspecialchars($row['title']) ?>">
          <h3><?= htmlspecialchars($row['title']) ?></h3>
          <p><em><?= htmlspecialchars($row['cuisine']) ?></em></p>
          <p>By <?= htmlspecialchars($row['chef_name']) ?></p>
          <p>Prep: <?= $row['prep_time_minutes'] ?>m | Cook: <?= $row['cook_time_minutes'] ?>m</p>
        </a>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="animate-on-scroll">No recipes found.</p>
    <?php endif; ?>
  </div>
</div>

<script>
// Auto-submit on select change
document.querySelectorAll('#filterForm select').forEach(select => {
  select.addEventListener('change', () => {
    document.getElementById('filterForm').submit();
  });
});

// Make Enter in search field submit immediately
const searchInput = document.querySelector('#filterForm input[name="q"]');
if (searchInput) {
  searchInput.addEventListener('keypress', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      searchInput.form.submit();
    }
  });
}
</script>

<?php
$stmt->close();
$conn->close();
include __DIR__ . '/inc/footer.php';
?>
