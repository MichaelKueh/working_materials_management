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
	    	$active = "";
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
		<input type='checkbox' name='active' id='active' checked='checked'/><br><br>
		
		<label for="file">Dateien:</label>
		<input type="file" name="file[]" multiple="multiple"><br><br>
			
		<label for="link">Links:</label>
		<input type="text" name="name[]" placeholder="Name">
		<input type="text" name="link[]" placeholder="Adresse">
		<input type="button" onclick="addLink();" value="weiteren Link speichern">
		<br><br>
			
		<label for="album">Fotos:</label>
		<input type="file" name="image[]" multiple="multiple"><br><br>
		
		<br><br><br><input type='submit' value='Absenden'>
		<input type='button' value='Abbrechen' onclick='history.back();'>
		</form>
<?php
	}
?>