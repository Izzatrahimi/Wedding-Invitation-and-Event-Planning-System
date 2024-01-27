<?php
include("../connection/dbconn.php");
include("../registration/session.php");
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
  <title>View Event Details</title>
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
          <i class='bx bx-grid-alt'></i>
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
        <a href="view_message.php" >
          <i class='bx bx-message-dots' ></i>
          <span class="links_name">Message</span>
        </a>
      </li>
      <li>
        <a href="view_event.php" class="active">
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
        <span class="dashboard">Event Details</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search username..." id="searchInput">
        <i class='bx bx-search'></i>
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
          <h2>Event Details</h2>
          <button class="add-header-details-btn">+ Add New Event Details</button>
        </div>

        <div class="table-responsive">
          <div class="table-scroll">
            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Bride</th>
                  <th>Groom</th>
                  <th>Wedding Date</th>
                  <th>Wedding Location</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <?php
                $query = "SELECT * FROM header_details";
                $result = mysqli_query($dbconn, $query);
                $counter = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>".$counter."</td>";
                  echo "<td>".$row['username']."</td>";
                  echo "<td>".$row['bride']."</td>";
                  echo "<td>".$row['groom']."</td>";
                  echo "<td>".$row['wedding_date']."</td>";
                  echo "<td>".$row['wedding_location']."</td>";
                  echo '<td>';
                  echo '&nbsp;<a href="db_delete_event.php?id='.$row['header_id'].'" ><button onclick="return confirm(\'Confirm Delete?\')"><i class="bx bx-trash"></i></button></a></td>';
                  echo "</tr>";
                  $counter++;
                }
                mysqli_close($dbconn);
                ?>
              </tbody>
            </table>

            <div id="eventDetailsNotFound" style="display: none; color: red;">Event not found</div>

          </div>
        </div>
      </div>
    </div>

    <!-- Add Header Details Modal -->
    <div id="addHeaderDetailsModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Header Details</h2>
        <form name="add_header_details" method="POST" action="db_add_event.php" enctype="multipart/form-data">
          <div class="row">
            <div class="col-50">
              <label for="username"><i class=""></i>Username</label>
              <input type="text" id="username" name="username" placeholder="Enter username" required>

              <label for="bride">Bride</label>
              <input type="text" id="bride" name="bride" placeholder="Enter bride's name" required>

              <label for="groom">Groom</label>
              <input type="text" id="groom" name="groom" placeholder="Enter groom's name" required>

              <label for="wedding_date"><i class=""></i>Wedding Date</label>
              <input type="text" id="wedding_date" name="wedding_date" placeholder="Enter wedding date" required>

              <label for="wedding_location"><i class=""></i>Wedding Location</label>
              <input type="text" id="wedding_location" name="wedding_location" placeholder="Enter wedding location" required>
            </div>
          </div>
          <input type="submit" name="submit" value="ADD HEADER DETAILS" class="btn1" onclick="return confirm('Confirm Add?')" />
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
      if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else {
        sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      }
    }

    // Get the modal elements
    const addHeaderDetailsModal = document.getElementById("addHeaderDetailsModal");

    const addHeaderDetailsBtn = document.querySelector(".add-header-details-btn");

    // Get the close button element
    const closeBtns = document.querySelectorAll(".close");

    // Add event listeners for opening modals
    addHeaderDetailsBtn.addEventListener("click", function() {
      addHeaderDetailsModal.style.display = "block";
    });

    // Add event listeners for closing modals
    closeBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        addHeaderDetailsModal.style.display = "none";
        // updateHeaderDetailsModal.style.display = "none"; // Uncomment if needed
      });
    });
  </script>

  <script>
// Function to handle the search and update the table
function searchEventDetails() {
  const searchInput = document.getElementById("searchInput").value;
  const tableRows = document.querySelectorAll("tbody tr");
  const eventDetailsNotFoundMessage = document.getElementById("eventDetailsNotFound");

  let foundEventDetails = false;

  tableRows.forEach(function (row) {
    const username = row.querySelector("td:nth-child(2)").textContent.toLowerCase();

    if (
      username.includes(searchInput.toLowerCase())
    ) {
      row.style.display = "table-row";
      foundEventDetails = true;
    } else {
      row.style.display = "none";
    }
  });

  if (!foundEventDetails) {
    eventDetailsNotFoundMessage.style.display = "block";
  } else {
    eventDetailsNotFoundMessage.style.display = "none";
  }
}

// Add an event listener to the search input field
document.getElementById("searchInput").addEventListener("input", searchEventDetails);

 

  </script>
</body>
</html>
