<?php
	if( isset($_GET["classID"]) ) {
		$_SESSION['classId'] = $_GET["classID"];
	}
	
	if( isAdmin() ) {
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
<?php
	}
	$subject = "*";

	if( isset($_GET["subject"]) ) {
    	$subject = $_GET["subject"];
    }
    
    if( isset($_SESSION['classId']) ) {
    	$posts = getPosts($subject,$_SESSION['classId']);
    	
    	foreach ($posts as $post) {
    		
    		$delete = "";
    		
    		if( isAdmin() ) {
				$delete = "<a href='index.php?action=edit&type=post&post=" . $post["postID"] . "'><img src='public_html/img/edit-item.png' width='20px'/></a>";
				$delete = $delete . "<a href='#' onclick='deletePost(" . $post["postID"] . ");'><img src='public_html/img/delete-item.png' width='20px'/></a>";
			}
    		
    		echo "<div class='post' id='post_" . $post["postID"] . "'>";
    		echo "<div class='post_title'>" . $post["title"] . "<div class='exit'>" . $delete . "</div>" . "</div>";
    		echo "<div class='post_content'>" . $post["content"] . "</div>";
    		echo "<div class='post_comments'>";
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
	    	echo "<form action = index.php?action=insert&type=comment method='POST'>";
    		echo "<input type='hidden' name='postID' value=" . $post["postID"] . ">";
    		echo "<input name='name' type='text' size='30' maxlength='30' placeholder='Name'><br>";
    		echo "<textarea name='text' cols='50' rows='2'' placeholder='Kommentar/Frage/Anregung'></textarea>";
    		echo "<input type='submit' value='Absenden' class='submit'>";
    		echo "</form>";
	    	echo "</div>";
    		echo "</div>";
    	}
    }
    else {
    	echo "kein Inhalt verfügbar";
    }
?>
