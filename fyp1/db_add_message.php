<?php
include 'connection/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $message = $_POST['message'];

    $query = "INSERT INTO message (message_name, message_email, message_phone, message_address, message_desc) 
    VALUES ('$name', '$email', '$phone', '$address', '$message')";

    if (mysqli_query($dbconn, $query)) {
        echo "Message added successfully.";
        header('Location: index.html');
        exit();
    } else {
        echo "Error adding message: " . mysqli_error($dbconn);
    }
}

mysqli_close($dbconn);
?>
