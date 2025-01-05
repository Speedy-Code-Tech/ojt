<?php
session_start();
require_once('../../backend/db_connect.php');
$id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM application_table WHERE user_id = $id");
// Check if any rows are returned
if ($result->num_rows > 0) {
    header('Location: status.php');
} else {
    header('Location: form.php');

 }
?>