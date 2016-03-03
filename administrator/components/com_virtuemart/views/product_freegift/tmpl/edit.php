<?php
/**
 *
 * Description
 *
 * @package	VirtueMart
 * @subpackage ShopperGroup
 * @author Markus �hler
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit.php 6031 2012-05-16 13:11:13Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
AdminUIHelper::startAdminArea();
AdminUIHelper::imitateTabs('start', 'COM_VIRTUEMART_PRODUCT_FREE_GIFT');
?>
<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm" id="adminForm">
    <?php
    ?>
    <?php echo $this->langList; ?>
    <div class="col50">
        <fieldset>
            <legend><?php echo JText::_('COM_VIRTUEMART_PRODUCT_FREE_GIFT'); ?></legend>
            <table class="admintable">
                <input type="hidden" name="id" value="<?php echo $this->freegift->id; ?>" />
                <?php echo $this->addStandardHiddenToForm(); ?>
                <?php echo VmHTML::row('input', 'COM_VIRTUEMART_PRODUCT_FREE_GIFT', 'free_gift_name', $this->freegift->free_gift_name); ?>
                <?php echo VmHTML::row('input', 'COM_VIRTUEMART_FREE_GIFT_PRODUCT_CONDITION', 'condition', $this->freegift->condition); ?>

            </table>
        </fieldset>
        <fieldset style="background-color:#F9F9F9;">
            <legend><?php echo JText::_('COM_VIRTUEMART_FREEGIFT_PRODUCTS'); ?></legend>
            <?php echo JText::_('COM_VIRTUEMART_PRODUCT_FREEGIFT_SEARCH'); ?>
            <div class="jsonSuggestResults" style="width: auto;">
                <input type="text" size="40" name="search" id="freegiftProductsSearch" value="" />
                <button class="reset-value"><?php echo JText::_('COM_VIRTUEMART_RESET') ?></button>
            </div>
            <div id="freegift_products"><?php echo $this->freegift->freegift_product; ?></div>
        </fieldset>
    </div>
</form>
<?php
AdminUIHelper::imitateTabs('end');
AdminUIHelper::endAdminArea();
?>
<script type="text/javascript">
    nextCustom = 1;
    jQuery("#admin-ui-tabs").delegate("div.vmicon-16-remove", "click", function() {
        jQuery(this).closest(".vm_thumb_image").fadeOut("500", function() {
            jQuery(this).remove()
        });
    });
    jQuery('input#freegiftProductsSearch').autocomplete({
        source: 'index.php?option=com_virtuemart&view=product_freegift&task=getData&format=json&type=freegift&row=' + nextCustom,
        select: function(event, ui) {
            jQuery("#freegift_products").append(ui.item.label);
            nextCustom++;
            jQuery(this).autocomplete("option", 'source', 'index.php?option=com_virtuemart&view=product_freegift&task=getData&format=json&type=freegift&row=' + nextCustom)
            jQuery('input#freegiftProductsSearch').autocomplete("option", 'source', 'index.php?option=com_virtuemart&view=product_freegift&task=getData&format=json&type=freegift&row=' + nextCustom)
        },
        minLength: 1,
        html: true
    });
</script>