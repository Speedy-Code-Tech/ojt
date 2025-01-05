<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER - OJT SYSTEM</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .box1 {
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once("backend/db_connect.php");

$dept = $conn->query("SELECT * FROM department");
$program = $conn->query("SELECT * FROM programs");

// Retrieve errors and old input
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

// Clear session errors and old input
unset($_SESSION['errors'], $_SESSION['old']);
?>
<body>
    <div class="login-box">
        <div style="width: 100%;" class="d-flex justify-content-center align-items-center">
            <img src="assets/img/logo.png" alt="">
        </div>
        <div class="right-box">
            <div class="box1 py-3">
                <h2 class="">REGISTER</h2>
                <form class="form-container" method="post" action="backend/register.php">
                    <label for="email">Email</label>
                    <input type="text" required id="email" class="m-0" name="email" placeholder="juan@lsu.edu.ph"
                        pattern="^[a-zA-Z0-9._%+-]+@lsu\.edu\.ph$"
                        title="Must be a valid LSU email (e.g., juan@lsu.edu.ph)"
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                    <?php if (isset($errors['email'])): ?>
                        <span class="error-message"><?= htmlspecialchars($errors['email']) ?></span>
                    <?php endif; ?>

                    <label for="password">Password</label>
                    <input type="password" required id="password"class="m-0" name="password" placeholder="**********">
                    <?php if (isset($errors['password'])): ?>
                        <span class="error-message"><?= htmlspecialchars($errors['password']) ?></span>
                    <?php endif; ?>

                    <label for="confirmpassword">Confirm Password</label>
                    <input type="password" required id="confirmpassword"class="m-0" name="confirmpassword" placeholder="**********">

                    <label for="department">Department</label>
                    <select name="department" id="department" class="form-control m-0">
                        <option value="" disabled selected>Select Department</option>
                        <?php while ($row = $dept->fetch_assoc()): ?>
                            <option value="<?= $row['dept']; ?>" <?= isset($old['department']) && $old['department'] === $row['dept'] ? 'selected' : '' ?>>
                                <?= $row['dept']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <?php if (isset($errors['department'])): ?>
                        <span class="error-message"><?= htmlspecialchars($errors['department']) ?></span>
                    <?php endif; ?>

                    <label for="program">Program</label>
                    <select name="program" id="program" class="form-control m-0">
                        <option value="" disabled selected>Select Program</option>
                    </select>
                    <?php if (isset($errors['program'])): ?>
                        <span class="error-message"><?= htmlspecialchars($errors['program']) ?></span>
                    <?php endif; ?>

                    <br>
                    <button class="btn btn-light px-5">Register</button>
                    <div class="container-fluid text-center px-3">
                        <hr>
                    </div>
                    <p class="text-center text-white p-0 m-0">Already have an Account? <a href="index.php" class="fw-bold p-0 m-0" style="text-decoration: none; color:#0CFF75;">Sign In Here</a></p>
                </form>
            </div>
        </div>
    </div>
    <script>
        const departmentDropdown = document.getElementById('department');
        const programDropdown = document.getElementById('program');

        departmentDropdown.addEventListener('change', function () {
            const departmentId = this.value;

            // Clear current program options
            programDropdown.innerHTML = '<option value="" disabled selected>Loading...</option>';

            // Fetch programs via AJAX
            fetch('fetchProgram.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `department=${departmentId}`
            })
                .then(response => response.json())
                .then(data => {
                    programDropdown.innerHTML = '<option value="" disabled selected>Select Program</option>';
                    data.forEach(program => {
                        const option = document.createElement('option');
                        option.value = program.programs;
                        option.textContent = program.programs;
                        programDropdown.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching programs:', error);
                    programDropdown.innerHTML = '<option value="" disabled>Error loading programs</option>';
                });
        });
    </script>
</body>

</html>
