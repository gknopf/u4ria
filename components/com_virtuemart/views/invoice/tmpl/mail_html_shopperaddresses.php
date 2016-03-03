<?php
/**
 *
 * Layout for the order email
 * shows the chosen adresses of the shopper
 * taken from the stored order
 *
 * @package	VirtueMart
 * @subpackage Order
 * @author Max Milbers,   Valerie Isaksen
 *
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
defined('_JEXEC') or die('Restricted access');
?>
<hr/>
<table class="html-email" cellspacing="0" cellpadding="0" border="0" width="100%">  <tr  >
	<td width="50%" >
	    <p style="text-align: left;font-size: 11pt;font-weight: bold"><?php echo JText::_('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?>:</p>

        <?php
        foreach ($this->userfields['fields'] as $field) {
            if (!empty($field['value'])) {
                ?><span class="titles"><?php echo $field['title'] ?>: </span >
                <span class="values vm2<?php echo '-' . $field['name'] ?>" ><?php echo $this->escape($field['value']) ?></span>
                <br class="clear" />
            <?php
            }
        }
        ?>
	</td>
	<td width="50%">
        <p style="text-align: left;font-size: 11pt;font-weight: bold">Your Payment Method is</p>

            <span style="display:none;"><?php  echo $this->orderDetails['paymentName'] ?></span>
        <span class="payment_name" onload="jQuery(document).ready(function ($) {$(this).text($('img.CToWUd').attr('alt'));});"></span>


	</td>
    </tr>
    <tr>
	<td valign="top" width="50%">
        <p style="text-align: left;font-size: 11pt;font-weight: bold"> <?php echo JText::_('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?>:</p>

        <?php
        foreach ($this->shipmentfields['fields'] as $field) {

            if (!empty($field['value'])) {
                ?><span class="titles"><?php echo $field['title'] ?>: </span >
                <span class="values vm2<?php echo '-' . $field['name'] ?>" ><?php echo $this->escape($field['value']) ?></span>
                <br class="clear" />
            <?php

            }
        }

        ?>
	</td>
	<td valign="top" width="50%">
        <p style="text-align: left;font-size: 11pt;font-weight: bold">Your Shipping Method is</p>

        <?php echo $this->orderDetails['shipmentName'] ?>
	</td>
    </tr>
    <tr>
        <td>
            <p style="text-align: left;font-size: 11pt;font-weight: bold">Your Comment: </p>
        </td>
    </tr>
</table>
<hr/>
