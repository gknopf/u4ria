<?php

defined('_JEXEC') or die('Restricted access');
if ( $params->get('filter_category', 0) ){
    $category_id = JRequest::getInt('virtuemart_category_id', 0);
} else {
    $category_id = 0 ;
}
if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
if(!class_exists('TableManufacturer_medias')) require(JPATH_ADMINISTRATOR.DS. 'components' . DS . 'com_virtuemart' . DS . 'tables'.DS.'manufacturer_medias.php');
if(!class_exists('TableManufacturers')) require(JPATH_ADMINISTRATOR.DS. 'components' . DS . 'com_virtuemart' . DS . 'tables'.DS.'manufacturers.php');
if (!class_exists( 'VirtueMartModelManufacturer' )){
   JLoader::import( 'manufacturer', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
}
$model = VmModel::getModel('Manufacturer');
$manufacturers = $model->getManufacturers(true, true,true);
foreach ($manufacturers as $manufacturer) {
    $manufacturer->count = $model->countProducts($manufacturer->virtuemart_manufacturer_id);
}
/////////////////*******//////////////////////
$db =& JFactory::getDBO();
$qmfc = '
SELECT m.virtuemart_manufacturercategories_id,mn.mf_category_name 
FROM #__virtuemart_manufacturercategories m
LEFT JOIN #__virtuemart_manufacturercategories_en_gb as mn ON m.virtuemart_manufacturercategories_id = mn.virtuemart_manufacturercategories_id    
'; 
$qmf = '
SELECT m.virtuemart_manufacturer_id,mn.mf_name,mc.virtuemart_manufacturercategories_id,mce.mf_category_name
FROM u4ria_virtuemart_manufacturers m
JOIN u4ria_virtuemart_manufacturers_en_gb as mn ON m.virtuemart_manufacturer_id = mn.virtuemart_manufacturer_id 
JOIN u4ria_virtuemart_manufacturercategories as mc on mc.virtuemart_manufacturercategories_id = m.virtuemart_manufacturercategories_id
JOIN u4ria_virtuemart_manufacturercategories_en_gb as mce on mce.virtuemart_manufacturercategories_id = mc.virtuemart_manufacturercategories_id   
'; 

$db->setQuery($qmfc); 
$resmfc = $db->loadObjectList();
$db->setQuery($qmf); 
$resmf = $db->loadObjectList();
$armfc=array();
$armf=array();
foreach ($resmfc as $value) {
    $v = strtolower(substr(trim($value->mf_category_name), 0, 1));
//    $v = substr($value->mf_category_name, 0, 1);
    $armfc[$v][]=$value;
}
foreach ($resmf as $value) {
    $v = strtolower(substr(trim($value->mf_name), 0, 1));
//    $v = substr($value->mf_category_name, 0, 1);
    $armf[$v][]=$value;
}
ksort($armfc);
ksort($armf);
$mafu = '<div id="mapop" style="display:none;"><span class="pclose"></span>';
$mafu .='<div class="mafut"><div class="mstitle"><span>Search by Brands<span></div></div>';
$mafu .='<div class="blist">';
foreach (range('a', 'z') as $char) {
    if($char=='a') $mafu .= '<div>';
    if($char=='e' || $char=='i' || $char=='m' || $char=='q' || $char=='u' || $char=='y') $mafu .= '</div><div>';
    $mafu .= '<div class="'.$char.'"><div class="lbc">'.$char.'</div>';
    if(!empty($armf[$char])){
        $mafu .='<div class="gc fc_'.$char.'" >';
            foreach ($armf[$char] as $value) {
                $link = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $value->virtuemart_manufacturer_id . '');
                $mafu .= '<div id="m'.$value->virtuemart_manufacturer_id.'" class="click" ><a href="'.$link.'">- '.$value->mf_name.'('.$model->countProducts($value->virtuemart_manufacturer_id).')</a></div>';
            }
        $mafu .='</div>';
    }    
     $mafu .='</div>';
    if($char=='z') $mafu .= '</div>';
}
$mafu .='</div>';
$mafu .='<div class="mafut"><div class="mstitle mf" style="width:100%;"><span>Search by Manufacturers</span><span class="mar"></span></div></div>';
$mafu .='<div class="mlist" style="display:none;">';
foreach (range('a', 'z') as $char) {
    if($char=='a') $mafu .= '<div>';
    if($char=='e' || $char=='i' || $char=='m' || $char=='q' || $char=='u' || $char=='y') $mafu .= '</div><div>';
    $mafu .= '<div class="'.$char.'"><div class="lbc">'.$char.'</div>';
    if(!empty($armfc[$char])){
        $mafu .='<div class="gc fc_'.$char.'" >';
            foreach ($armfc[$char] as $value) {
                $link = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturercat_id=' . $value->virtuemart_manufacturercategories_id . '');
                $mafu .= '<div id="m'.$value->virtuemart_manufacturercategories_id.'" class="click" ><a href="'.$link.'">- '.$value->mf_category_name.'('.$model->countProductsMcat($value->virtuemart_manufacturercategories_id).')</a></div>';
            }
        $mafu .='</div>';
    }    
     $mafu .='</div>';
    if($char=='z') $mafu .= '</div>';
}
$mafu .='</div>';

$mafu .='</div>';


//echo $mafu;die;

///////////////////******////////////////////
require(JModuleHelper::getLayoutPath('mod_vm_ajax_search'));