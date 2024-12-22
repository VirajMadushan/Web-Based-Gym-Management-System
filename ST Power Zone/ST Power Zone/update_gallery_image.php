<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch current details from the database
    $sql = "SELECT * FROM gallery_images WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $caption = $_POST['caption'];
        if (!empty($_FILES["image"]["name"])) {
            // Handle image upload if new image is provided
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            // Delete old image file from the server
            if (file_exists($row['image_path'])) {
                unlink($row['image_path']);
            }

            // Update image path and caption in the database
            $sql = "UPDATE gallery_images SET image_path = '$target_file', caption = '$caption' WHERE id = $id";
        } else {
            // Only update the caption
            $sql = "UPDATE gallery_images SET caption = '$caption' WHERE id = $id";
        }

        if ($conn->query($sql)) {
            echo "<script>alert('Image updated successfully!'); window.location.href='manage_gallery.php';</script>";
        } else {
            echo "<script>alert('Error updating image.'); window.location.href='manage_gallery.php';</script>";
        }
    }
} else {
    echo "No image selected for updating.";
}
?>

<div class="container">
    <h2>Update Gallery Image</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="image">Upload New Image (Optional):</label>
        <input type="file" name="image" id="image">
        <label for="caption">Caption:</label>
        <input type="text" name="caption" id="caption" value="<?= $row['caption']; ?>" required>
        <button type="submit">Update</button>
    </form>
</div>
