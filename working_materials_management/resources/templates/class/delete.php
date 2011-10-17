<?php

	if(isAdmin()){
		if( isset($_GET["class"]) ) {
			$class = $_GET["class"];
			if( isset($_GET["sure"]) ) {
				deleteClass($class);
				
				require_once(TEMPLATES_PATH . "/class/class.php");
			}
			else
			{
				$result = getClassById($class);
				
				echo "Wollen sie die Klasse <b>" . $result[0]["name"] . "</b> wirklich l&ouml;schen?";
				echo "<br/><a href='index.php?action=delete&type=class&class=" . $class. "&sure=true'>L&ouml;schen </a>";
			}	
		}
	}
?>
