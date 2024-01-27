<?php
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}

$username = $_SESSION['username'];

// Retrieve a small part of the itinerary information
$query = "SELECT activity_title, activity_desc, activity_time FROM activity_details WHERE username = '$username' LIMIT 3";
$result = mysqli_query($dbconn, $query);

$itineraryItems = array();

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $activityTitle = $row['activity_title'];
    $activityDesc = $row['activity_desc'];
    $activityTime = $row['activity_time'];
    $itineraryItems[] = array('title' => $activityTitle, 'desc' => $activityDesc, 'time' => $activityTime);
  }
}

// Free the result set
mysqli_free_result($result);

// Retrieve vendor information
$vendorQuery = "SELECT vendor_name, vendor_category FROM vendor WHERE username = '$username'";
$vendorResult = mysqli_query($dbconn, $vendorQuery);

$vendorItems = array();

if (mysqli_num_rows($vendorResult) > 0) {
  while ($row = mysqli_fetch_assoc($vendorResult)) {
    $vendorName = $row['vendor_name'];
    $vendorCategory = $row['vendor_category'];
    $vendorItems[] = array('name' => $vendorName, 'category' => $vendorCategory);
  }
}

// Free the result set
mysqli_free_result($vendorResult);

// Retrieve checklist information
$checklistQuery = "SELECT checklist_title, checklist_status FROM checklist WHERE username = '$username'";
$checklistResult = mysqli_query($dbconn, $checklistQuery);

$checklistItems = array();

if (mysqli_num_rows($checklistResult) > 0) {
  while ($row = mysqli_fetch_assoc($checklistResult)) {
    $checklistTitle = $row['checklist_title'];
    $checklistStatus = $row['checklist_status'];
    $checklistItems[] = array('title' => $checklistTitle, 'status' => $checklistStatus);
  }
}

// Free the result set
mysqli_free_result($checklistResult);

// Retrieve the total number of guest pax
$totalGuestPaxQuery = "SELECT SUM(guest_pax) AS total_pax FROM guest WHERE username = '$username'";
$totalGuestPaxResult = mysqli_query($dbconn, $totalGuestPaxQuery);
$totalPax = 0;

if ($totalGuestPaxResult && mysqli_num_rows($totalGuestPaxResult) > 0) {
  $row = mysqli_fetch_assoc($totalGuestPaxResult);
  $totalPax = $row['total_pax'];
}

// Retrieve the total number of guest pax with the status "attending"
$totalAttendingPaxQuery = "SELECT SUM(guest_pax) AS total_attending_pax FROM guest WHERE username = '$username' AND guest_status = 'attending'";
$totalAttendingPaxResult = mysqli_query($dbconn, $totalAttendingPaxQuery);
$totalAttendingPax = 0;

if ($totalAttendingPaxResult && mysqli_num_rows($totalAttendingPaxResult) > 0) {
  $row = mysqli_fetch_assoc($totalAttendingPaxResult);
  $totalAttendingPax = $row['total_attending_pax'];
}

// Retrieve the total number of vendors available
$totalVendorsQuery = "SELECT COUNT(*) AS total_vendors FROM vendor WHERE username = '$username'";
$totalVendorsResult = mysqli_query($dbconn, $totalVendorsQuery);
$totalVendors = 0;

if ($totalVendorsResult && mysqli_num_rows($totalVendorsResult) > 0) {
  $row = mysqli_fetch_assoc($totalVendorsResult);
  $totalVendors = $row['total_vendors'];
}

// Retrieve the total number of checklists available
$totalChecklistsQuery = "SELECT COUNT(*) AS total_checklists FROM checklist WHERE username = '$username'";
$totalChecklistsResult = mysqli_query($dbconn, $totalChecklistsQuery);
$totalChecklists = 0;

if ($totalChecklistsResult && mysqli_num_rows($totalChecklistsResult) > 0) {
  $row = mysqli_fetch_assoc($totalChecklistsResult);
  $totalChecklists = $row['total_checklists'];
}

