<?php
/*
* Created by		: Demente Design
* Email				: contact@demente-design.com
* Created on		: september 2010
* Last Modified 	: june 2011
* URL				: http://demente-design.com
* License			: GPLv2
* Copyright			: 2011 demente-design.com
* License 			: GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
* 
* The icons included by default in the package are from www.komodomedia.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
	
$document =& JFactory::getDocument();
$modulePath = JURI::base() . 'modules/mod_dmt_social/';

// add the stylesheet
if($params->get('addCSS')){
	$document->addStylesheet($modulePath.'css/dmt_social.css');
}

// Parameters
$websites = $params->get('websites');
$iconSize = $params->get('iconSize');
$addRelMe = $params->get('addRelMe');
$addRelNofollow = $params->get('addRelNofollow');
$RSS = $params->get('RSS');
$targetBlank = $params->get('targetBlank');

// Check for rel attributes
$rel = '';
if($addRelMe || $addRelNofollow){
	$rel .= ' rel="';
	if($addRelMe && $addRelNofollow){ $rel .= "me "; }
	else if($addRelMe){ $rel .= "me"; }
	if($addRelNofollow){ $rel .= "nofollow"; }
	$rel .= '"';
}
?>
<div class="slabel" style="text-align: center;">Visit U4ria at:</div>
<ul class="dmt-social-links<?php echo $params->get('moduleclass_sfx'); ?> dmt-icons-<?php echo $iconSize; ?>">
	<?php foreach( $websites as $key => $website ): ?>
	<li class="<?php echo $website->icon; ?>">
		<a title="<?php echo $website->alt; ?>"<?php echo $rel; ?> href="<?php echo $website->url; ?>"<?php if($targetBlank) echo ' target="_blank"'; ?>>
			<img src="<?php echo $modulePath.'icons/'.$website->icon.'_'.$iconSize.'.png'; ?>" alt="" />
		</a>
	</li>
	<?php endforeach; ?>	

	<?php if ($RSS && !is_null($RSSlink)): ?>
	<li class="rss">
		<a href="<?php echo $RSSlink; ?>">
			<img src="<?php echo $modulePath.'icons/rss_'.$iconSize.'.png'; ?>" alt="" />
		</a>
	</li>
	<?php endif; ?>
</ul>
<div class="slabel" style="text-align: center;">Share with friends:</div>
<div id="socialsharemod">
    <div class="addthis_toolbox addthis_default_style addthis_16x16_style">
    <a class="addthis_button_facebook" href="https://www.facebook.com/pages/U4Ria-Adult-Healthy-Lifestyle/129421453774690?fref=ts"></a>
    <a class="addthis_button_google_plusone_share" href="https://plus.google.com/114392103242436347955/about"></a>
    <a class="addthis_button_linkedin" href="http://www.linkedin.com/in/u4ria"></a>
    <a class="addthis_button_twitter" href="https://twitter.com/u4ria_sg"></a>
    <a class="addthis_button_pinterest_share" href="http://www.pinterest.com/u4riasg/"></a>
    <a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a>
    </div>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
</div>
<div class="slabel" style="text-align: center;">Contact Us at 065-822 89339:<br/>
Skype: bensongoh69</div>
<div id="socialsharemod">
    <div class="addthis_toolbox addthis_default_style addthis_16x16_style">
    <a onclick="return false;"><img src="images/Whatsapp-WeChat-Line-Logo.jpg" height="30"/>&nbsp;<img src="images/skype.jpg" height="30"/></a>
    </div>
    
</div>	