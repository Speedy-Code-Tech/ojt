<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require('../../backend/db_connect.php');

// Initialize variables with defaults
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 0;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$searchValue = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

// Get the current year
$currentYear = date("Y");

// Build the base query for filtered records
$query = "SELECT * FROM requirement WHERE year = ?";
$params = [$currentYear];

// If there's a search term, add it to the query
if (!empty($searchValue)) {
    $query .= " AND name LIKE ?";
    $params[] = '%' . $searchValue . '%';
}

// Prepare the statement for counting filtered records
$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();
$totalFiltered = $result->num_rows;

// Add LIMIT clause for pagination
$query .= " LIMIT ?, ?";
$params[] = $start;
$params[] = $length;

// Prepare the statement for paginated records
$stmt = $conn->prepare(query: $query);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Fetch data
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        $row['id'],       // Replace with your actual column for "No."
        $row['name'],
        $row['year'],      // Replace with your actual column for "Requirement Name"
              // Replace with your actual column for "Requirement Name"
    ];
}

// Get the total number of records (without filtering)
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM requirement WHERE year = ?";
$stmt = $conn->prepare($totalRecordsQuery);
$stmt->bind_param('s', $currentYear);
$stmt->execute();
$result = $stmt->get_result();
$totalRecords = $result->fetch_assoc()['total'];
$laman="";
if($searchValue){
$res = $conn->query("SELECT * FROM requirement WHERE year LIKE '%$searchValue%'");
    $data = [];
    $laman = "Meron";
while ($row = $res->fetch_assoc()) {
    $laman = $laman . $row["name"];
    $data[] = [
        $row['id'],       // Replace with your actual column for "No."
        $row['name'],      // Replace with your actual column for "Requirement Name"
        $row['year'],      // Replace with your actual column for "Requirement Name"
    ];
}
}
// Prepare the JSON response
$response = [
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $data,
    "search"=>$searchValue,
    "test"=> $laman,
];

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
