<?php
include("../connection/dbconn.php");
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login');
    exit();
}

if (isset($_GET['id'])) {
    $header_id = $_GET['id'];

    // Check if the header details exist in the database
    $check_query = "SELECT * FROM header_details WHERE header_id = $header_id";
    $check_result = mysqli_query($dbconn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Header details exist, so delete them
        $delete_query = "DELETE FROM header_details WHERE header_id = $header_id";
        if (mysqli_query($dbconn, $delete_query)) {
            // Successfully deleted the header details
            header('Location: view_event.php');
            exit();
        } else {
            // Error deleting the header details
            echo "Error: " . mysqli_error($dbconn);
        }
    } else {
        // Header details do not exist
        echo "Header details not found.";
    }
} else {
    // No header ID provided
    echo "Invalid request.";
}

mysqli_close($dbconn);
?>
