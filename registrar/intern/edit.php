<!DOCTYPE html>
<html lang="en">
<?php
require('../../backend/db_connect.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM user WHERE user_id = $id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $password = $row['password']; // Assuming the password is already hashed
        $type = $row['type'];
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "ID not found in URL.";
}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Edit User</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Sidebar -->
    <?php
     if(session_status()===PHP_SESSION_NONE) session_start();
    $_SESSION["page"] = "intern_accounts";
    include("../sidebar.php");
    ?>
    <!-- Main Content -->
    <div class="dashboard">
        <h2>EDIT USER</h2>
        <hr>
        <div class="container-fluid">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group mt-2">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Leave empty if you don't want to change the password">
                </div>
                <div class="form-group mt-2">
                    <label for="type">User Type:</label>
                    <input class="form-control" type="text" name="type" value="intern" readonly id="">
                </div>
                <button class="btn btn-success mt-3 px-4" style="position:absolute; right: 30px;"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
        </div>
    </div>

    <?php
     if(session_status()===PHP_SESSION_NONE) session_start();
    require('../../backend/db_connect.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_GET['id'];
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);

        // If password is not empty, hash it
        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT); // Hash the new password
            $sql = "UPDATE user SET email = '$email', password = '$password', type = '$type' WHERE user_id = $id";
        } else {
            // If password is empty, don't update the password
            $sql = "UPDATE user SET email = '$email', type = '$type' WHERE user_id = $id";
        }

        if (mysqli_query($conn, $sql)) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'User updated successfully!';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
        }
        header('Location: view.php'); // Redirect to view users page
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
