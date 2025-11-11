<?php
session_start();
$userRole = $_SESSION['role'] ?? '';
if ($userRole !== 'therapist') {
    die("Access denied. You must be a therapist to view this page.");
}

// Handle form submission
$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($name && $description) {
        $mysqli = new mysqli("localhost", "root", "", "mental_health");
        if ($mysqli->connect_error) {
            $errorMsg = "Database connection failed: " . $mysqli->connect_error;
        } else {
            $stmt = $mysqli->prepare("INSERT INTO activities (NAME, description, therapist) VALUES (?, ?, ?)");
            $therapistName = $_SESSION['username'] ?? 'Unknown Therapist';
            $stmt->bind_param("sss", $name, $description, $therapistName);
            if ($stmt->execute()) {
                $successMsg = "Activity created successfully!";
            } else {
                $errorMsg = "Error creating activity: " . $stmt->error;
            }
            $stmt->close();
            $mysqli->close();
        }
    } else {
        $errorMsg = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Activities - Therapist</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('../frontend/navbar.php'); ?>

<section class="therapist-page">
    <h1>Manage Activities</h1>
    <p>Create a new activity below:</p>

    <?php if ($successMsg)
        echo "<p class='success'>$successMsg</p>"; ?>
    <?php if ($errorMsg)
        echo "<p class='error'>$errorMsg</p>"; ?>

    <form method="POST" class="activity-form">
        <label for="name">Activity Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <button type="submit">Create Activity</button>
    </form>
</section>

<style>
.therapist-page {
    max-width: 600px;
    margin: 60px auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.therapist-page h1 {
    color: #002d2d;
    margin-bottom: 20px;
}

.activity-form label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
}

.activity-form input,
.activity-form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.activity-form button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #0c7b75;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.activity-form button:hover {
    background-color: #095e5a;
}

.success {
    color: green;
    font-weight: bold;
}

.error {
    color: red;
    font-weight: bold;
}
</style>
</body>
</html>
