<?php
$urlcurrent =  JURI::current();
$check1=strpos($urlcurrent,"vibrators");
$check2=strpos($urlcurrent,"lubes");
$check3=strpos($urlcurrent,"men-s-sextoy");
$check4=strpos($urlcurrent,"sexy-wear");
$check5=strpos($urlcurrent,"masturbators");
$check6=strpos($urlcurrent,"others");
$check7=strpos($urlcurrent,"new");
$check8=strpos($urlcurrent,"clearance");
$check9=strpos($urlcurrent,"promotion");
if($check1!=false ||$check2!=false ||$check3!=false ||$check4!=false ||$check5!=false ||$check6!=false ||$check7!=false ||$check8!=false ||$check9!=false )
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $('div#rightcolumn').remove();
            $('div#contentcolumn-leftright').css("width","100%");
        });
    </script>
<?php }?>
<?php
defined ('_JEXEC') or die('Restricted access');

//print_r($this->products);die();

//vmdebug('$this->category',$this->category);
vmdebug ('$this->category ' . $this->category->category_name);
// Check to ensure this file is included in Joomla!

jimport( 'joomla.html.html.tabs' );
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('product_alert');
/* javascript for list Slide
  Only here for the order list
  can be changed by the template maker
*/

$limitpp = JRequest::getVar('limit');
if(!empty($limitpp)) $lshow = 'limit='.$limitpp;
//if(!empty($limitpp)) $lshow = $limitpp.' Items Per Page';
$image = JURI::base().'components/com_virtuemart/assets/images/vmgeneral/avsgo-button.png' ;
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	);

});
";
$document = JFactory::getDocument ();
$document->addScriptDeclaration ($js);
//print_r($this->product_config);
?>
<?php
/*$edit_link = '';
if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
if (Permissions::getInstance()->check("admin,storeadmin")) {
	$edit_link = '<a href="'.JURI::root().'index.php?option=com_virtuemart&tmpl=component&view=category&task=edit&virtuemart_category_id='.$this->category->virtuemart_category_id.'">
		'.JHTML::_('image', 'images/M_images/edit.png', JText::_('COM_VIRTUEMART_PRODUCT_FORM_EDIT_PRODUCT'), array('width' => 16, 'height' => 16, 'border' => 0)).'</a>';
}

echo $edit_link; */
//echo "<pre>";
//print_r($this->category);
//echo "</pre>";



$searchif = TRUE; 
if ($this->smod) $searchif = FALSE; 
if ($this->fdate) $searchif = FALSE;
$mafu = JRequest::getVar('virtuemart_manufacturer_id');
$mafucat = JRequest::getVar('virtuemart_manufacturercat_id');
$app = JFactory::getApplication();
$pathway = $app->getPathway();
if(!empty($mafucat)){
    $model = VmModel::getModel('Manufacturercategories');
    $this->category->productcount = $model->countProductsMcat($mafucat);
    $cmfinfo = $model->getMafuCatInfo($mafucat);
    $this->category->category_name = 'Product From Manufacturer '.$cmfinfo->mf_category_name;
    $this->category->category_description = $cmfinfo->mf_category_desc;
    $this->topbestseller->id = $model->getManuTopBestCategory($mafucat);
    $pathway->addItem($cmfinfo->mf_category_name);
    
}
if(!empty($mafu)){
    $model = VmModel::getModel('Manufacturer');
    $this->category->productcount = $model->countProducts($mafu);
    $cmfinfo = $model->getBrandInfo($mafu);
    $this->category->category_name = 'Product From Brand '.$cmfinfo->mf_name;
    $this->category->category_description = $cmfinfo->mf_desc;
    $this->topbestseller->id = $model->getBrandTopBestCategory($mafu);
    $pathway->addItem($cmfinfo->mf_name);
}

if ($searchif) {
	?>
<div class="category_description category_lv3">
	<div class="category-img">
            <?php
                echo '<div class="category_imgbox">'.$this->category->images[0]->displayMediaThumb ("", FALSE).'</div>';
            ?>
            <?php echo "<div class=\"mark\"></div>" ?>
            <?php echo "<div class=\"totalincat\">".$this->category->category_name."(".$this->category->productcount.")</div>" ?>
        </div>
            <div class="category-title">
                <?php if(!empty($this->category->catagory_short_des)) $this->category->catagory_short_des = ' - '.$this->category->catagory_short_des;
                else
                    $this->category->catagory_short_des = '';
                ?>
                <?php echo $this->category->category_name.$this->category->catagory_short_des ?>
            </div>
                <?php echo $this->category->category_description;  ?>
        <br class="clr">
</div>
<?php
}

