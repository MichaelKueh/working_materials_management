<?php

	if(isAdmin()){
		if( isset($_GET["post"]) ) {
			$post = $_GET["post"];
			deletePost($post);
		}
	}
?>
