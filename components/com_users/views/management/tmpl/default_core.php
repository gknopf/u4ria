<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
$userDetail = JFactory::getUser();
?>

<h2 style="background: #f0f0f0; color: #B00C97; margin-bottom: 20px; padding-left: 20px;">MEMBER PROFILE</h2>

<table class="adminForm user-details" style="padding-left: 20px; border-collapse: collapse;
       border: 1px solid #CCC; width: 100%">

    <tbody>
        <tr>
            <td colspan="2" style="background: #DDD; font-size: 16px;">
                Your Personal Detail
            </td>
            
        </tr>
        <tr>
                <td title="" class="key">
                    <label >First Name:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->name; ?></label>
                </td>
            </tr>
            <tr>
                <td title="" class="key">
                    <label >Last Name:</label>
                </td>
                <td>
                    <label ><?php echo $this->data->lastname; ?></label>
                </td>
            </tr>
        <tr>
                <td title="" class="key">
                    <label >User Name:</label>
                </td>
                <td>
                    <label ><?php echo $this->data->username; ?></label>
                </td>
            </tr>   
        <tr>
                <td title="" class="key">
                    <label >Gender:</label>
                </td>
                <td>
                    <label ><?php echo ($userDetail->gender == 1 ? 'Male' : 'Female'); ?></label>
                </td>
            </tr>
                     
            <tr>
                <td title="" class="key">
                    <label >Date of Birth: </label>
                </td>
                <td>
                    <label ><?php echo date('jS F Y',strtotime($this->data->birth_day)); ?></label>
                </td>
            </tr>
            <tr>
                <td title="" class="key">
                    <label >Email Address:</label>
                </td>
                <td>
                    <label ><?php echo $this->data->email; ?></label>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="background: #DDD; font-size: 16px;">
                    Company Detail
                </td>

            </tr>
            <tr>
                <td title="" class="key">
                    <label >Company Names:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->company; ?></label>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="background: #DDD; font-size: 16px;">
                    Address Detail
                </td>

            </tr>
            <tr>
                <td title="" class="key">
                    <label >Address Line 01:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->add_line1; ?></label>
                </td>
            </tr>
            <tr>
                <td title="" class="key">
                    <label >Address Line 02:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->add_line2; ?></label>
                </td>
            </tr>
            <tr>
                <td title="" class="key">
                    <label >Zip/Postcode:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->zip_postcode; ?></label>
                </td>
            </tr>
            <tr>
                <td title="" class="key">
                    <label >City:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->city; ?></label>
                </td>
            </tr>
            <tr>
                <td title="" class="key">
                    <label >State/Province:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->state; ?></label>
                </td>
            </tr>
            <tr>
                <td title="" class="key">
                    <label >Country:</label>
                </td>
                <td>
                    <label ><?php echo $this->countryUser['country_name']; ?></label>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="background: #DDD; font-size: 16px;">
                    Your Contact Information
                </td>

            </tr>
            <tr>
                <td title="" class="key">
                    <label >Telephone Number:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->phone; ?></label>
                </td>
            </tr>
            <tr>
                <td title="" class="key">
                    <label >Fax Number:</label>
                </td>
                <td>
                    <label ><?php echo $userDetail->fax; ?></label>
                </td>
            </tr>
    </tbody>
</table>
<div style="width: 70px;border: 1px solid #B00C97;text-align: center; margin-left: 20px;">
    <a style="color: #B00C97;" href="<?php echo JRoute::_ ('index.php?option=com_users&view=profile&layout=edit', $this->useXHTML, $this->useSSL) ?>">
            EDIT >>
    </a>
</div>
