<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

if (isset($_POST['delete_guest'])) {
  // Get the username of the currently logged-in user
  $username = $_SESSION['username'];

  // Get the selected guest IDs to delete
  if (isset($_POST['guest_checkbox']) && is_array($_POST['guest_checkbox'])) {
    $guestIdsToDelete = $_POST['guest_checkbox'];

    // Sanitize and validate guest IDs (e.g., ensure they belong to the logged-in user)
    $safeGuestIdsToDelete = array();
    foreach ($guestIdsToDelete as $guestId) {
      $safeGuestId = mysqli_real_escape_string($dbconn, $guestId);
      $safeGuestIdsToDelete[] = $safeGuestId;
    }

    // Construct and execute the delete query
    $deleteQuery = "DELETE FROM guest WHERE guest_id IN (" . implode(',', $safeGuestIdsToDelete) . ") AND username = '$username'";
    if (mysqli_query($dbconn, $deleteQuery)) {
      // Deletion successful
      header('Location: guestlist.php');
      exit();
    } else {
      // Error handling (e.g., display an error message)
      echo "Error: " . mysqli_error($dbconn);
    }
  } else {
    // No checkboxes were selected
    header('Location: guestlist.php');
    exit();
  }
}

if (isset($_POST['update_status'])) {
  // Get the username of the currently logged-in user
  $username = $_SESSION['username'];

  // Get the selected guest IDs to update
  if (isset($_POST['guest_ids_to_update']) && !empty($_POST['guest_ids_to_update'])) {
    $guestIdsToUpdate = $_POST['guest_ids_to_update'];
    
    // Sanitize and validate the guest IDs
    $safeGuestIds = array_map('intval', explode(',', $guestIdsToUpdate));
    
    // Get the new guest status from the form
    $newGuestStatus = mysqli_real_escape_string($dbconn, $_POST['new_guest_status']);
    
    // Construct and execute the update query
    $updateQuery = "UPDATE guest SET guest_status = '$newGuestStatus' WHERE guest_id IN (" . implode(',', $safeGuestIds) . ") AND username = '$username'";
    
    if (mysqli_query($dbconn, $updateQuery)) {
      // Status update successful
      header('Location: guestlist.php');
      exit();
    } else {
      // Error handling (e.g., display an error message)
      echo "Error: " . mysqli_error($dbconn);
    }
  } else {
    // No guest IDs to update
    header('Location: guestlist.php');
    exit();
  }
}

?>
