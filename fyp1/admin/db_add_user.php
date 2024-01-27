<?php
include("../connection/dbconn.php");

if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $level_id = $_POST['level_id'];

  // Perform validation on the input if required

  // Insert the data into the database
  $query = "INSERT INTO user (username, email, password, name, phone, level_id) VALUES ('$username', '$email', '$password', '$name', '$phone', '$level_id')";
  $result = mysqli_query($dbconn, $query);

  if($result){
    // User added successfully
    mysqli_close($dbconn);
    $message = "User added successfully!";
    echo "<script>alert('$message'); window.location.replace('view_user.php');</script>";
    exit();
  } else {
    // Error in adding user
    echo "Error: " . mysqli_error($dbconn);
  }

  mysqli_close($dbconn);
}
?>
