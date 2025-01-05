<?php
session_start();
require_once('../backend/db_connect.php');

$id = $_SESSION['user_id'];

// Use prepared statements to fetch the department
$stmt = $conn->prepare('SELECT * FROM user WHERE user_id = ?');
$stmt->bind_param('i', $id); // Bind $id as an integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $department = $row['department'];
    $program = $row['program'];
    
} else {
    die("No department found for user ID: $id");
}


// Use a prepared statement for the count query
$stmt = $conn->prepare("SELECT COUNT(*) AS total_pending 
                        FROM application_table 
                        WHERE application_status = 'PENDING' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 0");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending = $row['total_pending'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_decline 
                        FROM application_table 
                        WHERE application_status = 'DECLINED' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 0");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $decline = $row['total_decline'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_approve 
                        FROM application_table 
                        WHERE pi_dept = ? AND pi_course = '$program'  AND application_step >= 1 ");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $approve = $row['total_approve'];
}

//STEP 2
// Use a prepared statement for the count query
$stmt = $conn->prepare("SELECT COUNT(*) AS total_pending2 
                        FROM application_table 
                        WHERE application_status = 'PENDING' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 1");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending2 = $row['total_pending2'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_decline2 
                        FROM application_table 
                        WHERE application_status = 'DECLINED' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 2");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $decline2 = $row['total_decline2'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_approve2 
                        FROM application_table 
                        WHERE pi_dept = ? AND pi_course = '$program'  AND application_step >= 2");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $approve2 = $row['total_approve2'];
}

//STEP 3
// Use a prepared statement for the count query
$stmt = $conn->prepare("SELECT COUNT(*) AS total_pending3 
                        FROM application_table 
                        WHERE application_status = 'PENDING' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 2");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending3 = $row['total_pending3'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_decline3 
                        FROM application_table 
                        WHERE application_status = 'DECLINED' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 3");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $decline3 = $row['total_decline3'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_approve3 
                        FROM application_table 
                        WHERE pi_dept = ? AND pi_course = '$program'  AND application_step >= 3");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $approve3 = $row['total_approve3'];
}

//STEP 4
// Use a prepared statement for the count query
$stmt = $conn->prepare("SELECT COUNT(*) AS total_pending4
                        FROM application_table 
                        WHERE application_status = 'PENDING' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 3");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending4 = $row['total_pending4'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_decline4
                        FROM application_table 
                        WHERE application_status = 'DECLINED' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 4");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $decline4 = $row['total_decline4'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_approve4 
                        FROM application_table 
                        WHERE pi_dept = ? AND pi_course = '$program'  AND application_step >= 4");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $approve4 = $row['total_approve4'];
}

//STEP 5
// Use a prepared statement for the count query
$stmt = $conn->prepare("SELECT COUNT(*) AS total_pending5
                        FROM application_table 
                        WHERE application_status = 'PENDING' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 5");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending5 = $row['total_pending5'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_decline5
                        FROM application_table 
                        WHERE application_status = 'DECLINED' AND pi_dept = ? AND pi_course = '$program'  AND application_step = 5");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $decline5 = $row['total_decline5'];
    
}

$stmt = $conn->prepare("SELECT COUNT(*) AS total_approve5 
                        FROM application_table 
                        WHERE pi_dept = ? AND pi_course = '$program'  AND application_step >= 5 AND application_status='ACCEPTED'");
$stmt->bind_param('s', $department); // Bind $department as a string
$stmt->execute();
$result = $stmt->get_result();

// Fetch the count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $approve5 = $row['total_approve5'];
}


?>
