<?php
include 'db_connect.php'; // Database connection
include 'header.php'; // Header file

if (isset($_GET['email'])) {
    $email = $conn->real_escape_string($_GET['email']); // Sanitize email input

    // SQL to delete the user
    $delete_sql = "DELETE FROM user WHERE email = '$email'";
    if ($conn->query($delete_sql)) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $conn->error . "');</script>";
    }

    // Redirect back to manage users
    header("Location: manage_users.php");
    exit();
} else {
    echo "<script>alert('Invalid request!');</script>";
    header("Location: manage_users.php");
    exit();
}
?>
