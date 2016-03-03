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
defined('_JEXEC') or die('Restricted access'); 
$i = 0;
$modelRelation = $this->getModel( 'product_relations');
if (is_array($this->product->product_relations) && count($this->product->product_relations) > 0)
{
	foreach ($this->product->product_relations as $related)
	{
		$display = $modelRelation->inputType($related->related_products,$row);
		if($related->type == 1)
		{
			$html1 .= '<div class="vm_thumb_image">
				<span>'.$display.'</span>
				<input type="hidden" value="' . $related->virtuemart_product_id . '" name="virtuemart_product_id[]" />
				<input type="hidden" value="' . $related->related_products .  '" name="related_products[]" />
				<input type="hidden" value="' . $related->type .  '" name="type[]" />
				<div class="vmicon vmicon-16-remove"></div></div>';
		}	
		else if($related->type == 2)
		{
			$html2 .= '<div class="vm_thumb_image">
				<span>'.$display.'</span>
				<input type="hidden" value="' . $related->virtuemart_product_id . '" name="virtuemart_product_id[]" />
				<input type="hidden" value="' . $related->related_products .  '" name="related_products[]" />
				<input type="hidden" value="' . $related->type .  '" name="type[]" />
				<div class="vmicon vmicon-16-remove"></div></div>';
		}	
		else 
		{
		
			$html3 .= '<div class="vm_thumb_image">
				<span>'.$display.'</span>
				<input type="hidden" value="' . $related->virtuemart_product_id . '" name="virtuemart_product_id[]" />
				<input type="hidden" value="' . $related->related_products .  '" name="related_products[]" />
				<input type="hidden" value="' . $related->type .  '" name="type[]" />
				<div class="vmicon vmicon-16-remove"></div></div>';
	
		}
	}
}
?>
<table width="100%">
	<tr>
		<td>
			<table class="adminform">
				<tr class="row0">
					<td>
						<fieldset style="background-color:#F9F9F9;">
						<legend><?php echo JText::_('COM_VIRTUEMART_ADDON_PRODUCTS'); ?></legend>
						<?php echo JText::_('COM_VIRTUEMART_PRODUCT_ADDON_SEARCH'); ?>
						<div class="jsonSuggestResults" style="width: auto;">
							<input type="text" size="40" name="search" id="addonproductsSearch" value="" />
							<button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
						</div>
						<div id="custom_products1"><?php echo  $html1; ?></div>
						</fieldset>					
					</td>
				</tr>
				<!-- low stock notification -->
				<tr class="row1">
					<td>
						<fieldset style="background-color:#F9F9F9;">
						<legend><?php echo JText::_('COM_VIRTUEMART_SPECIAL_DEALS_PRODUCTS'); ?></legend>
						<?php echo JText::_('COM_VIRTUEMART_PRODUCT_SPECIAL_DEAL'); ?>
						<div class="jsonSuggestResults" style="width: auto;">
							<input type="text" size="40" name="search" id="specialproductsSearch" value="" />
							<button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
						</div>
						<div id="custom_products2"><?php echo  $html2; ?></div>
						</fieldset>	
					</td>
				</tr>
				<!-- end low stock notification -->
				<tr class="row0">
					<td>
						<fieldset style="background-color:#F9F9F9;">
						<legend><?php echo JText::_('COM_VIRTUEMART_BETTER_EXPERIENCE_PRODUCTS'); ?></legend>
						<?php echo JText::_('COM_VIRTUEMART_PRODUCT_BETTER_EXPERIENCE'); ?>
						<div class="jsonSuggestResults" style="width: auto;">
							<input type="text" size="40" name="search" id="betterproductsSearch" value="" />
							<button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
						</div>
						<div id="custom_products3"><?php echo  $html3; ?></div>
						</fieldset>	
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript">
	jQuery('input#addonproductsSearch').autocomplete({
		source: 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=1&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>',
		select: function(event, ui){
			jQuery("#custom_products1").append(ui.item.label);
			jQuery(this).autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=1&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>' )
			jQuery('input#addonproductsSearch').autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=1&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>' )
		},
		
		minLength:1,
		html: true
	});

	jQuery('input#specialproductsSearch').autocomplete({
		source: 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=2&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>',
		select: function(event, ui){
			jQuery("#custom_products2").append(ui.item.label);
			jQuery(this).autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=2&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>')
			jQuery('input#specialproductsSearch').autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=2&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>' )
		},
		minLength:1,
		html: true
	});

	jQuery('input#betterproductsSearch').autocomplete({
		source: 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=3&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>',
		select: function(event, ui){
			jQuery("#custom_products3").append(ui.item.label);
			jQuery(this).autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=3&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>' )
			jQuery('input#betterproductsSearch').autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=addonproducts&relationtype=3&virtuemart_product_id=<?php echo $this->product->virtuemart_product_id;?>' )
		},
		minLength:1,
		html: true
	});
</script>
