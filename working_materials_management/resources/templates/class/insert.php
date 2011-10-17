<?php

	if(isAdmin()){
		if( isset($_POST["name"]) && isset($_POST["login_key"]) ) {
			$login_key = $_POST["login_key"];
			$name = $_POST["name"];
			
			insertClass($name, $login_key);	
	    }
	    
		require_once(TEMPLATES_PATH . "/class/class.php");
    }
?>
