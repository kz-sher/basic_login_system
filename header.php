<?php
	session_start();
?>
<html>
<title>Basic Login System</title>
<head>
	<link rel="stylesheet" type="text/css" href="styles/main.css" />
</head>
<body>
	<header>
		<a href="./index.php">HOME</a>
		<?php
			if(!isset($_SESSION["userUID"])){
				echo "<form action='includes/login.ctrl.php' method='post'>
						<input name='uidoremail' type='text' placeholder='Email/Username' />
						<input name='pwd' type='password' placeholder='Password' />
						<button name='login-submit' type='submit'>Log in</button>
					  </form>
					  <form action='signup.php' method='post'>
						<button type='submit'>Sign up</button>
					  </form>";
			}
			else{
				echo "<form action='includes/logout.ctrl.php' method='post'>
						<button name='logout-submit' type='submit'>Log out</button>
					  </form>";
			}
		?>
	</header>