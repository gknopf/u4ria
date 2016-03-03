<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6530 2012-10-12 09:40:36Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// addon for joomla modal Box
JHTML::_('behavior.modal');

//vmJsApi::css('jquery.ui.theme','components/com_virtuemart/assets/css/ui');

// JHTML::_('behavior.tooltip');
$document = JFactory::getDocument();

$document->addScriptDeclaration("function displayAjax(myURL){
var postData ='';

	 jQuery.ajax({
    type: 'POST',
	    dataType: 'json',
	    data: postData,
	    beforeSend: function(x) {
	        if(x && x.overrideMimeType) {
	            x.overrideMimeType('application/json;charset=UTF-8');
	        }
	    },
	    url: myURL,
	    success: function(data) {
	        // 'data' is a JSON object which we can access directly.
	        // Evaluate the data.success member and do something appropriate...
			parent.document.getElementById('qty').innerHTML  = data.list;
			jQuery('#remove_compare'+data.pid).toggle();
			jQuery('#add_compare'+data.pid).toggle();
	    }
	});
}

");


if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}
?>
<?php echo $this->loadTemplate('alert'); ?>
   <script type="text/javascript" language="javascript">
    /*
   jQuery(document).ready(function() {
      jQuery("#addwl").click(function(event){
          jQuery('#wishlist').load('http://localhost:81/u4rianew/trunk/4_Implementation/u4ria/index.php?option=com_virtuemart&view=wishlist&task=addwishlist&&tmpl=component');
      });
   });
   */
 jQuery(document).ready(function(){

   jQuery(".product_info_tab").click(function(){
	   var tab_id = jQuery(this).attr("rel");
	   var disabled_tab = jQuery(this).hasClass("disabled_tab");

	   if (disabled_tab) {
		   return false;
	   }

	   jQuery('li.product_info_tab').removeClass('active');
	   jQuery(this).addClass('active');

	   jQuery('.content_tab').removeClass('active');
	   jQuery('.content_tab').addClass('unactive');
	   jQuery('#' + tab_id).removeClass('unactive');
	   jQuery('#' + tab_id).addClass('active');
   });

   jQuery("#view_size_chart").click(function(){
	   jQuery('li.product_info_tab').removeClass('active');
	   jQuery('li.size_chart').addClass('active');

	   jQuery('.content_tab').removeClass('active');
	   jQuery('.content_tab').addClass('unactive');
	   jQuery('#size_chart_tab').removeClass('unactive');
	   jQuery('#size_chart_tab').addClass('active');
	   jQuery('html, body').animate({scrollTop:jQuery('#size_chart_tab').position().top - 50}, 'slow');

   });

   jQuery(".nano").nanoScroller();
  });
   </script>
<div class="productdetails-view productdetails">

    <?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
	?>
        <div class="product-neighbours">
	    <?php
	    if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		echo JHTML::_('link', $prev_link, $this->product->neighbours ['previous'][0]
			['product_name'], array('class' => 'previous-page'));
	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('class' => 'next-page'));
	    }
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // Product Navigation END
    ?>

	<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME') ;
	}
	?>
	<div class="back-to-category">
    	<a href="<?php echo $catURL ?>" class="product-details" title="<?php echo $categoryName ?>"><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
	</div>




    <div id="product_top">
	<div id="product_image">
    <div class="general_code">
      <a id="general_code" href="javascript:void(0);" rel="<?php echo ('index.php?option=com_virtuemart&view=productdetails&task=generalcode&sku=' . $this->product->product_sku); ?>">Generate Product code >></a></div>
    <div id="product_image_wapper">
        <?php if(!empty($this->label)): ?>
            <div class="product_label"><img src="<?php echo $this->label->file_url ?>" /></div>
        <?php endif; ?>
      <?php echo $this->loadTemplate('images'); ?>
    </div>
    <div id="product_video">
      <?php echo $this->loadTemplate('videos'); ?>
    </div>
	</div>

	<div id="product_info">
      	   <?php
      	     jimport('joomla.application.module.helper');
              $mod = JModuleHelper::getModule('mod_breadcrumbs');
