<?php
// signup.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - Mental Health Resources</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- Include Navbar -->
<?php include('navbar.php'); ?>

<section class="signup-section">
    <div class="signup-container">
        <h2>Create an Account</h2>
        <form action="save_signup.php" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account? <a href="login.php">Log In</a></p>
    </div>
</section>

</body>
</html>
