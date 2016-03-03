<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('product_alert');

?>
<?php $user = JFactory::getUser();  ?>
<script>
    var setpopup = false;
    var dialog_alert = jQuery.noConflict();    
    dialog_alert(function() {
        dialog_alert('#sign_up_dialog').dialog({
            autoOpen: false,
            modal: true,
            width: 450,
            height: 270
        });
        dialog_alert('#dlogin').dialog({
            autoOpen: false,
            modal: true,
            width: 450,
            height: 270
        });        
        dialog_alert('#dialog_select_oprtion').dialog({
            autoOpen: false,
            modal: true,
            width: 460,
            height: 270,
            hide: {
              effect: "fade",
              duration: 500
            }             
        });
        dialog_alert('#email_edit').dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            height: 150  
        });        
        dialog_alert('#opener').click(function() {
            if(setpopup){
                 dialog_alert('#dialog_select_oprtion').dialog('open');
            }else{
//            alert(yetVisited);
            <?php if(empty($this->alert_list)): ?>
            dialog_alert('#sign_up_dialog').dialog('open');
            <?php else: ?>
            dialog_alert('#dialog_select_oprtion').dialog('open');    
            <?php endif; ?>
            }
        });

        dialog_alert('#sign_up').click(function() {
            dialog_alert('#dialog_select_oprtion').dialog('open');
            dialog_alert('#sign_up_dialog').dialog('close');
        });
        dialog_alert("#emailtmp").keyup(function () {
          var value = dialog_alert(this).val();
          dialog_alert("#email").val(value);
        }).keyup();
        dialog_alert('#alert_update').click(function(){
            var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=addcompare";
            var parameter = {product_id: 1};
                alert('You added product to comparision');                
        });            

        dialog_alert("#JqPostForm").submit(function(e){
            e.preventDefault();
            var url = vmSiteurl + "index.php?option=com_virtuemart&view=productalert&task=addAlert";
            dialog_alert.post(url, dialog_alert("#JqPostForm").serialize(),function(res){
//                dialog_alert('#alert_option').html(res.html)
            },"json");
            dialog_alert('#dialog_select_oprtion').dialog('close');
//            window.setTimeout('location.reload()', 1500);
            setpopup = true;

        });
        dialog_alert('#login').click(function() {
            dialog_alert('#alert_login').dialog({
                autoOpen: false,
                modal: true,
                width: 400,
                height: 230
            }); 
            
            dialog_alert('#alert_login').dialog('open');
//            document.location.href='<?php echo JRoute::_('index.php?option=com_users&amp;view=login'); ?>';
        });
        dialog_alert('#alert_manager_botton').click(function() {
            document.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=productalert'); ?>';
        });
 
});
    
</script>
    
<?php if(empty($this->alert_list)): ?>
<div id="sign_up_dialog" title="Product Alert">
    <?php if ($user->id != 0){ ?>
    <p class="sign_up_dialog_label">Sign up with your email:</p>
    <input type="text" name="emailtmp" id="emailtmp" value="<?php echo $user->email; ?>" class="text ui-widget-content ui-corner-all" />    
    <p class="sign_up_dialog_label"><button class="alert_botton alert_botton_bold" id="sign_up" value="" >SIGN UP >></button></p>
    <?php }else{ ?>
    <p class="sign_up_dialog_label"><button class="alert_botton alert_botton_bold" id="login" value="" >LOG IN</button></p>
    <?php } ?>
</div>
<?php endif; ?>

