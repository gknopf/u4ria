<?php
/**
*
* Handle the waitinglist
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
* @version $Id: product_edit_waitinglist.php 2978 2011-04-06 14:21:19Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
if (isset($this->product->customfields_fromParent)) { ?>
	<label><?php echo JText::_('COM_VIRTUEMART_CUSTOM_SAVE_FROM_CHILD');?><input type="checkbox" name="save_customfields" value="1" /></label>
<?php } else {
	?> <input type="hidden" name="save_customfields" value="1" />
<?php }  ?>
<table id="customfieldsTable" width="100%">
	<tr>
		<td valign="top" width="%100">
			<fieldset style="background-color:#F9F9F9;">
				<legend><?php echo JText::_('COM_VIRTUEMART_SUGGESTION_PRODUCTS'); ?></legend>
				<?php echo JText::_('COM_VIRTUEMART_PRODUCT_SUGGESTION_SEARCH'); ?>
				<div class="jsonSuggestResults" style="width: auto;">
					<input type="text" size="40" name="search" id="suggestionProductsSearch" value="" />
					<button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
				</div>
				<div id="suggestion_products"><?php echo  $this->product->suggestion_product; ?></div>
			</fieldset>

			<fieldset style="background-color:#F9F9F9;">
				<legend><?php echo JText::_('COM_VIRTUEMART_SPECIAL_DEAL_PRODUCTS'); ?></legend>
				<?php echo JText::_('COM_VIRTUEMART_PRODUCT_SPECIAL_DEAL_SEARCH'); ?>
				<div class="jsonSuggestResults" style="width: auto;">
					<input type="text" size="40" name="search" id="specialDealProductsSearch" value="" />
					<button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
				</div>
				<div id="special_deal_products"><?php echo  $this->product->special_deal_product; ?></div>
			</fieldset>

			<fieldset style="background-color:#F9F9F9;">
				<legend><?php echo JText::_('COM_VIRTUEMART_FREEGIFT_PRODUCTS'); ?></legend>
				<?php echo JText::_('COM_VIRTUEMART_PRODUCT_FREEGIFT_SEARCH'); ?>
				<div class="jsonSuggestResults" style="width: auto;">
					<input type="text" size="40" name="search" id="freegiftProductsSearch" value="" />
					<button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
				</div>
				<div id="freegift_products"><?php echo  $this->product->freegift_product; ?></div>
			</fieldset>
		</td>

	</tr>
</table>


<div style="clear:both;"></div>


<script type="text/javascript">

jQuery('input#suggestionProductsSearch').autocomplete({
		source: 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=suggestionproducts&row='+nextCustom,
		select: function(event, ui){
			jQuery("#suggestion_products").append(ui.item.label);
			nextCustom++;
			jQuery(this).autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=suggestionproducts&row='+nextCustom )
			jQuery('input#suggestionProductsSearch').autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=suggestionproducts&row='+nextCustom )
		},
		minLength:1,
		html: true
});

	jQuery('input#specialDealProductsSearch').autocomplete({
		source: 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=specialdeal&row='+nextCustom,
		select: function(event, ui){
			jQuery("#special_deal_products").append(ui.item.label);
			nextCustom++;
			jQuery(this).autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=specialdeal&row='+nextCustom )
			jQuery('input#specialDealProductsSearch').autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=specialdeal&row='+nextCustom )
		},
		minLength:1,
		html: true
});


	jQuery('input#freegiftProductsSearch').autocomplete({
		source: 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=freegift&row='+nextCustom,
		select: function(event, ui){
			jQuery("#freegift_products").append(ui.item.label);
			nextCustom++;
			jQuery(this).autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=freegift&row='+nextCustom )
			jQuery('input#freegiftProductsSearch').autocomplete( "option" , 'source' , 'index.php?option=com_virtuemart&view=product&task=getData&format=json&type=freegift&row='+nextCustom )
		},
		minLength:1,
		html: true
	});
</script>