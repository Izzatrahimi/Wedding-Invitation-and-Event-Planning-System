<?php 
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

// Retrieve feedback data from the database
$query = "SELECT * FROM feedback WHERE username = '{$_SESSION['username']}'";
$result = mysqli_query($dbconn, $query);

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
        <a href="vendor.php">
          <i class='bx bx-store-alt' ></i>
          <span class="links_name">Vendor</span>
        </a>
      </li>
      <li>
        <a href="feedback.php" class="active">
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
        <span class="dashboard">Feedback</span>
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

    <section class="blog" id="blog" style="padding-top: 80px;">

      <button class="btn2" id="addFeedback" onclick="displayModal()">+ ADD FEEDBACK</button>


      <div id="modal" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModal()">&times;</span>
          <h2>Feedback Form</h2>
          <p class="border">Please enter your feedback.</p>
          <form id="feedbackForm" method="POST" action="db_add_feedback.php">
            <label for="feedback_category">I would like to</label>
            <select name="feedback_category" id="feedback_category" required>
              <option value="review">Leave a review</option>
              <option value="feature">Request a feature</option>
              <option value="bug">Report a bug</option>
            </select>

            <label for="feedback_topic">Topic:</label>
            <input type="text" id="feedback_topic" name="feedback_topic" required>

            <label for="feedback_description">Description:</label>
            <textarea type="text" id="feedback_description" name="feedback_description" required></textarea>

            <button type="submit" class="btn1">Save</button>
          </form>
        </div>
      </div>

      <div class="feedback-box">
        <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Category</th>
              <th>Topic</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <?php
// Display feedback data in table rows
            $counter = 1; // Initialize counter variable
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $counter . "</td>"; // Display the counter value
              echo "<td>" . $row['feedback_category'] . "</td>";
              echo "<td>" . $row['feedback_topic'] . "</td>"; 
              echo "<td>" . $row['feedback_desc'] . "</td>"; 
              echo "</tr>";
              $counter++; // Increment the counter
            }
            ?>
          </tbody>
        </table>
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

  <script>
// Function to display the modal
    function displayModal() {
      document.getElementById("modal").style.display = "block";
    }

// Function to close the modal
    function closeModal() {
      document.getElementById("modal").style.display = "none";
    }
  </script>



</body>
</html>