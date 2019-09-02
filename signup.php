<?php
	require "header.php";
?>
	
	<main>
		<form action="includes/signup.ctrl.php" method="post">
			<center><u><h2>Sign-up</h2></u></center>
			<?php

				if(isset($_GET["status"])){

					if ($_GET["status"] == "emptyfield") {
						echo "<h5>Please fill in all fields!</h5>";
					}
					elseif ($_GET["status"] == "invaliduidnemail") {
						echo "<h5>Invalid username and email!</h5>";
					}
					elseif ($_GET["status"] == "invaliduid") {
						echo "<h5>Invalid username!</h5>";
					}
					elseif ($_GET["status"] == "invalidemail") {
						echo "<h5>Invalid email!</h5>";
					}
					elseif ($_GET["status"] == "pwdnotsame") {
						echo "<h5>Please make sure passwords entered are the same!</h5>";
					}
					elseif ($_GET["status"] == "uidexist") {
						echo "<h5>Username exists!</h5>";
					}
					elseif ($_GET["status"] == "sqlerror") {
						echo "<h5>Internal error occurs!</h5>";
					}
					elseif ($_GET["status"] == "success") {
						echo "<h5>Sign up successfully!</h5>";
					}
					elseif ($_GET["status"] == "pwdupdated") {
						echo "<h5>Your password has changed successfully!</h5>";
					}

				}
			?>
			<input name="uid" type="text" placeholder="Username" value="<?php echo isset($_GET['uid'])? $_GET['uid']: ''; ?>"/>
			<input name="email" type="text" placeholder="Email" value="<?php echo isset($_GET['email'])? $_GET['email']: ''; ?>"/>
			<input name="pwd" type="password" placeholder="Password" />
			<input name="pwd-repeat" type="password" placeholder="Password Repeat" />
			<button name="signup-submit" type="submit">Sign up</button>
			<a href="./resetpwd.php">Forgot your password?</a>
		</form>
	</main>

<?php
	require "footer.php";
?>