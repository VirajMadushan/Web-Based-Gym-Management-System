<?php 
include 'header.php'; 
include 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle image upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $caption = $_POST['caption'];
    $sql = "INSERT INTO gallery_images (image_path, caption) VALUES ('$target_file', '$caption')";
    $conn->query($sql);
    echo "<script>alert('Image uploaded successfully!');</script>";
}

$sql = "SELECT * FROM gallery_images";
$result = $conn->query($sql);
?>
<div class="container">
    <h2>Gallery</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image" required>
        <label for="caption">Caption:</label>
        <input type="text" name="caption" id="caption" required>
        <button type="submit">Upload</button>
    </form>
    <h3>Gallery Images</h3>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Caption</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($row['image_path']); ?>" alt="Gallery Image" width="100"></td>
                    <td><?= htmlspecialchars($row['caption']); ?></td>
                    <td>
                        <!-- Styled Delete Button -->
                        <a href="delete_gallery_image.php?id=<?= $row['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this image?');" 
                           style="background-color: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
                           Delete
                        </a> |
                        
                        <!-- Styled Update Button -->
                        <a href="update_gallery_image.php?id=<?= $row['id']; ?>" 
                           style="background-color: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
                           Update
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
