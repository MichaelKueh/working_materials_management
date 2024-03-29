<?php
    
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
	
	function getClassesWithoutAdmin() {
		global $con;
		return $con->query("SELECT * FROM class WHERE name != 'admin'");
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
	
	function updatePostIndex($post, $order) {
		global $con;
		$stmt = $con->prepare("UPDATE post SET position= ? WHERE postID=?;");
		$stmt->bind_param('ii',$order,$post);
		
		$stmt->execute();
		$stmt->close();
	}
	
	function getPosts($subject, $class, $filterNonActive) {
		global $con;
		if(strcmp($subject, "*") == 0)
		{
			$stmt = $con->prepare("SELECT postID, title, content FROM post WHERE (active = true OR active = ? ) AND classID = ? ORDER BY position, creationDate DESC;");
			$stmt->bind_param('ii', $filterNonActive, $class);
		}
		else
		{
			$stmt = $con->prepare("SELECT postID, title, content FROM post WHERE (active = true OR active = ? ) AND classID = ? AND subjectID = ? ORDER BY position, creationDate DESC;");
			$stmt->bind_param('iii', $filterNonActive, $class,$subject);
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
	
	function getPostById($id) {
		global $con;
		$stmt = $con->prepare("SELECT postID, title, content, active, classID, subjectID FROM post WHERE postID = ?");
		$stmt->bind_param('i',$id);
		
		$stmt->execute();
		
		$stmt->bind_result($postID, $title, $content, $active, $classID, $subjectID);
		$stmt->fetch();
		$result = Array();
		array_push($result, array("postID" => $postID, "title" => $title, "content" => $content, "active" => $active, "classID" => $classID, "subjectID" => $subjectID));
		$stmt->close();
				
		return $result;
	}
	
	function insertPost($title, $content, $active, $classID, $subjectID) {
		global $con;
		$stmt = $con->prepare("INSERT INTO post (title, content, active, classID, subjectID, position) VALUES (?, ?, ?, ?, ?, 0);");
		$stmt->bind_param('ssiii', $title, $content, $active, $classID, $subjectID);

		$stmt->execute();
		
		$stmt->close();
		
		$temp = $con->query("SELECT max(postId) as postID FROM post")->fetch_object();
		$postID = $temp->postID;
		
		return $postID;
	}

	function updatePost($title, $content, $active, $classID, $subjectID, $postID) {
		global $con;
		$stmt = $con->prepare("UPDATE post SET title= ?, content= ?, active= ?, classID= ?, subjectID= ? WHERE postID=?");
		$stmt->bind_param('ssiiii', $title, $content, $active, $classID, $subjectID, $postID);

		$stmt->execute();
		
		$stmt->close();
	}
	
	function deletePost($post) {
		global $con;
		$stmt = $con->prepare("DELETE FROM post WHERE postID = ?");
		$stmt->bind_param('i',$post);
		
		$stmt->execute();
		$stmt->close();
	}
	
	function insertFile($name, $type, $size, $content, $postID) {
		global $con;
		$stmt = $con->prepare("INSERT INTO file (name, type, size, content, postID) VALUES (?, ?, ?, ?, ?);");
		$stmt->bind_param('ssisi', $name, $type, $size, $content, $postID);

		$stmt->execute();
		
		$stmt->close();
	}
	
	function getFilesByPostId($id) {
		global $con;
		$stmt = $con->prepare("SELECT fileID, name, type, size, content FROM file WHERE postID = ?");
		$stmt->bind_param('i',$id);
		
		$stmt->execute();
		$stmt->bind_result($fileID, $name, $type, $size, $content);
		$result = Array();
		
		while( $stmt->fetch() ) {
			array_push($result, array("fileID" => $fileID, "name" => $name, "type" => $type, "size" => $size, "content" => $content));
		}
		$stmt->close();
				
		return $result;
	}
	
	function insertImage($name, $type, $size, $content, $postID) {
		global $con;
		echo $con->error;
		$stmt = $con->prepare("INSERT INTO image (name, type, size, content, postID) VALUES (?, ?, ?, ?, ?);");
		echo $con->error;
		$stmt->bind_param('ssisi', $name, $type, $size, $content, $postID);

		$stmt->execute();
		
		$stmt->close();
	}
	
	function getImagesByPostId($id) {
		global $con;
		$stmt = $con->prepare("SELECT imageID, name, type, size, content FROM image WHERE postID = ?");
		$stmt->bind_param('i',$id);
		
		$stmt->execute();
		$stmt->bind_result($imageID, $name, $type, $size, $content);
		$result = Array();
		
		while( $stmt->fetch() ) {
			array_push($result, array("imageID" => $imageID, "name" => $name, "type" => $type, "size" => $size, "content" => $content));
		}
		$stmt->close();
				
		return $result;
	}
	
	function insertLink($link, $name, $postID) {
		global $con;
		$stmt = $con->prepare("INSERT INTO link (url, name, postID) VALUES (?, ?, ?);");
		$stmt->bind_param('ssi', $link, $name, $postID);

		$stmt->execute();
		
		$stmt->close();
	}
	
	function getLinksByPostId($id) {
		global $con;
		$stmt = $con->prepare("SELECT linkID, name, url FROM link WHERE postID = ?");
		$stmt->bind_param('i',$id);
		
		$stmt->execute();
		$stmt->bind_result($linkID, $name, $url);
		$result = Array();
		
		while( $stmt->fetch() ) {
			array_push($result, array("linkID" => $linkID, "name" => $name, "url" => $url));
		}
		$stmt->close();
				
		return $result;
	}
	
	function getComments($post) {
		global $con;
		$stmt = $con->prepare("SELECT commentID, name, text FROM comment WHERE postID=? ORDER BY creationDate;");
		$stmt->bind_param('i', $post);
		
		$stmt->execute();
		
		$stmt->bind_result($commentID, $name, $text);
		
		$result = Array();
		while ($stmt->fetch()) {
			array_push($result, array("commentID" => $commentID, "name" => $name, "text" => $text));
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
	
	function deleteComment($comment) {
		global $con;
		$stmt = $con->prepare("DELETE FROM comment WHERE commentID = ?");
		$stmt->bind_param('i',$comment);
		
		$stmt->execute();
		$stmt->close();
	}
	
	function deleteLink($link) {
		global $con;
		$stmt = $con->prepare("DELETE FROM link WHERE linkID = ?");
		$stmt->bind_param('i',$link);
		
		$stmt->execute();
		$stmt->close();
	}
	
	function deleteFile($file) {
		global $con;
		$stmt = $con->prepare("DELETE FROM file WHERE fileID = ?");
		$stmt->bind_param('i',$file);
		
		$stmt->execute();
		$stmt->close();
	}
	
	function deleteImage($image) {
		global $con;
		$stmt = $con->prepare("DELETE FROM image WHERE imageID = ?");
		$stmt->bind_param('i',$image);
		
		$stmt->execute();
		$stmt->close();
	}
	  
?>