/* Show child categories */

if (VmConfig::get ('showCategory', 1) and empty($this->keyword) and !$this->smod and !$this->fdate and empty($mafu) and empty($mafucat)) {
	if ($this->category->haschildren) {

		// Category and Columns Counter
		$iCol = 1;
		$iCategory = 1;

		// Calculating Categories Per Row
		$categories_per_row = VmConfig::get ('categories_per_row', 3);
		$category_cellwidth = ' width' . floor (100 / $categories_per_row);

		// Separator
		$verticalseparator = " vertical-separator";
		?>

		<div class="category-view">

		<?php // Start the Output

		if (!empty($this->category->children)) {
			foreach ($this->category->children as $category) {

				// Show the horizontal seperator
				if ($iCol == 1 && $iCategory > $categories_per_row) {
					?>
					<div class="horizontal-separator"></div>
					<?php
				}

				// this is an indicator wether a row needs to be opened or not
				if ($iCol == 1) {
//                                echo "<pre>";    print_r($category);
//                                echo "</pre>";
                                    ?>

			<div class="row">
			<?php
				}

				// Show the vertical seperator
				if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
					$show_vertical_separator = ' ';
				} else {
					$show_vertical_separator = $verticalseparator;
				}

				// Category Link
				$caturl = JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id);

				// Show Category
				?>
				<div class="category floatleft<?php echo $category_cellwidth . $show_vertical_separator ?>">
					<div class="spacer">
                                            <div class="cattitle_lv2">
						<h2>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
								<?php echo $category->category_name ?>
								<br/>
							</a>
                                                </h2>
                                                <?php echo "<span class=\"totalitem\">(Total ".$category->productcount." items)</span>" ?>
                                             </div>



					</div>
                                    <div class="subcat">
                                        <?php
                                          foreach ($category->children as $child) {
                                          $caturl3 = JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $child->virtuemart_category_id);
//                                foreach ($child->images[0] as $value) {
//                                    $img[]=$value;
//                                }
//                                echo $img[12];
//                                echo "<pre>";    print_r($child->images);
//                                echo "</pre>";
//                               echo  $child->images[0]->file_url;
                                              ?>
                                        <div class="catsub_lv3">
                                          <div class="cattitle_lv3">
                                          <div class="cattitle_lv3_2">
							<a href="<?php echo $caturl3 ?>" title="<?php echo $child->category_name ?>">
								<?php
                                                                    if($child->images['0']->file_url_thumb)
                                                                        echo '<img src="'.$child->images['0']->file_url_thumb.'"/>';
                                                                    else
                                                                        echo '<img src="components/com_virtuemart/assets/images/vmgeneral/noimage.gif"/>';
								 ?>
							</a>
                                              <div class="subtitle_bottom">
                                                  <a href="<?php echo $caturl3 ?>" title="<?php echo $child->category_name ?>">
                                                          <?php echo $child->category_name ?><?php echo "<span>(".$child->productcount.")" ?>
                                                          <br/>
                                                  </a>
                                              </div>

                                           </div>
                                           </div>
                                        </div>

                                      <?php    } ?>
                                    <div class="clear"></div>

                                    </div>
                                    <div class="clear"></div>
				</div>
				<?php
				$iCategory++;

				// Do we need to close the current row now?
				if ($iCol == $categories_per_row) {
					?>
					<div class="clear"></div>
		</div>
			<?php
					$iCol = 1;
				} else {
					$iCol++;
				}

			}


		}
		// Do we need a final closing row tag?
		if ($iCol != 1) {
			?>
			<div class="clear"></div>
		</div>
	<?php } ?>
	</div>

	<?php
	}
}
?>
        <?php
