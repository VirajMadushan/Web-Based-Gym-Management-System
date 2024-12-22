<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch current details of the item
    $sql = "SELECT * FROM store_items WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $conn->real_escape_string($_POST['name']);
        $price = $conn->real_escape_string($_POST['price']);

        // Handle file upload (update the image if provided)
        $upload_dir = "uploads/store/";
        $image_path = $row['image_path']; // Keep the old image by default
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

        // Update item details in the database
        $update_sql = "UPDATE store_items SET name = '$name', price = '$price', image_path = '$image_path' WHERE id = $id";
        if ($conn->query($update_sql)) {
            echo "<script>alert('Item updated successfully!'); window.location.href='manage_store.php';</script>";
        } else {
            echo "<script>alert('Error: Could not update item.');</script>";
        }
    }
} else {
    echo "No item selected for update.";
}
?>

<div class="container">
    <h2>Update Store Item</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($row['name']); ?>" required>
        <label>Price:</label>
        <input type="text" name="price" value="<?= htmlspecialchars($row['price']); ?>" required>
        <label>Image (Optional):</label>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Update Item</button>
    </form>
</div>
