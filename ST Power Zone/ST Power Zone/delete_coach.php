<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the image path from the database
    $sql = "SELECT image_path FROM coaches WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $image_path = $row['image_path'];

    // Delete the coach from the database
    $sql = "DELETE FROM coaches WHERE id = $id";
    if ($conn->query($sql)) {
        // Remove the image file from the server
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        echo "<script>alert('Coach deleted successfully!'); window.location.href='manage_coaches.php';</script>";
    } else {
        echo "<script>alert('Error: Could not delete coach.'); window.location.href='manage_coaches.php';</script>";
    }
}
?>
