<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="category_list">
	<?php
	// Category and Columns Counter
	$iBrowseCol = 1;
	$iBrowseProduct = 1;
	// Calculating Products Per Row
	$BrowseProducts_per_row = 1;
	$Browsecellwidth = ' width' . floor (100 / $BrowseProducts_per_row);
	// Separator
	$verticalseparator = " vertical-separator";
	$BrowseTotalProducts = count($this->products);
	// Start the Output
	foreach ($this->products as $product) {
            $totalvote = 0;
            $totalrate = 0;
            foreach ($product->rating as $key => $value) :
                $totalrate += $value->ratingcount*$value->rate;
                $totalvote += $value->ratingcount;
            endforeach;
//            print_r($product);
		// Show the horizontal seperator
		if ($iBrowseCol == 1 && $iBrowseProduct > $BrowseProducts_per_row) {
			?>
			<?php
		}
		// this is an indicator wether a row needs to be opened or not
		if ($iBrowseCol == 1) {
			?>
	<div class="row">
	<?php
		}
		// Show the vertical seperator
		if ($iBrowseProduct == $BrowseProducts_per_row or $iBrowseProduct % $BrowseProducts_per_row == 0) {
			$show_vertical_separator = ' ';
		} else {
			$show_vertical_separator = $verticalseparator;
		}
		// Show Products
		?>
		<div class="product floatleft<?php echo $Browsecellwidth . $show_vertical_separator ?>">
                    <div class="spacer width25 floatleft f4c">
                        <div class="prx">
                            <div>
				<div class="width100 floatleft center product_image">
                                    <?php if($product->label_id): ?>
                                    <div class="product_label"><img src="<?php echo $product->label->file_url ?>" /></div>
				    <?php endif; ?>
				    <a title="<?php echo $product->product_name ?>" rel="vm-additional-images" href="<?php echo $product->link; ?>">
						<?php
							echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
						?>
					 </a>

				</div>
                            </div>
                        </div>
                    </div>
                    <div class="spacer width25 floatleft f4c">
                        <div class="prx">
                            <div>
                                <div class="width100 floatleft">
                                    <div class="width100 floatright product_name">

                                    <?php if (strlen($product->product_name) < 45):
                                        $new_name = $product->product_name;
                                    else:
                                        $new_name = substr($product->product_name, 0, strrpos(substr($product->product_name, 0, 45), ' ')) . ' ...'; endif; ?>
                                        <h2><?php echo JHTML::link ($product->link, $new_name); ?></h2>
                                    </div>
                                    <div class="width100 floatright ">
                                    <!-- The "Average Customer Rating" Part -->
                                            <?php if ($this->showRating) {
                                                if (empty($product->rating)) {
                                                    ?>
                                                    <span class="vote"><?php echo JText::_('COM_VIRTUEMART_AVERAGE_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                                                        <?php
                                                    } else {
                                                        $AverageRate = $totalrate/$totalvote;
                                                        $ratingwidth = $AverageRate * 12; //I don't use round as percetntage with works perfect, as for me
                                                        ?>
                                                    <span class="vote">
                                                        <?php echo JText::_('COM_VIRTUEMART_RATING_AVE'); ?>
                                                        <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE")).' '.$AverageRate ?>" class="ratingbox rsm" style="display:inline-block;">
                                                            <span class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>">
                                                            </span>
                                                        </span>
                                                        <span><?php echo '('.$totalvote.' votes)' ?></span>
                                                    </span>
                                                <?php
                                                }
                                            } ?>
                                            <?php if ($this->showRating) {
                                                if (empty($product->votes)) {
                                                    ?>
                                                    <span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING_SOT') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                                                        <?php
                                                    } else {
                                                        $ratingwidth = $product->votes->rating * 12; //I don't use round as percetntage with works perfect, as for me
                                                        ?>
                                                    <span class="vote">
                                                        <?php echo JText::_('COM_VIRTUEMART_RATING'); ?>
                                                        <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE")).' '.$product->votes->rating ?>" class="ratingbox rsm" style="display:inline-block;">
                                                            <span class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>">
                                                            </span>
                                                        </span>
                                                        <span><?php echo '('.$product->votes->ratingcount.' reviews)' ?></span>
                                                    </span>
                                                <?php
                                                }
                                            } ?>
                                            <?php
                                                    if ( VmConfig::get ('display_stock', 1)) { ?>
                                                    <!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
                                                    <div class="paddingtop8">
                                                            <span class="vmicon vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
                                                            <span class="stock-level"><?php echo JText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
                                                    </div>
                                                    <?php } ?>
                                    </div>
                                    <div class="width100 floatleft cbicon c2ic">
                                        <div class="floatleft">
                                            <?php $con = "display:block;"; $coff = "display:none;"; ?>
                                            <?php if($product->show_compare_flag==2){ $con = "display:none;"; $coff = "display:block;";} ?>
                                            <?php if (in_array($product->virtuemart_product_id, $this->wishlist_list)): $add_wl = "display: none"; $remove_wl = ""; else: $add_wl = ""; $remove_wl = "display: none"; endif;?>
                                            <div class="icwl cl_add_wishlist_<?php echo  $product->virtuemart_product_id; ?>" style="<?php echo $add_wl; ?>"><a href="javascript:void(0);" onclick="cl_add_wishlist('<?php echo $product->virtuemart_product_id; ?>');" class="wishlist"><img alt="<?php echo JText::_('COM_VIRTUEMART_WISHLIST') ?>" title="<?php echo JText::_('COM_VIRTUEMART_WISHLIST') ?>" src="<?php echo $this->baseurl ?>/templates/altalab/images/wishlist.jpg" /></a></div>
                                            <div class="icwl cl_remove_wishlist_<?php echo  $product->virtuemart_product_id; ?>" style="<?php echo $remove_wl; ?>" ><a href="javascript:void(0);" onclick="cl_remove_wishlist('<?php echo $product->virtuemart_product_id; ?>');" class="wishlist"><img alt="<?php echo JText::_('COM_VIRTUEMART_WISHLIST') ?>" title="<?php echo JText::_('COM_VIRTUEMART_WISHLIST_REMOVE') ?>" src="<?php echo $this->baseurl ?>/templates/altalab/images/wishlist_remove.jpg" /></a></div>

                                            <div style="<?php echo $con; ?>" class="icc compa_on compa_on<?php echo $product->virtuemart_product_id; ?>"><a href="javascript:void(0);" onclick="cl_add_compare(<?php echo $product->virtuemart_product_id; ?>,'<?php echo $product->product_name; ?>')" class="wishlist"><img alt="<?php echo JText::_('COM_VIRTUEMART_COMPARISION') ?>" title="<?php echo JText::_('COM_VIRTUEMART_COMPARISION') ?>" src="<?php echo $this->baseurl ?>/templates/altalab/images/comparison.jpg" /></a></div>
                                            <div style="<?php echo $coff; ?>" class="icc compa_off compa_off<?php echo $product->virtuemart_product_id; ?>"><a href="javascript:void(0);" onclick="cl_rm_compare(<?php echo $product->virtuemart_product_id; ?>,'<?php echo $product->product_name; ?>')" class="wishlist"><img alt="<?php echo JText::_('COM_VIRTUEMART_COMPARISION') ?>" title="<?php echo JText::_('COM_VIRTUEMART_COMPARISION_REMOVE') ?>" src="<?php echo $this->baseurl ?>/templates/altalab/images/comparison_remove.jpg" /></a></div>
                                            <div class="icpp"><a  href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=pricematch&pid='.$product->virtuemart_product_id); ?>" class="price_match" title="<?php echo JText::_('PRICE_MATCH') ?>"><img title="Price Match" alt="<?php echo JText::_('PRICE_MATCH') ?>" title="<?php echo JText::_('PRICE_MATCH') ?>" src="<?php echo $this->baseurl ?>/templates/altalab/images/pricematch.jpg" /></a></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="spacer width25 floatleft f4c">
                        <div class="prx">
                            <div>
                                <div class="width100 floatleft vmprice vmdes">
                                    <div class="width100 floatleft">
                                        <p class="prd">Product Description</p>
                                        <?php
					if (!empty($product->product_s_desc)) {
						?>
						<p class="product_s_desc">
							<?php echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 150, '...') ?>
						</p>
                                        <?php } ?>

                                    </div>
                                    <div class="width100 floatleft cbicon pdes">
                                        <div class="floatright">
                                            <?php if($product->product_highly): ?>
                                            <div class="icwl highrecon"><img alt="<?php echo $this->product_config->name_attribute4 ?>" title="<?php echo $this->product_config->name_attribute4 ?>" src="<?php echo JURI::base().$this->product_config->highly ?>" /></div>
                                            <?php endif; ?>
                                            <?php if($product->product_top50): ?>
                                            <div class="icc"><img alt="<?php echo $this->product_config->name_attribute1 ?>" title="<?php echo $this->product_config->name_attribute1 ?>" src="<?php echo JURI::base().$this->product_config->top50 ?>" /></div>
                                            <?php endif; ?>
                                            <?php if($product->product_top100): ?>
                                            <div class="icc"><img alt="<?php echo $this->product_config->name_attribute2 ?>" title="<?php echo $this->product_config->name_attribute2 ?>" src="<?php echo JURI::base().$this->product_config->top100 ?>" /></div>
                                            <?php endif; ?>
                                            <?php if($product->product_with_video_demo): ?>
                                            <div class="icpp"><img alt="<?php echo $this->product_config->name_attribute3 ?>" title="<?php echo $this->product_config->name_attribute3 ?>" src="<?php echo JURI::base().$this->product_config->videodemo ?>" /></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="spacer width25 floatleft f4c">
                        <div class="prx"><div>
                                <div class="width100 floatleft vmprice">
                                    <div class="width100 floatleft vmprice">
                                        <div class="width100 floatleft">
                                            <div class="pdcl"><?php echo JText::_('COM_VIRTUEMART_MARKET_AVERAGR_RETAIL_PRICE') ?></div>
                                            <?php if($product->prices['retailPrice']): ?>
                                            <div class="pdcr"><?php echo $this->currency->createPriceDiv('retailPrice', 'COM_VIRTUEMART_PRODUCT_RETAIL_PRICE', $product->prices['retailPrice'],true); ?></div>
                                            <?php else: ?>
                                            <div class="pdcr">0.00 $</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="width100 floatleft">
                                            <div class="pdcl"><?php echo JText::_('COM_VIRTUEMART_GUEST_ONLINE_PRICE') ?></div>
                                            <?php if($product->prices['salesPrice']): ?>
                                            <div class="pdcr"><?php echo $this->currency->createPriceDiv('salesPrice', 'COM_VIRTUEMART_PRODUCT_RETAIL_PRICE', $product->prices['salesPrice'],true); ?></div>
                                            <?php else: ?>
                                            <div class="pdcr">0.00 $</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="width100 floatleft multi-tier">
                                            <div class="pdcl"><?php echo JText::_('COM_VIRTUEMART_MULTI_MEMBER_PRICE') ?></div>
                                            <?php if($product->prices['memberPrice']): ?>
                                            <div class="pdcr"><?php echo $this->currency->createPriceDiv('memberPrice', 'COM_VIRTUEMART_PRODUCT_RETAIL_PRICE', $product->prices['memberPrice'],true); ?></div>
                                            <?php else: ?>
                                            <div class="pdcr">Login</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="width100 floatleft category_addtocart">
                                        <form method="post" class="product" action="index.php" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">

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
                                                                $stockhandle = VmConfig::get ('stockhandle', 'none');
                                                                if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($product->product_in_stock - $product->product_ordered) < 1) {
                                                                        $button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
                                                                        $button_cls = 'Notify me';
                                                                        ?>

                                                                <span class="notify_me">
                                                                    <a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' 
                                                                            . $product->virtuemart_product_id); ?>" style="color: red;" class="notify">
                                                                                <?php echo JText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?>
                                                                    </a>
                                                                </span>
                                                                <span class="addtocart-button cart-notify">
                                                                    <span class="notify"><?php echo JText::_('COM_VIRTUEMART_OUT_OF_STOCK') ?></span>
                                                                </span>
                                                               <?php }else{
                                                                // Display the add to cart button ?>
                                                                <span class="addtocart-button">
                                                                        <input type="submit" name="addtocart"  class="fix addtocart-button" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" />
                                                                </span>
                                                                <span class="addtocart-button cart-in-stock">
                                                                    <span class="instock"><?php echo JText::_('COM_VIRTUEMART_IN_STOCK') ?></span>
                                                                </span>
                                                                <?php } ?>
                                                        <div class="clear"></div>
                                                </div>

                                                        <?php // Display the add to cart button END ?>
                                                        <input type="hidden" class="pname" value="<?php echo $product->product_name ?>">
                                                        <input type="hidden" name="option" value="com_virtuemart" />
                                                        <input type="hidden" name="view" value="cart" />
                                                        <noscript><input type="hidden" name="task" value="add" /></noscript>
                                                        <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>" />
                                                        <?php /** @todo Handle the manufacturer view */ ?>
                                                        <input type="hidden" name="virtuemart_manufacturer_id" value="<?php echo $product->virtuemart_manufacturer_id ?>" />
                                                        <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />
                                        </form>
                                    </div>
                                    <div class="clear"></div>
                                </div>

				<div class="clear"></div>
			</div></div></div>
			<!-- end of spacer -->
		</div> <!-- end of product -->
		<?php

		// Do we need to close the current row now?
		if ($iBrowseCol == $BrowseProducts_per_row || $iBrowseProduct == $BrowseTotalProducts) {
			?>
			<div class="clear"></div>
   </div> <!-- end of row -->
			<?php
			$iBrowseCol = 1;
		} else {
			$iBrowseCol++;
		}

		$iBrowseProduct++;
	} ?>
	<div class="clear"></div>
	<?php if ($iBrowseCol != 1) {
		?>
	<div class="clear"></div>

		<?php
	} ?>
       </div>
<!--<script type="text/javascript">
// Equal Height Columns
jQuery.fn.equalHeight = function () {
    var height        = 0;
    var maxHeight    = 0;

    // Store the tallest element's height
    this.each(function () {
        height        = jQuery(this).outerHeight();
        maxHeight    = (height > maxHeight) ? height : maxHeight;
    });

    // Set element's min-height to tallest element's height
    return this.each(function () {
        var t            = jQuery(this);
        var minHeight    = maxHeight - (t.outerHeight() - t.height());
        var property    = jQuery.browser.msie && jQuery.browser.version < 7 ? 'height' : 'min-height';

        t.css(property, minHeight + 'px');
    });
};
</script>
<script type="text/javascript">
jQuery('.prx').equalHeight();
</script>-->