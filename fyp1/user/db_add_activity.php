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
  // Get the form data
  $activityTitle = $_POST['activityTitle'];
  $activityDescription = $_POST['activityDescription'];
  $activityTime = $_POST['activityTime'];

  // Prepare the query
  $query = "INSERT INTO activity_details (username, activity_title, activity_desc, activity_time) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($dbconn, $query);

  // Bind the parameters
  mysqli_stmt_bind_param($stmt, "ssss", $username, $activityTitle, $activityDescription, $activityTime);

  // Execute the query
  if (mysqli_stmt_execute($stmt)) {
    // Activity inserted successfully
    header('Location: itinerary.php');
    exit();
  } else {
    // Error occurred while inserting the activity
    echo "Error: " . mysqli_error($dbconn);
  }

  // Close the statement
  mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($dbconn);
?>
