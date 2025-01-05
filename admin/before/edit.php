<?php
require('../../backend/db_connect.php');
 if(session_status()===PHP_SESSION_NONE) session_start();
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    
    // Update the application status
    $query = "UPDATE application_table SET application_status = '$status',application_step=3 WHERE application_id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Step 2 '.$status=='ACCEPTED'?'UPDATED':$status .' successfully!';
        $email = $conn->query("SELECT * FROM application_table WHERE application_id = $id");
            $em = '';
            while ($r = $email->fetch_assoc()) {
                $em = $r['pi_email'];
            }
            $_SESSION['user_email'] = $em;
            $_SESSION['msg'] = "Congratualation! Please proceed to STEP 3!";
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
    }
    
    header('Location: view.php'); // Redirect to view users page

}else{
    echo "Mayo Laman";
}
?>
