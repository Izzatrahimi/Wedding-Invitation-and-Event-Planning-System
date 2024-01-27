<?php
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}

// Initialize count variables
$activityCount = 0;
$checklistCount = 0;
$feedbackCount = 0;
$guestCount = 0;
$headerCount = 0;
$messageCount = 0;
$userCount = 0;
$vendorCount = 0;

// Query to get counts
$query = "SELECT 
(SELECT COUNT(*) FROM activity_details) AS activity_count,
(SELECT COUNT(*) FROM checklist) AS checklist_count,
(SELECT COUNT(*) FROM feedback) AS feedback_count,
(SELECT COUNT(*) FROM guest) AS guest_count,
(SELECT SUM(guest_pax) FROM guest) AS total_pax_count,
(SELECT COUNT(*) FROM header_details) AS header_count,
(SELECT COUNT(*) FROM message) AS message_count,
(SELECT COUNT(*) FROM user) AS user_count,
(SELECT COUNT(*) FROM vendor) AS vendor_count";

$result = mysqli_query($dbconn, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);
  $activityCount = $row['activity_count'];
  $checklistCount = $row['checklist_count'];
  $feedbackCount = $row['feedback_count'];
  $guestCount = $row['guest_count'];
  $headerCount = $row['header_count'];
  $messageCount = $row['message_count'];
  $userCount = $row['user_count'];
  $vendorCount = $row['vendor_count'];
  $total_pax_count = $row['total_pax_count'];
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Admin Dashboard </title>
  <link rel="stylesheet" href="style4.css">

  <!-- Montserrat Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">Wed Gala</span>
    </div>
    <ul class="nav-links">
      <!-- <li>
        <a href="admin.php">
          <i class='bx bx-grid-alt' ></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li> -->
      <li>
        <a href="report.php">
          <i class='bx bx-grid-alt' ></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="view_user.php">
          <i class='bx bxs-user-detail'></i>
          <span class="links_name">User</span>
        </a>
      </li>
      <li>
        <a href="view_feedback.php">
          <i class='bx bx-chat'></i>
          <span class="links_name">Feedback</span>
        </a>
      </li>
      <li>
        <a href="view_message.php">
          <i class='bx bx-message-dots' ></i>
          <span class="links_name">Message</span>
        </a>
      </li>
      <li>
        <a href="view_event.php">
          <i class='bx bx-calendar-event' ></i>
          <span class="links_name">Event Details</span>
        </a>
      </li>
      <!-- <li>
        <a href="view_vendor.php">
          <i class='bx bx-store'></i>
          <span class="links_name">Vendor</span>
        </a>
      </li> -->
      <li class="log_out">
        <a href="../registration/logout.php">
          <i class='bx bx-log-out'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>

  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
      </div>
      <!-- <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div> -->
      <div class="profile-details">
        <!-- <img src="images/profile.jpg" alt=""> -->
        <i class='bx bxs-user'></i>
        <span class="admin_name">
          <?php echo $_SESSION['username']; ?>
        </span>
      </div>
    </nav>

    <section class="main-skills">

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">TOTAL USERS:</p>
          <span class="material-symbols-outlined">group</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $userCount; ?> users</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">TOTAL VENDORS:</p>
          <span class="material-symbols-outlined">storefront</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $vendorCount; ?> vendors</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">TOTAL GUESTS:</p>
          <span class="material-symbols-outlined">groups</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $total_pax_count; ?> guests</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">TOTAL FEEDBACKS GIVEN:</p>
          <span class="material-symbols-outlined">forum</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $feedbackCount; ?> feedbacks</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">TOTAL MESSAGES SENT:</p>
          <span class="material-symbols-outlined">chat</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $messageCount; ?> messages</span>
      </div>

    </section>

    <section class="main-course">

      <div class="charts">

        <div class="charts-card">
          <p class="chart-title">distribution of vendors in each category</p>
          <div id="pie-chart">
            <canvas id="vendorCategoryPieChart" width="400" height="400"></canvas>

            <?php

            // Query to get vendor category distribution
            $query = "SELECT vendor_category, COUNT(*) as category_count FROM vendor GROUP BY vendor_category";
            $result = mysqli_query($dbconn, $query);

            $vendorCategoriesArray = array();
            $vendorCountsArray = array();

            while ($row = mysqli_fetch_assoc($result)) {
              $vendorCategoriesArray[] = $row['vendor_category'];
              $vendorCountsArray[] = $row['category_count'];
            }

            ?>
          </div>
        </div>

        <div class="charts-card">
          <p class="chart-title">distribution of guests in each group</p>
          <div id="donut-pie-chart">
            <canvas id="guestGroupDonutChart" width="400" height="400"></canvas>

            <?php

            // Query to get guest group distribution
            $query = "SELECT guest_group, COUNT(*) as group_count FROM guest GROUP BY guest_group";
            $result = mysqli_query($dbconn, $query);

            $guestGroupsArray = array();
            $guestGroupCountsArray = array();

            while ($row = mysqli_fetch_assoc($result)) {
              $guestGroupsArray[] = $row['guest_group'];
              $guestGroupCountsArray[] = $row['group_count'];
            }

            // Close the database connection
            mysqli_close($dbconn);

            ?>

          </div>
        </div>

      </div>

    </section>

  </section>

  <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
      sidebar.classList.toggle("active");
      if(sidebar.classList.contains("active")){
        sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
      }else
      sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // Get the canvas element and its context
    var ctx = document.getElementById('vendorCategoryPieChart').getContext('2d');

    // Data from PHP variables
    var vendorCategories = <?php echo json_encode($vendorCategoriesArray); ?>;
    var vendorCounts = <?php echo json_encode($vendorCountsArray); ?>;

    // Generate an array of random colors
    var randomColors = generateRandomColors(vendorCategories.length);

    // Create a pie chart
    var pieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: vendorCategories,
        datasets: [{
          data: vendorCounts,
          backgroundColor: randomColors,
        }],
      },
      options: {
        responsive: true,
        legend: {
          position: 'bottom',
        },
      },
    });

    // Function to generate random colors
    function generateRandomColors(count) {
      var colors = [];
      for (var i = 0; i < count; i++) {
        var randomColor = 'rgba(' +
        Math.floor(Math.random() * 256) + ',' +
        Math.floor(Math.random() * 256) + ',' +
        Math.floor(Math.random() * 256) + ',0.7)';
        colors.push(randomColor);
      }
      return colors;
    }

  </script>

  <script>
    // Get the canvas element and its context for the donut chart
    var donutCtx = document.getElementById('guestGroupDonutChart').getContext('2d');

    // Data from PHP variables
    var guestGroups = <?php echo json_encode($guestGroupsArray); ?>;
    var guestGroupCounts = <?php echo json_encode($guestGroupCountsArray); ?>;

    // Generate an array of random colors for the donut chart
    var randomDonutColors = generateRandomColors(guestGroups.length);

    // Create a donut chart
    var donutChart = new Chart(donutCtx, {
      type: 'doughnut',
      data: {
        labels: guestGroups,
        datasets: [{
          data: guestGroupCounts,
          backgroundColor: randomDonutColors,
        }],
      },
      options: {
        responsive: true,
        cutoutPercentage: 60,
        legend: {
          position: 'bottom',
        },
      },
    });

  </script>

</body>

</html>