<?php
include 'db_connect.php';

// Handle team creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_team'])) {
    $team_name = $_POST['team_name'];
    $conn->query("INSERT INTO teams (team_name) VALUES ('$team_name')");
    echo "<div class='alert alert-success'>Team created successfully!</div>";
}

// Handle player assignment to team
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_player'])) {
    $player_id = $_POST['player_id'];
    $team_id = $_POST['team_id'];
    
    // Remove player from any existing team first
    $conn->query("DELETE FROM player_teams WHERE player_id = $player_id");
    
    // Assign to new team
    $conn->query("INSERT INTO player_teams (player_id, team_id) VALUES ($player_id, $team_id)");
    echo "<div class='alert alert-success'>Player assigned to team successfully!</div>";
}

// Fetch all teams
$teams = $conn->query("SELECT * FROM teams");
// Fetch all players
$players = $conn->query("SELECT * FROM players");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Management - Cricket System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>👥 Team Management</h1>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
            <!-- Create Team Form -->
            <div class="form-container" style="margin: 0;">
                <h2>Create New Team</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Team Name</label>
                        <input type="text" name="team_name" class="form-control" placeholder="Enter team name" required>
                    </div>
                    <button type="submit" name="create_team" class="btn btn-primary">Create Team</button>
                </form>
            </div>

            <!-- Assign Player to Team -->
            <div class="form-container" style="margin: 0;">
                <h2>Assign Player to Team</h2>
                <form method="POST">
                    <div class="form-group">
                        <label>Select Player</label>
                        <select name="player_id" class="form-control" required>
                            <option value="">Choose a player</option>
                            <?php while($player = $players->fetch_assoc()): ?>
                                <option value="<?= $player['id'] ?>"><?= htmlspecialchars($player['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Team</label>
                        <select name="team_id" class="form-control" required>
                            <option value="">Choose a team</option>
                            <?php while($team = $teams->fetch_assoc()): ?>
                                <option value="<?= $team['id'] ?>"><?= htmlspecialchars($team['team_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" name="assign_player" class="btn btn-primary">Assign Player</button>
                </form>
            </div>
        </div>

        <!-- Teams List -->
        <h2>Existing Teams</h2>
        <div class="top-performers">
            <?php 
            $teams_with_players = $conn->query("
                SELECT t.*, GROUP_CONCAT(p.name SEPARATOR ', ') as player_names,
                       COUNT(pt.player_id) as player_count
                FROM teams t 
                LEFT JOIN player_teams pt ON t.id = pt.team_id 
                LEFT JOIN players p ON pt.player_id = p.id 
                GROUP BY t.id
            ");
            
            while($team = $teams_with_players->fetch_assoc()): 
            ?>
            <div class="performer-card">
                <h3>🏏 <?= htmlspecialchars($team['team_name']) ?></h3>
                <p><strong>Players: <?= $team['player_count'] ?></strong></p>
                <?php if($team['player_names']): ?>
                    <p><strong>Team Members:</strong><br><?= htmlspecialchars($team['player_names']) ?></p>
                <?php else: ?>
                    <p style="color: #7f8c8d;">No players assigned yet</p>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>

        <a href="index.php" class="btn btn-secondary" style="margin-top: 20px;">← Back to Dashboard</a>
    </div>
</body>
</html>