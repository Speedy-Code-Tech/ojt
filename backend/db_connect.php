<?php
// Database connection parameters
$host = 'localhost';       // Database host
$username = 'root'; // Database username
$password = ''; // Database password
$database = 'ojt'; // Database name

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

return $conn;
?>
