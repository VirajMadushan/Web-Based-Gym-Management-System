<?php 
include 'header.php'; 
include 'db_connect.php'; 

// Handle delete requests
if (isset($_GET['delete_email'])) {
    $delete_email = $conn->real_escape_string($_GET['delete_email']); // Sanitize input

    $delete_sql = "DELETE FROM meal_plans WHERE email = '$delete_email'";
    if ($conn->query($delete_sql)) {
        echo "<script>alert('Meal plan deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting meal plan!');</script>";
    }

    // Redirect to avoid resubmission of the delete action
    header("Location: manage_meal_plans.php");
    exit();
}

// Handle updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_meal_plan'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $meal_plan = $conn->real_escape_string($_POST['meal_plan']);

    $update_sql = "UPDATE meal_plans SET meal_plan = '$meal_plan' WHERE email = '$email'";
    if ($conn->query($update_sql)) {
        echo "<script>alert('Meal plan updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating meal plan!');</script>";
    }
}

// Fetch all meal plans
$sql = "SELECT * FROM meal_plans";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Manage Meal Plans</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Email</th>
                <th>Age</th>
                <th>Goal</th>
                <th>Meal Plan</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['age']); ?></td>
                    <td><?= htmlspecialchars($row['goal']); ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']); ?>">
                            <textarea name="meal_plan" rows="2" required><?= htmlspecialchars($row['meal_plan']); ?></textarea>
                    </td>
                    <td>
                            <!-- Styled Update Button -->
                            <button type="submit" name="update_meal_plan" 
                                    style="background-color: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
                                Update
                            </button>
                        </form>

                        <!-- Styled Delete Button -->
                        <form method="GET" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this meal plan?');">
                            <input type="hidden" name="delete_email" value="<?= htmlspecialchars($row['email']); ?>">
                            <button type="submit" 
                                    style="background-color: #f44336; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-left: 10px;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
