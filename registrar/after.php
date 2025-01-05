<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../backend/db_connect.php');

$id = $_SESSION['user_id'];

// Use prepared statements to fetch the department
$stmt = $conn->prepare('SELECT department FROM user WHERE user_id = ?');
$stmt->bind_param('i', $id); // Bind $id as an integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $department = $row['department'];
} else {
    die("No department found for user ID: $id");
}


// Use a prepared statement for the count query
$stmt = $conn->prepare("SELECT COUNT(*) AS total_pending 
                        FROM application_table 
                        WHERE after_ojt_status = 'PENDING'  AND after_ojt_steps = 2");

$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $afterpending = $row['total_pending'];
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_decline 
                        FROM application_table 
                        WHERE after_ojt_status = 'DECLINED'  AND after_ojt_steps = 2");

$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $afterdecline = $row['total_decline'];
}

$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_approve 
                        FROM application_table 
                        WHERE  after_ojt_steps > 2 ");

$stmt1->execute();
$result1 = $stmt1->get_result();

// Fetch the count
if ($result1->num_rows > 0) {
    $rows = $result1->fetch_assoc();
    $afterapprove = $rows['total_approve'];
}
//STEP 2
// Use a prepared statement for the count query
$stmt = $conn->prepare("SELECT COUNT(*) AS total_pending2 
                        FROM application_table 
                        WHERE after_ojt_status = 'PENDING'  AND after_ojt_steps = 3");

$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $afterpending2 = $row['total_pending2'];
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_decline2 
                        FROM application_table 
                        WHERE after_ojt_status = 'DECLINED'  AND after_ojt_steps = 3");

$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $afterdecline2 = $row['total_decline2'];
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_approve2 
                        FROM application_table 
                        WHERE  after_ojt_steps >= 4");

$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $afterapprove2 = $row['total_approve2'];
}

//STEP 3
// Use a prepared statement for the count query
$stmt = $conn->prepare("SELECT COUNT(*) AS total_pending3 
                        FROM application_table 
                        WHERE after_ojt_status = 'PENDING'  AND after_ojt_steps = 4");

$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $afterpending3 = $row['total_pending3'];
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_decline3 
                        FROM application_table 
                        WHERE after_ojt_status = 'DECLINED'  AND after_ojt_steps = 4");

$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $afterdecline3 = $row['total_decline3'];
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_approve3 
                        FROM application_table 
                        WHERE  after_ojt_steps >= 4 AND after_ojt_status='ACCEPTED'");

$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $afterapprove3 = $row['total_approve3'];
}


