<?php
// Include the database connection and session management files
include('db_connect.php');
session_start();

// Ensure the user is logged in; otherwise, redirect to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in user's email
$email = $_SESSION['email'];

// Initialize variables for feedback
$feedback = "";
$assigned_workout_plan = "";

// Check if a workout plan already exists for this user
$query = "SELECT * FROM workout_plans WHERE email = '$email' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $assigned_workout_plan = $row['workout_plan'];
    $feedback = "Your current workout plan is displayed below.";
} else {
    $feedback = "No workout plan assigned yet. Please fill out the form to generate one.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $goal = $_POST['goal'];
    $experience_level = $_POST['experience_level'];

    $workout_plans = [
        "weight_loss" => [
            "beginner" => "Low-intensity cardio and bodyweight exercises.",
            "intermediate" => "Moderate cardio with resistance training.",
            "advanced" => "High-intensity interval training (HIIT) and strength training.",
        ],
        "muscle_gain" => [
            "beginner" => "Basic resistance training with bodyweight exercises.",
            "intermediate" => "Structured strength training with moderate weights.",
            "advanced" => "Advanced hypertrophy training with heavy weights.",
        ],
        "maintenance" => [
            "beginner" => "Light cardio and mobility exercises.",
            "intermediate" => "Balanced workout including cardio and weights.",
            "advanced" => "Customized program to sustain fitness levels.",
        ]
    ];

    $assigned_workout_plan = $workout_plans[$goal][$experience_level];

    $query = "INSERT INTO workout_plans (email, age, gender, goal, experience_level, workout_plan) 
              VALUES ('$email', $age, '$gender', '$goal', '$experience_level', '$assigned_workout_plan')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $feedback = "Workout plan assigned successfully!";
    } else {
        $feedback = "Error assigning workout plan: " . mysqli_error($conn);
    }
}

// Progress tracking logic
$progress_message = "";
$progress_percent = 0;

// Calculate attendance within the last 45 days
$attendance_query = "
    SELECT COUNT(*) AS attendance_count
    FROM attendance
    WHERE user_email = '$email'
      AND attendance_date >= DATE_SUB(CURDATE(), INTERVAL 45 DAY)
      AND status = 'present'";
$attendance_result = mysqli_query($conn, $attendance_query);

if ($attendance_result) {
    $attendance_data = mysqli_fetch_assoc($attendance_result);
    $attendance_count = $attendance_data['attendance_count'];
    $progress_percent = min(100, ($attendance_count / 30) * 100);

    if ($attendance_count >= 30) {
        $progress_message = "Congratulations! You have successfully completed the schedule.";
    } else {
        $progress_message = "Keep going! You have not yet completed the schedule.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Plans | ST Power Zone</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .progress-bar {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 25px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar-inner {
            height: 20px;
            background-color: crimson;
            width: <?php echo $progress_percent; ?>%
        }
    </style>
</head>
<body>
<nav class="navbar">
<div class="logo">
            <img src="images/385699149_285353547631802_887358169895654602_n-removebg-preview.png" alt="ST Power Zone GYM Logo">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="attendance.php">Attendance</a></li>
            <li><a href="workout_plan.php">Gym Schedule</a></li>
            <li><a href="meal_plan.php">Meal Plan</a></li>
            <li><a href="coaches.php">Coaches</a></li>
            <li><a href="store.php">Store</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <?php if (isset($_SESSION['email'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
</nav>

<div class="container">
    <h1 class="page-title">Assign Workout Plans</h1>
    <p>Logged in as: <strong><?php echo htmlspecialchars($email); ?></strong></p>

    <!-- Display the assigned workout plan -->
    <?php if (!empty($assigned_workout_plan)) { ?>
        <div class="workout-plan-result">
            <h2>Current Workout Plan:</h2>
            <p><?php echo htmlspecialchars($assigned_workout_plan); ?></p>
            <p><strong>Feedback:</strong> <?php echo htmlspecialchars($feedback); ?></p>
        </div>
    <?php } ?>

    <!-- Display progress -->
    <h2>Progress Tracker</h2>
    <div class="progress-bar">
        <div class="progress-bar-inner"></div>
    </div>
    <p><?php echo $progress_message; ?></p>

    <!-- Form to generate new workout plan -->
    <h2>Generate a New Workout Plan:</h2>
    <form action="workout_plan.php" method="post">
        <!-- Form fields -->
        <button type="submit">Generate Workout Plan</button>
    </form>
</div>

<?php include('footer.php'); ?>
</body>
</html>
