<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORGOT PASSWORD - OJT SYSTEM</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Include jQuery -->
</head>

<body>
    <div class="login-box">
        <div style="width: 100%;" class="d-flex justify-content-center align-items-center">
            <img src="assets/img/logo.png" alt="">
        </div>
        <div class="right-box">
            <div class="box">
                <h2 class="text-white">FORGOT PASSWORD</h2>
                <div class="form-container">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="juan@lsu.edu.ph"
                        title="Must be a valid LSU email (e.g., juan@lsu.edu.ph)">
                    <div class="note">Must be LSU email</div>
                    <span id="emailError" class="text-danger"></span> <!-- Error message for email -->
                    <br>
                    <button onclick="sendmail()" class="btn btn-light mt-4 px-5">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

    <script>
        // EmailJS initialization
        (function() {
            emailjs.init({
                publicKey: "S1FtNxV2rLYANKTgj", // Your public key
            });
        })();

        function sendmail() {
            const email = document.getElementById('email').value;

            // Generate a random password
            const randomPassword = Math.random().toString(36).slice(-8); // Generates an 8-character password

            // Prepare parameters for EmailJS
            let params = {
                from_name: "TECHNICAL OF LA SALLE UNIVERSITY",  // Your email address
                to_name: email,  // User's email
                message: randomPassword,
            };

            // Send the email
            emailjs.send('service_e5jiq55', 'template_g38oro9', params).then((result) => {
                // Alert success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Password reset email sent successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // After success, save the new password in the database
                    saveNewPassword(email, randomPassword);
                });
            }).catch((err) => {
                console.log(err);
                Swal.fire('Error', 'Failed to send email. Please try again.', 'error');
            });
        }

        function saveNewPassword(email, newPassword) {
            // Send the new password to PHP to save it in the database
            $.ajax({
                url: 'save_password.php',  // The PHP file that will save the new password
                type: 'POST',
                data: {
                    email: email,
                    password: newPassword
                },
                success: function(response) {
                    console.log('Password updated in the database');
                    // Redirect to index.js or index.html after success
                    window.location.href = 'index.php'; // Or use 'index.html' if it's an HTML file
                },
                error: function(err) {
                    Swal.fire({
                    title: 'Oops!',
                    text: 'Something went wrong.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                    console.log('Error saving password:', err);
                }
            });
        }
    </script>

</body>

</html>
