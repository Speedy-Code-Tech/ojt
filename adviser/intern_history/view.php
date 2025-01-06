<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    require_once('../../backend/db_connect.php');
    session_start();
    $id = $_SESSION['user_id'] ?? null;

    // Retrieve user details
    $userQuery = $conn->prepare("SELECT department, program FROM user WHERE user_id = ?");
    $userQuery->bind_param("i", $id);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
    $user = $userResult->fetch_assoc();
    $data = $user['department'] ?? '';
    $prog = $user['program'] ?? '';

    // Count pending applications
    $pendingCount = $conn->query("SELECT COUNT(*) AS count FROM application_table WHERE application_status = 'PENDING' AND application_step = 1 AND pi_dept = '$data' AND pi_course = '$prog'")->fetch_assoc()['count'] ?? 0;
    $afterOJTCount = $conn->query("SELECT COUNT(*) AS count FROM application_table WHERE after_ojt_status = 'PENDING' AND after_ojt_steps = 3 AND pi_dept = '$data' AND pi_course = '$prog'")->fetch_assoc()['count'] ?? 0;

    // Handle filtering
    $fromYear = $_GET['from_year'] ?? '';
    $toYear = $_GET['to_year'] ?? '';
    $query = "SELECT * FROM application_table WHERE pi_dept = '$data' AND pi_course = '$prog'";
    if ($fromYear && $toYear) {
        if ($fromYear === $toYear) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Filter',
                        text: 'The selected years must be different.',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        } else {
            $query = "SELECT * FROM application_table WHERE start_date BETWEEN '$fromYear-01-01' AND '$toYear-12-31' AND pi_dept = '$data' AND  pi_course = '$prog'";
        }
    }
    $result = $conn->query($query);

    // Display success or error messages
    if (isset($_SESSION['status'])) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{$_SESSION['status']}',
                    title: '{$_SESSION['message']}',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
        unset($_SESSION['status'], $_SESSION['message']);
    }
    ?>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="../dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="../view.php"><i class="fa-solid fa-paperclip"></i> Before OJT Step 5 <span class="badge bg-danger"><?= $pendingCount ?></span></a>
        <a href="../after.php"><i class="fa-solid fa-paperclip"></i> After OJT Step 2 <span class="badge bg-danger"><?= $afterOJTCount ?></span></a>
        <a href="#" class="active"><i class="fa-solid fa-users"></i> Managed Interns</a>
        <a href="../history/view.php"><i class="fa-solid fa-users"></i> Awaiting Review</a>
        <a href="../../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">
        <h2>Managed Interns</h2>
        <hr>
        <!-- <div class="container-fluid">
            <h5>Filter By Academic Year</h5>
            <form action="" method="GET" class="d-flex container-fluid pt-2 pb-4">
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <label for="from_year">From:</label>
                    <select name="from_year" class="form-control">
                        <?php for ($year = 2020; $year <= 2028; $year++): ?>
                            <option value="<?= $year ?>" <?= $fromYear == $year ? 'selected' : '' ?>><?= $year ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <label for="to_year">To:</label>
                    <select name="to_year" class="form-control">
                        <?php for ($year = 2020; $year <= 2028; $year++): ?>
                            <option value="<?= $year ?>" <?= $toYear == $year ? 'selected' : '' ?>><?= $year ?></option>
                        <?php endfor; ?>
                    </select>
                    <button class="btn btn-danger" type="submit">Filter</button>
                    <a href="view.php" class="btn btn-primary">Reset</a>
                </div>
            </form>
        </div> -->
        <table class="table table-hover table-striped" id="announcement">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= "{$row['pi_fname']} {$row['pi_mname']} {$row['pi_lname']}" ?></td>
                        <td><?= $row['pi_email'] ?></td>
                        <td><?= $row['pi_contact'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#announcement').DataTable();
        });
    </script>
</body>

</html>
