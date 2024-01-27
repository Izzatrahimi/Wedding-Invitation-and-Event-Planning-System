<?php
include("../connection/dbconn.php");

if(isset($_POST['submit'])){
  $message_name = $_POST['message_name'];
  $message_email = $_POST['message_email'];
  $message_phone = $_POST['message_phone'];
  $message_address = $_POST['message_address'];
  $message_desc = $_POST['message_desc'];

  // Perform validation on the input if required

  // Insert the data into the database
  $query = "INSERT INTO message (message_name, message_email, message_phone, message_address, message_desc) VALUES ('$message_name', '$message_email', '$message_phone', '$message_address', '$message_desc')";
  $result = mysqli_query($dbconn, $query);

  if($result){
    // Message added successfully
    mysqli_close($dbconn);
    $message = "Message added successfully!";
    echo "<script>alert('$message'); window.location.replace('view_message.php');</script>";
    exit();
  } else {
    // Error in adding message
    echo "Error: " . mysqli_error($dbconn);
  }

  mysqli_close($dbconn);
}
?>
