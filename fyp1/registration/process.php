<?php
// Inialize session
session_start();

// Include database connection settings
include('../connection/dbconn.php');

if(isset($_POST['login'])){

	/* capture values from HTML form */
	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql= "SELECT username, password, level_id FROM user WHERE username= '$username' AND password= '$password'";
	$query = mysqli_query($dbconn, $sql) or die ("Error: " . mysqli_error());
	$row = mysqli_num_rows($query);
	if($row == 0){
// Jump to index wrong page
		/*header('Location: error.php');*/ 
		echo"<script>alert('The information entered does not match any user records. The user may have been deleted or does not exist.');
		window.location='../registration/login.php'</script>";
	}
	else{
		$r = mysqli_fetch_assoc($query);
		$username= $r['username'];
//$password= $r['password'];
		$level= $r['level_id'];
//echo($level_id);

		if($level==1) { 
			$_SESSION['username'] = $r['username'];
// Jump to secured page
			header('Location: ../admin/report.php'); 
		} 
		elseif($level==2) {
			$_SESSION['username'] = $r['username'];
// Jump to secured page
			header('Location: ../user/user.php');
		}
		else {
			header('Location: login.php');
//echo($level);
		}

	}	
}
mysqli_close($dbconn);
?>