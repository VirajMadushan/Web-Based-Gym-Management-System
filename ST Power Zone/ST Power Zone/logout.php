<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();
session_destroy();

// Redirect to index.php after logout
header("Location: index.php");
exit();