//              $mod->params    = "cols=2\nrows=10";
              $attribs['style'] = 'raw';
              echo JModuleHelper::renderModule($mod, $attribs);
            ?>

            <?php // Product Title   ?>
            <h1><?php echo $this->product->product_name ?></h1>
            <?php // Product Title END   ?>

            <?php // afterDisplayTitle Event
            echo $this->product->event->afterDisplayTitle ?>

            <?php
            // Product Edit Link
            echo $this->edit_link;
            // Product Edit Link END
            ?>

            <div class="spacer-buy-area">
            <div class="product_main_info">

		<?php
		if ($this->showRating) {
		    $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);

		    if (empty($this->rating)) {
			?>
			<span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
			    <?php
			} else {
			    $ratingwidth = $this->rating->rating * 15; //I don't use round as percetntage with works perfect, as for me
			    ?>
			<span class="vote">
	<?php echo JText::_('COM_VIRTUEMART_RATING'); ?>
			    <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($this->rating->rating) . '/' . $maxrating) ?>" class="ratingbox" style="display:inline-block;">
				<span class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>">
				</span>
			    </span>
			    <span>(<?php echo $this->rating->ratingcount;?> reviews)</span>
			</span>
			<?php
		    }
		}
                ?>
                        <div>
                            <span>Click <a href="<?php echo JURI::getInstance()->toString().'#reviewform'?>" class="click_here">HERE</a> to add your review to earn $50 voucher</span>
                        </div>
                        <?php
                // Call Average Rating
                echo $this->loadTemplate('average_rating'); ?>

                        <div class="product_top">
                            <div class="Product_top_lable"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_POPULARITY').':' ?></div>
                            <div class="Product_top_value">
                            <?php
                            if($this->product->product_top50 && $this->product->product_top100)
                                $topshow = "TOP 50 - TOP 100";
                            elseif ($this->product->product_top50)
                                $topshow = "TOP 50";
                            elseif($this->product->product_top100)
                                $topshow = "TOP 100";
                            echo $topshow
                            ?>
                            </div>
                            <a  href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=pricematch&pid='.$this->product->virtuemart_product_id); ?>" class="price_match" title="<?php echo JText::_('PRICE_MATCH') ?>">
                              <img src="templates/altalab/images/pricematch.jpg" alt="Price Match" title="Price Match"/>&nbsp;&nbsp;
                           </a>
                            <div class="clr"></div>
                        </div>

                <?php
		if (is_array($this->productDisplayShipments)) {
		    foreach ($this->productDisplayShipments as $productDisplayShipment) {
			echo $productDisplayShipment . '<br />';
		    }
		}
		if (is_array($this->productDisplayPayments)) {
		    foreach ($this->productDisplayPayments as $productDisplayPayment) {
			echo $productDisplayPayment . '<br />';
		    }
		}
		// Product Price
		    // the test is done in show_prices
		//if ($this->show_prices and (empty($this->product->images[0]) or $this->product->images[0]->file_is_downloadable == 0)) {
		    echo $this->loadTemplate('showprices');
		//}
		?>
    <div class="price_and_point">
        <span class="points_earn">
        With this purcharse, You earn <?php if ($this->product->prices['memberPrice']):  echo $this->product->prices['memberPrice'];?> <?php else: echo $this->product->prices['salesPrice']; ?> <?php endif; ?> Royalty Reward Points
        </span>
    </div>
                        <?php if ($this->size_color_list): ?>
                        <div class="product_option">
                            <div class="color_size_title">Select Size/Colour/Variety</div>
                        <div class="color_size_wapper ">
                            <div class="nano">
                                <div class="content">
                                    <div>
                                    <?php foreach ($this->size_color_list as $key => $value): ?>
                                      <div class="color_size">
                                        <span class="color_size_name add_size_price" rel="<?php echo $key; ?>" alt="<?php echo $value['custom_value']; ?>"><?php echo $value['custom_value']; ?></span>
                                        <span class="color_size_price add_size_price" rel="<?php echo $key; ?>" alt="<?php echo $value['custom_value']; ?>" >+S$<?php echo $value['custom_price']; ?></span>
                                      </div>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <?php endif; ?>
                        <div class="clr"></div>
                        </div>
		<?php
		// Add To Cart Button
