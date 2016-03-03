<?php

defined('_JEXEC') or die('Restricted access');
$curent_category_id = JRequest::getInt("virtuemart_category_id");
$db = JFactory::getDBO();
   $q = "select category_name
       from u4ria_virtuemart_categories_en_gb
       where virtuemart_category_id = " . $curent_category_id;
   $db->setQuery($q);
   $db->query();
   $categoryObj = $db->loadObject();
$clv3 = 1;
$prid = getParentCategory($curent_category_id)->category_parent_id;
if ($prid != 0) {
    $clv3++;
    $prid = getParentCategory($prid)->category_parent_id;
    if ($prid != 0) {
        $clv3++;
        $prid = getParentCategory($prid)->category_parent_id;
        if ($prid != 0) {
            $clv3++;
            $prid = getParentCategory($prid)->category_parent_id;
            if ($prid != 0) {
                $clv3++;
            }
        }
    }
}

$leftID = '';
$rightID = '';
$contentID = '';
$hiddenall = FALSE;
$hiddenleft = FALSE;
$hiddenright = FALSE;
$jcarousel = FALSE; //get videos view
$goption = JRequest::getVar("option");
$action = JRequest::getVar("action");
$view = JRequest::getVar("view");
$layout = JRequest::getVar("layout");
$virtuemart_manufacturer_id = JRequest::getVar("virtuemart_manufacturer_id");
$virtuemart_manufacturercat_id = JRequest::getVar("virtuemart_manufacturercat_id");

$search = JRequest::getBool("search");
if ($goption == "com_virtuemart" && ($view == "category" || $view == "productdetails" || $view == "productcompare" || $view == "wishlist"))
    $jcarousel = TRUE;
if ($view == "productdetails" ) {
    $hiddenleft = TRUE;
}
if ($layout == "notify" ) {
    $hiddenleft = FALSE;
}
if ($view == "category" AND  ($categoryObj->category_name=='Gift Certificates' OR $action=='topitems' OR $clv3>1 OR $search OR !empty($virtuemart_manufacturer_id) OR !empty($virtuemart_manufacturercat_id))) {
    $hiddenright = TRUE;
}
if($view == 'productcompare' || $view == "wishlist") {
    $leftID = 'leftcolumn-none';
    $rightID = 'rightcolumn-none';
    $contentID = 'contentcolumn-full';
    $hiddenleft = TRUE;
    $hiddenright = TRUE;
}elseif ($hiddenright) {
    $leftID = 'leftcolumn';
    $rightID = 'rightcolumn-none';
    $contentID = 'contentcolumn-left';
} else if ($hiddenleft) {
    $leftID = 'leftcolumn-none';
    $rightID = 'rightcolumn';
    $contentID = 'contentcolumn-right';

} else if ($this->countModules('position-left') && $this->countModules('position-right')) {
    $leftID = 'leftcolumn';
    $rightID = 'rightcolumn';
    $contentID = 'contentcolumn-leftright';
} else if (!$this->countModules('position-left') && $this->countModules('position-right')) {
    $leftID = 'leftcolumn-none';
    $rightID = 'rightcolumn';
    $contentID = 'contentcolumn-right';
} else if ($this->countModules('position-left') && !$this->countModules('position-right')) {
    $leftID = 'leftcolumn';
    $rightID = 'rightcolumn-none';
    $contentID = 'contentcolumn-left';
} else if (!$this->countModules('position-left') && !$this->countModules('position-right')) {
    $leftID = 'leftcolumn-none';
    $rightID = 'rightcolumn-none';
    $contentID = 'contentcolumn-full';
}

function getParentCategory($categoryId = 0) {

    $db = JFactory::getDBO();
    $q = "select category_parent_id
	from u4ria_virtuemart_category_categories
        where category_child_id = " . $categoryId;
    $db->setQuery($q);
    $db->query();
    $id = $db->loadObject();
    return $id;
}
