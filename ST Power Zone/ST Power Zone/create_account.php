<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - ST Power Zone GYM</title>
    <link rel="stylesheet" href="css/loginstyles.css">
</head>
<body>
    <div class="auth-container">
        <h2>Create Your Account</h2>
        <form action="create_account_process.php" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="telephone">Telephone:</label>
            <input type="text" id="telephone" name="telephone" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <button type="submit">Create Account</button>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
