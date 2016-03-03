<?php // no direct access
defined('_JEXEC') or die('Restricted access');
//$document = JFactory::getDocument();
//$document->addScriptDeclaration("
//	jQuery(document).ready(function($) {
//		$('a.catpopup').click( function(){
//			var popUrl = this.href;
//			$.facebox({
//				iframe: popUrl,
//				rev: 'iframe|550|980'
//			});
//			return false ;
//		});
//	
//	});
//");

JHTML::stylesheet ( 'menucss.css', 'modules/mod_virtuemart_category/css/', false );

?>


<?php
$i=1;
foreach ($categories as $category) {
		 $active_menu = 'class="VmClose"';
		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id );
		//$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$category->virtuemart_category_id.'&virtuemart_category_id='.$category->virtuemart_category_id.'&tmpl=component');
		
		$cattext = $category->category_name;
		//if ($active_category_id == $category->virtuemart_category_id) $active_menu = 'class="active"';
		?>
		<div class="mcathome <?php if ($i%3==0){?>homecat-outbound-last<?php } else { ?>homecat-outbound<?php }?>">		
			<div class="homecat">
				<div class="categoryimg">
				<a class="catpopup" href="<?php echo $caturl;?>">
					<?php
				    if (!empty($category->images)) {
					echo $category->images[0]->displayMediaThumb("", false);
				    }
				    ?>
					<?php //echo $category->images[0]->displayMediaThumb("",false);?>
					</a>
				</div>
				<div class="categoryname"><h2><a class="catpopup" href="<?php echo $caturl;?>"><?php echo $cattext;?></a></h2>
					<?php echo $category->category_label;?>
				</div>
			</div>
		</div>
		<?php
		$i++;
		} ?>
	<div class="clr"></div>	


