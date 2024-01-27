<?php

/* php& mysqldb connection file */
$user = "root"; //mysqlusername
$pass = ""; //mysqlpassword
$host = "localhost"; //server name or ipaddress
$dbname= "fyp1"; //your db name
$dbconn = mysqli_connect($host, $user, $pass, $dbname) or die(mysqli_connect_error());
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting


?>