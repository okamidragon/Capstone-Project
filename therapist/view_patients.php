<?php
session_start();
$userRole = $_SESSION['role'] ?? '';
if ($userRole !== 'therapist') {
    die("Access denied. You must be a therapist to view this page.");
}

$therapistName = $_SESSION['username'] ?? '';

$mysqli = new mysqli("localhost", "root", "", "mental_health");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Fetch all activities created by this therapist
$stmt = $mysqli->prepare("SELECT id, NAME, description FROM activities WHERE therapist=?");
$stmt->bind_param("s", $therapistName);
$stmt->execute();
$activitiesResult = $stmt->get_result();
$activities = [];
while ($row = $activitiesResult->fetch_assoc()) {
    $activities[$row['id']] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Patients - Therapist</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('../frontend/navbar.php'); ?>

<section class="therapist-page">
    <h1>View Patients</h1>
    <p>List of patients enrolled in your activities:</p>

    <?php if (empty($activities)): ?>
        <p>You have not created any activities yet.</p>
    <?php else: ?>
        <?php foreach ($activities as $activityId => $activity): ?>
            <div class="activity-box">
                <div class="activity-info">
                    <h2><?php echo htmlspecialchars($activity['NAME']); ?></h2>
                    <p><?php echo htmlspecialchars($activity['description']); ?></p>
                </div>
                <div class="patients-box">
                    <?php
                    $stmt2 = $mysqli->prepare("
                        SELECT u.username, u.email
                        FROM activity_enrollments ae
                        JOIN users u ON ae.user_id = u.id
                        WHERE ae.activity_id=?
                    ");
                    $stmt2->bind_param("i", $activityId);
                    $stmt2->execute();
                    $enrollResult = $stmt2->get_result();
                    ?>
                    <?php if ($enrollResult->num_rows === 0): ?>
                        <p>No patients enrolled yet.</p>
                    <?php else: ?>
                        <table class="patients-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user = $enrollResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <?php $stmt2->close(); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<style>
.therapist-page {
    max-width: 900px;
    margin: 60px auto;
    padding: 20px;
}

.activity-box {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 30px;
    border: 1px solid #ccc;
    border-radius: 10px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.activity-info {
    flex: 1 1 40%;
    padding: 20px;
    border-right: 1px solid #ccc;
}

.patients-box {
    flex: 1 1 60%;
    padding: 20px;
}

.activity-info h2 {
    margin-top: 0;
    color: #002d2d;
}

.patients-table {
    width: 100%;
    border-collapse: collapse;
}

.patients-table th,
.patients-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

.patients-table th {
    background-color: #f0f0f0;
}

@media (max-width: 768px) {
    .activity-box {
        flex-direction: column;
    }
    .activity-info {
        border-right: none;
        border-bottom: 1px solid #ccc;
    }
}
</style>

</body>
</html>

<?php
$mysqli->close();
?>
