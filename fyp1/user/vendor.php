<?php
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
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
        <span class="dashboard">Vendor Shortlist</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search name..." id="searchInput">
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

    <section class="blog" id="blog" style="padding-top: 80px;">

      <!-- Trigger/Open The Modal -->
      <button class="btn2" id="myBtn">+ ADD VENDOR</button>

      <a href="personalized_vendors.php"><button class="btn2" style="margin-left: 0px;">PERSONALIZATION</button></a>

      <!-- Vendor Category Section -->
      <div class="vendor-category modal-scrollable">
        <div class="category-list-container">
          <ul class="category-list">
            <li class="category-item active">All</li>
            <li class="category-item">Venue</li>
            <li class="category-item">Caterer</li>
            <li class="category-item">Photographer</li>
            <li class="category-item">Brideswear</li>
            <li class="category-item">Groomswear</li>
            <li class="category-item">Planner</li>
            <li class="category-item">Make Up Artist</li>
            <li class="category-item">Door Gift</li>
            <li class="category-item">Florist</li>
            <li class="category-item">Cake</li>
            <li class="category-item">Videographer</li>
            <li class="category-item">Musician</li>
            <li class="category-item">Decoration</li>
          </ul>
        </div>
      </div>


      <!-- The ADD VENDOR Modal -->
      <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Add Vendor</h2>
          <p>Please input the vendor details.</p>
          <div class="row">
            <div class="col-75">
              <div class="container1">

                <form name="add_vendor" method="POST" action="db_add_vendor.php" enctype="multipart/form-data">

                  <div class="row">
                    <div class="col-50">

                      <label for="vendor"><i class="fa fa-user"></i>Title</label>
                      <input type="text" id="vendor" name="vendor_name" placeholder="Vendor name" required>
                      <label for="price"><i class="fa fa-user"></i>Price</label>
                      <input type="text" id="price" name="vendor_price" placeholder="RM 0.00" required>
                      <label for="email"><i class="fa fa-envelope"></i> Email</label>
                      <input type="text" id="email" name="vendor_email" placeholder="Email address" required>

                    </div>

                    <div class="col-50">

                      <label for="contact"><i class="fa fa-address-card-o"></i> Contact</label>
                      <input type="text" id="contact" name="vendor_contact" placeholder="Phone number" required>

                      <label for="category">Category</label>
                      <select name="vendor_category" id="category" required>
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
                        <option value="Musician">Musician</option>
                        <option value="Decoration">Decoration</option>
                      </select>


                      <label for="link">Link</label>
                      <input type="text" id="link" name="vendor_link" placeholder="http://" required>

                    </div>

                  </div>

                  <div class="container1" style="padding: 10px">

                    <label for="notes"><i class="fa fa-user"></i>Notes</label>
                    <textarea rows="4" cols="50" name="notes" required>Enter notes here...</textarea>

                    <label for="image"><i class="fa fa-image"></i> Image</label>
                    <input type="file" id="image" name="vendor_image" accept="image/*" required>

                  </div>


                  <input type="submit" name="submit" value="ADD VENDOR" class="btn1" onclick="return confirm('Confirm user details?')" >

                </form>

              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Vendor boxes -->
      <div class="box-container" >
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
          $vendorId = $row['vendor_id'];
          $vendorName = $row['vendor_name'];
          $vendorPrice = $row['vendor_price'];
          $vendorEmail = $row['vendor_email'];
          $vendorContact = $row['vendor_contact'];
          $vendorCategory = $row['vendor_category'];
          $vendorLink = $row['vendor_link'];
          $vendorNotes = $row['notes'];
          $vendorImage = $row['vendor_image'];
          ?>

          <!-- Vendor Box -->
          <div class="box" data-category="<?php echo $vendorCategory; ?>" data-vendor-id="<?php echo $vendorId; ?>">
            <!-- Display vendor information -->
            <h3><?php echo $vendorName; ?></h3>
            <img src="<?php echo $vendorImage; ?>">
            <p>Price: RM <?php echo $vendorPrice; ?></p>
            <p>Email: <?php echo $vendorEmail; ?></p>
            <p>Contact: <?php echo $vendorContact; ?></p>
            <p>Category: <?php echo $vendorCategory; ?></p>
            <p>Link: <?php echo $vendorLink; ?></p>
            <p>Notes: <?php echo $vendorNotes; ?></p>

            <!-- View Button -->
            <button class="view-btn" onclick="openViewModal('<?php echo $vendorId; ?>', '<?php echo $vendorName; ?>', '<?php echo $vendorPrice; ?>', '<?php echo $vendorEmail; ?>', '<?php echo $vendorContact; ?>', '<?php echo $vendorCategory; ?>', '<?php echo $vendorLink; ?>', '<?php echo $vendorNotes; ?>', '<?php echo $vendorImage; ?>');">View</button>

            <!-- Delete Button -->
            <form method="POST" action="db_delete_vendor.php" style="display: inline;">
              <input type="hidden" name="vendor_id" value="<?php echo $vendorId; ?>">
              <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this vendor?')">Delete</button>
            </form>


          </div>

          <?php
        }
        ?>
      </div>

      <div id="noResultsMessage" style="display: none; color: red; text-align: center;">No vendors found</div>


      <!-- The View Vendor Modal -->
      <div id="viewModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Vendor Details</h2>
          <!-- Populate input fields with vendor information -->
          <form id="vendorForm" name="vendorForm" method="POST" action="db_update_vendor.php">
            <div class="row">

              <input type="hidden" id="vendorId" name="vendor_id">

              <label for="vendorName">Name:</label>
              <input type="text" id="vendorName" name="vendor_name" required>

              <label for="vendorPrice">Price(RM):</label>
              <input type="text" id="vendorPrice" name="vendor_price" required>

              <label for="vendorEmail">Email:</label>
              <input type="text" id="vendorEmail" name="vendor_email" required>

              <label for="vendorContact">Contact:</label>
              <input type="text" id="vendorContact" name="vendor_contact" required>

              <label for="vendorCategory">Category:</label>
              <select type="text" id="vendorCategory" name="vendor_category" required>
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
                <option value="Musician">Musician</option>
                <option value="Decoration">Decoration</option>
              </select>

              <label for="vendorLink">Link:</label>
              <input type="text" id="vendorLink" name="vendor_link" required>

              <label for="vendorNotes">Notes:</label>
              <input type="text" id="vendorNotes" name="vendor_notes" required>

              <label for="vendorImage"> Image</label>
              <input type="file" id="vendorImage" name="vendor_image" accept="image/*" required>


            </div>
            
            <button class="btn" type="submit">Update</button>

          </form>
        </div>
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

  <script>
