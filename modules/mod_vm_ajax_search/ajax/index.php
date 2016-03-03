<?php


// joomla external initialization


	header("HTTP/1.0 200 OK");

	global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_lang, $database,
    $mosConfig_mailfrom, $mosConfig_fromname;

        /*** access Joomla's configuration file ***/
        $my_path = dirname(__FILE__);

        if( file_exists($my_path."/../../../configuration.php")) {
            $absolute_path = dirname( $my_path."/../../../configuration.php" );
            require_once($my_path."/../../../configuration.php");

        }
        elseif( file_exists($my_path."/../../configuration.php")){
            $absolute_path = dirname( $my_path."/../../configuration.php" );
            require_once($my_path."/../../configuration.php");
        }
        elseif( file_exists($my_path."/configuration.php")){
            $absolute_path = dirname( $my_path."/configuration.php" );
            require_once( $my_path."/configuration.php" );
        }
        else {
            die( "Joomla Configuration File not found!" );
        }
        $absolute_path = realpath( $absolute_path );

// Get Joomla! framework
ini_set('display_errors', '0');     # don't show any errors...
define( '_JEXEC', 1 );
define( '_VALID_MOS', 1 );
define( 'JPATH_BASE', $absolute_path);
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );


        // Set up the appropriate CMS framework
        if( class_exists( 'jconfig' ) ) {


			// create the mainframe object
			$mainframe = & JFactory::getApplication( 'site' );

			// Initialize the framework
			$mainframe->initialise();

			// load system plugin group
			JPluginHelper::importPlugin( 'system' );

			// trigger the onBeforeStart events
			$mainframe->triggerEvent( 'onBeforeStart' );
			$mainframe->triggerEvent( 'onAfterInitialise' );

			$lang =& JFactory::getLanguage();

			// Adjust the live site path
			$mosConfig_live_site = str_replace('/modules/mod_vm_ajax_search/ajax', '', JURI::base());
			//jimport('joomla.enviroment.uri');
			//echo JURI::base();
			//$u =& JURI::getInstance();
			//echo JURI::$base;
			//$u->_uri = str_replace('/modules/mod_vm_ajax_search/ajax', '', $u->_uri);

			//$u->_path = '/';
			//echo $mosConfig_live_site; die();
			global $mosConfig_absolute_path;
			$mosConfig_absolute_path = JPATH_BASE;
        }
		else { die('incompatible joomla version'); }



	$_GLOBALS['mosConfig_absolute_path'] = JPATH_BASE;
        /*** VirtueMart part ***/


		{
		define('VM1', false);
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
		  VmConfig::loadConfig(true);
			if (!defined('VMLANG')) define('VMLANG', 'en_gb');
		}

$_REQUEST['option'] = 'com_virtuemart';
$lang =& JFactory::getLanguage();
if (!empty($jmshortcode) && is_object($jmshortcode))
{
 $_SESSION['jmactivelang']=$jmshortcode->id;

}

$db =& JFactory::getDBO();

$lang_code = JRequest::getVar('lang', '');
$myid = JRequest::getInt('myid', 0);
//if (!is_numeric($myid)) $mainframe->close();

$extension = 'com_virtuemart';
$base_dir = JPATH_SITE;
if (VM1)
$language_tag = $lang->_lang;
else
{
  $language_tag = $lang->getTag();
}
$lang->load($extension, $base_dir, $language_tag, true);
//$_REQUEST['option'] = 'com_virtuemart';

$prods = JRequest::getInt('prods', 5);
//if (!is_numeric($prods)) $mainframe->close();

//if (!empty($_SESSION['ajax_cache']))
{
  $cache_off = true;
}
//else
{

$q = 'select params from #__modules where id = "'.$myid.'" ';
$db->setQuery($q);
$res = $db->loadResult();

//jimport( 'joomla.html.parameter' );

if (!empty($res))
{
if (VM1)
{
$params = new JParameter( $res );
}
else
{
  jimport( 'joomla.application.module.helper' );
  $module = JModuleHelper::getModule('mod_vm_ajax_search');
  $params = new JRegistry();
  $params->loadString($module->params);
}

$ic = $params->get('internal_caching');
if (!empty($ic))
{
$cache_off = false;
$_SESSION['ajax_cache'] = true;
}
else
{
$cache_off = true;
$_SESSION['ajax_cache'] = false;
}
}
else
$cache_off = true;
}
$_REQUEST['option'] = 'com_virtuemart';

