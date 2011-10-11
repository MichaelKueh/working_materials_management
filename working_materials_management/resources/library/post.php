<?php
/*
 * Created on 10.10.2011
 *
 */
 
 if( !isset($_SESSION['key']))
 {
 	$key = 0;
 }
 else
 {
 	$key = $_SESSION['key'];
 }
 $query = sprintf("SELECT p.postID, p.title  FROM post p, class c WHERE p.classID = c.classID AND c.key = %s", $key);
 
 $result = mysql_query($query, $link);
 while ($row = mysql_fetch_object())
 {
 	echo "$row->title $row->postID";
 }
?>
