<?php
/**
 *
 * Define here the Header for order mail success !
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Kohl Patrick
 * @author Valérie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
/* TODO Change the header place in helper or assets ??? */
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="html-email">
	<tr>
<!--		<td align="top">-->
<!--			<img src="--><?php // echo JURI::root () . $this->vendor->images[0]->file_url ?><!--" />-->
<!--		</td>-->
<!--		<td>-->
<!--			--><?php //echo $this->vendorAddress; ?>
<!--		</td>-->
        <td colspan="2" style="text-align: center;font-size: 17pt;color: fuchsia;padding: 10px">
            THANK YOU! <br>
            Your order has been processed
        </td>
	</tr>
	<tr>
		<td colspan="2" style="line-height:1.5">

                <?php echo JText::sprintf ('COM_VIRTUEMART_MAIL_SHOPPER_NAME', $this->orderDetails['details']['BT']->title . ' ' . $this->orderDetails['details']['BT']->first_name . ' ' . $this->orderDetails['details']['BT']->last_name); ?>
            thank you for shopping at <a href="<?php echo JURI::root(); ?>">u4riashop.com</a>.Once your package ships we will send an email with link to track your order. You can check the status of your order by
            <a class="default" title="<?php echo $this->vendor->vendor_store_name ?>" href="<?php echo JURI::root().'index.php?option=com_virtuemart&view=orders&layout=details&order_number='.$this->orderDetails['details']['BT']->order_number.'&order_pass='.$this->orderDetails['details']['BT']->order_pass; ?>">
                <?php echo JText::_('COM_VIRTUEMART_MAIL_SHOPPER_YOUR_ORDER_LINK'); ?></a>.
            <br/>
            Your order confirmation is below. Thank you again for your business.<br>
		</td>
	</tr>
</table>
