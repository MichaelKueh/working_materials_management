<?php
	require_once("../../config.php");
	require_once("../../database.php");
	if(isset($_GET['imageID'])) 
	{
		$result  = getImageById($_GET['imageID']);
		
		if(isset($result[0])) {
			header("Content-length: ".$result[0]['size']);
			header("Content-type: ".$result[0]['type']);
			header("Content-Disposition: attachment; filename=" . $result[0]['name']);
		 	echo $result[0]['content'];
		}
		else {
			return null;
		}
	 }
?>
