<?php  
    // load up config file  
    require_once("resources/config.php");
    
    // load up database connection file  
    require_once("resources/database.php");        
    
    // start session
   	session_start();
    
    // session handling
    if( !isset($_SESSION['login']) )
    {
	    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
			$key = $_POST['login_key'];
			$class = getClassByKey($key);
			
			if ( isset($class) ) {
				$_SESSION['classId'] = getClassIdByKey($key);
				$_SESSION['login'] = $class;
			} else {
				$wrongLogin = true;
			}
	    }
    }
    
    // define content
    if( isset($_GET["action"]) ) {
    	
    	if( $_GET["action"] == "logout") {
    		unset($_SESSION['classId']);
    		unset($_SESSION['login']);
    	}
    	
    	$content = $_GET["action"] . ".php";
    	if( isset($_GET["type"]) )
    		$content = $_GET["type"] . "/" . $content;
    }
    else {
    	$content = "content.php";
    }
    
    function isAdmin()
    {
    	if( isset($_SESSION['login']) ){
    		 if( strcmp($_SESSION['login'] , "admin")==0 ) {
    		 	return true;
    		 }
    	}
    	return false;
    }
    
    // set up navigation
    $menu = Array();
    if( isset($_SESSION['login']) ) {
	    if( $_SESSION['login'] == "admin" ) {
	    	// initialize $_GET["action"] if its not defined
	    	$_GET["type"] = isset($_GET["type"]) ? $_GET["type"] : "";
	    	
	    	array_push($menu, array("url" => "index.php", "text" => "Startseite", "class" => $_GET["type"] == "" ? "current" : ""));
		    array_push($menu, array("url" => "index.php?action=post&type=post", "text" => "Beitr&auml;ge verwalten", "class" => $_GET["type"] == "post" ? "current" : ""));
		    array_push($menu, array("url" => "index.php?action=class&type=class", "text" => "Klassenverwaltung", "class" => $_GET["type"] == "class" ? "current" : ""));
	    } else {
	    	$subject = 0;
	    	$bsubject = false;
			if(isset($_GET["subject"])) {
				$subject = $_GET["subject"];
				$bsubject = true;
			}
	    	array_push($menu, array("url" => "index.php?action=post&type=post", "text" => "Alle", "class" => $bsubject?"":"current"));
	    	$classes = getSubjects();
	    	while($row = $classes->fetch_object()) {
				if($row->subjectID == $subject) {
					$class = "current";
				}
				else {
					$class = "";
				}
				array_push($menu, array("url" => "index.php?action=post&type=post&subject=" . $row->subjectID , "text" => $row->name, "class" => $class));
			}
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
		<link rel="stylesheet" type="text/css" href="<?php echo STYLESHEET_PATH . "/apprise.min.css" ?>" />
		<script type="text/javascript" src="<?php echo JAVASCRIPT_PATH . "/apprise-1.5.min.js" ?>"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo JAVASCRIPT_PATH . "/main.js" ?>"> </script>
		<script type="text/javascript" src="<?php echo "resources/library/galleria/galleria-1.2.5.min.js" ?>"> </script>
	</head>
	<body>
		<div id="container">
			<div id="banner">
				<?php require_once(TEMPLATES_PATH . "/banner.php"); ?>
			</div>
			<div id="login">
				<?php require_once(TEMPLATES_PATH . "/login.php"); ?>
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