// Retrieve the total number of checklists with the status "completed"
$totalCompletedChecklistsQuery = "SELECT COUNT(*) AS total_completed_checklists FROM checklist WHERE username = '$username' AND checklist_status = 'completed'";
$totalCompletedChecklistsResult = mysqli_query($dbconn, $totalCompletedChecklistsQuery);
$totalCompletedChecklists = 0;

if ($totalCompletedChecklistsResult && mysqli_num_rows($totalCompletedChecklistsResult) > 0) {
  $row = mysqli_fetch_assoc($totalCompletedChecklistsResult);
  $totalCompletedChecklists = $row['total_completed_checklists'];
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> User Dashboard </title>
  <link rel="stylesheet" href="style3.css">

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">Wed Gala</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="userprofile.php">
          <i class='bx bxs-user' ></i>
          <span class="links_name"><?php echo $_SESSION['username']; ?></span>
        </a>
      </li>
      <li>
        <a href="user.php" class="active">
          <i class='bx bx-grid-alt' ></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="itinerary.php">
          <i class='bx bx-calendar' ></i>
          <span class="links_name">Itinerary</span>
        </a>
      </li>
      <li>
        <a href="checklist.php?status=all">
          <i class='bx bx-list-check' ></i>
          <span class="links_name">Checklist</span>
        </a>
      </li>
      <li>
        <a href="guestlist.php">
          <i class='bx bx-user-check' ></i>
          <span class="links_name">Guestlist</span>
        </a>
      </li>
      <li>
        <a href="invitation.php">
          <i class='bx bx-mail-send' ></i>
          <span class="links_name">Digital Invite</span>
        </a>
      </li>
      <li>
        <a href="vendor.php">
          <i class='bx bx-store-alt' ></i>
          <span class="links_name">Vendor</span>
        </a>
      </li>
      <li>
        <a href="feedback.php">
          <i class='bx bx-message-detail' ></i>
          <span class="links_name">Feedback</span>
        </a>
      </li>
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

    <div class="main-skills">

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">TOTAL GUESTS:</p>
          <span class="material-symbols-outlined">groups</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $totalPax; ?> guests</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">ATTENDING GUESTS:</p>
          <span class="material-symbols-outlined">person_add</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $totalAttendingPax; ?> guests</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">TOTAL VENDORS:</p>
          <span class="material-symbols-outlined">storefront</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $totalVendors; ?> vendors</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">CHECKLIST ITEMS:</p>
          <span class="material-symbols-outlined">receipt_long</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $totalChecklists; ?> items</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">COMPLETED CHECKLISTS:</p>
          <span class="material-symbols-outlined">checklist</span>
        </div>
        <span class="text-primary font-weight-bold"><?php echo $totalCompletedChecklists; ?> items</span>
      </div>

      </div>

    <section class="main-course">
      <h1>My Planning</h1>
      <div class="course-box">
        <ul>
          <li class="active">In progress</li>
          <!-- <li>explore</li>
          <li>incoming</li>
          <li>finished</li> -->
        </ul>

        <div class="course">

          <div class="box">
            <h3>ITINERARY</h3>
            <div class="whitecard">
              <table>
                <thead>
                  <tr>
                    <th>Time</th>
                    <th>Title</th>
                    <!-- <th>Description</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($itineraryItems as $item) { ?>
                    <tr>
                      <td><?php echo date('H:i A', strtotime($item['time'])); ?></td>
                      <td><?php echo $item['title']; ?></td>
                      <!-- <td><?php echo $item['desc']; ?></td> -->
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <a href="itinerary.php"><button>continue</button></a>
          </div>

          <div class="box">
            <h3>Vendor</h3>
            <div class="whitecard scrollable-table modal-scrollable">
              <table>
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Category</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($vendorItems as $vendor) { ?>
                    <tr>
                      <td><?php echo $vendor['name']; ?></td>
                      <td><?php echo $vendor['category']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <a href="vendor.php"><button>continue</button></a>
          </div>

          <div class="box">
            <h3>Checklist</h3>
            <div class="whitecard scrollable-table modal-scrollable">
              <table>
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($checklistItems as $checklist) { ?>
                    <tr>
                      <td><?php echo $checklist['title']; ?></td>
                      <td><?php echo $checklist['status']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <a href="checklist.php?status=all"><button>continue</button></a>
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

  

</body>
</html>