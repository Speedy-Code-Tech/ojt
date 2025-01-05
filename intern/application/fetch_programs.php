<?php
require_once("../../backend/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dept'])) {
    $dept = $conn->real_escape_string($_POST['dept']);
    $query = "SELECT programs FROM programs WHERE department = '$dept'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row['programs']) . '">' . htmlspecialchars($row['programs']) . '</option>';
        }
    } else {
        echo '<option value="" disabled>No programs available</option>';
    }
}
?>
