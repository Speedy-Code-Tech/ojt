<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN - OJT SYSTEM</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert -->
</head>

<?php
if(session_status() == PHP_SESSION_NONE) session_start();
?>

<body>
    <div class="login-box">
        <div style="width: 100%;" class="d-flex justify-content-center align-items-center">
            <img src="assets/img/logo.png" alt="">
        </div>
        <div class="right-box">
            <div class="box">
                <h2 class="text-white">LOGIN</h2>
                <form class="form-container" method="post" action="backend/login.php" onsubmit="return validateForm()">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="juan@lsu.edu.ph"
                        pattern="^[a-zA-Z0-9._%+-]+@lsu\.edu\.ph$" title="Must be a valid LSU email (e.g., juan@lsu.edu.ph)">
                    <div class="note">Must be LSU email</div>
                    <span id="emailError" class="text-danger"></span> <!-- Error message for email -->

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="**********">
                    <span id="passwordError" class="text-danger"></span> <!-- Error message for password -->

                    <a href="#">Forgot password?</a>
                    <br>
                    <button class="btn btn-light mt-4 px-5">Login</button>
                    <div class="container-fluid text-center px-3">
                        <hr>
                    </div>
                    <p class="text-center text-white p-0 m-0">Don't have an Account? <a href="register.php" class="fw-bold p-0 m-0" style="text-decoration: none; color:#0CFF75;"> Register Here</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Check if the session variable 'success' is set
        <?php if (isset($_SESSION['success'])): ?>
            Swal.fire({
                icon: 'success',
                title: '<?= $_SESSION['success'] ?>',
                showConfirmButton: false,
                timer: 3000
            });
            <?php unset($_SESSION['success']); ?> <!-- Clear session success after showing the message -->
        <?php endif; ?>

        // Display error message if set in the session
        <?php if (isset($_SESSION['login_error'])): ?>
            // Display the error message for the login failure
            document.getElementById('emailError').textContent = '<?= $_SESSION['login_error'] ?>';
            <?php unset($_SESSION['login_error']); ?> <!-- Clear session error after showing the message -->
        <?php endif; ?>

        // Form validation
        function validateForm() {
            let valid = true;
            // Reset previous error messages
            document.getElementById('emailError').textContent = '';
            document.getElementById('passwordError').textContent = '';

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@lsu\.edu\.ph$/;

            // Email validation
            if (!email) {
                document.getElementById('emailError').textContent = 'Email is required.';
                valid = false;
            } else if (!emailPattern.test(email)) {
                document.getElementById('emailError').textContent = 'Please enter a valid LSU email (e.g., juan@lsu.edu.ph).';
                valid = false;
            }

            // Password validation
            if (!password) {
                document.getElementById('passwordError').textContent = 'Password is required.';
                valid = false;
            }

            return valid;
        }
    </script>
</body>

</html>
