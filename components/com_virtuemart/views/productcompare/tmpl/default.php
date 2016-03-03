<link href="components/com_virtuemart/views/productcompare/css.css" rel="stylesheet" type="text/css" />
<!-- <link href="components/com_virtuemart/views/productcompare/css_002.css" rel="stylesheet" type="text/css" /> -->
<!-- <script type="text/javascript" src="components/com_virtuemart/views/productcompare/ga.js"></script> -->

<?php
// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
JHTML::_('behavior.modal');
$document = JFactory::getDocument ();
$imageJS = 'jQuery(document).ready(function() {';
foreach ($this->general_info as $k => $videos):
$imageJS .= '
        jQuery(\'#productcompare_videos_'.$k.'\').jcarousel({
            scroll:1
        });
        jQuery(\'#rated_review_'.$k.'\').jcarousel({
            scroll:1
        });
';
endforeach;
$imageJS .='});';
$document->addScriptDeclaration ($imageJS);
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('product_alert');
?>

<script type="text/javascript" language="javascript">
 jQuery(document).ready(function(){
	    var max_height_highly_rated = 0;
	    jQuery('.highly_rated', this).each(function() {
	        if(jQuery(this).height() > max_height_highly_rated) {
	        	max_height_highly_rated = jQuery(this).height();
	        }
	    });

	    jQuery('.highly_rated').height(max_height_highly_rated);

	    var max_height_video = 0;
	    jQuery('.videos', this).each(function() {
	        if(jQuery(this).height() > max_height_video) {
	        	max_height_video = jQuery(this).height();
	        }
	    });

	    jQuery('.videos').height(max_height_video);

	    var max_height_general = 0;
	    jQuery('.general', this).each(function() {
	        if(jQuery(this).height() > max_height_general) {
	        	max_height_general = jQuery(this).height();
	        }
	    });

	    jQuery('.general').height(max_height_general + 50);
  });
