<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

?>
<h2 style="background: #f0f0f0; color: #B00C97; margin-bottom: 20px; padding-left: 20px;">TRANSACTIONS HISTORY</h2>

<table
	class="cart-summary"
	cellspacing="0"
	cellpadding="0"
	border="0"
	width="100%">
    <tr style="background:#ECE8E8; color: #B00C97">	
	<th align="cender" width="100px">Order No.</th>
	<th align="center" width="100px">Order Date</th>
        <th class="cw1" align="center">Total</th>
	<th class="cw4"	align="center" width="200px">Status</th>
	<th class="cw6" align="center" width="100px">Details</th>
</tr>
<?php 

foreach ($this->orderListTransaction as $value){ ?>
    <tr>
	<th><?php echo $value->order_number ?></th>
	<th><?php echo $value->created_on ?></th>
	<th><?php echo $this->currencyDisplay->priceDisplay($value->order_total) ?></th>
	<th><?php echo $this->orderStatusList[$value->order_status];  ?></th>
        <th style="font-style:italic;" id="view_detail_transaction">
            <a style="color: #B00C97; " href="<?php echo JRoute::_('index.php?option=com_users&view=management&tab=transaction_detail&order_id='); echo $value->virtuemart_order_id; ?>">View Detail</a>
        </th>
</tr>
<?php
}
?>
</table>