// security
//if (!is_numeric($prods)) $mainframe->close();

	    // restart session
	    // Constructor initializes the session!
	    $sess = new op_compatibility2();
	    $keyword = JRequest::getVar('keyword', '');


	    $cachedir = JPATH_CACHE.DS.'mod_vm_ajax_search';
	    $cachefile = $cachedir.DS.md5($keyword).'.'.$lang_code.'.part.html';

	    if (empty($cache_off))
	    {

	    if (!file_exists($cachedir))
	    {
	      @mkdir($cachedir);
	    }
	    else
	    {

	      if (file_exists($cachefile))
	      {
	        $x = file_get_contents($cachefile);
	        echo $x;
	        $mainframe->close();
	      }
	      else
	      {

	      }
	    }
	    }
	    ob_start();

	//	echo '<div class="vm_ajax_search_header2">'.JText::_('SEARCH').': '.$keyword;
	//	echo '<a class="product_lnk_ajax" id="vm_ajax_search_link2'.$myid.'" href="#" onclick="javascript: return hide_results_live(\''.$myid.'\');">'.JText::_('COM_VIRTUEMART_CLOSE').'</a>';
	//	echo '</div>';

	    if (tableExists('#__jf_content')) $joomfish_enabled = true;
	    else $joomfish_enabled = false;



		$shortcode = JRequest::getVar('lang', '');

		if ($joomfish_enabled && (!empty($shortcode)))
		 {
		   $q2 = 'select id from #__languages where shortcode = "'.$shortcode.'"';

		   $db->setQuery($q2);
		   $lid = $db->loadResult();
		 }
		 else $lid = "";


	    //$db =& JFactory::getDBO();


	    $ko = trim($keyword);

	    $or = '';
	    $or_j = '';

		// not used:
		if (false)
	    if (strpos($keyword, ' ')!==false)
	    {
		  //keyarr = explode(' ', $keyword);

	      //$keyword = str_replace(' ', '%', $keyword);

	      if (false)
	      {
	      $a = explode(' ', $keyword);
	      foreach ($a as $k)
	      {
	        if (!empty($k))
	        {
	        if (empty($or))
	        $or = " product_name LIKE '%".$db->getEscaped($k)."%' ";
	        else $or = " and product_name LIKE '%".$db->getEscaped($k)."%' ";
	        }

	        if ($joomfish_enabled)
	        {
	        if (!empty($k))
	        {
	        if (empty($or))
	        $or_j = " jf.product_name LIKE '%".$db->getEscaped($k)."%' ";
	        else $or_j = " and jf.product_name LIKE '%".$db->getEscaped($k)."%' ";
	        }

	        }

	      }
	      if (!empty($or))
	       $or = ' or ('.$or.')';
	      }
	    }

		if (VM1 == true)
		{
	    if (strlen($keyword)<3) $keyword = ' '.$keyword.' ';

	    // check for joomfish
	    $q = '';
	    $shortcode = JRequest::getVar('lang', '');
	    $conf = JFactory::getConfig();
	    $default_lang = $conf->getValue('config.defaultlang');
	    $a = explode('-', $default_lang);
	    if (!empty($a[0]) && $a[0]==$shortcode)
	    {
	    $joomfish_enabled = false;

	    }

		$ks = explode(' ', $keyword);

		$m1 = '';
		$mj = '';
		if (count($ks)>1)
		foreach ($ks as $kw)
		{

		   if (!empty($kw))
		   {
		   if (!empty($mj)) $mj .= ' AND ';
		   $mj .=" (jf.value LIKE '%".$db->getEscaped($kw)."%') ";
		   }

		   if (!empty($kw))
		   {
		   if (!empty($m1)) $m1 .= ' AND ';
		   $m1 .= " (p.product_name LIKE '%".$db->getEscaped($kw)."%' ) ";
		   }
		}
		if (!empty($mj)) $mj = " union (select p.product_id, jf.value, p.product_thumb_image from #__vm_product as p, #__jf_content as jf where (".$mj.") and jf.reference_table = 'vm_product' and jf.reference_field = 'product_name'   and jf.reference_id = p.product_id and jf.language_id = '".$lid."' and p.product_publish = 'Y' LIMIT 0,".$prods.")"." \n";
		if (!empty($m1)) $m1 = " union (select p.product_id, p.product_name, p.product_thumb_image from #__vm_product as p where (".$m1.") and p.product_publish = 'Y' LIMIT 0,".$prods.") "." \n";


		//
		//
		// ."
		//
		//var_dump($ks);
		if (VM1)
		{
	    if ($joomfish_enabled && (!empty($shortcode)))
	    {

		   $q2 = 'select id from #__languages where shortcode = "'.$shortcode.'"';
		   $dbj =& JFactory::getDBO();
		   $dbj->setQuery($q2);
		   $lid = $dbj->loadResult();
		   if (!empty($lid))
		   {

	      $q = "select p.product_id, jf.value, p.product_thumb_image from #__vm_product AS p, #__jf_content as jf where p.product_sku = '".$db->getEscaped($keyword)."'                 and jf.reference_table = 'vm_product' and jf.reference_field = 'product_name'   and jf.reference_id = p.product_id and jf.language_id = '".$lid."' and p.product_publish = 'Y' LIMIT 0,".$prods." \n"
	      ." union (select p.product_id, jf.value, p.product_thumb_image from #__vm_product as p, #__jf_content as jf where jf.value LIKE '".$db->getEscaped($keyword)."%'              and jf.reference_table = 'vm_product' and jf.reference_field = 'product_name'   and jf.reference_id = p.product_id and jf.language_id = '".$lid."' and p.product_publish = 'Y' LIMIT 0,".$prods.")"." \n"
	      ." union (select p.product_id, jf.value, p.product_thumb_image from #__vm_product as p, #__jf_content as jf where (jf.value LIKE '%".$db->getEscaped($keyword)."%' ".$or_j.") and jf.reference_table = 'vm_product' and jf.reference_field = 'product_name'   and jf.reference_id = p.product_id and jf.language_id = '".$lid."' and p.product_publish = 'Y' LIMIT 0,".$prods.")"." \n"
		  ." union (select p.product_id, jf.value, p.product_thumb_image from #__vm_product as p, #__jf_content as jf where p.product_sku LIKE '".$db->getEscaped($ko)."%'              and jf.reference_table = 'vm_product' and jf.reference_field = 'product_name'   and jf.reference_id = p.product_id and jf.language_id = '".$lid."' and p.product_publish = 'Y' LIMIT 0,".$prods.")"." \n"
		  ." union (select p.product_id, jf.value, p.product_thumb_image from #__vm_product as p, #__jf_content as jf where jf.value LIKE '%".$db->getEscaped($keyword)."%'             and jf.reference_table = 'vm_product' and jf.reference_field = 'product_desc'   and jf.reference_id = p.product_id and jf.language_id = '".$lid."' and p.product_publish = 'Y' LIMIT 0,".$prods.")"." \n"
		  ." union (select p.product_id, jf.value, p.product_thumb_image from #__vm_product as p, #__jf_content as jf where jf.value LIKE '%".$db->getEscaped($keyword)."%'             and jf.reference_table = 'vm_product' and jf.reference_field = 'product_s_desc' and jf.reference_id = p.product_id and jf.language_id = '".$lid."' and p.product_publish = 'Y' LIMIT 0,".$prods.")"." \n"
		  .$mj
	      ." LIMIT 0,".$prods;

		   }
	    }
	    //echo $keyword;
		if (empty($q))
		{
	     $q =
	       " select p.product_id, p.product_name, p.product_thumb_image from #__vm_product AS p where p.product_sku = '".$db->getEscaped($keyword)."' and p.product_publish = 'Y' LIMIT 0,".$prods." "."\n"
	      ." union (select p.product_id, p.product_name, p.product_thumb_image from #__vm_product as p where p.product_name LIKE '".$db->getEscaped($keyword)."%' and p.product_publish = 'Y' LIMIT 0,".$prods.")"."\n"
	      ." union (select p.product_id, p.product_name, p.product_thumb_image from #__vm_product as p where (p.product_name LIKE '%".$db->getEscaped($keyword)."%' ".$or.") and p.product_publish = 'Y' LIMIT 0,".$prods.")"."\n"
		  ." union (select p.product_id, p.product_name, p.product_thumb_image from #__vm_product as p where p.product_sku LIKE '".$db->getEscaped($ko)."%' and p.product_publish = 'Y' LIMIT 0,".$prods.")"."\n"
		  ." union (select p.product_id, p.product_name, p.product_thumb_image from #__vm_product as p where p.product_desc LIKE '%".$db->getEscaped($keyword)."%' and p.product_publish = 'Y' LIMIT 0,".$prods.")"."\n"
		  ." union (select p.product_id, p.product_name, p.product_thumb_image from #__vm_product as p where p.product_s_desc LIKE '%".$db->getEscaped($keyword)."%' and p.product_publish = 'Y' LIMIT 0,".$prods.")"."\n"
		  .$m1
	      ." LIMIT 0,".$prods;
	    }
		}
		else
		{
		  $prods = 5;
		  $q = "select p.virtuemart_product_id, p.product_name, m.file_url_thumb from #__virtuemart_products as p2, #__virtuemart_products_".VMLANG." as p, #__virtuemart_product_medias as pmx, #__virtuemart_medias as m "
		  ." where p2.virtuemart_product_id = p.virtuemart_product_id and pmx.virtuemart_product_id = p2.virtuemart_product_id and pmx.virtuemart_media_id = m.virtuemart_media_id  and p2.published = '1'  "
		  ." and ((p.product_name LIKE '%".$db->escape($keyword)."%') or (p2.product_sku = '".$db->escape($keyword)."'))"
		  ." LIMIT 0,".$prods." "."\n";
		}
		}
		else
		{
		 // VM2
		  require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php'); //overrides'.DS.'vmplugin.php');


		  if (!defined('VMLANG')) define('VMLANG', 'en-gb');
		  $q =
