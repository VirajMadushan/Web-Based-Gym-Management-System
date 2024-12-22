<?php 
include 'header.php'; 
include 'db_connect.php'; 

// Handle deletion if a delete request is made
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitize input

    // SQL query to delete the record
    $delete_query = "DELETE FROM attendance WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Attendance record deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting record');</script>";
    }

    $stmt->close();
    
    // Redirect to avoid re-execution of the delete query
    header("Location: manage_attendance.php");
    exit();
}

// Fetch attendance records
$sql = "SELECT * FROM attendance";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Attendance Records</h2>
    <table border="1">
        <thead>
            <tr>
                <th>User Email</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['user_email']); ?></td>
                    <td><?= htmlspecialchars($row['attendance_date']); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td>
                        <!-- Styled Delete Button -->
                        <a href="manage_attendance.php?delete_id=<?= $row['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this record?');" 
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
