<?php
include 'db_connect.php';

// Fetch players from database
$result = $conn->query("SELECT * FROM players ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Players - Cricket Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>👥 All Players</h1>
        
        <div style="display: flex; gap: 15px; justify-content: center; margin-bottom: 30px; flex-wrap: wrap;">
            <a href="index.php" class="btn btn-secondary">← Back to Dashboard</a>
            <a href="add_player.php" class="btn">➕ Add New Player</a>
            <a href="search_players.php" class="btn" style="background: linear-gradient(135deg, #3498db, #2980b9);">
                🔍 Advanced Search
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Role</th>
                    <th>Matches</th>
                    <th>Runs</th>
                    <th>Wickets</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['country']); ?></td>
                    <td><?= htmlspecialchars($row['role']); ?></td>
                    <td><?= $row['matches']; ?></td>
                    <td><?= $row['runs']; ?></td>
                    <td><?= $row['wickets']; ?></td>
                    <td class="actions">
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">✏️ Edit</a>
                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this player?')">❌ Delete</a>
                        <a href="compare_players.php?player1=<?= $row['id']; ?>" class="btn-edit">⚔️ Compare</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <?php if($result->num_rows == 0): ?>
            <div class="no-data">
                <p>No players found. <a href="add_player.php">Add your first player</a></p>
            </div>
        <?php endif; ?>
        
        <a href="index.php" class="btn btn-secondary" style="margin-top: 30px;">← Back to Dashboard</a>
    </div>
</body>
</html>