</script>
<div class="product_compare_wapper">
  <div class="top">
    <?php    if ($this->compare_list): ?>
    <div class="padding">
      <span class="send_friend" title="Email To Friend"  onclick="email_to_friend('compare')" >Email To Friend</span>
      <?php if (isset($this->page_array['pre'])):?>
        <?php echo $this->page_array['pre']; ?>
      <?php else: ?>
        <span class="pre"> < Previous </span>
      <?php endif; ?>
      <span class="page"> | </span>
      <span class="page"> Pages </span>
      <?php foreach ($this->page_array['pages'] as $value): ?>
        <?php echo $value; ?>
      <?php endforeach; ?>
      <span class="page"> | </span>
      <?php if (isset($this->page_array['next'])):?>
        <?php echo $this->page_array['next']; ?>
      <?php else: ?>
        <span class="next">Next > </span>
      <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="total">
      <span class="main_title">Comparison Chart</span>
      <?php if ($this->compare_list): ?>
        <a href="javascript:void(0);" onclick="remove_all_compare()"  class="wishlist" title="Erase All">Erase All</a>
        <img class="rm_all_compare" border="0" alt="comparsion" title="comparsion" src="images/rm_compare.png">
      <?php endif; ?>
      Total Number Of Product To Compare: <strong id="tot_prods_top"><?php echo $this->total_number;?></strong></div>
  </div><!-- End .top -->
  <?php if ($this->compare_list): ?>
  <div class="compare_content">
    <div class="compare_items">
      <div class="title main_title">
        General Information
      </div>
      <?php foreach ($this->general_info as $key => $value): ?>
        <?php  $in_wishlist_flag = FALSE;
          if(is_array($this->wishlist_list)):
            if (in_array($key, $this->wishlist_list)):
               $in_wishlist_flag = TRUE;
            endif;
          endif;
        ?>
        <div class="compare_product general">
          <div class="" id="rm_icon">
            <div class="icon_rm" onclick="rm_compare('<?php echo $key;?>')">&nbsp;</div>
          </div>
          <div class="product_title"><?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $key), $value['name']); ?></div>
          <div class="product_thumb">
            <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $key), '<img  alt="image" title="" src=' . JURI::base() . $value['image'] . ' />'); ?>

          </div>
          <div class="icons">
            <?php if (!$in_wishlist_flag): ?>
              <a id="add_wishtlist_<?php echo $key; ?>" onclick="compare_add_wishlist('<?php echo $key; ?>')" title="Add to Wishlist" class="icon_wishlist">&nbsp;</a>
              <a id="remove_wishlist_<?php echo $key; ?>" onclick="compare_remove_wishlist('<?php echo $key; ?>')" title="Remove from Wishlist" class="icon_unwishlist unactive">&nbsp;</a>
            <?php else: ?>
              <a id="add_wishtlist_<?php echo $key; ?>" onclick="compare_add_wishlist('<?php echo $key; ?>')" title="Add to Wishlist" class="icon_wishlist unactive">&nbsp;</a>
              <a id="remove_wishlist_<?php echo $key; ?>" onclick="compare_remove_wishlist('<?php echo $key; ?>')" title="Remove from Wishlist" class="icon_unwishlist">&nbsp;</a>
            <?php endif; ?>

            <a class="icon_uncompare" title="Remove from Comparison" onclick="rm_compare('<?php echo $key;?>')" >&nbsp;</a>
            <a class="icon_promotion" title="Price Match" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=pricematch&pid='.$key); ?>">&nbsp;</a>
            <a id="icon_cart_<?php echo $key; ?>" title="Add to Cart" class="icon_cart" onclick="add_to_cart('<?php echo $key; ?>')">&nbsp;</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div><!-- End General info -->
    <div class="clr"></div>
    <div class="compare_items">
      <div class="title sub_title">
        - Photos
      </div>
      <?php foreach ($this->compare_list as $value): ?>
      <div class="compare_product">
        <div class="photo_title">All Available Photos </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Photos info -->
    <div class="clr"></div>

    <div class="compare_items">
      <div class="title sub_title">
        - Our Price
      </div>

      <?php foreach ($this->price_array as $key => $value): ?>
        <div class="compare_product">
          <?php echo $this->currency->createPriceDiv('retailPrice', 'COM_VIRTUEMART_PRODUCT_RETAIL_PRICE', $value); ?>
        	<?php echo $this->currency->createPriceDiv('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $value); ?>
        	<?php echo $this->currency->createPriceDiv('memberPrice', 'COM_VIRTUEMART_PRODUCT_MEMBER_PRICE', $value); ?>
        </div>
      <?php endforeach; ?>
    </div><!-- End Our price info -->
    <div class="clr"></div>
    <?php if (array_filter($this->detail_array['color'])): ?>
        <div class="compare_items">
          <div class="title sub_title">
            - Color (Product)
          </div>
            <?php foreach ($this->detail_array['color'] as $key => $value): ?>
              <div class="compare_product">
                <div class="photo_title"><?php if ($value ): echo $value; else: echo ''; endif; ?></div>
              </div>
            <?php endforeach;?>
        </div><!-- End Color info -->
        <div class="clr"></div>
        <?php endif; ?>
    <div class="clr"></div>
    <?php if (array_filter($this->detail_array['product_type'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Type
      </div>
      <?php foreach ($this->detail_array['product_type'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['product_lining'])): ?>
<div class="compare_items">
      <div class="title sub_title">
        - Lining
      </div>
      <?php foreach ($this->detail_array['product_lining'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['cock_ring_style'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Cock ring style
      </div>
      <?php foreach ($this->detail_array['cock_ring_style'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['product_boning'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Boning
      </div>
      <?php foreach ($this->detail_array['product_boning'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['bottom_style'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Bottom style
      </div>
      <?php foreach ($this->detail_array['bottom_style'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['flavor'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Flavor
      </div>
      <?php foreach ($this->detail_array['flavor'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['lingerie_closure'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Lingerie closure
      </div>
      <?php foreach ($this->detail_array['lingerie_closure'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['lingerie_special_features'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Lingerie special features
      </div>
      <?php foreach ($this->detail_array['lingerie_special_features'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['product_pattern'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Pattern
      </div>
      <?php foreach ($this->detail_array['product_pattern'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['product_top_style'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Top style
      </div>
      <?php foreach ($this->detail_array['product_top_style'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (empty($this->brand_array)): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Brand
      </div>
      <?php foreach ($this->brand_array as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (empty($this->manufacturer_array)): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Manufacturer
      </div>
      <?php foreach ($this->manufacturer_array as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <?php endif; ?>
    <div class="clr"></div>
    <hr>
    <div class="compare_items">
        <div class="title main_title" style="padding: 0px 0px 0px 10px;">
        Promotions / Clearance / Price Reduction
      </div>
      <?php foreach ($this->compare_list as $value): ?>
      <div class="compare_product disable_border_top">
        <div class="product_title">&nbsp;</div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Product detail info -->
    <div class="clr"></div>
    <hr>
    <div class="compare_items">
      <div class="title main_title">
        Rating
      </div>
      <?php foreach ($this->average_rating as $key => $value): ?>
        <?php $totalvote = 0; ?>
        <?php $totalrate = 0; ?>
        <?php $ratingwidth = 0; ?>
        <?php if ($value): ?>
          <?php foreach ($value as $key2 => $value2):?>
            <?php $totalrate += $value2->ratingcount * $value2->rate; ?>
            <?php $totalvote += $value2->ratingcount; ?>
          <?php endforeach;?>
          <?php $ratingwidth = ($totalrate/$totalvote) * 19; ?>
        <?php endif; ?>

        <div class="compare_product disable_border_top">
            <div class="star_icon">
                <span style="display:inline-block;" class="ave_ratingbox" title="Average Rating">
                  <span style="width:<?php echo $ratingwidth; ?>px" class="stars-green1"></span>
                </span>
            </div>
            <div  class="number_vote">(<?php echo $totalvote; ?> Vote)</div>
        </div>
      <?php endforeach; ?>
    </div><!-- End Average Rating info -->
    <div class="clr"></div>
    <hr>
    <div class="compare_items">
      <div class="title main_title">
        Material and Safety
      </div>
      <?php foreach ($this->compare_list as $value): ?>
      <div class="compare_product disable_border_top">
        <div class="product_title">&nbsp;</div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Product detail info --> 
    <div class="clr"></div>
    <?php if (array_filter($this->detail_array['care_and_cleaning'])): ?>
    <div class="compare_items">
      <div class="title sub_title disable_border_top">
        - Care and cleaning
      </div>
      <?php foreach ($this->detail_array['care_and_cleaning'] as $key => $value): ?>
      <div class="compare_product disable_border_top">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['materials'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Material
      </div>
      <?php foreach ($this->detail_array['materials'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['material_safety'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Material safety
      </div>
      <?php foreach ($this->detail_array['material_safety'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['safety_features'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Safety features
      </div>
      <?php foreach ($this->detail_array['safety_features'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['product_texture'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Texture
      </div>
      <?php foreach ($this->detail_array['product_texture'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value ; ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <hr>
    <div class="compare_items">
      <div class="title main_title">
        Measures
      </div>
      <?php foreach ($this->compare_list as $value): ?>
      <div class="compare_product disable_border_top">
        <div class="product_title">&nbsp;</div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Product detail info -->
    <div class="clr"></div>

    <?php if ($this->detail_array['countweight'] > 0): ?>
    <div class="compare_items">
      <div class="title sub_title disable_border_top">
        - Weight (Product)
      </div>
      <?php foreach ($this->detail_array['weight'] as $key => $value): ?>
      <div class="compare_product disable_border_top">
        <div class="photo_title"><?php echo ($value > 0 ? $value : ''); ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Weight info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if ($this->detail_array['countheight'] > 0): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Height (Product)
      </div>
      <?php foreach ($this->detail_array['height'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo ($value > 0 ? $value : ''); ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if ($this->detail_array['countwidth'] > 0): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Width (Product)
      </div>
      <?php foreach ($this->detail_array['width'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo ($value > 0 ? $value : ''); ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if ($this->detail_array['countlength'] > 0): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Length (Product)
      </div>
      <?php foreach ($this->detail_array['length'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo ($value > 0 ? $value : ''); ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if ($this->detail_array['countinsertable_length'] > 0): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Insertable Length
      </div>
      <?php foreach ($this->detail_array['insertable_length'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo ($value > 0 ? $value : ''); ?> </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if ($this->detail_array['countcircumference'] > 0): ?>
    <div class="compare_items">
      <div class="title sub_title">
        - Circumference
      </div>
      <?php foreach ($this->detail_array['circumference'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo ($value > 0 ? $value : ''); ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if ($this->detail_array['countdiameter'] > 0): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Diameter (Product)
      </div>
      <?php foreach ($this->detail_array['diameter'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo ($value > 0 ? $value : ''); ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if (array_filter($this->detail_array['made_in'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Made in
      </div>
      <?php foreach ($this->detail_array['made_in'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['max_stretched_diameter'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Max stretched diameter
      </div>
      <?php foreach ($this->detail_array['max_stretched_diameter'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['product_size'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Size
      </div>
      <?php foreach ($this->detail_array['product_size'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['maximum_hip_size'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Maximum hip size
      </div>
      <?php foreach ($this->detail_array['maximum_hip_size'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['maximum_waist_size'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Maximum waist size
      </div>
      <?php foreach ($this->detail_array['maximum_waist_size'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['cup_size'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Cup Size
      </div>
      <?php foreach ($this->detail_array['cup_size'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['unstretched_diameter'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Unstretched diameter
      </div>
      <?php foreach ($this->detail_array['unstretched_diameter'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['inner_diameter'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Inner diameter
      </div>
      <?php foreach ($this->detail_array['inner_diameter'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <hr>
    <div class="compare_items">
      <div class="title main_title">
        Functionality
      </div>
      <?php foreach ($this->compare_list as $value): ?>
      <div class="compare_product disable_border_top">
        <div class="product_title">&nbsp;</div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Product detail info -->
    <div class="clr"></div>
    <?php if (array_filter($this->detail_array['control_type'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Control type
      </div>
      <?php foreach ($this->detail_array['control_type'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['product_functions'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Functions
      </div>
      <?php foreach ($this->detail_array['product_functions'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['harness_compatibility'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Harness compatibility
      </div>
      <?php foreach ($this->detail_array['harness_compatibility'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['powered_by'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Powered By
      </div>
      <?php foreach ($this->detail_array['powered_by'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>  
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['special_features'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Special features
      </div>
      <?php foreach ($this->detail_array['special_features'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['clitoral_attachment_shape'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Clitoral attachment shape
      </div>
      <?php foreach ($this->detail_array['clitoral_attachment_shape'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->detail_array['pump_mechanism'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Pump mechanism
      </div>
      <?php foreach ($this->detail_array['pump_mechanism'] as $key => $value): ?>
      <div class="compare_product">
        <div class="photo_title"><?php echo $value; ?></div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>
    <?php if (array_filter($this->review_array['average_customer']) && array_filter($this->review_array['top_highly_rated'])): ?>
    <hr>
    <div class="compare_items">
      <div class="title main_title">
        Product Reviews
      </div>
      <?php foreach ($this->compare_list as $value): ?>
      <div class="compare_product disable_border_top">
        <div class="product_title">&nbsp;</div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Product detail info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if (array_filter($this->review_array['average_customer'] )): ?>
    <div class="compare_items">
      <div class="title sub_title disable_border_top">
       - Average Customer
      </div>
      <?php foreach ($this->review_array['average_customer'] as $key => $value): ?>
      <div class="compare_product disable_border_top">
        <div class="photo_title">
          <?php if ($value):?>
          <span class="vote">
            <?php $ratingwidth = $value->rating * 15; ?>
            <span style="display:inline-block;" class="ratingbox" title=" Rating: <?php echo round($value->rating); ?>/5">
              <span style="width:<?php echo $ratingwidth; ?>px" class="stars-orange"></span>
            </span>
            <span>(<?php echo $value->ratingcount; ?> reviews)</span>
          </span>
          <?php else: ?>
            N/A
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if (array_filter($this->review_array['top_highly_rated'])): ?>
    <div class="compare_items">
      <div class="title sub_title">
       - Top 5 Highly Rated
      </div>
      <?php foreach ($this->review_array['top_highly_rated'] as $key => $highly_rated): ?>
      <div class="compare_product">
        <div class="photo_title highly_rated">
          <?php if ($highly_rated):?>
            <ul id="rated_review_<?php echo $key ?>"  class="jcarousel-skin-productcompare review_list">
              <?php foreach ($highly_rated as $k => $value): ?>
                <?php if ($value && $value->published):?>
                  <?php $ratingwidth = $value->vote * 10; ?>
                  <li>
                    <span class="comment_title"><?php echo $value->comment_title; ?></span>
                    <span class="commnet_author">
                      <span class="author_wapper"> by <span class="author"><?php echo $value->customer; ?></span></span>
                      <span style="display:inline-block;" class="ratingbox10" title=" Rating: <?php echo round($value->vote); ?>/5">
                        <span style="width:<?php echo $ratingwidth; ?>px" class="stars-orange10"></span>
                      </span>
                    </span>
                    <span class="commnet_content"><?php echo $value->comment; ?></span>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <div class="photo_title">&nbsp;</div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div><!-- End Brand info -->
    <div class="clr"></div>
    <?php endif; ?>

    <?php if (array_filter($this->video_array)): ?>
    <hr>
    <div class="compare_items" style="min-height: 159px">
      <div class="title main_title">
        Video Demo
      </div>

      <?php foreach ($this->video_array as $k => $videos): ?>
      <div class="compare_product disable_border_top">
        <?php if ($videos):?>
        <div class="product_title videos">
          <ul id="productcompare_videos_<?php echo $k ?>" class="jcarousel-skin-productcompare video_list">
            <?php foreach ($videos as $key => $value): ?>
              <li class="floatleft">
                  <a rel="{handler: 'iframe', size: {x: 520, y: 320}}" class="modal" href="view_videos.php?url=<?php echo $value->video_link;?>" target="_blank">
                  <img alt="" src="<?php echo $value->video_thumb; ?>">
                </a>
                <span><?php echo $value->video_title; ?></span>
              </li>
            <?php endforeach; ?>
            <div class="clear"></div>
          </ul>
        </div>
        <?php else: ?>
          <div class="product_title videos">&nbsp;</div>
        <?php endif;?>
      </div>
      <?php endforeach;?>
    </div><!-- End Product detail info -->
    <?php endif; ?>
    <div class="clr"></div>
    <div class="clr"></div>
    <div id="wishlist_mess_box" title=""></div>
    <div id="cart_mess_box" title=""></div>
  </div><!-- End .compare_content -->
  <?php else:?>
  <div style="height: 350px;color: #B00C97;">There are no items to compare</div>
  <?php endif; ?>
</div>
<style>
    div#contentwrapper
    {
        width: 100% !important;
        overflow: scroll;
    }
</style>