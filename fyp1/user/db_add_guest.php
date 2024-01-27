<?php
include('../connection/dbconn.php');
include("../registration/session.php");
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login');
    exit();
}

// Get the username of the currently logged-in user
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $guest_name = $_POST["guest_name"];
    $guest_phone = $_POST["guest_phone"];
    $guest_email = $_POST["guest_email"];
    $guest_address = $_POST["guest_address"];
    $guest_group = $_POST["guest_group"];
    $guest_status = $_POST["guest_status"];
    $guest_pax = $_POST["guest_pax"];
    $notes = $_POST["notes"];

    // Insert the new guest into the database
    $insert_query = "INSERT INTO guest (guest_name, guest_phone, guest_email, guest_address, guest_group, guest_status, guest_pax, notes, username)
                     VALUES ('$guest_name', '$guest_phone', '$guest_email', '$guest_address', '$guest_group', '$guest_status', '$guest_pax', '$notes', '$username')";

    if (mysqli_query($dbconn, $insert_query)) {
        // Redirect back to the guestlist.php page after successfully adding the guest
        header('Location: guestlist.php');
        exit();
    } else {
        // Handle the error if the insertion fails
        echo "Error: " . mysqli_error($dbconn);
    }
}

mysqli_close($dbconn);


?>