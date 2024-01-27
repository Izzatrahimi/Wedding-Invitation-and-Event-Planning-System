<?php 
include('../connection/dbconn.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$level_id = $_POST['level_id'];

// Check if the username already exists
$checkUsernameQuery = "SELECT * FROM user WHERE username = '$username'";
$checkUsernameResult = mysqli_query($dbconn, $checkUsernameQuery);

if (mysqli_num_rows($checkUsernameResult) > 0) {
    // Username already exists
    echo "<script>alert('Username already exists');
    window.location='../registration/signup.php'</script>";
    exit;
}

// Insert the user into the database
$sql = "INSERT INTO user (username, email, password, name, phone, level_id)
VALUES ('$username', '$email', '$password', '$name', '$phone', '$level_id')";

$result = mysqli_query($dbconn, $sql);

if ($result) {
    echo "<script>alert('Account successfully registered');
    window.location='../registration/login.php'</script>";
} else {
    echo "<script>alert('Failed to register user');
    window.location='../registration/login.php'</script>";
}

mysqli_close($dbconn);
?>
