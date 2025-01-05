<?php
    include_once('badge.php');
    $page = isset($_SESSION['page']) ? $_SESSION['page'] : ''; // Ensure $page is set to avoid errors
    $link = $_SERVER['DOCUMENT_ROOT'] . '/admin/';
    
?>

<div class="sidebar">
    <h4 class="text-center py-3">OJT System</h4>
    
    <!-- Dashboard -->
    <a href="<?= ($page == 'dashboard') ? '#' : '/admin/dashboard.php' ?>" class="<?= ($page == 'dashboard') ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge"></i> Dashboard
    </a>

    <!-- Student's Information -->
    <a href="<?= ($page == 'student_info') ? '#' : '/admin/student_info/view.php' ?>" class="<?= ($page == 'student_info') ? 'active' : '' ?>">
        <i class="fa-solid fa-paperclip"></i> Student's Information 
        <span class="badge bg-danger"><?= isset($student) ? $student : 0 ?></span>
    </a>

    <!-- Before OJT -->
    <a href="#" class="dropdown-toggle <?= ($page == 'step1'||$page == 'step2'||$page == 'step3') ? 'active' : '' ?>" data-bs-toggle="collapse" data-bs-target="#beforeOJTMenu">
        <i class="fa-solid fa-hand"></i> Before OJT
    </a>
    <div id="beforeOJTMenu" class="collapse ">
        <a href="<?= ($page == 'step1') ? '#' : '/admin/step1/view.php' ?>" class="ms-3 <?= ($page == 'step1') ? 'active' : '' ?>"> 
            <i class="fa-solid fa-paperclip"></i> Step 1 
            <span style="color: red; cursor: pointer;">(<?= isset($step1) ? $step1 : 0 ?>)</span>
        </a>
        <a href="<?= ($page == 'step2') ? '#' : '/admin/before/view.php' ?>" class="ms-3 <?= ($page == 'step2') ? 'active' : '' ?>"> 
            <i class="fa-solid fa-paperclip"></i> Step 2 
            <span style="color: red; cursor: pointer;">(<?= isset($step2) ? $step2 : 0 ?>)</span>
        </a>
        <a href="<?= ($page == 'step3') ? '#' : '/admin/step3/view.php' ?>" class="ms-3 <?= ($page == 'step3') ? 'active' : '' ?>"> 
            <i class="fa-solid fa-paperclip"></i> Step 3 
            <span style="color: red; cursor: pointer;">(<?= isset($step3) ? $step3 : 0 ?>)</span>
        </a>
    </div>

    <!-- After OJT -->
    <a href="#" class="dropdown-toggle <?= ($page == 'afterstep1'||$page == 'afterstep2'||$page == 'afterstep3') ? 'active' : '' ?>" data-bs-toggle="collapse" data-bs-target="#afterOJTMenu">
        <i class="fa-solid fa-paperclip"></i> After OJT
    </a>
    <div id="afterOJTMenu" class="collapse">
        <a href="<?= ($page == 'afterstep1') ? '#' : '/admin/after_step1/view.php' ?>" class="ms-3 <?= ($page == 'afterstep1') ? 'active' : '' ?>"> 
            <i class="fa-solid fa-paperclip"></i> Step 1 
            <span style="color: red; cursor: pointer;">(<?= isset($afterstep1) ? $afterstep1 : 0 ?>)</span>
        </a>
        <a href="<?= ($page == 'afterstep2') ? '#' : '/admin/after_step2/view.php' ?>" class="ms-3 <?= ($page == 'afterstep2') ? 'active' : '' ?>"> 
 
            <i class="fa-solid fa-paperclip"></i> Step 2 
            <span style="color: red; cursor: pointer;">(<?= isset($afterstep2) ? $afterstep2 : 0 ?>)</span>
        </a>
        <a href="<?= ($page == 'afterstep3') ? '#' : '/admin/after_step3/view.php' ?>" class="ms-3 <?= ($page == 'afterstep3') ? 'active' : '' ?>"> 
        
            <i class="fa-solid fa-paperclip"></i> Step 3 
            <span style="color: red; cursor: pointer;">(<?= isset($afterstep3) ? $afterstep3 : 0 ?>)</span>
        </a>
    </div>

    <!-- Additional Links -->
    <a href="<?= ($page == 'announcements') ? '#' : '/admin/announcements/view.php' ?>" class="<?= ($page == 'announcements') ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge"></i> Add Announcement
    </a>
    <a href="<?= ($page == 'department') ? '#' : '/admin/department/view.php' ?>" class="<?= ($page == 'department') ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge"></i> Add Department
    </a>
    <a href="<?= ($page == 'programs') ? '#' : '/admin/programs/view.php' ?>" class="<?= ($page == 'programs') ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge"></i> Add Program
    </a>

    <!-- Manage Accounts -->
    <a href="#" class="dropdown-toggle <?= ($page == 'admin_accounts'||$page == 'adviser_accounts'||$page == 'dean_accounts'||$page == 'heads_accounts'||$page == 'registrar_accounts'||$page == 'view_accounts'||$page == 'intern_accounts') ? 'active' : '' ?>" data-bs-toggle="collapse" data-bs-target="#manageAccountsMenu">
        <i class="fa-solid fa-hand"></i> Manage Accounts
    </a>
    <div id="manageAccountsMenu" class="collapse">
        <a href="<?= ($page == 'admin_accounts') ? '#' : '/admin/admin/view.php' ?>" class="ms-3 <?= ($page == 'admin_accounts') ? 'active' : '' ?>">Admin Accounts</a>
        <a href="<?= ($page == 'adviser_accounts') ? '#' : '/admin/adviser/view.php' ?>" class="ms-3 <?= ($page == 'adviser_accounts') ? 'active' : '' ?>">Adviser Accounts</a>
        <a href="<?= ($page == 'intern_accounts') ? '#' : '/admin/intern/view.php' ?>" class="ms-3 <?= ($page == 'intern_accounts') ? 'active' : '' ?>">Intern Accounts</a>
        <a href="<?= ($page == 'dean_accounts') ? '#' : '/admin/dean/view.php' ?>" class="ms-3 <?= ($page == 'dean_accounts') ? 'active' : '' ?>">Dean Accounts</a>
        <a href="<?= ($page == 'heads_accounts') ? '#' : '/admin/heads/view.php' ?>" class="ms-3 <?= ($page == 'heads_accounts') ? 'active' : '' ?>">Program Head Accounts</a>
        <a href="<?= ($page == 'registrar_accounts') ? '#' : '/admin/registrar/view.php' ?>" class="ms-3 <?= ($page == 'registrar_accounts') ? 'active' : '' ?>">Registrar Accounts</a>
        <a href="<?= ($page == 'view_accounts') ? '#' : '/admin/accounts/view.php' ?>" class="ms-3 <?= ($page == 'view_accounts') ? 'active' : '' ?>">View Accounts</a>
    </div>
    <a href="<?= ($page == 'view_intern') ? '#' : '/admin/intern_history/view.php' ?>" class=" <?= ($page == 'view_intern') ? 'active' : '' ?>">
    <i class="fa-solid fa-users"></i> View Intern History</a>
    <a href="<?= ($page == 'history') ? '#' : '/admin/history/view.php' ?>" class=" <?= ($page == 'history') ? 'active' : '' ?>">
    <i class="fa-solid fa-paper-plane"></i> View History</a>

    <!-- Requirements -->
    <a href="<?= ($page == 'requirements') ? '#' : '/admin/requirements/view.php' ?>" class="<?= ($page == 'requirements') ? 'active' : '' ?>">
        <i class="fa-solid fa-paperclip"></i> Requirements
    </a>

    <!-- Logout -->
    <a href="/backend/logout.php" class="logout">
        <i class="fa-solid fa-right-to-bracket"></i> Log Out
    </a>
</div>