// 			if (!empty($this->product->prices) and !empty($this->product->images[0]) and $this->product->images[0]->file_is_downloadable==0 ) {
//		if (!VmConfig::get('use_as_catalog', 0) and !empty($this->product->prices['salesPrice'])) {
		    echo $this->loadTemplate('addtocart');
//		}  // Add To Cart Button END
		?>
    <?php if ($this->size_list): ?>
      <div class="view_size_chart_wapper"><div class="view_size_chart" id="view_size_chart">View size chart now >></div></div>
    <?php endif; ?>
    <div class="clr"></div>
		<?php
		// Availability Image
		$stockhandle = VmConfig::get('stockhandle', 'none');
		if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
			if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
			?>	<div class="availability">
			    <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : VmConfig::get('rised_availability'); ?>
			</div>
		    <?php
			} else if (!empty($this->product->product_availability)) {
			?>
			<div class="availability">
			<?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : $this->product->product_availability; ?>
			</div>
			<?php
			}
		}
		?>

                <?php
                // Ask a question about this product
                if (VmConfig::get('ask_question', 1) == 1) {
                    ?>
    		<div class="ask-a-question">
    		    <a class="ask-a-question" href="<?php echo $this->askquestion_url ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
    		    <!--<a class="ask-a-question modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php //echo $this->askquestion_url ?>"><?php //echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>-->
    		</div>
		<?php }
		?>

		<?php
		// Manufacturer of the Product
		if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
		    echo $this->loadTemplate('manufacturer');
		}
		?>

	    </div>

            <div id="product_morelink">
                <div id="add_wishlist_wapper" class="add_compares <?php if (in_array($this->product->virtuemart_product_id, $this->wishlist_list)): echo 'unactive'; endif; ?>">
                  <img class="add_compare_icon" border="0" alt="Add to wishlist" title="Add to Wishlist" src="images/wishlist.jpg" width="30px">
                  <!-- <input type="button" id="addwl" value="Add to wishlist" /> -->
                  <a href="javascript:void(0);" id="add_wishlist" title="Add to Wishlist"> Add to Wishlist</a>
                </div>
                <div id="remove_wishlist_wapper" class="add_compares <?php if (!in_array($this->product->virtuemart_product_id, $this->wishlist_list)): echo 'unactive'; endif; ?>">
                  <img class="add_compare_icon" border="0" alt="Remove from wishlist" title="Remove from Wishlist" src="<?php echo $this->baseurl ?>/templates/altalab/images/wishlist_remove.jpg" width="30px">
                  <a href="javascript:void(0);" id="remove_wishlist" title="Remove from Wishlist"> Remove from Wishlist</a>
                </div>
                <?php
                        $compare_list = $_SESSION['compare_list'];
                        $in_compare_flag = FALSE;

                        if(is_array($compare_list) ):
                          if ( in_array($this->product->virtuemart_product_id, $compare_list)):
                             $in_compare_flag = TRUE;
                          endif;
                        endif;
                ?>
                <div id="socialshare">
                    <div class="addthis_toolbox addthis_default_style addthis_16x16_style">
                    <a class="addthis_button_facebook"></a>
                    <a class="addthis_button_google_plusone_share"></a>
                    <a class="addthis_button_linkedin"></a>
                    <a class="addthis_button_twitter"></a>
                    <a class="addthis_button_pinterest_share"></a>
                    <a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a>
                    </div>
                </div>
                <div id="add_compare" class="add_compares <?php if ($in_compare_flag): echo 'unactive'; endif; ?>">
                  <img class="add_compare_icon" border="0" alt="Add to Comparison" src="templates/altalab/images/comparison.jpg" width="30px" title="Add to Comparison">
                  <a href="javascript:void(0);" onclick="add_compare(<?php echo $this->product->virtuemart_product_id; ?>)" class="wishlist" title="Add to Comparison">Add to Comparison</a>
                </div>

                <div id="remove_compare" class="add_compares <?php if (!$in_compare_flag): echo 'unactive'; endif; ?>" >
                  <img class="add_compare_icon" border="0" alt="Remove from Comparison" title="Remove from Comparison" src="templates/altalab/images/comparison_remove.jpg" width="30px">
                  <a href="javascript:void(0);" onclick="remove_compare(<?php echo $this->product->virtuemart_product_id; ?>)"  class="wishlist" title="Remove from Comparison">Remove from Comparison</a>
                </div>
                <div class="add_compares">
                  <img class="add_compare_icon" border="0" alt="set product alert" title="set product alert" src="images/alert.jpg" width="30px">
                  <a id="opener" href="javascript:void(0);" title="Set Product Alert"> Set Product Alert</a>
                </div>
                <div class="clr"></div>
            </div>

	</div>

    </div>

    <div class="clr"></div>
    <div id="product_added">
        <div class="related_wapper">
           <div class="related_wapper_title">
             <div class="colum1">Top 5 products added on when customers bought this product:</div>
             <div class="colum2">Special deals purchased with this product:</div>
             <div class="colum3">Items added for better Expenrience:</div>
             <div class="clr"></div>
           </div>
           <div class="related_wapper_content">
             <div class="colum1">
              <?php
              // Product Files
              // foreach ($this->product->images as $fkey => $file) {
              // Todo add downloadable files again
              // if( $file->filesize > 0.5) $filesize_display = ' ('. number_format($file->filesize, 2,',','.')." MB)";
              // else $filesize_display = ' ('. number_format($file->filesize*1024, 2,',','.')." KB)";

              /* Show pdf in a new Window, other file types will be offered as download */
              // $target = stristr($file->file_mimetype, "pdf") ? "_blank" : "_self";
              // $link = JRoute::_('index.php?view=productdetails&task=getfile&virtuemart_media_id='.$file->virtuemart_media_id.'&virtuemart_product_id='.$this->product->virtuemart_product_id);
              // echo JHTMl::_('link', $link, $file->file_title.$filesize_display, array('target' => $target));
              // }
              if (!empty($this->product->customfieldsRelatedProducts))
                  echo $this->loadTemplate('relatedproducts');
              ?>
              </div>
             <div class="colum2">
               <?php echo $this->loadTemplate('special_deal_products'); ?>
               <div class="clr"></div>
             </div>
             <div class="colum3">
               <?php echo $this->loadTemplate('suggestionproducts'); ?>
               <div class="clr"></div>
             </div>
             <div class="clr"></div>
           </div>
           <div class="clr"></div>
        </div>
  <?php

        if (!empty($this->product->customfieldsSorted['onbot'])) {
            $this->position='onbot';
            echo $this->loadTemplate('customfields');
        } // Product Custom ontop end
        ?>
    </div>
    <div class="clr"></div>
    <div id="product_desc">
        <?php

        if (!empty($this->product->customfieldsSorted['ontop'])) {
            $this->position = 'ontop';
            echo $this->loadTemplate('customfields');
        } // Product Custom ontop end

        echo $this->product->event->beforeDisplayContent; ?>

  	<?php if (!empty($this->product->product_desc)): ?>
      <div class="product-description">
        <span class="title"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></span>
        <?php echo $this->product->product_desc; ?>
      </div>
  	<?php endif; ?>

    <div class="desc_extra_wapper">
      <ul class="title">
        <li class="product_info_tab active" rel="product_features_tab">Product Features:</li>
        <li class="product_info_tab" rel="product_detail_tab">Product Details:</li>
        <li class="product_info_tab" rel="product_brand_tab">Product Brand:</li>
        <li class="product_info_tab" rel="product_feedback_tab">Product Feedback:</li>
        <li class="product_info_tab size_chart <?php if (!$this->size_list): ?>disabled_tab<?php endif; ?>" rel="size_chart_tab">Size Chart:</li>
      </ul>
      <div class="content">
        <div class="active content_tab" id="product_features_tab">
           <?php echo $this->product->product_feature; ?>
           <div class="clr"></div>
        </div>
        <div class="unactive content_tab"  id="product_detail_tab">
          <?php echo $this->product->product_detail; ?>
