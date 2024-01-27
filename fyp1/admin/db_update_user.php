<?php
include("../connection/dbconn.php");


if(isset($_POST['submit'])){
  $userId = $_POST['id'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $level_id = $_POST['level_id'];

  // Perform validation on the input if required

  // Update the user data in the database
  $query = "UPDATE user SET username = '$username', email = '$email', password = '$password', name = '$name', phone = '$phone', level_id = '$level_id' WHERE id = '$userId'";
  $result = mysqli_query($dbconn, $query);

  if($result){
    // User updated successfully
    echo "<script>alert('User information updated successfully.'); window.location.href = 'view_user.php';</script>";
    exit();
  } else {
    // Error in updating user
    echo "Error: " . mysqli_error($dbconn);
  }

  mysqli_close($dbconn);
}
?>
