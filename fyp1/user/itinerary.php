<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

$username = $_SESSION['username'];

// Retrieve header details for the logged-in user
$query = "SELECT bride, groom, wedding_date, wedding_location FROM header_details WHERE username = '$username'";
$result = mysqli_query($dbconn, $query);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $bride = $row['bride'];
  $groom = $row['groom'];
  $wedding_date = $row['wedding_date'];
  $wedding_location = $row['wedding_location'];
} else {
  // Default values if no header details found
  $bride = "Bride";
  $groom = "Groom";
  $wedding_date = "Wedding Date";
  $wedding_location = "Wedding Location";
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

  <!-- Link to Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
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
        <a href="itinerary.php" class="active">
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
        <span class="dashboard">Itinerary</span>
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
      <div class="itinerary-box">
        <div class="header header-background" onclick="openModal()">
          <!-- Header content -->
          <div id="bridegroom">
            <?php echo $bride; ?>
            <br>
            &
            <br>
            <?php echo $groom; ?>
          </div>
          <h4 id="wedding_date"><?php echo $wedding_date; ?></h4>
          <h4 id="wedding_location"><?php echo $wedding_location; ?></h4>
        </div>
        <div class="content">
          <!-- Itinerary content -->
          <div class="activity-container">

            <table >
              <thead>
                <tr>
                  <th>Time</th>
                  <th>Activity</th>
                  <th>Description</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
  // Retrieve activity details for the logged-in user
                $query = "SELECT activity_id, activity_title, activity_desc, activity_time FROM activity_details WHERE username = '$username'";
                $result = mysqli_query($dbconn, $query);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $activityId = $row['activity_id'];
                    $activityTitle = $row['activity_title'];
                    $activityDesc = $row['activity_desc'];
                    $activityTime = $row['activity_time'];
                    ?>
                    <tr onclick="openEditDeleteForm('<?php echo $activityId; ?>', '<?php echo $activityTitle; ?>', '<?php echo $activityDesc; ?>', '<?php echo $activityTime; ?>')">
                      <td><?php echo date('H:i A', strtotime($activityTime)); ?></td>
                      <td><?php echo $activityTitle; ?></td>
                      <td><?php echo $activityDesc; ?></td>
                    </tr>
                    <?php
                  }
                } else {
    // No activity details found
                  echo "<tr><td colspan='5'>No activities found.</td></tr>";
                }

  // Free the result set
                mysqli_free_result($result);
                ?>
              </tbody>

            </table>

          </div>
        </div>
        <button class="add-button" onclick="openAddForm()">
          <i class='bx bx-plus'></i>
        </button>
      </div>
    </section>

    <!-- Modal Form for edit header -->
    <div id="editModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-itinerary">
          <h2>Edit Details</h2>
          <form id="editForm" method="POST" action="db_edit_header.php">
            <label for="brideInput">Bride:</label>
            <input type="text" id="brideInput" name="brideInput" required>

            <label for="groomInput">Groom:</label>
            <input type="text" id="groomInput" name="groomInput" required>

            <label for="weddingDateInput">Wedding Date:</label>
            <input type="text" id="weddingDateInput" name="weddingDateInput" required>

            <label for="weddingLocationInput">Wedding Location:</label>
            <input type="text" id="weddingLocationInput" name="weddingLocationInput" required>

            <button type="submit" class="btn" onclick="submitForm()">Save</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Form for adding activity -->
    <div id="addModal" class="modal">
      <div class="modal-content">
        <div class="modal-itinerary">
          <span class="close" onclick="closeAddForm()">&times;</span>
          <h2>Add Activity</h2>
          <form id="addForm" method="POST" action="db_add_activity.php">
            <label for="activityTitle">Activity Title:</label>
            <input type="text" id="activityTitle" name="activityTitle" required>

            <label for="activityDescription">Activity Description:</label>
            <textarea id="activityDescription" name="activityDescription" required></textarea>

            <label for="activityTime">Activity Time:</label>
            <input type="time" id="activityTime" name="activityTime" required>

            <button type="submit" class="btn" onclick="submitForm()">Add</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Form for editing and deleting activity -->
    <div id="editdeleteModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeEditDeleteModal()">&times;</span>
        <div class="modal-itinerary">
          <h2>Edit/Delete Form</h2>
          <form id="editdeleteForm" method="POST" action="db_editdelete_activity.php">
            <input type="hidden" id="editdeleteActivityId" name="activityId">

            <label for="editdeleteActivityTitle">Activity Title:</label>
            <input type="text" id="editdeleteActivityTitle" name="activityTitle" required>

            <label for="editdeleteActivityDescription">Activity Description:</label>
            <textarea id="editdeleteActivityDescription" name="activityDescription" required></textarea>

            <label for="editdeleteActivityTime">Activity Time:</label>
            <input type="time" id="editdeleteActivityTime" name="activityTime" required>

            <button type="submit" class="btn" name="action" value="edit">Save</button>
            <button type="submit" class="btn" name="action" value="delete">Delete</button>
          </form>

        </div>
      </div>
    </div>



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

  <script>
    function openModal() {
      document.getElementById("editModal").style.display = "block";
    }

    function closeModal() {
      document.getElementById("editModal").style.display = "none";
    }

    function submitEditForm() {
      document.getElementById("editForm").submit();
    }


    function openAddForm() {
      document.getElementById("addModal").style.display = "block";
    }

    function closeAddForm() {
      document.getElementById("addModal").style.display = "none";
    }

    function submitAddForm() {
      document.getElementById("addForm").submit();
    }
  </script>

  <script>
    function openEditDeleteForm(activityId, activityTitle, activityDesc, activityTime) {
      document.getElementById("editdeleteActivityId").value = activityId;
      document.getElementById("editdeleteActivityTitle").value = activityTitle;
      document.getElementById("editdeleteActivityDescription").value = activityDesc;
      document.getElementById("editdeleteActivityTime").value = activityTime;
      document.getElementById("editdeleteModal").style.display = "block";
    }

    function closeEditDeleteModal() {
      document.getElementById("editdeleteModal").style.display = "none";
    }

    function submitEditDeleteForm() {
      document.getElementById("editdeleteForm").submit();
    }

    function deleteActivity(activityId) {
      if (confirm("Are you sure you want to delete this activity?")) {
        document.getElementById("editdeleteActivityId").value = activityId;
        document.getElementById("editdeleteForm").submit();
      }
    }
  </script>




</body>

</html>