<?php
$host = 'localhost';
$dbname = 'stgym';
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
