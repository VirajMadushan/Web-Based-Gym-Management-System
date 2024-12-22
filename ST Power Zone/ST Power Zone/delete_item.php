<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the image path from the database
    $sql = "SELECT image_path FROM store_items WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $image_path = $row['image_path'];

    // Delete the item from the database
    $sql = "DELETE FROM store_items WHERE id = $id";
    if ($conn->query($sql)) {
        // Remove the image file from the server
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        echo "<script>alert('Item deleted successfully!'); window.location.href='manage_store_items.php';</script>";
    } else {
        echo "<script>alert('Error: Could not delete item.'); window.location.href='manage_store_items.php';</script>";
    }
}
?>
