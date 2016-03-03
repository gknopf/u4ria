<?php 
/* 
* @author Bryan Keller
* Email : satechheads@yahoo.com
* URL : www.sanantoniocomputerrepair.net
* Description : This module displays icon links to your social media profiles.
* Copyright (c) 2008-2010 Techheads IT Consulting
* License GNU GPL
***/

// no direct access
defined('_JEXEC') or die;
 
$document =& JFactory::getDocument();
$mod = JURI::base() . 'modules/mod_socialmedialinks/';
$document->addStyleSheet(JURI::base() . 'modules/mod_socialmedialinks/style.css');

// Get Basic Module Parameters 
	$moduleclass_sfx 	= $params->get('moduleclass_sfx','');
	$target 			= $params->get('target','_blank');
	$robots			= $params->get('robots','1');
	$size 			= $params->get('size','32'); 
	$align 			= $params->get('align','left'); 
	$margin			= $params->get('margin','3px'); 
	$margin         = intval($margin);
	$text 		= $params->get('text','Follow us on'); 
	$rsstext 		= $params->get('rsstext','Subscribe to our Feed'); 
	$credits      	= $params->get('credits','1'); 
	$size2 	     	= intval($size) + intval($margin);
	$effect		= $params->get('effect','none');
	$ssize		= intval($size) - 4;
	$ssizeoffset	= intval($size) - 2 + intval($margin);
	$gsize		= intval($size) + 4;
	$gsizeoffset	= intval($size) + 2 + intval($margin);
	$backcolor		= $params->get('backcolor','#ffffff');
	$shiftoffset	= intval($size) + intval($margin);
	$highlight		= $params->get('highlight','#ffff00');
	$rotatedeg		= $params->get('rotatedeg',"90");



// Prepare the Link Attribute
	if($robots == '1') {
	$nofollow = 'rel="nofollow"';
	}else{
	$nofollow = '';
	}

// Prepare the Icon Alignment Style
	$alignstyle = "text-align: $align ";

// Get Icon Parameters
$ic = array(
	$params->get('ic1'), $params->get('ic2'), $params->get('ic3'));

$url = array(
	$params->get('url1'), $params->get('url2'), $params->get('url3'));
	
	$vimg = array();
     $vurl = array();
	
// Set Wrapping Div
	echo '<div class="smile" style="'. $alignstyle .'"> ';
	
// Prepare the Icon List
	for($i=0;$i < count($ic);$i++)
     {   
     $vimg[$ic[$i]]= htmlspecialchars($url[$i]);
	 $vurl[$url[$i]]=$ic[$i];
	 $title = ucwords(substr($vurl[$url[$i]], 0 , -4));
	 
// Output the Icon Links	
	 	 if(($vimg[$ic[$i]]) != '') {
		 	
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$size.'px; height: '.$size.'px; margin:'. $margin .'px;" src="'. $mod .'icons/'. $vurl[$url[$i]] .' " alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}

switch ($effect) {
    case "none":
        break;
    case "custom":
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$size.'px; height: '.$size.'px; opacity:0.0;filter:alpha(opacity=0); position: relative; margin-bottom: '. $margin .'px; margin-left: -'. $size2 .'px; z-index: 2;" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100" onmouseout="this.style.opacity=0.0;this.filters.alpha.opacity=0" src="'. $mod .'icons/mo/'. $vurl[$url[$i]] .'" alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}
        break;
    case "dogear":
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$size.'px; height: '.$size.'px; opacity:0.0;filter:alpha(opacity=0); position: relative; margin-bottom: '. $margin .'px; margin-left: -'. $size2 .'px; z-index: 2;" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100" onmouseout="this.style.opacity= 0.0;this.filters.alpha.opacity=0" src="'. $mod .'icons/mo/dogear.png" alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}
        break;
	case "shrink":
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$ssize.'px; height: '.$ssize.'px; opacity:0.0;filter:alpha(opacity=0); position: relative; margin-bottom: '. $margin .'px; border: 3px solid '. $backcolor .'; margin-left: -'. $size2 .'px; z-index: 4;" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.opacity=0.0;this.filters.alpha.opacity=0" src="'. $mod .'icons/'. $vurl[$url[$i]] .'" alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}
        break;
	case "enlarge":
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$gsize.'px; height: '.$gsize.'px; opacity:0.0;filter:alpha(opacity=0); position: relative; margin-bottom: '. $margin .'px; margin-left: -'. $gsizeoffset .'px; z-index: 2;" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100" onmouseout="this.style.opacity=0.0;this.filters.alpha.opacity=0" src="'. $mod .'icons/'. $vurl[$url[$i]] .'" alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}
        break;
	case "shiftup":
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$size.'px; height: '.$size.'px; opacity:0.0;filter:alpha(opacity=0); position: relative; margin-bottom: '. $margin .'px; border-bottom-style: solid; border-bottom-width: 3px; border-bottom-color: '. $backcolor .'; margin-left: -'. $shiftoffset .'px; z-index: 2;" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.opacity=0.0;this.filters.alpha.opacity=0" src="'. $mod .'icons/'. $vurl[$url[$i]] .'" alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}
        break;
	case "highlight":
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$ssize.'px; height: '.$ssize.'px; opacity:0.0;filter:alpha(opacity=0); position: relative; margin-bottom: '. $margin .'px; border:2px solid '. $highlight .'; margin-left: -'. $size2 .'px; z-index: 4;" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.opacity=0.0;this.filters.alpha.opacity=0" src="'. $mod .'icons/'. $vurl[$url[$i]] .'" alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}
        break;
	case "rotate":
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$size.'px; height: '.$size.'px; -moz-transform: rotate('.$rotatedeg.'deg); -ms-transform: rotate('.$rotatedeg.'deg); opacity:0.0;filter:alpha(opacity=0); position: relative; margin-bottom: '. $margin .'px; margin-left: -'. $size2 .'px; z-index: 2;" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100"
onmouseout="this.style.opacity=0.0;this.filters.alpha.opacity=0" src="'. $mod .'icons/'. $vurl[$url[$i]] .'" alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}
        break;
	case "bullseye":
			echo '<a '. $nofollow .' href="'. $vimg[$ic[$i]]. '" target="'. $target .'"><img style="width: '.$size.'px; height: '.$size.'px; opacity:0.0;filter:alpha(opacity=0); position: relative; margin-bottom: '. $margin .'px; margin-left: -'. $size2 .'px; z-index: 2;" onmouseover="this.style.opacity=1;this.filters.alpha.opacity=100" onmouseout="this.style.opacity=0.0;this.filters.alpha.opacity=0" src="'. $mod .'icons/mo/bullseye.png" alt="'. $title .'" '; if($title == 'Feed') { echo 'title="'. $rsstext .'" /></a>';}else{ echo 'title="'. $text .' '. $title .'" /></a>';}
        break;
			}
		 }
	 } 

			if($credits == '1') :
				echo '<div class="smilecredits" style="text-align:'. $alignstyle .';margin: 0px '.$margin.' 0px '.$margin.';"><a href="http://www.free-extensions.com/" title="Joomla Extensions">Joomla Extensions</a></div>';
			endif;
		?>
	</div>
    <div class="clr"></div>
