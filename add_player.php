<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $country = $_POST['country'];
  $role = $_POST['role'];
  $matches = $_POST['matches'];
  $runs = $_POST['runs'];
  $wickets = $_POST['wickets'];

  $sql = "INSERT INTO players (name, country, role, matches, runs, wickets)
          VALUES ('$name', '$country', '$role', $matches, $runs, $wickets)";
  
  if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success'>
            <i>✅</i>
            <div>
              <strong>Success!</strong> Player added successfully!
            </div>
          </div>";
  } else {
    echo "<div class='alert alert-danger'>
            <i>❌</i>
            <div>
              <strong>Error:</strong> " . $conn->error . "
            </div>
          </div>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Player - Cricket Management</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <div class="form-header">
      <h1><i>➕</i> Add New Player</h1>
      <p>Fill in the details below to add a new player to the system</p>
    </div>

    <form method="POST" action="">
      <div class="form-grid">
        <div class="form-group required">
          <label for="name">Player Name</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Enter player's full name" required>
        </div>

        <div class="form-group required">
          <label for="country">country</label>
          <input type="text" id="country" name="country" class="form-control" placeholder="Enter country name" required>
        </div>

        <div class="form-group required">
          <label for="role">Role</label>
          <input type="text" id="role" name="role" class="form-control" placeholder="e.g., Batsman, Bowler, All-rounder" required>
        </div>

        <div class="form-group required">
          <label for="matches">Matches Played</label>
          <input type="number" id="matches" name="matches" class="form-control" placeholder="Enter number of matches" min="0" required>
        </div>

        <div class="form-group required">
          <label for="runs">Total Runs</label>
          <input type="number" id="runs" name="runs" class="form-control" placeholder="Enter total runs scored" min="0" required>
        </div>

        <div class="form-group required">
          <label for="wickets">Total Wickets</label>
          <input type="number" id="wickets" name="wickets" class="form-control" placeholder="Enter total wickets taken" min="0" required>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <i>➕</i> Add Player
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