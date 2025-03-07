<?php
session_start();
include "db.php"; // Ensure database connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Securely hash password
    $role = $_POST['role'];

    // Check if username or email already exists
    $check_sql = "SELECT * FROM users WHERE username=? OR email=?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email already exists! Try another.'); window.location.href='register.html';</script>";
        exit();
    }

    // Insert new user
    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Fix: Ensure we pass 4 parameters for 4 placeholders
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now log in.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error registering user. Please try again.'); window.location.href='register.html';</script>";
    }
}
?>
