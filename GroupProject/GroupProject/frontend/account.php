<?php
session_start();
require_once '../backend/db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user info
$stmt = $mysqli->prepare("SELECT id, username, email, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include('navbar.php'); ?>

<section class="account-section">
    <div class="account-container">
        <!-- Account Overview -->
        <h2>My Account</h2>
        <div class="account-info-card">
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'Not Provided'); ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($user['role']); ?></p>
        </div>

    </div>
</section>

</body>
</html>
