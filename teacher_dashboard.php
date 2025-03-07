<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != "teacher") {
    header("Location: index.html");
    exit();
}
echo "<h2>Welcome Parent, " . $_SESSION['username'] . "!</h2>";
?>
<a href="logout.php">Logout</a>
