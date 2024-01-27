<?php
include("../connection/dbconn.php");

if(isset($_GET['id'])){
  $vendorId = $_GET['id'];

  // Fetch the vendor data from the database
  $query = "SELECT * FROM vendor WHERE vendor_id = '$vendorId'";
  $result = mysqli_query($dbconn, $query);

  if(mysqli_num_rows($result) > 0){
    $vendor = mysqli_fetch_assoc($result);
    echo json_encode($vendor);
  } else {
    // If no vendor is found with the given ID, return an empty object
    echo json_encode((object)[]);
  }
} else {
  // If the 'id' parameter is not set, return an empty object
  echo json_encode((object)[]);
}
?>
