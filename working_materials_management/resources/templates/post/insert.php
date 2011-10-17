<?php

	if(isAdmin()){
		if( isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["classID"]) && isset($_POST["subjectID"]) ) {
			$title = $_POST["title"];
			$content = $_POST["content"];
			$active = isset($_POST["active"]) ? 1 : 0;
			$classID = $_POST["classID"];
			$subjectID = $_POST["subjectID"];
			
			$postID = insertPost($title, $content, $active, $classID, $subjectID);
			
			if( isset($_FILES["file"]) ){
				$name = $_FILES["file"]["name"];
				$tmpName = $_FILES["file"]["tmp_name"];
				$size = $_FILES["file"]["size"];
				$type = $_FILES["file"]["type"];
				
				
				$fp      = fopen($tmpName, 'r');
				$content = fread($fp, filesize($tmpName));
				$content = addslashes($content);
				fclose($fp);
				
				if(!get_magic_quotes_gpc())
				{
				    $name = addslashes($name);
				}
				
				insertFile($name, $type, $size, $content, $postID);
			}	
	    }
	    
		require_once(TEMPLATES_PATH . "/post/post.php");
    }
?>
