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
    <a style="color: #B00C97;" href="<?php echo JRoute::_('index.php?option=com_users&view=management&tab=edit_address&address_type=ST'); ?>">
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
                    if (!empty($this->billToAddress->date_of_birth) && ($this->v->date_of_birth != '0000-00-00')) {
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
<div style="width: 70px;border: 1px solid #B00C97;text-align: center; margin-left: 20px;">
    <a style="color: #B00C97;" href="<?php echo JRoute::_('index.php?option=com_users&view=management&tab=edit_address&address_type=BT'); ?>">
        EDIT >>
    </a>
</div>