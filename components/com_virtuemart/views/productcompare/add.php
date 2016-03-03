<?php

define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
echo dirname(__FILE__);
//require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
//require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
 
	session_start(); 
	$id = $_GET['virtuemart_product_id'];	 	
	
	if (!isset($_SESSION['pid'])){
		$my_array = array();
	}
	else{
		$my_array = $_SESSION['pid'];
	}	
	
	
	if (!isset($_GET['remove'])){
		$my_array[] = $id;
	}
	else{
		$my_array = array_diff($my_array, array($id));
	}
	
	$_SESSION['pid'] = $my_array;
	
	// Do lots of devilishly clever analysis and processing here...
    echo json_encode($my_array);
 
?>