<!--            <ul>-->
<!--              --><?php //if ($this->product->customfieldsCart): ?>
<!--                --><?php //foreach ($this->product->customfieldsCart as $customfields): ?>
<!--                  <li>-->
<!--                    --><?php //echo $customfields->custom_title; ?><!-- (Product):-->
<!--                    --><?php //if ($customfields->options): ?>
<!--                      --><?php //$temp =array(); ?>
<!--                      --><?php //foreach ($customfields->options as $key => $options): ?>
<!--                        --><?php //$temp[] = $options->custom_value; ?>
<!--                      --><?php //endforeach;?>
<!--                      --><?php //echo implode('; ', $temp); ?>
<!--                    --><?php //endif; ?>
<!--                  </li>-->
<!--                --><?php //endforeach;?>
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->product_weight > 0): ?>
<!--              <li>Weight (Product): --><?php //echo  $this->currency->convertUnit($this->product->product_weight, $this->product->product_weight_uom); ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->product_height > 0): ?>
<!--              <li>Height (Product): --><?php //echo  $this->currency->convertUnit($this->product->product_height, $this->product->product_lwh_uom); ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->product_width > 0): ?>
<!--              <li>Width (Product): --><?php //echo  $this->currency->convertUnit($this->product->product_width, $this->product->product_lwh_uom); ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->product_length > 0): ?>
<!--              <li>Length (Product): --><?php //echo  $this->currency->convertUnit($this->product->product_length, $this->product->product_lwh_uom); ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->insertable_length > 0): ?>
<!--              <li>Insertable Length: --><?php //echo  $this->currency->convertUnit($this->product->insertable_length, $this->product->product_lwh_uom); ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->circumference > 0): ?>
<!--              <li>Circumference : --><?php //echo  $this->currency->convertUnit($this->product->circumference, $this->product->product_lwh_uom); ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->diameter > 0): ?>
<!--              <li>Diameter (Product): --><?php //echo  $this->currency->convertUnit($this->product->diameter, $this->product->product_lwh_uom); ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->materials != ''): ?>
<!--              <li>Materials (Product): --><?php //echo $this->product->materials ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--              --><?php //if ($this->product->made_in != ''): ?>
<!--              <li>Made in: --><?php //echo $this->product->made_in ?><!--</li>-->
<!--              --><?php //endif; ?>
<!--            </ul>-->
          <div class="clr"></div>
        </div>
        <div class="unactive content_tab" id="product_brand_tab">
          <?php echo $this->product->mf_desc; ?>
          <div class="clr"></div>
        </div>
        <div class="unactive content_tab" id="product_feedback_tab">
            <?php echo $this->product->feedback; ?>
        </div>
        <div class="unactive content_tab" id="size_chart_tab">
          <?php echo $this->loadTemplate('size_chart'); ?>
        </div>
      </div>
    </div>
        <?php if (!empty($this->product->customfieldsSorted['normal'])):
           $this->position = 'normal';
            echo $this->loadTemplate('customfields');
         endif; ?>

        <?php // event onContentBeforeDisplay

        // Product Packaging
        $product_packaging = '';
        if ($this->product->product_box) {
            ?>
            <div class="product-box">
                <?php
                    echo JText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
                ?>
            </div>
        <?php } // Product Packaging END
        ?>

    </div>
    <div class="clr"></div>
    <div id="product_review">
        <?php
        echo $this->loadTemplate('reviews');
        ?>
    </div>
    <?php  echo $this->loadTemplate('topcompare'); ?>
    <div class="clr"></div>
<div id="general_code_mess_box" title="Code Generator"></div>
<?php // onContentAfterDisplay event
echo $this->product->event->afterDisplayContent; ?>
</div>

<style>
    div#contentwrapper
    {
        width: 80% !important;
    }
    @media only screen and (max-width: 1111px) {
        div#contentwrapper
        {
            width: 100% !important;
        }
    }
</style>