//	      "         select p.virtuemart_product_id, l.product_name from #__virtuemart_products AS p, #__virtuemart_products_".VMLANG." as l where p.product_sku = '".$db->getEscaped($keyword)."' and p.published = '1' and p.virtuemart_product_id = l.virtuemart_product_id  LIMIT 0,".$prods." "."\n"
	      "         (select p.hits as s1h,p.virtuemart_product_id, l.product_name from #__virtuemart_products AS p, #__virtuemart_products_".VMLANG." as l where l.product_name LIKE '".$db->getEscaped($keyword)."%' and p.published = '1' and p.virtuemart_product_id = l.virtuemart_product_id  LIMIT 0,".$prods.") "."\n"
	//      ." union (select p.virtuemart_product_id, l.product_name from #__virtuemart_products AS p, #__virtuemart_products_".VMLANG." as l where l.product_name LIKE '".$db->getEscaped($keyword)."%' and p.published = '1' and p.virtuemart_product_id = l.virtuemart_product_id  LIMIT 0,".$prods.")"."\n"
	      ." union (select p.hits as s2h,p.virtuemart_product_id, l.product_name from #__virtuemart_products AS p, #__virtuemart_products_".VMLANG." as l where (l.product_name LIKE '%".$db->getEscaped($keyword)."%' ".$or.") and p.published = '1' and p.virtuemart_product_id = l.virtuemart_product_id  LIMIT 0,".$prods.")"."\n"
		//  ." union (select p.virtuemart_product_id, l.product_name from #__virtuemart_products AS p, #__virtuemart_products_".VMLANG." as l where p.product_sku LIKE '".$db->getEscaped($ko)."%' and p.published = '1'  and p.virtuemart_product_id = l.virtuemart_product_id LIMIT 0,".$prods.")"."\n"
		//  ." union (select p.virtuemart_product_id, l.product_name from #__virtuemart_products AS p, #__virtuemart_products_".VMLANG." as l where l.product_desc LIKE '%".$db->getEscaped($keyword)."%' and p.published = '1' and p.virtuemart_product_id = l.virtuemart_product_id LIMIT 0,".$prods.")"."\n"
		///  ." union (select p.virtuemart_product_id, l.product_name from #__virtuemart_products AS p, #__virtuemart_products_".VMLANG." as l where l.product_s_desc LIKE '%".$db->getEscaped($keyword)."%' and p.published = '1' and p.virtuemart_product_id = l.virtuemart_product_id LIMIT 0,".$prods.")"."\n"
              ."  ORDER BY s1h DESC \n"
	      ." LIMIT 0,".$prods;
		}
	      //$q = "select * from #__{vm}_product where product_name LIKE '".$db->getEscaped($keyword)."%' and product_publish = 'Y' LIMIT 0,".$prods."";
	      //'select * from jos_vm_product where product_id = "998" limit 1';// union (select * from jos_vm_product where product_id = "999" limit 1)';
	      //$q = " select p.product_id, p.product_name, p.product_thumb_image from #__{vm}_product as p where (p.product_name LIKE '%".$db->getEscaped($keyword)."%' ".$or.") and p.product_publish = 'Y' LIMIT 0,".$prods."";
	      //echo $q;
	      $db->setQuery($q);
             // echo $db->getQuery();
		 //$q =
		 //file_put_contents(JPATH_CACHE.DS.'testq.q', str_replace('#__', 'jos_', $q));
		 //echo $_POST['keyword'].":::".$keyword; die();
		 $ps = @$db->loadAssocList();
		 //var_dump($ps);
	     //
	     $err = $db->getErrorMsg();
	     if (!empty($err)) {
			// for debugging only:
			echo $err;
		 $mainframe->close();  }



	    include_once(JPATH_ROOT.DS.'modules'.DS.'mod_vm_ajax_search'.DS.'ajax'.DS.'helper.php');
	    $ahelper = new ajaxProductHelper();

		if (!empty($ps))
		{
		$xb = true;
		$n = 0;
	    foreach ($ps as $row)
	    {





		  if (isset($row['virtuemart_product_id'])) $row['product_id'] = $row['virtuemart_product_id'];
		  if (VM1)
		  {
	      if (!empty($row['value']))
		  if ($joomfish_enabled) $row['product_name'] = $row['value'];
	      }
		  if (!empty($xb))
	      $x = 1;
	      else $x = 2;
	      $pnames = strtolower($row['product_name']);
	      $pname = strtolower($row['product_name']);
	      $keyword = strtolower($keyword);
//	      echo '<div class="vm_ajax_search_row_'.$x.'" onclick="javascript: aj_redirect('."'".$pname."'".');">';

	      echo '<div id="vm_ajax_search_results2'.$myid.'_'.$n.'" class="record_result vm_ajax_search_row_'.$x.'" onmouseover="javascript:op_hoverme(this);"  onclick="javascript: aj_setkeyword('."'".$pname."'".');" rel=' . "'" . $pname . '\'>';
//	      echo '<div id="vm_ajax_search_results2'.$myid.'_'.$n.'" class="vm_ajax_search_row_'.$x.'" onmouseover="javascript:op_hoverme(this);"  onclick="javascript: aj_redirect('."'prod".$row['product_id']."'".');">';
	      $width = 30; $height = 30;
	      $h2 = $height +1;


	      $org_pname = $pname;
	      $pname = str_replace($keyword, '<span class="kfc">'.$keyword.'</span>', $pname) ;
	      //$pname = str_replace($ko, '<span style="font-weight: bold;">'.$ko.'</span>', $pname);
		  if (VM1)
		  {
		  $ps_product = new ps_product;
		  $flypage = $ps_product->get_flypage($row['product_id']);

		  $cat_id = $ahelper->get_lowcat($row['product_id']);
		  if (!empty($cat_id)) $cat_id = '&category_id='.$cat_id;
		  else $cat_id = '';
	      $href = $sess->url('index.php?option=com_virtuemart&page=shop.product_details&product_id='.$row['product_id'].'&flypage='.$flypage.$cat_id);
		  $href = str_replace('modules/mod_vm_ajax_search/ajax/', '', $href);
            $row['product_thumb_image'] = Resize_Image::getVm1Path($row['product_thumb_image']);
		  }
		  else
		  {
		    $href = JRoute::_('index.php?keyword='.$pnames.'&option=com_virtuemart&page=shop.browse&search=true&view=category&limitstart=0');
		    $href_enter = JRoute::_('index.php?keyword='.$keyword.'&option=com_virtuemart&page=shop.browse&search=true&view=category&limitstart=0');
		    $link = JRoute::_('index.php?keyword='.$org_pname.'&option=com_virtuemart&page=shop.browse&search=true&view=category&limitstart=0');
//		    $href = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$row['product_id']);
			$href = str_replace('modules/mod_vm_ajax_search/ajax/', '', $href);
			$href_enter = str_replace('modules/mod_vm_ajax_search/ajax/', '', $href_enter);
			$link = str_replace('modules/mod_vm_ajax_search/ajax/', '', $link);
		//	$dbj = JFactory::getDBO();
		//	$q = 'select virtuemart_media_id from #__virtuemart_product_medias where virtuemart_product_id = '.$row['product_id'];
		//	$dbj->setQuery($q);
		///	$mediaid = $dbj->loadResult();
		//	$row['product_thumb_image'] = Resize_Image::getImageFile($mediaid);
                  }
		  $value = $href;
		  $value_enter = $href_enter;
//	      echo '<div style="float: left; width; 23%; min-height: 55px;">';
//	      echo '<div style="float: left; width: '.$width.'px; height: '.$h2.'px; border: 1px solid grey; white-space: no-wrap; display: inline-block; clear: right; ">';
//	      Resize_Image::showImage($row['product_thumb_image'], 30, 30);
//	      echo '</div>';
//	      echo '</div>';
//	      echo '<br style="clear: both;" />';

             //     $ac = 'onclick="pp_search146.keyword.setAttribute(\'value\', myDivObj = document.getElementById("myDiv"));"';
	      echo '<div  class="prow" style="float: right; display: block; overflow: none; padding: 0; margin: 0; width: 100%;"/>';
	      $id = ' id="prod'.$row['product_id'].'_'.$myid.'" ';
//	      echo $pname;
	      echo '<a onclick="" class="product_lnk_ajax_text" style="text-align: left; margin-top: -3px; " href="'. $value.'" >'.$pname.'</a>';
	      echo '</div>';
		  echo '<input type="hidden" name="op_ajax_results" id="vm_ajax_search_results2_'.$myid.'_value_'.$n.'" value="'.$link.'" />';
		  echo '<input type="hidden" name="kw_search" id="kw_search" value="' . $keyword . '" />';
		  echo '<input type="hidden" name="org_kw_search" id="org_kw_search" value="' . $value_enter . '" />';
//		  echo '<input type="hidden" name="op_ajax_results_id" id="vm_ajax_search_results2'.$myid.'_input_'.$n.'" value="'.JRequest::getVar('inputid','').'" />';

	      echo '</div>';

	      $xb = !$xb;
		  $n++;
	    }
	    }
	    else
	    {
	      echo '<div class="vm_ajax_search_row_1">'.JText::_('NO RESULTS WERE FOUND').'</div>';
	    }

	    $html = ob_get_clean();
	    echo $html;

	    if (empty($cache_off))
	    @file_put_contents($cachefile, $html);

	    // load system plugin group
	//	JPluginHelper::importPlugin( 'system' );
	    $mainframe->triggerEvent( 'onAfterRender' );
//	    echo '</div>';

function tableExists($table)
{
 $db =& JFactory::getDBO();
 $prefix = $db->getPrefix();
 $table = str_replace('#__', '', $table);
 $table = str_replace($prefix, '', $table);
 $q = "SHOW TABLES LIKE '".$db->getprefix().$table."'";
 $db->setQuery($q);
 $r = $db->loadResult();
 if (!empty($r)) return true;
 return false;
}

class op_compatibility2
{
 function url($p1, $p2, $p3)
 {
   if (!empty($GLOBALS['sess'])) return $GLOBALS['sess']->url($p1, $p2, $p3);
   else return JRoute::_($p1);
 }
 function getShopItemid()
 {
   return JRequest::getVar('Itemid');
 }
 function _($val)
 {
   $v2 = str_replace('PHPSHOP_', 'COM_VIRTUEMART_', $val);
   return JText::_($v2);
 }
 function load($str='')
 {
 }
}