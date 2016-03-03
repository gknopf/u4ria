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

$sublevelClass = 'level'.( 1+$this->get('level',1) );
$submenuClass  = 'subnavi ' . $sublevelClass;
?>
<div class="mega-group">
	<div class="mega-group-title">
		<?php
			echo $this->getLink();
		?>
	</div>
	<?php
	if($this->haveMegaContent()){
		$contentType = $this->params->get('ytext_contenttype');
	?>
	<div class="mega-group-content">
		<?php
		if($contentType=='menu' || $contentType=='megachild'){
			$styleofcolumn = $this->params->get('styleofcolumn', '');
		?>
		<ul class="<?php echo $submenuClass; ?>" <?php echo $styleofcolumn; ?>>
			<?php
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
						if ($child->haveMegaContent()){
							$child->addClass('havechild');
						}
						$child->getContent();
					}
				}
			?>
		</ul>
		<?php
		} else if ($contentType=='mod' || $contentType=='pos'){
			$listModules = $this->loadModules();
			if (count($listModules)>0){
				foreach ($listModules as $k => $module){
					$m_params = new YtParams($module->params);
					$m_class_sfx = $m_params->get('moduleclass_sfx', '');
					$m_showtitle = $module->showtitle; //$m_params->get('moduleclass_sfx', '');
				?>
					<div class="mega-module<?php echo $m_class_sfx;?> moduletable<?php echo $m_class_sfx; ?>">
						<?php if ($m_showtitle):?>
						<div class="mega-module-title">
							<h3><?php echo $module->title; ?></h3>
						</div>
						<?php endif; ?>
						<div class="mega-module-content">
						<?php
							echo JModuleHelper::renderModule($module, array('style'=>'raw'));
						?>
						</div>
					</div>
				<?php
				}
			}
		}
		?>
	</div>
	<?php
	}
	?>
</div>