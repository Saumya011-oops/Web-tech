<?php
include 'db_connect.php';

$player1 = null;
$player2 = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])) {
    $player1_id = $_POST['player1'];
    $player2_id = $_POST['player2'];
    
    $player1 = $conn->query("SELECT * FROM players WHERE id = $player1_id")->fetch_assoc();
    $player2 = $conn->query("SELECT * FROM players WHERE id = $player2_id")->fetch_assoc();
}

// Fetch all players for dropdown
$players = $conn->query("SELECT * FROM players ORDER BY name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Player Comparison - Cricket System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .comparison-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }
        .player-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .winner {
            color: #27ae60;
            font-weight: bold;
        }
        .vs-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(135deg, #1a2a6c, #b21f1f);
            color: white;
            padding: 15px 25px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 1.2em;
            z-index: 10;
        }
        .comparison-wrapper {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚔️ Player Comparison</h1>
        
        <!-- Comparison Form -->
        <div class="form-container">
            <form method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Select Player 1</label>
                        <select name="player1" class="form-control" required>
                            <option value="">Choose Player 1</option>
                            <?php while($player = $players->fetch_assoc()): ?>
                                <option value="<?= $player['id'] ?>" <?= isset($player1) && $player1['id'] == $player['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($player['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Player 2</label>
                        <select name="player2" class="form-control" required>
                            <option value="">Choose Player 2</option>
                            <?php 
                            $players->data_seek(0); // Reset pointer
                            while($player = $players->fetch_assoc()): 
                            ?>
                                <option value="<?= $player['id'] ?>" <?= isset($player2) && $player2['id'] == $player['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($player['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="compare" class="btn btn-primary" style="width: 200px; margin: 20px auto; display: block;">
                    Compare Players
                </button>
            </form>
        </div>

        <?php if ($player1 && $player2): ?>
        <div class="comparison-wrapper">
            <div class="vs-badge">VS</div>
            <div class="comparison-container">
                <!-- Player 1 Card -->
                <div class="player-card">
                    <h2 style="color: #1a2a6c;"><?= htmlspecialchars($player1['name']) ?></h2>
                    <p style="color: #7f8c8d; margin-bottom: 20px;"><?= htmlspecialchars($player1['team']) ?> • <?= htmlspecialchars($player1['role']) ?></p>
                    
                    <div class="stat-row">
                        <span>Matches</span>
                        <span class="<?= $player1['matches'] > $player2['matches'] ? 'winner' : '' ?>">
                            <?= $player1['matches'] ?>
                        </span>
                    </div>
                    <div class="stat-row">
                        <span>Runs</span>
                        <span class="<?= $player1['runs'] > $player2['runs'] ? 'winner' : '' ?>">
                            <?= $player1['runs'] ?>
                        </span>
                    </div>
                    <div class="stat-row">
                        <span>Wickets</span>
                        <span class="<?= $player1['wickets'] > $player2['wickets'] ? 'winner' : '' ?>">
                            <?= $player1['wickets'] ?>
                        </span>
                    </div>
                    <div class="stat-row">
                        <span>Batting Average</span>
                        <span class="<?= ($player1['matches'] > 0 ? $player1['runs']/$player1['matches'] : 0) > ($player2['matches'] > 0 ? $player2['runs']/$player2['matches'] : 0) ? 'winner' : '' ?>">
                            <?= $player1['matches'] > 0 ? number_format($player1['runs']/$player1['matches'], 2) : '0.00' ?>
                        </span>
                    </div>
                </div>

                <!-- Player 2 Card -->
                <div class="player-card">
                    <h2 style="color: #b21f1f;"><?= htmlspecialchars($player2['name']) ?></h2>
                    <p style="color: #7f8c8d; margin-bottom: 20px;"><?= htmlspecialchars($player2['team']) ?> • <?= htmlspecialchars($player2['role']) ?></p>
                    
                    <div class="stat-row">
                        <span>Matches</span>
                        <span class="<?= $player2['matches'] > $player1['matches'] ? 'winner' : '' ?>">
                            <?= $player2['matches'] ?>
                        </span>
                    </div>
                    <div class="stat-row">
                        <span>Runs</span>
                        <span class="<?= $player2['runs'] > $player1['runs'] ? 'winner' : '' ?>">
                            <?= $player2['runs'] ?>
                        </span>
                    </div>
                    <div class="stat-row">
                        <span>Wickets</span>
                        <span class="<?= $player2['wickets'] > $player1['wickets'] ? 'winner' : '' ?>">
                            <?= $player2['wickets'] ?>
                        </span>
                    </div>
                    <div class="stat-row">
                        <span>Batting Average</span>
                        <span class="<?= ($player2['matches'] > 0 ? $player2['runs']/$player2['matches'] : 0) > ($player1['matches'] > 0 ? $player1['runs']/$player1['matches'] : 0) ? 'winner' : '' ?>">
                            <?= $player2['matches'] > 0 ? number_format($player2['runs']/$player2['matches'], 2) : '0.00' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary" style="margin-top: 30px;">← Back to Dashboard</a>
    </div>
</body>
</html>