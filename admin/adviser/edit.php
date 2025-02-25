<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require('../../backend/db_connect.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM user WHERE user_id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $department = $row['department'];
        $program = $row['program'];
        $fname = $row['fname'];
        $mname = $row['mname'];
        $lname = $row['lname'];
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "ID not found in URL.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $programs = mysqli_real_escape_string($conn, $_POST['programs']);

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET email = '$email', password = '$hashed_password', department = '$department', program = '$programs',fname = '$fname',mname = '$mname',lname = '$lname' WHERE user_id = $id";
    } else {
        $sql = "UPDATE user SET email = '$email', department = '$department', program = '$programs',fname = '$fname',mname = '$mname',lname = '$lname' WHERE user_id = $id";
    }

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'User updated successfully!';
        header('Location: view.php');
        exit;
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
    }
}

// Fetch departments
$departments = $conn->query("SELECT * FROM department");

// Fetch programs
$programList = $conn->query("SELECT * FROM programs");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Edit Program HEAD</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Sidebar -->
    <?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION["page"] = "heads_accounts";
    include("../sidebar.php");
    ?>
    <div class="dashboard">
        <h2>Edit Dean</h2>
        <hr>
        <div class="container-fluid">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" placeholder="Maria" name="fname" class="form-control" value="<?= htmlspecialchars($fname); ?>" id="fname" required>
                    <?php
                    if (isset($_SESSION['fname'])) {
                        echo '<span class="text-danger">' . $_SESSION['fname'] . '</span>';
                        unset($_SESSION['fname']);
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="mname" class="form-label">Middle Name</label>
                    <input type="text" placeholder="Optional" name="mname" class="form-control" id="mname" value="<?= htmlspecialchars($mname); ?>" required>
                    <?php
                    if (isset($_SESSION['mname'])) {
                        echo '<span class="text-danger">' . $_SESSION['mname'] . '</span>';
                        unset($_SESSION['mname']);
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" placeholder="Dela Cruz" value="<?= htmlspecialchars($lname); ?>" name="lname" class="form-control" id="lname" required>
                    <?php
                    if (isset($_SESSION['lname'])) {
                        echo '<span class="text-danger">' . $_SESSION['lname'] . '</span>';
                        unset($_SESSION['lname']);
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($email); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Leave blank to keep current password">
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" class="form-select" id="department" required>
                        <option value="" disabled>Select Department</option>
                        <?php while ($dept = $departments->fetch_assoc()) { ?>
                            <option value="<?= htmlspecialchars($dept['dept']); ?>" <?= $department === $dept['dept'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($dept['dept']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="programs" class="form-label">Program</label>
                    <select name="programs" class="form-select" id="programs" required>
                        <option value="" disabled>Select Program</option>
                        <?php while ($prog = $programList->fetch_assoc()) { ?>
                            <option value="<?= htmlspecialchars($prog['programs']); ?>" <?= $program === $prog['programs'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($prog['programs']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success mt-3"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
        </div>
    </div>
</body>

</html>