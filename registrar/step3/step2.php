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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<?php
     if(session_status()===PHP_SESSION_NONE) session_start();

require_once("../../backend/db_connect.php");
// Query to get the latest announcement from the database
if (isset($_GET["id"])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM application_table WHERE application_id = $id ";
    $result = mysqli_query($conn, $query);

    // Check if there is a result
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
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
    }
}
require_once("badge.php");
?>

<body>
    <!-- Sidebar -->
    <?php
    $_SESSION["page"] = "step3";
    include("../sidebar.php");
    ?>
    <!-- Main Content -->
    <div class="dashboard">

        <div class="wrapper">

            <div id="content">
                <div class="container-fluid text-center">
                    <h3>INTERN FORM STEP 3</h3>
                </div>
                <div class="container-fluid text-start">
                    <h3>Documents (STEP 3)</h3>
                    <a href="<?= $data['step2_docs_link'] ?>" target="_blank" rel="noopener noreferrer">Submitted Documents G-Drive link for STEP 3</a>
                </div>

                <div class="form">
                    <div class="main-content">
                        <div class="form-groups">
                            <div class="heading-area text-center">
                                <h2>Complete Practicum application form</h2>
                            </div>
                        </div>
                        <input disabled class="form-input" type="hidden" name="user_id" id="user_id" required>

                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">First Name</label>

                                <input disabled value="<?= $data['pi_fname']; ?>" class="form-input container-fluid" type="text" name="pi_fname" id="pi_fname" required>
                            </div>
                            <div class="form-wrap">
                                <label class="fw-bold">Middle Name</label>
                                <input disabled value="<?= $data['pi_mname']; ?>" class="form-input container-fluid" type="text" name="pi_mname" id="pi_mname" required>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Last Name</label>
                                <input disabled value="<?= $data['pi_lname']; ?>" class="form-input" type="text" name="pi_lname" id="pi_lname" required>
                            </div>

                            <div class="form-wrap">

                                <label class="fw-bold">Department</label>
                                <input disabled value="<?= $data['pi_dept']; ?>" class="form-input" type="text" name="pi_lname" id="pi_lname" required>

                            </div>

                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Program</label>
                                <input disabled value="<?= $data['pi_course']; ?>" class="form-input" type="text" name="pi_lname" id="pi_lname" required>

                            </div>

                            <div class="form-wrap">

                                <label class="fw-bold">Year Level</label>
                                <input disabled value="<?= $data['pi_year_lv']; ?>" class="form-input" type="text" name="pi_lname" id="pi_lname" required>

                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Gender</label>
                                <input disabled value="<?= $data['pi_gender']; ?>" class="form-input" type="text" name="pi_lname" id="pi_lname" required>

                            </div>
                            <div class="form-wrap">
                                <label class="fw-bold">Age</label>
                                <input disabled value="<?= $data['pi_age'] ?>" class="form-input" type="number" maxlength='2' name="pi_age" id="pi_age" required>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">

                                <label class="fw-bold">Civil Status</label>
                                <input disabled value="<?= $data['pi_civil_status'] ?>" class="form-input">

                            </div>

                            <div class="date-wrap">
                                <label class="fw-bold">Birth Date</label>
                                <input disabled value="<?= $data['pi_bdate'] ?>" class="form-input" type="date" name="pi_bdate" id="pi_bdate" required>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Contact Number</label>
                                <input disabled value="<?= $data['pi_contact'] ?>" class="form-input" maxlength='11' type="number" name="pi_contact" id="pi_contact" required>
                            </div>
                            <div class="form-wrap">
                                <label class="email-label">Email Address</label>
                                <input disabled value="<?= $data['pi_email'] ?>" class="form-input email-input" type="text" name="pi_email" id="pi_email" required readonly>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Home Address</label>
                                <input disabled value="<?= $data['pi_address'] ?>" class="form-input" type="text" name="pi_address" id="pi_address" required>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="heading-area">
                                <h2>Practicum Training Details</h2>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Training Establishment</label>
                                <input disabled value="<?= $data['ptd_establishment'] ?>" class="form-input" type="text" name="ptd_establishment" id="ptd_establishment" required>
                            </div>
                            <div class="form-wrap">
                                <label class="fw-bold">Address</label>
                                <input disabled class="form-input" value="<?= $data['ptd_address'] ?>" type="text" name="ptd_address" id="ptd_address" required>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Contact Number (Optional)</label>
                                <input disabled class="form-input" maxlength='11' value="<?= $data['ptd_contact_number'] ?>" type="number" name="ptd_contact_number" id="ptd_contact_number">
                            </div>
                            <div class="form-wrap">
                                <label class="fw-bold">Duration of Training Hours</label>

                                <input disabled class="form-input" type="number" value="<?= $data['ptd_training_hrs'] ?>" name="ptd_training_hrs" id="ptd_training_hrs" required>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="date-wrap">
                                <label class="fw-bold">Start Date (Optional)</label>

                                <input disabled class="form-input from-date" type="date" value="<?= $data['ptd_start_date'] ?>" name="ptd_start_date" id="ptd_start_date">
                            </div>
                            <div class="date-wrap">
                                <label class="fw-bold">End Date (Optional)</label>

                                <input disabled class="form-input to-date" type="date" value="<?= $data['ptd_end_date'] ?>" name="ptd_end_date" id="ptd_end_date">
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="heading-area">
                                <h2>Contact Details in Case of Emergency</h2>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Full Name</label>

                                <input disabled class="form-input" type="text" value="<?= $data['cdi_name'] ?>" name="cdi_name" id="cdi_name" required>
                            </div>
                            <div class="form-wrap">
                                <label class="fw-bold">Relationship</label>

                                <input disabled class="form-input" type="text" value="<?= $data['cdi_relationship'] ?>" name="cdi_relationship" id="cdi_relationship" required>
                            </div>
                            <div class="form-wrap">
                                <label class="fw-bold">Contact Number</label>

                                <input disabled class="form-input" maxlength='11' type="number" value="<?= $data['cdi_contact'] ?>" name="cdi_contact" id="cdi_contact" required>

                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Home Address</label>

                                <input disabled class="form-input" type="text" name="cdi_address" value="<?= $data['cdi_address'] ?>" id="cdi_address" required>
                            </div>
                        </div>
                        <div class="form-groups">
                            <div class="form-wrap">
                                <label class="fw-bold">Company Address (Optional)</label>

                                <input disabled class="form-input" type="text" name="cdi_com_address" value="<?= $data['cdi_com_address'] ?>" id="cdi_com_address">
                            </div>
                        </div>
                        <div class="container-fluid pt-4 d-flex gap-2 justify-content-center align-items center">
                            <button id="reject" data-id="<?= $data['application_id'] ?>" class="btn px-5 btn-lg btn-danger">Reject Form</button>
                            <button id="approve" data-id="<?= $data['application_id'] ?>" class="btn px-5 btn-lg btn-success">Verify Form</button>
                        </div>
                </d>
            </div>

        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fetchPrograms() {
            const department = document.getElementById('pi_dept').value;

            // Make an AJAX request to fetch the programs based on the selected department
            $.ajax({
                url: './fetch_programs.php', // The PHP file to handle the request
                method: 'POST',
                data: {
                    dept: department
                },
                success: function(response) {
                    // Populate the pi_course dropdown
                    document.getElementById('pi_course').innerHTML = response;

                    // Set the selected value for pi_course if it exists
                    const selectedCourse = "<?= $data['pi_course']; ?>"; // The selected course from the database
                    if (selectedCourse) {
                        document.getElementById('pi_course').value = selectedCourse;
                    }
                },
                error: function() {
                    alert('Error fetching programs.');
                }
            });
        }
    </script>
    <script>
        $('#approve').on('click', function() {
            const announcementId = $(this).data('id'); // Get the announcement ID from the button's data-id attribute

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, approved it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete.php with the announcement ID
                    window.location.href = `edit.php?id=${announcementId}&status=PENDING`;
                }
            });
        })
        $('#reject').on('click', function() {
            const announcementId = $(this).data('id'); // Get the announcement ID from the button's data-id attribute

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, approved it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete.php with the announcement ID
                    window.location.href = `edit.php?id=${announcementId}&status=REJECTED`;
                }
            });
        })
    </script>
    <script>
        // Get the current year
        let currentYear = new Date().getFullYear();
        let startYearSelect = document.getElementById('start_year');
        let endYearSelect = document.getElementById('end_year');

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

        // Set the start year from the database (pre-select)
        const selectedStartYear = "<?= $data['start_date']; ?>"; // Get the start year from the database
        if (selectedStartYear) {
            startYearSelect.value = selectedStartYear;
            populateEndYear(); // Re-populate the end year dropdown based on the selected start year
        }

        // Set the end year from the database (pre-select)
        const selectedEndYear = "<?= $data['end_date']; ?>"; // Get the end year from the database
        if (selectedEndYear) {
            endYearSelect.value = selectedEndYear;
        }

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
                const requiredFields = form.querySelectorAll("[required]");
                requiredFields.forEach((field) => {
                    if (!field.value.trim()) {
                        isValid = false;
                        showError(field, "This field is required.");
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