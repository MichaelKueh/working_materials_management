<?php
	require_once("../../config.php");
	
	
	if(isset($_GET['imageID'])) 
	{
		$con = new mysqli($config["db"]["host"],$config["db"]["username"],$config["db"]["password"]);
		if (mysqli_connect_errno())
			die('Could not connect: ' . mysqli_connect_error());
		
		$con->select_db($config["db"]["dbname"]);
		
		function getImageById($image) {
			global $con;
			$stmt = $con->prepare("SELECT name, type, size, content FROM image WHERE imageID = ?;");
			$stmt->bind_param('i', $image);
			
			$stmt->execute();
			
			$stmt->bind_result($name, $type, $size, $content);
			
			$result = Array();
			while ($stmt->fetch()) {
				
				array_push($result, array("name" => $name, "type" => $type, "size" => $size, "content" => $content));
			}
			$stmt->close();
			
			return $result;
		}
		
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
