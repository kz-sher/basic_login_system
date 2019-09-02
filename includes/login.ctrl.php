<?php

if(isset($_POST["login-submit"])){
	require "dbconn.php";

	$usernameOrEmail = $_POST["uidoremail"];
	$password = $_POST["pwd"];

	if(empty($usernameOrEmail) || empty($password)){
		header("Location: ../index.php?status=emptyfield");
		exit();	
	}
	else{

		$sql = "SELECT * FROM users WHERE userUID = ? OR userEmail = ?;";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../index.php?status=sqlerror");
			exit();
		}
		else{
			mysqli_stmt_bind_param($stmt, "ss", $usernameOrEmail, $usernameOrEmail);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			if($row = mysqli_fetch_assoc($result)){
				
				$pwdCheck = password_verify($password, $row["userPwd"]);
				
				if($pwdCheck == false){
					header("Location: ../index.php?status=wrongpwd");
					exit();
				}
				else{
					session_start();
					$_SESSION["userID"] = $row["userID"];
					$_SESSION["userUID"] = $row["userUID"];
					header("Location: ../index.php?status=success");
					exit();
				}
			}
			else{
				header("Location: ../index.php?status=nouser");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else{
	header("Location: ../index.php");
	exit();
}