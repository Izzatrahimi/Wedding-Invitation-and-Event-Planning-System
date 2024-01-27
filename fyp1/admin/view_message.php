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
  <title> View Message </title>
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
        <a href="view_feedback.php">
          <i class='bx bx-chat'></i>
          <span class="links_name">Feedback</span>
        </a>
      </li>
      <li>
        <a href="view_message.php" class="active">
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
        <span class="dashboard">Message</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search name, email or phone..." id="searchInput">
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
          <h2>Message</h2>
          <button class="add-message-btn">+ Add New Message</button>
        </div>

        <div class="table-responsive">
          <div class="table-scroll">

            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT * FROM message";
                $result = mysqli_query($dbconn, $query);
                $counter = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>".$counter."</td>";
                  echo "<td>".$row['message_name']."</td>";
                  echo "<td>".$row['message_email']."</td>";
                  echo "<td>".$row['message_phone']."</td>";
                  echo "<td>".$row['message_address']."</td>";
                  echo "<td>".$row['message_desc']."</td>";
                  echo '<td>';
                  echo '&nbsp;<a href="db_delete_message.php?id='.$row['message_id'].'" ><button onclick="return confirm(\'Confirm Delete?\')"><i class="bx bx-trash"></i></button></a></td>';
                  echo "</tr>";
                  $counter++;
                }
                mysqli_close($dbconn);
                ?>
              </tbody>
            </table>

            <div id="eventDetailsNotFound" style="display: none; color: red;">Event details not found</div>

          </div>
        </div>
      </div>

    </div>

    <!-- Add Message Modal -->
    <div id="addMessageModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Message</h2>
        <form name="add_message" method="POST" action="db_add_message.php" enctype="multipart/form-data">

          <div class="row">
            <div class="col-50">
              <label for="message_name"><i class=""></i>Name</label>
              <input type="text" id="message_name" name="message_name" placeholder="Enter name" required>

              <label for="message_email">Email</label>
              <input type="text" id="message_email" name="message_email" placeholder="Enter email" required>

              <label for="message_phone">Phone</label>
              <input type="text" id="message_phone" name="message_phone" placeholder="Enter phone" required>

              <label for="message_address">Address</label>
              <input type="text" id="message_address" name="message_address" placeholder="Enter address" required>

              <label for="message_desc">Description</label>
              <textarea id="message_desc" name="message_desc" placeholder="Enter description" required></textarea>
            </div>
          </div>

          <input type="submit" name="submit" value="ADD MESSAGE" class="btn1" onclick="return confirm('Confirm Add?')" />
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
    const addMessageModal = document.getElementById("addMessageModal");

    const addMessageBtn = document.querySelector(".add-message-btn");

    // Add event listeners for opening modals
    addMessageBtn.addEventListener("click", function() {
      addMessageModal.style.display = "block";
    });

    // Get the close button elements
    const closeBtns = document.querySelectorAll(".close");

  // Add event listeners for closing modals
    closeBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        addMessageModal.style.display = "none";
      });
    });

  // Close the modal if the user clicks anywhere outside of it
    window.addEventListener("click", function(event) {
      if (event.target == addMessageModal) {
        addMessageModal.style.display = "none";
      }
    });

  </script>

  <script>
    // Function to handle the search and update the table
    function searchMessages() {
      const searchInput = document.getElementById("searchInput").value;
      const tableRows = document.querySelectorAll("tbody tr");
      const messageNotFoundMessage = document.getElementById("messageNotFound");

      let foundMessages = false;

      tableRows.forEach(function (row) {
        const name = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
        const email = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
        const phone = row.querySelector("td:nth-child(4)").textContent.toLowerCase();

        if (
          name.includes(searchInput.toLowerCase()) ||
          email.includes(searchInput.toLowerCase()) ||
          phone.includes(searchInput.toLowerCase())
          ) {
          row.style.display = "table-row";
        foundMessages = true;
      } else {
        row.style.display = "none";
      }
    });

      if (!foundMessages) {
        messageNotFoundMessage.style.display = "block";
      } else {
        messageNotFoundMessage.style.display = "none";
      }
    }

    // Add an event listener to the search input field
    document.getElementById("searchInput").addEventListener("input", searchMessages);

  </script>

</body>
</html>