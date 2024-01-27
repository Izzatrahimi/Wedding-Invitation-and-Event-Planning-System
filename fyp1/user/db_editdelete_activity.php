<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'];
  $activityId = $_POST['activityId'];

  if ($action === 'edit') {
    $activityTitle = $_POST['activityTitle'];
    $activityDescription = $_POST['activityDescription'];
    $activityTime = $_POST['activityTime'];

    // Prepare the query
    $query = "UPDATE activity_details SET activity_title = ?, activity_desc = ?, activity_time = ? WHERE username = ? AND activity_id = ?";
    $stmt = mysqli_prepare($dbconn, $query);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "ssssi", $activityTitle, $activityDescription, $activityTime, $username, $activityId);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
      // Activity updated successfully
      mysqli_stmt_close($stmt); // Close the statement

      // Redirect to itinerary.php
      header('Location: itinerary.php');
      exit();
    } else {
      // Error occurred while updating the activity
      echo "Error: " . mysqli_error($dbconn);
    }
  } elseif ($action === 'delete') {
    // Prepare the query
    $query = "DELETE FROM activity_details WHERE username = ? AND activity_id = ?";
    $stmt = mysqli_prepare($dbconn, $query);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "si", $username, $activityId);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
      // Activity deleted successfully
      mysqli_stmt_close($stmt); // Close the statement

      // Redirect to itinerary.php
      header('Location: itinerary.php');
      exit();
    } else {
      // Error occurred while deleting the activity
      echo "Error: " . mysqli_error($dbconn);
    }
  }
}

// Close the database connection
mysqli_close($dbconn);
?>
