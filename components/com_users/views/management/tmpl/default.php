<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6530 2012-10-12 09:40:36Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// addon for joomla modal Box
JHTML::_('behavior.modal');

//vmJsApi::css('jquery.ui.theme','components/com_virtuemart/assets/css/ui');

// JHTML::_('behavior.tooltip');

//$this->data = JFactory::getUser();
?>

   <script type="text/javascript" language="javascript">
    /*
   jQuery(document).ready(function() {
      jQuery("#addwl").click(function(event){
          jQuery('#wishlist').load('http://localhost:81/u4rianew/trunk/4_Implementation/u4ria/index.php?option=com_virtuemart&view=wishlist&task=addwishlist&&tmpl=component');
      });
   });
   */
 jQuery(document).ready(function(){

   jQuery(".your_account_tab").click(function(){
	   var tab_id = jQuery(this).attr("rel");
	   var disabled_tab = jQuery(this).hasClass("disabled_tab");

	   if (disabled_tab) {
		   return false;
	   }
	   jQuery('li.your_account_tab').removeClass('active');
	   jQuery(this).addClass('active');

	   jQuery('.content_tab').removeClass('active');
	   jQuery('.content_tab').addClass('unactive');
	   jQuery('#' + tab_id).removeClass('unactive');
	   jQuery('#' + tab_id).addClass('active');
   });
   jQuery("#view_size_chart").click(function(){
	   jQuery('li.your_account_tab').removeClass('active');
	   jQuery('li.size_chart').addClass('active');

	   jQuery('.content_tab').removeClass('active');
	   jQuery('.content_tab').addClass('unactive');
	   jQuery('#size_chart_tab').removeClass('unactive');
	   jQuery('#size_chart_tab').addClass('active');
	   jQuery('html, body').animate({scrollTop:jQuery('#size_chart_tab').position().top - 50}, 'slow');

   });

   jQuery(".nano").nanoScroller();
  });
   </script>

<style type="text/css">
    tr {
            height: 30px;
    }
</style>
	

 <div class="clr"></div>
    <div id="management_desc">
        

    <div class="desc_extra_wapper">
        <div>
      <ul class="title">
        <li class="your_account_tab <?php if(($this->tab == 'membership') || ($this->tab == '')) echo "active"; ?>" rel="membership_management_tab">Membership Management</li>
        <li class="your_account_tab <?php if($this->tab == 'rewardpoint') echo "active"; ?>" rel="reward_point_management_tabs">Reward Point Management</li>
        <li class="your_account_tab <?php if($this->tab == 'profile') echo "active"; ?>" rel="member_profile_tab">Member Profile</li>
        <li class="your_account_tab <?php if($this->tab == 'address' || $this->tab == 'edit_address') echo "active"; ?>" rel="address_management_tab">Address Management</li>
        <li class="your_account_tab size_chart <?php if($this->tab == 'transaction' || $this->tab == 'transaction_detail') echo "active"; ?>" rel="transaction_history_tab">Transaction History</li>
      </ul>
        </div>
        <div id="memberprofiletab2" style="text-align: center; width: 100%; padding-left: 100px; height: 40px;">
                <div style="text-align: center;width: 150px; padding-top: 10px; float: left;background: #8F247F;height: 30px;margin: 1px;">
                    <a style="color: white;" href="<?php echo JRoute::_ ('index.php?option=com_content&view=article&id=21&catid=16') ?>">
                        Membership Benefits >>
                    </a>                    
                </div>
                <div id="memberprofiletabwishlist" style="text-align: center;width: 150px; padding-top: 10px;float: left;background: #8F247F;color: white;height: 30px; margin: 1px;">                        
                    <a style="color: white;" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=wishlist&task=managerwishlist') ?>">
                        Your Wishlist >>
                    </a>
                </div>
                <div id="memberprofiletabalert" style="text-align: center;width: 150px; padding-top: 10px; float: left;background: #8F247F;color: white;height: 30px; margin: 1px;">
                    <a style="color: white;" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productalert') ?>">
                        Product Alert >>
                    </a>
                </div>
            </div>
      <div class="content">
          <div class="<?php if(($this->tab == 'membership') || ($this->tab == '')) echo "active"; else echo "unactive"; ?> content_tab"  id="membership_management_tab">
          <?php echo $this->loadTemplate('membership'); ?>
          <div class="clr"></div>
        </div>
        <div class="<?php if($this->tab == 'rewardpoint') echo "active"; else echo "unactive";?> content_tab" id="reward_point_management_tabs">
           <?php echo $this->loadTemplate('reward_point_management'); ?>
           <div class="clr"></div>
        </div>
        <div class="<?php if($this->tab == 'profile') echo "active"; else echo "unactive";?> content_tab" id="member_profile_tab">
          <?php echo $this->loadTemplate('core'); ?>
          <div class="clr"></div>
        </div>
        <div class="<?php if($this->tab == 'address') echo "active"; else echo "unactive";?> content_tab" id="address_management_tab">
            <?php echo $this->loadTemplate('address_management'); ?>
        </div>
          <div class="<?php if($this->tab == 'edit_address') echo "active"; else echo "unactive";?> content_tab" id="address_management_edit_tab">
          <?php echo $this->loadTemplate('edit_address'); ?>
        </div>
        <div class="<?php if($this->tab == 'transaction') echo "active"; else echo "unactive";?> content_tab" id="transaction_history_tab">
          <?php echo $this->loadTemplate('history_transactions'); ?>
        </div>
        <div class="<?php if($this->tab == 'transaction_detail') echo "active"; else echo "unactive";?> content_tab" id="transaction_history_detail_tab">
          <?php echo $this->loadTemplate('transaction_detail'); ?>
        </div>
      </div>
    </div>
        

    </div>

