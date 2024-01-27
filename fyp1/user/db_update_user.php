<?php
include('../connection/dbconn.php');
include ("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $level_id = $_POST['level_id'];

  // Update user information in the database
  $query = "UPDATE user SET email = '$email', password = '$password', name = '$name', phone = '$phone', level_id = '$level_id' WHERE id = '$id'";
  $result = mysqli_query($dbconn, $query);

  if ($result) {
    // User information updated successfully
    echo '<script>alert("User information successfully updated.");</script>'; 
    echo '<script>window.location.href = "userprofile.php";</script>'; 
    exit();
  } else {
    // Handle error if the update fails
    // Display an appropriate message or redirect to an error page
    echo "Error updating user information: " . mysqli_error($dbconn);
  }
} else {
  // Handle error if the form is not submitted via POST
  // Display an appropriate message or redirect to an error page
  echo "Invalid request.";
}
?>
