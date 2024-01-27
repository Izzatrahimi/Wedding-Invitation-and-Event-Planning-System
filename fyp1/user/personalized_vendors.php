<?php
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
}

$username = $_SESSION['username'];

// Retrieve vendor information from the database
$sql = "SELECT * FROM vendor WHERE username = '$username'";
$result = mysqli_query($dbconn, $sql);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personalized Vendors</title>
  <link rel="stylesheet" href="style3.css">
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
      <li>
        <a href="userprofile.php">
          <i class='bx bxs-user' ></i>
          <span class="links_name"><?php echo $_SESSION['username']; ?></span>
        </a>
      </li>
      <li>
        <a href="user.php">
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
        <a href="vendor.php" class="active">
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
        <span class="dashboard">Personalized Vendors</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>
      <div class="profile-details">
        <!-- <img src="images/profile.jpg" alt=""> -->
        <i class='bx bxs-user'></i>
        <span class="admin_name">
          <?php echo $_SESSION['username']; ?>
        </span>
      </div>
    </nav>

    <section class="blog" id="blog" style="padding-top: 80px;">

      <!-- Trigger/Open The Modal -->
      <a href="vendor.php"><button class="btn2">BACK</button></a>

      <!-- Wedding budget form -->
      <div class="budget-form-container">
        <h2>Wedding Budget</h2>
        <form id="budget-form" method="POST" action="db_personalized_vendors.php?vendors=true">
          <label for="wedding-budget">Enter your budget:</label>
          <input type="number" id="wedding-budget" name="wedding_budget" required>
          <!-- Add a tooltip container -->
          <div class="tooltip-container">
            <button type="submit" class="submit-button">Submit</button>
            <!-- Add a tooltip element with the message -->
            <div class="tooltip">Personalized Vendors feature selects the cheapest vendor from each available category.</div>
          </div>
        </form>
      </div>

      <div class="box-container">
        <?php

        // Check if vendors data is present in the URL
        if (isset($_GET['vendors'])) {
          // Retrieve the serialized vendors data from the URL and unserialize it
          $selectedVendors = unserialize(urldecode($_GET['vendors']));

          // Check if $selectedVendors is an array
          if (is_array($selectedVendors)) {

            // Loop through each selected vendor
            foreach ($selectedVendors as $vendor) {
              $vendorName = $vendor['vendor_name'];
              $vendorImage = $vendor['vendor_image'];
              $vendorPrice = $vendor['vendor_price'];
              $vendorEmail = $vendor['vendor_email'];
              $vendorContact = $vendor['vendor_contact'];
              $vendorCategory = $vendor['vendor_category'];
              $vendorLink = $vendor['vendor_link'];
              $vendorNotes = $vendor['notes'];

              // Display the vendor information in a box
              echo '<div class="vendor-box">';
              echo '<img src="' . $vendorImage . '" alt="' . $vendorName . '">';
              echo '<h3>' . $vendorName . '</h3>';

              // Display labels and information
              echo '<div class="vendor-info">';
              echo '<label>Price:</label>';
              echo '<p>RM ' . $vendorPrice . '</p>';

              echo '<label>Email:</label>';
              echo '<p>' . $vendorEmail . '</p>';

              echo '<label>Contact:</label>';
              echo '<p>' . $vendorContact . '</p>';

              echo '<label>Category:</label>';
              echo '<p>' . $vendorCategory . '</p>';

              echo '<label>Link:</label>';
              echo '<p>' . $vendorLink . '</p>';

              echo '<label>Notes:</label>';
              echo '<p>' . $vendorNotes . '</p>';

              echo '</div>';

              echo '</div>'; 

              
            }

          } else {
            echo "Not enough budget amount. No vendors will be selected.";
          }

        }
        ?>
      </div>


    </section>


  </section>

  <script >
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