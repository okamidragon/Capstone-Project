<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mental Health Resources</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>

  <!-- Include Navbar -->
  <?php include('navbar.php'); ?>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Accessibility to Mental Health Resources</h1>
    <p>We provide easy access to mental health resources for individuals seeking support.</p>
    <div class="search-box">
      <input type="text" placeholder="Search resources" />
      <button>Search</button>
    </div>
  </section>

  <!-- Content Section -->
  <section class="content">
    <div class="card">
      <h2>Therapy</h2>
      <p>Individual therapy services for adults</p>
      <a href="#" class="btn">Learn More</a>
    </div>

    <div class="card">
      <h2>Managing Anxiety</h2>
      <p>Techniques and tips for managing anxiety</p>
      <a href="activity.php?id=1" class="btn">Get Started</a>
    </div>
  </section>

</body>
</html>
