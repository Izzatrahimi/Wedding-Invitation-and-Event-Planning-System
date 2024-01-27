<?php
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

// Retrieve user information from the database
$username = $_SESSION['username'];
$query = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($dbconn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
  // Handle error if user information is not found
  // Display an appropriate message or redirect to an error page
}

$row = mysqli_fetch_assoc($result);

// Extract user information
$id = $row['id'];
$email = $row['email'];
$password = $row['password'];
$name = $row['name'];
$phone = $row['phone'];
$level_id = $row['level_id'];
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
</head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">Wed Gala</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="userprofile.php" class="active">
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
        <span class="dashboard">User Profile</span>
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
      <div class="profile-box">
        <h2><?php echo $_SESSION['username']; ?>'s Details</h2>

        <form action="db_update_user.php" method="POST">
          <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" readonly>

          <label for="username">Username:</label>
          <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>

          <label for="email">Email:</label>
          <input type="text" id="email" name="email" value="<?php echo $email; ?>" required>

          <label for="password">Password:</label>
          <input type="text" id="password" name="password" value="<?php echo $password; ?>" required>

          <label for="name">Name:</label>
          <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

          <label for="phone">Phone:</label>
          <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>

          <input type="hidden" id="level_id" name="level_id" value="<?php echo $level_id; ?>" readonly>

          <button type="submit" class="btn1" onclick="submitForm()">Save</button>
        </form>
        
      </div>
      
    </div>

    <section class="main-course">

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