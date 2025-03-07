<?php
$host = "localhost";
$user = "root"; // Change this if your database has a different username
$pass = ""; // Add your database password if set
$dbname = "login_system";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
