<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the image path from the database
    $sql = "SELECT image_path FROM gallery_images WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $image_path = $row['image_path'];

    // Delete the image from the database
    $sql = "DELETE FROM gallery_images WHERE id = $id";
    if ($conn->query($sql)) {
        // Delete the image file from the server
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        echo "<script>alert('Image deleted successfully!'); window.location.href='gallery.php';</script>";
    } else {
        echo "<script>alert('Error deleting image.'); window.location.href='gallery.php';</script>";
    }
}
?>
