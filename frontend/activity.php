<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "mental_health");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get activity id from URL, default to 1
$activity_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Fetch activity info
$stmt = $mysqli->prepare("SELECT * FROM activities WHERE id=?");
$stmt->bind_param("i", $activity_id);
$stmt->execute();
$result = $stmt->get_result();
$activity = $result->fetch_assoc();
$stmt->close();

// Check if activity exists
if (!$activity) {
    die("Activity not found.");
}

// Count enrolled users
$stmt2 = $mysqli->prepare("SELECT COUNT(*) AS total FROM activity_enrollments WHERE activity_id=?");
$stmt2->bind_param("i", $activity_id);
$stmt2->execute();
$enroll_result = $stmt2->get_result();
$enroll_count = $enroll_result->fetch_assoc()['total'];
$stmt2->close();

// Handle unenroll request
if (isset($_POST['unenroll']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt_del = $mysqli->prepare("DELETE FROM activity_enrollments WHERE activity_id=? AND user_id=?");
    $stmt_del->bind_param("ii", $activity_id, $user_id);
    $stmt_del->execute();
    $stmt_del->close();

    // Refresh page after unenroll
    header("Location: activity.php?id=" . $activity_id);
    exit();
}

// Check if current user is already enrolled
$already_enrolled = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt3 = $mysqli->prepare("SELECT * FROM activity_enrollments WHERE activity_id=? AND user_id=?");
    $stmt3->bind_param("ii", $activity_id, $user_id);
    $stmt3->execute();
    $check_result = $stmt3->get_result();
    $already_enrolled = ($check_result->num_rows > 0);
    $stmt3->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($activity['NAME']); ?> - Mental Health Activities</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include('navbar.php'); ?>

<section class="activity-page">
    <div class="activity-container">
        <h1><?php echo htmlspecialchars($activity['NAME']); ?></h1>
        <p><strong>Therapist:</strong> <?php echo htmlspecialchars($activity['therapist']); ?></p>
        <p><?php echo htmlspecialchars($activity['description']); ?></p>
        <p><strong>Enrolled Participants:</strong> <?php echo $enroll_count; ?></p>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($already_enrolled): ?>
                <p>You are already enrolled.</p>
                <form method="POST" style="display:inline;">
                    <button type="submit" name="unenroll" class="btn">Unenroll</button>
                </form>
            <?php else: ?>
                <form action="enroll.php" method="POST">
                    <input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>">
                    <button type="submit" class="btn">Enroll</button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <p><a href="login.php">Log in</a> to enroll in this activity.</p>
        <?php endif; ?>
    </div>
</section>

<style>
.activity-page {
    display: flex;
    justify-content: center;
    padding: 60px 20px;
}

.activity-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    max-width: 600px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.activity-container h1 {
    color: #002d2d;
    margin-bottom: 10px;
}

.activity-container p {
    margin: 10px 0;
}

.activity-container .btn {
    background-color: #0c7b75;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.activity-container .btn:hover {
    background-color: #095e5a;
}
</style>

</body>
</html>
