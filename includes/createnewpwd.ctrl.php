<?php

if (isset($_POST["createnewpwd-submit"])){

	$selector = $_POST["selector"];
	$validator = $_POST["validator"];
	$pwd = $_POST["pwd"];
	$pwdCheck = $_POST["pwd-repeat"];

	if (empty($pwd) || empty($pwdCheck)){
		header("Location: ../createnewpwd.php?status=newpwdempty");
		exit();
	}
	elseif ($pwd !== $pwdCheck) {
		header("Location: ../createnewpwd.php?status=pwdnotsame");
		exit();		
	}

	$currentTs = date("U");

	require "dbconn.php";

	$sql = "SELECT * FROM pwdReset WHERE resetPwdSelector = ? AND resetPwdTs >= ?;";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "Internal error occurs!";
		exit();
	}
	else{
		mysqli_stmt_bind_param($stmt, "ss", $selector, $currentTs);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if (!$row = mysqli_fetch_assoc($result)){
			echo "You need to re-submit your reset password form!";
			exit();
		}
		else{

			$token2Bin = hex2bin($validator);
			$tokenCheck = password_verify($token2Bin, $row["resetPwdToken"]);

			if ($tokenCheck === false){
				echo "You need to re-submit your reset password form!";
				exit();
			}
			else{

				$email = $row["userEmail"];
				$sql = "SELECT * FROM users WHERE userEmail = ?;";
				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt, $sql)){
					echo "Internal error occurs!";
					exit();
				}
				else{
					mysqli_stmt_bind_param($stmt, "s", $email);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					if (!$row = mysqli_fetch_assoc($result)){
						echo "There is an error occured!";
						exit();
					}
					else{

						$sql = "UPDATE users SET userPwd = ? WHERE userEmail = ?;";
						$stmt = mysqli_stmt_init($conn);

						if(!mysqli_stmt_prepare($stmt, $sql)){
							echo "Internal error occurs!";
							exit();
						}
						else{
							$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
							mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $email);
							mysqli_stmt_execute($stmt);

							$sql = "DELETE FROM pwdReset WHERE userEmail = ?;";
							$stmt = mysqli_stmt_init($conn);

							if(!mysqli_stmt_prepare($stmt, $sql)){
								echo "Internal error occurs!";
								exit();
							}
							else{
								mysqli_stmt_bind_param($stmt, "s", $email);
								mysqli_stmt_execute($stmt);
								header("Location: ../signup.php?status=pwdupdated");
							}
						}

					}
				}
			}

		}
	}
}
else{
	header("Location: ../index.php");
	exit();
}