<?php
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['addTitle'];
  $desc = $_POST['addDesc'];
  $status = $_POST['addStatus'];
  $username = $_SESSION['username'];

  // Insert the new checklist into the database
  $insertQuery = "INSERT INTO checklist (checklist_title, checklist_desc, checklist_status, username)
                  VALUES ('$title', '$desc', '$status', '$username')";
  $insertResult = mysqli_query($dbconn, $insertQuery);

  if ($insertResult) {
    // Redirect back to the checklist page after adding
    header('Location: checklist.php?status=all');
    exit();
  } else {
    echo "Error adding checklist: " . mysqli_error($dbconn);
  }
}
?>
