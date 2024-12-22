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
$assigned_meal_plan = "";

// Check if a meal plan already exists for this user
$query = "SELECT * FROM meal_plans WHERE email = '$email' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $assigned_meal_plan = $row['meal_plan'];
    $feedback = "Your current meal plan is displayed below.";
} else {
    $feedback = "No meal plan assigned yet. Please fill out the form to generate one.";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $goal = $_POST['goal'];
    $activity_level = $_POST['activity_level'];

    // Define meal plans based on goal and activity level
    $meal_plans = [
        "weight_loss" => [
            "sedentary" => "Low-calorie meal plan with balanced protein and greens.",
            "lightly_active" => "Low-calorie meals with moderate carbs and high protein.",
            "moderately_active" => "Balanced meals with reduced carbs and moderate protein.",
            "very_active" => "Low-calorie meals with increased protein for energy.",
        ],
        "muscle_gain" => [
            "sedentary" => "High-protein, low-carb meals tailored for recovery.",
            "lightly_active" => "High-protein meals with healthy fats and moderate carbs.",
            "moderately_active" => "High-protein and carb-rich meals for muscle building.",
            "very_active" => "High-protein, high-carb meals for intense training.",
        ],
        "maintenance" => [
            "sedentary" => "Balanced meals with controlled portions.",
            "lightly_active" => "Balanced meals with slightly increased protein.",
            "moderately_active" => "Slightly higher protein and carb intake for activity.",
            "very_active" => "Balanced meals with additional carbs for energy.",
        ]
    ];

    // Assign a meal plan
    $assigned_meal_plan = $meal_plans[$goal][$activity_level];

    // Save the assigned meal plan and user details to the database
    $query = "INSERT INTO meal_plans (email, age, gender, goal, activity_level, meal_plan) 
              VALUES ('$email', $age, '$gender', '$goal', '$activity_level', '$assigned_meal_plan')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $feedback = "Meal plan assigned successfully!";
    } else {
        $feedback = "Error assigning meal plan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Plans | ST Power Zone</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link your existing CSS -->
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <img src="images/385699149_285353547631802_887358169895654602_n-removebg-preview.png" alt="ST Power Zone GYM Logo">
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
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
        <h1 class="page-title">Assign Meal Plans</h1>
        <p>Logged in as: <strong><?php echo htmlspecialchars($email); ?></strong></p>

        <!-- Display the assigned meal plan -->
        <?php if (!empty($assigned_meal_plan)) { ?>
            <br><br>
            <div class="meal-plan-result">
                <h2>Current Meal Plan:</h2><br><br>
                <p><?php echo htmlspecialchars($assigned_meal_plan); ?></p>
                <p><strong>Feedback:</strong> <?php echo htmlspecialchars($feedback); ?></p>
            </div>
            <br><br><br><br>
        <?php } ?>

        <!-- Form to collect gym member data -->
        <h2>Generate a New Meal Plan:</h2>
        <form action="meal_plan.php" method="post">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="goal">Fitness Goal:</label>
            <select id="goal" name="goal" required>
                <option value="weight_loss">Weight Loss</option>
                <option value="muscle_gain">Muscle Gain</option>
                <option value="maintenance">Maintenance</option>
            </select>

            <label for="activity_level">Activity Level:</label>
            <select id="activity_level" name="activity_level" required>
                <option value="sedentary">Sedentary</option>
                <option value="lightly_active">Lightly Active</option>
                <option value="moderately_active">Moderately Active</option>
                <option value="very_active">Very Active</option>
            </select>

            <button type="submit">Generate Meal Plan</button>
        </form>
    </div>
    <br><br>

    <?php include('footer.php'); // Include the footer ?>
</body>
</html>
