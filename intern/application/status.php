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
$query = "SELECT * FROM application_table WHERE user_id = $id";
$result12 = mysqli_query($conn, $query);
$steps  = 0;
$status  = "";
if ($result12 && mysqli_num_rows($result12) > 0) {
    while ($row = mysqli_fetch_assoc($result12)) {
        $steps = $row['application_step'];
        $status = $row['application_status'];
    }
}
?>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="../dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="#" class="active"><i class="fa-solid fa-boxes-stacked"></i> Application Status</a>
        <a href="../after/status.php" class="ms-3 <?= ($steps == 5 && $status == 'ACCEPTED') ? 'd-block' : 'd-none' ?> ps-0"><i class="fa-solid fa-boxes-stacked"></i> After OJT</a>

        <a href="../../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">

        <div class="container-fluid">
            <div class="main-content container-fluid d-flex justify-content-center align-items-center">

                <?php if ($step == 0 && $application['application_status'] == 'PENDING' && $application) { ?>
                    <div class="pending-message-step-intern-info card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle pending-active">
                                    <i class="fa-solid fa-hourglass-start"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
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
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                            <h6>Your submitted form for your Personal Information is currently being process for verification. While your form has not yet been confirmed, you may still make changes by clicking <span style="color: rgb(99, 226, 99)"><a href="edit.php">here.</a></span></h6>
                        </div>


                    </div>

                <?php } else if ($step == 0 && $application['application_status'] == 'DECLINED' && $application) { ?>

                    <div class="declined-message-step-intern-info card">

                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle deny-active">
                                    <i class="fa-solid fa-x"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
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
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <h6>
                            The form you've submitted for your personal Info has been denied.
                            To resubmit, please click <span style="color: rgb(99, 226, 99)">
                                <a href="step1.php?id=<?= $application['application_id'] ?>&step=0">here</a>
                            </span>.
                        </h6>




                    </div>
                <?php } else if ($step == 1 && $application['application_status'] == 'PENDING' && $application) { ?>

                    <div class="pending-message-step-1 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                            <h6>Please wait patiently for the approval of the Program Head, Thank you.</a></span></h6>
                        </div>

                        <div id="modal_edit_form_step_1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>Edit document Link for Step 1</h3>
                                        <button type="button" class="close btn float-end" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa-solid fa-x"></i></span>
                                        </button>
                                    </div>
                                    <form class="form" id="edit_form_step_1">
                                        <input class="form-input" type="hidden" name="user_id" id="user_id_step_1" required="required">

                                        <div class="form-wrap">
                                            <input class="form-input" type="text" name="ac_check_list_glink" id="ac_check_list_glink" required="required">
                                            <span>Academic Checklist form G-drive Link</span>
                                        </div>
                                        <div class="btn-area">
                                            <button class="resubmit-btn re-info-btn" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php } else if ($step == 1 && $application['application_status'] == 'ACCEPTED' && $application) { ?>

                    <div class="accepted-message-step-1 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Step 1</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <a href="#">Step 2</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 3</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-check big-icon check-icon"></i>
                            <h6>Your submitted form for step 1 has been verified; to proceed to step 2, please click <span style="color: rgb(99, 226, 99)"><a href="submit-application-step-2.html">here</a></span>.</h6>
                        </div>
                    </div>
                <?php } else if ($step == 1 && $application['application_status'] == 'DECLINED' && $application) { ?>

                    <div class="declined-message-step-1 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle deny-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Step 1</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <a href="#">Step 2</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 3</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-x big-icon deny-icon"></i>
                            <h6>The form you've submitted for step 1 has been denied. To resubmit please click <span style="color: rgb(99, 226, 99)"><a href="step1.php?id=<?= $application['application_id'] ?>&step=1">here</a></span>.</h6>
                        </div>

                        <div id="resubmit_modal_step_1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3></h3>
                                        <button type="button" class="close btn float-end" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa-solid fa-x"></i></span>
                                        </button>
                                    </div>
                                    <form class="form" id="resubmit_form_step1">
                                        <div class="heading-area">
                                            <h3>Resumit the following Gdrive-links</h3>
                                        </div>
                                        <input class="form-input" type="hidden" name="user_id" id="user_id_step_denied_1" required="required">

                                        <div class="form-wrap">
                                            <input class="form-input" type="text" name="ac_check_list_glink" required="required">
                                            <span>Academic Check List Form G-drive Link</span>
                                        </div>

                                        <div class="btn-area">
                                            <button class="resubmit-btn rebtn-1" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                <?php } else if ($step == 2 && $application['application_status'] == 'PENDING' && $application) { ?>
                    <div class="pending-message-step-2 card">

                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                            <h6>Your submitted form for step 2 is now being process for verification. While your form has not yet been confirmed, you may still make changes by clicking <span style="color: rgb(99, 226, 99)"><a href="" data-toggle="modal" data-target="#exampleModal2">here.</a></span></h6>
                        </div>

                        <div id="exampleModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3></h3>
                                        <button type="button" class="close btn float-end" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa-solid fa-x"></i></span>
                                        </button>
                                    </div>

                                    <form class="form" method="post" id="edit_form_step2">
                                        <div class="heading-area">
                                            <h3>Edit</h3>
                                        </div>
                                        <input class="form-input" type="hidden" name="user_id" id="user_id_step_2" required="required">
                                        <section id="requirements_container" class="d-flex flex-column">
                                            <table>
                                                <?php
                                                $no = 0;
                                                while ($row = mysqli_fetch_assoc($r)) {
                                                    $no++;
                                                    echo '
                                                        <tr>
                                                            <td class="fw-bold">' . $no . '. ' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</td>
                                                        </tr>
                                                        ';
                                                }
                                                ?>
                                            </table>



                                        </section>
                                        <div class="form-wrap form-wrap-glink">
                                            <input class="form-input" type="text" name="step2_docs_link" id="step2_docs_link" required="required">
                                            <span>G-Link folder of the required documents</span>
                                        </div>
                                        <div class="btn-area">
                                            <button class="save-changes-btn-2" type="submit">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php } else if ($step == 2 && $application['application_status'] == 'ACCEPTED' && $application) { ?>

                    <div class="accepted-message-step-2 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 3</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-check big-icon check-icon"></i>
                            <h6>Your submitted form for step 2 has been verified; to proceed to step 3, please click <span style="color: rgb(99, 226, 99)"><a href="submit-application-step-3.html">here</a></span>.</h6>
                        </div>
                    </div>
                <?php } else if ($step == 2 && $application['application_status'] == 'DECLINED' && $application) { ?>

                    <div class="declined-message-step-2 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Step 1</a>
                            </div>

                            <div class="progress-wrapper">
                                <div class="progress-circle deny-active">
                                    <i class="fa-solid fa-x"></i>
                                </div>
                                <a href="#">Step 2</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 3</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-x big-icon deny-icon"></i>
                            <h6>The form you've submitted for step 2 has been denied. Click <span style="color: rgb(99, 226, 99)"><a href="step1.php?id=<?= $application['application_id'] ?>&step=2">here.</span> to view the following reason. To resumit please click <span style="color: rgb(99, 226, 99)"><a data-toggle="modal" data-target="#resubmit_modal_step_2">here</a></span>.</h6>
                        </div>

                        <div id="resubmit_modal_step_2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3></h3>
                                        <button type="button" class="close btn float-end" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa-solid fa-x"></i></span>
                                        </button>
                                    </div>
                                    <form class="form" method="post" id="resubmit_form_step2">
                                        <div class="heading-area">
                                            <h3>Resumit</h3>
                                        </div>
                                        <input class="form-input" type="hidden" name="user_id" id="user_id_step_denied_2" required="required">

                                        <section id="requirements_display">
                                            <div class="form-wrap">
                                                <!--    <input class="form-input" type="text" name="alt_glink" id="alt_glink" required="required"> -->
                                                <span>1. Application Letter and Resume</span>
                                            </div>
                                            <div class="form-wrap">
                                                <!--   <input class="form-input" type="text" name="pcmrd_glink" id="pcmrd_glink" required="required"> -->
                                                <span>2. Philhealth Card/MDR</span>
                                            </div>
                                            <div class="form-wrap">
                                                <!--  <input class="form-input" type="text" name="vc_glink" id="vc_glink" required="required"> -->
                                                <span>3. Vaccination Card</span>
                                            </div>
                                            <div class="form-wrap">
                                                <!--     <input class="form-input" type="text" name="cmc_glink" id="cmc_glink" required="required"> -->
                                                <span>4. Complete Medical check-up (CBC, Urinalysis, Fecalysis, X-ray test)</span>
                                            </div>
                                            <div class="form-wrap">
                                                <!--     <input class="form-input" type="text" name="dt_glink" id="dt_glink" required="required"> -->
                                                <span>5. Drug Test</span>
                                            </div>
                                            <div class="form-wrap">
                                                <!--  <input class="form-input" type="text" name="mc_glink" id="mc_glink" required="required"> -->
                                                <span>6. Medical Certificate</span>
                                            </div>
                                            <div class="form-wrap">
                                                <!--    <input class="form-input" type="text" name="pt_glink" required="required">  -->
                                                <span>7. Pregnancy Test for Females</span>
                                            </div>
                                        </section>
                                        <div class="form-wrap form-wrap-glink">
                                            <input class="form-input" type="text" name="step2_docs_link" required="required">
                                            <span>G-Link folder of the required documents</span>
                                        </div>
                                        <div class="btn-area">
                                            <button class="resubmit-btn rebtn-2" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                <?php } else if ($step == 3 && $application['application_status'] == 'PENDING' && $application) { ?>


                    <div class="pending-message-step-3 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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

                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                            <h6>Your application is still being process for step 3. You can still edit your submitted form by clicking <span style="color: rgb(99, 226, 99)"><a data-toggle="modal" data-target="#exampleModal3">here</a></span></h6>
                        </div>

                        <div id="exampleModal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3></h3>
                                        <button type="button" class="close btn float-end" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa-solid fa-x"></i></span>
                                        </button>
                                    </div>
                                    <form class="form" id="edit_form_step3">
                                        <input class="form-input" type="hidden" name="user_id" id="user_id_step_3" required="required">
                                        <div class="form-wrap">
                                            <!--   <input class="form-input" type="text" name="el_glink" id="el_glink" required="required"> -->
                                            <span>1. Endorsement Letter</span>
                                        </div>
                                        <div class="form-wrap">
                                            <!--  <input class="form-input" type="text" name="mhu_glink" id="mhu_glink" required="required"> -->
                                            <span>2. MOA: Student & HTE</span>
                                        </div>
                                        <div class="form-wrap">
                                            <!--     <input class="form-input" type="text" name="msh_glink" id="msh_glink" required="required"> -->
                                            <span>3. MOA: HTE & Univeristy</span>
                                        </div>
                                        <div class="form-wrap form-wrap-glink">
                                            <input class="form-input" type="text" name="step3_docs_link" id="step3_docs_link" required="required">
                                            <span>G-Link folder of the requied documents</span>
                                        </div>
                                        <div class="btn-area">
                                            <button class="save-changes-btn-3" type="submit">Save</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>


                    </div>
                <?php } else if ($step == 3 && $application['application_status'] == 'DECLINED' && $application) { ?>



                    <div class="declined-message-step-3 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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
                                <div class="progress-circle deny-active">
                                    <i class="fa-solid fa-x"></i>
                                </div>
                                <a href="#">Step 3</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-x big-icon deny-icon"></i>
                            <h6>The form you've submitted for step 3 has been denied. Click <span style="color: rgb(99, 226, 99)"><a href="step1.php?id=<?= $application['application_id'] ?>&step=3">here</a></span> to view the following reason. To resumit please click <span style="color: rgb(99, 226, 99)"><a data-toggle="modal" data-target="#resubmit_modal_step_3">here</a></span>.</h6>
                        </div>

                        <div id="resubmit_modal_step_3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3></h3>
                                        <button type="button" class="close btn float-end" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa-solid fa-x"></i></span>
                                        </button>
                                    </div>
                                    <form class="form" id="resubmit_form_step3">
                                        <div class="heading-area">
                                            <h2>Resubmit the following documents</h2>
                                        </div>

                                        <input class="form-input" type="hidden" name="user_id" id="user_id_step_denied_3" required="required">

                                        <div class="form-wrap">
                                            <!--   <input class="form-input" type="text" name="el_glink" id="el_glink" required="required"> -->
                                            <span>1. Endorsement Letter</span>
                                        </div>
                                        <div class="form-wrap">
                                            <!--  <input class="form-input" type="text" name="mhu_glink" id="mhu_glink" required="required"> -->
                                            <span>2. MOA: Student & HTE</span>
                                        </div>
                                        <div class="form-wrap">
                                            <!--     <input class="form-input" type="text" name="msh_glink" id="msh_glink" required="required"> -->
                                            <span>3. MOA: HTE & Univeristy</span>
                                        </div>
                                        <div class="form-wrap form-wrap-glink">
                                            <input class="form-input" type="text" name="step3_docs_link" id="step3_docs_link" required="required">
                                            <span>G-Link folder of the required documents</span>
                                        </div>
                                        <div class="btn-area">
                                            <button class="resubmit-btn rebtn-3" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                <?php } else if ($step == 3 && $application['application_status'] == 'ACCEPTED' && $application) { ?>


                    <div class="accepted-message-step-3 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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
                            <div class="progress-wrapper">
                                <div class="progress-circle pending-active">
                                    <i class="fa-solid fa-hourglass-start"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                            <h6>Your application for step 3 has been veified. Please wait for the approval of the college dean.</h6>
                        </div>

                    </div>
                <?php } else if ($step == 4 && $application['application_status'] == 'PENDING' && $application) { ?>


                    <div class="pending-message-step-3 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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

                            <div class="progress-wrapper">
                                <div class="progress-circle pending-active">
                                    <i class="fa-regular fa-hourglass-start"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                            <h6>Your application is still being process for step 4. You can still update your dean in regards to this</span></h6>
                        </div>




                    </div>
                <?php } else if ($step == 4 && $application['application_status'] == 'DECLINED' && $application) { ?>



                    <div class="declined-message-step-3 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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

                            <div class="progress-wrapper">
                                <div class="progress-circle deny-active">
                                    <i class="fa-regular fa-x"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-x big-icon deny-icon"></i>
                            <h6>The form you've submitted for step 4 has been denied.</span>.</h6>
                        </div>



                    </div>
                <?php } else if ($step == 4 && $application['application_status'] == 'ACCEPTED' && $application) { ?>


                    <div class="accepted-message-step-3 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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

                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-regular fa-check"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle pending-active">
                                    <i class="fa-regular fa-hourglass-start"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                            <h6>Your application for step 4 has been veified. Please wait for the approval of the adviser.</h6>
                        </div>

                    </div>

                <?php } else if ($step == 5 && $application['application_status'] == 'PENDING' && $application) { ?>

                    <div class="accepted-message-step-4 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle pending-active">
                                    <i class="fa-solid fa-hourglass-start"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">
                            <i class="fa-solid fa-hourglass-start big-icon pending-icon"></i>
                            <h6>You are now approved by the college dean. Please wait for the approval of the adviser.</h6>
                        </div>
                    </div>
                <?php } else if ($step == 5 && $application['application_status'] == 'ACCEPTED' && $application) { ?>

                    <div class="accepted-message-step-5 card">
                        <div class="progress-area">
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Info</a>
                            </div>
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
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Step 4</a>
                            </div>
                            <div class="progress-wrapper">
                                <div class="progress-circle success-active">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <a href="#">Step 5</a>
                            </div>
                        </div>
                        <div class="content-area">

                            <i class="fa-solid fa-door-open big-icon welcome-icon"></i>
                            <h6>You are now approved by the adviser. You are now ready for your OJT.</h6>
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
    <script>
        $(document).ready(function() {
            $('a[href^="step1.php"]').on('click', function(e) {
                e.preventDefault();
                const href = $(this).attr('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will re submit your form.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Resubmit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(href)
                        window.location.href = href;
                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#edit_form_step2').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var step2DocsLink = $('#step2_docs_link').val();

                // Validate the G-Link URL
                if (!step2DocsLink) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please enter the G-Link URL.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // AJAX request
                $.ajax({
                    url: 'update_step2.php', // The PHP file that will handle the update
                    type: 'POST',
                    data: {
                        step2_docs_link: step2DocsLink
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.status)
                        // Handle the success response from PHP
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "Error Na",
                                confirmButtonText: 'OK'
                            });
                        }
                        $('#exampleModal2').modal('hide')
                    },
                    error: function() {
                        // Handle any errors in the AJAX request
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
            $('#edit_form_step3').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var step3DocsLink = $('#step3_docs_link').val();

                // Validate the G-Link URL
                if (!step3DocsLink) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Please enter the G-Link URL.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // AJAX request
                $.ajax({
                    url: 'update_step3.php', // The PHP file that will handle the update
                    type: 'POST',
                    data: {
                        step3_docs_link: step3DocsLink
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.status)
                        // Handle the success response from PHP
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "Error Na",
                                confirmButtonText: 'OK'
                            });
                        }
                        $('#exampleModal3').modal('hide')
                    },
                    error: function() {
                        // Handle any errors in the AJAX request
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>