<?php  
    // load up config file  
    require_once("resources/config.php");
    
    // load up database connection file  
    require_once("resources/database.php");        
    
    // start session
   	session_start();
    
    // session handlin
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
    	$content = $_GET["action"] . ".php";
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
	    if( strcmp($_SESSION['login'] , "admin")==0 ) {
	    	array_push($menu, array("url" => "index.php", "text" => "Startseite", "class" => "current"));
		    array_push($menu, array("url" => "index.php", "text" => "Beitrag erstellen", "class" => ""));
		    array_push($menu, array("url" => "index.php", "text" => "Alben verwalten", "class" => ""));
		    array_push($menu, array("url" => "index.php?action=class", "text" => "Klassenverwaltung", "class" => ""));
	    } else {
	    	$subject = 0;
	    	$bsubject = false;
			if(isset($_GET["subject"])) {
				$subject = $_GET["subject"];
				$bsubject = true;
			}
	    	array_push($menu, array("url" => "index.php?action=show_posts", "text" => "Alle", "class" => $bsubject?"":"current"));
	    	$classes = getSubjects();
	    	while($row = $classes->fetch_object()) {
				if($row->subjectID == $subject) {
					$class = "current";
				}
				else {
					$class = "";
				}
				array_push($menu, array("url" => "index.php?action=show_posts&subject=" . $row->subjectID , "text" => $row->name, "class" => $class));
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