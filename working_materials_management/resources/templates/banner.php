<h1>
	<class style="color: #ff0000">A</class>
	<class style="color: #EEEE00">r</class>
	<class style="color: #ffa500">b</class>
	<class style="color: #ff0000">e</class>
	<class style="color: #EEEE00">i</class>
	<class style="color: #ffa500">t</class>
	<class style="color: #ff0000">s</class>
	<class style="color: #EEEE00">m</class>
	<class style="color: #ffa500">a</class>
	<class style="color: #ff0000">t</class>
	<class style="color: #EEEE00">e</class>
	<class style="color: #ffa500">r</class>
	<class style="color: #ff0000">i</class>
	<class style="color: #EEEE00">a</class>
	<class style="color: #ffa500">l</class>
	<class style="color: #ff0000">i</class>
	<class style="color: #EEEE00">e</class>
	<class style="color: #ffa500">n</class>
</h1>    
<ul id="menu">
	<?php
		foreach ($menu as $entry) {
		  echo "<li><a href=\"" . $entry["url"] . "\" class=\"" . $entry["class"] . "\">" . $entry["text"] . "</a></li>";  
		}
		
	?>
</ul>  