// Get the first modal
    var modal = document.getElementById("myModal");
// Get the button that opens the first modal
    var btn = document.getElementById("myBtn");
// Get the <span> element that closes the first modal
    var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the first modal
    btn.onclick = function() {
      modal.style.display = "block";
    };
// When the user clicks on <span> (x) of the first modal, close the first modal
    span.onclick = function() {
      modal.style.display = "none";
    };


  </script>

  <script>
// Get all the category items
    var categoryItems = document.querySelectorAll(".category-item");

// Add click event listener to each category item
    categoryItems.forEach(function(item) {
      item.addEventListener("click", function() {
// Remove the "active" class from all category items
        categoryItems.forEach(function(item) {
          item.classList.remove("active");
        });

// Add the "active" class to the clicked category item
        item.classList.add("active");

// Get the category name
        var category = item.innerText;

// Get all the vendor boxes
        var vendorBoxes = document.querySelectorAll(".box");

        vendorBoxes.forEach(function(box) {
          var boxCategory = box.getAttribute("data-category");
          if (category === "All" || category === boxCategory) {
            box.style.display = "block";
          } else {
            box.style.display = "none";
          }
        });
      });
    });
  </script>

  <script>
  // Get the view modal
    var viewModal = document.getElementById("viewModal");
  // Get the <span> element that closes the view modal
    var closeViewModal = viewModal.getElementsByClassName("close")[0];
  // Get the form inside the view modal
    var vendorForm = document.getElementById("vendorForm");
  // Get the input fields inside the form
    var vendorIdInput = document.getElementById("vendorId");
    var vendorNameInput = document.getElementById("vendorName");
    var vendorPriceInput = document.getElementById("vendorPrice");
    var vendorEmailInput = document.getElementById("vendorEmail");
    var vendorContactInput = document.getElementById("vendorContact");
    var vendorCategoryInput = document.getElementById("vendorCategory");
    var vendorLinkInput = document.getElementById("vendorLink");
    var vendorNotesInput = document.getElementById("vendorNotes");
    var vendorImageInput = document.getElementById("vendorImage");

  // Function to open the view modal and populate the form
    function openViewModal(vendorId, vendorName, vendorPrice, vendorEmail, vendorContact, vendorCategory, vendorLink, vendorNotes, vendorImage) {
  // Get the view modal
      var viewModal = document.getElementById("viewModal");

  // Populate the input fields with vendor information
      document.getElementById("vendorId").value = vendorId;
      document.getElementById("vendorName").value = vendorName;
      document.getElementById("vendorPrice").value = vendorPrice;
      document.getElementById("vendorEmail").value = vendorEmail;
      document.getElementById("vendorContact").value = vendorContact;
      document.getElementById("vendorCategory").value = vendorCategory;
      document.getElementById("vendorLink").value = vendorLink;
      document.getElementById("vendorNotes").value = vendorNotes;
  // Set the image source
      document.getElementById("vendorImage").src = vendorImage;

  // Display the view modal
      viewModal.style.display = "block";
    }


    //Scroll up to the view modal form after the modal is displayed
    setTimeout(function() {
      window.scrollTo({ top: viewModal.offsetTop, behavior: 'smooth' });
    }, 0);

  // Close the view modal when the user clicks on <span> (x)
    closeViewModal.onclick = function() {
      viewModal.style.display = "none";
    };

  // Close the view modal when the user clicks outside of it
    window.onclick = function(event) {
      if (event.target === viewModal) {
        viewModal.style.display = "none";
      }
    };

  // Get all the view buttons
    var viewButtons = document.querySelectorAll(".view-btn");

