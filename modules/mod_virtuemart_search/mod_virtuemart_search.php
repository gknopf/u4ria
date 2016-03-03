<?php
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
* @version $Id: mod_virtuemart_search.php 5171 2011-12-27 15:41:22Z alatak $
* @package VirtueMart
* @subpackage modules
*
* @copyright (C) 2011 Patrick Kohl
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/

// Load the virtuemart main parse code
$button			 = $params->get('button', '');
$imagebutton	 = $params->get('imagebutton', '');
$button_pos		 = $params->get('button_pos', 'left');
$button_text	 = $params->get('button_text', JText::_('Search'));
$width			 = intval($params->get('width', 20));
$maxlength		 = $width > 20 ? $width : 20;
$text			 = $params->get('text', JText::_('search...'));
$set_Itemid		 = intval($params->get('set_itemid', 0));
$moduleclass_sfx = $params->get('moduleclass_sfx', '');

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
require(JModuleHelper::getLayoutPath('mod_virtuemart_search'));

?>
