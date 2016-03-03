<?php defined ('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License orcpsku

 * other free or open source software licenses.
 *
 */

// Check to ensure this file is included in Joomla!

// jimport( 'joomla.application.component.view');
// $viewEscape = new JView();
// $viewEscape->setEscape('htmlspecialchars');
$document = JFactory::getDocument ();
$user = JFactory::getUser();
$document->addScriptDeclaration ("

    //<![CDATA[
    jQuery(document).ready(function($) {
       add_reward_point();
    });
    //]]>
");

?>
<fieldset class="shopping_cart_product_list">
<table
	class="cart-summary"
	cellspacing="0"
	cellpadding="0"
	border="0"
	width="100%">
<tr>
	<th class="cw1" align="left"><?php echo JText::_ ('COM_VIRTUEMART_CART_PHOTO') ?></th>
	<th class="cw2" align="left"><?php echo JText::_ ('COM_VIRTUEMART_CART_PRODUCT') ?></th>
	<th class="cw3"
		align="center"
		width="60px"><?php echo JText::_ ('COM_VIRTUEMART_CART_PRICE') ?></th>
	<th class="cw4"
		align="right"
		width="140px"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?></th>

	<th class="cw5" align="right" width="70px"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></th>
        <?php if($this->checkout_task !== 'confirm'){ ?>
	<th class="cw6" align="right" width="60px"><?php echo JText::_ ('COM_VIRTUEMART_CART_ACTION') ?></th>
        <?php } ?>
</tr>
</table>
<table class="cart-summary product_list">
    <tr>
        <td class="product_list_td">
<?php
$i = 1;
// 		vmdebug('$this->cart->products',$this->cart->products);
if(empty($this->cart->products)){
    echo 'CART EMPTY';
}else{
foreach ($this->cart->products as $pkey => $prow) {
	?>

    <table class="cart-summary cat_product_item  cat_product_item_<?php echo $i ?>">
<tr valign="top" class="product_tr sectiontableentry<?php echo $i ?>">
    <td class="cw1" align="left">

		<?php if ($prow->virtuemart_media_id) { ?>
            <a href="<?php echo $prow->url ?>">
                <span class="cart-images">
						 <?php
			if (!empty($prow->image)) {
				echo $prow->image->displayMediaThumb ('', FALSE);
			}
			?>
                </span></a>
		<?php } ?>


	</td>
	<td class="cw2" align="left">
            <div class="cpn"><?php echo JHTML::link ($prow->url, $prow->product_name) . $prow->customfields; ?></div>
            <div class="cpsku" ><?php  echo JText::_('Model:').$prow->product_sku ?></div>
        </td>
	<td class="cw3" align="center">
		<?php
		// 					vmdebug('$this->cart->pricesUnformatted[$pkey]',$this->cart->pricesUnformatted[$pkey]['priceBeforeTax']);
		if ($this->cart->pricesUnformatted[$pkey]['salesPrice'] > 0) {
		  echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted[$pkey], FALSE);
		} else {
		  echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted[$pkey]['salesPrice'], 0, 1,false,false,'salesPrice');
		}
		// 					echo $prow->salesPrice ;
		?>
	</td>
	<td class="cw4" align="right"><?php
//				$step=$prow->min_order_level;
				if ($prow->step_order_level)
					$step=$prow->step_order_level;
				else
					$step=1;
				if($step==0)
					$step=1;
				$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
				?>
                <script type="text/javascript">
				function check<?php echo $step?>(obj) {
 				// use the modulus operator '%' to see if there is a remainder
				remainder=obj.value % <?php echo $step?>;
				quantity=obj.value;
 				if (remainder  != 0) {
 					alert('<?php echo $alert?>!');
 					obj.value = quantity-remainder;
 					return false;
 				}
 				return true;
 				}
				</script>
		<form action="<?php echo JRoute::_ ('index.php'); ?>" method="post" class="inline">
			<input type="hidden" name="option" value="com_virtuemart"/>
				<!--<input type="text" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="inputbox" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" /> -->
      <?php if ($prow->freegift_flag == 0 && $this->checkout_task !== 'confirm'):?>
        <input type="text" onblur="check<?php echo $step?>(this);" onclick="check<?php echo $step?>(this);" onchange="check<?php echo $step?>(this);" onsubmit="check(<?php echo $step?>this);" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" />
      <?php else: ?>
        <span class="cart_freegift_quantity"><?php echo $prow->quantity ?></span>
      <?php endif; ?>
			<input type="hidden" name="view" value="cart"/>
			<input type="hidden" name="task" value="update"/>
			<input type="hidden" name="cart_virtuemart_product_id" value="<?php echo $prow->cart_item_id  ?>"/>
			<?php if ($prow->freegift_flag == 0 && $this->checkout_task !== 'confirm'):?>
			  <input type="submit" class="vmicon vm2-add_quantity_cart" name="update" title="<?php echo  JText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>" align="middle" value=" "/>
			<?php endif; ?>
		</form>
	</td>

	<td class="cw5" colspan="1" align="right">
		<?php
//		if (VmConfig::get ('checkout_show_origprice', 1) && !empty($this->cart->pricesUnformatted[$pkey]['salesPrice']) && $this->cart->pricesUnformatted[$pkey]['salesPrice'] != $this->cart->pricesUnformatted[$pkey]['salesPrice']) {
	//		echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted[$pkey], TRUE, FALSE, $prow->quantity) . '</span><br />';
	//	}
  	if ($this->cart->pricesUnformatted[$pkey]['salesPrice'] > 0) {
  		echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity);
  	} else {
  		echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted[$pkey]['salesPrice'], 0, 1,false,false,'salesPrice');
  	}
	?>
        </td>
        <?php if($this->checkout_task !== 'confirm'){ ?>
	<td class="cw6" align="right">
            <a class="vmicon remover_item vm2-remove_from_cart" title="<?php echo JText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" align="middle" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id=' . $prow->cart_item_id) ?>">Delete the item</a>
        </td>
        <?php } ?>
