<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage Manufacturer
* @author Kohl Patrick, Eugen Stranz
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 2701 2011-02-11 15:16:49Z impleri $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
JHtml::_ ('behavior.formvalidation');
vmJsApi::css('product_alert');
vmJsApi::css('jplist');
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::js('jplist.min');
//
?>
<div id="main_product_alert">
    <div id="alert_list" class="box">
    <div class="product_alert_head floatleft width100">
        <h3 class="product_alert_title">Manage Product Alert</h3>
        <!--<div class="product_alert_page">< Previous | Page 01 | 02 | Next > Erase All</div>-->
        <div title="Remove All Product" onclick="removeAllAlert();" id="alert_remove_all" class="alert_remove_all">Erase All</div>
        <?php if(count($this->alert)>10): ?>
        <div class="panel box panel-top">						
                <div class="buttons"></div>						
        </div> 
        <?php endif; ?>
    </div>
    
    <div class="product_alert_main_action floatleft width100">
        <div class="alert-action" onclick="alert_add_all_compare();" title="Add All Items To Comparison"><span class="alert_icon add-comparison"></span>Add All Items To Comparison</div>
        <div class="alert-action" onclick="add_all_to_cart('alert_all');" title="Add All Items to Cart"><span class="alert_icon add-cart"></span>Add All Items to Cart</div>
        <div class="alert-action" onclick="add_all_to_wishlist('alert_all');" title="Add All Items To Wishlist"><span class="alert_icon add-wishlist"></span>Add All Items To Wishlist</div>
    </div>
        
    <?php if(!empty($this->alert)) $TotalAlert = count($this->alert); else $TotalAlert = 0; ?>
    <div class="product_alert_total_items floatleft width100">Total Number Of Products In Product Alert: <?php echo $TotalAlert; ?></div>
    <div class="product_alert_item_list floatleft width100">
            <div class="list">
        <?php if(!empty($this->alert)): ?>
        <?php foreach ($this->alert as $value) { ?>
        <?php
            $value->link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->virtuemart_product_id);
        ?>
        <div class="list-item">
        <div class="alert_item product_alert_item_<?php echo $value->virtuemart_product_alert_id; ?>">
            <span title="Remove Item" onclick="removeAlert(<?php echo $value->virtuemart_product_alert_id; ?>);" id="alert_item_remove" class="alert_item_remove"></span>
            <h2 class="product_name"><a href="<?php echo $value->link ;?>" ><?php echo $value->product_name ?></a></h2>
            <div class="product_alert_item_left floatleft"><a href="<?php echo $value->link ;?>" ><img src="<?php echo $value->file_url; ?>" /></a></div>
            <div class="product_alert_item_right floatright">
                <div class="product_alert_top_button">
                     <div class="width100 view_productdetails">
                                  

                                            <div class="addtocart-bar">
                                                            <?php // Display the quantity box ?>
                                                            <!-- <label for="quantity<?php echo $value->virtuemart_product_id;?>" class="quantity_box"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
                                                            <!--<span class="quantity-box">-->
                                                                    <input style="display:none;" type="text" class="quantity-input" name="quantity[]" value="1" />
                                                            <!--</span>-->

                                                            <?php // Display the quantity box END ?>

                                                            <?php // Add the button
                                                            $button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
                                                            $button_cls = ''; //$button_cls = 'addtocart_button';
                                                            if (VmConfig::get('check_stock') == '0' && !$value->product_in_stock) {
                                                                    $button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
                                                                    $button_cls = 'Notify me';
                                                                    ?>

                                                            <span class="addtocart-button">
                                                                <div class="notify"><?php echo $button_cls ?></div>
                                                            </span>
                                                            <span class="addtocart-button cart-notify">
                                                                <span class="notify"><?php echo JText::_('COM_VIRTUEMART_OUT_OF_STOCK') ?></span>
                                                            </span>
                                                           <?php }else{
                                                            // Display the add to cart button ?>
                                                            <span class="addtocart-button">
                                                                    <input id="icon_cart_<?php echo $value->virtuemart_product_id ?>" title="Add to Cart" onclick="add_to_cart(<?php echo $value->virtuemart_product_id ?>);" type="submit" name="addtocart"  class="fix addtocart-button" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" />
                                                            </span>
                                                            <span class="addtocart-button cart-in-stock">
                                                                <span class="instock"><?php echo JText::_('COM_VIRTUEMART_IN_STOCK') ?></span>
                                                            </span>
                                                            <?php } ?>
                                                    <div class="clear"></div>
                                            </div>

                                </div>
                </div>
                <span onclick="eclick(<?php echo $value->virtuemart_product_alert_id; ?>);" class="alert_edit edit_<?php echo $value->virtuemart_product_alert_id; ?>" id="edit_product_alert_<?php echo $value->virtuemart_product_alert_id; ?>">Edit</span>
                <div id="alert_option_item_<?php echo $value->virtuemart_product_alert_id; ?>" class="product_alert_list_action_alert">
                    <?php if($value->alert_product_promotion): ?>
                    <p><span>Promotion For This Product</span></p>
                    <?php endif; ?>
                    <?php if($value->alert_product_clearance_sale): ?>
                    <p><span>Clearance Sale For This Product  </span></p>
                    <?php endif; ?>
                    <?php if($value->alert_product_price_reduction): ?>
                    <p><span>Price Reduction For This Product</span></p>
                    <?php endif; ?>
                    <?php if($value->alert_product_new_review): ?>
                    <p><span>New Review For This Product</span></p>
                    <?php endif; ?>
                </div>
                <!-- FORM EDIT-->
                    <div class="edit_form" id="dialog_select_oprtion_<?php echo $value->virtuemart_product_alert_id; ?>" title="Product Alert">

                        <p class="dialog_select_label">Notify Me Through Email When:</p>

                        <form id="EditForm<?php echo $value->virtuemart_product_alert_id; ?>">
                        <div class="dialog_left floatleft">
                            <p><input type="checkbox" name="promotion" id="promotion" value="1" class="text ui-widget-content ui-corner-all" <?php if( $value->alert_product_promotion) echo "checked" ?> /><span>Promotion For This Product</span></p>
                            <p><input type="checkbox" name="clearance" id="clearance" value="1" class="text ui-widget-content ui-corner-all" <?php if( $value->alert_product_clearance_sale) echo "checked" ?>/><span>Clearance Sale For This Product  </span></p>
                            <p><input type="checkbox" name="price_reduction" id="price_reduction" value="1" class="text ui-widget-content ui-corner-all" <?php if( $value->alert_product_price_reduction) echo "checked" ?> /><span>Price Reduction For This Product</span></p>
                            <p><input type="checkbox" name="new_review" id="new_review" value="1" class="text ui-widget-content ui-corner-all" <?php if( $value->alert_product_new_review) echo "checked" ?> /><span>New Review For This Product</span></p>
                        </div>
                        <div class="dialog_right floatright">
                            <a href="javascript:void(0);" onclick="mailedit();" name="editmail" id="editmail">Edit Email Alert</a>
                            <input type="submit" id="submit" class="alert_botton alert_botton_bold" value="Update >>" />
                        </div>  
                        <div id="message_post"></div>
                        <input name="product_id" type="hidden" value="<?php echo $value->virtuemart_product_id ?>"/>
                        <input id="email" name="email" type="hidden" value="<?php echo $value->alert_email; ?>"/>
                        <input name="uid" type="hidden" value="<?php echo JFactory::getUser()->id; ?>"/>                        
                        <input name="alert_action" type="hidden" value="update"/>
     
                        </form>
                    </div>                
                
                <!-- FORM EDIT-->
                
                
                <div class="product_alert_review">
                    <?php if(!empty($value->review)): ?>
                        <?php if(count($value->review)>5) $NumReviewShow = 5; else $NumReviewShow = count($value->review); ?>
                        <?php for($i=0; $i<$NumReviewShow; $i++): ?>
                        <div class="alert_review product_alert_review_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>">
                            <h4><?php echo $value->review[$i]->comment_title ?></h4>
                            <p class="review_info">Reviewed: <span class="hight"><?php echo JHTML::date ($value->review[$i]->created_on, JText::_ ('DATE_FORMAT_LC')); ?></span> By <?php echo $value->review[$i]->customer; ?></p>
                            <p class="product_alert_more product_alert_show_more_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>"><span>More >></span></p>
                            <p class="product_alert_more product_alert_hide_more_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>" style="display: none;"><span>Hide <<</span></p>
                            <div class="product_alert_comment_content_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>" style="display: none;"><?php echo $value->review[$i]->comment; ?></div>
                        </div>
                        <script>
                        var alert = jQuery.noConflict();
                            alert(function() {
                                alert('.product_alert_show_more_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>').click(function(){
                                    alert('.product_alert_hide_more_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>').show();
                                    alert('.product_alert_comment_content_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>').show();
                                    alert('.product_alert_show_more_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>').hide();
                                }); 
                                alert('.product_alert_hide_more_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>').click(function(){
                                    alert('.product_alert_hide_more_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>').hide();
                                    alert('.product_alert_comment_content_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>').hide();
                                    alert('.product_alert_show_more_<?php echo $value->review[$i]->virtuemart_rating_review_id  ?>').show();
                                });                                
                            });
                        </script>
                        <?php endfor; ?>
                    <?php endif; ?>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        </div>
        </div>
        <div class="">
            
        </div>
        <?php } ?>
        <?php endif; ?>
        <div class="clr"></div>
            </div>
              
    </div>
    </div>
    <div class="clr"></div>
