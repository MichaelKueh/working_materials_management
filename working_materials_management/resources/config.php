<?php
	$config = array(  
	    "db" => array(    
	        "dbname" => "wmm",  
	        "username" => "root",  
	        "password" => "",  
	        "host" => "localhost"  
	    ),  
	    "urls" => array(  
	        "baseUrl" => "http://example.com"  
	    ),  
	    "paths" => array(  
	        "resources" => "/path/to/resources",  
	        "images" => array(  
	            "content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",  
	            "layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"  
	        )  
	    )  
	); 
	
	defined("LIBRARY_PATH")  
	    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));  
	  
	defined("TEMPLATES_PATH")  
	    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
	    
	defined("STYLESHEET_PATH")  
	    or define("STYLESHEET_PATH", "/public_html/css");
	    
	defined("JAVASCRIPT_PATH")  
	    or define("JAVASCRIPT_PATH", "/public_html/js");    
	
	defined("LIBRARY_PATH")  
	    or define("LIBRARY_PATH", "/resources/library");
	  
	/* 
	    Error reporting. 
	*/  
	ini_set("error_reporting", "true");  
	error_reporting(E_ALL|E_STRCT);  
?>
