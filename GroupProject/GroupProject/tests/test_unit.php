<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// tests/test_unit.php
require_once __DIR__ . '/../../backend/db_connect.php';

$tests = [];

// UT-01: Successful login
$username = "testuser";
$password = "password123";

$stmt = $mysqli->prepare("SELECT password, role FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($hashedPassword, $role);
$stmt->fetch();
$stmt->close();

$actual = (password_verify($password, $hashedPassword)) 
            ? ['status' => 'success', 'message' => 'Login successful', 'role' => $role]
            : ['status' => 'error', 'message' => 'Incorrect username or password'];

$expected = ['status' => 'success', 'message' => 'Login successful', 'role' => 'user'];

$tests[] = [
    'Test Case' => 'UT-01',
    'Component' => 'check_login.php',
    'Input' => "Username: $username, Password: $password",
    'Expected Output' => json_encode($expected),
    'Actual Output' => json_encode($actual),
    'Result' => ($actual === $expected) ? 'Pass' : 'Fail'
];

// UT-02: Failed login
$username = "wronguser";
$password = "password123";

$stmt = $mysqli->prepare("SELECT password, role FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($hashedPassword, $role);
$stmt->fetch();
$stmt->close();

$actual = $hashedPassword 
            ? (password_verify($password, $hashedPassword) ? ['status'=>'success'] : ['status'=>'error', 'message'=>'Incorrect username or password'])
            : ['status'=>'error', 'message'=>'Incorrect username or password'];

$expected = ['status'=>'error', 'message'=>'Incorrect username or password'];

$tests[] = [
    'Test Case' => 'UT-02',
    'Component' => 'check_login.php',
    'Input' => "Username: $username, Password: $password",
    'Expected Output' => json_encode($expected),
    'Actual Output' => json_encode($actual),
    'Result' => ($actual === $expected) ? 'Pass' : 'Fail'
];

$mysqli->close();

// Display results
foreach ($tests as $t) {
    echo implode(" | ", $t) . "\n";
}
?>
