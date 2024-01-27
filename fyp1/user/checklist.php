<?php 
include('../connection/dbconn.php');
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
        <a href="checklist.php?status=all" class="active">
          <i class='bx bx-list-check' class="active"></i>
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
        <a href="feedback.php" >
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
        <span class="dashboard">Checklist</span>
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

    <section class="checklist-section">

      <div class="filter-menu">
        <a href="checklist.php?status=all" class="<?php echo (empty($_GET['status']) || $_GET['status'] === 'all') ? 'active' : ''; ?>">All</a>
        <a href="checklist.php?status=priority" class="<?php echo ($_GET['status'] === 'priority') ? 'active' : ''; ?>">Priority</a>
        <a href="checklist.php?status=upcoming" class="<?php echo ($_GET['status'] === 'upcoming') ? 'active' : ''; ?>">Upcoming</a>
        <a href="checklist.php?status=completed" class="<?php echo ($_GET['status'] === 'completed') ? 'active' : ''; ?>">Completed</a>
      </div>

      <a href="#" class="btn3" onclick="openAddModal()">
        <i class='bx bx-plus'></i>
        <span>Add New Checklist</span>
      </a>


      <!-- Your checklist content will go here -->
      <div class="checklist-box">

        <h1>All Tasks</h1>

        <div class="checklist-content">

          <?php
          // Retrieve checklist data associated with the logged-in user
          $username = $_SESSION['username'];
          $status = isset($_GET['status']) ? $_GET['status'] : 'all'; // Default to 'all' if not set

          $query = "SELECT * FROM checklist WHERE username = '$username'";

          if ($status === 'priority' || $status === 'upcoming' || $status === 'completed') {
            $query .= " AND checklist_status = '$status'";
          }

          $result = mysqli_query($dbconn, $query);

          if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
              $checklistTitle = $row['checklist_title'];
              $checklistDesc = $row['checklist_desc'];
              $checklistStatus = $row['checklist_status'];
              $checklistId = $row['checklist_id'];

              $disabledAttribute = 'disabled';
              

              if ($checkboxStatus = $checklistStatus === 'completed' ? 'checked' : '')
              {
                $disabledAttribute = $checklistStatus === 'completed' ? 'disabled' : '';
              }

              echo '<div class="checklist-item">';
              echo '<input type="checkbox" id="check_' . $row['checklist_id'] . '" ' . $checkboxStatus . ' ' . $disabledAttribute . '>';
              echo '<label class="modal-trigger" for="check_' . $row['checklist_id'] . '">';
              echo '<h3>' . $checklistTitle . '</h3>';
              echo '<p>' . $checklistDesc . '</p>';
              echo '<span class="status">' . $checklistStatus . '</span>';
              echo '</label>';
              echo '</div>';

            }
          } else {
            echo "Error fetching checklist data: " . mysqli_error($dbconn);
          }
          ?>

        </div>

      </div>

    </section>

    <!-- Modal -->
    <div class="modal" id="checklistModal">
      <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Edit Checklist Item</h2>
        <form id="editForm" action="db_update_checklist.php" method="POST">
          <input type="hidden" id="checklistId" name="checklistId">

          <label for="editTitle">Title</label>
          <input type="text" id="editTitle" name="editTitle" class="modal-input" required>

          <label for="editDesc">Description</label>
          <textarea id="editDesc" name="editDesc" class="modal-input" required></textarea>

          <label for="editStatus">Status</label>
          <select id="editStatus" name="editStatus" class="modal-input" required>
            <option value="priority">Priority</option>
            <option value="upcoming">Upcoming</option>
            <option value="completed">Completed</option>
          </select>

          <button type="submit" class="btn">Save</button>
          <button type="button" class="btn delete-btn" id="deleteBtn" onclick="deleteChecklist()">Delete</button>
          <input type="hidden" id="deleteChecklistId" name="deleteChecklistId">

        </form>
      </div>
    </div>

    <!-- Add Modal -->
    <div class="modal" id="addChecklistModal">
      <div class="modal-content">
        <span class="close" id="closeAddModal">&times;</span>
        <h2>Add New Checklist</h2>
        <form id="addForm" action="db_add_checklist.php" method="POST" onsubmit="return confirm('Are you sure you want to add this to the checklist?')">
          <label for="addTitle">Title</label>
          <input type="text" id="addTitle" name="addTitle" class="modal-input" required>
          <label for="addDesc">Description</label>
          <textarea id="addDesc" name="addDesc" class="modal-input" required></textarea>
          <label for="addStatus">Status</label>
          <select id="addStatus" name="addStatus" class="modal-input" required>
            <option value="priority">Priority</option>
            <option value="upcoming">Upcoming</option>
            <option value="completed">Completed</option>
          </select>
          <button type="submit" class="btn">Add</button>
        </form>
      </div>
    </div>

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
  // Function to open the modal
    function openModal(checklistId, title, desc, status) {
      document.getElementById('checklistId').value = checklistId;
      document.getElementById('editTitle').value = title;
      document.getElementById('editDesc').value = desc;
      document.getElementById('editStatus').value = status;
      document.getElementById('checklistModal').style.display = 'block';
    }

  // Function to close the modal
    function closeModal() {
      document.getElementById('checklistModal').style.display = 'none';
    }

  // Function to submit the form
    function submitForm() {
      document.getElementById('editForm').submit();
    }

  // Add click event listeners to checklist items
    const checklistItems = document.querySelectorAll('.checklist-item');
    checklistItems.forEach(item => {
      item.addEventListener('click', () => {
        const checklistId = item.querySelector('input[type="checkbox"]').id.replace('check_', '');
        const title = item.querySelector('h3').textContent;
        const desc = item.querySelector('p').textContent;
        const status = item.querySelector('.status').textContent;
        openModal(checklistId, title, desc, status);
      });
    });

  // Close modal when the close button is clicked
    document.getElementById('closeModal').addEventListener('click', () => {
      closeModal();
    });

  // Close modal if clicked outside the modal content
    window.addEventListener('click', event => {
      const modal = document.getElementById('checklistModal');
      if (event.target === modal) {
        closeModal();
      }
    });

  // Prevent modal content click from closing modal
    document.querySelector('.modal-content').addEventListener('click', event => {
      event.stopPropagation();
    });
  </script>

  <script>

    function deleteChecklist() {
      const checklistId = document.getElementById('checklistId').value;

      if (confirm("Are you sure you want to delete this checklist item?")) {
        document.getElementById('deleteChecklistId').value = checklistId;
        document.getElementById('editForm').action = 'db_delete_checklist.php';
        document.getElementById('editForm').submit();
      }
    }

  </script>

  <script >

    // Function to open the add checklist modal
    function openAddModal() {
      document.getElementById('addChecklistModal').style.display = 'block';
    }

// Function to close the add checklist modal
    function closeAddModal() {
      document.getElementById('addChecklistModal').style.display = 'none';
    }

// Open add checklist modal when the "Add New Checklist" button is clicked
      document.querySelector('.btn3').addEventListener('click', () => {
        openAddModal();
      });

// Close add checklist modal when the close button is clicked
      document.getElementById('closeAddModal').addEventListener('click', () => {
        closeAddModal();
      });

// Close add checklist modal if clicked outside the modal content
      window.addEventListener('click', event => {
        const modal = document.getElementById('addChecklistModal');
        if (event.target === modal) {
          closeAddModal();
        }
      });

// Prevent modal content click from closing modal
      document.querySelector('#addChecklistModal .modal-content').addEventListener('click', event => {
        event.stopPropagation();
      });



    </script>


  </body>
  </html>