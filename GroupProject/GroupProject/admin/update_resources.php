<?php
session_start();
$userRole = $_SESSION['role'] ?? '';
if ($userRole !== 'admin') {
    die("Access denied. You must be an admin to view this page.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Resources - Admin</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('../frontend/navbar.php'); ?>

<section class="admin-page">
    <h1>Update Resources</h1>
    <p>This is where you can add or edit mental health resources.</p>
    <!-- TODO: Add form to create/update resources -->
</section>

</body>
</html>
