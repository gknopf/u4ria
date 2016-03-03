
<?php

defined('_JEXEC') or die('Restricted access');
/* Load the virtuemart main parse code */

		
		define('VM1', false); 
		define('VM2', true); 
		


{
 $image = JURI::base().'components/com_virtuemart/assets/images/vmgeneral/go-button.png' ;

 // load virtuemart language files
 $jlang =JFactory::getLanguage();
 $jlang->load('com_virtuemart', JPATH_SITE, $jlang->getDefault(), true);
 $jlang->load('com_virtuemart', JPATH_SITE, null, true);
}



$lang =& JFactory::getLanguage();
$extension = 'com_search';
$base_dir = JPATH_SITE;
if (VM1)
$language_tag = $lang->_lang;
else $language_tag = $lang->getTag(); 

$lang->load($extension, $base_dir, $language_tag, true);
$myid = $module->id;



$clang = JRequest::getVar('lang', ''); 
//var_dump($_SESSION);die();
$conf = JFactory::getConfig();
$l = $conf->getValue('config.language');
$a = explode('-', $l); 

if (!empty($a[0]))
$clang = $a[0];
else $clang = '';

$q = 'select params from #__modules where id = "'.$myid.'" '; 
$db =& JFactory::getDBO();
$db->setQuery($q); 
$res = $db->loadResult(); 


if (!empty($res))
$params = new JParameter( $res );

$min_height = $params->get('min_height');
$results_width = $params->get('results_width');

if (empty($min_height)) $min_height = '40'; 
if (empty($results_width)) $results_width = '200px';
else $results_width .= 'px'; 

$prods = $params->get('number_of_products'); 
// we start with zero
$prods--; 
if (empty($prods)) $prods = 4; 
$url = JURI::base().'modules/mod_vm_ajax_search/ajax/index.php';


$document =& JFactory::getDocument();
if (!defined('search_timer'))
{
 // init only once per all modules
 $document->addStyleSheet(JURI::base().'modules/mod_vm_ajax_search/css/mod_vm_ajax_search.css'); 
 $document->addScript(JURI::Base().'modules/mod_vm_ajax_search/js/vmajaxsearch.js'); 

 $js1 = ' 
          var search_timer = new Array(); 
		  var search_has_focus = new Array(); 
		  var op_active_el = null;
		  var op_active_row = null;
          var op_active_row_n = parseInt("0");
		  var op_last_request = ""; 
          var op_process_cmd = "href"; 
		  var op_controller = ""; 
		  var op_lastquery = "";
		  var op_maxrows = '.$prods.'; 
		  var op_lastinputid = "vm_ajax_search_search_str2'.$myid.'";
		  var op_currentlang = "'.$clang.'";
		  var op_lastmyid = "'.$myid.'"; 
		  var op_ajaxurl = "'.$url.'";
		  var op_savedtext = new Array(); 
 
 '; 
}
else $js1 = ''; 

