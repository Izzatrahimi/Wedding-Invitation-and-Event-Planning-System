<?php
include("../connection/dbconn.php");
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login');
    exit();
}

if (isset($_GET['id'])) {
    $feedback_id = $_GET['id'];

    // Check if the feedback exists in the database
    $check_query = "SELECT * FROM feedback WHERE feedback_id = $feedback_id";
    $check_result = mysqli_query($dbconn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Feedback exists, so delete it
        $delete_query = "DELETE FROM feedback WHERE feedback_id = $feedback_id";
        if (mysqli_query($dbconn, $delete_query)) {
            // Successfully deleted the feedback
            header('Location: view_feedback.php');
            exit();
        } else {
            // Error deleting the feedback
            echo "Error: " . mysqli_error($dbconn);
        }
    } else {
        // Feedback does not exist
        echo "Feedback not found.";
    }
} else {
    // No feedback ID provided
    echo "Invalid request.";
}

mysqli_close($dbconn);
?>
