<?php

	if(isAdmin()){
		if( isset($_GET["comment"]) ) {
			$comment = $_GET["comment"];
			deleteComment($comment);
		}
	}
?>
