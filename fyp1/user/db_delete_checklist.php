<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $checklistIdToDelete = $_POST['deleteChecklistId'];
  $username = $_SESSION['username'];

  $deleteQuery = "DELETE FROM checklist WHERE username = '$username' AND checklist_id = '$checklistIdToDelete'";
  $deleteResult = mysqli_query($dbconn, $deleteQuery);

  if ($deleteResult) {
    header('Location: checklist.php?status=all'); // Redirect after deletion
    exit();
  } else {
    echo "Error deleting checklist item: " . mysqli_error($dbconn);
  }
}
?>
