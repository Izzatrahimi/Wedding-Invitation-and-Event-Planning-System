<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

// Get the username of the currently logged-in user
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the updated guest information from the form
  $guestId = $_POST['guestId'];
  $guestname = $_POST['guestname'];
  $guestphone = $_POST['guestphone'];
  $guestemail = $_POST['guestemail'];
  $guestaddress = $_POST['guestaddress'];
  $guestgroup = $_POST['guestgroup'];
  $gueststatus = $_POST['gueststatus'];
  $guestpax = $_POST['guestpax'];
  $guestnotes = $_POST['guestnotes'];

  // Update the guest information in the database associated with the logged-in user
  $query = "UPDATE guest SET
    guest_name = '$guestname',
    guest_phone = '$guestphone',
    guest_email = '$guestemail',
    guest_address = '$guestaddress',
    guest_group = '$guestgroup',
    guest_status = '$gueststatus',
    guest_pax = '$guestpax',
    notes = '$guestnotes'
    WHERE guest_id = '$guestId' AND username = '$username'";

  if (mysqli_query($dbconn, $query)) {
    // Successfully updated the guest information
    header('Location: guestlist.php');
    exit();
  } else {
    // Handle the error if the update fails
    echo "Error updating guest information: " . mysqli_error($dbconn);
  }
}

// Close the database connection
mysqli_close($dbconn);
?>