<div id="dialog_select_oprtion" title="Product Alert">
    
    <p class="dialog_select_label">Notify Me Through Email When:</p>
    <p class="dialog_bottom">
    <form method="post" class="product dialog_form" action="index.php" id="addtocartproduct<?php echo $this->product->virtuemart_product_id ?>">

            <div class="addtocart-bar">
                            <?php // Display the quantity box ?>
                            <!-- <label for="quantity<?php echo $product->virtuemart_product_id;?>" class="quantity_box"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
                            <!--<span class="quantity-box">-->
                                    <input style="display:none;" type="text" class="quantity-input" name="quantity[]" value="1" />
                            <!--</span>-->

                            <?php // Display the quantity box END ?>

                            <?php // Add the button
                            $button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
                            $button_cls = ''; //$button_cls = 'addtocart_button';
                            if (VmConfig::get('check_stock') == '0' && !$this->product->product_in_stock) {
                                    $button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
                                    $button_cls = 'Notify me'; 
                                    ?>

                            <span class="addtocart-button">
                                <div class="notify"><?php echo $button_cls ?></div>
                            </span>                                                          
                           <?php }else{
                            // Display the add to cart button ?>
                            <span class="addtocart-button">
                                    <input type="submit" name="addtocart"  class="fix addtocart-button" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" />
                            </span>
                                                          
                            <?php } ?>
                            <span class="dialog_lasttree">LAST 3 PIECES</span>
                    <div class="clear"></div>
            </div>

                    <?php // Display the add to cart button END ?>
                    <input type="hidden" class="pname" value="<?php echo $this->product->product_name ?>">
                    <input type="hidden" name="option" value="com_virtuemart" />
                    <input type="hidden" name="view" value="cart" />
                    <noscript><input type="hidden" name="task" value="add" /></noscript>
                    <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $this->product->virtuemart_product_id ?>" />
                    <?php /** @todo Handle the manufacturer view */ ?>
                    <input type="hidden" name="virtuemart_manufacturer_id" value="<?php echo $this->product->virtuemart_manufacturer_id ?>" />
                    <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $this->product->virtuemart_category_id ?>" />
    </form>
        
    </p>
    <form id="JqPostForm">
    <div id="alert_option" class="dialog_left floatleft">
        <p><input type="checkbox" name="promotion" id="promotion" value="1" class="text ui-widget-content ui-corner-all" <?php if($this->alert->alert_product_promotion) echo "checked" ?> /><span>Promotion For This Product</span></p>
        <p><input type="checkbox" name="clearance" id="clearance" value="1" class="text ui-widget-content ui-corner-all" <?php if($this->alert->alert_product_clearance_sale) echo "checked" ?>/><span>Clearance Sale For This Product  </span></p>
        <p><input type="checkbox" name="price_reduction" id="price_reduction" value="1" class="text ui-widget-content ui-corner-all" <?php if($this->alert->alert_product_price_reduction) echo "checked" ?> /><span>Price Reduction For This Product</span></p>
        <p><input type="checkbox" name="new_review" id="new_review" value="1" class="text ui-widget-content ui-corner-all" <?php if($this->alert->alert_product_new_review) echo "checked" ?> /><span>New Review For This Product</span></p>
    </div>
    <div class="dialog_right floatright">
        <a href="javascript:void(0);" onclick="mailedit();" class="alert_manager_botton" name="editmail" id="editmail">Edit Email Alert</a>
        <a href="javascript:void(0);" id="alert_manager_botton" class="alert_manager_botton">Manage Product Alert</a>
        <input type="submit" id="submit" class="alert_botton alert_botton_bold" value="Update >>" />
    </div>  
    <div id="message_post"></div>
    <input name="product_id" type="hidden" value="<?php echo $this->product->virtuemart_product_id ?>"/>
    <input id="email" name="email" type="hidden" value="<?php echo $this->alert_list[0]->alert_email; ?>"/>
    <input name="uid" type="hidden" value="<?php echo $user->id; ?>"/>
    <?php if(empty($this->alert)): ?>
        <input id="alert_action" name="alert_action" type="hidden" value="add"/>
    <?php else: ?>
        <input id="alert_action" name="alert_action" type="hidden" value="update"/>
    <?php endif; ?>
    </form>
</div>

<div id="alert_login" class="moduletable loginmod" title="Login">
       <?php
         jimport('joomla.application.module.helper');
          $mod = JModuleHelper::getModule('mod_login');
//              $mod->params    = "cols=2\nrows=10";
          $attribs['style'] = 'raw';
          echo JModuleHelper::renderModule($mod, $attribs);
        ?>
</div>
<div id="email_edit" title="Change Email Alert">
    <form id="email_form">
        <p>Email to change:</p>
        <input id="new_email" class="new_email" name="new_email" type="text" value="<?php echo $this->alert_list[0]->alert_email; ?>" placeholder="New Email"/>
        <input class="alert_botton" type="submit" name="submit" value="Update" />
    </form>
</div>



