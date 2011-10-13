<?php

	if( isset($_POST["name"]) ) {
		if( isset($_POST["text"]) ) {
			if( isset($_POST["postID"]) ) {
				$name = $_POST["name"];
				$text = $_POST["text"];
				$post = $_POST["postID"];
			}
		}	
    }
	addComments($name, $text, $post);
	
	require_once(TEMPLATES_PATH . "/" . "show_posts.php");


?>
