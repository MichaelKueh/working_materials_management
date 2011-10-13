<?php
	 // load up config file  
    require_once("resources/config.php");
    
	$con = new mysqli($config["db"]["host"],$config["db"]["username"],$config["db"]["password"]);
	if (mysqli_connect_errno())
		die('Could not connect: ' . mysqli_connect_error());
	
	$con->select_db($config["db"]["dbname"]);

	function getSubjects() {
		global $con;
		return $con->query("SELECT * FROM subject");
	}
	
	function getClasses() {
		global $con;
		return $con->query("SELECT * FROM class");
	}
	
	function updateClass($name, $login_key, $class) {
		global $con;
		$stmt = $con->prepare("UPDATE class SET name= ?, login_key= ? WHERE classID=?");
		$stmt->bind_param('ssi',$name,$login_key,$class);
		
		$stmt->execute();
		$stmt->close();
	}
	
	function deleteClass($class) {
		global $con;
		$stmt = $con->prepare("DELETE FROM class WHERE classID = ?");
		$stmt->bind_param('i',$class);
		
		$stmt->execute();
		$stmt->close();
	}
	
	function insertClass($name, $login_key) {
		global $con;
		$stmt = $con->prepare("INSERT INTO class (name, login_key) VALUES (?, ?);");
		$stmt->bind_param('ss',$name,$login_key);
		
		$stmt->execute();
		$stmt->close();
	}
	
	function getClassById($id) {
		global $con;
		$stmt = $con->prepare("SELECT name, login_key FROM class WHERE classID = ?");
		$stmt->bind_param('i',$id);
		
		$stmt->execute();
		
		$stmt->bind_result($name, $login_key);
		$stmt->fetch();
		$result = Array();
		array_push($result, array("name" => $name, "login_key" => $login_key));
		$stmt->close();
				
		return $result;
	}
	
	function getClassByKey($key) {
		global $con;
		$stmt = $con->prepare("SELECT name FROM class WHERE login_key = ?");
		$stmt->bind_param('s',$key);
		
		$stmt->execute();
		
		$stmt->bind_result($name);
		$stmt->fetch();
		$stmt->close();
		
		return $name;
	}
	
	function getClassIdByKey($key) {
		global $con;
		$stmt = $con->prepare("SELECT classId FROM class WHERE login_key = ?");
		$stmt->bind_param('s',$key);
		
		$stmt->execute();
		
		$stmt->bind_result($id);
		$stmt->fetch();
		$stmt->close();
		
		return $id;
	}
	
	function getPosts($subject, $class) {
		global $con;
		if(strcmp($subject, "*") == 0)
		{
			$stmt = $con->prepare("SELECT postID, title, content FROM post WHERE active = 1 AND classID = ? ORDER BY creationDate;");
			$stmt->bind_param('i', $class);
		}
		else
		{
			$stmt = $con->prepare("SELECT postID, title, content FROM post WHERE active = 1 AND classID = ? AND subjectID = ? ORDER BY creationDate;");
			$stmt->bind_param('ii', $class,$subject);
		}
		
		
		$stmt->execute();
		
		$stmt->bind_result($postID, $title, $content);
		$result = Array();
		while ($stmt->fetch()) {
			array_push($result, array("postID" => $postID, "title" => $title, "content" => $content));
   		}
		$stmt->close();
		
		return $result;
	}
	
	function getComments($post) {
		global $con;
		$stmt = $con->prepare("SELECT name, text FROM comment WHERE postID=? ORDER BY creationDate;");
		$stmt->bind_param('i', $post);
		
		$stmt->execute();
		
		$stmt->bind_result($name, $text);
		
		$result = Array();
		while ($stmt->fetch()) {
			array_push($result, array("name" => $name, "text" => $text));
   		}
		$stmt->close();
		
		return $result;
	}
	
	function addComments($name, $text, $post) {
		global $con;
		$stmt = $con->prepare("INSERT INTO comment (name, text, postID) VALUES (?, ?, ?);");

		$stmt->bind_param('ssi', $name, $text, $post);
		
		$stmt->execute();
		
		$stmt->close();
	}
	  
?>
