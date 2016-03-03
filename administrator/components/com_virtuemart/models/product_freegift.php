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
jimport('joomla.application.component.model');

if (!class_exists('VmModel'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmmodel.php');

/**
 * Model class for VirtueMart Market_prices
 *
 * @package VirtueMart
 * @subpackage Market_price
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelProduct_Freegift extends VmModel {

    /**
     * constructs a VmModel
     * setMainTable defines the maintable of the model
     * @author Max Milbers
     */
    function __construct() {
        parent::__construct('id');
        $this->setMainTable('product_freegift');
    }

    public function getProductFreegift() {

        $this->_data = $this->getTable('product_freegift');
        $this->_data->load($this->_id);
        return $this->_data;
    }

    public function store($data) {
        /* Setup some place holders */
        $table = $this->getTable('product_freegift');
        $product_id = '';
        if (is_array($data['freegiftArray'])) {
            $product_id = implode(',', $data['freegiftArray']);
        }
        $data['product_id'] = $product_id;
        $table->bindChecknStore($data);
        $errors = $table->getErrors();
        foreach ($errors as $error) {
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
    function saveData($data, $product_id) {
        $sql = 'DELETE FROM #__virtuemart_product_freegift WHERE product_id = ' . $product_id;
        $this->_db->setQuery($sql);
        $this->_db->query();
        $sql = "INSERT INTO `#__virtuemart_product_freegift` (`product_id`, `product_freegift_id`, `condition`) VALUES ";
        if (is_array($data['freegiftArray'])) {
            foreach ($data['freegiftArray'] as $key => $value) {
                $sql .= '(' . $product_id . ',' . $value . ',' . $data['freegift_' . $value] . '),';
            }

            $sql = rtrim($sql, ',');
            $this->_db->setQuery($sql);
            $this->_db->query();
        }
    }

    public function renderSpecialDealHtml($id, $productIds) {
        $sql = 'SELECT p.virtuemart_product_id, product_s_desc, p.product_name, `virtuemart_media_id`  AS media_id, 
	`product_price` AS product_price 
        FROM `#__virtuemart_products_' . VMLANG . '` AS p LEFT JOIN
        `#__virtuemart_product_medias` AS m ON p.virtuemart_product_id = m.virtuemart_product_id
        LEFT JOIN `#__virtuemart_product_prices` pp ON pp.virtuemart_product_id = m.virtuemart_product_id
          WHERE p.virtuemart_product_id in (' . $productIds . ') AND (ordering is NULL OR ordering = 1)';
        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $resultArray = $db->loadObjectList();
        $html = '';

        if ($resultArray) {
            foreach ($resultArray as $value) {
                $display = '<input type="hidden" value="' . $value->virtuemart_product_id . '" name="freegiftArray[]" />';
                $thumb = '';


                if ($value->media_id) {
                    if (!class_exists('VirtueMartModelCustomfields')) {
                        require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'customfields.php');
                    }

                    $thumb = VirtueMartModelCustomfields::displayCustomMedia($value->media_id);
                }

                $title = $value->product_s_desc ? $value->product_s_desc : '';
                $display .= JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=product&task=edit&virtuemart_product_id=' . $value->product_freegift_id), $thumb . '<br /> ' . $value->product_name, array('title' => $title));

                if (!class_exists('CurrencyDisplay')) {
                    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');
                }

                $currency = CurrencyDisplay::getInstance();

                $html .= '<div class="vm_thumb_image"><span>' . $display . '</span><br/><span>' . $currency->createPriceDiv('salesPrice', '', $value->product_price, true) . '</span><br/>'
                        . '<div class="vmicon vmicon-16-remove"></div></div>';
            }
        }

        return $html;
    }
    
    public function getFreeGiftMedia($productIds) {
        $sql = 'SELECT p.virtuemart_product_id, product_s_desc, p.product_name, `virtuemart_media_id`  AS media_id, 
	`product_price` AS product_price 
        FROM `#__virtuemart_products_' . VMLANG . '` AS p LEFT JOIN
        `#__virtuemart_product_medias` AS m ON p.virtuemart_product_id = m.virtuemart_product_id
        LEFT JOIN `#__virtuemart_product_prices` pp ON pp.virtuemart_product_id = m.virtuemart_product_id
          WHERE p.virtuemart_product_id in (' . $productIds . ') AND (ordering is NULL OR ordering = 1)';
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

                    $value->thumb = VirtueMartModelCustomfields::displayCustomMedia($value->media_id);
                }
            }
        }

        return $resultArray;
    }
    public function getAllFreegift($product_id) {
        $sql = 'SELECT psd.product_freegift_id, psd.condition, p.product_s_desc, p.product_name, pp.product_price, p1.product_sku, '
                . '(SELECT `virtuemart_media_id` FROM `#__virtuemart_product_medias` WHERE `virtuemart_product_id`=  psd.product_freegift_id AND (`ordering` = 0 OR `ordering` = 1)) AS media_id '
                . 'FROM `#__virtuemart_product_freegift` AS psd '
                . 'LEFT JOIN `#__virtuemart_products_' . VMLANG . '` AS p ON p.virtuemart_product_id = psd.product_freegift_id '
                . 'LEFT JOIN `#__virtuemart_products` AS p1 ON p1.virtuemart_product_id = psd.product_freegift_id '
                . 'LEFT JOIN `#__virtuemart_product_prices` AS pp ON pp.virtuemart_product_id = psd.product_freegift_id '
                . 'WHERE psd.product_id = ' . $product_id;

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

                    $value->thumb = VirtueMartModelCustomfields::displayCustomMedia($value->media_id);
                }
            }
        }

        return $resultArray;
    }

    public function getFreegifts() {
        $sql = 'SELECT psd.id, psd.product_id, psd.condition, psd.free_gift_name '
                . 'FROM `#__virtuemart_product_freegift` AS psd ORDER BY psd.condition DESC';
        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $resultArray = $db->loadObjectList();
        return $resultArray;
    }

    public function getAllProducts() {
        $sql = 'SELECT p.product_s_desc, p.product_name, p1.product_sku, p1.virtuemart_product_id '
                . 'FROM `#__virtuemart_products_' . VMLANG . '` AS p '
                . 'LEFT JOIN `#__virtuemart_products` AS p1 '
                . ' ON p.virtuemart_product_id = p1.virtuemart_product_id ';
        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $resultArray = $db->loadObjectList();
        return $resultArray;
    }

}

// pure php no closing tag