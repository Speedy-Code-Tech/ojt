<?php
 if(session_status()===PHP_SESSION_NONE) session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Add Program Head</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<?php
require('../../backend/db_connect.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $program = mysqli_real_escape_string($conn, $_POST['programs']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password
    $type = 'heads'; // Default user type for admin

    // Insert query
    $sql = "INSERT INTO user (email, password, type,department,program) VALUES ('$email', '$hashed_password', '$type','$department','$program')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Program Head added successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
    }

    header('Location: view.php'); // Redirect to the admin accounts view page
    exit;
}
$result12 = $conn->query("SELECT * FROM department");
$results = $conn->query("SELECT * FROM programs");

?>

<body>
    <!-- Sidebar -->
    <?php
     if(session_status()===PHP_SESSION_NONE) session_start();
    $_SESSION["page"] = "heads_accounts";
    include("../sidebar.php");
    ?>
    <!-- Main Content -->
    <div class="dashboard">
        <h2>ADD NEW PROGRAM HEAD</h2>
        <hr>
        <div class="container-fluid">
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" class="form-select" id="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <?php
                        while ($row = $result12->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['dept']) . '">' . htmlspecialchars($row['dept']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="programs" class="form-label">Program</label>
                    <select name="programs" class="form-select" id="programs" required>
                        <option value="" disabled selected>Select Program</option>
                        <?php
                        while ($row = $results->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['programs']) . '">' . htmlspecialchars($row['programs']) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <button class="btn btn-success mt-2 px-4" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>