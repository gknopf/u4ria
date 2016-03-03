<?php


//vmdebug('$this->category',$this->category);
vmdebug ('$this->category ' . $this->category->category_name);
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
jimport( 'joomla.html.html.tabs' );
/* javascript for list Slide
  Only here for the order list
  can be changed by the template maker
*/
$image = JURI::base().'components/com_virtuemart/assets/images/vmgeneral/avsgo-button.png' ;
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
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


/* Show child categories */

?>
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
	<div class="width50 floatleft">
		<?php echo $this->orderByList['orderby']; ?>
		<?php echo $this->orderByList['manufacturer']; ?>
	</div>
	<div class="width20 floatleft display-number">Show <?php echo $this->vmPagination->getLimitBox (); ?></div>
        <?php
        $search = JRequest::getBool("search");
        if(!$search):
        ?>
        <div class="top10bestseller"><a href="#"> Top 20 Best Seller</a></div>
        <?php endif; ?>
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

?>
      <?php echo $this->loadTemplate('grid'); ?>




<div class="vm-pagination"><?php echo $this->vmPagination->getPagesLinks (); ?><span style="float:right"><?php echo $this->vmPagination->getPagesCounter (); ?></span></div>

	<?php
} elseif ($this->search !== NULL) {
	echo JText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div><!-- end browse-view -->
<script>
    
jQuery("#virtuemart_manufacturercategories_id").change(function(){
    var selectedValue = jQuery(this).find(":selected").val();
  //  console.log("the value you selected: " + selectedValue);
        getBrand(selectedValue);
//    abc =  jQuery('#'+pos).html();
//    jQuery('#brand').text(abc);
//    jQuery('#typeofmanu').val(pos);    
//    jQuery('#mapop').hide();
//    localStorage['brand'] = abc;
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