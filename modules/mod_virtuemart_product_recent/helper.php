<?php
/**
 * @version		$Id: helper.php 21451 2011-06-04 19:00:00Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	mod_articles_latest
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModel::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');
if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
$config= VmConfig::loadConfig();
if (!class_exists( 'VirtueMartModelVendor' )) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'vendor.php');
if(!class_exists('TableProducts')) require(JPATH_VM_ADMINISTRATOR.DS.'tables'.DS.'products.php');
if (!class_exists( 'VirtueMartModelProduct' )) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'product.php');
abstract class modArticlesLatestHelper
{
	public static function getList(&$params)
	{
		// Get the dbo
		$db = JFactory::getDbo();
		$product = VmModel::getModel ('product');
		$count = (int) $params->get('count', 5);
		$ip = $_SERVER['REMOTE_ADDR'];
		$sql = "SELECT * " .
			  " FROM #__virtuemart_product_recent  " .
			  " WHERE ip_address = '" . $ip . "' ORDER BY created_date desc " .
			  " LIMIT 0, $count";
		$db->setQuery($sql);
		$items = $db->loadObjectList();
		foreach ($items as &$item) {
			$item->product = $product->getProduct($item->virtuemart_product_id);
			$item->link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$item->virtuemart_product_id);
		}
		
		return $items;
	}
	
	
}
