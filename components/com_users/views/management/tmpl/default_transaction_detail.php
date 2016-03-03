<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2 style="background: #f0f0f0; color: #B00C97; margin-bottom: 20px; padding-left: 20px;">Detail</h2>

<table
	class="cart-summary"
	cellspacing="0"
	cellpadding="0"
	border="0"
	width="100%">
    <tr style="background:#ECE8E8; color: #B00C97">	
	<th align="center">Product</th>
	<th align="center" width="100px">Price</th>
        <th align="center" width="100px">Quality</th>
	<th class="cw4"	align="center" width="100px">Total</th>
</tr>

<?php 
foreach ($this->orderDetail['items'] as $value){ ?>
    <tr>
	<th><span class="">
               <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->virtuemart_product_id), $value->thumb); ?>
            </span><br><br>
            <?php echo $value->order_item_name ?>
        </th>
	<th><?php echo $this->currencyDisplay->priceDisplay($value->product_item_price) ?></th>
	<th><?php echo $value->product_quantity;  ?></th>
        <th><?php echo $this->currencyDisplay->priceDisplay($value->product_quantity * $value->product_item_price ) ?></th>
</tr>
<?php
}
?>
</table>
<div class="ctkh_detail" style="margin-top: 10px; padding-top: 10px;">
    <div style="text-align: right;font-size: 16px; padding-left: 350px;">
        <span style="width: 150px; float: left; text-align: right; color: #b00c97">Reward Point use:</span>
        <div id="shipmentprice" style="display: block; text-align: right;"><?php echo $this->orderDetail['details']['BT']->rp_added; ?>
        </div>     
    </div>
    <div style="text-align: right;font-size: 16px; padding-left: 350px;">
        <span style="width: 150px; float: left; text-align: right; color: #b00c97">Coupons:</span>
        <div id="shipmentprice" style="display: block; text-align: right;"><?php echo $this->currencyDisplay->priceDisplay($this->orderDetail['details']['BT']->coupon_discount) ?>
        </div>     
    </div>
    <div style="text-align: right;font-size: 16px; padding-left: 350px;">
        <span style="width: 150px; float: left; text-align: right; color: #b00c97">Shipping:</span>
        <div id="shipmentprice" style="display: block; text-align: right;"><?php echo $this->currencyDisplay->priceDisplay($this->orderDetail['details']['BT']->order_shipment) ?>
        </div>     
    </div>
    <div style="padding-top: 5px; margin-top: 10px; background: #f0f0f0; height: 25px;font-size: 16px;font-weight: bold; padding-left: 350px;">
        <span style="width: 150px; float: left;color: #c01d2e; text-align: right">Grand Total:</span>
        <div id="PricebillTotal" style="display: block; text-align: right;"><?php echo $this->currencyDisplay->priceDisplay($this->orderDetail['details']['BT']->order_total) ?>
        </div>     
    </div>
</div>
<div style="margin-top: 10px; padding-top: 10px;">
    -Delivery method: 
    <?php 
        foreach ($this->orderDetail['shipments'] as $value){
            echo $value->shipment_name;
        } ?>
    <br>
    -Payment method:
    
        <?php 
        foreach ($this->orderDetail['payments'] as $value){
            echo $value->payment_name;
        }?>
</div>