$js = $js1.'
  /* <![CDATA[ */
  // global variable for js
  
   
   search_timer['.$myid.'] = null; 
   search_has_focus['.$myid.'] = false; 
   //document.addEvent(\'onkeypress\', function(e) { handleArrowKeys(e); });
 
   window.addEvent(\'domready\', function() {
     document.onkeydown = function(event) { return handleArrowKeys(event); };
     //jQuery(document).keydown(function(event) { handleArrowKeys(event); }); 
     // document.onkeypress = function(e) { handleArrowKeys(e); };
     if (document.body != null)
	 {
	   var div = document.createElement(\'div\'); 
	   div.setAttribute(\'id\', "vm_ajax_search_results2'.$myid.'"); 
	   div.setAttribute(\'class\', "res_a_s sbd"); 
	   div.setAttribute(\'style\', "width:'.$results_width.'");
	   document.getElementById("maincontainer").appendChild(div);
	 }
     //document.body.innerHTML += \'<div class="res_a_s" id="vm_ajax_search_results2'.$myid.'" style="z-index: 999; width: '.$results_width.';">&nbsp;</div>\';
   });
   
   /* ]]> */
   
   
  '; 
$document->addScriptDeclaration($js); 
$style = '
 #vm_ajax_search_results2'.$myid.' {margin-left:'.$params->get('offset_left_search_result').'px;margin-top:'.$params->get('offset_top_search_result').'px;}
';
$document->addStyleDeclaration($style); 





// to support more positions


//var_dump($params);

//var_dump($conf); die();
?>
<div style="position: absolute;" >
<form name="pp_search<?php echo $myid ?>" id="pp_search2.<?php echo $myid ?>" action="<?php echo JRoute::_('index.php'); ?>" method="get">
<div class="vmlpsearch<?php echo $params->get('moduleclass_sfx'); ?>" style="min-height: <?php echo $min_height; ?>px;">


        
	<?php
		$search = JText::_('Search: enter search term here:');
		// can set this also to: JText::_('SEARCH');
		
		$search = addslashes($search);
		$include_but = $params->get('include_but');
		$tw = $params->get('text_box_width');  
	?>
        
	 <div class="aj_label_wrapper" style="position: relative; height: 20px;" >
         <span class="vm_ajax_search_pretext"><?php echo $params->get('pretext'); ?></span>
         <input placeholder="<?php echo $search;  ?>" style="<?php if (!empty($tw)) echo 'width: '.($tw+10).'px;' ?> position: relative; top: 0; left: 0;"
                class="inputbox_vm_ajax_search_search_str2" 
                id="vm_ajax_search_search_str2<?php echo $myid ?>" 
                name="keyword" type="text" value="" autocomplete="off" 
                onblur="javascript: return search_setText('', this, '<?php echo $myid ?>');" 
                onfocus="javascript: aj_inputclear(this, '<?php echo $params->get('number_of_products'); ?>', '<?php echo $clang; ?>', '<?php echo $myid; ?>', '<?php echo $url ?>');" 
                onkeyup="javascript:search_vm_ajax_live(this, '<?php echo $params->get('number_of_products'); ?>', '<?php echo $clang; ?>', '<?php echo $myid; ?>', '<?php echo $url ?>'); "/>
	 
<!--         <label for="vm_ajax_search_search_str2--><?php //echo $myid ?><!--" id="label_vm_ajax_search_search_str2--><?php //echo $myid ?><!--" style="position: absolute; left: 3px; top: -1px;">-->
<!--	  --><?php //echo $search;  ?>
<!--	 </label>-->
	 <?php if (VM1)
	 {
	 ?>
 	  <input type="hidden" name="Itemid" value="<?php echo $sess->getShopItemid(); ?>" />
	 <?php } ?>
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="page" value="shop.browse" />
		<input type="hidden" name="search" value="true" />
		<input type="hidden" name="view" value="category" />
		<input type="hidden" name="limitstart" value="0" />	
	
	<?php if (!empty($include_but)) 
	{
	 $st = ' style="display: block; "';
	}
	else 
	$st = 'style="display: none;"'; ?>
		        &nbsp;<input onclick="" class="search_bt" type="image"  src="<?php echo $image?>" class="button" value="Go" style="vertical-align :middle;" <?php echo $st ?>>

	<span class="useavs">Use <a href="index.php?option=com_virtuemart&view=avsearch&layout=search&search=true">Advanced Search</a></span>
<?php
//         $vid = JRequest::getInt('virtuemart_manufacturer_id',0);
//        $manufacture = '<span class="searchbrand">Search by Brands </span> <select name="virtuemart_manufacturer_id">';
//            $manufacture .= '<option value="">--All--</option>';
//        foreach ($manufacturers as $manufacturer)
//        {
//            if($manufacturer->virtuemart_manufacturer_id==$vid)
//                $manufacture .= '<option value="'.$manufacturer->virtuemart_manufacturer_id.'" selected>' . $manufacturer->mf_name .'('.$manufacturer->count.')'. '</option>';
//            else
//                $manufacture .= '<option value="'.$manufacturer->virtuemart_manufacturer_id.'">' . $manufacturer->mf_name .'('.$manufacturer->count.')'.'</option>';
//        }
//        $manufacture .= '</select>';
//        echo $manufacture;
        
?>       

            <?php // echo '<input class="button_ajax_search" type="submit" value="'.$search.'" name="Search" '.$st.'/>';
		
		
		if (($params->get('include_advsearch')== 1) && (VM1)) {
		if (VM1)
		$search_page = JRoute::_('index.php?option=com_virtuemart&page=shop.search'); 
		else
		$search_page = JRoute::_('index.php?option_com_virtuemart&view=category'); 
		
		
		echo '<a style="clear: both; float: left;" href="'.$search_page.'">'.$search.' </a>';}?>
                
	<?php $postt = $params->get('posttext'); 
	
	if (!empty($postt))
	{
	?>
	<div class="vm_ajax_search_posttext" style="clear: both;"><?php echo $postt; ?></div>
	<?php 
	
	}
	?>
            <div id="brand" class="brand" onclick="">-- Search by Brands and Manufacturers  -- </div>
            <?php echo $mafu; ?>
        <input type="hidden" id='typeofmanu' name="typeofmanu" value="" />
        
    </div>
</div>
</form>
<?php 
if (false) { ?>
<div class="res_a_s" id="vm_ajax_search_results2<?php echo $myid ?>" style="position: <?php echo $params->get('css_position'); ?>; z-index: 999; width: <?php echo $results_width ?>;">&nbsp; 
</div>
<?php } ?>

</div>

<script>
var showOrHide = true; 
var yetVisited = localStorage['brand'];
jQuery('#brand').click(function(){
    jQuery('#mapop').toggle();
});
//function viewbrand(){
////    jQuery('#brand').addClass('');
//    jQuery('#mapop').toggle(showOrHide);
//    alert(showOrHide);
//
//}
function mfa(k) {
        jQuery('.fc'+k).toggle();
}
function mba(k) {
        jQuery('.bc'+k).toggle();
}
jQuery(".mar").click(function(){
    jQuery('.mlist').toggle();
});
jQuery(".pclose").click(function(){
    jQuery('#mapop').hide();
});
jQuery(".click").click(function(){
    pos = this.id;
    abc =  jQuery('#'+pos+' a').html();
    jQuery('#brand').text(abc);
    jQuery('#typeofmanu').val(pos);    
    jQuery('#mapop').hide();

    localStorage['brand'] = abc;
        
//     alert(abc);
});

jQuery(document).ready(function() {
    if (yetVisited) {
        jQuery('#brand').text(yetVisited);
    }
});

</script>
