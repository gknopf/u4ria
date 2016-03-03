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
class VirtueMartModelMarketPrice extends VmModel {

	/**
	 * constructs a VmModel
	 * setMainTable defines the maintable of the model
	 * @author Max Milbers
	 */
	function __construct() {
		parent::__construct('virtuemart_market_price_id');
		$this->setMainTable('market_prices');

	}


    /**
     * Load a single market_price
     */
     public function getMarketPrice() {
     	$this->_data = $this->getTable('market_prices');
     	$this->_data->load($this->_id);
     	return $this->_data;
     }

     /**
	 * Bind the post data to the market_price table and save it
     *
     * @author Roland
     * @author Max Milbers
     * @return boolean True is the save was successful, false otherwise.
	 */
	public function store($data) {

		/* Setup some place holders */
		$table = $this->getTable('market_prices');
		$table->bindChecknStore($data);
		
		$sql = "SELECT AVG(mk_price) as mk_price FROM #__virtuemart_market_prices group by virtuemart_product_id ";
		$this->_db->setQuery($sql);
		$averageMarketPrice = $this->_db->loadObjectList();
		
		if ($averageMarketPrice)
		{
			$sql = "UPDATE #__virtuemart_product_prices SET product_marketing_price = '" . $averageMarketPrice->mk_price . "'
					 WHERE virtuemart_product_id = '" . $data['virtuemart_product_id'] . "'";
			$this->_db->setQuery ( $sql );
			$this->_db->query ();
		}
		$errors = $table->getErrors();
		foreach($errors as $error){
			$this->setError($error);
		}

		return $table->virtuemart_market_price_id;
	}
	
	public function save($data) {
		$table = $this->getTable('market_prices');
			
		$table->bindChecknStore($data);
		$errors = $table->getErrors();
		
		foreach($errors as $error){
			$this->setError($error);
		}

		return $table->virtuemart_market_price_id;
	}

    /**
     * Select the products to list on the product list page
     */
/*    public function getMarket_priceList() {
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
	 * @return object List of market_price objects
	 */
	public function getMarket_prices($onlyPublished=false, $noLimit=false, $getMedia=false) {

		$this->_noLimit = $noLimit;
		$mainframe = JFactory::getApplication();
// 		$db = JFactory::getDBO();
		$option	= 'com_virtuemart';


		$where = array();

		if ( $search && $search != 'true') {
			$search = '"%' . $this->_db->getEscaped( $search, true ) . '%"' ;
			//$search = $this->_db->Quote($search, false);
			$where[] .= 'LOWER( mk.`mk_price` ) LIKE '.$search;
		}

		if ($onlyPublished) {
			$where[] .= 'mk.`published` = 1';
		}

		$select = ' mk.*, pd.product_name, u.username ';

		$joinedTables = ' FROM `#__virtuemart_market_prices` AS mk ';
		$joinedTables .= ' LEFT JOIN `#__virtuemart_products` AS p ON mk.virtuemart_product_id = p.virtuemart_product_id ';
		$joinedTables .= ' LEFT JOIN `#__virtuemart_products_en_gb` as pd ON  mk.virtuemart_product_id = pd.virtuemart_product_id ';
		$joinedTables .= ' LEFT JOIN `#__users` AS u ON mk.created_by = u.id ';
		$whereString = ' ';
		if (count($where) > 0) $whereString = ' WHERE '.implode(' AND ', $where).' ' ;

		$ordering = $this->_getOrdering('mk.published asc,');
		return $this->_data = $this->exeSortSearchListQuery(0,$select,$joinedTables,$whereString,' ',$ordering );

	}

}
// pure php no closing tag