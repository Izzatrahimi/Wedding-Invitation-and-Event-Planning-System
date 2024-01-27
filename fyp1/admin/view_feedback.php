<?php
include("../connection/dbconn.php");
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> View Feedback </title>
  <link rel="stylesheet" href="style4.css">
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
        <a href="view_user.php" >
          <i class='bx bxs-user-detail'></i>
          <span class="links_name">User</span>
        </a>
      </li>
      <li>
        <a href="view_feedback.php" class="active">
          <i class='bx bx-chat'></i>
          <span class="links_name">Feedback</span>
        </a>
      </li>
      <li>
        <a href="view_message.php" >
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
        <span class="dashboard">Feedback</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search username or category..." id="searchInput">
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

    <div class="main-skills">

      <div class="table-container">
        <div class="table-header">
          <h2>Feedback</h2>
          <button class="add-feedback-btn">+ Add New Feedback</button>
        </div>

        <div class="table-responsive">
          <div class="table-scroll">

            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Category</th>
                  <th>Topic</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php
                $query = "SELECT * FROM feedback";
                $result = mysqli_query($dbconn, $query);
                $counter = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>".$counter."</td>";
                  echo "<td>".$row['username']."</td>";
                  echo "<td>".$row['feedback_category']."</td>";
                  echo "<td>".$row['feedback_topic']."</td>";
                  echo "<td>".$row['feedback_desc']."</td>";
                  echo '<td>';
                  echo '&nbsp;<a href="db_delete_feedback.php?id='.$row['feedback_id'].'" ><button onclick="return confirm(\'Confirm Delete?\')"><i class="bx bx-trash"></i></button></a></td>';
                  echo "</tr>";
                  $counter++;
                }
                mysqli_close($dbconn);
                ?>
              </tbody>
            </table>

            <div id="feedbackNotFound" style="display: none; color: red;">Feedback not found</div>

          </div>
        </div>
      </div>


    </div>

    <!-- Add Feedback Modal -->
    <div id="addFeedbackModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Feedback</h2>
        <form name="add_feedback" method="POST" action="db_add_feedback.php" enctype="multipart/form-data">

          <div class="row">
            <div class="col-50">

              <label for="username"><i class=""></i>Username</label>
              <input type="text" id="username" name="username" placeholder="Enter username" required>

              <label for="feedback_category">Feedback Category</label>
              <select name="feedback_category" id="feedback_category" required>
                <option value="Bug">Bug</option>
                <option value="Feature">Feature</option>
                <option value="Review">Review</option>
              </select>

              <label for="feedback_topic"><i class=""></i>Topic</label>
              <input type="text" id="feedback_topic" name="feedback_topic" placeholder="Enter topic" required>

              <label for="feedback_desc"><i class=""></i>Description</label>
              <textarea type="text" id="feedback_desc" name="feedback_desc" placeholder="Enter description" required></textarea>

            </div>

          </div>

          <input type="submit" name="submit" value="ADD FEEDBACK" class="btn1" onclick="return confirm('Confirm Add?')" />

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

    // Get the modal elements
    const addFeedbackModal = document.getElementById("addFeedbackModal");

    const addFeedbackBtn = document.querySelector(".add-feedback-btn");

    // Get the close button element
    const closeBtns = document.querySelectorAll(".close");

    // Add event listeners for opening modals
    addFeedbackBtn.addEventListener("click", function() {
      addFeedbackModal.style.display = "block";
    });

    // Add event listeners for closing modals
    closeBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        addFeedbackModal.style.display = "none";
        updateFeedbackModal.style.display = "none";
      });
    });


  </script>

  <script>
    // Function to handle the search and update the table
    function searchFeedback() {
      const searchInput = document.getElementById("searchInput").value;
      const tableRows = document.querySelectorAll("tbody tr");
      const feedbackNotFoundMessage = document.getElementById("feedbackNotFound");

      let foundFeedback = false;

      tableRows.forEach(function (row) {
        const username = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
        const category = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
        const topic = row.querySelector("td:nth-child(4)").textContent.toLowerCase();

        if (username.includes(searchInput.toLowerCase()) || 
          category.includes(searchInput.toLowerCase())) {
          row.style.display = "table-row";
        foundFeedback = true;
      } else {
        row.style.display = "none";
      }
    });

      if (!foundFeedback) {
        feedbackNotFoundMessage.style.display = "block";
      } else {
        feedbackNotFoundMessage.style.display = "none";
      }
    }

// Add an event listener to the search input field
    document.getElementById("searchInput").addEventListener("input", searchFeedback);

  </script>

</body>
</html>