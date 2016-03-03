<?php
defined('_JEXEC') or die('Restricted access');
?>
<?php if ($this->top_compare_list): ?>
<div id="topproductcompare">
    <h2>Other products customers compare with 10 function bullet vibrator</h2>
    <ul id="topcompare" class="jcarousel-skin-ie7 topcompare list10p">
        <?php foreach ($this->top_compare_list as $key => $value): ?>
            <li class="product product_<?php echo $key; ?>"><div>
                    <div class="count"><?php echo $value->count; ?> <?php if ($value->count > 1): ?>customers <?php else: ?>customer <?php endif; ?>compared with</div>
                    <div class="product_info">
                        <div class="product_img">
                            <?php $thum = '<img src="' . JURI::root () . $value->data->images[0]->file_url  . '" title="'. $value->data->product_name.'" />'?>
                            <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->data->virtuemart_product_id), $thum); ?>
                        </div>
                        <p class="product_name"><?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->data->virtuemart_product_id), $value->data->product_name); ?> </p>
                        <p class="price"><?php echo $this->currency->createPriceDiv('salesPrice', 'COM_VIRTUEMART_PRODUCT_RETAIL_PRICE',  $value->data->prices, TRUE); ?></p>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#topcompare').jcarousel({
            scroll: 3
        });
    });
</script>
<?php endif; ?>