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

if ($this->isRoot()){
	$menucssid = $this->params->get('menustyle') . 'navigator' . $this->params->get('cssidsuffix');
	$addCssRight = $this->params->get('direction', 'ltr')=='rtl' ? "rtl" : "";
	echo "<ul id=\"$menucssid\" class=\"navi$addCssRight\">";
	if($this->haveChild()){
		$idx = 0;
		foreach($this->getChild() as $child){
			$child->addClass('level'.$child->get('level',1));
			++$idx;
			if ($idx==1){
				$child->addClass('first');
			} else if ($idx==$this->countChild()){
				$child->addClass('last');
			}
			if ($child->haveChild()){
				$child->addClass('havechild');
			}
			$child->getContent();
		}
	}
	echo "</ul>";
	
	// import assets
	$this->addStylesheet(array('moomenu.css'));
	$j15 = $this->j15 ? "15" : "";
	
	if ($this->j15){
		JHTML::_('behavior.mootools');
	} else {
		JHtml::_('behavior.framework', true);
	}
	
	$this->addScript(array("menulib$j15.js"));
	
	$duration   = $this->params->get('moofxduration', '300');
	$transition = $this->params->get('moofx', 'Fx.Transitions.linear');
	$debug		= 0!=$this->params->get('debug', 0) ? 'true' : 'false';
	$document 	=& JFactory::getDocument();
	$activeSlider = intval($this->params->get('activeslider', '0')) ? 1 : 0;
	$document->addScriptDeclaration("
		window.addEvent('domready',function() {
			new YTMenu(
				$('$menucssid'),
				{
					duration: $duration,
					transition: $transition,
					slide: 1,
					wrapperClass: 'yt-main',
					activeSlider: $activeSlider,
					debug: $debug
				});
			}
		);
		"
	);

} else if ( $this->canAccess() ){
	$haveChild = $this->haveChild();
	$liClass = $this->haveClass() ? "class=\"{$this->getClass()}\"" : "";
?>

<li <?php echo $liClass; ?>>
	<?php echo $this->getLink(); ?>
	<?php
		if($haveChild){
			$levelClassName = 'level'.($this->get('level',1)+1);
			$subStyleWidth = $this->getSubmenuWidth();
			
			echo "<ul class=\"{$levelClassName} subnavi\" $subStyleWidth>";
			$cidx = 0;
			foreach($this->getChild() as $child){
				$child->addClass($levelClassName);
				++$cidx;
				if ($cidx==1){
					$child->addClass('first');
				} else if ($cidx==$this->countChild()){
					$child->addClass('last');
				}
				if ($child->haveChild()){
					$child->addClass('havechild');
				}
				$child->getContent();
			}
			echo "</ul>";
		}
	?>
</li>

<?php
}
?>