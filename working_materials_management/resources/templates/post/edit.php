<?php

	if(isAdmin()){
		if( isset($_GET["post"]) ) {
	    	$post = $_GET["post"];
	    	
	    	$result = getPostById($post);
	    	
	    	foreach ($result as $blub) {
	    		$title = $blub["title"];
	    		$content = $blub["content"];
	    		$active = $blub["active"];
	    		$classID = $blub["classID"];
	    		$subjectID = $blub["subjectID"];
	    	}
	    	$link = "index.php?action=update&type=post";
	    	
	    }
	    else {
	    	$post = "";
	    	$title = "";
	    	$content = "";
	    	$active = 1;
	    	$classID = "";
	    	$subjectID = "";
	    	$link = "index.php?action=insert&type=post";
	    }
?>	    
	<form action = " <?= $link ?> " method='POST' enctype='multipart/form-data'>
		<input type='hidden' name='postID' value="<?= $post ?>">
		<input name='title' type='text' size='30' maxlength='30' value='<?= $title ?>' placeholder='Titel'><br><br>
		<textarea name='content' type='text' placeholder='Inhalt' cols='40' rows='4'><?= $content ?></textarea><br><br>
		
		<label for='classID'>Klasse:</label>
		<select name='classID' id='classID'>
		
		<?php
			$classes = getClassesWithoutAdmin();
			 while($row = $classes->fetch_object())
			{
				$selected = $row->classID == $classID ? " selected='selected' " : "";
				
				echo "<option value='" . $row->classID . "'" . $selected . ">" . $row->name ."</option>";
			}
		?>
		</select><br>
		
		<label for='subjectID'>Fach:</label>
		<select name='subjectID' id='subjectID'>
		
		<?php
			$subjects = getSubjects();
			 while($row = $subjects->fetch_object())
			{
				$selected = $row->subjectID == $subjectID ? " selected='selected' " : "";
				
				echo "<option value='" . $row->subjectID . "'" . $selected . ">" . $row->name ."</option>";
			}
		?>
		</select><br><br>
    	
		
		<label for='active'>Aktiv:</label>
		<input type='checkbox' name='active' id='active' <?php if($active) echo "checked='checked'"?>/><br><br>
		
		<label for="file">Dateien:</label>
		<input type="file" name="file[]" multiple="multiple"><br><br>
		<?php
			echo "<div class='post_files'>";
				$files = getFilesByPostId($post);
				if( count($files) > 0 ) {
					echo "<ul class='edit_delete'>";
					foreach($files as $file) {
						echo "<li id=file_". $file["fileID"] .">";
							echo "<div>";
								echo "<div  style='min-width:25em; display:inline-block;'>";
									echo "<a href='index.php?action=getFile&fileID=" .  $file["fileID"] . "'>" . $file["name"] . "</a>";
									echo " (" . round($file["size"] / 1024, 1) . " kB )";
								echo "</div>";
								echo "<div style='display:inline-block;'>";
									echo "<a href='javascript:deleteFile(" .  $file["fileID"] . ");'>" . "L&ouml;schen". "</a>";
								echo "</div>";
							echo "</div>";
						echo "</li>";
					}
					echo "</ul>";
				}
			echo "</div>";
		?>
			
		<label for="link">Links:</label>
		<input type="text" name="name[]" placeholder="Name">
		<input type="text" name="link[]" placeholder="Adresse">
		<input type="button" onclick="addLink();" value="weiteren Link speichern">
		<?php
    		echo "<div class='post_links'>";
				$links = getLinksByPostId($post);
				if( count($links) > 0 ) {
					echo "<h2>Links:</h2>";
	    			echo "<ul class='edit_delete'>";
	    			foreach($links as $link) {
	    				echo "<li id=link_". $link["linkID"] .">";
	    					echo "<div>";
		    					echo "<div  style='min-width:25em; display:inline-block;'>";
			    					if( !(strpos($link["url"],"http") === 0) ) {
				    					$link["url"] = "http://" . $link["url"];
				    				}
		    						echo "<a href='" .  $link["url"] . "' target='_blank'>" . $link["name"] . "</a>";
		    					echo "</div>";
		    					echo "<div style='display:inline-block;'>";
		    						echo "<a href='javascript:deleteLink(" .  $link["linkID"] . ");'>" . "L&ouml;schen". "</a>";
	    						echo "</div>";
    						echo "</div>";
						echo "</li>";
	    			}
	    			echo "</ul>";
				}
    		echo "</div>";
		?>
		<br><br>
			
		<label for="album">Fotos:</label>
		<input type="file" name="image[]" multiple="multiple"><br><br>
		<?php
    		echo "<div class='post_images'>";
				$images = getImagesByPostId($post);
				if( count($images) > 0 ) {
					echo "<ul class='edit_delete'>";
					foreach($images as $image) {
						
						echo "<li id=image_". $image["imageID"] .">";
						echo "<div >";
							echo "<div  style='min-width:25em; display:inline-block;'>";
		    					echo $image["name"];
	    					echo "</div>";
	    					echo "<div style='display:inline-block;'>";
		    					echo "<a href='javascript:deleteImage(" .  $image["imageID"] . ");'>" . "L&ouml;schen". "</a>"; 
	    					echo "</div>";
    					echo "</div>";
						echo "</li>";
					}
					echo "</ul>";
				}
    		echo "</div>";
		?>
		
		<br><br><br><input type='submit' value='Absenden'>
		</form>
<?php
	}
?>
