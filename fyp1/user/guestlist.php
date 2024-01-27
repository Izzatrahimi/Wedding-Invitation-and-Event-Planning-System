<?php 
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

// Get the username of the currently logged-in user
$username = $_SESSION['username'];

// Check if a filter option is selected
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Define a mapping of filter options to SQL conditions
$filterConditions = [
  'all' => "",
  'invited' => "AND guest_status = 'Invited'",
  'attending' => "AND guest_status = 'Attending'",
  'not_attending' => "AND guest_status = 'Not Attending'",
  'maybe' => "AND guest_status = 'Maybe'",
  'none' => "AND guest_status = 'None'",
];

// Fetch guest data from the database associated with the username and the selected filter
$query = "SELECT * FROM guest WHERE username = '$username' " . $filterConditions[$filter];
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
          <i class='bx bx-list-check' class="active"></i>
          <span class="links_name">Checklist</span>
        </a>
      </li>
      <li>
        <a href="guestlist.php" class="active">
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
        <span class="dashboard">Guestlist</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search name, group or rsvp..." id="guest-search">
        <button onclick="searchGuests()"><i class='bx bx-search'></i></button>
      </div>
      <div class="profile-details">
        <!-- <img src="images/profile.jpg" alt=""> -->
        <i class='bx bxs-user'></i>
        <span class="admin_name">
          <?php echo $_SESSION['username']; ?>
        </span>
      </div>
    </nav>

    <section class="guestlist-section">

      <!-- Filter buttons or links -->
      <div class="filter-menu">
        <a href="guestlist.php?filter=all" <?php if ($filter === 'all') echo 'class="active"'; ?>>All</a>
        <a href="guestlist.php?filter=invited" <?php if ($filter === 'invited') echo 'class="active"'; ?>>Invited</a>
        <a href="guestlist.php?filter=attending" <?php if ($filter === 'attending') echo 'class="active"'; ?>>Attending</a>
        <a href="guestlist.php?filter=not_attending" <?php if ($filter === 'not_attending') echo 'class="active"'; ?>>Not Attending</a>
        <a href="guestlist.php?filter=maybe" <?php if ($filter === 'maybe') echo 'class="active"'; ?>>Maybe</a>
        <a href="guestlist.php?filter=none" <?php if ($filter === 'none') echo 'class="active"'; ?>>None</a>
      </div>


      <button class="btn4" id="addGuestButton">Add Guest</button>

      <div id="no-guests-found" style="display: none; text-align: center; color: red; margin-top: 10px;">No guest found.</div>

      <!-- Create a form to handle checkbox selections -->
      <form id="guest-form" action="db_update_delete_guest.php" method="post">

        <!-- Create a table to display the guest list -->
        <table class="guest-table" onclick="openEditModal()">
          <thead>
            <tr>
              <th></th>
              <th>NAME</th>
              <th>GROUP</th>
              <th>RSVP</th>
              <th>PAX</th>
            </tr>
          </thead>
          <tbody>
            <?php

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $guestId = $row['guest_id'];
                $guestname = $row['guest_name'];
                $guestphone = $row['guest_phone'];
                $guestemail = $row['guest_email'];
                $guestaddress = $row['guest_address'];
                $guestgroup = $row['guest_group'];
                $gueststatus = $row['guest_status'];
                $guestpax = $row['guest_pax'];
                $guestnotes = $row['notes'];
                ?>

                <tr data-guest-id="<?php echo $guestId; ?>"
                  data-guest-name="<?php echo $guestname; ?>"
                  data-guest-phone="<?php echo $guestphone; ?>"
                  data-guest-email="<?php echo $guestemail; ?>"
                  data-guest-address="<?php echo $guestaddress; ?>"
                  data-guest-group="<?php echo $guestgroup; ?>"
                  data-guest-status="<?php echo $gueststatus; ?>"
                  data-guest-pax="<?php echo $guestpax; ?>"
                  data-guest-notes="<?php echo $guestnotes; ?>">

                  <td><input type='checkbox' class='guest-checkbox' name='guest_checkbox[]' value="<?php echo $guestId; ?>"></td>
                  <td><?php echo $guestname; ?></td>
                  <td><?php echo $guestgroup; ?></td>
                  <td><?php echo $gueststatus; ?></td>
                  <td><?php echo $guestpax; ?></td>

                </tr>

                <?php
              }
            } else {
          // No guest details found
              echo "<tr><td colspan='5'>No guest found.</td></tr>";
            }

        // Free the result set
            mysqli_free_result($result);
            ?>

          </tbody>
        </table>

        <div class="button-row" style="display: none;">
          <div class="button-container">
            <!-- Display the number of selected checkboxes -->
            <p id="selected-count">0 selected</p>
            <button class="btn4" type="button" name="update_status" onclick="openStatusUpdateModal()">Update Status</button>
            <button class="btn4" type="submit" name="delete_guest" id="delete_button"  onclick="return confirmDelete();">
              <i class='bx bx-trash'></i>
            </button>
          </div>
        </div>

      </form>

    </section>

    <div class="modal" id="addGuestModal">
      <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Add New Guest</h2>

        <!-- Add your form elements for adding a new guest here -->
        <div class="modal-scrollable">
          <form action="db_add_guest.php" method="POST">
            <!-- Add your form fields here -->
            <input type="hidden" id="guest_id" name="guest_id">

            <label for="guest_name">Guest Name:</label>
            <input type="text" name="guest_name" id="guest_name" placeholder="Enter guest name" required>

            <label for="guest_contact">Contact:</label>
            <input type="text" name="guest_phone" id="guest_phone" placeholder="Phone Number" required>
            <input type="text" name="guest_email" id="guest_email" placeholder="Email Address" required>

            <label for="guest_address">Address:</label>
            <textarea type="text" name="guest_address" id="guest_address" placeholder="Enter address" required></textarea>

            <label for="guest_group">Group</label>
            <select id="guest_group" name="guest_group" class="modal-input" required>
              <option value="Family">Family</option>
              <option value="Friend">Friend</option>
              <option value="Neighbour">Neighbour</option>
              <option value="Colleague">Colleague</option>
              <option value="Associate">Associate</option>
              <option value="Acquaintance">Acquaintance</option>
              <option value="Teeacher and Mentor">Teeacher and Mentor</option>
              <option value="Event Vendor">Event Vendor</option>
            </select>

            <label for="guest_status">Status</label>
            <select id="guest_status" name="guest_status" class="modal-input" required>
              <option value="Invited">Invited</option>
              <option value="Attending">Attending</option>
              <option value="Maybe">Maybe</option>
              <option value="Not Attending">Not Attending</option>
              <option value="None">None</option>
            </select>

            <label for="guest_pax">Pax:</label>
            <input type="number" name="guest_pax" id="guest_pax" placeholder="Enter pax" required>

            <label for="notes">Notes:</label>
            <textarea type="text" name="notes" id="notes" placeholder="Enter notes" required></textarea>

            <button type="submit" class="btn4" onclick="return confirmAddGuest();">Add Guest</button>
          </form>
        </div>

      </div>

    </div>

    <div class="modal" id="editGuestModal">
      <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Guest Details</h2>

        <!-- Add your form elements for adding a new guest here -->
        <div class="modal-scrollable">
          <form class="editForm" action="db_update_guest.php" method="POST">
            <!-- Add your form fields here -->
            <input type="hidden" id="edit_guest_id" name="guestId">

            <label for="edit_guest_name">Guest Name:</label>
            <input type="text" name="guestname" id="edit_guest_name" placeholder="Enter guest name" required>

            <label for="edit_guest_contact">Contact:</label>
            <input type="text" name="guestphone" id="edit_guest_phone" placeholder="Phone Number" required>
            <input type="text" name="guestemail" id="edit_guest_email" placeholder="Email Address" required>

            <label for="edit_guest_address">Address:</label>
            <textarea type="text" name="guestaddress" id="edit_guest_address" placeholder="Enter address" required></textarea>

            <label for="edit_guest_group">Group</label>
            <select id="edit_guest_group" name="guestgroup" class="modal-input" required>
              <option value="Family">Family</option>
              <option value="Friend">Friend</option>
              <option value="Neighbour">Neighbour</option>
              <option value="Colleague">Colleague</option>
              <option value="Associate">Associate</option>
              <option value="Acquaintance">Acquaintance</option>
              <option value="Teeacher and Mentor">Teeacher and Mentor</option>
              <option value="Event Vendor">Event Vendor</option>
            </select>

            <label for="edit_guest_status">Status</label>
            <select id="edit_guest_status" name="gueststatus" class="modal-input" required>
              <option value="Invited">Invited</option>
              <option value="Attending">Attending</option>
              <option value="Maybe">Maybe</option>
              <option value="Not Attending">Not Attending</option>
              <option value="None">None</option>
            </select>

            <label for="edit_guest_pax">Pax:</label>
            <input type="number" name="guestpax" id="edit_guest_pax" placeholder="Enter pax" required>

            <label for="edit_notes">Notes:</label>
            <textarea type="text" name="guestnotes" id="edit_notes" placeholder="Enter notes" required></textarea>

            <button type="submit" class="btn4" onclick="return confirmUpdateGuest();">Save</button>
          </form>
        </div>

      </div>

    </div>

    <!-- Status Update Modal -->
    <div class="modal" id="updateStatusModal">
      <div class="modal-content">
        <span class="close" id="closeStatusModal" onclick="closeEditStatus()">&times;</span>
        <h2>Update Guest Status</h2>
        <div class="modal-scrollable">
          <form action="db_update_delete_guest.php" method="POST">
            <input type="hidden" id="guest_ids_to_update" name="guest_ids_to_update">

            <label for="guest_status">New Status:</label>
            <select id="guest_status" name="new_guest_status" class="modal-input" required>
              <option value="Invited">Invited</option>
              <option value="Attending">Attending</option>
              <option value="Maybe">Maybe</option>
              <option value="Not Attending">Not Attending</option>
              <option value="None">None</option>
            </select>

            <button type="submit" class="btn4" name="update_status" onclick="confirmStatusUpdate()">Save</button>
          </form>
        </div>
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

    const checkboxes = document.querySelectorAll('.guest-checkbox');
    const buttonRow = document.querySelector('.button-row');
    const selectedCount = document.getElementById('selected-count'); 

    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener('change', () => {
        const checkedCheckboxes = document.querySelectorAll('.guest-checkbox:checked');
        const count = checkedCheckboxes.length;
        selectedCount.textContent = count + ' selected';
        buttonRow.style.display = count > 0 ? 'block' : 'none';
      });
    });

  </script>


  <script>

