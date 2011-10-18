<?php
if(isAdmin()){
	if( isset($_GET["post"])) {
		$posts = $_GET["post"];
		foreach ($posts as $index => $post) {
			updatePostIndex($post, $index);
				
		}
		
	}
	require_once(TEMPLATES_PATH . "/" . "post/post.php");
}
?>
