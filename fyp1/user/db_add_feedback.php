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
  $username = $_SESSION['username'];
  $feedbackCategory = $_POST['feedback_category'];
  $feedbackTopic = $_POST['feedback_topic'];
  $feedbackDescription = $_POST['feedback_description'];

  // Prepare the SQL statement
  $sql = "INSERT INTO feedback (username, feedback_category, feedback_topic, feedback_desc) VALUES (?, ?, ?, ?)";

  // Prepare the statement
  $stmt = $dbconn->prepare($sql);

  // Bind the parameters
  $stmt->bind_param("ssss", $username, $feedbackCategory, $feedbackTopic, $feedbackDescription);

  // Execute the statement
  if ($stmt->execute()) {
    // Feedback added successfully
    echo '<script>alert("Feedback successfully added.");</script>'; // JavaScript alert
    echo '<script>window.location.href = "feedback.php";</script>'; // Redirect to feedback.php
    exit();
  } else {
    // Error occurred while adding feedback
    echo "Error adding feedback: " . $stmt->error;
  }

  // Close the statement and database connection
  $stmt->close();
  $dbconn->close();
}
?>