// Get the modal element and the button to open it
    const addGuestModal = document.getElementById('addGuestModal');
    const addGuestButton = document.getElementById('addGuestButton');
    const closeModalButton = document.getElementById('closeModal');
    const editGuestModal = document.getElementById('editGuestModal');

// Function to open the modal
    function openModal() {
      addGuestModal.style.display = 'block';
    }

// Function to close the modal
    function closeModal() {
      addGuestModal.style.display = 'none';
    }

// Event listeners for opening and closing the modals
    addGuestButton.addEventListener('click', openModal);
    closeModalButton.addEventListener('click', closeModal);

// Close the modal if the user clicks anywhere outside of it
    window.addEventListener('click', (event) => {
      if (event.target === addGuestModal) {
        closeModal();
      }
    });

  </script>


  <script>

    function closeEditModal() {
      document.getElementById("editGuestModal").style.display = "none";
    }

    function submitEditForm() {
      document.getElementById("editGuestModal").submit();
    }

    function deleteActivity(guestId) {
      if (confirm("Are you sure you want to delete this guest?")) {
        document.getElementById("edit_guest_id").value = guestId;
        document.getElementById("editForm").submit();
      }
    }

// Add an event listener to the table rows to handle the opening of the modal
    document.querySelectorAll('.guest-table tbody tr').forEach((row) => {
      row.addEventListener('click', (event) => {
    // Check if the clicked element is not a checkbox
        if (event.target.type !== 'checkbox' && !event.target.classList.contains('generate-pdf-button')) {
          const guestId = row.getAttribute('data-guest-id');
          const guestname = row.getAttribute('data-guest-name');
          const guestphone = row.getAttribute('data-guest-phone');
          const guestemail = row.getAttribute('data-guest-email');
          const guestaddress = row.getAttribute('data-guest-address');
          const guestgroup = row.getAttribute('data-guest-group');
          const gueststatus = row.getAttribute('data-guest-status');
          const guestpax = row.getAttribute('data-guest-pax');
          const guestnotes = row.getAttribute('data-guest-notes');

          document.getElementById("edit_guest_id").value = guestId;
          document.getElementById("edit_guest_name").value = guestname;
          document.getElementById("edit_guest_phone").value = guestphone;
          document.getElementById("edit_guest_email").value = guestemail;
          document.getElementById("edit_guest_address").value = guestaddress;
          document.getElementById("edit_guest_group").value = guestgroup;
          document.getElementById("edit_guest_status").value = gueststatus;
          document.getElementById("edit_guest_pax").value = guestpax;
          document.getElementById("edit_notes").value = guestnotes;
          document.getElementById("editGuestModal").style.display = "block";
        }
      });
    });

  </script>


  <script>

