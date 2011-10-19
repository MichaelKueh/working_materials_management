<?php
if(isAdmin()){
	if( isset($_GET["id"]) ) {
		deleteLink($_GET["id"]);
	}
}
?>
