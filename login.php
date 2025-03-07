<?php
session_start();
include "db.php"; // Ensure database connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password']; // User-entered password
    $role = $_POST['role'];

    // Prepare SQL Query (DO NOT compare passwords in the query)
    $sql = "SELECT * FROM users WHERE username=? AND role=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role (server-side for reliability)
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.html");
            } else {
                header("Location: teacher_dashboard.php");
            }
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Incorrect password! Try again.'); window.location.href='index.html';</script>";
            exit();
        }
    } else {
        // User not found or role mismatch
        echo "<script>alert('User not found or role mismatch!'); window.location.href='index.html';</script>";
        exit();
    }
}
?>
