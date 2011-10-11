<?php
	// load up database connection file  
    require_once("resources/database.php");
    
    $classes = getClasses();
    
    echo "<table>";
    echo "<tr>";
		echo "<td>ClassID</td>";
		echo "<td>Klassenname</td>";
		echo "<td>Loginschl&uuml;ssel</td>";
	echo "</tr>";
    
    while($row = mysql_fetch_array($classes))
	{
		echo "<tr>";
		echo "<td>" . $row['classID'] . "</td>";
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['login_key'] . "</td>";
		echo "</tr>";
	}
	
	echo "</table>";
?>
