<?php
 if(session_status()===PHP_SESSION_NONE) session_start();
require('../../backend/db_connect.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM user WHERE user_id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $department = $row['department'];
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
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET email = '$email', password = '$hashed_password', department = '$department' WHERE user_id = $id";
    } else {
        $sql = "UPDATE user SET email = '$email', department = '$department' WHERE user_id = $id";
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

$departments = $conn->query("SELECT * FROM department");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Edit Dean</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
   
    <!-- Sidebar -->
    <?php
    $_SESSION["page"] = "dean_accounts";
    include("../sidebar.php");
    ?>
    <div class="dashboard">
        <h2>Edit Dean</h2>
        <hr>
        <div class="container-fluid">
            <form action="" method="post">
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
                <button type="submit" class="btn btn-success mt-3"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
        </div>
    </div>
</body>

</html>
