<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current details of the coach
    $sql = "SELECT * FROM coaches WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);

        // Handle file upload (update image if provided)
        $upload_dir = "uploads/coaches/";
        $image_path = $row['image_path']; // Keep old image by default
        if (!empty($_FILES['image']['name'])) {
            $image_name = basename($_FILES['image']['name']);
            $image_path = $upload_dir . $image_name;

            // Delete old image file
            if (file_exists($row['image_path'])) {
                unlink($row['image_path']);
            }

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                echo "<script>alert('Error: Image upload failed.');</script>";
            }
        }

        // Update coach details in the database
        $update_sql = "UPDATE coaches SET name = '$name', description = '$description', image_path = '$image_path' WHERE id = $id";
        if ($conn->query($update_sql)) {
            echo "<script>alert('Coach updated successfully!'); window.location.href='manage_coaches.php';</script>";
        } else {
            echo "<script>alert('Error: Could not update coach.');</script>";
        }
    }
} else {
    echo "No coach selected for update.";
}
?>

<div class="container">
    <h2>Update Coach</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($row['name']); ?>" required>
        <label>Description:</label>
        <textarea name="description" required><?= htmlspecialchars($row['description']); ?></textarea>
        <label>Image (Optional):</label>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Update Coach</button>
    </form>
</div>
