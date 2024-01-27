<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $vendorId = $_POST['vendor_id'];
  $vendorName = $_POST['vendor_name'];
  $vendorPrice = $_POST['vendor_price'];
  $vendorEmail = $_POST['vendor_email'];
  $vendorContact = $_POST['vendor_contact'];
  $vendorCategory = $_POST['vendor_category'];
  $vendorLink = $_POST['vendor_link'];
  $vendorNotes = $_POST['vendor_notes'];

  // Check if a new image file was uploaded
  if ($_FILES['vendor_image']['name'] != '') {
    $vendorImage = $_FILES['vendor_image']['name'];
    $tempImage = $_FILES['vendor_image']['tmp_name'];
    $targetDirectory = '../images/';
    $targetFile = $targetDirectory . basename($vendorImage);
    move_uploaded_file($tempImage, $targetFile);
  } else {
    // Keep the existing image file if no new file was uploaded
    $sqlImage = "SELECT vendor_image FROM vendor WHERE vendor_id = '$vendorId'";
    $resultImage = mysqli_query($dbconn, $sqlImage);
    $rowImage = mysqli_fetch_assoc($resultImage);
    $vendorImage = $rowImage['vendor_image'];
  }

  // Update vendor information in the database
  $sqlUpdate = "UPDATE vendor SET
                vendor_name = '$vendorName',
                vendor_price = '$vendorPrice',
                vendor_email = '$vendorEmail',
                vendor_contact = '$vendorContact',
                vendor_category = '$vendorCategory',
                vendor_link = '$vendorLink',
                notes = '$vendorNotes',
                vendor_image = '$vendorImage'
                WHERE vendor_id = '$vendorId' AND username = '$username'";

  if (mysqli_query($dbconn, $sqlUpdate)) {
    header("Location: vendor.php");
    exit();
  } else {
    echo "Error updating vendor information: " . mysqli_error($dbconn);
  }
}

mysqli_close($dbconn);
?>
