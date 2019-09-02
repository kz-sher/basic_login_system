<?php
	require "header.php";
?>
	
	<main>
		<?php
			if(isset($_SESSION["userUID"])){
				echo "<p>You are logged in!</p>";
			}
			elseif(isset($_POST["logout_submit"])){
				echo "<p>You are logged out!</p>";
			}
			else{
				if(isset($_GET["status"])){

					if ($_GET["status"] == "emptyfield") {
						echo "<p>Please fill in all fields!</p>";
					}
					elseif ($_GET["status"] == "wrongpwd") {
						echo "<p>Wrong password entered!</p>";
					}
					elseif ($_GET["status"] == "nouser") {
						echo "<p>User not found!</p>";
					}
					elseif ($_GET["status"] == "sqlerror") {
						echo "<p>Internal error occurs!</p>";
					}
				}
				else{
					echo "<p>Welcome!</p>";
				}
			}
		?>
	</main>

<?php
	require "footer.php";
?>