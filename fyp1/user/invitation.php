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

// Fetch guest data from the database associated with the username and the "invited" status
$query = "SELECT * FROM guest WHERE username = '$username' AND guest_status = 'invited'";
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
        <a href="guestlist.php" >
          <i class='bx bx-user-check' ></i>
          <span class="links_name">Guestlist</span>
        </a>
      </li>
      <li>
        <a href="invitation.php" class="active">
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

      <div id="no-guests-found" style="display: none; text-align: center; color: red; margin-top: 10px;">No guest found.</div>

        <!-- Create a table to display the guest list -->
        <table class="guest-table">
          <thead>
            <tr>
              <th></th>
              <th>NAME</th>
              <th>GROUP</th>
              <th>RSVP</th>
              <th>PAX</th>
              <th>INVITE</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $counter = 1;

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

                  <td><?php echo $counter; ?></td>
                  <td><?php echo $guestname; ?></td>
                  <td><?php echo $guestgroup; ?></td>
                  <td><?php echo $gueststatus; ?></td>
                  <td><?php echo $guestpax; ?></td>
                  <td>
                    <!-- Add the button for invitation PDF generation -->
                    <form action="generate_pdf.php" method="post">
                      <input type="hidden" name="guest_id" value="<?php echo $guestId; ?>">
                      <button type="submit" name="generate_pdf" class="generate-pdf-button">Generate PDF</button>
                    </form>
                  </td>

                </tr>

                <?php

                $counter++;

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
            <button class="btn4" type="submit" name="delete_guest" id="delete_button"  onclick="return confirmDelete();">
              <i class='bx bx-trash'></i>
            </button>
          </div>
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