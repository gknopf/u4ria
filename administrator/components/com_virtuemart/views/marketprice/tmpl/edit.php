<?php
/**
 *
 * Description
 *
 * @package	VirtueMart
 * @subpackage ShopperGroup
 * @author Markus �hler
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit.php 6031 2012-05-16 13:11:13Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
AdminUIHelper::startAdminArea();
AdminUIHelper::imitateTabs('start','COM_VIRTUEMART_PRODUCT_MARKET_PRICE');
?>
<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm" id="adminForm">
<?php 

?>
<?php echo $this->langList; ?>
<div class="col50">
	<fieldset>
	<legend><?php echo JText::_('COM_VIRTUEMART_PRODUCT_MARKET_PRICE'); ?></legend>
	<table class="admintable">
	<input type="hidden" name="virtuemart_market_price_id" value="<?php echo $this->priceMatch->virtuemart_market_price_id; ?>" />
	<?php echo $this->addStandardHiddenToForm(); ?>
	<?php echo VmHTML::row('input','COM_VIRTUEMART_MARKETPRICE_PRODUCT','virtuemart_product_id',$this->priceMatch->virtuemart_product_id); ?>
	<?php echo VmHTML::row('input','COM_VIRTUEMART_MARKETPRICE_PRICE','mk_price',$this->priceMatch->mk_price); ?>
	<?php echo VmHTML::row('input','COM_VIRTUEMART_MARKETPRICE_LINK','mk_link',$this->priceMatch->mk_link ); ?>
	<?php echo VmHTML::row('textarea','COM_VIRTUEMART_MARKETPRICE_COMMENT','mk_comment',$this->priceMatch->mk_comment); ?>
	<?php echo VmHTML::row('input','COM_VIRTUEMART_MARKETPRICE_POST_BY','created_by',$this->priceMatch->created_by ); ?>
		
	</table>
	</fieldset>
</div>
</form>
<?php
AdminUIHelper::imitateTabs('end');
AdminUIHelper::endAdminArea();
?>