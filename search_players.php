<?php
include 'db_connect.php';

$search_results = [];
$search_performed = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search_performed = true;
    $name = $_POST['name'];
    $country = $_POST['country'];
    $role = $_POST['role'];
    $min_runs = $_POST['min_runs'];
    $min_wickets = $_POST['min_wickets'];
    
    // Build dynamic query
    $sql = "SELECT * FROM players WHERE 1=1";
    $params = [];
    
    if (!empty($name)) {
        $sql .= " AND name LIKE ?";
        $params[] = "%$name%";
    }
    if (!empty($country)) {
        $sql .= " AND country LIKE ?";
        $params[] = "%$country%";
    }
    if (!empty($role)) {
        $sql .= " AND role LIKE ?";
        $params[] = "%$role%";
    }
    if (!empty($min_runs)) {
        $sql .= " AND runs >= ?";
        $params[] = $min_runs;
    }
    if (!empty($min_wickets)) {
        $sql .= " AND wickets >= ?";
        $params[] = $min_wickets;
    }
    
    $sql .= " ORDER BY name";
    
    // Prepare and execute query
    $stmt = $conn->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $search_results = $stmt->get_result();
}

// Get unique countrys and roles for dropdowns
$countrys = $conn->query("SELECT DISTINCT country FROM players ORDER BY country");
$roles = $conn->query("SELECT DISTINCT role FROM players ORDER BY role");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Player Search - Cricket System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .search-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .results-count {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Advanced Player Search</h1>
        
        <!-- Search Form -->
        <div class="search-form">
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Player Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Search by name..." value="<?= $_POST['name'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>country</label>
                        <select name="country" class="form-control">
                            <option value="">All countrys</option>
                            <?php while($country_row = $countrys->fetch_assoc()): ?>
                                <option value="<?= $country_row['country'] ?>" <?= (isset($_POST['country']) && $_POST['country'] == $country_row['country']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($country_row['country']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value="">All Roles</option>
                            <?php while($role_row = $roles->fetch_assoc()): ?>
                                <option value="<?= $role_row['role'] ?>" <?= (isset($_POST['role']) && $_POST['role'] == $role_row['role']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($role_row['role']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Minimum Runs</label>
                        <input type="number" name="min_runs" class="form-control" placeholder="0" min="0" value="<?= $_POST['min_runs'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Minimum Wickets</label>
                        <input type="number" name="min_wickets" class="form-control" placeholder="0" min="0" value="<?= $_POST['min_wickets'] ?? '' ?>">
                    </div>
                </div>
                
                <button type="submit" name="search" class="btn btn-primary" style="width: 200px;">
                    🔍 Search Players
                </button>
                <a href="search_players.php" class="btn btn-secondary">Clear Filters</a>
            </form>
        </div>

        <?php if ($search_performed): ?>
            <?php if ($search_results->num_rows > 0): ?>
                <div class="results-count">
                    Found <?= $search_results->num_rows ?> player(s) matching your criteria
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>country</th>
                            <th>Role</th>
                            <th>Matches</th>
                            <th>Runs</th>
                            <th>Wickets</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($player = $search_results->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($player['name']) ?></td>
                            <td><?= htmlspecialchars($player['country']) ?></td>
                            <td><?= htmlspecialchars($player['role']) ?></td>
                            <td><?= $player['matches'] ?></td>
                            <td><?= $player['runs'] ?></td>
                            <td><?= $player['wickets'] ?></td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $player['id'] ?>" class="btn-edit">✏️ Edit</a>
                                <a href="compare_players.php?player1=<?= $player['id'] ?>" class="btn-edit">⚔️ Compare</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <h3>No players found matching your search criteria</h3>
                    <p>Try adjusting your filters or search terms</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary" style="margin-top: 30px;">← Back to Dashboard</a>
    </div>
</body>
</html>