if ($this->smod) {
	?>
        <div class="avhead"><?php if(empty($this->titleCategoryMonth)){
        echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH'); }else{
            echo $this->titleCategoryMonth;
        }
                        ?></div>
	<?php
} ?>
<?php if(!$this->fdate){ ?>
<?php if ($this->search !== NULL || $this->smod) { ?>
<?php if($this->searchtype) $this->keyword = htmlentities(trim(JRequest::getVar('keyword')));?>
<div class="vs">

<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0'); ?>" method="get">
<table>
	<tr>
            <td colspan="3"  class="keylable"><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_KEY'); ?></td>
        </tr>
        <tr>
            <td colspan="3">
                 <input name="keyword" class="inputbox" type="text" size="20" value="<?php echo htmlentities(trim(JRequest::getVar('keyword'))); ?>"/>
            </td>
	</tr>
        <tr>
            <td width="110px"><?php echo JText::_ ('Search by Product Code'); ?></td>
            <td><input type="text" name="sku"  style="width:50%"  value="<?php echo $this->sku; ?>"/></td>
            <td class="boxText sd">
               <a  class="help_popup" >Search help[?]</a>
            </td>
        </tr>
        <tr>
            <td  width="80px"><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_CAT'); ?></td>
            <td>
           <?php

                echo "<select name=\"category\" style=\"vertical-align :middle;display:block;width:50%\">";
                echo '<option value="">All Categories:</option>';

                foreach ($this->categories as $category ) {
                        echo '<option  value="'.$category->virtuemart_category_id.'" '.$category->curent.'>'.$category->category_name.'('.$category->productcount.')</option>';
                        if ($category->childs ) {
                                foreach ($category->childs as $child) {
                                        echo '<option  value="'.$child->virtuemart_category_id.'"  '.$child->curent.'>&nbsp; &nbsp; &nbsp;'.$child->category_name.'('.$child->productcount.')</option>';
                                        if($child->childs){
                                            foreach ($child->childs as $ch) {
                                                               echo '<option  value="'.$ch->virtuemart_category_id.'" '.$ch->curent.'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'.$ch->category_name.'('.$ch->productcount.')</option>';
                                            }
                                        }
                                }

                        }
                }
                echo "</select>";

            ?>

            </td>
                        <td align="right"  class="boxText sd">
                            <!--<a  class="help_popup" href="JavaScript:newWindow('index.php?option=com_content&view=article&id=36&tmpl=component&task=preview')">Search help[?]</a>-->
                        </td>

        </tr>
        <tr>
            <td></td>
                <td align="left" colspan="3" class="boxText">
                    <input type="checkbox" name="sinsub" value="checked" <?php echo $this->sinsub; ?>><span class="cfi">  <?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_INSUB'); ?></span>
                </td>
            <td></td>
        </tr>
<!--        <tr>
            <td><?php // echo JText::_ ('Manufacturer'); ?></td>
            <td>
                <?php
//                    echo '<div id="manufacturer" class="manufacturer"> -- Select Manufacturer -- </div>';
//                    echo $this->amafu;
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td><?php // echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_MANUFA'); ?></td>
            <td>
                <?php
//                    echo $this->manufacturer; echo '<span id="bload"></span>';
                ?>
            </td>
            <td></td>
        </tr>-->
        <tr>
            <td><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_PRICE_FROM'); ?></td>
            <td><input type="text" name="pricefrom" style="width:50%" value="<?php echo $this->ip_pricefrom; ?>" /></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_PRICE_TO'); ?></td>
            <td><input type="text" name="priceto"  style="width:50%"  value="<?php echo $this->ip_priceto; ?>"/></td>
            <td></td>
        </tr>
        <tr>
            <td><input type="image"  src="<?php echo $image?>" class="" value="Go" style="vertical-align :middle;"></td>

            <td></td>
            <td></td>

        </tr>

</table>
    <input type="hidden" name="view" value="category"/>
    <input type="hidden" name="option" value="com_virtuemart"/>
    <input type="hidden" name="search" value="true"/>
</form>
</div>
<!-- End Search Box -->
	<?php } ?>
	<?php } ?>
<div class="browse-view">


