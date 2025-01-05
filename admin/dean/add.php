<?php
 if(session_status()===PHP_SESSION_NONE) session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Add Dean</title>
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
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password
    $type = 'dean'; // Default user type for admin

    if (!preg_match('/@lsu\.edu\.ph$/', $email)) {
        $_SESSION['email_error'] = 'Email must end with @lsu.edu.ph!';
        header('Location: add.php'); // Redirect back to the add admin page
        exit;
    }

    // Check if the email already exists
    $email_check_query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $email_check_query);
    
    if (mysqli_num_rows($result) > 0) {
        // Email already exists
        $_SESSION['email_error'] = 'Email is already taken!';
        header('Location: add.php'); // Redirect back to the add admin page
        exit;
    }

    // Insert query
    $sql = "INSERT INTO user (email, password, type,department) VALUES ('$email', '$hashed_password', '$type','$department')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Dean added successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
    }

    header('Location: view.php'); // Redirect to the admin accounts view page
    exit;
}
$result = $conn->query("SELECT * FROM department");

?>

<body>
    <!-- Sidebar -->
    <?php
    $_SESSION["page"] = "dean_accounts";
    include("../sidebar.php");
    ?>

    <!-- Main Content -->
    <div class="dashboard">
        <h2>ADD NEW DEAN</h2>
        <hr>
        <div class="container-fluid">
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <?php
                    if (isset($_SESSION['email_error'])) {
                        echo '<span class="text-danger">' . $_SESSION['email_error'] . '</span>';
                        unset($_SESSION['email_error']);
                    }
                    ?>
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
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['dept']) . '">' . htmlspecialchars($row['dept']) . '</option>';
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