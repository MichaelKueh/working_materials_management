<?php  
    // load up your config file  
    require_once("resources/config.php");    
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
				<?php require_once(TEMPLATES_PATH . "/content.php"); ?>
			</div>
			<div id="footer">
				<?php require_once(TEMPLATES_PATH . "/footer.php"); ?>
			</div>
		</div>
	</body>
</html>