<?php
if(isAdmin()){
	if( isset($_GET["id"]) ) {
		deleteImage($_GET["id"]);
	}
}
?>
