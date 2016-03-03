<?php
/**
*
* product suggestions Model
*
* @package  VirtueMart
* @subpackage product suggestions
* @author DuongTD <trieudaiduong@gmail.com>
* @version $Id: market_price.php 4286 2011-10-06 18:05:15Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the model framework
jimport( 'joomla.application.component.model');

if(!class_exists('VmModel'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmmodel.php');

class VirtueMartModelProductSuggestions extends VmModel
{
  function __construct()
  {
    parent::__construct('product_id');
    $this->setMainTable('product_suggestions');

  }

  public function store($data)
  {
    /* Setup some place holders */
    $table = $this->getTable('product_suggestions');

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
    $sql = 'DELETE FROM #__virtuemart_product_suggestions WHERE product_id = ' . $product_id;
    $this->_db->setQuery ($sql);
    $this->_db->query ();

    $sql = "INSERT INTO `#__virtuemart_product_suggestions` (`product_id`,`product_suggestion_id`) VALUES ";

    if (is_array($data['suggestionArray'])) {
      foreach ($data['suggestionArray'] as $key => $value) {
        $sql .= '(' . $product_id . ',' . $value . '),';
      }

      $sql = rtrim($sql, ',');

      $this->_db->setQuery ($sql);
      $this->_db->query ();
    }
  }

  public function renderSuggestionHtml($product_id)
  {
    $sql = 'SELECT ps.product_suggestion_id, p.product_s_desc, p.product_name '
         . 'FROM `#__virtuemart_product_suggestions` AS ps '
         . 'LEFT JOIN `#__virtuemart_products_' . VMLANG . '` AS p ON p.virtuemart_product_id = ps.product_suggestion_id '
         . 'WHERE ps.product_id = ' . $product_id;

    $db = JFactory::getDBO();
    $db->setQuery($sql);
    $resultArray = $db->loadObjectList();

    $html = '';

    if ($resultArray) {
      foreach ($resultArray as $value) {
        $display = '<input type="hidden" value="' . $value->product_suggestion_id . '" name="suggestionArray[]" />';
  	    $thumb = '';

  	    $q = 'SELECT `virtuemart_media_id` FROM `#__virtuemart_product_medias`WHERE `virtuemart_product_id`= "' . (int)$value->product_suggestion_id . '" AND (`ordering` = 0 OR `ordering` = 1)';
  	    $db->setQuery ($q);

  	    if ($media_id = $db->loadResult()) {
  	      if (!class_exists('VirtueMartModelCustomfields')) {
  	        require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'customfields.php');
  	      }

  	      $thumb = VirtueMartModelCustomfields::displayCustomMedia($media_id);
  	    }

  	    $title= $value->product_s_desc ?  $value->product_s_desc : '';
  	    $display .= JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=product&task=edit&virtuemart_product_id=' . $value->product_suggestion_id), $thumb . '<br /> ' . $value->product_name, array('title' => $title));

  	    $html .= '<div class="vm_thumb_image"><span>' . $display . '</span><div class="vmicon vmicon-16-remove"></div></div>';
      }
    }

    return $html;
  }

  public function getAllSuggenstion($product_id, $limit)
  {
    $sql = 'SELECT ps.product_suggestion_id, p.product_s_desc, p.product_name, pp.product_price, '
         . '(SELECT `virtuemart_media_id` FROM `#__virtuemart_product_medias` WHERE `virtuemart_product_id`=  ps.product_suggestion_id AND (`ordering` = 0 OR `ordering` = 1)) AS media_id '
         . 'FROM `#__virtuemart_product_suggestions` AS ps '
         . 'LEFT JOIN `#__virtuemart_products_' . VMLANG . '` AS p ON p.virtuemart_product_id = ps.product_suggestion_id '
         . 'LEFT JOIN `#__virtuemart_product_prices` AS pp ON pp.virtuemart_product_id = ps.product_suggestion_id '
         . 'WHERE ps.product_id = ' . $product_id . ' '
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
}
