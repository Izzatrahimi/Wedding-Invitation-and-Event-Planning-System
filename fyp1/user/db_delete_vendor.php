<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $vendorId = $_POST['vendor_id'];
  $username = $_SESSION['username'];

  // Delete the vendor from the database
  $sql = "DELETE FROM vendor WHERE vendor_id = '$vendorId' AND username = '$username'";
  $result = mysqli_query($dbconn, $sql);

  if ($result) {
    // Vendor deleted successfully
    header('Location: vendor.php');
    exit();
  } else {
    // Failed to delete the vendor
    echo "Error: " . mysqli_error($dbconn);
  }
}
?>
