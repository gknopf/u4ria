<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;
echo $this->loadTemplate('upgrade_membership');
?>
<h2 style="background: #f0f0f0; color: #B00C97; margin-bottom: 20px; padding-left: 20px;">REWARD POINT ACCOUNT</h2>
<div style="line-height: 35px">
    You have a total of <label style="color: #AA0E0E; font-weight: bold"><?php echo $this->reward_point['total_point']; ?></label><label style="color: red;"> Reward Point</label> based on <label style="color: #B00C97;"><?php echo count($this->orderList);?></label> transaction with <label style="color: #B00C97;">U4ria</label> <br>
    Kindly note that you could use your reward points to 
    <label style="color: #B00C97;">Upgrade your membership</label> or 
    <label style="color: #B00C97;">Buying products from us</label> <br>
    To Upgrade your membership, you will need <label style="color: #B00C97;"><?php echo $this->orderList->rp_upgrade?></label> reward points. Kindly click on the button below if you choose to upgrade <br>
        <div style="color: #B00C97; border: 1px solid #B00C97; text-align: center; width: 200px;">
            <a id="upgrademember" href="javascript:void(0);" >UPGRADE MEMBERSHIP NOW</a></div>
        <label style="color: #CCC; font-style: italic; font-size: 11px ">To upgrade your membership to</label> 
        <label style="color: #B00C97; font-style: italic; font-size: 11px"><?php echo $this->orderList->next_user_level?></label>
        <label style="color: #CCC; font-style: italic; font-size: 11px">, we will deduct </label>
        <label style="color: #B00C97; font-style: italic; font-size: 11px"><?php echo $this->orderList->rp_upgrade?></label>
        <label style="color: #CCC; font-style: italic; font-size: 11px">points from your</label> 
        <label style="color: #B00C97; font-style: italic; font-size: 11px">Reward Point Account</label> <br>
    To know more about Reward Point, kindly click

        <a href="<?php echo JURI::base().'reward-points'?>" style="color:#B00C97">HERE</a>

    <br>
    We also have First Purchase Special, kindly click
    <a href="<?php echo JURI::base().'first-purchase-special'?>" style="color:#B00C97">HERE</a>

    for more information<br>
</div>
