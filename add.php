<?php

define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
define('JPATH_BASE', dirname(__FILE__) );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();

$session =& JFactory::getSession();
	$id = $_GET['virtuemart_product_id'];	 	
	
	//$my_array = $session->get('pid');
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
	$session->set('pid',$my_array);
	// Do lots of devilishly clever analysis and processing here...
	$json= array();
	$json['pid'] = $id;
	$json['list'] = sizeof($my_array);
    echo json_encode($json);
 
?>