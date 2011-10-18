<?php
if(isAdmin()){
	if( isset($_GET["id"]) ) {
		deleteFile($_GET["id"]);
	}
}
?>
