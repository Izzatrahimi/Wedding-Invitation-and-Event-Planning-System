<?php
include("../connection/dbconn.php");

if (isset($_POST['submit'])) {
  $vendorId = $_POST['vendor_id'];
  $vendorName = $_POST['vendor_name'];
  $vendorPrice = $_POST['vendor_price'];
  $vendorEmail = $_POST['vendor_email'];
  $vendorContact = $_POST['vendor_contact'];
  $vendorCategory = $_POST['vendor_category'];
  $vendorLink = $_POST['vendor_link'];
  $notes = $_POST['notes'];
  $username = $_POST['username'];

  // Handle file upload
  $targetDirectory = "../images/";
  $targetFile = $targetDirectory . basename($_FILES["vendor_image"]["name"]);
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if the file is a valid image
  $allowedExtensions = array("jpg", "jpeg", "png");
  if (in_array($imageFileType, $allowedExtensions)) {
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["vendor_image"]["tmp_name"], $targetFile)) {
      // File upload success
      $vendorImage = $targetFile;

      // Update the vendor record in the database with the new values
      $query = "UPDATE vendor SET 
                vendor_name='$vendorName', 
                vendor_price='$vendorPrice', 
                vendor_email='$vendorEmail', 
                vendor_contact='$vendorContact', 
                vendor_category='$vendorCategory', 
                vendor_link='$vendorLink', 
                notes='$notes', 
                vendor_image='$vendorImage', 
                username='$username' 
                WHERE vendor_id='$vendorId'";
      $result = mysqli_query($dbconn, $query);

      if ($result) {
        // Update successful
        echo "<script>alert('Vendor information updated successfully.'); window.location.href = 'view_vendor.php';</script>";
      } else {
        // Update failed
        echo "Error updating vendor: " . mysqli_error($dbconn);
      }
    } else {
      // File upload failed
      echo "Error uploading image.";
    }
  } else {
    // Invalid file type
    echo "Invalid image file. Only JPG, JPEG, and PNG files are allowed.";
  }
}
?>
