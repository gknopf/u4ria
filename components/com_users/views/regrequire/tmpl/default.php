<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//For login form
$app =& JFactory::getApplication();
$menu =& $app->getMenu();
$params = $menu->getParams($menuItemId);
$params->get('paramName');
$session =& JFactory::getSession();
$session->set('regrequire', 2);
?>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<h2 style="color: #B60D9D;margin: 5px 5px 15px 5px;font-size: 20px;">Sign In</h2>
<div style="width: 100%;">
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
    <h2 style="color : #666; padding-left: 10px ;font-size: 16px;  line-height: 32px; background: #f0f0f0;">
        Welcome, Please Sign In</h2><br/>

    Ordering with U4Ria is simple and fast <br/><br/><br/>
    Note: Your "Guest Cart" contents will be merged with your "Member Cart" contents ounce you have decided
    to Sign in as Member. Pls click here for [<a href="index.php?option=com_content&amp;view=article&amp;id=21&amp;catid=16" style="color: #B00C97;">More Details </a> ]
    <br/><br/><br/>
</fieldset>
<fieldset style="margin-top: 20px;">
    <h2 style="color : #666; padding-left: 10px ;font-size: 16px;  line-height: 32px; background: #f0f0f0;">
        Sign in as a Guest or Register as a member</h2><br/>

    Register with us for future order convenience and enjoy more benefits and discounts: <br/><br/><br/>
    <h4 style="color: #B60D9D;">   - 10% extra "Reward Points" for first purchase</h4><br/>
    <h4 style="color: #B60D9D;">   - Member can view their current order status, history and update account information</h4><br/>
    Pls click here for [<a href="index.php?option=com_content&amp;view=article&amp;id=21&amp;catid=16" style="color: #B00C97;">More Details </a> ] <br/><br/>
    <script type="text/javascript">
        function init1() {
            document.getElementById('guest').style.display='inline';
            document.getElementById('register').style.display='none';
            document.getElementById('membercheckout').style.display='none';
        }
        function init2() {
            document.getElementById('guest').style.display='none';
            document.getElementById('register').style.display='none';
            document.getElementById('membercheckout').style.display='inline';
        }
        function init3() {
			jQuery('#dynamic_recaptcha_2').html(jQuery('#dynamic_recaptcha_1').clone(true,true));

            document.getElementById('guest').style.display='none';
            document.getElementById('register').style.display='inline';
            document.getElementById('membercheckout').style.display='none';

        }

    </script>
    <input type="radio" id="radio1" name="group1" value="Guest" onchange="init1()"> Check out as Guest without creating account<br><br>
    <input type="radio" id="radio2" name="group1" value="Member" onchange="init2()"> Check out as Member<br><br>
    <input type="radio" id="radio3" name="group1" value="Regestration" onchange="init3()" > Register as Member<br><br>


</fieldset>
<div id ="guest" style="display: none">
        <br/>
    <h2 style="color: #B60D9D; margin: 10px">Check out as Guest</h2>
    <br/>

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

        var elem = jQuery('#jform_age_check');
        elem.attr('class', "required");

        var elem = jQuery('#userForm');

        return myValidator(f, '<?php echo $rtask ?>');

    }
</script>

<fieldset>

            <form method="post" id="userForm" name="userForm" action="<?php echo JRoute::_('index.php?option=com_users&task=reqrequire.saveCheckoutUser'); ?>" class="form-validate">
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
        $user = JFactory::getUser();
        if (($user->get('guest') == 1)) {
            ?>

            <div>

                <input type="checkbox" checked="false"  name="jform[age_check]" id="jform_age_check" value="" onclick="check()" class="required" aria-required="true" required="required">
<?php //php code
JPluginHelper::importPlugin('captcha');
$dispatcher = JDispatcher::getInstance();
$dispatcher->trigger('onInit','dynamic_recaptcha_1');

//html code inside form tag ?>

                <label id="jform_age_check-lbl" for="jform_age_check" class=" required">I am 18 years of age or older (depending on the  jurisdiction of your home country or state)<span class="star">&nbsp;*</span></label>                                                                                </dt>
				<br/>
				<br/>
                                        <label style="color: #B60D9D; font-weight: bold">Security check : </label>
                                        <label>Your privacy is important to us, we DO NOT rent, sell or reveal your personal infomation to 3rd parties. To learn more, read our privacy <a style="color: #B00C97;" href="index.php?option=com_content&view=article&id=17&Itemid=142">policy page</a>.</label>
                                        </dt> <br/>
										<br/>
				<div id="dynamic_recaptcha_1"></div>
            </div>
            <script>
                document.getElementById('jform_age_check').checked = false;
                function check()
                {
                    if (document.getElementById('jform_age_check').value == 1) {
                        document.getElementById('jform_age_check').value = "";
                        document.getElementById('jform_age_check').checked = false;
                    } else {
                        document.getElementById('jform_age_check').value = 1;
                        document.getElementById('jform_age_check').checked = true;
                    }

                }

            </script>
        <?php } ?>


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
            >
        SUBMIT >></button>

