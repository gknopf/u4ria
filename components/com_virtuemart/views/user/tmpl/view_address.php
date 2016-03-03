<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */
defined('_JEXEC') or die;
$session = & JFactory::getSession();
$session->set('check', 0);
?>
<h2 style="color: #B60D9D;margin: 5px 5px 15px 5px;font-size: 20px;">Shipping Address</h2>
<div style="width: 100%;">
    <a href="index.php?option=com_users&view=regrequire">
        <img src="components/com_virtuemart/assets/images/sign_in_inactive.jpg"/>
    </a>
    <img src="components/com_virtuemart/assets/images/shipping_address_active.jpg"/>    
    <?php if (!empty($this->cart->virtuemart_shipmentmethod_id) && $this->cart->virtuemart_shipmentmethod_id > 0) { ?>
        <a href="index.php?option=com_virtuemart&view=cart&task=edit_shipment">
            <img src="components/com_virtuemart/assets/images/shipping_method_inactive.jpg"/>
        </a>
    <?php } else { ?>
        <img src="components/com_virtuemart/assets/images/shipping_method_inactive.jpg"/>
    <?php } ?>        
    <?php if (!empty($this->cart->virtuemart_paymentmethod_id) && $this->cart->virtuemart_paymentmethod_id > 0) { ?>
        <a href="index.php?option=com_virtuemart&view=cart&task=editpayment">
            <img src="components/com_virtuemart/assets/images/payment_method_inactive.jpg"/>
        </a>
        <a href="index.php?option=com_virtuemart&view=cart">
            <img src="components/com_virtuemart/assets/images/confirmation.jpg"/>
        </a>
    <?php } else { ?>
        <img src="components/com_virtuemart/assets/images/payment_method_inactive.jpg"/>
        <img src="components/com_virtuemart/assets/images/confirmation.jpg"/>
    <?php } ?>    
</div>

<h2 style="background: #f0f0f0; color: #B00C97; margin-bottom: 20px; margin-top: 20px; padding-left: 20px;">SHIPPING ADDRESS</h2>

<table class="adminForm user-details" style="padding-left: 20px;">

    <tbody>
        <tr>
            <td title="" class="key">
                <label >First Name:</label>
            </td>
            <td>
                <label ><?php echo $this->shipToAddress->first_name; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Last Name:</label>
            </td>
            <td>
                <label ><?php echo $this->shipToAddress->last_name; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Gender:</label>
            </td>
            <td>
                <label ><?php
                    if ($this->shipToAddress->gender == 1)
                        echo 'Male';
                    elseif ($this->shipToAddress->gender == 2)
                        echo 'Female';
                    else
                        echo '';
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Date of Birth:</label>
            </td>
            <td>
                <label ><?php
                    if (!empty($this->shipToAddress->date_of_birth) && ($this->shipToAddress->date_of_birth != '0000-00-00')) {
                        $date = date_create($this->shipToAddress->date_of_birth);
                        echo date_format($date, 'Y-M-d');
                    }
                    ?>
                </label>
            </td>
        </tr>
        
        <tr>
            <td title="" class="key">
                <label >Email:</label>
            </td>
            <td>
                <label ><?php echo $this->shipToAddress->email; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Phone:</label>
            </td>
            <td>
                <label ><?php echo $this->shipToAddress->phone_1; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Address Line 01: </label>
            </td>
            <td>
                <label ><?php echo $this->shipToAddress->address_1; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Address Line 02 :</label>
            </td>
            <td>
                <label ><?php echo $this->shipToAddress->address_2; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Zip/PostCode:</label>
            </td>
            <td>
                <label ><?php echo $this->shipToAddress->zip; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >City:</label>
            </td>
            <td>
                <label ><?php echo $this->shipToAddress->city; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Country:</label>
            </td>
            <td>
                <label ><?php echo $this->countryST['country_name']; ?></label>
            </td>
        </tr>

    </tbody>
</table>
<div style="width: 70px;border: 1px solid #B00C97;text-align: center; margin-left: 20px;">
    <a style="color: #B00C97;" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=user&task=editaddresscheckout&addrtype=ST'); ?>">
        EDIT >>
    </a>
</div>
<br>

<h2 style="background: #f0f0f0; color: #B00C97; margin-bottom: 20px; padding-left: 20px;">BILLING ADDRESS</h2>

<table class="adminForm user-details" style="padding-left: 20px;">

    <tbody>
        <tr>
            <td title="" class="key">
                <label >First Name:</label>
            </td>
            <td>
                <label ><?php echo $this->billToAddress->first_name; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Last Name:</label>
            </td>
            <td>
                <label ><?php echo $this->billToAddress->last_name; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Gender:</label>
            </td>
            <td>
                <label ><?php
                    if ($this->billToAddress->gender == 1)
                        echo 'Male';
                    elseif ($this->billToAddress->gender == 2)
                        echo 'Female';
                    else
                        echo '';
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Date of Birth:</label>
            </td>
            <td>
                <label ><?php
                    if (!empty($this->billToAddress->date_of_birth) && ($this->billToAddress->date_of_birth != '0000-00-00')) {
                        $date = date_create($this->billToAddress->date_of_birth);
                        echo date_format($date, 'Y-M-d');
                    }
                    ?>
                </label>
            </td>
        </tr>
        
        <tr>
            <td title="" class="key">
                <label >Email:</label>
            </td>
            <td>
                <label ><?php echo $this->billToAddress->email; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Phone:</label>
            </td>
            <td>
                <label ><?php echo $this->billToAddress->phone_1; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Address Line 01: </label>
            </td>
            <td>
                <label ><?php echo $this->billToAddress->address_1; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Address Line 02 :</label>
            </td>
            <td>
                <label ><?php echo $this->billToAddress->address_2; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Zip/PostCode:</label>
            </td>
            <td>
                <label ><?php echo $this->billToAddress->zip; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >City:</label>
            </td>
            <td>
                <label ><?php echo $this->billToAddress->city; ?></label>
            </td>
        </tr>
        <tr>
            <td title="" class="key">
                <label >Country:</label>
            </td>
            <td>
                <label ><?php echo $this->country['country_name']; ?></label>
            </td>
        </tr>

    </tbody>
</table>
<div style="display:none;width: 70px;border: 1px solid #B00C97;text-align: center; margin-left: 20px;">
    <a style="color: #B00C97;" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=user&task=editaddresscheckout&addrtype=BT'); ?>">
        EDIT >>
    </a>
</div>
<br>
<div style="float: right">
    <div style="width: 100px;height: 20px;padding-top: 5px;
         float: left;background: #B00C97;
         text-align: center; margin-left: 20px;">

        <a style="color: white;" href="<?php echo JRoute::_('index.php?option=com_virtuemart&amp;view=cart&amp;task=edit_shipment'); ?>">
            CONFIRM >>
        </a>
    </div>
    <div style="width: 70px;border: 1px solid #B00C97;background: #B00C97;
         height: 20px;padding-top: 5px;
         float: left;text-align: center; margin-left: 20px;">
        <a style="color: white;" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart&step=1'); ?>">
            << BACK
        </a>

    </div>
</div>