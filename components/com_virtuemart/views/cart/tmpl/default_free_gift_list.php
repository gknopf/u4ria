<?php
defined('_JEXEC') or die('Restricted access');
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
//vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('product_alert');
vmJsApi::css('jplist');
vmJsApi::js('jplist.min');
?>
<?php if ($this->freegiftArray['freegiftAmount'] > 0): ?>
<div id="freegif" class="box" style="border-top: 1px solid #CCC;">
<table class="list_free_gift" width="100%" style="padding-top: 10px;">
    <tr>
        <td colspan="5" class='free_gift_tip' style="text-align: center;">
            <p style="font-size: 20px;">Your Free Gift Indicator</p>
            <p>The higher your Indicator, the better the Free Gift!</p>
        </td>
    </tr>
    <tr>
        <td colspan="3" class="free_gift_head">
            <p style="text-align: right; padding-right: 125px;">Hit Jacket Gift!</p>
            <p class="line_point">
            <span class="point_percent" style="width: <?php echo $this->free_gift_price_percent; ?>px">&nbsp
            <img <?php if ($this->free_gift_price_percent == 0): ?> style="margin-top: 0px" <?php endif;?> alt="Free gift" title="Free gift: <?php echo $this->currencyDisplay->priceDisplay($this->freegift_spend, 0, 1,false,false,''); ?>" src="templates/altalab/images/point_icon.png" width="8px" height="8px">
            </span>
            </p>
            <p class="line_point_text">You're made it that far!</p>
            <p class="vm-button-correct" style="background: #A70A8B">Please select 1 free gift below in the pink box</p>
        </td>
    </tr>
</table>
<ul class="list_free_gift list">
    <?php foreach ($this->freegiftArray as $key => $value): 
        if($value->virtuemart_product_id > 0) :?>
    <li class="list-item">
        <div class="box_line">
            <div class="list_free_gift_head">
                <?php echo $value->product_name?><br/>
            </div>
            <div class="list_free_gift_img">
            <span class="">
               <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->virtuemart_product_id), $value->thumb); ?>
            </span>
            </div>
            <div class="list_free_gift_info">
                <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->virtuemart_product_id), $value->product_sku); ?>
                 <?php if (strlen($value->product_s_desc) < 38): echo $value->product_s_desc; else: echo substr($value->product_s_desc, 0, 38) . ' ...'; endif; ?>
                <p class="freegift">Free Gift</p>
                <p class="vm-button-correct add_free_gift" rel="<?php echo $value->virtuemart_product_id; ?>" onclick="add_free_gift('<?php echo $value->virtuemart_product_id; ?>')">Add Free Gift</p>
            </div>
            <div class="clr"></div>
        </div>
    </li>
    <?php endif;
    endforeach; ?>
</ul>
    <div class="freegift_page">
    <?php if ($this->freegiftArray): ?>
        <?php if(count($this->freegiftArray)>11): ?>
        <div class="panel box panel-top">
                <div class="buttons"></div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    </div>
<?php endif; ?>
</div>
<script type="text/javascript">
    var page = jQuery.noConflict();
        page("document").ready(function(){
                var jplist = page("#freegif").jplist({
                        //main options
                        items_box: ".list", //items container
                        item_path: ".list-item", //path to the item
                        css_prefix: "jplist",
                        cookies: false,
                        redraw_callback: "",
                        //paging
                        pagingbox: ".buttons",
              //        pageinfo: ".info",
                        items_on_page: 9,
                        paging_length: 7,  //pager length
                        show_one_page: false,
                        //drop down
                        sort_dd_path: ".sort-drop-down",
                        paging_dd_path: ".page-by"
                });
        });
</script>
