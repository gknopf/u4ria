<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_weblinks
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document = JFactory::getDocument ();

$vmSiteurl  = " var vmSiteurl = '". JURI::root( ) . "';\n";
$document->addScriptDeclaration ($vmSiteurl);
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('product_alert');
?>
<div style="text-align: center;cursor: pointer;">
    <a href="javascript:void(0);"  onclick="show_wishlist();"><img src="images/wishlist.png" alt='My wishlist' /></a>
</div>
<div id='wishlist'></div>
<div class="wl_popup">
  <div class="wish_list_wapper unactive" id="wish_list_wapper">
    <div class="close"><a href="javascript:void(0);"  onclick="rm_wishlist_popup();">Close <span class="close_icon">&nbsp;</span></div>
    <div class="adapter_wl">&nbsp</div>
    <div class="wish_list_title">
      <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=wishlist&task=managerwishlist'), 'Manage Wishlist'); ?>
    </div>
    <div class="wish_list_list" id="wish_list_list"></div>
    <div class="add_all">
      <span class="add_cart_icon"><a onclick="add_all_to_cart('wishlist_all')" href="javascript:void(0);" title="Add all to Cart"><img border="0" width="20px" src="images/cart-icon.gif" title="Add all to Cart" alt="Add all to Cart" class="add_compare_icon"> Add all to Cart</a></span>
      <span><a onclick="wishlist_add_all_compare()" href="javascript:void(0);" id="add_all_compare" title="Add all to Comparison"><img border="0" width="30px" src="images/comparison.jpg" title="Add all to Comparison" alt="Add all to Comparison" class="add_compare_icon"> Add all to Comparison</a></span>
      <span><a  href="javascript:void(0);"  onclick="delete_wishlist_all();" title="Remove all Wishlist">Remove all</a></span>
    </div>
  </div>
</div>
<div id="wishlist_mess_box" title=""></div>
<div id="cart_mess_box" title=""></div>