<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert user data with hashed password
    $sql = "INSERT INTO `user`(`email`, `password`, `name`, `telephone`, `role`) VALUES (?, ?, ?, ?, 'user')";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssss", $email, $hashed_password, $name, $telephone);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Account created successfully!";
            header("Location: login.php"); // Redirect to login page
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
