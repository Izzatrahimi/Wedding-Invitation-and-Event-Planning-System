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
  <title> View Vendor Details </title>
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
        <a href="view_vendor.php" class="active">
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
        <span class="dashboard">Vendor</span>
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

    <div class="main-skills">

      <div class="table-container">
        <div class="table-header">
          <h2>Vendor Details</h2>
          <button class="add-vendor-btn">+ Add New Vendor</button>
        </div>

        <div class="table-responsive">
          <div class="table-scroll">

            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Category</th>
                  <th>Link</th>
                  <th>Notes</th>
                  <th>Image</th>
                  <th>Username</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <tbody>
                <!-- PHP code to retrieve and display user data -->
                <?php

                $query = "SELECT * FROM vendor";
                $result = mysqli_query($dbconn, $query);
                $counter = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>".$counter."</td>";
                  echo "<td>".$row['vendor_name']."</td>";
                  echo "<td>".$row['vendor_price']."</td>";
                  echo "<td>".$row['vendor_email']."</td>";
                  echo "<td>".$row['vendor_contact']."</td>";
                  echo "<td>".$row['vendor_category']."</td>";
                  echo "<td>".$row['vendor_link']."</td>";
                  echo "<td>".$row['notes']."</td>";
                  echo "<td>".$row['vendor_image']."</td>";
                  echo "<td>".$row['username']."</td>";
                  echo '<td><button class="edit-vendor-btn" data-id="'.$row['vendor_id'].'"><i class="bx bx-edit"></i></button>';
                  echo '<a href="db_delete_vendor.php?id='.$row['vendor_id'].'" ><button onclick="return confirm(\'Confirm Delete?\')"><i class="bx bx-trash"></i></button></a></td>';
                  echo "</tr>";
                  $counter++;
                }


                mysqli_close($dbconn);
                ?>
              </tbody>
            </table>

          </div>
        </div>
      </div>

    </div>

    <!-- Add Vendor Modal -->
    <div id="addVendorModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Vendor</h2>
        <form name="add_vendor" method="POST" action="db_add_vendor.php" enctype="multipart/form-data">

          <div class="row">
            <div class="col-50">

              <label for="vendor_name"><i class=""></i>Name</label>
              <input type="text" id="vendor_name" name="vendor_name" placeholder="Enter vendor name" required>

              <label for="vendor_price"><i class=""></i>Price</label>
              <input type="text" id="vendor_price" name="vendor_price" placeholder="Enter vendor price" required>

              <label for="vendor_email"><i class=""></i>Email</label>
              <input type="text" id="vendor_email" name="vendor_email" placeholder="Enter vendor email" required>

              <label for="vendor_contact"><i class=""></i>Contact</label>
              <input type="text" id="vendor_contact" name="vendor_contact" placeholder="Enter vendor contact" required>

              <label for="vendor_category">Vendor Category</label>
              <select name="vendor_category" id="vendor_category" required>
                <option value="Venue">Venue</option>
                <option value="Caterer">Caterer</option>
                <option value="Photographer">Photographer</option>
                <option value="Brideswear">Brideswear</option>
                <option value="Groomswear">Groomswear</option>
                <option value="Planner">Planner</option>
                <option value="Make Up Artist">Make Up Artist</option>
                <option value="Door Gift">Door Gift</option>
                <option value="Florist">Florist</option>
                <option value="Cake">Cake</option>
                <option value="Videographer">Videographer</option>
                <option value="Musican">Musican</option>
                <option value="Decoration">Decoration</option>
              </select>

              <label for="vendor_link"><i class=""></i>Link</label>
              <input type="text" id="vendor_link" name="vendor_link" placeholder="Enter vendor link" required>

              <label for="notes"><i class=""></i>Notes</label>
              <input type="text" id="notes" name="notes" placeholder="Enter notes" required>

              <label for="username"><i class=""></i>Username</label>
              <input type="text" id="username" name="username" placeholder="Enter username" required>

              <label for="vendor_image"><i class=""></i>Image</label>
              <input type="file" id="vendor_image" name="vendor_image" accept="image/*" required>

            </div>

          </div>

          <input type="submit" name="submit" value="ADD VENDOR" class="btn1" onclick="return confirm('Confirm Add?')" />

        </form>
      </div>
    </div>

    <!-- Update Vendor Modal -->
    <div id="updateVendorModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update User Details</h2>
        <form name="edit_vendor" method="POST" action="db_update_vendor.php" enctype="multipart/form-data">

          <div class="row">
            <div class="col-50">

              <input type="hidden" id="vendor_id" name="vendor_id" placeholder="Vendor ID"/>

              <label for="vendor_nameUpdate"><i class=""></i>Name</label>
              <input type="text" id="vendor_nameUpdate" name="vendor_name"  placeholder="Enter vendor name" required />

              <label for="vendor_priceUpdate"><i class=""></i>Price</label>
              <input type="text" id="vendor_priceUpdate" name="vendor_price"  placeholder="Email vendor price" required />

              <label for="vendor_emailUpdate"><i class=""></i>Email</label>
              <input type="text" id="vendor_emailUpdate" name="vendor_email"  placeholder="Enter vendor email" required />

              <label for="vendor_contactUpdate"><i class=""></i> Contact</label>
              <input type="text" id="vendor_contactUpdate" name="vendor_contact"  pattern="[0-9]{3}-[0-9]{7}" placeholder="Phone number" required />

              <label for="vendor_categoryUpdate">Vendor Category</label>
              <select name="vendor_category" id="vendor_categoryUpdate" required>
                <option value="Venue">Venue</option>
                <option value="Caterer">Caterer</option>
                <option value="Photographer">Photographer</option>
                <option value="Brideswear">Brideswear</option>
                <option value="Groomswear">Groomswear</option>
                <option value="Planner">Planner</option>
                <option value="Make Up Artist">Make Up Artist</option>
                <option value="Door Gift">Door Gift</option>
                <option value="Florist">Florist</option>
                <option value="Cake">Cake</option>
                <option value="Videographer">Videographer</option>
                <option value="Musican">Musican</option>
                <option value="Decoration">Decoration</option>
              </select>

              <label for="vendor_linkUpdate"><i class=""></i>Link</label>
              <input type="text" id="vendor_linkUpdate" name="vendor_link" placeholder="Enter vendor link" required>

              <label for="notesUpdate"><i class=""></i>Notes</label>
              <input type="text" id="notesUpdate" name="notes" placeholder="Enter notes" required>

              <label for="usernameUpdate"><i class=""></i>Username</label>
              <input type="text" id="usernameUpdate" name="username" placeholder="Enter username" required>

              <label for="vendor_imageUpdate"><i class=""></i>Image</label>
              <input type="file" id="vendor_imageUpdate" name="vendor_image" accept="image/*" required>

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
    const addVendorModal = document.getElementById("addVendorModal");
    const updateVendorModal = document.getElementById("updateVendorModal");

    // Get the button elements
    const addVendorBtn = document.querySelector(".add-vendor-btn");
    const editVendorBtns = document.querySelectorAll(".edit-vendor-btn");

    // Get the close button element
    const closeBtns = document.querySelectorAll(".close");

    // Add event listeners for opening modals
    addVendorBtn.addEventListener("click", function() {
      addVendorModal.style.display = "block";
    });

    editVendorBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        const vendorId = btn.getAttribute("data-id");
        // Perform AJAX request to fetch vendor data using vendorId
        // Populate the input fields in updateVendorModal with the fetched vendor data
        updateVendorModal.style.display = "block";
      });
    });

    // Add event listeners for closing modals
    closeBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        addVendorModal.style.display = "none";
        updateVendorModal.style.display = "none";
      });
    });


