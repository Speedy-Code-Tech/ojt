<?php
session_start();
require_once("../../backend/db_connect.php");

// Check if the form is submitted for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user_id from the session
    $user_id = $_SESSION['user_id'];

    // Retrieve and sanitize form inputs
    $start_year = $_POST['start_year'];
    $end_year = $_POST['end_year'];
    $pi_fname = htmlspecialchars($_POST['pi_fname']);
    $pi_mname = htmlspecialchars($_POST['pi_mname']);
    $pi_lname = htmlspecialchars($_POST['pi_lname']);
    $pi_dept = htmlspecialchars($_POST['pi_dept']);
    $pi_course = htmlspecialchars($_POST['pi_course']);
    $pi_year_lv = htmlspecialchars($_POST['pi_year_lv']);
    $pi_gender = htmlspecialchars($_POST['pi_gender']);
    $pi_age = (int) $_POST['pi_age'];
    $pi_civil_status = htmlspecialchars($_POST['pi_civil_status']);
    $pi_bdate = $_POST['pi_bdate'];
    $pi_contact = htmlspecialchars($_POST['pi_contact']);
    $pi_email = htmlspecialchars($_POST['pi_email']);
    $pi_address = htmlspecialchars($_POST['pi_address']);
    $ptd_establishment = htmlspecialchars($_POST['ptd_establishment']);
    $ptd_address = htmlspecialchars($_POST['ptd_address']);
    $ptd_contact_number = htmlspecialchars($_POST['ptd_contact_number']);
    $ptd_training_hrs = (int) $_POST['ptd_training_hrs'];
    $ptd_start_date = $_POST['ptd_start_date'] ?? null;
    $ptd_end_date = $_POST['ptd_end_date'] ?? null;
    $cdi_name = htmlspecialchars($_POST['cdi_name']);
    $cdi_relationship = htmlspecialchars($_POST['cdi_relationship']);
    $cdi_contact = htmlspecialchars($_POST['cdi_contact']);
    $cdi_address = htmlspecialchars($_POST['cdi_address']);
    $cdi_com_address = htmlspecialchars($_POST['cdi_com_address'] ?? null);

    // Validation: Check for required fields
    if (empty($start_year)) {
        $errors['start_year'] = "Start Year is required.";
    }
    if (empty($end_year)) {
        $errors['end_year'] = "End Year is required.";
    }
    if (empty($pi_fname)) {
        $errors['pi_fname'] = "First Name is required.";
    }
    if (empty($pi_lname)) {
        $errors['pi_lname'] = "Last Name is required.";
    }
    if (empty($pi_dept)) {
        $errors['pi_dept'] = "Department is required.";
    }
    if (empty($pi_course)) {
        $errors['pi_course'] = "Program is required.";
    }
    if (empty($pi_year_lv)) {
        $errors['pi_year_lv'] = "Year Level is required.";
    }
    if (empty($pi_gender)) {
        $errors['pi_gender'] = "Gender is required.";
    }
    if (empty($pi_age)) {
        $errors['pi_age'] = "Age is required.";
    }
    if (empty($pi_civil_status)) {
        $errors['pi_civil_status'] = "Civil Status is required.";
    }
    if (empty($pi_bdate)) {
        $errors['pi_bdate'] = "Birth Date is required.";
    }
    if (empty($pi_contact)) {
        $errors['pi_contact'] = "Contact Number is required.";
    }
    if (empty($pi_address)) {
        $errors['pi_address'] = "Home Address is required.";
    }
    if (empty($ptd_establishment)) {
        $errors['ptd_establishment'] = "Training Establishment is required.";
    }
    if (empty($ptd_address)) {
        $errors['ptd_address'] = "Training Address is required.";
    }
    if (empty($ptd_training_hrs)) {
        $errors['ptd_training_hrs'] = "Duration of Training Hours is required.";
    }
    if (empty($cdi_name)) {
        $errors['cdi_name'] = "Emergency Contact Name is required.";
    }
    if (empty($cdi_contact)) {
        $errors['cdi_contact'] = "Emergency Contact Number is required.";
    }
    if (empty($cdi_address)) {
        $errors['cdi_address'] = "Emergency Contact Address is required.";
    }
    if (empty($cdi_com_address)) {
        $errors['cdi_com_address1'] = "Contact Address is required.";
    }

    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header(header: "Location: edit.php"); // Adjust the redirect to your form page
        exit;
    }

    $result = mysqli_query($conn, "
    UPDATE application_table
    SET 
        pi_fname = '$pi_fname',
        pi_mname = '$pi_mname',
        pi_lname = '$pi_lname',
        pi_dept = '$pi_dept',
        pi_course = '$pi_course',
        pi_year_lv = '$pi_year_lv',
        pi_gender = '$pi_gender',
        pi_age = '$pi_age',
        pi_civil_status = '$pi_civil_status',
        pi_bdate = '$pi_bdate',
        pi_contact = '$pi_contact',
        pi_email = '$pi_email',
        pi_address = '$pi_address',
        ptd_establishment = '$ptd_establishment',
        ptd_address = '$ptd_address',
        ptd_contact_number = '$ptd_contact_number',
        ptd_training_hrs = '$ptd_training_hrs',
        ptd_start_date = '$ptd_start_date',
        ptd_end_date = '$ptd_end_date',
        cdi_name = '$cdi_name',
        cdi_relationship = '$cdi_relationship',
        cdi_contact = '$cdi_contact',
        cdi_address = '$cdi_address',
        cdi_com_address = '$cdi_com_address',
        application_status = 'PENDING',
        is_new = 'true',
        applicant_notified = 'true',
        application_step = 0,
        start_date = '$start_year',
        end_date = '$end_year'
    WHERE user_id = '$user_id'
");
if ($result == TRUE) {
    // return true;
    // echo "Updated";  
    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Application Form Updated Successfully!'; 
    
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Application Form Failed to Update!';

    // echo "0";
}
header('Location: status.php'); // Redirect to view users page

} else {
    // Fetch existing data to populate the form
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT * FROM application_table WHERE user_id = '$user_id'");

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Populate form fields with existing data
        $start_year = $row['start_date'];
        $end_year = $row['end_date'];
        $pi_fname = $row['pi_fname'];
        $pi_mname = $row['pi_mname'];
        $pi_lname = $row['pi_lname'];
        $pi_dept = $row['pi_dept'];
        $pi_course = $row['pi_course'];
        $pi_year_lv = $row['pi_year_lv'];
        $pi_gender = $row['pi_gender'];
        $pi_age = $row['pi_age'];
        $pi_civil_status = $row['pi_civil_status'];
        $pi_bdate = $row['pi_bdate'];
        $pi_contact = $row['pi_contact'];
        $pi_email = $row['pi_email'];
        $pi_address = $row['pi_address'];
        $ptd_establishment = $row['ptd_establishment'];
        $ptd_address = $row['ptd_address'];
        $ptd_contact_number = $row['ptd_contact_number'];
        $ptd_training_hrs = $row['ptd_training_hrs'];
        $ptd_start_date = $row['ptd_start_date'];
        $ptd_end_date = $row['ptd_end_date'];
        $cdi_name = $row['cdi_name'];
        $cdi_relationship = $row['cdi_relationship'];
        $cdi_contact = $row['cdi_contact'];
        $cdi_address = $row['cdi_address'];
        $cdi_com_address = $row['cdi_com_address'];

        // Output the form with existing data for editing
        // include("edit_form.php"); // Assuming you have a form to display
    } else {
        echo "No record found.";
    }
}
?>
