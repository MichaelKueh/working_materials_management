<?php

	if(isAdmin()){
		if( isset($_POST["name"]) && isset($_POST["login_key"]) && isset($_POST["classID"]) ) {
			$login_key = $_POST["login_key"];
			$name = $_POST["name"];
			$class = $_POST["classID"];
			
			updateClass($name, $login_key, $class);	
	    }
	    
		require_once(TEMPLATES_PATH . "/class/class.php");
	}
?>
