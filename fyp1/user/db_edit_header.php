<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_SESSION['username'];
  $bride = $_POST['brideInput'];
  $groom = $_POST['groomInput'];
  $wedding_date = $_POST['weddingDateInput'];
  $wedding_location = $_POST['weddingLocationInput'];

  // Check if header details already exist for the logged-in user
  $checkQuery = "SELECT * FROM header_details WHERE username = '$username'";
  $checkResult = mysqli_query($dbconn, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    // Update existing header details
    $updateQuery = "UPDATE header_details SET bride = '$bride', groom = '$groom', wedding_date = '$wedding_date', wedding_location = '$wedding_location' WHERE username = '$username'";
    $updateResult = mysqli_query($dbconn, $updateQuery);

    if ($updateResult) {
      // Header details updated successfully
      header('Location: itinerary.php');
      exit();
    } else {
      // Error updating header details
      echo "Error updating header details: " . mysqli_error($conn);
    }
  } else {
    // Insert new header details
    $insertQuery = "INSERT INTO header_details (username, bride, groom, wedding_date, wedding_location) VALUES ('$username', '$bride', '$groom', '$wedding_date', '$wedding_location')";
    $insertResult = mysqli_query($dbconn, $insertQuery);

    if ($insertResult) {
      // Header details inserted successfully
      header('Location: itinerary.php');
      exit();
    } else {
      // Error inserting header details
      echo "Error inserting header details: " . mysqli_error($conn);
    }
  }
}
?>
