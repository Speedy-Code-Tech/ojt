<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Intern Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="../../assets/css/form.css">
    <link rel="stylesheet" href="../../assets/css/status.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<?php
session_start();
require_once("../../backend/db_connect.php");
// Query to get the latest announcement from the database

$id = $_SESSION['user_id'];
$query = "SELECT * FROM application_table WHERE user_id = $id";
$result = mysqli_query($conn, $query);

// Check if there is a result
if ($result && mysqli_num_rows($result) > 0) {
    $application = mysqli_fetch_array($result);
    $step = $application["application_step"];

    $data = true;
} else {
    $data = false;
}
$result = $conn->query("SELECT * FROM department");
$results = $conn->query("SELECT * FROM programs");
$r = $conn->query('SELECT * FROM requirement');
// Assume $id is retrieved safely and sanitized
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $id); // 'i' indicates an integer type
$stmt->execute();
$result1 = $stmt->get_result();

if ($result1->num_rows > 0) {
    $email = $result1->fetch_assoc(); // Fetch the user data as an associative array
    // Access the email, for example:
    // echo $email['email']; // Assuming the email column exists
} else {
    echo "No user found with the given ID.";
}

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
?>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="../dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="../application/redirect.php" ><i class="fa-solid fa-boxes-stacked"></i> Application Status</a>
        <a href="#" class="ms-3 ps-0 active"><i class="fa-solid fa-boxes-stacked"></i> After OJT</a>

        <a href="../../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">

        <div class="container-fluid">

            <div class="main-content container-fluid d-flex justify-content-center align-items-center">
            <?php  if ($step == 5 && $application['application_status'] == 'ACCEPTED' && $application['after_ojt_steps']==1 && ($application['after_ojt_status'] == 'PENDING'|| !$application['after_ojt_status'])) { ?>
    
            <div class="accepted-message-step-1 card">
                    <div class="progress-area">
                        <div class="progress-wrapper">
                            <div class="progress-circle">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <a href="#">Step 1</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <a href="#">Step 2</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <a href="#">Step 3</a>
                        </div>

                    </div>
                    <div class="content-area">
                        <i class="fa-solid fa-check big-icon check-icon"></i>
                        <h6>Once you're finished with your OJT, and completed all requirements. Submit after OJT requirements to proceed to Step 2. Please click <span style="color: rgb(99, 226, 99)"><a href="step1form.php">here</a></span>.</h6>
                    </div>
                </div>
                <?php } else if ($application['after_ojt_steps']==2 && $application['after_ojt_status'] == 'PENDING') { ?>

                <div class="pending-message-step-1 card">
                    <div class="progress-area">
                        <div class="progress-wrapper">
                            <div class="progress-circle pending-active">
                                <i class="fa-solid fa-hourglass-start"></i>
                            </div>
                            <a href="#">Step 1</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <a href="#">Step 2</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <a href="#">Step 3</a>
                        </div>
                    </div>
                    <div class="content-area">
                        <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                        <h6>Your submitted form for step 1 is now being process for verification. While your form has not yet been confirmed, you may still make changes by clicking <span style="color: rgb(99, 226, 99)"><a href="step1form.php">here.</a></span></h6>
                    </div>
                </div>
                <?php } else if ($application['after_ojt_steps']==2 && $application['after_ojt_status'] == 'DECLINED') { ?>


                <div class="declined-message-step-1 card">
                    <div class="progress-area">
                        <div class="progress-wrapper">
                            <div class="progress-circle deny-active">
                                <i class="fa-solid fa-x"></i>
                            </div>
                            <a href="#">Step 1</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <a href="#">Step 2</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <a href="#">Step 3</a>
                        </div>

                    </div>
                    <div class="content-area">
                        <i class="fa-solid fa-x big-icon deny-icon"></i>
                        <h6>The form you've submitted for step 1 has been denied. Click <span style="color: rgb(99, 226, 99)"><a data-toggle="modal" data-target="#deniedModal">here</a></span> to view the following reason. To resumit please click <span style="color: rgb(99, 226, 99)"><a href="after-ojt-submit-application-step-2.html">here</a></span>.</h6>
                    </div>
                </div>
                <?php } else if ($application['after_ojt_steps']==3 && $application['after_ojt_status'] == 'PENDING') {?>


                <div class="pending-message-step-2 card">
                    <div class="progress-area">

                        <div class="progress-wrapper">
                            <div class="progress-circle success-active">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <a href="#">Step 1</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle pending-active">
                                <i class="fa-solid fa-hourglass-start"></i>
                            </div>
                            <a href="#">Step 2</a>
                        </div>

                        <div class="progress-wrapper">
                            <div class="progress-circle">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <a href="#">Step 3</a>
                        </div>

                    </div>
                    <div class="content-area">
                        <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                        <h6>Your submitted form for step 1 has been verified. Please wait for the approval of Adviser to proceed to step 3.</h6>
                    </div>


                </div>
                <?php } else if ($application['after_ojt_steps']==4 && $application['after_ojt_status'] == 'PENDING') {?>

                <div class="accepted-message-step-2 card">
                    <div class="progress-area">

                        <div class="progress-wrapper">
                            <div class="progress-circle success-active">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <a href="#">Step 1</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle success-active">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <a href="#">Step 2</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle pending-active">
                                <i class="fa-solid fa-hourglass-start"></i>
                            </div>
                            <a href="#">Step 3</a>
                        </div>

                    </div>
                    <div class="content-area">
                        <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                        <h6>Your application for step 2 has been verified. Please wait for the approval of the Registrar.</h6>
                    </div>

                </div>
                <?php } else if ($application['after_ojt_steps']==4 && $application['after_ojt_status'] == 'ACCEPTED') {?>


                <div class="accepted-message-step-3 card">
                    <div class="progress-area">

                        <div class="progress-wrapper">
                            <div class="progress-circle success-active">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <a href="#">Step 1</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle success-active">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <a href="#">Step 2</a>
                        </div>
                        <div class="progress-wrapper">
                            <div class="progress-circle success-active">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <a href="#">Step 3</a>
                        </div>

                    </div>
                    <div class="content-area">

                        <i class="fa-solid fa-door-open big-icon welcome-icon"></i>
                        <h6>You are now approved by the registrar. You are now completed all requirements.</h6>
                    </div>
                </div> 
                <?php } ?>


                <!-- Modal -->
                <div class="modal fade" id="deniedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Feedback for application</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body decline-message">
                                <!--  <p class="decline-message-text"></p> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Understood</button>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

</body>

</html>