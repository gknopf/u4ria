<?php defined ( '_JEXEC' ) or die ( 'Restricted access' );
$document = JFactory::getDocument ();

$vmSiteurl  = " var vmSiteurl = '". JURI::root( ) . "';\n";
$document->addScriptDeclaration ($vmSiteurl);
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('product_alert');
vmJsApi::css('jplist');
vmJsApi::js('jplist.min');


?>
<div id="alert_list" class="box">
<div class="wishlist_page_wapper">
  <div class="top">
    <?php if ($this->wishlist_list): ?>
        <?php if(count($this->wishlist_list)>10): ?>
        <div class="panel box panel-top">
                <div class="buttons"></div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="total">
      <span class="main_title">Modify Wishlist</span>
    </div>
    <span class="send_friend" title="Email To Friend"  onclick="email_to_friend('wishlist')" >Email To Friend</span>
  </div><!-- End .top -->
  <?php if ($this->wishlist_list): ?>
      <?php $count = count($this->wishlist_list);?>
  <div class="wishlist_content_wapper">
    <div class="wishlist_left">
      <div class="box">
        <div class="box_line">
          <span class="icon_alert" title="Set All Product Alert"></span><span class="box_line_text" onclick="wishlist_add_all_alert()" title="Set All Product Alert">Set All Product Alert</span>
        </div>
        <div class="box_line">
          <span class="icon_comparison" title="Add All Items to Comparison"></span><span onclick="wishlist_add_all_compare()" class="box_line_text" title="Add All Items to Comparison" id="add_all_compare">Add All Items to Comparison</span>
        </div>
        <div class="box_line unborder_bottom">
          <span class="icon_cart"  title="Add All Items to Cart"></span><span class="box_line_text" onclick="add_all_to_cart('wishlist_all')" title="Add All Items to Cart" >Add All Items to Cart</span>
        </div>
      </div><!-- End .box -->
      <div class="rm_all">
        <a href="javascript:void(0);" onclick="remove_all_wishlist()"  class="wishlist" title="Erase All">Erase All</a>
        <img class="rm_all_compare" border="0" alt="comparsion" title="Erase All" src="images/rm_compare.png">
      </div>
      <div class="total">Total Number Of Products In Wishlist: <?php echo $count; ?></div>
    </div><!-- End .wishlist_left -->
    <div class="wishlist_right">
      <div class="list">
      <?php $compare_list = $_SESSION['compare_list']; ?>
      <?php foreach ($this->wishlist_list as $key => $value): ?>
      <div class="list-item">
      <div class="item <?php if ($count - 1 == $key): echo 'unborder_bottom'; endif;?>">
        <div class="image">
          <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->virtuemart_product_id), '<img  alt="image" title="" src=' . JURI::base() .  $value->images[0]->file_url . ' />'); ?>

        </div>
        <div class="icon_list">
            <div class="title_product">
              <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->virtuemart_product_id), $value->product_name); ?>
            </div>
            <?php  $in_compare_flag = FALSE;
                    if(is_array($compare_list) ):
                      if (in_array($value->virtuemart_product_id, $compare_list)):
                         $in_compare_flag = TRUE;
                      endif;
                    endif;
            ?>
            <a onclick="remove_reload_wishlist('<?php echo $value->virtuemart_product_id; ?>')"  title="Remove from Wishlist" class="icon_unwishlist">&nbsp;</a>

            <?php if (!$in_compare_flag): ?>
              <a id="add_compare_<?php echo $value->virtuemart_product_id; ?>" onclick="wishlist_add_compare('<?php echo $value->virtuemart_product_id; ?>')" title="Add to Comparison" class="icon_compare">&nbsp;</a>
              <a id="remove_compare_<?php echo $value->virtuemart_product_id; ?>" onclick="wishlist_remove_compare('<?php echo $value->virtuemart_product_id; ?>')" title="Remove from Comparison" class="icon_uncompare unactive">&nbsp;</a>
            <?php else: ?>
              <a id="add_compare_<?php echo $value->virtuemart_product_id; ?>" onclick="wishlist_add_compare('<?php echo $value->virtuemart_product_id; ?>')" title="Add to Comparison" class="icon_compare unactive">&nbsp;</a>
              <a id="remove_compare_<?php echo $value->virtuemart_product_id; ?>" onclick="wishlist_remove_compare('<?php echo $value->virtuemart_product_id; ?>')" title="Remove from Comparison" class="icon_uncompare">&nbsp;</a>
            <?php endif; ?>
            <a title="Price Match" class="icon_promotion">&nbsp;</a>
            <a id="icon_cart_<?php echo $value->virtuemart_product_id; ?>" title="Add to Cart" class="icon_cart" onclick="add_to_cart('<?php echo $value->virtuemart_product_id; ?>')">&nbsp;</a>
          </div>
          <div class="price">
            <?php echo $this->currency->createPriceDiv('retailPrice', 'COM_VIRTUEMART_PRODUCT_RETAIL_PRICE', $value->prices); ?>
          	<?php echo $this->currency->createPriceDiv('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $value->prices); ?>
          	<?php echo $this->currency->createPriceDiv('memberPrice', 'COM_VIRTUEMART_PRODUCT_MEMBER_PRICE', $value->prices); ?>
          </div>
          <div class="date_added">
            <div class="date"> <span class="date_title">Date Added: </span><span class="time"><?php echo JHTML::date ($value->create_date, 'd M, Y'); ?></span> </div>
            <div class="quality"> <span class="date_title">Quantity:&nbsp;&nbsp;&nbsp;</span><input name="quality" type="text" size="1" value="<?php echo $value->quantity; ?>" id="product_quantity_<?php echo $value->virtuemart_product_id; ?>" onblur="update_quantity(<?php echo $value->virtuemart_product_id; ?>);"> </div>
          </div>
      </div><!-- End .item -->
      </div><!-- End .item -->
      <?php endforeach; ?>
    </div><!-- End .wishlist_right -->
    </div><!-- End .wishlist_right -->
  </div><!-- End .wishlist_content_wapper -->
  <div id="wishlist_mess_box" title=""></div>
  <div id="cart_mess_box" title=""></div>
  <?php else : ?>
    No Data
  <?php endif; ?>
</div>
</div>

<!-- FORM EDIT-->
    <div class="edit_form" id="dialog_select_oprtion" title="Product Alert">

        <p class="dialog_select_label">Notify Me Through Email When:</p>

        <form id="EditForm">
        <div class="dialog_left floatleft">
            <p><input type="checkbox" name="promotion" id="promotion" value="1" class="text ui-widget-content ui-corner-all"  /><span>Promotion For This Product</span></p>
            <p><input type="checkbox" name="clearance" id="clearance" value="1" class="text ui-widget-content ui-corner-all" /><span>Clearance Sale For This Product  </span></p>
            <p><input type="checkbox" name="price_reduction" id="price_reduction" value="1" class="text ui-widget-content ui-corner-all"  /><span>Price Reduction For This Product</span></p>
            <p><input type="checkbox" name="new_review" id="new_review" value="1" class="text ui-widget-content ui-corner-all" /><span>New Review For This Product</span></p>
        </div>
        <div class="dialog_right floatright">
            <input type="submit" id="submit" class="alert_botton alert_botton_bold" value="Update >>" />
        </div>
        <div id="message_post"></div>
        </form>
    </div>
<div id="sendmailfriend" title="Email To Friend">
    <?php echo $this->emailform->text; ?>
</div>
<!-- FORM EDIT-->
<script>
    jQuery('#sendmailfriend').dialog({
        autoOpen: false,
        modal: true,
        width: 350,
        height: 150
    });
    jQuery("#EmailToFriend").submit(function(e) {
        e.preventDefault();
        var url2 = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=managerwishlist";
        jQuery.post(url2, jQuery("#EmailToFriend").serialize(), function() {
        }, "json");
        jQuery('#sendmailfriend').dialog('close');
    });

    var alert = jQuery.noConflict();
        alert('.edit_form').dialog({
            autoOpen: false,
            modal: true,
            width: 460,
            height: 270
        });
   function wishlist_add_all_alert(){
        alert('.edit_form').dialog('open');
        alert("#EditForm").submit(function(e){
        e.preventDefault();
        var url = vmSiteurl + "index.php?option=com_virtuemart&view=productalert&task=AllToAlert";
        alert.post(url,alert("#EditForm").serialize(), function (res) {
                alert('#wishlist_mess_box').attr("title", "Add All Product To Alert");
                alert('#wishlist_mess_box').dialog({
                autoOpen: false,
                modal: true,
                width: 400,
                height: 150
            });

                alert('#wishlist_mess_box').html('<br/><center>' + res + '</center>');
            alert('.edit_form').dialog('close');
            alert('#wishlist_mess_box').dialog('open');
        });

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
<style>
    #contentwrapper
    {
        width: 100% !important;
    }
</style>