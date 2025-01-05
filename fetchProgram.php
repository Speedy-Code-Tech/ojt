<?php
require_once("backend/db_connect.php");

if (isset($_POST['department'])) {
    header('Content-Type: application/json');

    $department_id = "%" . $_POST['department'] . "%"; // Add wildcards for partial match
    $stmt = $conn->prepare("SELECT * FROM programs WHERE department LIKE ?");
    $stmt->bind_param("s", $department_id); // Use "s" for string
    $stmt->execute();
    $result = $stmt->get_result();

    $programs = [];
    while ($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }

    echo json_encode($programs);
}
?>
