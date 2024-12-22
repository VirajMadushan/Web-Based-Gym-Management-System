<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ST Power Zone GYM</title>
    <link rel="stylesheet" href="css/styles.css">
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

    <section id="home">
        <h1>Welcome to ST Power Zone GYM</h1>
        <?php if (isset($_SESSION['email'])): ?>
            <p>Hello, <?php echo $_SESSION['name']; ?>! You are logged in.</p>
        <?php else: ?>
            <p>Please <a href="login.php">login</a> to access more features.</p>
        <?php endif; ?>
    </section>

    <main>
    <section id="home" class="section home">
        <div class="overlay">
        <div class="hero">

            <video autoplay loop muted plays-inline class="backvideo">
                <source src="images/gymvid.mp4" type="video/mp4">`
            </video>
        </div>

            <img src="images/385699149_285353547631802_887358169895654602_n-removebg-preview.png" alt="Gallery Cafe Logo" class="logo">
        </div>
    </section>
        <!-- Other sections like attendance, schedule, etc. -->
    </main>

    <!-- Other sections... -->
    <!-- Footer Section -->

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-left">
                <h3>ST Power Zone GYM</h3>
                <p>
                    <strong>Address:</strong>8HQ4+V62, Hedeniya<br>
                    <strong>Phone:</strong> 0770 053 935<br>
                    <strong>Email:</strong> info@stpowerzonegym.com
                </p>
            </div>
            <div class="footer-right">
                <h3>Location</h3>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.12693441351!2d80.5529995745817!3d7.339639392668913!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae343144081322b%3A0xbbd24fe9d63c1550!2sST%20Power%20Zone!5e0!3m2!1sen!2slk!4v1728179777309!5m2!1sen!2slk" 
                    height="200" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </footer>


</body>
</html>
