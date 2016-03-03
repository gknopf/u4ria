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
<h2 style="color: #B60D9D;margin: 5px 5px 15px 5px;font-size: 20px;">Secure Checkout</h2>
<div style="height: 29px;width: 100%; margin-bottom: 40px;">    
    <img src="components/com_virtuemart/assets/images/sign_in_active.jpg"/>
    <?php if(!empty($this->cart->ST)){?>
        <a href="index.php?option=com_virtuemart&amp;view=user&amp;task=editaddresscheckout&amp;tab=viewaddress">
            <img src="components/com_virtuemart/assets/images/shipping_address_inactive.jpg"/>
        </a>
    <?php } else {?>
        <img src="components/com_virtuemart/assets/images/shipping_address_inactive.jpg"/>
    <?php }?>
    <?php if(!empty($this->cart->virtuemart_shipmentmethod_id) && $this->cart->virtuemart_shipmentmethod_id > 0){?>
        <a href="index.php?option=com_virtuemart&view=cart&task=edit_shipment">
            <img src="components/com_virtuemart/assets/images/shipping_method_inactive.jpg"/>
        </a>
    <?php } else {?>
        <img src="components/com_virtuemart/assets/images/shipping_method_inactive.jpg"/>
    <?php }?>        
    <?php if(!empty($this->cart->virtuemart_paymentmethod_id) && $this->cart->virtuemart_paymentmethod_id > 0){?>
        <a href="index.php?option=com_virtuemart&view=cart&task=editpayment">
            <img src="components/com_virtuemart/assets/images/payment_method_inactive.jpg"/>
        </a>
        <a href="index.php?option=com_virtuemart&view=cart">
            <img src="components/com_virtuemart/assets/images/confirmation.jpg"/>
        </a>
    <?php }else { ?>
        <img src="components/com_virtuemart/assets/images/payment_method_inactive.jpg"/>
        <img src="components/com_virtuemart/assets/images/confirmation.jpg"/>
    <?php } ?>    
</div>
<fieldset>
<h2 style="color : #666; padding-left: 10px ;font-size: 16px;  line-height: 32px; background: #f0f0f0;">Congratulation! Your U4Ria member </h2><br>
<label style="color: #B00C97; font-weight: bold">Congratulation! Your U4Ria</label> member account has been created!<br><br><br>
You can now take advantage of member privileges to enhance your online shopping experience with us. 
If you have ANY questions about the operation of this online shop, please email us at: <u><a href="" style="color: #B00C97;">u4riashop@gmai.com</a></u><br><br><br>
A confirmation has been sent to your registered email address. 
If you have not received it within the hour, please email us: <u><a href="" style="color: #B00C97;">u4riashop@gmai.com</a></u><br><br><br>
As part of our Welcome to new member, you will receive a warm welcome bonus of 
10% extra Reward Point base on your purchase amount, when you sign up and make a first purchase.<br><br><br>
Please refer to our <u><a href="" >U4Ria Online Member Privilege</a></u> as condition may apply.<br><br>
</fieldset>
<div style="width: 100px;height: 20px;padding-top: 5px; margin-top: 20px;
     float: left;background: #B00C97; text-align: center; margin-left: 20px;">
<a href="index.php?option=com_virtuemart&view=user&task=editaddresscheckout&addrtype=XT" style="color: white;"> CONTINUE >> </a>
</div>
