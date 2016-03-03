<?php
/**
 *
 * Layout for the payment selection
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: select_payment.php 5451 2012-02-15 22:40:08Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$session = & JFactory::getSession();
$session->set('check', 2);
?>
<script language=javascript>
var preId;
function setDescription(myRadio){
    if(typeof(preId) !== 'undefined' && preId !== null){
       document.getElementById('payment_description_'+preId).style.display = 'none'; 
    }
    document.getElementById('payment_description_'+myRadio).style.display = 'inline';
    preId = myRadio;
}
</script>
<style>
    strong {color: #B60D9D;}
</style>
<style>
tr {border: 1px solid #CCC;}
td {border: 1px solid #CCC;padding: 10px;}
</style>
<form method="post" id="paymentForm" name=" choosePaymentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">
<h2 style="color: #B60D9D;margin: 5px 5px 15px 5px;font-size: 20px;">Payment Methods</h2>
<div style="width: 100%;">
    <a href="index.php?option=com_users&view=regrequire">
        <img src="components/com_virtuemart/assets/images/sign_in_inactive.jpg"/>
    </a>
    <a href="index.php?option=com_virtuemart&amp;view=user&amp;task=editaddresscheckout&amp;tab=viewaddress">
        <img src="components/com_virtuemart/assets/images/shipping_address_inactive.jpg"/>
    </a>
    <a href="index.php?option=com_virtuemart&view=cart&task=edit_shipment">
        <img src="components/com_virtuemart/assets/images/shipping_method_inactive.jpg"/>
    </a>
    <img src="components/com_virtuemart/assets/images/payment_method_active.jpg"/>
    <img src="components/com_virtuemart/assets/images/confirmation.jpg"/>
</div>
<h2 style="background-color: #f0f0f0;padding: 10px;margin-bottom: 10px;font-size: 20px;">Singapore Order Information</h2>
<div style="border: 1px solid #CCC;padding: 10px;margin-bottom: 10px;margin-left: 2px;margin-right: 2px;">
    The company name will appear as "DV8 Trading" for local and International deliveries
    <br><br>
    Your credit card or bill statement will only show "DV8 Trading" and will not have any indication of the nature
    of our business.
    <br><br>
    Please click the link 
    <a href="index.php?option=com_content&view=article&id=4&Itemid=148" style="color: #B00C97;">www.u4riashop.com/payment_info</a>
    for details on our various Payment Methods.
</div>
<div style="border: 1px solid #CCC;padding: 10px;margin-left: 2px;margin-right: 2px;">
    <label style="color: #B00C97;">Products Ordered</label> - Forgot an item? (
    <a href="<?php echo JRoute::_("index.php?option=com_virtuemart&view=cart&step=1")?>" style="color: #B00C97;">Edit your shopping cart</a>
    )
</div>
<table style="width: 100%">
    <tr>
        <td><b>Product Name</b></td>
        <td><b>Price</b></td>
    </tr>
<?php
        foreach ($this->cart->products as $pkey => $prow) {
            ?>
    <tr>
        <td style="width: 80%;">
            <?php echo $prow->quantity.' x '.$prow->product_name; ?>
        </td>
        <td>
            <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted[$pkey]['subtotal_with_tax']) ?>
        </td>
    </tr>
    <?php
        }
?>
    <tr>
        <td>
            Subtotal
        </td>
        <td>
            <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPrice']) ?>
        </td>
    </tr>
    <tr>
        <td style="color: #B00C97;">
            Shopping Points Redemptions 
            (
    <a href="<?php echo JRoute::_("index.php?option=com_virtuemart&view=cart&step=1")?>" style="color: #B00C97;">Edit</a>
    )
        </td>
        <td>
            Valued at : <?php echo $this->currencyDisplay->priceDisplay($this->cart->rewardPointsDiscount) ?>
        </td>
    </tr>
    <tr>
        <td style="color: #B00C97;">
            Gift Vouchers or Discount Coupons 
            (
    <a href="<?php echo JRoute::_("index.php?option=com_virtuemart&view=cart&step=1")?>" style="color: #B00C97;">Edit</a>
    )
        </td>
        <td>
            Valued at : <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPriceCoupon']) ?>
        </td>
    </tr>
    <tr>
        <td style="color: #B00C97;">
            Delivery Methods (
            <a style="color: #B00C97;" href="index.php?option=com_virtuemart&view=cart&task=edit_shipment">Change ?
            </a>)
        </td>
        <td>            
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $this->cart->cartData['shipmentName'] ?>
        </td>
        <td>
            <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPriceShipment']) ?>
        </td>
    </tr>
    <tr>
        <td>
            Final Charge Amount
        </td>
        <td>
            <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['billTotal']) ?>
        </td>
    </tr>
    <tr>
        <td style="color: #B00C97;">
            Delivery Address (
            <a style="color: #B00C97;" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=user&task=editaddresscheckout&addrtype=ST'); ?>">
            Change ?
            </a>
            )
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
            <table class="tb_info_cus">
                <tr><td>Full Name:</td><td>   <?php echo $this->cart->ST['first_name'].' '.$this->cart->ST['last_name'] ?><br></td></tr>
                <tr><td>  Address:</td><td> <?php echo $this->cart->ST['address_1'] ?><br></td></tr>
                <tr><td> City:</td><td> <?php echo $this->cart->ST['city'] ?><br></td></tr>
                <tr><td> Country id:</td><td><?php echo $this->cart->ST['virtuemart_country_id'] ?><br></td></tr>
                <tr><td>Zip/PostCode:</td><td><?php echo $this->cart->ST['zip'] ?></td></tr>
            </table>
            <style>
                table.tb_info_cus td{
                    padding: 0px;
                    border: none;
                }
            </style>
        </td>
        <td>
        </td>
    </tr>
</table>
<div style="color: #B00C97; padding: 10px;">
    Payment methods
</div>
<table style="width:100%;">
    <tr>
        <td colspan="2" style="text-align: center;">
            Please select the preferred payment method to use on this order
        </td>
    </tr>
    <?php
        foreach ($this->payments as $payments) {
            ?>
    <tr>
        <td style="width: 80%;">
            <?php echo $payments->payment_name?>
        </td>
        <td style="text-align: center">
            <input type="radio" name="virtuemart_paymentmethod_id" id="virtuemart_paymentmethod_id_<?php echo $payments->virtuemart_paymentmethod_id ;?>"
                   value="<?php echo $payments->virtuemart_paymentmethod_id ;?>"/>
        </td>
    </tr>
    <?php
        }
?>
</table>
<?php
     if (!$this->found_payment_method){
	 echo "<h1>".$this->payment_not_found_text."</h1>";
    }


    ?>
<div style="clear: both; padding-bottom: 20px;"></div>
<table  style="width:100%;">
        <tr>
            <td style="padding: 10px;">
                Please kindly email us at <label style="color : #B00C97;">enquiry@u4riashop.com</label> or reach/SMS Benson at +65 63377463/+65 98515156 after you
                have done the Online Banking / ATM Transfer.
            </td>
        </tr>
        
    </table>
<!--    <table  style="width:100%;">-->
<!--        <tr>-->
<!--            <td style="padding: 10px;">-->
<!--                <label style="font-weight: bold">-->
<!--                To add comments, requests, special messages ("Happy birthday","Happy Anniversary"), kindly fill in bellow-->
<!--                </label>-->
<!--                <br><br>-->
<!--                <textarea style="width: 95%;height: 70px;"></textarea>-->
<!--                <br><br>-->
<!--                <label style="color : red">-->
<!--                *Kindly make changes of date/time/venue 6 hours before each delivery. A extra amount of $15 will be incurred should-->
<!--                buyers make changes after that                -->
<!--                </label>-->
<!--                <br><br>-->
<!--            </td>-->
<!--        </tr>-->
<!--    </table>-->
    <br>
    <label style="color: red; font-size:18pt;">
        Total : <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPrice']) ?>
    </label>
    <br><br>
<button type="submit" class="regbutton">SUBMIT >></button>
			&nbsp;<?php echo ' or '?>&nbsp;&nbsp;
<button class="regbutton" type="reset" onClick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment'); ?>'" >&lt;&lt;BACK</button>
    <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="view" value="cart" />
    <input type="hidden" name="task" value="setpayment" />
    <input type="hidden" name="controller" value="cart" />    
</form>