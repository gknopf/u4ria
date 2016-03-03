<?php
/**
*
* Show the products in a category
*
* @package	VirtueMart
* @subpackage
* @author RolandD
* @author Max Milbers
* @todo add pagination
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 4615 2011-11-07 17:54:37Z cleanshooter $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_( 'behavior.modal' );
/* javascript for list Slide
  Only here for the order list
  can be changed by the template maker
*/
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
";

$document = JFactory::getDocument();
$document->addScriptDeclaration($js);
$document->addStyleSheet('templates/' . $this->template . '/css/style.css');
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
}")


?>


<?php
/* Show child categories */

// Show child categories
if (!empty($this->products)) {
	$search='';
	if (!empty($this->keyword)) {
		$search ='&search=true&keyword='.$this->keyword;
		?>
		<h3><?php echo $this->keyword; ?></h3>
		<?php
	}
	?>

<?php // Category and Columns Counter
$iBrowseCol = 1;
$iBrowseProduct = 1;

// Calculating Products Per Row
$BrowseProducts_per_row = (empty($this->category->products_per_row)) ?  VmConfig::get('products_per_row',2) : $this->category->products_per_row;
$Browsecellwidth = ' width'.floor ( 100 / $BrowseProducts_per_row );

// Separator
$verticalseparator = " vertical-separator";
?>

<div class="browse-view">
	<div style="background:white; padding: 10px;">
	<h1><?php echo $this->category->category_name; ?><span> <?php echo $this->category->category_label; ?></span></h1>
	<div class="category_description">
	<?php echo $this->category->images[0]->displayMediaThumb("style=\"float:left\"",false);?> <?php echo $this->category->category_description ; ?>
	<div class="clr"></div>
	</div>
	</div>
	<div class="productlist">
	<!-- form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id ); ?>" method="post">
	<div class="orderby-displaynumber">
		<div class="width30 floatleft">
			<?php echo $this->pagination->getResultsCounter();?>
			<?php //echo $this->orderByList; ?>
		</div>
		<div class="centerpagenum floatleft display-number"><span class="floatleft"><?php echo JText::_('COM_PAGING');?>:</span> <?php echo $this->pagination->getPagesLinks(); ?> <?php //echo $this->pagination->getPagesCounter(); ?></div>
		<div id="bottom-pagination"><span style="float:right"><?php echo JText::_('JLIB_HTML_SHOW_OF') ?> <?php echo $this->pagination->getLimitBox();?> <?php echo JText::_('JLIB_HTML_PERPAGE') ?></span></div>
		<div class="clear"></div>
		<div style="border-top: solid 1px #000; padding-top: 5px">
			<div class="width30 floatleft">
				<strong>View as:</strong> <a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id . '&viewas=grid' ); ?>">Grid</a> | <a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id . '&viewas=list' ); ?>">List</a>
			</div>
			<div class="centerpagenum floatleft display-number"></div>
			<div id="bottom-pagination" class=" floatright"><strong>Sort by:</strong>
			<?php 
			$orderStatus = strtoupper ( JRequest::getWord ( 'order', 'ASC' ) );
			$orderBy = JRequest::getString ( 'orderby', VmConfig::get ( 'browse_orderby_field', 'p.virtuemart_product_id' ) );
			if ($orderBy == 'product_name' && $orderStatus == 'ASC')
				$selected = 1;
			else if ($orderBy == 'product_name' && $orderStatus == 'DESC')
				$selected = 2;
				
			if ($orderBy == 'pp.product_price' && $orderStatus == 'ASC')
				$selected = 3;
			else if ($orderBy == 'pp.product_price' && $orderStatus == 'DESC')
				$selected = 4;	
				
			?>
			<select name="orderby" onchange="location.href=this[this.selectedIndex].value;">
				<option value="">default</option>
				<option <?php if ($selected == 1) echo ' selected ';?> value="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id ); ?>?orderby=product_name&order=ASC">Product name a to z</option>
				<option <?php if ($selected == 2) echo ' selected ';?> value="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id ); ?>?orderby=product_name&order=DESC">Product name z to a</option>
				<option <?php if ($selected == 3) echo ' selected ';?> value="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id ); ?>?orderby=pp.product_price&order=ASC">Product price low to high</option>
				<option <?php if ($selected == 4) echo ' selected ';?> value="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id ); ?>?orderby=pp.product_price&order=DESC">Product price high to low</option>
			</select>
			</div>
		</div>
		<div class="clear"></div>
		
	</div>
	</form -->
