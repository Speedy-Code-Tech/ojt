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
    <!-- Sidebar -->
    <?php
    if(session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION["page"] = "view_intern";
    include("../sidebar.php");
    ?>
    <?php
    if(session_status() === PHP_SESSION_NONE) session_start();
    require('../../backend/db_connect.php');
    // Display success or error messages using SweetAlert
    if (isset($_SESSION['status'])) {
        $status = $_SESSION['status'];
        $message = $_SESSION['message'];

        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '$status',
                    title: '$message',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
        unset($_SESSION['status']);
        unset($_SESSION['message']);
    }

    // Get filter values from GET request
    $fromYear = isset($_GET['from_year']) ? $_GET['from_year'] : '';
    $toYear = isset($_GET['to_year']) ? $_GET['to_year'] : '';

    // Build SQL query with filtering
    $query = "SELECT * FROM application_table";
    if ($fromYear && $toYear) {
        $query .= " WHERE start_date BETWEEN '$fromYear-01-01' AND '$toYear-12-31'";
    }

    $result = $conn->query($query);
    ?>
    <!-- Main Content -->
    <div class="dashboard">
        <h2>VIEW INTERN HISTORY</h2>
        <hr>
        <div class="container-fluid">
            <h5>Filter By Academic Year</h5>
            <form action="" method="GET" class="d-flex container-fluid pt-2 pb-4">
                <div class="container d-flex gap-2 justify-content-center align-items-center">
                    <label for="">From:</label>
                    <select name="from_year" class="form-control">
                        <option value="2020" <?= $fromYear == '2020' ? 'selected' : '' ?>>2020</option>
                        <option value="2021" <?= $fromYear == '2021' ? 'selected' : '' ?>>2021</option>
                        <option value="2022" <?= $fromYear == '2022' ? 'selected' : '' ?>>2022</option>
                        <option value="2023" <?= $fromYear == '2023' ? 'selected' : '' ?>>2023</option>
                        <option value="2024" <?= $fromYear == '2024' ? 'selected' : '' ?>>2024</option>
                        <option value="2025" <?= $fromYear == '2025' ? 'selected' : '' ?>>2025</option>
                        <option value="2026" <?= $fromYear == '2026' ? 'selected' : '' ?>>2026</option>
                        <option value="2027" <?= $fromYear == '2027' ? 'selected' : '' ?>>2027</option>
                        <option value="2028" <?= $fromYear == '2028' ? 'selected' : '' ?>>2028</option>
                    </select>
                </div>
                <div class="container d-flex gap-2 justify-content-center align-items-center">
                    <label for="">To:</label>
                    <select name="to_year" class="form-control">
                        <option value="2020" <?= $toYear == '2020' ? 'selected' : '' ?>>2020</option>
                        <option value="2021" <?= $toYear == '2021' ? 'selected' : '' ?>>2021</option>
                        <option value="2022" <?= $toYear == '2022' ? 'selected' : '' ?>>2022</option>
                        <option value="2023" <?= $toYear == '2023' ? 'selected' : '' ?>>2023</option>
                        <option value="2024" <?= $toYear == '2024' ? 'selected' : '' ?>>2024</option>
                        <option value="2025" <?= $toYear == '2025' ? 'selected' : '' ?>>2025</option>
                        <option value="2026" <?= $toYear == '2026' ? 'selected' : '' ?>>2026</option>
                        <option value="2027" <?= $toYear == '2027' ? 'selected' : '' ?>>2027</option>
                        <option value="2028" <?= $toYear == '2028' ? 'selected' : '' ?>>2028</option>
                    </select>
                    <button class="btn btn-danger" type="submit">Filter</button>
                    <a href="view.php" class="btn btn-primary">Reset</a>
                </div>
            </form>
        </div>
        <table class="table table-hover table-striped" id="announcement">
            <thead>
                <tr>
                    <th>FullName</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Academic Year</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $no = 1;
                while ($r = $result->fetch_assoc()) { ?>
                   <tr>
                    <td><?= $r['pi_fname'].' '.$r['pi_mname'].' '.$r['pi_lname'] ?></td>
                    <td><?= $r['pi_email'] ?></td>
                    <td><?= $r['pi_contact'] ?></td>
                    <td><?= $r['start_date'].' - '.$r['end_date'] ?></td>
                   </tr>
                <?php }
            ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            $('#announcement').DataTable();
        });
    </script>
</body>

</html>
