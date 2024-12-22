<?php
session_start();
?>
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