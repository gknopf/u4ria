<?php
/**
*
* Information regarding the product status
*
* @package	VirtueMart
* @subpackage Product
* @author RolandD
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: product_edit_status.php 4380 2011-10-13 17:55:39Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
<!--

	function addVideos()
	{
		var videoTitle = document.getElementById('video_title_single');
		var videoLink = document.getElementById('video_link_single');
		if (videoTitle.value != "" && videoLink.value != "")
		{
			var count = jQuery('#product_videos_list').find('.row1').length;
			if (count >= 8) {
			  alert('Maximum video link is 8 links');
				return false;
			}

			jQuery('#product_videos_list').append('<tr class="row1"><td>' + videoTitle.value + '<input type="hidden" name="video_title[]" value="' + videoTitle.value + '"></td><td><a href="' + videoLink.value + '" target="_blank">' + videoLink.value + '</a><input type="hidden" name="video_link[]" value="' + videoLink.value + '"></td><td><a href="javascript:void(0)" onclick="jQuery(this).parent().parent().remove();">[Remove]</a></td>	</tr>');
			videoTitle.value = "";
			videoLink.value = "";
		}
	}

//-->
</script>

<table width="100%">
	<tr>
		<td width="100%">
			<fieldset style="background-color:#F9F9F9;">
				<legend><?php echo JText::_('COM_VIRTUEMART_VIDEO_LIST' );?></legend>
				<div id="videolist">
				<table id="custom_fields" class="adminlist" cellspacing="0" cellpadding="0">
					<thead>
					<tr class="row1">
						<th><?php echo JText::_('COM_VIRTUEMART_TITLE');?></th>
						<th><?php echo JText::_('COM_VIRTUEMART_VIDEO_LINK');?></th>
						<th><?php echo JText::_('COM_VIRTUEMART_ACTION');?></th>
					</tr>
					</thead>
					<tbody id="product_videos_list">
					<?php
					$i=1;
					if (is_array($this->product->product_videos) && count($this->product->product_videos) > 0)
					{
						foreach ($this->product->product_videos as $item):
						$published = JHTML::_('grid.published', $item, $i );
						?>
						<tr class="row1" id="<?php echo $item->virtuemart_video_id; ?>">
							<td><?php echo $item->video_title;?>
								<input type="hidden" name="video_title[]" value="<?php echo $item->video_title;?>">
							</td>
							<td><a href="<?php echo $item->video_link;?>" target="_blank"><?php echo $item->video_link;?></a>
							<input type="hidden" name="video_link[]" value="<?php echo $item->video_link;?>">
							</td>
							<td><a href="javascript:void(0)" onclick="jQuery(this).parent().parent().remove();">[Remove]</a></td>

						</tr>
						<?php
						$i++;
						endforeach;
					}
					?>
					</tbody>
				</table>
				</div>
			</fieldset>
			<fieldset style="background-color:#F9F9F9;">
				<legend>Add New</legend>
				<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><?php echo JText::_('COM_VIRTUEMART_TITLE');?></td>
					<td><?php echo JText::_('COM_VIRTUEMART_VIDEO_LINK');?></td>
					<td></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="video_title_single" id="video_title_single" value="" size="80">
					</td>
					<td>
						<input type="text" name="video_link_single" id="video_link_single" value=""  size="80">
					</td>
					<td>
						<input type="button" value="Add" onclick="addVideos();">
					</td>
				</tr>
				</table>
			</fieldset>
		</td>
	</tr>
</table>
