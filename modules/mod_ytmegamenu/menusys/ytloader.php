<?php
/*------------------------------------------------------------------------
 # Yt Megamenu - Version 1.0
 # Copyright (C) 2009-2011 The YouTech Company. All Rights Reserved.
 # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Author: The YouTech Company
 # Websites: http://www.ytcvn.com
 -------------------------------------------------------------------------*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
if (!defined('YT_MENU_LOADED')){
	define('YT_MENU_LOADED', 1);
	include_once 'ytdebuger.php';
	include_once 'ytobject.php';
	include_once 'ytparam.php';
	include_once 'ytmenu.php';
	include_once 'ytmenubase.php';
}
