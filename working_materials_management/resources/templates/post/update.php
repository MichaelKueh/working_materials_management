<?php

	if( isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["classID"]) && isset($_POST["subjectID"]) && isset($_POST["postID"]) ) {
			$title = $_POST["title"];
			$content = $_POST["content"];
			$active = isset($_POST["active"]) ? 1 : 0;
			$classID = $_POST["classID"];
			$subjectID = $_POST["subjectID"];
			$postID = $_POST["postID"];
			
			$postID = updatePost($title, $content, $active, $classID, $subjectID, $postID);
	}
?>
<script>self.location.href="index.php?action=post&type=post";</script>