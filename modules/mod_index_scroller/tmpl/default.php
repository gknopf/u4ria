<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_banners
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_ROOT . '/components/com_banners/helpers/banner.php';
$baseurl = JURI::base();
?>
<div id="slidebox">
    <div class="next"></div>
    <div class="previous"></div>
    <div class="thumbs">
    	<?php $i=1 ;
			foreach($list as $item):?>
	    <a href="#" onClick="Slidebox('<?php echo $i;?>');return false" class="thumb"><?php echo $i;?></a>
	    <?php 
	    	$i++;
	    endforeach; ?> 

    </div>

	<div class="container">
	<?php 
	
	foreach($list as $item):?>
		<?php $link = JRoute::_('index.php?option=com_banners&task=click&id='. $item->id);?>
		<div class="content">
            <div>

			<h3><?php echo str_replace("20", "<span>20</span>", $item->name); ?></h3>
			<?php $imageurl = $item->params->get('imageurl');?>
				<?php $width = $item->params->get('width');?>
				<?php $height = $item->params->get('height');?>
				<?php if (BannerHelper::isImage($imageurl)) :?>
					<?php // Image based banner ?>
					<?php $alt = $item->params->get('alt');?>
					<?php $alt = $alt ? $alt : $item->name ;?>
					<?php $alt = $alt ? $alt : JText::_('MOD_BANNERS_BANNER') ;?>
					<?php if ($item->clickurl) :?>
						<?php // Wrap the banner in a link?>
						<?php $target = $params->get('target', 1);?>
						<?php if ($target == 1) :?>
							<a
								href="<?php echo $link; ?>" target="_blank"
								title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
								<img
									src="<?php echo $baseurl . $imageurl;?>"
									alt="<?php echo $alt;?>"
									<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
									<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
								/>
							</a>
						<?php elseif ($target == 2):?>
							<?php // open in a popup window?>
							<a
								href="javascript:void window.open('<?php echo $link;?>', '',
									'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');
									return false"
								title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
								<img
									src="<?php echo $baseurl . $imageurl;?>"
									alt="<?php echo $alt;?>"
									<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
									<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
								/>
							</a>
						<?php else :?>
							<?php // open in parent window?>
							<a
								href="<?php echo $link;?>"
								title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
								<img
									src="<?php echo $baseurl . $imageurl;?>"
									alt="<?php echo $alt;?>"
									<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
									<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
								/>
							</a>
						<?php endif;?>	
					<?php else :?>
						<?php // Just display the image if no link specified?>
						<img
							src="<?php echo $baseurl . $imageurl;?>"
							alt="<?php echo $alt;?>"
							<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
							<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
						/>
					<?php endif;?>	
				<?php endif;?>	
				<div class="footer-title"><span><?php echo $item->params->get('alt'); ?></span> <p>U4Ria</p></div>	
		</div>
	</div>
			
	<?php endforeach; ?>
</div>

</div>

