<?php
include 'db_connect.php';

$id = $_GET['id'];
$conn->query("DELETE FROM players WHERE id=$id");

header("Location: index.php");
exit;
?>
