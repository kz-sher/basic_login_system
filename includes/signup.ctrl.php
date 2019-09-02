<?php

if(isset($_POST["signup-submit"])){
	require "dbconn.php";

	$username = $_POST["uid"];
	$email = $_POST["email"];
	$password = $_POST["pwd"];
	$passwordCheck = $_POST["pwd-repeat"];

	if(empty($username) || empty($email) || empty($password) || empty($passwordCheck)){
		header("Location: ../signup.php?status=emptyfield&uid=$username&email=$email");
		exit();
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signup.php?status=invaliduidnemail&uid=$username");
		exit();	
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../signup.php?status=invalidemail&uid=$username");
		exit();	
	}
	elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
		header("Location: ../signup.php?status=invaliduid&email=$email");
		exit();	
	}
	elseif($password !== $passwordCheck){
		header("Location: ../signup.php?status=pwdnotsame&uid=$username&email=$email");
		exit();	
	}
	else{

		$sql = "SELECT userUID FROM users WHERE userUID=?;";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../signup.php?status=sqlerror");
			exit();
		}
		else{
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$rowNum = mysqli_stmt_num_rows($stmt);
			if($rowNum > 0){
				header("Location: ../signup.php?status=uidexist");
				exit();
			}
			else{
				$sql = "INSERT INTO users (userUID, userEmail, userPwd) VALUES (?, ?, ?);";
				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt, $sql)){
					header("Location: ../signup.php?status=sqlerror");
					exit();
				}				
				else{
					$hashed_password = password_hash($password, PASSWORD_DEFAULT);
					mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
					mysqli_stmt_execute($stmt);
					header("Location: ../signup.php?status=success");
					exit();
				}

			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else{
	header("Location: ../signup.php?");
	exit();
}


