<?php

	if(isAdmin()){
	    echo "<a href='index.php?action=edit_class'>Neue Klasse erstellen </a>";
	    
	    $classes = getClasses();
	    
	    echo "<table>";
	    echo "<tr>";
			echo "<th>ClassID</th>";
			echo "<th>Klassenname</th>";
			echo "<th>Loginschl&uuml;ssel</th>";
			echo "<th></th>";
			echo "<th></th>";
		echo "</tr>";
	    
	    while($row = $classes->fetch_object())
		{
			echo "<tr>";
			echo "<td>" . $row->classID . "</td>";
			echo "<td>" . $row->name . "</td>";
			echo "<td>" . $row->login_key . "</td>";
			echo "<td><a href='index.php?action=edit_class&class=" . $row->classID . "'> &Auml;ndern </a></td>";
			echo "<td><a href='index.php?action=delete_class&class=" . $row->classID . "'> L&ouml;schen </a></td>";
			echo "</tr>";
		}
		
		echo "</table>";
	}
	else
		require_once("content.php");
?>
