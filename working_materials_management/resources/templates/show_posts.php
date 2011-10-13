<?php

	$subject = "*";

	if( isset($_GET["subject"]) ) {
    	$subject = $_GET["subject"];
    }
    
    echo "<div class='content'>";
    if( isset($_SESSION['classId']) ) {
    	$posts = getPosts($subject,$_SESSION['classId']);
    	
    	foreach ($posts as $post) {
    		echo "<div class='post'>";
    		echo "<div class='post_title'>" . $post["title"] . "</div>";
    		echo "<div class='post_content'>" . $post["content"] . "</div>";
    		$comments = getComments($post["postID"]);
    		foreach ($comments as $comment) {
    			echo "<div class='comment'>";
	    		echo "<div class='comment_name'>" . $comment["name"] . "</div>";
	    		echo "<div class='comment_text'>" . $comment["text"] . "</div>";
	    		echo "</div>";
    		}
    		echo "<form action = index.php?action=add_comment method='POST'>";
    		echo "<input type='hidden' name='postID' value=" . $post["postID"] . ">";
    		echo "<input name='name' type='text' size='30' maxlength='30' placeholder='Name'>";
    		echo "<textarea name='text' cols='50' rows='10'' placeholder='Kommentar/Frage/Anregung'></textarea>";
    		echo "<input type='submit' value='Absenden'>";
    		echo "</form>";
    		echo "</div>";
    	}
    }
    else {
    	echo "kein Inhalt verfügbar";
    }
    
    echo "</div>";
?>
