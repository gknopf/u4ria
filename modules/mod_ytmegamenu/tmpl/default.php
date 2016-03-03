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

if (!empty($introtext)){
	echo "<div class=\"yt-introtext\">" . JText::_($introtext) . "</div>";
}
$has_wrapper = $params->get('menustyle')=='dropline' && $params->get('droplinewrapper', 0);
if ($has_wrapper){
	echo '<div class="yt-main" style="width:' . (intval($params->get('droplinewidth', 1023))+1) . 'px">';
}
$moduleMenuBase->getMenu()->getContent();
if ($has_wrapper){
	echo '</div>';
}
if (!empty($footertext)){
	echo "<div class=\"yt-footertext\">" . JText::_($footertext) . "</div>";
}
?>