// JavaScript function to show a confirmation dialog before deletion
    function confirmDelete() {
// Use JavaScript's built-in "confirm" function to display a dialog
      return confirm("Are you sure you want to delete the selected guest(s)?");
    }

// JavaScript function to show a confirmation dialog before adding a new guest
    function confirmAddGuest() {
// Use JavaScript's built-in "confirm" function to display a dialog
      return confirm("Are you sure you want to add a new guest?");
    }

// JavaScript function to show a confirmation dialog before updating guest details
    function confirmUpdateGuest() {
// Use JavaScript's built-in "confirm" function to display a dialog
      return confirm("Are you sure you want to update the guest details?");
    }

  </script>


  <script>

// JavaScript function to open the status update modal
    function openStatusUpdateModal() {
      const checkedCheckboxes = document.querySelectorAll('.guest-checkbox:checked');
      const checkedIds = Array.from(checkedCheckboxes).map((checkbox) => checkbox.value);
      const guestIdsToUpdate = checkedIds.join(',');

      if (checkedCheckboxes.length > 0) {
        document.getElementById('guest_ids_to_update').value = guestIdsToUpdate;
        document.getElementById('updateStatusModal').style.display = 'block';
      } else {
        alert('Please select at least one guest to update status.');
      }
    }

// JavaScript function to confirm status update
    function confirmStatusUpdate() {
      const confirmation = confirm(`Are you sure you want to update the status for the selected guest(s)?`);

      if (confirmation) {
// If user confirms, submit the form to update the status
        document.getElementById('status_update_form').submit();
      }
    }

// Function to close the status update modal
    function closeEditStatus() {
      document.getElementById('updateStatusModal').style.display = 'none';
    }

  </script>

  <script>

    function searchGuests() {
      const searchText = document.getElementById('guest-search').value.toLowerCase();
      const tableRows = document.querySelectorAll('.guest-table tbody tr');
      let guestsFound = false;

      tableRows.forEach((row) => {
        const guestName = row.getAttribute('data-guest-name').toLowerCase();
        const guestStatus = row.getAttribute('data-guest-status').toLowerCase();
        const guestGroup = row.getAttribute('data-guest-group').toLowerCase();

        if (
          guestName.includes(searchText) ||
          guestStatus.includes(searchText) ||
          guestGroup.includes(searchText)
          ) {
          row.style.display = '';
        guestsFound = true;
      } else {
        row.style.display = 'none';
      }
    });

      const noGuestsFoundMessage = document.getElementById('no-guests-found');
      if (!guestsFound) {
        noGuestsFoundMessage.style.display = 'block';
      } else {
        noGuestsFoundMessage.style.display = 'none';
      }
    }

  </script>


</body>
</html>