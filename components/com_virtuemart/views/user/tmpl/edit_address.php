<?php
/**
 *
 * Enter address data for the cart, when anonymous users checkout
 *
 * @package    VirtueMart
 * @subpackage User
 * @author Oscar van Eijk, Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit_address.php 6406 2012-09-08 09:46:55Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
// vmdebug('user edit address',$this->userFields['fields']);
// Implement Joomla's form validation
JHTML::_('behavior.formvalidation');
JHTML::stylesheet('vmpanels.css', JURI::root() . 'components/com_virtuemart/assets/css/');

if ($this->fTask === 'savecartuser') {
    $rtask = 'registercartuser';
    $url = 0;
} else {
    $rtask = 'registercheckoutuser';
    $url = JRoute::_('index.php?option=com_virtuemart&view=cart&task=checkout', $this->useXHTML, $this->useSSL);
}
?>
<h2 style="color: #B60D9D;margin: 5px 5px 15px 5px;font-size: 20px;">Shipping Address</h2>
<div style="width: 100%;">
    <a href="index.php?option=com_users&view=regrequire">
        <img src="components/com_virtuemart/assets/images/sign_in_inactive.jpg"/>
    </a>
    <img src="components/com_virtuemart/assets/images/shipping_address_active.jpg"/>    
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
<?php
echo shopFunctionsF::getLoginForm(TRUE, FALSE, $url);
?>
<script language="javascript">
    function myValidator(f, t) {
        f.task.value = t; //this is a method to set the task of the form on the fTask.
        if (document.formvalidator.isValid(f)) {
            f.submit();
            return true;
        } else {
            var msg = '<?php echo addslashes(JText::_('COM_VIRTUEMART_USER_FORM_MISSING_REQUIRED_JS')); ?>';
            alert(msg + ' ');
        }
        return false;
    }

    function callValidatorForRegister(f) {

        var elem = jQuery('#username_field');
        elem.attr('class', "required");

        var elem = jQuery('#name_field');
        elem.attr('class', "required");

        var elem = jQuery('#password_field');
        elem.attr('class', "required");

        var elem = jQuery('#password2_field');
        elem.attr('class', "required");

        var elem = jQuery('#userForm');

        return myValidator(f, '<?php echo $rtask ?>');

    }
</script>

<fieldset>
    <form method="post" id="userForm" name="userForm" class="form-validate">
            <!--<form method="post" id="userForm" name="userForm" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">-->
        <div class="control-buttons">

        </div>


        <?php
        if (!class_exists('VirtueMartCart')) {
            require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
        }

        if (count($this->userFields['functions']) > 0) {
            echo '<script language="javascript">' . "\n";
            echo join("\n", $this->userFields['functions']);
            echo '</script>' . "\n";
        }
        echo $this->loadTemplate('userfields');
        ?>
<?php
if (strpos($this->fTask, 'cart') || strpos($this->fTask, 'checkout')) {
    $rview = 'cart';
} else {
    $rview = 'user';
}
// echo 'rview = '.$rview;

if (strpos($this->fTask, 'checkout') || $this->address_type == 'ST') {
    $buttonclass = 'regbutton';
} else {
    $buttonclass = 'regbutton';
}


if (VmConfig::get('oncheckout_show_register', 1) && $this->userId == 0 && !VmConfig::get('oncheckout_only_registered', 0) && $this->address_type == 'BT' and $rview == 'cart') {
    echo JText::sprintf('COM_VIRTUEMART_ONCHECKOUT_DEFAULT_TEXT_REGISTER', JText::_('COM_VIRTUEMART_REGISTER_AND_CHECKOUT'), JText::_('COM_VIRTUEMART_CHECKOUT_AS_GUEST'));
} else {
    //echo JText::_('COM_VIRTUEMART_REGISTER_ACCOUNT');
}
if (VmConfig::get('oncheckout_show_register', 1) && $this->userId == 0 && $this->address_type == 'BT' and $rview == 'cart') {
    ?>

    <button class="<?php echo $buttonclass ?>" type="submit" onclick="javascript:return callValidatorForRegister(userForm);"
            title="<?php echo JText::_('COM_VIRTUEMART_REGISTER_AND_CHECKOUT'); ?>"><?php echo JText::_('COM_VIRTUEMART_REGISTER_AND_CHECKOUT'); ?></button>
            <?php if (!VmConfig::get('oncheckout_only_registered', 0)) { ?>
        <button class="<?php echo $buttonclass ?>" title="<?php echo JText::_('COM_VIRTUEMART_CHECKOUT_AS_GUEST'); ?>" type="submit"
                onclick="javascript:return myValidator(userForm, '<?php echo $this->fTask; ?>');"><?php echo JText::_('COM_VIRTUEMART_CHECKOUT_AS_GUEST'); ?></button>
                <?php
            }
        } else {
            ?>

    <button class="<?php echo $buttonclass ?>" type="submit"
            onclick="javascript:return myValidator(userForm, '<?php echo $this->fTask; ?>');">
        SUBMIT >></button>

<?php } ?>
<input type="hidden" name="shipto_address_type_name" value="Shipping" />
<input type="hidden" name="option" value="com_virtuemart"/>
<input type="hidden" name="view" value="user"/>
<input type="hidden" name="controller" value="user"/>
<input type="hidden" name="task" value="<?php echo $this->fTask; // I remember, we removed that, but why?       ?>"/>
<input type="hidden" name="layout" value="<?php echo $this->getLayout(); ?>"/>
<input type="hidden" name="address_type" value="<?php echo $this->address_type; ?>"/>
<?php
if (!empty($this->virtuemart_userinfo_id)) {
    echo '<input type="hidden" name="shipto_virtuemart_userinfo_id" value="' . (int) $this->virtuemart_userinfo_id . '" />';
}
echo JHTML::_('form.token');
?>
</form>
</fieldset>