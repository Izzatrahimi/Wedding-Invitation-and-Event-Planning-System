<?php
include("../connection/dbconn.php");

if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $feedback_category = $_POST['feedback_category'];
  $feedback_topic = $_POST['feedback_topic'];
  $feedback_desc = $_POST['feedback_desc'];

  // Perform validation on the input if required

  // Insert the data into the database
  $query = "INSERT INTO feedback (username, feedback_category, feedback_topic, feedback_desc) VALUES ('$username', '$feedback_category', '$feedback_topic', '$feedback_desc')";
  $result = mysqli_query($dbconn, $query);

  if($result){
    // Feedback added successfully
    mysqli_close($dbconn);
    $message = "Feedback added successfully!";
    echo "<script>alert('$message'); window.location.replace('view_feedback.php');</script>";
    exit();
  } else {
    // Error in adding feedback
    echo "Error: " . mysqli_error($dbconn);
  }

  mysqli_close($dbconn);
}
?>