<?php
    include_once('badge.php');
    $page = isset($_SESSION['page']) ? $_SESSION['page'] : ''; // Ensure $page is set to avoid errors
    $link = $_SERVER['DOCUMENT_ROOT'] . '/registrar/';
    ini_set('display_errors', 1);
error_reporting(E_ALL);

?>

<div class="sidebar">
    <h4 class="text-center py-3">OJT System</h4>
    
    <!-- Dashboard -->
    <a href="<?= ($page == 'dashboard') ? '#' : '/registrar/dashboard.php' ?>" class="<?= ($page == 'dashboard') ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge"></i> Dashboard
    </a>

    <!-- Student's Information -->
    <a href="<?= ($page == 'student_info') ? '#' : '/registrar/student_info/view.php' ?>" class="<?= ($page == 'student_info') ? 'active' : '' ?>">
        <i class="fa-solid fa-paperclip"></i> Student's Information 
        <span class="badge bg-danger"><?= isset($student) ? $student : 0 ?></span>
    </a>


    <!-- After OJT -->
    <a href="#" class="dropdown-toggle <?= ($page == 'afterstep1'||$page == 'afterstep2'||$page == 'afterstep3') ? 'active' : '' ?>" data-bs-toggle="collapse" data-bs-target="#afterOJTMenu">
        <i class="fa-solid fa-paperclip"></i> After OJT
    </a>
    <div id="afterOJTMenu" class="collapse">
        
        <a href="<?= ($page == 'afterstep3') ? '#' : '/registrar/after_step3/view.php' ?>" class="ms-3 <?= ($page == 'afterstep3') ? 'active' : '' ?>"> 
        
            <i class="fa-solid fa-paperclip"></i> Step 3 
            <span style="color: red; cursor: pointer;">(<?= isset($afterstep3) ? $afterstep3 : 0 ?>)</span>
        </a>
    </div>

    <!-- Additional Links -->
    <a href="<?= ($page == 'announcements') ? '#' : '/registrar/announcements/view.php' ?>" class="<?= ($page == 'announcements') ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge"></i> Add Announcement
    </a>
    

  
    <a href="<?= ($page == 'view_intern') ? '#' : '/registrar/intern_history/view.php' ?>" class=" <?= ($page == 'view_intern') ? 'active' : '' ?>">
    <i class="fa-solid fa-users"></i> View Intern History</a>
    <a href="<?= ($page == 'history') ? '#' : '/registrar/history/view.php' ?>" class=" <?= ($page == 'history') ? 'active' : '' ?>">
    <i class="fa-solid fa-paper-plane"></i> Awaiting Review</a>
    <!-- Logout -->
    <a href="/backend/logout.php" class="logout">
        <i class="fa-solid fa-right-to-bracket"></i> Log Out
    </a>
</div>
