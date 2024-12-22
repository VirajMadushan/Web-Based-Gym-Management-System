<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user data, including role
    $sql = "SELECT * FROM `user` WHERE `email` = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            // Verify the hashed password with the entered password
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['role'] = $row['role']; // Store role in session

                // Redirect based on role
                if ($row['role'] === 'admin') {
                    header("Location: manageindex.php"); // Redirect to admin panel
                } else {
                    header("Location: index.php"); // Redirect to user home
                }
                exit();
            } else {
                echo "Incorrect password!";
            }
        } else {
            echo "No account found with that email!";
        }
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!-- HTML for the login form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyles.css"> <!-- Ensure correct path -->
</head>
<body>
    <div class="auth-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="create_account.php">Create Account</a></p>
    </div>
</body>
</html>