// Add click event listener to each view button
    viewButtons.forEach(function(button) {
      button.addEventListener("click", function() {
    // Get the vendor information from the corresponding vendor box
        var vendorBox = button.closest(".box");
        var vendorId = vendorBox.getAttribute("data-vendor-id");
        var vendorName = vendorBox.querySelector("h3").innerText;
        var vendorPrice = vendorBox.querySelector("p:nth-child(2)").innerText.replace("Price: ", "");
        var vendorEmail = vendorBox.querySelector("p:nth-child(3)").innerText.replace("Email: ", "");
        var vendorContact = vendorBox.querySelector("p:nth-child(4)").innerText.replace("Contact: ", "");
        var vendorCategory = vendorBox.querySelector("p:nth-child(5)").innerText.replace("Category: ", "");
        var vendorLink = vendorBox.querySelector("p:nth-child(6)").innerText.replace("Link: ", "");
        var vendorNotes = vendorBox.querySelector("p:nth-child(7)").innerText.replace("Notes: ", "");
        var vendorImage = vendorBox.querySelector("img").getAttribute("src");

    // Open the view modal and populate the form with vendor information
        openViewModal(vendorId, vendorName, vendorPrice, vendorEmail, vendorContact, vendorCategory, vendorLink, vendorNotes, vendorImage);
      });
    });

  </script>

  <script>
    // Function to handle the search and update the vendor boxes
    function searchVendors() {
      const searchInput = document.getElementById("searchInput").value.toLowerCase();
      const vendorBoxes = document.querySelectorAll(".box");
      const noResultsMessage = document.getElementById("noResultsMessage");

      let foundVendors = false;

      vendorBoxes.forEach(function (box) {
        const vendorName = box.querySelector("h3").innerText.toLowerCase();
        if (vendorName.includes(searchInput)) {
          box.style.display = "block";
          foundVendors = true;
        } else {
          box.style.display = "none";
        }
      });

      if (!foundVendors) {
        noResultsMessage.style.display = "block";
      } else {
        noResultsMessage.style.display = "none";
      }
    }

    // Add an event listener to the search input field
    document.getElementById("searchInput").addEventListener("input", searchVendors);

  </script>


</body>
</html>