<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Intern Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="../../assets/css/form.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>


</head>
<?php
session_start();
require_once("../../backend/db_connect.php");
// Query to get the latest announcement from the database

$id = $_SESSION['user_id'];
$query = "SELECT * FROM application_table WHERE user_id = $id AND application_step=0";
$result = mysqli_query($conn, $query);

// Check if there is a result
if ($result && mysqli_num_rows($result) > 0) {
    $data = true;
} else {
    $data = false;
}
$result = $conn->query("SELECT * FROM department");
$results = $conn->query("SELECT * FROM programs");
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
        <a href="after/status.php" class="ms-3 <?= ($steps == 5 && $status == 'ACCEPTED') ? 'd-block' : 'd-none' ?> ps-0"><i class="fa-solid fa-boxes-stacked"></i> After OJT</a>

        <a href="../../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">

        <div class="wrapper">
            <div id="content">
                <form action="add.php" method="post" class="form">
                    <nav class="navbar navbar-expand-lg navbar-light ">
                        <div class="container-fluid">
                            <button type="button" id="sidebarCollapse" class="btn btn-info">
                                <i class="fas fa-greater-than" id="greater_than"></i>
                                <i class="fas fa-less-than" id="less_than" style="display:none;"></i>
                            </button>
                        </div>
                        <div class="container-fluid school-year">
                            <div class="heading-area">
                                <h2>School Year</h2>
                            </div>
                            <div class="school-year-item">
                                <div class="container">
                                    <div class="form-wrap">
                                        <label for="start_year">Start Year</label>
                                        <select class="form-input" id="start_year" name="start_year">
                                            <?php
                                            for ($i = 2020; $i <= 2028; $i++) {
                                            ?>
                                                <option value="<?= $i ?>" <?= $_SESSION['start_year'] == '<?=$i?>' ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php if (!empty($_SESSION['errors']['start_year'])): ?>
                                        <p class="error-message"><?= $_SESSION['errors']['start_year'] ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="container">
                                    <div class="form-wrap">
                                        <label for="end_year">End Year</label>
                                        <select class="form-input" id="end_year" name="end_year">
                                            <?php
                                            for ($i = 2020; $i <= 2028; $i++) {
                                            ?>
                                                <option value="<?= $i ?>" <?= $_SESSION['end_year'] == '<?=$i?>' ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php if (!empty($_SESSION['errors']['end_year'])): ?>
                                        <p class="error-message"><?= $_SESSION['errors']['end_year'] ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="main-content">
                        <div class="form-groups">
                            <div class="heading-area text-center">
                                <h2>Personal Information</h2>
                            </div>
                        </div>
                        <input class="form-input" type="hidden" name="user_id" id="user_id">

                        <div class="form-groups">
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="pi_fname">First Name</label>
                                    <input class="form-input" type="text" name="pi_fname" id="pi_fname" value="<?= $_SESSION['pi_fname'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_fname'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_fname'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="pi_mname">Middle Name</label>
                                    <input class="form-input" type="text" name="pi_mname" id="pi_mname" value="<?= $_SESSION['pi_mname'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_mname'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_mname'] ?></p>
                                <?php endif; ?>
                            </div>

                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="pi_lname">Last Name</label>
                                    <input class="form-input" type="text" name="pi_lname" id="pi_lname" value="<?= $_SESSION['pi_lname'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_lname'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_lname'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="select-wrap">
                                    <label for="pi_dept">Department</label>
                                    <select name="pi_dept" id="pi_dept" class="form-control" onchange="fetchPrograms()">
                                        <option value="" disabled selected>Select Department</option>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            $selected = ($_SESSION['pi_dept'] == $row['dept']) ? 'selected' : '';
                                            echo '<option value="' . htmlspecialchars($row['dept']) . '" ' . $selected . '>' . htmlspecialchars($row['dept']) . '</option>';
                                        }
                                        ?>  
                                    </select>
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_dept'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_dept'] ?></p>
                                <?php endif; ?>
                            </div>

                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="select-wrap">
                                    <label for="pi_course">Program</label>
                                    <select name="pi_course" id="pi_course" class="form-control">
                                        <option value="" disabled selected><?= $_SESSION['pi_dept']?$_SESSION['pi_dept']:'Select Program'?></option>
                                    </select>
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_course'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_course'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="select-wrap">
                                    <label for="pi_year_lv">Year Level</label>
                                    <select name="pi_year_lv" id="pi_year_lv">
                                        <option value="" selected>Select Year Level</option>
                                        <option value="1" <?= $_SESSION['pi_year_lv'] == 1 ? 'selected' : '' ?>>1st Year</option>
                                        <option value="2" <?= $_SESSION['pi_year_lv'] == 2 ? 'selected' : '' ?>>2nd Year</option>
                                        <option value="3" <?= $_SESSION['pi_year_lv'] == 3 ? 'selected' : '' ?>>3rd Year</option>
                                        <option value="4" <?= $_SESSION['pi_year_lv'] == 4 ? 'selected' : '' ?>>4th Year</option>
                                        <option value="5" <?= $_SESSION['pi_year_lv'] == 5 ? 'selected' : '' ?>>5th Year</option>
                                    </select>
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_year_lv'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_year_lv'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="select-wrap">
                                    <label for="pi_gender">Gender</label>
                                    <select name="pi_gender" id="pi_gender">
                                        <option value="" selected>Select Gender</option>
                                        <option value="Male"   <?= $_SESSION['pi_gender'] == 'Male' ? 'selected' : '' ?> >Male</option>
                                        <option value="Female" <?= $_SESSION['pi_gender'] == 'Female' ? 'selected' : '' ?> >Female</option>
                                    </select>
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_gender'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_gender'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="pi_age">Age</label>
                                    <input class="form-input" type="number" maxlength='2' name="pi_age" id="pi_age" value="<?= $_SESSION['pi_age'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_age'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_age'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="select-wrap">
                                    <label for="pi_civil_status">Civil Status</label>
                                    <select name="pi_civil_status" id="pi_civil_status">
                                        <option value="" selected>Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_civil_status'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_civil_status'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="date-wrap">
                                    <label for="pi_bdate">Birth Date</label>
                                    <input class="form-input" type="date" name="pi_bdate" id="pi_bdate" value="<?= $_SESSION['pi_bdate'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_bdate'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_bdate'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="pi_contact">Contact Number</label>
                                    <input class="form-input" maxlength='11' type="number" name="pi_contact" id="pi_contact" value="<?= $_SESSION['pi_contact'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_contact'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_contact'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="pi_email">Email Address</label>
                                    <input class="form-input email-input" type="text" name="pi_email" id="pi_email" readonly value="<?= ($email['email']); ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_email'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_email'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="pi_address">Home Address</label>
                                    <input class="form-input" type="text" name="pi_address" id="pi_address" value="<?= $_SESSION['pi_address'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['pi_address'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['pi_address'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Practicum Training Details Section -->
                        <div class="form-groups">
                            <div class="heading-area">
                                <h2>Practicum Training Details</h2>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="ptd_establishment">Training Establishment</label>
                                    <input class="form-input" type="text" name="ptd_establishment" id="ptd_establishment" value="<?= $_SESSION['ptd_establishment'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['ptd_establishment'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['ptd_establishment'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="ptd_address">Address</label>
                                    <input class="form-input" type="text" name="ptd_address" id="ptd_address" value="<?= $_SESSION['ptd_address'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['ptd_address'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['ptd_address'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="ptd_contact_number">Contact Number (Optional)</label>
                                    <input class="form-input" maxlength='11' type="number" name="ptd_contact_number" id="ptd_contact_number" value="<?= $_SESSION['ptd_contact_number'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['ptd_contact_number'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['ptd_contact_number'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="ptd_training_hrs">Duration of Training Hours</label>
                                    <input class="form-input" type="number" name="ptd_training_hrs" id="ptd_training_hrs" value="<?= $_SESSION['ptd_training_hrs'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['ptd_training_hrs'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['ptd_training_hrs'] ?></p>
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="form-groups">
                            <div class="date-wrap">
                                <label>Start Date (Optional)</label>
                                <input class="form-input from-date" type="date" name="ptd_start_date" id="ptd_start_date" value="<?= $_SESSION['ptd_start_date'] ?? '' ?>">

                            </div>
                            <div class="date-wrap">
                                <label>End Date (Optional)</label>
                                <input class="form-input to-date" type="date" name="ptd_end_date" id="ptd_end_date" value="<?= $_SESSION['ptd_end_date'] ?? '' ?>">
                            </div>
                        </div>

                        <!-- Emergency Contact Details Section -->
                        <div class="form-groups">
                            <div class="heading-area">
                                <h2>Contact Details in Case of Emergency</h2>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="cdi_name">Full Name</label>
                                    <input class="form-input" type="text" name="cdi_name" id="cdi_name" value="<?= $_SESSION['cdi_name'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['cdi_name'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['cdi_name'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="cdi_relationship">Relationship</label>
                                    <input class="form-input" type="text" name="cdi_relationship" id="cdi_relationship" value="<?= $_SESSION['cdi_relationship'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['cdi_relationship'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['cdi_relationship'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="container">
                                <div class="form-wrap">
                                    <label for="cdi_contact">Contact Number</label>
                                    <input class="form-input" maxlength='11' type="number" name="cdi_contact" id="cdi_contact" value="<?= $_SESSION['cdi_contact'] ?? '' ?>">
                                </div>
                                <?php if (!empty($_SESSION['errors']['cdi_contact'])): ?>
                                    <p class="error-message"><?= $_SESSION['errors']['cdi_contact'] ?></p>
                                <?php endif; ?>
                            </div>

                        </div>
                        <div class="container">
                            <div class="form-wrap">
                                <label for="cdi_com_address">Address</label>
                                <input class="form-input" type="text" name="cdi_address" id="cdi_address" value="<?= $_SESSION['cdi_address'] ?? '' ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['cdi_address'])): ?>
                                <p class="error-message"><?= $_SESSION['errors']['cdi_address'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="container">
                            <div class="form-wrap">
                                <label for="cdi_com_address">Company Address</label>
                                <input class="form-input" type="text" name="cdi_com_address" id="cdi_com_address" value="<?= $_SESSION['cdi_com_address'] ?? '' ?>">
                            </div>
                            <?php if (!empty($_SESSION['errors']['cdi_com_address1'])): ?>
                                <p class="error-message"><?= $_SESSION['errors']['cdi_com_address1'] ?></p>
                            <?php endif; ?>
                        </div>
                        <!-- Submit Button -->
                        <div class="btn-area">
                            <button class="add-account-btn" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fetchPrograms() {
            const department = document.getElementById('pi_dept').value;

            // Make an AJAX request
            $.ajax({
                url: './fetch_programs.php', // The PHP file to handle the request
                method: 'POST',
                data: {
                    dept: department
                },
                success: function(response) {
                    // Populate the pi_course dropdown
                    console.log(response)
                    document.getElementById('pi_course').innerHTML = response;
                },
                error: function() {
                    alert('Error fetching programs.');
                }
            });
        }
    </script>
    <script>
        // Get the current year
        let currentYear = new Date().getFullYear();
        let startYearSelect = document.getElementById('stcart_year');
        let endYearSelect = document.getElementById('end_ccyear');

        // Set the range for start year (2020 to 2028)
        let startYearMin = 2020;
        let startYearMax = 2028;

        // Function to populate the start year dropdown (from 2020 to 2028)
        function populateStartYear() {
            for (let year = startYearMin; year <= startYearMax; year++) {
                let option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                startYearSelect.appendChild(option);
            }
        }

        // Function to populate the end year dropdown dynamically based on the selected start year
        function populateEndYear() {
            // Clear existing end year options
            endYearSelect.innerHTML = '';

            // Get the selected start year
            let startYear = parseInt(startYearSelect.value);

            // Add years from the selected start year to 2028
            for (let year = startYear; year <= 2028; year++) {
                let option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                endYearSelect.appendChild(option);
            }

            // If the start year is the last option (2028), set the end year to 2028 automatically
            if (startYear === startYearMax) {
                endYearSelect.value = startYearMax;
            }
        }

        // Initialize the dropdowns
        populateStartYear();
        populateEndYear();

        // Update end year options whenever the start year is changed
        startYearSelect.addEventListener('change', populateEndYear);
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("form");

            form.addEventListener("submit", function(e) {
                e.preventDefault()
                alert("Sample")
                let isValid = true;

                // Example validations
                const Fields = form.querySelectorAll("[]");
                Fields.forEach((field) => {
                    if (!field.value.trim()) {
                        isValid = false;
                        showError(field, "This field is .");
                    } else {
                        removeError(field);
                    }
                });

                const emailField = document.getElementById("pi_email");
                if (emailField && !validateEmail(emailField.value)) {
                    isValid = false;
                    showError(emailField, "Please enter a valid email address.");
                }

                const contactField = document.getElementById("pi_contact");
                if (contactField && contactField.value.length !== 11) {
                    isValid = false;
                    showError(contactField, "Contact number must be 11 digits.");
                }

                if (!isValid) {
                    e.preventDefault(); // Prevent form submission
                }
            });

            function showError(field, message) {
                let parent = field.parentNode; // Get the parent element
                let error = parent.querySelector(".error-message"); // Check if an error message already exists
                if (!error) {
                    error = document.createElement("span");
                    error.className = "error-message text-danger"; // Add appropriate Bootstrap class
                    parent.appendChild(error); // Append the error message to the parent container
                }
                error.textContent = message; // Set the error message text
                field.classList.add("is-invalid"); // Add invalid class for Bootstrap styling
            }


            function removeError(field) {
                let parent = field.parentNode;
                const error = parent.querySelector(".error-message");
                if (error) {
                    error.remove(); // Remove the error message
                }
                field.classList.remove("is-invalid"); // Remove invalid class
            }


            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(String(email).toLowerCase());
            }
        });
    </script>

</body>

</html>