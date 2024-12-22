<?php
include 'db_connect.php'; // Database connection
include 'header.php'; // Header file

// Check if email is provided
if (isset($_GET['email'])) {
    $email = $conn->real_escape_string($_GET['email']); // Sanitize input

    // Fetch user details
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('User not found!');</script>";
        header("Location: manage_users.php");
        exit();
    }
}

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $telephone = $conn->real_escape_string($_POST['telephone']);
    $role = $conn->real_escape_string($_POST['role']);

    // Update query
    $update_sql = "UPDATE user SET name = '$name', telephone = '$telephone', role = '$role' WHERE email = '$email'";
    if ($conn->query($update_sql)) {
        echo "<script>alert('User updated successfully!');</script>";
        header("Location: manage_users.php");
        exit();
    } else {
        echo "<script>alert('Error updating user: " . $conn->error . "');</script>";
    }
}
?>

<div class="container">
    <h2>Edit User</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
        <br>
        <label for="telephone">Telephone:</label>
        <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone']); ?>" required>
        <br>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>admin</option>
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>user</option>
        </select>
        <br>
        <button type="submit">Update</button>
    </form>
</div>

<?php include 'footer.php'; ?>
