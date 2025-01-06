<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Add Adviser</title>
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
    $errors = [];

    // Input validation
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $department = trim($_POST['department']);
    $program = trim($_POST['programs']);

    if (empty($fname)) $errors['fname'] = "First Name is required.";
    if (empty($lname)) $errors['lname'] = "Last Name is required.";
    if (empty($email)) $errors['email'] = "Email is required.";
    elseif (!preg_match('/@lsu\.edu\.ph$/', $email)) $errors['email'] = "Email must end with @lsu.edu.ph.";
    if (empty($password)) $errors['password'] = "Password is required.";
    if (empty($department)) $errors['department'] = "Department is required.";
    if (empty($program)) $errors['program'] = "Program is required.";

    if (empty($errors)) {
        $email = mysqli_real_escape_string($conn, $email);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $type = 'adviser';

        // Check if the email already exists
        $email_check_query = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $email_check_query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['email_error'] = 'Email is already taken!';
            header('Location: add.php');
            exit;
        }

        // Insert into the database
        $sql = "INSERT INTO user  email, password, type, department, program,fname, mname, lname) 
                VALUES ( '$email', '$hashed_password', '$type', '$department', '$program''$fname', '$mname', '$lname')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Adviser added successfully!';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
        }

        header('Location: view.php');
        exit;
    } else {
        $_SESSION['errors'] = $errors;
    }
}

$result1 = $conn->query("SELECT * FROM department");
$results2 = $conn->query("SELECT * FROM programs");
?>

<body>
    <?php
    $_SESSION["page"] = "heads_accounts";
    include("../sidebar.php");
    ?>
    <div class="dashboard">
        <h2>ADD NEW ADVISER</h2>
        <hr>
        <div class="container-fluid">
            <form action="#" method="post" id="add-adviser-form">
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" name="fname" class="form-control" id="fname" value="<?= htmlspecialchars($_POST['fname'] ?? '') ?>" required>
                    <?php if (isset($_SESSION['errors']['fname'])) echo '<span class="text-danger">' . $_SESSION['errors']['fname'] . '</span>'; ?>
                </div>
                <div class="mb-3">
                    <label for="mname" class="form-label">Middle Name</label>
                    <input type="text" name="mname" class="form-control" id="mname" value="<?= htmlspecialchars($_POST['mname'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" name="lname" class="form-control" id="lname" value="<?= htmlspecialchars($_POST['lname'] ?? '') ?>" required>
                    <?php if (isset($_SESSION['errors']['lname'])) echo '<span class="text-danger">' . $_SESSION['errors']['lname'] . '</span>'; ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    <?php if (isset($_SESSION['errors']['email'])) echo '<span class="text-danger">' . $_SESSION['errors']['email'] . '</span>'; ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" class="form-select" id="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <?php while ($row = $result1->fetch_assoc()) echo '<option value="' . htmlspecialchars($row['dept']) . '">' . htmlspecialchars($row['dept']) . '</option>'; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="programs" class="form-label">Program</label>
                    <select name="programs" class="form-select" id="programs" required>
                        <option value="" disabled selected>Select Program</option>
                        <?php while ($row = $results2->fetch_assoc()) echo '<option value="' . htmlspecialchars($row['programs']) . '">' . htmlspecialchars($row['programs']) . '</option>'; ?>
                    </select>
                </div>
                <button class="btn btn-success mt-2 px-4" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('add-adviser-form').addEventListener('submit', function (e) {
            const email = document.getElementById('email').value;
            if (!email.endsWith('@lsu.edu.ph')) {
                e.preventDefault();
                alert('Email must end with @lsu.edu.ph');
            }
        });
    </script>
</body>

</html>
