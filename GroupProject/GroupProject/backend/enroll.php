<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to enroll.");
}

$user_id = $_SESSION['user_id'];
$activity_id = intval($_POST['activity_id']);

$mysqli = new mysqli("localhost", "root", "", "mental_health");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Insert enrollment
$stmt = $mysqli->prepare("INSERT IGNORE INTO activity_enrollments (user_id, activity_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $activity_id);

if ($stmt->execute()) {
    $stmt->close();
    $mysqli->close();
    header("Location: activity.php?id=$activity_id&enrolled=1");
    exit;
} else {
    echo "Error enrolling: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
