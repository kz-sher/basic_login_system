<?php
	require "header.php";
?>
	
	<main>
		<form action="includes/resetpwd.ctrl.php" method="post">
			<center><u><h2>Reset Password</h2></u></center>
			<?php
				if (isset($_GET["status"])){
					if ($_GET["status"] == "success"){
						echo "<h5>Please check your email!</h5>";
					} 
				}
			?>
			<input name="email" type="text" placeholder="Email" />
			<button name="resetpwd-submit" type="submit">Reset</button>
		</form>
	</main>

<?php
	require "footer.php";
?>