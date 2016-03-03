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

if (!function_exists('p')){
	define('YTDEBUG', 1);
	function p($var, $usedie=null){
		if(!defined('YTDEBUG') || YTDEBUG==0) return false;
		if (isset($usedie) && !$usedie) return false;
		echo "<pre>";
		switch(gettype($var)){
			case 'number':
			case 'string': echo "$var<br>"; break;
			case 'array': print_r($var); break;
			default:
				var_dump($var);
		}
		echo "</pre>";
		if (isset($usedie) && $usedie) die();
	}
}