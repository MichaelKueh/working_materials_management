<?php

	if( isset($_POST["name"]) && isset($_POST["text"]) && isset($_POST["postID"]) ) {
		$name = $_POST["name"];
		$text = $_POST["text"];
		$post = $_POST["postID"];
    }
	addComments($name, $text, $post);
?>

<script>history.back(2)</script>