<?php } ?>

            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="regrequire.saveCheckoutUser" />

<?php
if (!empty($this->virtuemart_userinfo_id)) {
    echo '<input type="hidden" name="shipto_virtuemart_userinfo_id" value="' . (int) $this->virtuemart_userinfo_id . '" />';
}
echo JHTML::_('form.token');
?>
</form>
</fieldset>
</div>
<div id ="membercheckout" class="moduletable loginmod" style="display: none;">
    <br/>
    <h2 style="color: #B60D9D; margin: 10px">Members Login</h2>
    <br/>
       <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" name="form-login" id="login-form" >
	<?php if ($params->get('pretext')): ?>
	<div class="pretext">
	<p><?php echo $params->get('pretext'); ?></p>
	</div>
	<?php endif; ?>
           <fieldset class="userdata" style="border: 1px groove threedface;">
	<p id="form-login-username">
            <label for="modlgn-username" style=" font-size: 12px;"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
		<input id="modlgn-username" type="text" name="username" class="inputbox" style=" font-size: 12px;" size="30"/>
	</p>
	<p id="form-login-password">
		<label for="modlgn-passwd" style=" font-size: 12px;"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
		<input id="modlgn-passwd" type="password" name="password" class="inputbox" style=" font-size: 12px;" size="30"/>
	</p>
	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
	<p id="form-login-remember">
		<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
		<label style=" font-size: 12px;" for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
	</p>
	<?php endif; ?>
	<div class="readon"><input type="submit" name="Submit" class="login" value="<?php //echo JText::_('JLOGIN') ?>" />
	<input type="button" onclick="location.href='<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>'" name="signup" class="signup" value="<?php //echo JText::_('JLOGIN') ?>" />
	</div>
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHtml::_('form.token'); ?>
	</fieldset>
	<?php if ($params->get('posttext')): ?>
	<div class="posttext">
		<p><?php echo $params->get('posttext'); ?></p>
	</div>
	<?php endif; ?>
</form>
    </div>

