<script type="text/javascript">
	function showFile() {
		$("#file").slideDown();
		$("#link").slideUp();
		$("#album").slideUp();
	}
	
	function showLink() {
		$("#link").slideDown();
		$("#file").slideUp();
		$("#album").slideUp();
	}
	
	function showAlbum() {
		$("#album").slideDown();
		$("#file").slideUp();
		$("#link").slideUp();
	}
</script>
	<div id='nav'>
		<a href='#' onclick='showFile();'>Datei hochladen</a> |
		<a href='#' onclick='showLink();'>Link teilen</a> |
		<a href='#' onclick='showAlbum();'>Album ver&ouml;ffentlichen</a>
	</div><br>

<?php

	if(isAdmin()){
		if( isset($_GET["post"]) ) {
	    	$post = $_GET["post"];
	    	
	    	$result = getPostId($post);
	    	
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
		
		<div id="file" style="display:none;">
			<label for="file">Datei:</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
			<input type="file" name="file" id="file">
		</div>
	
		<div id="link" style="display:none;">
			<label for="link">Link:</label>
			<input type="text" name="link" id="link">
		</div>
		
		<div id="album" style="display:none;">
			<label for="album">Album:</label>
			<input type="text" name="link" id="album">
		</div>
		
		<br><br><input type='submit' value='Absenden'>
		<input type='button' value='Abbrechen' onclick='history.back();'>
		</form>
		<script>showFile();</script>
<?php
	}
?>