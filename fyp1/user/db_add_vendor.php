<?php
include("../connection/dbconn.php");
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: ../login');
  exit();
}

// Get the vendor details from the form
$vendorName = $_POST['vendor_name'];
$vendorPrice = $_POST['vendor_price'];
$vendorEmail = $_POST['vendor_email'];
$vendorContact = $_POST['vendor_contact'];
$vendorCategory = $_POST['vendor_category'];
$vendorLink = $_POST['vendor_link'];
$notes = $_POST['notes'];

// Upload image
$targetDirectory = "../images/";
$targetFile = $targetDirectory . basename($_FILES["vendor_image"]["name"]);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Move uploaded file to the target directory
if (move_uploaded_file($_FILES["vendor_image"]["tmp_name"], $targetFile)) {
  // Image upload successful
  $vendorImage = $targetFile;

  // Add the vendor details to the database
  $username = $_SESSION['username'];
  $query = "INSERT INTO vendor (vendor_name, vendor_price, vendor_email, vendor_contact, vendor_category, vendor_link, notes, vendor_image, username) 
  VALUES ('$vendorName', '$vendorPrice', '$vendorEmail', '$vendorContact', '$vendorCategory', '$vendorLink', '$notes', '$vendorImage', '$username')";
  $result = mysqli_query($dbconn, $query);

  if ($result) {
    // Vendor details inserted successfully
    header('Location: vendor.php');
    exit();
  } else {
    // Failed to insert vendor details
    echo "Error: " . mysqli_error($dbconn);
  }
} else {
  // Failed to upload image
  echo "Error uploading image.";
}

mysqli_close($dbconn);
?>
