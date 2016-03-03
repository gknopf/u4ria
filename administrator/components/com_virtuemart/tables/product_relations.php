<?php

/**
 *
 * Product table
 *
 * @package	VirtueMart
 * @subpackage Product
 * @author RolandD
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: product_prices.php 4241 2011-10-03 22:52:05Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if(!class_exists('VmTableData'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmtabledata.php');

/**
 * Product table class
 * The class is is used to manage the products in the shop.
 *
 * @package	VirtueMart
 * @author RolandD
 * @author Max Milbers
 */
class TableProduct_relations extends VmTableData {

    /** @var int Primary key */
    var $id = 0;
    /** @var int Product id */
    var $virtuemart_product_id = 0;
    /** @var int Shopper group ID */
    var $related_products = null;
    var $type = 1;
    
    //------------------------
    /**
     * @author RolandD
     * @param $db A database connector object
     */
    function __construct(&$db) {
        parent::__construct('#__virtuemart_product_relations', 'id', $db);

        $this->setPrimaryKey('id');
		$this->setLoggable();
		$this->setTableShortCut('pr');
    }

    

}

// pure php no closing tag
