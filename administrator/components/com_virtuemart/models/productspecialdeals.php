<?php
/**
*
* Market_price Model
*
* @package	VirtueMart
* @subpackage Market_price
* @author RolandD, Patrick Kohl, Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: market_price.php 4286 2011-10-06 18:05:15Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the model framework
jimport( 'joomla.application.component.model');

if(!class_exists('VmModel'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmmodel.php');

/**
 * Model class for VirtueMart Market_prices
 *
 * @package VirtueMart
 * @subpackage Market_price
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelProductSpecialDeals extends VmModel {

	/**
	 * constructs a VmModel
	 * setMainTable defines the maintable of the model
	 * @author Max Milbers
	 */
	function __construct() {
		parent::__construct('id');
		$this->setMainTable('product_special_deals');

	}

	public function store($data)
	{
	  /* Setup some place holders */
	  $table = $this->getTable('product_special_deals');

	  $table->bindChecknStore($data);
	  $errors = $table->getErrors();
	  foreach($errors as $error){
	    $this->setError($error);
	  }

	  return $table->id;
	}

  /**
   * save data when save product info
   *
   * @param array $data
   * @param int $product_id
   *
   * @author DuongTD <trieudaiduong@gmail.com>
   */
  function saveData($data, $product_id)
  {
    $sql = 'DELETE FROM #__virtuemart_product_special_deals WHERE product_id = ' . $product_id;
    $this->_db->setQuery ($sql);
    $this->_db->query ();

    $sql = "INSERT INTO `#__virtuemart_product_special_deals` (`product_id`, `product_special_deal_id`, `special_price`) VALUES ";

    if (is_array($data['specialDealArray'])) {
      foreach ($data['specialDealArray'] as $key => $value) {
        $sql .= '(' . $product_id . ',' . $value . ',' . $data['special_deal_' . $value] . '),';
      }

      $sql = rtrim($sql, ',');
      $this->_db->setQuery ($sql);
      $this->_db->query ();
    }
  }

  public function renderSpecialDealHtml($product_id)
  {
    $sql = 'SELECT psd.product_special_deal_id, psd.special_price, p.product_s_desc, p.product_name, '
         . '(SELECT `virtuemart_media_id` FROM `#__virtuemart_product_medias` WHERE `virtuemart_product_id`=  psd.product_special_deal_id AND (`ordering` = 0 OR `ordering` = 1)) AS media_id, '
         . '(SELECT `product_price` FROM `#__virtuemart_product_prices` WHERE `virtuemart_product_id`=  psd.`product_special_deal_id`) AS product_price '
         . 'FROM `#__virtuemart_product_special_deals` AS psd '
         . 'LEFT JOIN `#__virtuemart_products_' . VMLANG . '` AS p ON p.virtuemart_product_id = psd.product_special_deal_id '
         . 'WHERE psd.product_id = ' . $product_id;

    $db = JFactory::getDBO();
    $db->setQuery($sql);
    $resultArray = $db->loadObjectList();
    $html = '';

    if ($resultArray) {
      foreach ($resultArray as $value) {
        $display = '<input type="hidden" value="' . $value->product_special_deal_id . '" name="specialDealArray[]" />';
  	    $thumb = '';


  	    if ($value->media_id) {
  	      if (!class_exists('VirtueMartModelCustomfields')) {
  	        require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'customfields.php');
  	      }

  	      $thumb = VirtueMartModelCustomfields::displayCustomMedia($value->media_id);
  	    }

  	    $title= $value->product_s_desc ?  $value->product_s_desc : '';
  	    $display .= JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=product&task=edit&virtuemart_product_id=' . $value->product_special_deal_id), $thumb . '<br /> ' . $value->product_name, array('title' => $title));

  	    if (!class_exists ('CurrencyDisplay')) {
  	      require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');
  	    }

  	    $currency = CurrencyDisplay::getInstance ();

  	    $html .= '<div class="vm_thumb_image"><span>' . $display . '</span><br/><span>' . $currency->createPriceDiv('salesPrice', '', $value->product_price, true) . '</span><br/>'
  	           . '<span>'. JText::_('COM_VIRTUEMART_ADMIN_PRODUCT_SPECIAL_DEAL_TITLE' ) . ': <input type="text" value="' . substr($value->special_price, 0, -3) .'" name="special_deal_' . $value->product_special_deal_id . '" size="40"></span><div class="vmicon vmicon-16-remove"></div></div>';
      }
    }

    return $html;
  }

  public function getAllSpecialDeal($product_id, $limit)
  {
    $sql = 'SELECT psd.product_special_deal_id, psd.special_price, p.product_s_desc, p.product_name, pp.product_price, '
         . '(SELECT `virtuemart_media_id` FROM `#__virtuemart_product_medias` WHERE `virtuemart_product_id`=  psd.product_special_deal_id AND (`ordering` = 0 OR `ordering` = 1)) AS media_id '
         . 'FROM `#__virtuemart_product_special_deals` AS psd '
         . 'LEFT JOIN `#__virtuemart_products_' . VMLANG . '` AS p ON p.virtuemart_product_id = psd.product_special_deal_id '
         . 'LEFT JOIN `#__virtuemart_product_prices` AS pp ON pp.virtuemart_product_id = psd.product_special_deal_id '
         . 'WHERE psd.product_id = ' . $product_id . ' '
         . 'LIMIT 0, ' . $limit;

    $db = JFactory::getDBO();
    $db->setQuery($sql);
    $resultArray = $db->loadObjectList();

    if ($resultArray) {
      foreach ($resultArray as &$value) {
        $value->thumb = '';

        if ($value->media_id) {
          if (!class_exists('VirtueMartModelCustomfields')) {
            require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'customfields.php');
          }

          $value->thumb  = VirtueMartModelCustomfields::displayCustomMedia($value->media_id);
        }
      }
    }

    return $resultArray;
  }

  public function getAllSpecialDealId($product_id)
  {
    $sql = 'SELECT psd.product_special_deal_id, psd.special_price '
         . 'FROM `#__virtuemart_product_special_deals` AS psd '
         . 'WHERE psd.product_id = ' . $product_id;

    $db = JFactory::getDBO();
    $db->setQuery($sql);
    $records = $db->loadObjectList();

    $resultArray = array();
    if ($records) {
      foreach ($records as $key => $value) {
        $resultArray[$value->product_special_deal_id] = $value->special_price;
      }
    }

    return $resultArray;
  }
}
// pure php no closing tag