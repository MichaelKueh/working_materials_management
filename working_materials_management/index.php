<?php  
    // load up config file  
    require_once("resources/config.php");
    
    // load up database connection file  
    require_once("resources/database.php");        
    
    // start session
    session_start();
    
    // session handling
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$key = $_POST['login_key'];
		$class = getClassByKey($key);
		
		if ( isset($class) ) {
			$_SESSION['login'] = $class;
		} else {
			$wrongLogin = true;
		}
    }
    
    // define content
    $content = "content.php";
    if( isset($_GET["action"]) ) {
 		switch($_GET["action"]) {
	    	case "class":
	    		$content = "class.php";
	    		break;
	    	case "impressum":
	    		$content = "impressum.php";
	    		break;
	    	case "logout":
	    		session_destroy();
	    		unset($_SESSION['login']);
	    		break;
	    }
    }
    
    // set up navigation
    $menu = Array();
    if( isset($_SESSION['login']) ) {
	    if( $_SESSION['login'] == ("admin") ) {
	    	array_push($menu, array("url" => "index.php", "text" => "Startseite", "class" => "current"));
		    array_push($menu, array("url" => "index.php", "text" => "Beitrag erstellen", "class" => ""));
		    array_push($menu, array("url" => "index.php", "text" => "Alben verwalten", "class" => ""));
		    array_push($menu, array("url" => "index.php?action=class", "text" => "Klassenverwaltung", "class" => ""));
	    } else {
	    	array_push($menu, array("url" => "index.php", "text" => "Alle", "class" => "current"));
		    array_push($menu, array("url" => "index.php", "text" => "Deutsch", "class" => ""));
		    array_push($menu, array("url" => "index.php", "text" => "Mathematik", "class" => ""));
		    array_push($menu, array("url" => "index.php", "text" => "Sachunterricht", "class" => ""));
	    }
    } else {
    	array_push($menu, array("url" => "index.php", "text" => "Startseite", "class" => "current"));
    }    
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Arbeitsmaterialien</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo STYLESHEET_PATH . "/layout.css" ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo STYLESHEET_PATH . "/format.css" ?>" />
	</head>
	<body>
		<div id="container">
			<div id="banner">
				<?php require_once(TEMPLATES_PATH . "/banner.php"); ?>
			</div>
			<div id="right">
				<?php require_once(TEMPLATES_PATH . "/right.php"); ?>
			</div>
			<div id="content">
				<?php require_once(TEMPLATES_PATH . "/" . $content); ?>
			</div>
			<div id="footer">
				<?php require_once(TEMPLATES_PATH . "/footer.php"); ?>
			</div>
		</div>
	</body>
</html>