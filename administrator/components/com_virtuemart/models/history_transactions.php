<?php

/**
 *
 * VirtueMartModelHistoryTransactions
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
 * Model class for History Transactions
 *
 * @package VirtueMart
 * @subpackage Market_price
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelHistory_transactions extends VmModel {

    /**
     * constructs a VmModel
     * setMainTable defines the maintable of the model
     * @author Max Milbers
     */
    function __construct() {
        parent::__construct('history_transaction_id');
        $this->setMainTable('history_transactions');
    }

    public function getHistoryTransactions($productId, $userId) {

        $sql = 'SELECT history_transaction_id '
                . 'FROM `#__virtuemart_history_transactions` '
                . 'WHERE `user_id` = ' . $userId
                . ' AND virtuemart_product_id = ' . $productId;

        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $result = $db->loadObjectList();
        return $result;
    }

    public function storeHistoryTransaction($productId, $userId) {
        $historyTransactionList = $this->getHistoryTransactions($productId, $userId);
        if (empty($historyTransactionList)) {
            $table = $this->getTable('history_transactions');
            $data['virtuemart_product_id'] = $productId;
            $data['user_id'] = $userId;
            $data['quantity'] = 1;
            $data['date_buy'] = date("Y-m-d H:i:s");
            $table->bindChecknStore($data);
        } else {
            $db = JFactory::getDBO();
            $q = "UPDATE #__virtuemart_history_transactions " .
                    "SET quantity = quantity + 1, date_buy = NOW() "
                    . " WHERE user_id = " . $userId
                    . " AND virtuemart_product_id  = " . $productId;
            $db->setQuery($q);
            $db->query();
        }
    }
    
    public function deleteHistoryTransaction($product_id, $userId) {
        $db = JFactory::getDBO();
        $q = "DELETE FROM #__virtuemart_history_transactions WHERE (virtuemart_product_id in (" 
                . $product_id . ")) AND user_id = " . $userId;
        $db->setQuery($q);
        $db->query();
    }
    
    public function getAllHistoryTransaction(){
        $sql = 'SELECT h.*,p.product_name, u.username, u.firstname, u.lastname, u.email, u.phone '
                .' FROM #__virtuemart_history_transactions as h JOIN '
                .'#__virtuemart_products_' . VMLANG . ' AS p '
                . ' ON p.virtuemart_product_id = h.virtuemart_product_id JOIN #__users as u '
                .' ON h.user_id = u.id ORDER BY u.username';
        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $resultArray = $db->loadObjectList();
        return $resultArray;
    }

}