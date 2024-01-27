<?php
include("../connection/dbconn.php");

if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $bride = $_POST['bride'];
  $groom = $_POST['groom'];
  $wedding_date = $_POST['wedding_date'];
  $wedding_location = $_POST['wedding_location'];

  // Perform validation on the input if required

  // Insert the data into the database
  $query = "INSERT INTO header_details (username, bride, groom, wedding_date, wedding_location) VALUES ('$username', '$bride', '$groom', '$wedding_date', '$wedding_location')";
  $result = mysqli_query($dbconn, $query);

  if($result){
    // Header details added successfully
    mysqli_close($dbconn);
    $message = "Header details added successfully!";
    echo "<script>alert('$message'); window.location.replace('view_event.php');</script>";
    exit();
  } else {
    // Error in adding header details
    echo "Error: " . mysqli_error($dbconn);
  }

  mysqli_close($dbconn);
}
?>
