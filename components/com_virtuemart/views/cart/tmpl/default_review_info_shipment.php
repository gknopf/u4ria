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
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */

// Check to ensure this file is included in Joomla!

// jimport( 'joomla.application.component.view');
// $viewEscape = new JView();
// $viewEscape->setEscape('htmlspecialchars');

?>
<div class="billto-shipto">
    <div id="width50_floatleft2">
        <div id="SB_Address" style="background-color: #A53A94;height: 25px;padding-left: 10px; padding-top: 5px;">
		<span style="color: white;"><?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?></span>
                <span style="color: white; padding-left: 30%">BILLING ADDRESS</span>
                
            </div>
        </div>
        <div class="output-shipto">
            <?php
            if (empty($this->cart->STaddress['fields'])) {
                    echo JText::sprintf ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_EXPLAIN', JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'));
            } else {
                    if (!class_exists ('VmHtml')) {
                            require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');
                    }
//				echo JText::_ ('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
//				echo VmHtml::checkbox ('STsameAsBTjs', $this->cart->STsameAsBT) . '<br />';
                    ?>
            <?php if (!isset($this->cart->lists['current_id'])) {
		$this->cart->lists['current_id'] = 0;
	} ?>    
                    <div id="output-shipto-display" style="padding-left: 20px; width: 40%; float: left">
                        <span class="titles">Full name: </span>
                            <?php
               foreach ($this->cart->STaddress['fields'] as $item) {
                                          if (!empty($item['value'])) {
                                            if ($item['name'] == 'first_name' || $item['name'] == 'middle_name'|| $item['name'] == 'last_name') {
                                                    ?>
                                                    <span class="values<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
                                                    <?php 
                                            }
                                    }
                            }
                            foreach ($this->cart->STaddress['fields'] as $item) {
                                    if (!empty($item['value'])) {
                                            ?>
                                            <!-- <span class="titles"><?php echo $item['title'] ?></span> -->
                                            <?php
                                            if($item['name'] == 'gender'){
                                                if($item['value'] == 1)
                                                    { ?> 
													<br class="clear"/>
                                                        <span class="titles"><?php echo $item['title'] ?>: </span>
													<span class="values">Male</span>
                                                    <br class="clear"/>
													<?php } else
                                                        { ?>
														<br class="clear"/>
                                                            <span class="titles"><?php echo $item['title'] ?>: </span>
														<span class="values">Female</span>
                                                    <br class="clear"/>
														<?php }
                                            }else{
                                                if ($item['name'] == 'first_name' || $item['name'] == 'middle_name' || $item['name'] == 'last_name') {
                                                    ?>
                                                    
                                                    <?php } else { ?>
                                                    <span class="titles"><?php echo $item['title'] ?>: </span>
                                                    <span class="values"><?php echo $this->escape ($item['value']) ?></span>
                                                    <br class="clear"/>
                                                    <?php
                                                }
                                            }
                                    }
                            }
                            ?>
                                                    <div class="clear"></div>
                            
                    </div>
                    <div id="output-shipto-display" style="padding-left: 20px; width: 50%; float: left">
                        <span class="titles">Full name: </span>
                            <?php
                            foreach ($this->cart->BTaddress['fields'] as $item) {
                                    if (!empty($item['value'])) {
                                            if ($item['name'] == 'first_name' || $item['name'] == 'middle_name'|| $item['name'] == 'last_name') {
                                                    ?>

                                                    <span class="values<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
                                                    <?php 
                                            }
                                    }
                            }
                      foreach ($this->cart->BTaddress['fields'] as $item) {
                                    if (!empty($item['value'])) {
                                            ?>
                                            <!-- <span class="titles"><?php echo $item['title'] ?></span> -->
                                            <?php
                                            if($item['name'] == 'gender'){
                                                if($item['value'] == 1)
                                                    { ?> 
													<br class="clear"/>
                                                        <span class="titles"><?php echo $item['title'] ?>: </span>
													<span class="values">Male</span>
                                                    <br class="clear"/>
													<?php } else
                                                        { ?>
														<br class="clear"/>
                                                            <span class="titles"><?php echo $item['title'] ?>: </span>
														<span class="values">Female</span>
                                                    <br class="clear"/>
														<?php }
                                            }else{
                                            if ($item['name'] == 'first_name' || $item['name'] == 'middle_name' || $item['name'] == 'last_name') {
                                                    ?>
                                                    
                                                    <?php } else { ?>
                                                    <span class="titles"><?php echo $item['title'] ?>: </span>
                                                    <span class="values"><?php echo $this->escape ($item['value']) ?></span>
                                                    <br class="clear"/>
                                                    <?php
                                            }
                                            }
                                    }
                            }							
                            ?>
                            <div class="clear"></div>
                            
                    </div>
            
                    <?php
            }
            ?>
            <div class="clear"></div>
        </div>
            <div style="width: 70px;border: 1px solid #B00C97;text-align: center; margin-left: 20px; margin-top: 20px;">
                                <a style="color: #B00C97;" 
                                   href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=XT&virtuemart_user_id[]=' . $this->cart->lists['current_id'], $this->useXHTML, $this->useSSL) ?>">
			EDIT >>
		</a>
            </div>
	</div>
        <div style="background-color: #A53A94;height: 25px;padding-left: 10px; margin-top: 20px; padding-top: 5px;">
		<span style="color: white;">SHIPPING METHOD</span>
        </div>
        <div style="padding-left: 20px; background: #f0f0f0; margin-bottom: 10px; margin-top: 10px;">
            <?php echo($this->cart->cartData['shipmentName'])?>
        </div>
        <?php if($this->cart->shipment_hour !== null){?>
            <div style="padding-left: 20px;">
                <?php echo($this->cart->shipment_hour)?>
            </div>
            <div style="width: 70px;border: 1px solid #B00C97;text-align: center; margin-left: 20px; margin-top: 10px;">
		<a style="color: #B00C97;" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment'); ?>">
			EDIT >>
		</a>
            </div>
        <?php }?>
        <div style="background-color: #A53A94;height: 25px;padding-left: 10px; margin-top: 20px; padding-top: 5px;">
		<span style="color: white;">PAYMENT METHOD</span>
        </div>
        <div style="margin-bottom: 10px;margin-left: 20px;margin-top: 10px;width: 200px;height: 110px;border: 1px solid #92278F;">
            <?php echo($this->cart->cartData['paymentName'])?>
        </div>
        <div style="width: 70px;border: 1px solid #B00C97;text-align: center; margin-left: 20px; margin-top: 10px;">
            <a style="color: #B00C97;" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment'); ?>">
                    EDIT >>
            </a>
        </div>
	<div class="clear" style="border: 1px solid; margin-top: 20px; border-color: #B00C97"></div>
</div>