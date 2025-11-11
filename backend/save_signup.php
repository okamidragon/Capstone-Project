<?php
$mysqli = new mysqli("localhost", "root", "", "mental_health");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Collect and sanitize POST data
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// Simple validation
if ($password !== $confirm) {
    die("Passwords do not match.");
}

// Optional: check if username already exists
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("Username already exists.");
}
$stmt->close();

// Insert into database
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Sign up successful! <a href='login.php'>Log in</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