<div id ="register" style="display: none;">
    <br/>
    <h2 style="color: #B60D9D; margin: 10px">Register as U4ria Member</h2>
    <br/>
    <div id="regform" class="registration<?php echo $this->pageclass_sfx?>">

            <h3>Your Personal Detail</h3>

    <?php if ($this->params->get('show_page_heading')) : ?>
            <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php endif; ?>

            <form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=reqrequire.register'); ?>" method="post" class="form-validate">
    <?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
            <?php $fields = $this->form->getFieldset($fieldset->name);?>
            <?php if (count($fields) && $fieldset->name != 'checks'):?>
                    <fieldset class="<?php echo $fieldset->name; ?>">
                    <?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
                    ?>
                            <legend><?php echo JText::_($fieldset->label);?></legend>
                    <?php endif;?>
                            <dl>
                        <?php foreach ($fields as $field):// Iterate through the fields in the set and display them. ?>
                            <?php if ($field->hidden):// If the field is hidden, just display the input.?>
                                <?php echo $field->input; ?>
                            <?php
                            else:
                                if ($field->name != 'jform[day]' &&
                                        $field->name != 'jform[month]' && $field->name != 'jform[year]') {
                                    ?>
                                    <div class="field <?php echo $field->name; ?>">
                                        <dt>
                                        <?php echo $field->label; ?>
                                        <?php if (!$field->required && $field->type != 'Spacer'): ?>

                                        <?php endif; ?>
                                        </dt>
                                        <dd><?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd>
                                    </div>
                                <?php }else {
                                    if ($field->name == 'jform[year]') {
                                        ?>
                                        <div class="field <?php echo $field->name; ?>">
                                            <dt>
                                            <?php echo $field->label; ?>
                                            <?php if (!$field->required && $field->type != 'Spacer'): ?>

                        <?php endif; ?>
                                            </dt>
                                            <dd><select name ="jform[year]" class="sizeinputselectbirthday"
                                                        id="yearField"
                                                        onchange="resetMonthAndDayByYear();">
                                                    <option value="0">Year</option>
                                                <?php
                                            $y =  date("Y");
                                            $x = $y - 18;
                                                    for(; $x >= 1901; $x -- ){
                                                        echo '<option value="'.$x.'">'.$x.'</option>';
                                                    }
                                            ?>
                                                </select>

                                        <?php }
                                        else if ($field->name == 'jform[month]') {
                                            ?>
                                            <?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?>
                                            <?php } else {
                                                ?>
                                            <?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd></div>
                                    <?php
                                    }
                                }
                            endif;
                            ?>
                <?php endforeach; ?>
                    </dl>
                    </fieldset>
            <?php elseif($fieldset->name == 'checks'):?>
                    <fieldset class="<?php echo $fieldset->name; ?>">
                    <?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
                    ?>
                            <legend><?php echo JText::_($fieldset->label);?></legend>
                    <?php endif;?>
                            <dl>
                        <?php foreach ($fields as $field):// Iterate through the fields in the set and display them.?>
                            <?php if ($field->hidden):// If the field is hidden, just display the input. ?>
                                <?php echo $field->input; ?>
                            <?php else:
                                if ($field->name == 'jform[age_check]') {
                                    ?>
                                    <div class="field <?php echo $field->name; ?>">
                                        <dd><?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd>
                                        <dt>
                                        <?php echo $field->label; ?>
                                        <?php if (!$field->required && $field->type != 'Spacer'): ?>

                                    <?php endif; ?>
                                        </dt>
                                    </div>
                <?php } else if ($field->name == 'jform[notes]') { ?>
                                    <div class="field <?php echo $field->name; ?>">
                                        <dd><?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd>
                                        <dt>
                                        <label style="color: #B60D9D; font-weight: bold">Security check : </label>

                                        <label>Your privacy is important to us, we DO NOT rent, sell or reveal your personal infomation to 3rd parties. To learn more, read our privacy <a style="color: #B00C97;" href="index.php?option=com_content&view=article&id=17&Itemid=142">policy page</a>.</label>
										<br/>
										<br/>
										<div id="dynamic_recaptcha_2"></div>
                                        </dt>
                                    </div>
                <?php }else { ?>
                                    <div class="field <?php echo $field->name; ?>">
                                        <dd style="margin: 0px;"><?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd>
                                    </div>
                                <?php } ?>
            <?php endif; ?>
                <?php endforeach; ?>
                    </dl>
                    </fieldset>
            <?php endif;?>
    <?php endforeach;?>

                    <div>
                            <button type="submit" class="regbutton">SUBMIT >></button>
                            <?php echo JText::_('COM_USERS_OR');?>
                            <a href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
                            <input type="hidden" name="option" value="com_users" />
                            <input type="hidden" name="task" value="regrequire.register" />
                            <?php echo JHtml::_('form.token');?>
                    </div>
            </form>
    </div>
</div>
    <script type="text/javascript">

        var query_string = {};
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        var pair = vars[vars.length-1].split("=");
        if (pair[0] == "reg") {
            document.getElementById('radio3').checked = true;
            document.getElementById('register').style.visibility='visible';
        }

        if (document.getElementById('radio1').checked) {
            init1();
        }
        if (document.getElementById('radio2').checked) {
            init2();
        }
        if (document.getElementById('radio3').checked) {
           // init3();
        }
     </script>
