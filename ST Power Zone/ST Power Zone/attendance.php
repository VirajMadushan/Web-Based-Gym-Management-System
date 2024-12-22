<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login if user is not logged in
    exit();
}

// Database connection
include 'db_connect.php';

$user_email = $_SESSION['email']; // Get the logged-in user's email

// Handle attendance form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mark_attendance'])) {
    $attendance_date = date('Y-m-d'); // Mark attendance for today's date
    $status = 'Present'; // Default status when marking attendance

    // Check if attendance is already marked for today
    $check_sql = "SELECT * FROM attendance WHERE user_email = ? AND attendance_date = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param('ss', $user_email, $attendance_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert attendance for today
        $insert_sql = "INSERT INTO attendance (user_email, attendance_date, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param('sss', $user_email, $attendance_date, $status);
        $stmt->execute();

        echo "<script>alert('Attendance marked for today!');</script>";
    } else {
        echo "<script>alert('Attendance already marked for today!');</script>";
    }
}

// Fetch attendance data for calendar display
$sql = "SELECT attendance_date, status FROM attendance WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_email);
$stmt->execute();
$result = $stmt->get_result();

// Initialize attendance data array for FullCalendar
$attendance_data = [];

while ($row = $result->fetch_assoc()) {
    $attendance_data[] = [
        'title' => $row['status'],  // 'Present' or 'Absent'
        'start' => $row['attendance_date'],  // Date to highlight on calendar
        'color' => $row['status'] == 'Present' ? 'green' : 'red',  // Green for Present, Red for Absent
    ];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Calendar</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
</head>
<body><nav class="navbar">
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


    <main>
    <br>           
    <h1><center>Attendance Calendar</center></h1><br><br>

    <div id="attendanceCalendar"></div>

    <!-- Form to mark attendance -->
    <form method="POST" class="attendance-form">
        <center><button type="submit" name="mark_attendance">Mark Attendance for Today</button></center>
    </form>
    </main> 

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

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('attendanceCalendar');

            // Initialize FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Month view
                events: <?php echo json_encode($attendance_data); ?>, // Load events (attendance data)
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventColor: 'green',
                eventTextColor: 'white'
            });

            // Render the calendar
            calendar.render();
        });
    </script>

</body>
</html>
