<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_relatedproducts.php 6431 2012-09-12 12:31:31Z alatak $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<?php if ($this->product->specialDealProducts): ?>
  <?php foreach ($this->product->specialDealProducts as $product): ?>
  <div class="product_promotion">
   <div class="pp_image">
     <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->product_special_deal_id), $product->thumb); ?>
     <span class="p_price"><s><?php echo $this->currency->createPriceDiv('salesPrice', '', $product->product_price, true); ?></s></span>
   </div>
   <div class="pp_title">
     <span class="p_title">
        <?php if (strlen($product->product_name) < 38): echo $product->product_name; else: echo substr($product->product_name, 0, 38) . ' ...'; endif; ?>
     </span>
     <span class="tell_more">
        <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->product_special_deal_id), 'Tell me more'); ?>
     </span>
     <span class="p_price"><?php echo $this->currency->createPriceDiv('salesPrice', '', $product->special_price, true); ?></span>
   </div>
   <div class="clr"></div>
  </div>
  <?php endforeach; ?>
<?php endif; ?>