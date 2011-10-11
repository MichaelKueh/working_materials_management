<?php
	 // load up config file  
    require_once("resources/config.php");
    
	$con = mysql_connect($config["db"]["host"],$config["db"]["username"],$config["db"]["password"]);
	if (!$con)
		die('Could not connect: ' . mysql_error());
	
	mysql_select_db($config["db"]["dbname"], $con);

	function getClasses() {
		return mysql_query("SELECT * FROM class");
	}
	
	function getClassByKey($key) {
		$row = mysql_fetch_array(mysql_query("SELECT name FROM class WHERE login_key = '" . $key . "'"));
		
		return $row["name"];
	}
	  
?>
