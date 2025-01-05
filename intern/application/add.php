<?php
session_start();
require_once("../../backend/db_connect.php");

// Initialize an array to store errors
$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user_id from the session
    $user_id = $_SESSION['user_id'];

    // Retrieve and sanitize form inputs
    $start_year = $_POST['start_year'] ?? '';
    $end_year = $_POST['end_year'] ?? '';
    $pi_fname = htmlspecialchars($_POST['pi_fname'] ?? '');
    $pi_mname = htmlspecialchars($_POST['pi_mname'] ?? '');
    $pi_lname = htmlspecialchars($_POST['pi_lname'] ?? '');
    $pi_dept = htmlspecialchars($_POST['pi_dept'] ?? '');
    $pi_course = htmlspecialchars($_POST['pi_course'] ?? '');
    $pi_year_lv = htmlspecialchars($_POST['pi_year_lv'] ?? '');
    $pi_gender = htmlspecialchars($_POST['pi_gender'] ?? '');
    $pi_age = (int) ($_POST['pi_age'] ?? 0);
    $pi_civil_status = htmlspecialchars($_POST['pi_civil_status'] ?? '');
    $pi_bdate = $_POST['pi_bdate'] ?? '';
    $pi_contact = htmlspecialchars($_POST['pi_contact'] ?? '');
    $pi_email = htmlspecialchars($_POST['pi_email'] ?? '');
    $pi_address = htmlspecialchars($_POST['pi_address'] ?? '');
    $ptd_establishment = htmlspecialchars($_POST['ptd_establishment'] ?? '');
    $ptd_address = htmlspecialchars($_POST['ptd_address'] ?? '');
    $ptd_contact_number = htmlspecialchars($_POST['ptd_contact_number'] ?? '');
    $ptd_training_hrs = (int) ($_POST['ptd_training_hrs'] ?? 0);
    $ptd_start_date = $_POST['ptd_start_date'] ?? null;
    $ptd_end_date = $_POST['ptd_end_date'] ?? null;
    $cdi_name = htmlspecialchars($_POST['cdi_name'] ?? '');
    $cdi_relationship = htmlspecialchars($_POST['cdi_relationship'] ?? '');
    $cdi_contact = htmlspecialchars($_POST['cdi_contact'] ?? '');
    $cdi_address = htmlspecialchars($_POST['cdi_address'] ?? '');
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

    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header(header: "Location: form.php"); // Adjust the redirect to your form page
        exit;
    }

    // If no errors, proceed with inserting data into the database
    $query = "INSERT INTO application_table (user_id, pi_fname, pi_mname, pi_lname, pi_dept, pi_course, pi_year_lv, pi_gender, pi_age, 
    pi_civil_status, pi_bdate, pi_contact, pi_email, pi_address, ptd_establishment, ptd_address, ptd_contact_number, 
    ptd_training_hrs, ptd_start_date, ptd_end_date, cdi_name, cdi_relationship, cdi_contact, cdi_address, cdi_com_address,
    application_status, is_new, applicant_notified, application_step, start_date, end_date) 
    VALUES ('$user_id', '$pi_fname', '$pi_mname', '$pi_lname', '$pi_dept', '$pi_course', '$pi_year_lv', '$pi_gender', 
    '$pi_age', '$pi_civil_status', '$pi_bdate', '$pi_contact', '$pi_email', '$pi_address', '$ptd_establishment', 
    '$ptd_address', '$ptd_contact_number', '$ptd_training_hrs', '$ptd_start_date', '$ptd_end_date', '$cdi_name', 
    '$cdi_relationship', '$cdi_contact', '$cdi_address', '$cdi_com_address', 'PENDING', 'true', 'true', 0, '$start_year', '$end_year')";

    $result = mysqli_query($conn, $query);

    // Check if the insertion was successful
    if ($result) {
        $_SESSION['success'] = "Application submitted successfully.";
        header("Location: redirect.php"); // Adjust the redirect to a success page
        exit;
    } else {
        $_SESSION['error'] = "An error occurred while submitting your application. Please try again.";
        header("Location: form.php"); // Redirect back to the form if insertion fails
        exit;
    }
} else {
    echo "Invalid request method.";
}
?>