<?php // Show child categories
if (!empty($this->products)) {
	?>
<div class="orderby-displaynumber">
	<div class="vm-pagination">
                <span class="left">
                <?php echo $this->vmPagination->getResultsCounter ("COM_VIRTUEMART_ADVANCED_RESULTS_OF");?>
                </span>
		<?php echo $this->vmPagination->getPagesLinks (); ?>
		<span class="left" style="float:right"><?php echo $this->vmPagination->getPagesCounter (); ?></span>
	</div>
    <?php if($this->category->top10bs == 0 && $this->category->virtuemart_category_id != 47){ ?>
    <div class="width50 floatleft">
		<?php echo $this->orderByList['orderby']; ?>
		<?php echo $this->orderByList['manufacturer']; ?>
	</div>
	<div class="width30 floatleft display-number">Show <?php echo $this->vmPagination->getLimitBox (); ?></div>
        <?php
        $search = JRequest::getBool("search");
        if(!$search AND $this->category->top10bs != 1 and $this->category->top_for_manufacturer != 1 and $this->category->top_for_brand != 1 and !empty($this->topbestseller->id)):

                $topbest = JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $this->topbestseller->id.'&action=topitems');

        ?>
        <div class="top10bestseller"><a href="<?php echo $topbest ?>"> Top 20 Best Seller</a></div>
        <?php endif; ?>
    <?php }?>
         
    <div class="width100 floatleft" style="padding-top: 20px; width: 100%">
        <?php if($this->category->virtuemart_category_id != 47){ ?>
            <label>Kindly be noted that the products in this page are ordered from left to right, top to bottom; with the top right product be our first and bottom left be our last ordered product</label>
	<?php }?>
    </div>	
        
	<div class="clear"></div>
</div> <!-- end of orderby-displaynumber -->
<?php
// Star display view Grid and List
$options = array(
    'onActive' => 'function(title, description){
        description.setStyle("display", "block");
        title.addClass("open").removeClass("closed");
    }',
    'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',
    'startOffset' => 0,  // 0 starts on the first tab, 1 starts the second, etc...
    'useCookie' => true, // this must not be a string. Don't use quotes.
);

        echo "<div class=\"view_lable\">View as</div> ";
        echo JHtml::_('tabs.start', 'tab_group', $options);
        echo JHtml::_('tabs.panel', JText::_('Grid'), 'panel_1_id'); ?>
      <?php echo $this->loadTemplate('grid'); ?>
      <?php  echo JHtml::_('tabs.panel', JText::_('List'), 'panel_2_id'); ?>
      <?php echo $this->loadTemplate('list'); ?>
      <?php echo JHtml::_('tabs.end');

        ?>

<div class="vm-pagination"><?php echo $this->vmPagination->getPagesLinks (); ?><span style="float:right"><?php echo $this->vmPagination->getPagesCounter (); ?></span></div>

	<?php
} elseif ($this->search !== NULL) {
	echo JText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div><!-- end browse-view -->
<script>
jQuery(document).ready(function() {
        jQuery(function() {
            jQuery("option[value*='<?php echo $lshow ?>']").attr('selected', 'selected');
        });
});

jQuery("#virtuemart_manufacturercategories_id").change(function(){
    var selectedValue = jQuery(this).find(":selected").val();
        getBrand(selectedValue);

});
function getBrand(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=category&task=getbrand";
    var parameter = {manufacturercat_id:id};
    jQuery('#bload').addClass('bload');
    jQuery.post(url, parameter, function(res) {
        jQuery('#bload').removeClass('bload');
        jQuery('#virtuemart_manufacturer_id').html(res);
    });
}
jQuery('#manufacturer').click(function(){
    jQuery('.mafulist').toggle();
});
</script>
<script>
        var url = "<?php echo JURI::base() ?>" + "index.php?option=com_content&view=article&id=36&tmpl=component&task=preview";
        var jhelp = jQuery.noConflict();
        jhelp(document).ready(function(){
           jhelp('.vs').append('<div id="help_popup" title="Welcome to U4ria Advanced Search!"></div>');
        });

        jhelp('.help_popup').click(function(){


        jhelp.post(url,{},function(res){
                jhelp('#help_popup').dialog({
                    autoOpen: false,
                    modal: true,
                    width: 750,
                    height: 325
                });
                jhelp('#help_popup').html(res);
                jhelp('#help_popup').dialog('open');
            });
        });
</script>
<style type="text/css">
    .notify_me{
        border: 1px solid #8E0B7C;border-radius: 0 27px 27px 0;
float: left;
font: bold 12px arial;
padding: 2px 4px;
width: 60px;
height: 15px;
background: #F4F4F6;
margin: 0 0 0 10px;
}
    @media only screen and (min-width: 901px) {
        div#contentwrapper
        {
            width: 80% !important;
        }
    }
    @media only screen and (max-width: 1111px) {
        div#contentwrapper
        {
            width: 100% !important;
        }
    }

</style>