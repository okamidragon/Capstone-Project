<?php
session_start();
require_once '../backend/db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../frontend/login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user info
$stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();

// Fetch enrolled activities
$stmt2 = $mysqli->prepare("
    SELECT a.name, a.description, a.therapist 
    FROM activities a
    JOIN activity_enrollments e ON a.id = e.activity_id
    WHERE e.user_id = ?
");
$stmt2->bind_param("i", $user['id']);
$stmt2->execute();
$activities = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Activities</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include('../frontend/navbar.php'); ?>

<section class="activities-section">
    <div class="activities-container">
        <h2>My Enrolled Activities</h2>

        <?php if ($activities->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Activity Name</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $activities->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['description']); ?></td>
                            <td><?= htmlspecialchars($row['therapist']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-activities">You are not enrolled in any activities yet.</p>
        <?php endif; ?>
    </div>
</section>

</body>
</html>