</div>
<div id="email_edit" title="Change Email Alert">
    <form id="email_form">
        <p>Email to change:</p>
        <input id="new_email" class="new_email" name="new_email" type="text" value="<?php echo $this->alert[0]->alert_email; ?>" placeholder="New Email"/>
        <input class="alert_botton" type="submit" name="submit" value="Update" />
    </form>
</div>

<script>
    var editform = jQuery.noConflict();
    editform('.edit_form').dialog({
        autoOpen: false,
        modal: true,
        width: 460,
        height: 270,
        hide: {
          effect: "fade",
          duration: 1000
        }    
    });
    editform('#email_edit').dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        height: 150  
    });    
    function eclick(id){
        editform('#dialog_select_oprtion_'+id).dialog('open');
        editform(function(){
            editform("#EditForm"+id).submit(function(e){
                e.preventDefault();
                var url = vmSiteurl + "index.php?option=com_virtuemart&view=productalert&task=addAlert";
                editform.post(url, editform("#EditForm"+id).serialize(),function(res){
                editform('#alert_option_item_'+id).html(res.html);    
                },"json");
                editform('.edit_form').dialog('close');  
//                window.setTimeout('location.reload()', 2500);
            });
        });
    }
   
   function removeAlert(id){
     var url = vmSiteurl + "index.php?option=com_virtuemart&view=productalert&task=removeAlert";
     var parameter = {virtuemart_product_alert_id: id};
     jQuery.post(url, parameter, function (res) {
     jQuery('.product_alert_item_' + id).remove();
     });
   }
   function removeAllAlert(){
     var url = vmSiteurl + "index.php?option=com_virtuemart&view=productalert&task=removeAllAlert";
     jQuery.post(url,function () {
         window.setTimeout('location.reload()');
     });
   }   
</script>
<script type="text/javascript">
    var page = jQuery.noConflict();
        page("document").ready(function(){
                var jplist = page("#alert_list").jplist({
                        //main options
                        items_box: ".list", //items container
                        item_path: ".list-item", //path to the item
                        css_prefix: "jplist",
                        cookies: false,
                        redraw_callback: "",
                        //paging
                        pagingbox: ".buttons",
              //        pageinfo: ".info",
                        items_on_page: 10,
                        paging_length: 7,  //pager length
                        show_one_page: false,
                        //drop down
                        sort_dd_path: ".sort-drop-down",
                        paging_dd_path: ".page-by"					
                });
        });
</script>
