<?php 
	if( !isset($_SESSION['login']) )
	{
?>

	<form method="POST" action="index.php">
		<label for="login_key">Bitte Schl&uuml;ssel eingeben:</label>
		<input type="text" name="login_key" size="10" placeholder="Schl&uuml;ssel"/> 
		<input type="submit" value="Anmelden"/>
		
		<p class="error">
			<?php
				if( isset($wrongLogin) ) {
					echo "unbekannter Schl&uuml;ssel eingegeben.";
				}
			?>
		</p>
	</form>
	
<?php
	} else {
		echo "eingeloggt als: " . $_SESSION['login'];
		?> <a href="index.php?action=logout">logout</a> <?php
	}
?>