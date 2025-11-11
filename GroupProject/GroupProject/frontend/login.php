<?php
// frontend/login/login.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Mental Health Resources</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>

  <!-- Include Navbar -->
  <?php include('navbar.php'); ?>

  <!-- Login Section -->
  <section class="login-section">
    <div class="login-container">
      <h2>Log In</h2>
      <div class="error" id="errorMsg"></div>
      <form id="loginForm">
        <input type="text" id="username" placeholder="Username" required>
        <input type="password" id="password" placeholder="Password" required>
        <button type="submit">Log In</button>
      </form>
      <p>Don't have an account? <a href="../frontend/signup/signup.php">Sign Up</a></p>
    </div>
  </section>

  <script>
    const form = document.getElementById('loginForm');
    const errorMsg = document.getElementById('errorMsg');

    form.addEventListener('submit', async e => {
      e.preventDefault();

      const username = document.getElementById('username').value.trim();
      const password = document.getElementById('password').value;

      errorMsg.textContent = '';

      try {
        const res = await fetch('../backend/check_login.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ username, password })
        });

        const data = await res.json();

        if (data.status === 'success') {
          // Store user info
          localStorage.setItem('loggedInUser', username);
          localStorage.setItem('userRole', data.role);

          alert('Login successful!');

          // Redirect based on role
          if (data.role === 'therapist') {
            window.location.href = '../therapist/manage_activities.php';
          } else if (data.role === 'admin') {
            window.location.href = '../admin/manage_users.php';
          } else {
            window.location.href = '../frontend/home/index.php';
          }

        } else {
          errorMsg.textContent = data.message;
        }

      } catch (err) {
        console.error(err);
        errorMsg.textContent = 'Server error. Please try again later.';
      }
    });
  </script>

</body>
</html>
