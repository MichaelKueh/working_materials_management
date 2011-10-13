<?php

	if(isAdmin()){
		if( isset($_POST["name"]) ) {
			if( isset($_POST["login_key"]) ) {
				if( isset($_POST["classID"]) ) {
					$login_key = $_POST["login_key"];
					$name = $_POST["name"];
					$class = $_POST["classID"];
					
					updateClass($name, $login_key, $class);
				}
			}	
	    }
	    
	    require_once(TEMPLATES_PATH . "/" . "class.php");
	}
	else
		require_once("content.php");
?>
