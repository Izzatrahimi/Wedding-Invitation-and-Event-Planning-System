<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_SESSION['username'];
  $checklistId = $_POST['checklistId'];
  $editTitle = $_POST['editTitle'];
  $editDesc = $_POST['editDesc'];
  $editStatus = $_POST['editStatus'];

  // Update the checklist details in the database
  $updateQuery = "UPDATE checklist 
                  SET checklist_title = '$editTitle', checklist_desc = '$editDesc', checklist_status = '$editStatus' 
                  WHERE checklist_id = '$checklistId' AND username = '$username'";

  $result = mysqli_query($dbconn, $updateQuery);

  if ($result) {
    header('Location: checklist.php?status=all');
  } else {
    echo "Error updating checklist: " . mysqli_error($dbconn);
  }
}
?>
