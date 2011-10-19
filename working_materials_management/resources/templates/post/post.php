<?php

	echo "<script>Galleria.loadTheme('resources/library/galleria/themes/classic/galleria.classic.min.js');</script>";
	
	if( isset($_GET["classID"]) ) {
		$_SESSION['classId'] = $_GET["classID"];
	}
	
	$filterNonActive = true;
	
	if( isAdmin() ) {
		$filterNonActive = false;
?>

		<form action="index.php?action=post&type=post" 	method="get">
			<input type="hidden" value="post" name="action">
			<input type="hidden" value="post" name="type">
			<label for="classID">Eintr&auml;ge anzeigen f&uuml;r:</label>
			<select name="classID" id="classID" onchange="this.form.submit();">
				<?php
					$classes = getClassesWithoutAdmin();
					 while($row = $classes->fetch_object())
					{
						if( isset($_SESSION['classId']) )
							$selected = $row->classID == $_SESSION['classId'] ? " selected='selected' " : "";
						
						echo "<option value='" . $row->classID . "'" . $selected . ">" . $row->name ."</option>";
					}
				?>
			</select>
		</form>
		<br><br>
		<a href="index.php?action=edit&type=post">Neuen Eintrag erstellen</a>
		<form id = "order" name = "order" action="index.php?action=order&type=post" 	method="get">
			<input type="hidden" value="order" name="action">
			<input type="hidden" value="post" name="type">
			<a id="order_edit" href="javascript:startOrderingPosts();">Posts ordnen</a>
			<a id="order_submit" href="javascript:submitOrderForm();" style="display: none;" >Postsanordnung speichern</a>
		</form>
<?php
	}
	$subject = "*";

	if( isset($_GET["subject"]) ) {
    	$subject = $_GET["subject"];
    }
    
    
    if( isset($_SESSION['classId']) ) {
    	$posts = getPosts($subject,$_SESSION['classId'], $filterNonActive);
    	
    	echo "<ul id='sortable'>";
    	foreach ($posts as $post) {
    		
    		$delete = "";
    		
    		if( isAdmin() ) {
				$delete = "<a href='index.php?action=edit&type=post&post=" . $post["postID"] . "'><img src='public_html/img/edit-item.png' width='20px'/></a>";
				$delete = $delete . "<a href='#' onclick='deletePost(" . $post["postID"] . ");'><img src='public_html/img/delete-item.png' width='20px'/></a>";
			}
			
			echo "<li class='order_input' data-value=" . $post["postID"] . ">";
    		echo "<div class='post' id='post_" . $post["postID"] . "'>";
    		echo "<div class='post_title'>" . $post["title"] . "<div class='exit'>" . $delete . "</div>" . "</div>";
    		echo "<div class='post_content'>" . $post["content"] . "</div>";
    		
    		echo "<div class='post_files'>";
    			$files = getFilesByPostId($post["postID"]);
    			if( count($files) > 0 ) {
    				echo "<h2>Dateien:</h2>";
	    			echo "<ul>";
	    			foreach($files as $file) {
	    				echo "<li>";
	    					echo "<a href='resources/templates/post/get_file.php?fileID=" .  $file["fileID"] . "'>" . $file["name"] . "</a>";
	    					echo " (" . round($file["size"] / 1024, 1) . " kB )";
						echo "</li>";
	    			}
	    			echo "</ul>";
    			}
    		echo "</div>";
    		
    		echo "<div class='post_links'>";
    			$links = getLinksByPostId($post["postID"]);
    			if( count($links) > 0 ) {
    				echo "<h2>Links:</h2>";
	    			echo "<ul>";
	    			foreach($links as $link) {
	    				if( !(strpos($link["url"],"http") === 0) ) {
	    					$link["url"] = "http://" . $link["url"];
	    				}
	    				echo "<li>";
	    					echo "<a href='" .  $link["url"] . "' target='_blank'>" . $link["name"] . "</a>"; 
						echo "</li>";
	    			}
	    			echo "</ul>";
    			}
    		echo "</div>";
    		echo "<br>";
    		echo "<div class='post_images'>";
    			$images = getImagesByPostId($post["postID"]);
    			if( count($images) > 0 ) {
    				foreach($images as $image) {
    					echo "<img src='resources/templates/post/get_image.php?imageID=". $image["imageID"] . "'/>";
    				}
    				echo "<script>";
						echo "$('#post_" . $post["postID"] . " .post_images').galleria({width: 700, height: 300});";
						echo "console.log($(this));";
					echo "</script>";
    			}
    		echo "</div>";
    		
    		echo "<br><div class='post_comments'>";
	    		$comments = getComments($post["postID"]);
	    		foreach ($comments as $comment) {
	    			$comment["name"] = strlen($comment["name"]) == 0 ?  "kein Name angegeben" : $comment["name"];
	    			$comment["text"] = strlen($comment["text"]) == 0 ?  "kein Text angegeben" : $comment["text"];
	    			
	    			if( isAdmin() ) {
	    				$delete = "<a href='#'  onclick='deleteComment(" . $comment["commentID"] . ");'><img src='public_html/img/delete-item.png' width='15px'/></a>";
	    			}
	    			
	    			echo "<div class='comment' id='comment_" . $comment["commentID"] . "'>";
		    		echo "<div class='comment_name'>" . $comment["name"] . "<div class='exit'>" . $delete . "</div></div>"; // TODO delete comment
		    		echo "<div class='comment_text'>" . $comment["text"] . "</div>";
		    		echo "</div>";
	    		}
	    	echo "<form action = index.php?action=insert&type=comment method='POST' name = 'comment'>";
    		echo "<input type='hidden' name='postID' value=" . $post["postID"] . ">";
    		echo "<input name='name' type='text' size='30' maxlength='30' placeholder='Name'><br>";
    		echo "<textarea name='text' cols='50' rows='2'' placeholder='Kommentar/Frage/Anregung'></textarea>";
    		echo "<input type='submit' value='Absenden' class='submit'>";
    		echo "</form>";
	    	echo "</div>";
    		echo "</div>";
    		echo "</li>";
    	}
    	echo "</ul>";
    }
    else {
    	echo "kein Inhalt verfügbar";
    }
?>
