<?php
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
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
 * @version $Id: cart.php 2551 2010-09-30 18:52:40Z milbo $
 */
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('product_alert');

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
vmJsApi::js('facebox');
vmJsApi::css('facebox');
JHtml::_('behavior.formvalidation');
$document = JFactory::getDocument();

$document->addScriptDeclaration("

//<![CDATA[
	jQuery(document).ready(function($) {
		$('div#full-tos').hide();
		$('a#terms-of-service').click(function(event) {
			event.preventDefault();
			$.facebox( { div: '#full-tos' }, 'my-groovy-style');
		});
	});

//]]>
");
$document->addScriptDeclaration("

//<![CDATA[
	jQuery(document).ready(function($) {
	if ( $('#STsameAsBTjs').is(':checked') ) {
				$('#output-shipto-display').hide();
			} else {
				$('#output-shipto-display').show();
			}
		$('#STsameAsBTjs').click(function(event) {
			if($(this).is(':checked')){
				$('#STsameAsBT').val('1') ;
				$('#output-shipto-display').hide();
			} else {
				$('#STsameAsBT').val('0') ;
				$('#output-shipto-display').show();
			}
		});
	});

//]]>

");
$document->addStyleDeclaration('#facebox .content {display: block !important; height: 480px !important; overflow: auto; width: 560px !important; }');

//vmdebug('car7t pricesUnformatted',$this->cart->pricesUnformatted);
//vmdebug('cart cart',$this->cart->pricesUnformatted );
?>

<div class="cart-view">
    <div>
        <div class="width50 floatleft">
            <h1>
                <?php
                if ($this->checkout_task !== 'confirm') {
                    echo JText::_('COM_VIRTUEMART_CART_TITLE');
                } else {
                    echo JText::_('COM_VIRTUEMART_USER_FORM_CART_STEP5');
                }
                ?>
            </h1>
        </div>
        <div class="clear"></div>
        <?php if ($this->checkout_task === 'confirm') {?>

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
                <a href="index.php?option=com_virtuemart&view=cart&task=editpayment">
                    <img src="components/com_virtuemart/assets/images/payment_method_inactive.jpg"/>
                </a>
                <img src="components/com_virtuemart/assets/images/confirmation_active.jpg"/>
            </div>
        <?php }?>


    </div>



    <?php
    // echo shopFunctionsF::getLoginForm ($this->cart, FALSE);
    // This displays the pricelist MUST be done with tables, because it is also used for the emails
    echo $this->loadTemplate('pricelist');
    if ($this->checkout_task !== 'confirm') {

        echo $this->loadTemplate('free_gift_list');
    }
    if ($this->checkout_task) {
        $taskRoute = '&task=' . $this->checkout_task;
    } else {
        $taskRoute = '';
    }


    // added in 2.0.8
    if ($this->checkout_task === 'confirm') {
        echo $this->loadTemplate('review_info_shipment');
    }
    ?>
    <div id="checkout-advertise-box">
        <?php
        if (!empty($this->checkoutAdvertise)) {
            foreach ($this->checkoutAdvertise as $checkoutAdvertise) {
                ?>
                <div class="checkout-advertise">
                    <?php echo $checkoutAdvertise; ?>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <form method="post" id="checkoutForm" name="checkoutForm" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart' . $taskRoute, $this->useXHTML, $this->useSSL); ?>">

        <?php // Leave A Comment Field ?>
        <div class="customer-comment marginbottom15">
            <span class="comment"><?php echo JText::_('COM_VIRTUEMART_COMMENT_CART'); ?></span><br/>
<!--            <textarea class="customer-comment" name="customer_comment" cols="60" rows="1">--><?php //echo $this->cart->customer_comment; ?><!--</textarea>-->
        </div>
        <?php if ($this->checkout_task !== 'confirm') { ?>
            <div class="checkout-button-top">
                <div class="width100 check_continue checkout_footer">
                    <a class="vm-button-correct" href="javascript:void(0);" onclick="update_cart();"
                       style="background: #c01878">
                        <span>Update Cart</span>
                    </a>
                    <?php
                    if ($this->continue_link_html != '') {

                        echo $this->continue_link_html;
                    }
                    echo $this->checkout_link_html;
                    ?>
                </div>
            </div>
        <?php } else { ?>

            <table  style="width:100%;">
                <tr>
                    <td style="padding: 10px;">
                        <label style="font-weight: bold">
                            To add comments, requests, special messages ("Happy birthday","Happy Anniversary"), kindly fill in bellow
                        </label>
                        <br><br>
                        <textarea class="customer-comment" name="customer_comment" style="width: 95%;height: 70px;"></textarea>
                        <br><br>
                        <label style="color : red">
                            *Kindly make changes of date/time/venue 6 hours before each delivery. A extra amount of $15 will be incurred should
                            buyers make changes after that
                        </label>
                        <br><br>
                    </td>
                </tr>
            </table>

            <div>
                <button type="submit" class="regbutton">CONFIRM >></button>
            </div>
        <?php } ?>

        <?php if ($this->checkout_task !== 'confirm') { ?>
            <div class="pay_accept" style="border: 1px solid #CCC; margin-top: 10px">
                <img src="images/footer_cart.jpg" border="0" alt="" width="100%">
            </div>
        <?php } ?>
        <input type='hidden' id='STsameAsBT' name='STsameAsBT' value='<?php echo $this->cart->STsameAsBT; ?>'/>
        <input type='hidden' name='task' value='<?php echo $this->checkout_task; ?>'/>
        <input type='hidden' name='option' value='com_virtuemart'/>
        <input type='hidden' name='view' value='cart'/>
        <input type='hidden' name='rp_added_on_confirm' value=''  id='rp_added_on_confirm'/>
    </form>
</div>
