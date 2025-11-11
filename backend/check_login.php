<?php
header('Content-Type: application/json');
session_start(); // start PHP session

// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "mental_health");

if ($mysqli->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

$username = $mysqli->real_escape_string($input['username']);
$password = $input['password']; // plain text for verification

// Query for user including role
$query = $mysqli->prepare("SELECT id, password, role FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];

    if (password_verify($password, $hashedPassword)) {
        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role']; // store role in session

        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful.',
            'role' => $row['role'] // send role to frontend
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect username or password.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incorrect username or password.']);
}

$query->close();
$mysqli->close();
?>
