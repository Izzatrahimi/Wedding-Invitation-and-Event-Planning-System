<?php
include("../connection/dbconn.php");

if(isset($_GET['id'])){
  $userId = $_GET['id'];

  // Fetch the user data from the database
  $query = "SELECT * FROM user WHERE id = '$userId'";
  $result = mysqli_query($dbconn, $query);

  if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);
    echo json_encode($user);
  } else {
    echo "User not found";
  }

  mysqli_close($dbconn);
}
?>
