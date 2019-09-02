<?php

if (isset($_POST["resetpwd-submit"])){

	$selector = bin2hex(random_bytes(8));
	$token = random_bytes(32);

	$url = "localhost/basic_login_system/createnewpwd.php?selector=$selector&validator=".bin2hex($token);

	$timestamp = date("U") + 1800;

	require "dbconn.php";

	$email = $_POST["email"];

	$sql = "DELETE FROM pwdReset WHERE userEmail = ?;";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "Internal error occurs!";
		exit();
	}
	else{
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
	}

	$sql = "INSERT INTO pwdReset (userEmail, resetPwdSelector, resetPwdToken, resetPwdTs) VALUES (?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo "Internal error occurs!";
		exit();
	}
	else{
		$hashedToken = password_hash($token, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $timestamp);
		mysqli_stmt_execute($stmt);
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);

	$to = $email;
	$subject = "Basic Login System Password Reset: Do not reply to this email";
	$msg = "Click the following link to reset your password: <br>
	 		<a href=$url>$url</a>";

	// $header = "From: root <root@localhost.com>\r\n";
	// $header .= "Reply-to: root@localhost.com\r\n";
	// $header .= "Content-type: text/html\r\n";

	// mail($to, $subject, $msg, $header);

	require_once('PHPMailer/Exception.php');
	require_once('PHPMailer/PHPMailer.php');
	require_once('PHPMailer/SMTP.php');

	$mail = new PHPMailer\PHPMailer\PHPMailer(true);
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = '465';
	$mail->isHTML(true);
	$mail->Username = 'youremailaddr@example.com';
	$mail->Password = 'youremailpwd';
	$mail->setFrom('youremailaddr@example.com');
	$mail->Subject = $subject;
	$mail->Body = $msg;
	$mail->addAddress($to);
	if($mail->send() == true){
		echo "success";
	}
	else{
		echo "failure";
	}

	header("Location: ../resetpwd.php?status=success");
	exit();

}
else{
	header("Location: ../index.php");
	exit();
}