<?php

	if(isAdmin()){
		if( isset($_GET["class"]) ) {
			$class = $_GET["class"];
			if( isset($_GET["sure"]) ) {
				deleteClass($class);
				require_once(TEMPLATES_PATH . "/" . "class.php");
			}
			else
			{
				$result = getClassById($class);
				
				echo "Wollen sie die Klasse <b>" . $result[0]["name"] . "</b> wirklich l&ouml;schen?";
				echo "<br/><a href='index.php?action=delete_class&class=" . $class. "&sure=true'>L&ouml;schen </a>";
			}	
		}
	}
	else
		require_once("content.php");
?>
