<?php 
include 'header.php'; 
include 'db_connect.php'; 

// Handle adding new users
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $name = $conn->real_escape_string($_POST['name']);
    $telephone = $conn->real_escape_string($_POST['telephone']);
    $role = $conn->real_escape_string($_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash password

    $insert_sql = "INSERT INTO user (email, name, telephone, role, password) VALUES ('$email', '$name', '$telephone', '$role', '$password')";
    if ($conn->query($insert_sql)) {
        echo "<script>alert('User added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding user: " . $conn->error . "');</script>";
    }
}

// Fetch all users
$sql = "SELECT * FROM user";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Manage Users</h2>

    <!-- Add User Form -->
    <h3>Add New User</h3>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="telephone">Telephone:</label>
        <input type="text" id="telephone" name="telephone" required>
        <br>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="add_user" style="background-color: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">Add User</button>
    </form>

    <!-- Users Table -->
    <h3>Existing Users</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Telephone</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['telephone']); ?></td>
                    <td><?= htmlspecialchars($row['role']); ?></td>
                    <td>
                        <!-- Update Button with Styling -->
                        <form method="GET" action="update_user.php" style="display:inline;">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']); ?>">
                            <button type="submit" style="background-color: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">Update</button>
                        </form>
                        
                        <!-- Delete Button with Styling -->
                        <form method="GET" action="delete_user.php" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']); ?>">
                            <button type="submit" style="background-color: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-left: 10px;">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
