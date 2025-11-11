<!-- navbar.php -->
<nav class="navbar">
  <div class="logo">Mental Health Resources</div>
  <ul class="nav-links" id="navLinks">
      <li><a href="../frontend/index.php">Home</a></li>
      <li><a href="../frontend/resources.php">Resources</a></li>
      <li><a href="../frontend/about.php">About</a></li>
      <li><a href="../frontend/contact.php">Contact</a></li>
  </ul>

  <!-- Login / User Dropdown -->
  <div class="user-menu" id="userMenu">
      <a href="../frontend/login.php" class="login-btn" id="loginBtn">Login</a>
      <div class="dropdown" id="dropdownMenu" style="display:none;">
          <a href="../frontend/account.php">Account</a>
          <div id="roleLinks"></div>
          <a href="#" id="signOutBtn">Sign Out</a>
      </div>
  </div>
</nav>

<script>
const loginBtn = document.getElementById('loginBtn');
const dropdownMenu = document.getElementById('dropdownMenu');
const signOutBtn = document.getElementById('signOutBtn');
const roleLinks = document.getElementById('roleLinks');

function updateNavbar() {
    const loggedInUser = localStorage.getItem('loggedInUser');
    const userRole = localStorage.getItem('userRole'); // user | therapist | admin

    if (loggedInUser) {
        // Show username instead of "Login"
        loginBtn.textContent = loggedInUser;
        loginBtn.href = "#";

        // Reset role-specific links
        roleLinks.innerHTML = "";

        // Add links based on user role
        if (userRole === "user") {
            roleLinks.innerHTML += `<a href="/GroupProject/frontend/activities/activities.php">My Activities</a>`;
        } else if (userRole === "therapist") {
            roleLinks.innerHTML += `
                <a href="../therapist/manage_activities.php">Manage Activities</a>
                <a href="../therapist/view_patients.php">View Patients</a>
            `;
        } else if (userRole === "admin") {
            roleLinks.innerHTML += `
                <a href="../admin/manage_users.php">User Management</a>
                <a href="../admin/update_resources.php">Update Resources</a>
            `;
        }

        // Toggle dropdown visibility
        loginBtn.onclick = function(e) {
            e.preventDefault();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        };

        // Handle sign out
        signOutBtn.onclick = function(e) {
            e.preventDefault();
            if (confirm("Do you want to sign out?")) {
                localStorage.removeItem('loggedInUser');
                localStorage.removeItem('userRole');
                dropdownMenu.style.display = 'none';
                updateNavbar();
                window.location.href = "../frontend/index.php";
            }
        };

    } else {
        // Not logged in — show normal navbar
        loginBtn.textContent = "Login";
        loginBtn.href = "../frontend/login.php";
        dropdownMenu.style.display = 'none';
    }
}

// Initialize navbar on load
updateNavbar();

// Ensure navbar links redirect correctly
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = this.getAttribute('href');
    });
});
</script>

<style>
/* Dropdown styling */
.user-menu {
    position: relative;
    display: inline-block;
}

.dropdown {
    position: absolute;
    right: 0;
    background-color: #fff;
    min-width: 150px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    z-index: 1000;
    border-radius: 5px;
    overflow: hidden;
}

.dropdown a {
    display: block;
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    font-size: 14px;
}

.dropdown a:hover {
    background-color: #f0f0f0;
}
</style>