/*This code adds an event listener to each edit vendor button. When clicked, it retrieves the vendor's ID from the button's data attribute. 
It then performs an AJAX request to db_fetch_vendor.php passing the vendor ID as a parameter. 
The response from the AJAX request is parsed as JSON, and the data is used to populate the input fields in the updateVendorModal.*/

    editVendorBtns.forEach(function(btn) {
      btn.addEventListener("click", function() {
        const vendorId = btn.getAttribute("data-id");
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            const vendor = JSON.parse(xhr.responseText);
            document.getElementById("vendor_id").value = vendor.vendor_id;
            document.getElementById("vendor_nameUpdate").value = vendor.vendor_name;
            document.getElementById("vendor_priceUpdate").value = vendor.vendor_price;
            document.getElementById("vendor_emailUpdate").value = vendor.vendor_email;
            document.getElementById("vendor_contactUpdate").value = vendor.vendor_contact;
            document.getElementById("vendor_categoryUpdate").value = vendor.vendor_category;
            document.getElementById("vendor_linkUpdate").value = vendor.vendor_link;
            document.getElementById("notesUpdate").value = vendor.notes;
            document.getElementById("usernameUpdate").value = vendor.username;
            document.getElementById("vendor_imageUpdate").src = vendor.vendor_image;
            updateUserModal.style.display = "block";
          }
        };
        xhr.open("GET", "db_fetch_vendor.php?id=" + vendorId, true);
        xhr.send();
      });
    });



  </script>

</body>
</html>