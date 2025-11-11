<?php
session_start();
$userRole = $_SESSION['role'] ?? '';
if ($userRole !== 'admin') {
    die("Access denied. You must be an admin to view this page.");
}

$mysqli = new mysqli("localhost", "root", "", "mental_health");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Fetch all users
$result = $mysqli->query("SELECT id, username, email, role FROM users ORDER BY id ASC");
$users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Management - Admin</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('../frontend/navbar.php'); ?>

<section class="admin-page">
    <h1>User Management</h1>
    <p>View, edit, or delete users below:</p>

    <?php if (empty($users)): ?>
        <p>No users found.</p>
    <?php else: ?>
        <div class="users-box">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <form method="POST" action="update_role.php" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <select name="role" onchange="this.form.submit()">
                                        <option value="user" <?php if ($user['role'] === 'user')
                                            echo 'selected'; ?>>User</option>
                                        <option value="therapist" <?php if ($user['role'] === 'therapist')
                                            echo 'selected'; ?>>Therapist</option>
                                        <option value="admin" <?php if ($user['role'] === 'admin')
                                            echo 'selected'; ?>>Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="delete_user.php" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<style>
.admin-page {
    max-width: 900px;
    margin: 60px auto;
    padding: 20px;
}

.users-box {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table th,
.users-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}

.users-table th {
    background-color: #f0f0f0;
}

.btn-delete {
    background-color: #c0392b;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.btn-delete:hover {
    background-color: #a93226;
}
</style>

</body>
</html>

<?php $mysqli->close(); ?>
