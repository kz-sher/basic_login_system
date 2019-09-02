<?php
	
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "basic_login_system_db";
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

