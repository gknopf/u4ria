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
<style type="text/css">
    tr {
            height: 30px;
    }
</style>
<h2 style="background: #f0f0f0; color: #B00C97; margin-bottom: 20px; padding-left: 20px;">MEMBERSHIP STATUS</h2>
<div style="line-height: 35px">
    Since <?php echo $this->orderList->start_date_member?>, you have ordered from U4ria a total amount of 
    <label style="color: #AA0E0E; font-size: 16px; font-weight: bold"><?php echo$this->currencyDisplay->priceDisplay($this->orderList->sum_order_total) ?></label><br/>
    Currently, you are our <label style="color: red;"><?php echo $this->orderList->user_level ?></label> member, for benefits of a 
    <label style="color: red;"><?php echo $this->orderList->user_level ?></label> member, please click <a href="index.php?option=com_content&amp;view=article&amp;id=21&amp;catid=16" style="color: #B00C97;">HERE</a> for more details<br/>
    <?php if($this->orderList->user_level != 'Standard'){ ?>
    Your <label style="color: red;"><?php echo $this->orderList->user_level ?></label>
    membership will be expired on <?php echo $this->orderList->end_date_member?>. Kindly click <a href="index.php?option=com_content&amp;view=article&amp;id=22&amp;catid=16" style="color: #B00C97;">HERE</a> for information on how to maintain membership<br/>
    <?php }?>
    <?php if($this->orderList->user_level != 'Platinum'){ ?>
    To become a <label style="color: #B00C97;"><?php echo $this->orderList->next_user_level?></label> member for more benefits, kindly click <a href="index.php?option=com_content&amp;view=article&amp;id=21&amp;catid=16" style="color: #B00C97;">HERE</a> for more information<br/>
    <?php }?>    
    How to maintain membership status using Reward Point, kindly click <a href="index.php?option=com_content&amp;view=article&amp;id=22&amp;catid=16" style="color: #B00C97;">HERE</a>
    
</div>