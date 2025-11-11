<?php
include('navbar.php');

// Connect to database
$mysqli = new mysqli("localhost", "root", "", "mental_health");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch all activities
$activities_result = $mysqli->query("SELECT * FROM activities ORDER BY id ASC");
$activities = [];
if ($activities_result) {
    while ($row = $activities_result->fetch_assoc()) {
        $activities[] = $row;
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mental Health Resources</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../css/resourcesStyle.css">
</head>
<body>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Find Mental Health Resources</h1>
    <p>We provide access to mental health resources for individuals seeking support.</p>
    <div class="search-box">
      <input type="text" placeholder="Search resources">
      <button>Search</button>
    </div>
  </section>

  <!-- Resource Categories -->
  <section class="categories">
    <div class="category">
      <img src="images/icons/therapy.png" alt="Therapy">
      <p>Therapy</p>
    </div>
    <div class="category">
      <img src="images/icons/crisis.png" alt="Crisis hotlines">
      <p>Crisis Hotlines</p>
    </div>
    <div class="category">
      <img src="images/icons/selfhelp.png" alt="Self-help">
      <p>Self-help</p>
    </div>
    <div class="category">
      <img src="images/icons/clinic.png" alt="Local clinics">
      <p>Local Clinics</p>
    </div>
  </section>

  <!-- Emergency Box -->
  <div class="emergency-box">
    <h2>Emergency Contact</h2>
    <h1>988</h1>
    <button onclick="window.location.href='https://988lifeline.org/'">Quick Escape</button>
  </div>

  <!-- Featured Resources -->
  <section class="featured">
    <h2>Featured Resources</h2>
    <div class="resources-container">
      <div class="resource-card">
        <h3>Therapy</h3>
        <p>Individual therapy services for adults, teens, and children. Licensed therapists available online or in-person.</p>
      </div>
      <div class="resource-card">
        <h3>Crisis Hotlines</h3>
        <p>24/7 crisis support for anyone in distress. Call, chat, or text to get immediate help from trained counselors.</p>
      </div>
      <div class="resource-card">
        <h3>Self-help</h3>
        <p>Articles, workbooks, and online programs to help manage mental health challenges independently.</p>
      </div>
      <div class="resource-card">
        <h3>Local Clinics</h3>
        <p>Find clinics in your area offering therapy, psychiatric support, and wellness programs.</p>
      </div>
    </div>
  </section>

  <!-- Mental Health Activities -->
  <section id="mental-health-activities">
    <h2>Mental Health Activities</h2>
    <div class="activities-box">
      <?php if (!empty($activities)): ?>
        <?php foreach ($activities as $activity): ?>
          <div class="activity-card">
            <h3><?php echo htmlspecialchars($activity['NAME']); ?></h3>
            <p><?php echo htmlspecialchars($activity['description']); ?></p>
            <a href="activity.php?id=<?php echo $activity['id']; ?>">Learn More</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No activities available at the moment. Please check back later.</p>
      <?php endif; ?>
    </div>
  </section>

</body>
</html>
