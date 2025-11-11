<?php
include('db_connect.php');

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM players WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $country = $_POST['country'];
    $role = $_POST['role'];
    $matches = $_POST['matches'];
    $runs = $_POST['runs'];
    $wickets = $_POST['wickets'];

    $conn->query("UPDATE players SET name='$name', country='$country', role='$role', matches=$matches, runs=$runs, wickets=$wickets WHERE id=$id");
    
    echo "<div class='alert alert-success'>
            <i>✅</i>
            <div>
              <strong>Success!</strong> Player updated successfully!
            </div>
          </div>";
    
    // Refresh the data
    $result = $conn->query("SELECT * FROM players WHERE id=$id");
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Player - Cricket Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1><i>✏️</i> Edit Player</h1>
            <p>Update the player information below</p>
        </div>
        
        <form method="POST" class="player-form">
            <div class="form-grid">
                <div class="form-group required">
                    <label for="name">Player Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                </div>

                <div class="form-group required">
                    <label for="country">country</label>
                    <input type="text" id="country" name="country" class="form-control" value="<?php echo htmlspecialchars($row['country']); ?>" required>
                </div>

                <div class="form-group required">
                    <label for="role">Role</label>
                    <input type="text" id="role" name="role" class="form-control" value="<?php echo htmlspecialchars($row['role']); ?>" required>
                </div>

                <div class="form-group required">
                    <label for="matches">Matches Played</label>
                    <input type="number" id="matches" name="matches" class="form-control" value="<?php echo $row['matches']; ?>" min="0" required>
                </div>

                <div class="form-group required">
                    <label for="runs">Total Runs</label>
                    <input type="number" id="runs" name="runs" class="form-control" value="<?php echo $row['runs']; ?>" min="0" required>
                </div>

                <div class="form-group required">
                    <label for="wickets">Total Wickets</label>
                    <input type="number" id="wickets" name="wickets" class="form-control" value="<?php echo $row['wickets']; ?>" min="0" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i>💾</i> Update Player
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i>←</i> Cancel
                </a>
            </div>
        </form>

        <a href="index.php" class="back-link">
            <i>←</i> Back to Player List
        </a>
    </div>
</body>
</html>