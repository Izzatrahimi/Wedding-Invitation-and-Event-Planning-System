<?php
include("../connection/dbconn.php");
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login');
    exit();
}

if (isset($_GET['id'])) {
    $message_id = $_GET['id']; // Change variable name to match the "message" table

    // Check if the message exists in the database (update table name)
    $check_query = "SELECT * FROM message WHERE message_id = $message_id";
    $check_result = mysqli_query($dbconn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Message exists, so delete it
        $delete_query = "DELETE FROM message WHERE message_id = $message_id";
        if (mysqli_query($dbconn, $delete_query)) {
            // Successfully deleted the message
            header('Location: view_message.php'); // Update the redirect URL
            exit();
        } else {
            // Error deleting the message
            echo "Error: " . mysqli_error($dbconn);
        }
    } else {
        // Message does not exist
        echo "Message not found.";
    }
} else {
    // No message ID provided
    echo "Invalid request.";
}

mysqli_close($dbconn);
?>
