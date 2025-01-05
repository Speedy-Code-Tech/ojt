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
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION["page"] = "history";
    include("../sidebar.php");
    ?>
    <?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    require('../../backend/db_connect.php');
    
    // Query for all records except those that are declined
    $rejected = $conn->query("SELECT * FROM application_table WHERE application_status='DECLINED' || after_ojt_status='DECLINED'");
    $all = $conn->query("SELECT * FROM application_table WHERE application_status != 'DECLINED' AND after_ojt_status != 'DECLINED'");

    // Fetch programs and departments for dropdown filters
    $programs = $conn->query("SELECT DISTINCT pi_course FROM application_table");
    $departments = $conn->query("SELECT DISTINCT pi_dept FROM application_table");
    ?>
    <!-- Main Content -->
    <div class="dashboard">
        <h2>VIEW HISTORY</h2>
        <hr>

        <!-- Filter for Approved/Pending Interns -->
        <h5>Filter by Program and Department (Approved/Pending Interns)</h5>
        <form method="GET" class="d-flex gap-3 py-4">
            <div class="d-flex gap-2 align-items-center">
                <label for="program">Program:</label>
                <select name="program" id="program" class="form-control">
                    <option value="">All Programs</option>
                    <?php while ($program = $programs->fetch_assoc()) { ?>
                        <option value="<?= $program['pi_course'] ?>" <?= isset($_GET['program']) && $_GET['program'] == $program['pi_course'] ? 'selected' : '' ?>><?= $program['pi_course'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <label for="department">Department:</label>
                <select name="department" id="department" class="form-control">
                    <option value="">All Departments</option>
                    <?php while ($department = $departments->fetch_assoc()) { ?>
                        <option value="<?= $department['pi_dept'] ?>" <?= isset($_GET['department']) && $_GET['department'] == $department['pi_dept'] ? 'selected' : '' ?>><?= $department['pi_dept'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <button class="btn btn-danger" type="submit">Filter</button>
            <a href="view.php" class="btn btn-primary">Reset</a>
        </form>

        <!-- Approved/Pending Interns Table -->
        <h5>Approved/Pending Interns</h5>
        <table class="table table-hover table-striped" id="announcement">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Program</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $program_filter = isset($_GET['program']) ? " AND pi_course = '{$_GET['program']}'" : '';
                $department_filter = isset($_GET['department']) ? " AND pi_dept = '{$_GET['department']}'" : '';
                $all = $conn->query("SELECT * FROM application_table WHERE application_status != 'DECLINED' AND after_ojt_status != 'DECLINED' $program_filter $department_filter");
                
                while ($r = $all->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $r['user_id'] ?></td>
                        <td><?= $r['pi_fname'] . ' ' . $r['pi_mname'] . ' ' . $r['pi_lname'] ?></td>
                        <td><?= $r['pi_dept'] ?></td>
                        <td><?= $r['pi_course'] ?></td>
                        <td class="fw-bold text-center">
                            <?php if ($r['application_status'] == 'ACCEPTED' && $r['after_ojt_status'] == 'PENDING') {
                                echo "<span class='text-warning'>PENDING ON AFTER OJT</span>";
                            } else if ($r['application_status'] == 'PENDING' && $r['after_ojt_status'] == 'ACCEPTED') {
                                echo "<span class='text-warning'>PENDING ON BEFORE OJT</span>";
                            } else if ($r['application_status'] == 'ACCEPTED' && $r['after_ojt_status'] == 'ACCEPTED') {
                                echo "<span class='text-success'>COMPLETED</span>";
                            } else if (!$r['application_status'] || $r['application_status'] == 'PENDING' || !$r['after_ojt_status']) {
                                echo "<span class='text-warning'>PENDING</span>";
                            }
                            ?>
                        </td>
                        <td>
                            <a href="pending.php?id=<?=$r['application_id'];?>" class="btn btn-primary">View Details</a>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>

        <br><br><hr>

        <!-- Filter for Rejected Interns -->
        <h5>Filter by Program and Department (Rejected Interns)</h5>
        <form method="GET" class="d-flex gap-3 py-4">
            <div class="container-fluid d-flex gap-2 align-items-center">
                <label for="program">Program:</label>
                <select name="program" id="program" class="form-control">
                    <option value="">All Programs</option>
                    <?php while ($program = $programs->fetch_assoc()) { ?>
                        <option value="<?= $program['pi_course'] ?>" <?= isset($_GET['program']) && $_GET['program'] == $program['pi_course'] ? 'selected' : '' ?>><?= $program['pi_course'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="container-fluid d-flex gap-2 align-items-center">
                <label for="department">Department:</label>
                <select name="department" id="department" class="form-control">
                    <option value="">All Departments</option>
                    <?php while ($department = $departments->fetch_assoc()) { ?>
                        <option value="<?= $department['pi_dept'] ?>" <?= isset($_GET['department']) && $_GET['department'] == $department['pi_dept'] ? 'selected' : '' ?>><?= $department['pi_dept'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <button class="btn btn-danger" type="submit">Filter</button>
            <a href="view.php" class="btn btn-primary">Reset</a>
        </form>

        <!-- Rejected Interns Table -->
        <h5>Rejected Interns</h5>
        <table class="table table-hover table-striped" id="reject">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Program</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Apply the same filters for rejected interns
                $rejected = $conn->query("SELECT * FROM application_table WHERE application_status='DECLINED' || after_ojt_status='DECLINED' $program_filter $department_filter");
                
                while ($r = $rejected->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $r['user_id'] ?></td>
                        <td><?= $r['pi_fname'] . ' ' . $r['pi_mname'] . ' ' . $r['pi_lname'] ?></td>
                        <td><?= $r['pi_dept'] ?></td>
                        <td><?= $r['pi_course'] ?></td>
                        <td class="text-danger fw-bold">Rejected</td>
                        <td>
                            <a href="" class="btn btn-warning">View Details</a>
                        </td>
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
            $('#reject').DataTable();
        });
    </script>
</body>

</html>
