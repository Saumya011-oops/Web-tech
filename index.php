<?php
include 'db_connect.php';

// Fetch players from database (we still need this for stats)
$result = $conn->query("SELECT * FROM players ORDER BY id DESC");

// Get statistics
$stats = $conn->query("SELECT COUNT(*) as total_players, 
                      SUM(matches) as total_matches,
                      SUM(runs) as total_runs,
                      SUM(wickets) as total_wickets 
                      FROM players")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cricket Player Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>🏏 Cricket Player Management</h1>
        
        <!-- Navigation Section -->
        <div style="display: flex; gap: 15px; justify-content: center; margin-bottom: 30px; flex-wrap: wrap;">
            <a href="teams.php" class="btn" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">
                👥 Manage Teams
            </a>
            <a href="compare_players.php" class="btn" style="background: linear-gradient(135deg, #e74c3c, #e67e22);">
                ⚔️ Compare Players
            </a>
            <a href="search_players.php" class="btn" style="background: linear-gradient(135deg, #3498db, #2980b9);">
                🔍 Advanced Search
            </a>
            <a href="add_player.php" class="btn">
                ➕ Add New Player
            </a>
            <!-- NEW: Link to view all players -->
            <a href="all_players.php" class="btn" style="background: linear-gradient(135deg, #9b59b6, #8e44ad);">
                👥 View All Players
            </a>
        </div>
        
        <!-- Statistics Dashboard -->
        <div class="stats">
            <div class="stat-card">
                <h3>Total Players</h3>
                <p><?= $stats['total_players'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Matches</h3>
                <p><?= $stats['total_matches'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Runs</h3>
                <p><?= $stats['total_runs'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Wickets</h3>
                <p><?= $stats['total_wickets'] ?></p>
            </div>
        </div>

        <!-- Top Performers Section -->
        <h2>🏆 Top Performers</h2>
        <div class="top-performers">
            <!-- Most Runs -->
            <div class="performer-card">
                <h3>🔥 Most Runs</h3>
                <?php
                $most_runs = $conn->query("SELECT name, runs, country FROM players ORDER BY runs DESC LIMIT 5");
                $rank = 1;
                while($row = $most_runs->fetch_assoc()) {
                    $badge_class = $rank == 1 ? 'badge-gold' : ($rank == 2 ? 'badge-silver' : ($rank == 3 ? 'badge-bronze' : ''));
                    $badge = $rank <= 3 ? "<span class='badge $badge_class'>$rank</span>" : "";
                    echo "<div class='performer-item'>
                            <div class='player-info'>
                                <div class='player-avatar'>" . substr($row['name'], 0, 1) . "</div>
                                <div>
                                    <div class='player-name'>" . htmlspecialchars($row['name']) . "$badge</div>
                                    <small style='color: #7f8c8d;'>" . htmlspecialchars($row['country']) . "</small>
                                </div>
                            </div>
                            <div class='player-stats'>" . $row['runs'] . " runs</div>
                          </div>";
                    $rank++;
                }
                ?>
            </div>

            <!-- Most Wickets -->
            <div class="performer-card">
                <h3>🎯 Most Wickets</h3>
                <?php
                $most_wickets = $conn->query("SELECT name, wickets, country FROM players ORDER BY wickets DESC LIMIT 5");
                $rank = 1;
                while($row = $most_wickets->fetch_assoc()) {
                    $badge_class = $rank == 1 ? 'badge-gold' : ($rank == 2 ? 'badge-silver' : ($rank == 3 ? 'badge-bronze' : ''));
                    $badge = $rank <= 3 ? "<span class='badge $badge_class'>$rank</span>" : "";
                    echo "<div class='performer-item'>
                            <div class='player-info'>
                                <div class='player-avatar'>" . substr($row['name'], 0, 1) . "</div>
                                <div>
                                    <div class='player-name'>" . htmlspecialchars($row['name']) . "$badge</div>
                                    <small style='color: #7f8c8d;'>" . htmlspecialchars($row['country']) . "</small>
                                </div>
                            </div>
                            <div class='player-stats'>" . $row['wickets'] . " wickets</div>
                          </div>";
                    $rank++;
                }
                ?>
            </div>

            <!-- Best Batting Average -->
            <div class="performer-card">
                <h3>📈 Best Batting Average</h3>
                <?php
                $best_avg = $conn->query("SELECT name, runs, matches, country,
                                         CASE WHEN matches > 0 THEN ROUND(runs/matches, 2) ELSE 0 END as average 
                                         FROM players 
                                         WHERE matches > 0 
                                         ORDER BY average DESC LIMIT 5");
                $rank = 1;
                while($row = $best_avg->fetch_assoc()) {
                    $badge_class = $rank == 1 ? 'badge-gold' : ($rank == 2 ? 'badge-silver' : ($rank == 3 ? 'badge-bronze' : ''));
                    $badge = $rank <= 3 ? "<span class='badge $badge_class'>$rank</span>" : "";
                    echo "<div class='performer-item'>
                            <div class='player-info'>
                                <div class='player-avatar'>" . substr($row['name'], 0, 1) . "</div>
                                <div>
                                    <div class='player-name'>" . htmlspecialchars($row['name']) . "$badge</div>
                                    <small style='color: #7f8c8d;'>" . htmlspecialchars($row['country']) . "</small>
                                </div>
                            </div>
                            <div class='player-stats'>" . $row['average'] . "</div>
                          </div>";
                    $rank++;
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>