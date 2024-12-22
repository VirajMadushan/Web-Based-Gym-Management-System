<?php 
include 'header.php'; 
include 'db_connect.php'; 

$sql = "SELECT * FROM coaches";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);

    // Handle file upload
    $upload_dir = "uploads/coaches/";
    $image_name = basename($_FILES['image']['name']);
    $image_path = $upload_dir . $image_name;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        // Insert data into database
        $insert_sql = "INSERT INTO coaches (name, description, image_path) VALUES ('$name', '$description', '$image_path')";
        if ($conn->query($insert_sql)) {
            echo "<script>alert('Coach added successfully!');</script>";
        } else {
            echo "<script>alert('Error: Could not add coach.');</script>";
        }
    } else {
        echo "<script>alert('Error: Image upload failed.');</script>";
    }
}
?>

<div class="container">
    <h2>Manage Coaches</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Description:</label>
        <textarea name="description" required></textarea>
        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Coach</button>
    </form>
    
    <h3>Current Coaches</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td><img src="<?= htmlspecialchars($row['image_path']); ?>" alt="<?= htmlspecialchars($row['name']); ?>" width="100"></td>
                    <td>
                        <!-- Styled Update Button -->
                        <a href="update_coach.php?id=<?= $row['id']; ?>" 
                           style="background-color: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-left: 10px;">
                           Update
                        </a>
                        
                        <!-- Styled Delete Button -->
                        <a href="delete_coach.php?id=<?= $row['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this coach?');" 
                           style="background-color: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
