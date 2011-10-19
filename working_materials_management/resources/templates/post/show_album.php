<script>
	Galleria.loadTheme('resources/library/galleria/themes/classic/galleria.classic.min.js');
</script>

<?php if(isset($_GET["postID"])) { ?>
	<div class='post_images'>
	<?php $images = getImagesByPostId($_GET["postID"]);
		if( count($images) > 0 ) {
			foreach($images as $image) { ?>
    			<img src='resources/templates/post/get_image.php?imageID=<?= $image["imageID"] ?>'/>
    		<?php } ?>
			<script>
				$('.post_images').galleria({width: 700, height: 500});
			</script>
		<? } ?>
    </div>	
<?php } ?>