</tr>
</table>
	<?php
	$i = ($i==1) ? 2 : 1;
}
}
?>
            </td>
    </tr>
</table>
    <?php if($this->checkout_task !== 'confirm'){ ?>
    <table class="cart-summary" width="100%" style="border-bottom: 1px solid #CCC;border-collapse: collapse">
        <tr>            
            <td style="text-align: right;padding: 20px;font-size: 16px;">
                Sub Total : <label style="color: red">
                    <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPrice']) ?>
                </label>
            </td>
        </tr>
    </table>
    <?php } ?>
    <?php if($this->checkout_task !== 'confirm' && !$user->guest){ ?>
    <table class="cart-summary" width="100%" style="border-collapse: collapse; border: 1px solid #CCC;margin-top: 10px;">
    <tr>            
        <td colspan="2" style="border-bottom: 1px solid #CCC;padding: 10px; color: #A70A8B; font-weight: bold;">
            Shopping Points Redemptions
        </td>
    </tr>
    <tr>            
        <td colspan="2" style="border-bottom: 1px solid #CCC;padding: 10px;width: 70%;">
            With this Order Purchase, You earn <span style="color: #A70A8B"><?php echo $this->reward_point['reward_point']; ?> loyalty point(s)</span>
        </td>
    </tr>
    <tr>  
        <td style="border-bottom: 1px solid #CCC;padding: 10px;width: 70%;">
            Your accumulated gift points: <span style="color: #A70A8B" id="your_balance_rp"><?php echo $this->reward_point['total_point'];?></span>
        </td>
        <td style="border-left: 1px solid #CCC; border-bottom: 1px solid #CCC;padding: 10px; text-align: right">            
            Value at : <?php echo $this->currencyDisplay->priceDisplay($this->reward_point['total_point_money']) ?>
        </td>
    </tr>
    <tr>            
        <td style="border-bottom: 1px solid #CCC;padding: 10px;width: 70%;">
            Enter the amount of Points you wish to redeem: <br/>
            <span style="color: #A70A8B">
                <input type="text" id="add_reward_point"
                       style="width: 100px"
                       value="<?php if (isset($_SESSION['rp_added'])):?><?php echo $_SESSION['rp_added'];?> <?php endif; ?>" size="1" name="add_reward_point"></span>
        <input type="button" class="regbutton" value="Enter" onclick="add_reward_point();AppendTotal();" style="cursor:pointer;"/>
        </td>
        <td style="border-left: 1px solid #CCC; border-bottom: 1px solid #CCC;padding: 10px; text-align: right">            
            Value at : <label id="convertpoints"><?php echo $this->currencyDisplay->priceDisplay(0) ?></label>
        </td>
    </tr>
    </table>
    <table class="cart-summary" width="100%" style="border-collapse: collapse; border: 1px solid #CCC;margin-top: 10px;margin-bottom: 10px;">
        <tr>            
            <td colspan="2" style="border-bottom: 1px solid #CCC;padding: 10px; color: #A70A8B; font-weight: bold;">
                Gift Vouchers or Discount Coupons
            </td>
        </tr>        
        <tr>            
            <td style="border-bottom: 1px solid #CCC;padding: 10px;width: 70%;">
                <?php echo $this->loadTemplate ('coupon'); ?>
            </td>
            <td style="border-left: 1px solid #CCC; border-bottom: 1px solid #CCC;padding: 10px; text-align: right">
                <?php if (!empty($this->cart->cartData['couponCode'])) { ?>
	<?php
        echo $this->cart->cartData['couponCode'].'<br>'; }?>
                Value at : <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPriceCoupon']); ?>
            </td>
        </tr>
    </table>
    <?php } ?>
    <?php if($this->checkout_task === 'confirm'){ ?>
    <table style="width: 100%">
        <tr>        
            <td>

                <div style="text-align: right;font-size: 16px; ">
                     <span style="width: 70%; float: left;">Reward Points Used:</span>                
                        <div id="reward_point_used" style="display: block; text-align: right ; color: #A70A8B">
                            <?php echo ($this->cart->rewardPoints != null ? $this->cart->rewardPoints : 0)?>
                        </div>
                </div>
                <div style="text-align: right;font-size: 16px; ">
                     <span style="width: 70%; float: left;">Coupons:</span>                
                        <div id="convert_to_price2" style="display: block; text-align: right ; color: #A70A8B">
                            <?php echo ($this->cart->pricesUnformatted['salesPriceCoupon'] != null ? $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPriceCoupon']) : 0)?>
                        </div>
                </div>
                <div style="text-align: right;font-size: 16px; ">
                    <span style="width: 70%; float: left;"><?php echo JText::_ ('COM_VIRTUEMART_CART_TITLE_SHIPMENT') ?>:</span>
                    <div id="shipmentprice" style="display: block; text-align: right; color: #A70A8B"><?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPriceShipment']) ?>
                    </div>     
                </div>
                <div style="text-align: right;font-size: 16px;  border-top: 1px solid; margin-top: 5px; padding-top: 10px;">
                    <span style="width: 70%; float: left;color: red;">Grand Total</span>
                    <div id="PricebillTotal" style="display: block; text-align: right; color: #A70A8B"><?php echo $this->cart->pricesUnformatted['billTotal'] ?>
                    </div>     
                </div>
            </td>

        </tr>
    </table>
    <?php }  ?>       
    <div id="freegift_mess_box" title="Add Free Gift "></div>
</fieldset>
<div id="divTotal" style="display:none;">
<table id="tbTotal"  style="width: 100%;">
    <tr>
        <td style="border-bottom: 1px solid #CCC;padding: 10px;width: 70%;">
            <h3> Total Price Products:</h3>
        </td>
        <td style="border-left: 1px solid #CCC; border-bottom: 1px solid #CCC;padding: 10px; text-align: right">
            <label style="color: red">
                <h3><?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPrice']) ?> </h3>
            </label>
        </td>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid #CCC;padding: 10px;width: 70%;">
            <h3>Final Total Payment</h3>
        </td>
        <td style="border-left: 1px solid #CCC; border-bottom: 1px solid #CCC;padding: 10px; text-align: right">
            <h3><label id="PricebillTotal" style="color: red"><?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['billTotal']) ?></label> </h3>
        </td>
    </tr>
</table>
</div>
<script>
    jQuery(document).ready(function ($) {
        divToTal = $('div#divTotal').html();
        $('div#freegif').append(divToTal);
    });
        function AppendTotal() {

            jQuery(document).ready(function ($) {
               var timeout = setInterval(function(){
                    $('div#freegif').find('table#tbTotal').remove();
                    divToTal = $('div#divTotal').html();
                    $('div#freegif').append(divToTal);
                }, 1000);

            });
        }
</script>