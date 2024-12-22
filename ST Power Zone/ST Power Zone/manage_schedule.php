<?php 
include 'header.php'; 
include 'db_connect.php'; 

$sql = "SELECT * FROM workout_plans";
$result = $conn->query($sql);

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_email'])) {
    $email_to_delete = $_POST['delete_email'];
    $delete_sql = "DELETE FROM workout_plans WHERE email='$email_to_delete'";
    if ($conn->query($delete_sql)) {
        echo "<script>alert('Workout plan deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting workout plan.');</script>";
    }
}

// Handle updating workout plan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['workout_plan'])) {
    $email = $_POST['email'];
    $workout_plan = $_POST['workout_plan'];
    $update_sql = "UPDATE workout_plans SET workout_plan='$workout_plan' WHERE email='$email'";
    $conn->query($update_sql);
    echo "<script>alert('Workout plan updated successfully!');</script>";
}
?>

<div class="container">
    <h2>Manage Gym Schedules</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Email</th>
                <th>Age</th>
                <th>Goal</th>
                <th>Workout Plan</th>
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
                            <textarea name="workout_plan" rows="2" required><?= htmlspecialchars($row['workout_plan']); ?></textarea>
                    </td>
                    <td>
                            <!-- Styled Update Button -->
                            <button type="submit" name="workout_plan" 
                                    style="background-color: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">
                                Update
                            </button>
                        </form>

                        <!-- Styled Delete Button -->
                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this workout plan?');">
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
