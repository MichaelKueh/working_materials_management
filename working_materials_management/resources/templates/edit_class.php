<?php

	if(isAdmin()){
		if( isset($_GET["class"]) ) {
	    	$class = $_GET["class"];
	    	
	    	$result = getClassById($class);
	    	
	    	
	    	foreach ($result as $blub) {
	    		$name = $blub["name"];
	    		$login_key = $blub["login_key"];
	    	}
	    	$link = "index.php?action=update_class";
	    	
	    }
	    else {
	    	$class = "";
	    	$name = "";
	    	$login_key = "";
	    	$link = "index.php?action=insert_class";
	    }
	    
	    echo "<form action = " . $link . " method='POST'>";
		echo "<input type='hidden' name='classID' value=" . $class . ">";
		echo "<input name='name' type='text' size='30' maxlength='30' value='" . $name ."' placeholder='Klasse'>";
		echo "<input name='login_key' type='text' size='30' maxlength='30' value='" . $login_key . "' placeholder='Schl&uuml;ssel'></textarea>";
		echo "<input type='submit' value='Absenden'>";
		echo "</form>";
	
	}
	else
		require_once("content.php");
?>
