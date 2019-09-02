<?php
	require "header.php";
?>
	
	<main>
		<?php

			$selector = $_GET["selector"];
			$validator = $_GET["validator"];

			if (empty($selector) || empty($validator)){
				echo "Could not validate your request";
				exit();
			}
			else{
				if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
				?>					
				<form action="includes/createnewpwd.ctrl.php" method="post">
					<center><u><h2>Create New Password</h2></u></center>
					<input name="selector" type="hidden" value="<?php echo $selector ?>"/>
					<input name="validator" type="hidden" value="<?php echo $validator ?>"/>
					<input name="pwd" type="password" placeholder="Password" />
					<input name="pwd-repeat" type="password" placeholder="Password Repeat" />
					<button name="createnewpwd-submit" type="submit">Confirm</button>
				</form>
		<?php
				}
				else{
					echo "Could not validate your request";
					exit();
				}
			}
		?>
	</main>

<?php
	require "footer.php";
?>