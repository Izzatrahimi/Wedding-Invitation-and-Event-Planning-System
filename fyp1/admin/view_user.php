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
  <title> View User Details </title>
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
        <a href="#" class="active">
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
        <span class="dashboard">User Details</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search username or email..." id="searchInput">
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
          <h2>User Details</h2>
          <button class="add-user-btn">+ Add New User</button>
        </div>

        <div class="table-responsive">
          <div class="table-scroll">

            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Password</th>
                  <th>Name</th>
                  <th>Phone Number</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <tbody>
                <!-- PHP code to retrieve and display user data -->
                <?php

                $query = "SELECT * FROM user";
                $result = mysqli_query($dbconn, $query);
                $counter = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>".$counter."</td>";
                  echo "<td>".$row['username']."</td>";
                  echo "<td>".$row['email']."</td>";
                  echo "<td>".$row['password']."</td>";
                  echo "<td>".$row['name']."</td>";
                  echo "<td>".$row['phone']."</td>";
                  echo "<td>".$row['level_id']."</td>";
                  echo '<td><button class="edit-user-btn" data-id="'.$row['id'].'"><i class="bx bx-edit"></i></button>';
                  echo '&nbsp;<a href="db_delete_user.php?id='.$row['id'].'" ><button onclick="return confirm(\'Confirm Delete?\')"><i class="bx bx-trash"></i></button></a></td>';
                  echo "</tr>";
                  $counter++;
                }


                mysqli_close($dbconn);
                ?>
              </tbody>
            </table>

            <div id="userNotFound" style="display: none; color: red;">User not found</div>

          </div>
        </div>
      </div>

    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New User</h2>
        <form name="add_user" method="POST" action="db_add_user.php" enctype="multipart/form-data">

          <div class="row">
            <div class="col-50">

              <label for="username"><i class=""></i>Username</label>
              <input type="text" id="username" name="username" placeholder="Enter username" required>

              <label for="email"><i class=""></i> Email</label>
              <input type="text" id="email" name="email" placeholder="Email address" required>

              <label for="password"><i class=""></i>Password</label>
              <input type="text" id="password" name="password" placeholder="Enter password" required>

              <label for="name"><i class=""></i>Name</label>
              <input type="text" id="name" name="name" placeholder="Enter full name" required>

              <label for="contact"><i class=""></i> Contact</label>
              <input type="text" id="phone" name="phone" placeholder="Phone number" required>

              <label for="role">Account Role</label>
              <select name="level_id" id="level_id" required>
                <option value="1">Admin</option>
                <option value="2">User</option>
              </select>

            </div>

          </div>

          <input type="submit" name="submit" value="ADD USER" class="btn1" onclick="return confirm('Confirm Add?')" />

        </form>
      </div>
    </div>

    <!-- Update User Modal -->
    <div id="updateUserModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update User Details</h2>
        <form name="edit_user" method="POST" action="db_update_user.php" enctype="multipart/form-data">

          <div class="row">
            <div class="col-50">

              <input type="hidden" id="id" name="id" placeholder="User ID"/>

              <label for="usernameUpdate"><i class=""></i>Username</label>
              <input type="text" id="usernameUpdate" name="username"  placeholder="Enter username" required />

              <label for="emailUpdate"><i class=""></i> Email</label>
              <input type="text" id="emailUpdate" name="email"  placeholder="Email address" required />

              <label for="passwordUpdate"><i class=""></i>Password</label>
              <input type="text" id="passwordUpdate" name="password"  placeholder="Enter password" required />

              <label for="nameUpdate"><i class=""></i>Name</label>
              <input type="text" id="nameUpdate" name="name"  placeholder="Enter full name" required />

              <label for="contactUpdate"><i class=""></i> Contact</label>
              <input type="text" id="phoneUpdate" name="phone"  pattern="[0-9]{3}-[0-9]{7}" placeholder="Phone number" required />

              <label for="roleUpdate">Account Role</label>
              <select name="level_id" id="level_id">
                <option value="1">Admin</option>
                <option value="2">User</option>
              </select>

            </div>

          </div>

          <input type="submit" name="submit" value="Save" class="btn1" onclick="return confirm('Confirm Update?')"/>

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
    const addUserModal = document.getElementById("addUserModal");
    const updateUserModal = document.getElementById("updateUserModal");

    // Get the button elements
    const addUserBtn = document.querySelector(".add-user-btn");
    const editUserBtns = document.querySelectorAll(".edit-user-btn");

    // Get the close button element
    const closeBtns = document.querySelectorAll(".close");

    // Add event listeners for opening modals
    addUserBtn.addEventListener("click", function() {
      addUserModal.style.display = "block";
    });

    editUserBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        const userId = btn.getAttribute("data-id");
        // Perform AJAX request to fetch user data using userId
        // Populate the input fields in updateUserModal with the fetched user data
        updateUserModal.style.display = "block";
      });
    });

    // Add event listeners for closing modals
    closeBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        addUserModal.style.display = "none";
        updateUserModal.style.display = "none";
      });
    });


/*This code adds an event listener to each edit user button. When clicked, it retrieves the user's ID from the button's data attribute. 
It then performs an AJAX request to db_fetch_user.php passing the user ID as a parameter. 
The response from the AJAX request is parsed as JSON, and the data is used to populate the input fields in the updateUserModal.*/

    editUserBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        const userId = btn.getAttribute("data-id");
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            const user = JSON.parse(xhr.responseText);
            document.getElementById("id").value = user.id;
            document.getElementById("usernameUpdate").value = user.username;
            document.getElementById("emailUpdate").value = user.email;
            document.getElementById("passwordUpdate").value = user.password;
            document.getElementById("nameUpdate").value = user.name;
            document.getElementById("phoneUpdate").value = user.phone;
            document.getElementById("level_id").value = user.level_id;
            updateUserModal.style.display = "block";
          }
        };
        xhr.open("GET", "db_fetch_user.php?id=" + userId, true);
        xhr.send();
      });
    });



  </script>
  <script>
    // Function to handle the search and update the table
    function searchUsers() {
      const searchInput = document.getElementById("searchInput").value;
      const tableRows = document.querySelectorAll("tbody tr");
      const userNotFoundMessage = document.getElementById("userNotFound");

      let foundUser = false;

      tableRows.forEach(function(row) {
        const username = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
        const email = row.querySelector("td:nth-child(3)").textContent.toLowerCase();

        if (username.includes(searchInput.toLowerCase()) || email.includes(searchInput.toLowerCase())) {
          row.style.display = "table-row";
          foundUser = true;
        } else {
          row.style.display = "none";
        }
      });

      if (!foundUser) {
        userNotFoundMessage.style.display = "block";
      } else {
        userNotFoundMessage.style.display = "none";
      }

    }

    // Add an event listener to the search input field
    document.getElementById("searchInput").addEventListener("input", searchUsers);

  </script>

</body>
</html>