<?php // Start the Output
if ($_GET['viewas'] != "")
	$_SESSION['viewas'] = $_GET['viewas'];
else 	
	$_SESSION['viewas']	= 'grid';
		
foreach ( $this->products as $product ) {

	// Show the horizontal seperator
	if ($iBrowseCol == 1 && $iBrowseProduct > $BrowseProducts_per_row) { ?>
	<!--  div class="horizontal-separator"></div-->
	<?php }

	// this is an indicator wether a row needs to be opened or not
	if ($iBrowseCol == 1) { ?>
	<div class="row">
	<?php }

	// Show the vertical seperator
	if ($iBrowseProduct == $BrowseProducts_per_row or $iBrowseProduct % $BrowseProducts_per_row == 0) {
		$show_vertical_separator = ' ';
	} else {
		$show_vertical_separator = $verticalseparator;
	}
		$class_last = '';
		if ($iBrowseCol == $BrowseProducts_per_row && $_SESSION['viewas']) {
			$class_last = 'last';
		}
		// Show Products 
	if ($_SESSION['viewas'] == 'grid')	
	{
	?>
		
		<div class="product floatleft<?php echo $Browsecellwidth . $show_vertical_separator ?>">
			<div class="spacer">
				<h2 class="center"><?php echo JHTML::link($product->link, $product->product_name); ?></h2>
				<div class="center">
					<?php /** @todo make image popup */
							echo $product->images[0]->displayMediaThumb('class="browseProductImage" border="0" title="'.$product->product_name.'" ',true,'class="modal"');
						?>

						<div class="contentpagetitle"><strong><?php echo JText::_('COM_VIRTUEMART_CUSTOMER_RATING') ?></strong></div>
						<?php
						$stars = '';	
						 for ($i=1; $i <= 5; $i++)
						 {
						 	if ($i <= $product->rating->rates && $product->rating->rates != 0)
						 		$stars .= '<span class="activestar"></span>';
					 		else 
					 			$stars .= '<span class="inactivestar"></span>';
						 }
						 echo '<div class="starblock">' . $stars . '</div>';
						 
						 $rating = empty($product->rating)? JText::_('COM_VIRTUEMART_UNRATED'):$product->rating->rates;
						 echo round($rating, 2) . " " . JText::_('COM_VIRTUEMART_TOTAL_VOTES'); ?><br /><br />
						 <div class="clear"></div>
						 <span class="contentpagetitle"><strong><?php echo JText::_('COM_VIRTUEMART_POPULARITY');?>:</strong></span>
						 <?php echo $product->lb_normal_text;?> 
						 <div class="clear"></div>

						<?php if (!VmConfig::get('use_as_catalog')){?>
						<div class="paddingtop8 center">
							<span class="vmicon vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
							<span class="stock-level"><?php echo JText::_('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
						<?php }?>
						
				</div>

				<div class="width100">
						<?php // Product Short Description
						if(!empty($product->product_s_desc)) { ?>
						<p class="product_s_desc">
						<?php echo $product->product_s_desc ?>
						</p>
						<?php } ?>

					<div class="product-price marginbottom12" id="productPrice<?php echo $product->virtuemart_product_id ?>">
					<?php
					if ($this->show_prices == '1') {
						$this->currency->displayProductPrice($product->prices);
					} ?>
					
					</div>
					<div class="wrap_buy_me">
						<?php if ($product->stock->stock_level != 'nostock'):?>
							<span class="btninstock">instock</span>
						<?php else:?>
							<span class="btnoutstock">outstock</span>
						<?php endif?>
						<a href="<?php echo $product->link;?>" class="btn2">buy me</a>
						
						<div class="clear"></div>
					</div>
					<div class="wrap_add_to">
						<a href="#<?php echo $product->virtuemart_product_id ?>" class="wishlist addtowishlist"><?php echo JText::_('MOD_VIRTUEMART_PRODUCT_ADD_TO_WISHLIST');?></a><span class="sperator"> | </span>
						<?php 						
							$my_array = $_SESSION['pid'];
							if ( in_array($product->virtuemart_product_id,$my_array)){
						?>
						<div id="add_compare<?php echo $product->virtuemart_product_id ?>" style="display:none">
						<a href="#" onclick="displayAjax('/u4ria/add.php?virtuemart_product_id=<?php echo $product->virtuemart_product_id?>');return false;" class="wishlist">						
						<?php echo JText::_('MOD_VIRTUEMART_PRODUCT_ADD_TO_COMPARE');?></a>
						</div>
						<div id="remove_compare<?php echo $product->virtuemart_product_id ?>" >
						<a href="#" onclick="displayAjax('/u4ria/add.php?virtuemart_product_id=<?php echo $product->virtuemart_product_id?>&remove=1');return false;" class="wishlist">						
						<?php echo JText::_('MOD_VIRTUEMART_PRODUCT_REMOVE_FROM_COMPARE');?></a>
						</div>
						<?php } 
						else { ?>
						<div id="add_compare<?php echo $product->virtuemart_product_id ?>">
						<a href="#" onclick="displayAjax('/u4ria/add.php?virtuemart_product_id=<?php echo $product->virtuemart_product_id?>');return false;" class="wishlist">						
						<?php echo JText::_('MOD_VIRTUEMART_PRODUCT_ADD_TO_COMPARE');?></a>
						</div>
						<div id="remove_compare<?php echo $product->virtuemart_product_id ?>" style="display:none">
						<a href="#" onclick="displayAjax('/u4ria/add.php?virtuemart_product_id=<?php echo $product->virtuemart_product_id?>&remove=1');return false;" class="wishlist">						
						<?php echo JText::_('MOD_VIRTUEMART_PRODUCT_REMOVE_FROM_COMPARE');?></a>
						</div>
						
						<?php } ?>
						
						
						</span></a>
					</div>
					<p class="productdetail">
					<ul class="progird_bot">
						<li>
							<a class="icon_r_star" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id . "&tag=R");?>">icon_r_star</a>
						</li>
						<li>
							<a class="icon_top50" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id . "&tag=T");?>">icon_top50</a>
						</li>
						<li>
							<a class="icon_star" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->category->virtuemart_category_id . "&tag=B");?>">icon_star</a>
						</li>
						<li>
							<a href="<?php echo $product->link;?>" class="icon_play" >icon_play</a>
						</li>
						<div class="clear"></div>	
					</ul>
					
					</p>	
					<p>
					<?php // Product Details Button
					echo JHTML::link($product->link, JText::_('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $product->product_name,'class' => 'product-details', 'target' => '_parent'));
					?>
					</p>

				</div>
			<div class="clear"></div>
			</div><!-- end of spacer -->
		</div> <!-- end of product -->
	<?php
	}
	
	$iBrowseProduct ++;

	// Do we need to close the current row now?
	if ($iBrowseCol == $BrowseProducts_per_row) { ?>
	<div class="clear"></div>
	</div>
		<?php
		$iBrowseCol = 1;
	} else {
		$iBrowseCol ++;
	}
}
// Do we need a final closing row tag?
if ($iBrowseCol != 1) { ?>
	<div class="clear"></div>
	</div>
<?php
}
?>
	<!-- div id="bottom-pagination"><?php echo $this->pagination->getPagesLinks(); ?><span style="float:right"><?php echo $this->pagination->getPagesCounter(); ?></span></div -->
	</div>
</div>
<?php } ?>
