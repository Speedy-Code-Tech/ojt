<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>


</head>
<?php
include_once('step1.php');
include_once('after1.php');

// Query to get the latest announcement from the database
$query = "SELECT * FROM announcement ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

// Check if there is a result
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the latest announcement
    $announcement = mysqli_fetch_assoc($result);
} else {
    // No announcements found
    $announcement = null;
}

$id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE user_id = $id";
$user = mysqli_query($conn, $query);

// Check if there is a result
if ($user && mysqli_num_rows($user) > 0) {
    $data = mysqli_fetch_assoc($user);
} else {
    $data = null;
}
$dept = $data['department'];
$program = $data['program'];
$intern = $conn->query("SELECT * FROM user WHERE type='intern' AND department = '$dept' AND program ='$program'");

$intern_count = 0;
while ($row = mysqli_fetch_assoc($intern)) {
    $intern_count = $intern_count + 1;
}

$tables = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 1 AND pi_dept = '$dept'");

$count = 0;
while ($row = mysqli_fetch_assoc($tables)) {
    $count = $count + 1;
}

$tables1 = $conn->query("SELECT * FROM application_table WHERE after_ojt_status = 'PENDING' AND after_ojt_steps = 3 AND pi_course = '$program'");


$count1 = 0;
while ($row = mysqli_fetch_assoc($tables1)) {
    $count1 = $count1 + 1;
}
?>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="#" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="view.php"><i class="fa-solid fa-paperclip"></i> Before OJT Step 5 <span class="badge bg-danger"><?=$count?></span></a>
        <a href="after.php"><i class="fa-solid fa-paperclip"></i> After OJT Step 2 <span class="badge bg-danger"><?=$count1?></span></a>
        <a href="intern_history/view.php"><i class="fa-solid fa-users"></i> Intern History</a>
        <a href="history/view.php"><i class="fa-solid fa-users"></i> View History</a>
        
        <a href="../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <i class="h2 fa-solid fa-users"></i>
                    <h5>Total Intern Accounts</h5>
                    <h2><?=$intern_count?></h2>
                </div>
            </div>
        </div>

        <div class="announcement">
        <h2>Announcements</h2>
        <?php if($announcement){?>
            <div>
                <span class="fw-bold">Date Announced:</span> <?php echo date("F d, Y", strtotime($announcement['date_created'])); ?>
            </div>
            <p class="ps-5 pt-3"><?=$announcement['message'];?></p>
            <?php } else { ?>
                <p class="container-fluid ps-5 pt-3 text-warning text-warning">----- No Annnouncement Today -----</p>

            <?php } ?>
        </div>

        <hr>
        <div class="container-fluid d-flex flex-column gap-5 pt-5 mt-5">
            <div class="container-fluid d-flex gap-3">
                <div class="col">
                    <h4 class="text-center">Before OJT Step 1 Intern Process</h4>
                    <canvas id="step1Chart" data-approve="<?=$approve?>" data-pending="<?=$pending?>" data-decline="<?=$decline?>"></canvas>
                </div>
                <div class="col">
                    <h4 class="text-center">Before OJT Step 2 Intern Process</h4>
                    <canvas id="step2Chart" data-approve="<?=$approve2?>" data-pending="<?=$pending2?>" data-decline="<?=$decline2?>"></canvas>
                </div>
            </div>
            <div class="container-fluid d-flex gap-3">
                <div class="col">
                    <h4 class="text-center">Before OJT Step 3 Intern Process</h4>
                    <canvas id="step3Chart" data-approve="<?=$approve3?>" data-pending="<?=$pending3?>" data-decline="<?=$decline3?>"></canvas>
                </div>
                <div class="col">
                    <h4 class="text-center">Before OJT Step 4 Intern Process</h4>
                    <canvas id="step4Chart" data-approve="<?=$approve4?>" data-pending="<?=$pending4?>" data-decline="<?=$decline4?>"></canvas>
                </div>
            </div>
            <div class="container-fluid d-flex gap-3">
                <div class="col">
                    <h4 class="text-center">Before OJT Step 5 Intern Process</h4>
                    <canvas width="50%" id="step5Chart" data-approve="<?=$approve5?>" data-pending="<?=$pending5?>" data-decline="<?=$decline5?>"></canvas>
                </div>
                <div class="col">
                    <h4 class="text-center">After OJT Step 1 Intern Process</h4>
                    <canvas width="50%" id="afterstep1Chart" data-approve="<?= $afterapprove ?>" data-pending="<?= $afterpending ?>" data-decline="<?= $afterdecline ?>"></canvas>
                </div>


            </div>
            <div class="container-fluid d-flex gap-3">
                <div class="col">
                    <h4 class="text-center">After OJT Step 2 Intern Process</h4>
                    <canvas width="50%" id="afterstep2Chart" data-approve="<?= $afterapprove2 ?>" data-pending="<?= $afterpending2 ?>" data-decline="<?= $afterdecline2 ?>"></canvas>
                </div>
                <div class="col">
                    <h4 class="text-center">After OJT Step 3 Intern Process</h4>
                    <canvas width="50%" id="afterstep3Chart" data-approve="<?= $afterapprove3 ?>" data-pending="<?= $afterpending3 ?>" data-decline="<?= $afterdecline3 ?>"></canvas>
                </div>


            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const step1Canvas = document.getElementById('step1Chart');

     // Fetch data from data attributes
     const approveCount = parseInt(step1Canvas.getAttribute('data-approve'), 10) || 0;
    const pendingCount = parseInt(step1Canvas.getAttribute('data-pending'), 10) || 0;
    const declineCount = parseInt(step1Canvas.getAttribute('data-decline'), 10) || 0;

    // Data for the chart
    const step1Data = {
        labels: ['ACCEPTED', 'REJECTED', 'PENDING'],
        datasets: [
            {
                label: 'Status',
                data: [approveCount, declineCount, pendingCount],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                borderWidth: 1
            }
        ]
    };
    // Options for the chart
    const step1Options = {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Before OJT Step 1 Intern Process'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };

    // Render the chart
    const ctx = document.getElementById('step1Chart').getContext('2d');
    const step1Chart = new Chart(ctx, {
        type: 'bar', // You can change this to 'pie' or 'doughnut' if preferred
        data: step1Data,
        options: step1Options
    });
</script>

<script>
    const step2Canvas = document.getElementById('step2Chart');

     // Fetch data from data attributes
     const approveCount2 = parseInt(step2Canvas.getAttribute('data-approve'), 10) || 0;
    const pendingCount2 = parseInt(step2Canvas.getAttribute('data-pending'), 10) || 0;
    const declineCount2 = parseInt(step2Canvas.getAttribute('data-decline'), 10) || 0;
    // Data for the chart
    const step2Data = {
        labels: ['ACCEPTED', 'REJECTED', 'PENDING'],
        datasets: [
            {
                label: 'Status',
                data: [approveCount2, declineCount2, pendingCount2],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                borderWidth: 1
            }
        ]
    };
    // Options for the chart
    const step2Options = {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Before OJT Step 2 Intern Process'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };

    // Render the chart
    const ctx2 = document.getElementById('step2Chart').getContext('2d');
    const step2Chart = new Chart(ctx2, {
        type: 'bar', // You can change this to 'pie' or 'doughnut' if preferred
        data: step2Data,
        options: step2Options
    });
</script>

<script>
    const step3Canvas = document.getElementById('step3Chart');

     // Fetch data from data attributes
     const approveCount3 = parseInt(step3Canvas.getAttribute('data-approve'), 10) || 0;
    const pendingCount3 = parseInt(step3Canvas.getAttribute('data-pending'), 10) || 0;
    const declineCount3 = parseInt(step3Canvas.getAttribute('data-decline'), 10) || 0;
    // Data for the chart
    const step3Data = {
        labels: ['ACCEPTED', 'REJECTED', 'PENDING'],
        datasets: [
            {
                label: 'Status',
                data: [approveCount3, declineCount3, pendingCount3],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                borderWidth: 1
            }
        ]
    };
    // Options for the chart
    const step3Options = {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Before OJT Step 3 Intern Process'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };

    // Render the chart
    const ctx3 = document.getElementById('step3Chart').getContext('2d');
    const step3Chart = new Chart(ctx3, {
        type: 'bar', // You can change this to 'pie' or 'doughnut' if preferred
        data: step3Data,
        options: step3Options
    });
</script>

<script>
    const step4Canvas = document.getElementById('step4Chart');

     // Fetch data from data attributes
     const approveCount4 = parseInt(step4Canvas.getAttribute('data-approve'), 10) || 0;
    const pendingCount4 = parseInt(step4Canvas.getAttribute('data-pending'), 10) || 0;
    const declineCount4 = parseInt(step4Canvas.getAttribute('data-decline'), 10) || 0;
    // Data for the chart
    const step4Data = {
        labels: ['ACCEPTED', 'REJECTED', 'PENDING'],
        datasets: [
            {
                label: 'Status',
                data: [approveCount4, declineCount4, pendingCount4],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                borderWidth: 1
            }
        ]
    };
    // Options for the chart
    const step4Options = {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Before OJT Step 4 Intern Process'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };

    // Render the chart
    const ctx4 = document.getElementById('step4Chart').getContext('2d');
    const step4Chart = new Chart(ctx4, {
        type: 'bar', // You can change this to 'pie' or 'doughnut' if preferred
        data: step4Data,
        options: step4Options
    });
</script>

<script>
    const step5Canvas = document.getElementById('step5Chart');

     // Fetch data from data attributes
     const approveCount5 = parseInt(step5Canvas.getAttribute('data-approve'), 10) || 0;
    const pendingCount5 = parseInt(step5Canvas.getAttribute('data-pending'), 10) || 0;
    const declineCount5 = parseInt(step5Canvas.getAttribute('data-decline'), 10) || 0;
    // Data for the chart
    const step5Data = {
        labels: ['ACCEPTED', 'REJECTED', 'PENDING'],
        datasets: [
            {
                label: 'Status',
                data: [approveCount5, declineCount5, pendingCount5],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                borderWidth: 1
            }
        ]
    };
    // Options for the chart
    const step5Options = {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Before OJT Step 5 Intern Process'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    };

    // Render the chart
    const ctx5 = document.getElementById('step5Chart').getContext('2d');
    const step5Chart = new Chart(ctx5, {
        type: 'bar', // You can change this to 'pie' or 'doughnut' if preferred
        data: step5Data,
        options: step5Options
    });
</script>
<!-- AFTER SCRIPT -->
<script>
        const afterstepCanvas = document.getElementById('afterstep1Chart');

        // Fetch data from data attributes
        const afterapproveCount = parseInt(afterstepCanvas.getAttribute('data-approve'), 10) || 0;
        const afterpendingCount = parseInt(afterstepCanvas.getAttribute('data-pending'), 10) || 0;
        const afterdeclineCount = parseInt(afterstepCanvas.getAttribute('data-decline'), 10) || 0;
        // Data for the chart
        const afterstepData = {
            labels: ['ACCEPTED', 'REJECTED', 'PENDING'],
            datasets: [{
                label: 'Status',
                data: [afterapproveCount, afterdeclineCount, afterpendingCount],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                borderWidth: 1
            }]
        };
        // Options for the chart
        const afterstep1Options = {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'After OJT Step 1 Intern Process'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        };

        // Render the chart
        const afterctx = document.getElementById('afterstep1Chart').getContext('2d');
        const afterstep1Chart = new Chart(afterctx, {
            type: 'bar', // You can change this to 'pie' or 'doughnut' if preferred
            data: afterstepData,
            options: afterstep1Options
        });
    </script>

<script>
        const afterstepCanvas2 = document.getElementById('afterstep2Chart');

        // Fetch data from data attributes
        const afterapproveCount2 = parseInt(afterstepCanvas2.getAttribute('data-approve'), 10) || 0;
        const afterpendingCount2 = parseInt(afterstepCanvas2.getAttribute('data-pending'), 10) || 0;
        const afterdeclineCount2 = parseInt(afterstepCanvas2.getAttribute('data-decline'), 10) || 0;
        // Data for the chart
        const afterstepData2 = {
            labels: ['ACCEPTED', 'REJECTED', 'PENDING'],
            datasets: [{
                label: 'Status',
                data: [afterapproveCount2, afterdeclineCount2, afterpendingCount2],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                borderWidth: 1
            }]
        };
        // Options for the chart
        const afterstep2Options = {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'After OJT Step 2 Intern Process'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        };

        // Render the chart
        const afterctx2 = document.getElementById('afterstep2Chart').getContext('2d');
        const afterstep2Chart = new Chart(afterctx2, {
            type: 'bar', // You can change this to 'pie' or 'doughnut' if preferred
            data: afterstepData2,
            options: afterstep2Options
        });
    </script>

<script>
        const afterstepCanvas3 = document.getElementById('afterstep3Chart');

        // Fetch data from data attributes
        const afterapproveCount3 = parseInt(afterstepCanvas3.getAttribute('data-approve'), 10) || 0;
        const afterpendingCount3 = parseInt(afterstepCanvas3.getAttribute('data-pending'), 10) || 0;
        const afterdeclineCount3 = parseInt(afterstepCanvas3.getAttribute('data-decline'), 10) || 0;
        // Data for the chart
        const afterstepData3 = {
            labels: ['ACCEPTED', 'REJECTED', 'PENDING'],
            datasets: [{
                label: 'Status',
                data: [afterapproveCount3, afterdeclineCount3, afterpendingCount3],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                borderWidth: 1
            }]
        };
        // Options for the chart
        const afterstep3Options = {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'After OJT Step 3 Intern Process'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        };

        // Render the chart
        const afterctx3 = document.getElementById('afterstep3Chart').getContext('2d');
        const afterstep3Chart = new Chart(afterctx3, {
            type: 'bar', // You can change this to 'pie' or 'doughnut' if preferred
            data: afterstepData3,
            options: afterstep3Options
        });
    </script>
</body>

</html>