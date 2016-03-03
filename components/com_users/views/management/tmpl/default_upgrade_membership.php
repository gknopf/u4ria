<?php defined('_JEXEC') or die('Restricted access'); ?>

<script src="components/com_virtuemart/assets/nanoscroller/javascripts/jquery.nanoscroller.js" type="text/javascript"></script>
  
<script>
    var setpopup = false;
    var dialog_alert = jQuery.noConflict();    
    dialog_alert(function() {
        dialog_alert('#confirm_dialog').dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            height: 150  
        });        
        dialog_alert('#upgrademember').click(function() {
                 dialog_alert('#confirm_dialog').dialog('open');
        });
        dialog_alert('#cancelupgrademember').click(function() {
                 dialog_alert('#confirm_dialog').dialog('close');
        });
 
});
    
</script>
<div id="confirm_dialog" title="Upgraded membership">
    <form method="post" class="product js-recalculate" action="<?php echo JRoute::_('index.php'); ?>">
        <div style="text-align: center">
            <input class="alert_botton" type="submit" name="submit" value="OK" 
                   style="height: 30px;width: 50px;"/>
            <input class="alert_botton" type="button" id="cancelupgrademember" value="Cancel" 
                   style="height: 30px;"/>
        </div>
         <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="management.upgradedmember" />
    </form>
</div>



