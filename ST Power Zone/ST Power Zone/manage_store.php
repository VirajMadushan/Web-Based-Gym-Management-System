<?php 
include 'header.php'; 
include 'db_connect.php'; 

$sql = "SELECT * FROM store_items";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);

    // Handle file upload
    $upload_dir = "uploads/store/";
    $image_name = basename($_FILES['image']['name']);
    $image_path = $upload_dir . $image_name;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        // Insert data into database
        $insert_sql = "INSERT INTO store_items (name, price, image_path) VALUES ('$name', '$price', '$image_path')";
        if ($conn->query($insert_sql)) {
            echo "<script>alert('Item added successfully!');</script>";
        } else {
            echo "<script>alert('Error: Could not add item.');</script>";
        }
    } else {
        echo "<script>alert('Error: Image upload failed.');</script>";
    }
}
?>

<div class="container">
    <h2>Manage Store Items</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Price:</label>
        <input type="text" name="price" required>
        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Add Item</button>
    </form>
    <h3>Current Store Items</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['price']); ?></td>
                    <td><img src="<?= htmlspecialchars($row['image_path']); ?>" alt="<?= htmlspecialchars($row['name']); ?>" width="100"></td>
                    <td>
                        <!-- Styled Delete Button -->
                        <a href="delete_item.php?id=<?= $row['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this item?');" 
                           style="background-color: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
                           Delete
                        </a> |
                        
                        <!-- Styled Update Button -->
                        <a href="update_item.php?id=<?= $row['id']; ?>" 
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
