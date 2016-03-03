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

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'menusys'.DS.'ytloader.php');

// get document direction from template.
$document =& JFactory::getDocument();
$app_direction = $document->params->get('direction', 'ltr');
$params->set('direction', $app_direction);

$params->def('menutype',		'mainmenu');
$params->def('menustyle',		'vmega');
$params->def('moofxduration',	'500');
$params->def('moofx',			'Fx.Transitions.linear');
$params->def('activeslider',	0);
$params->def('jsdropline',		0);
$params->def('startlevel',		0);
$params->def('endlevel',		9);
$params->def('cssidsuffix',		$module->id);
$introtext 	= $params->def('introtext',		'');
$footertext	= $params->def('footertext',	'');

$menubase = dirname(__FILE__) . DS . 'menusys';
$params->set('basepath', str_replace('\\', '/', $menubase));

$position = property_exists($module, 'position') ? $module->position : '';
if (!empty($position)){
	$params->set('exclude_positions', $position);
}

$moduleMenuBase = new YtMenuBase($params->toArray());
$layout = JModuleHelper::getLayoutPath($module->module);
if ($layout){
	require $layout;
} else {
	$moduleMenuBase->getMenu()->getContent();
}