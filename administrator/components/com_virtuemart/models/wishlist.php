<?php

/**
 *
 * Label Model
 *
 * @package	VirtueMart
 * @subpackage Label
 * @author RolandD, Patrick Kohl, Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: label.php 4286 2011-10-06 18:05:15Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the model framework
jimport('joomla.application.component.model');

if (!class_exists('VmModel'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmmodel.php');

/**
 * Model class for VirtueMart Labels
 *
 * @package VirtueMart
 * @subpackage Label
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelWishlist extends VmModel {

    /**
     * constructs a VmModel
     * setMainTable defines the maintable of the model
     * @author Max Milbers
     */
    function __construct() {
        parent::__construct('id');
        $this->setMainTable('wishlist');
    }

    /**
     * Load a single label
     */
    public function getWishlist() {

        $this->_data = $this->getTable('wishlist');
        $this->_data->load($this->_id);

        return $this->_data;
    }

    /**
     * Bind the post data to the label table and save it
     *
     * @author Roland
     * @author Max Milbers
     * @return boolean True is the save was successful, false otherwise.
     */
    public function checkExistingWishlist($data) {
        $existWishlist = array();

        if (is_array($data) && count($data) > 0) {
            $select = "id ";
            $joinTable = " FROM `#__virtuemart_wishlist` ";
            $whereClause = " WHERE user_id = " . $data['virtuemart_user_id'] . " AND product_id = " . $data['virtuemart_product_id'];
            $existWishlist = $this->exeSortSearchListQuery(null, $select, $joinTable, $whereClause);
        }

        if (count($existWishlist) == 0)
            return false;
        return true;
    }

    public function insertWishlist($data) {
        $db = JFactory::getDBO();
        $myuser = & JFactory::getUser();

        $q = "INSERT INTO `#__virtuemart_wishlist` (`product_id`, `user_id`, `quantity`,`create_date`) VALUES (" . $data['virtuemart_product_id'] . ',' . $data['virtuemart_user_id'] . ', ' . $data['quantity'] . ', NOW())';
        $db->setQuery($q);
        $db->query();
    }

    public function store($data) {

        /* Setup some place holders */

        if (!$this->checkExistingWishlist($data)) {
            $table = $this->getTable('wishlist');

            $table->bindChecknStore($data);
            $errors = $table->getErrors();

            foreach ($errors as $error) {
                $this->setError($error);
            }

            return $table->wishlist_id;
        }
    }

    /**
     * Select the products to list on the product list page
     */
    /*    public function getLabelList() {
      $db = JFactory::getDBO();
      // Pagination
      $this->getPagination();

      // Build the query
      $q = "SELECT
      ";
      $db->setQuery($q, $this->_pagination->limitstart, $this->_pagination->limit);
      return $db->loadObjectList('virtuemart_product_id');
      }
     */

    /**
     * Retireve a list of countries from the database.
     *
     * @param string $onlyPuiblished True to only retreive the publish countries, false otherwise
     * @param string $noLimit True if no record count limit is used, false otherwise
     * @return object List of label objects
     */
    /*
      public function getWishlists($noLimit=true) {

      $this->_noLimit = $noLimit;
      $mainframe = JFactory::getApplication();
      $user = JFactory::getUser();
      if(!$user->get('guest'))
      {
      $option	= 'com_virtuemart';
      $where = array();
      $select = ' p.virtuemart_product_id, wl.created_on as created_on_wl';
      $joinedTables = ' FROM `#__virtuemart_wishlist` as wl INNER JOIN #__virtuemart_products as p ON wl.virtuemart_product_id = p.virtuemart_product_id ';
      $ordering = $this->_getOrdering('wl.created_on');
      $where = " WHERE wl.virtuemart_user_id	= " . $user->id;
      return $this->_data = $this->exeSortSearchListQuery(0,$select,$joinedTables,$where,' ',$ordering );
      }
      return null;

      }
     */

    public function getWishlists() {
        $myuser = & JFactory::getUser();

        $whereString = '';
        $whereString .= ' WHERE `virtuemart_user_id` = ' . (int) $myuser->id;

        $select = ' w.wishlist_id, w.created_on, p.product_name, pp.product_price, p.virtuemart_product_id ';

        $joinedTables = ' FROM `#__virtuemart_wishlist` AS w ';
        $joinedTables .= ' INNER JOIN `#__virtuemart_products` AS p ON w.virtuemart_product_id = p.virtuemart_product_id ';
        $joinedTables .= ' INNER JOIN `#__virtuemart_product_prices` AS pp ON p.virtuemart_product_id = pp.virtuemart_product_id ';

        $ordering = $this->_getOrdering('created_on');

        $this->_data = $this->exeSortSearchListQuery(0, $select, $joinedTables, $whereString, ' ', $ordering);

        return $this->_data;
    }

    public function delete($product_id, $user_id) {
        $db = JFactory::getDBO();
        $q = "DELETE FROM `#__virtuemart_wishlist` WHERE `product_id` = " . $product_id . " AND `user_id` = " . $user_id;
        $db->setQuery($q);
        $db->query();
    }

    public function deleteAll($user_id) {
        $db = JFactory::getDBO();
        $q = "DELETE FROM `#__virtuemart_wishlist` WHERE `user_id` = " . $user_id;
        $db->setQuery($q);
        $db->query();
    }

    public function getProductInfo($product_id) {
        $sql = 'SELECT p.virtuemart_product_id, p.product_s_desc, p.product_name, pp.product_price, '
                . '(SELECT `virtuemart_media_id` FROM `#__virtuemart_product_medias` WHERE `virtuemart_product_id`=  p.virtuemart_product_id AND (`ordering` = 0 OR `ordering` = 1)) AS media_id '
                . 'FROM `#__virtuemart_products_' . VMLANG . '` AS p '
                . 'LEFT JOIN `#__virtuemart_product_prices` AS pp ON pp.virtuemart_product_id = p.virtuemart_product_id '
                . 'WHERE p.virtuemart_product_id = ' . $product_id;

        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $result = $db->loadObject();

        if ($result) {
            $result->thumb = '';

            if ($result->media_id) {
                if (!class_exists('VirtueMartModelCustomfields')) {
                    require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'customfields.php');
                }

                $result->thumb = VirtueMartModelCustomfields::displayCustomMedia($result->media_id);
            }
        }

        return $result;
    }

    public function getProductIdByUser($user_id) {
        $sql = 'SELECT product_id '
                . 'FROM `#__virtuemart_wishlist` '
                . 'WHERE `user_id` = ' . $user_id;

        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $result = $db->loadObjectList();

        $prodcutIdArray = array();

        if ($result) {
            foreach ($result as $value) {
                $prodcutIdArray[$value->product_id] = $value->product_id;
            }
        }

        return $prodcutIdArray;
    }

    public function getWishlistByUser($user_id) {
        $sql = 'SELECT product_id, quantity, create_date '
                . 'FROM `#__virtuemart_wishlist` '
                . 'WHERE `user_id` = ' . $user_id;

        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $result = $db->loadObjectList();


        return $result;
    }

    public function updateQuantity($user_id, $product_id, $quantity) {
        $db = JFactory::getDBO();
        $q = "UPDATE `#__virtuemart_wishlist` SET `quantity` = " . $quantity . " WHERE `user_id` = " . $user_id . " AND `product_id`  = " . $product_id;
        $db->setQuery($q);
        $db->query();
    }

}