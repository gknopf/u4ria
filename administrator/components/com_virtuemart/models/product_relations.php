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
class VirtueMartModelProduct_relations extends VmModel {

	/**
	 * constructs a VmModel
	 * setMainTable defines the maintable of the model
	 * @author Max Milbers
	 */
	function __construct() {
		parent::__construct('id');
		$this->setMainTable('product_relations');

	}


    /**
     * Load a single market_price
     */
     public function getProduct_relation() {

     	$this->_data = $this->getTable('product_relations');
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
		$table = $this->getTable('product_relations');

		$table->bindChecknStore($data);
		$errors = $table->getErrors();
		foreach($errors as $error){
			$this->setError($error);
		}

		return $table->id;
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
	public function getProduct_relations($noLimit=false, $getMedia=false) {

		$this->_noLimit = $noLimit;
		$mainframe = JFactory::getApplication();
// 		$db = JFactory::getDBO();
		$option	= 'com_virtuemart';


		$where = array();

		if ( $search && $search != 'true') {
			$search = '"%' . $this->_db->getEscaped( $search, true ) . '%"' ;
			//$search = $this->_db->Quote($search, false);
			$where[] .= 'LOWER( pr.`virtuemart_product_id` ) LIKE '.$search;
		}

		$select = ' pr.*, p.product_name ';

		$joinedTables = ' FROM `#__virtuemart_product_relations` AS pr ';
		$joinedTables .= ' LEFT JOIN `#__virtuemart_products` AS p ON pr.related_products = p.virtuemart_product_id ';
		$whereString = ' ';
		if (count($where) > 0) $whereString = ' WHERE '.implode(' AND ', $where).' ' ;

		$ordering = $this->_getOrdering('p.product_name');
		return $this->_data = $this->exeSortSearchListQuery(0,$select,$joinedTables,$whereString,' ',$ordering );

	}

	public function inputType($product_id,$row)
	{
		$q='SELECT `product_name`,`product_sku`,`product_s_desc` FROM `#__virtuemart_products` WHERE `virtuemart_product_id`='.(int)$product_id;
		$this->_db->setQuery($q);
		$related = $this->_db->loadObject();
		$display = $related->product_name.'('.$related->product_sku.')';
		$display .= '<input type="hidden" value="'.$product_id.'" name="field['.$row.'][custom_value]" />';

		$q='SELECT `virtuemart_media_id` FROM `#__virtuemart_product_medias`WHERE `virtuemart_product_id`= "'.(int)$product_id.'" ';
		$this->_db->setQuery($q);
		$thumb ='';
		if ($media_id = $this->_db->loadResult()) {
			$thumb = $this->displayCustomMedia($media_id);
		}
		else 
			$thumb = '<img src="../images/waiting_image.gif" border="0">';
		return $display.JHTML::link ( JRoute::_ ( 'index.php?option=com_virtuemart&view=product&task=edit&virtuemart_product_id='.$product_id),  $thumb, array ('title' => $related->product_name) );
	}
	
	function displayCustomMedia($media_id,$table='product'){

		if (!class_exists('TableMedias'))
			require(JPATH_VM_ADMINISTRATOR . DS . 'tables' . DS . 'medias.php');
		//$data = $this->getTable('medias');
		$db =& JFactory::getDBO();
		$data = new TableMedias($db);
   		$data->load((int)$media_id);

  		if (!class_exists('VmMediaHandler')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'mediahandler.php');
  			$media = VmMediaHandler::createMedia($data,$table);

		return $media->displayMediaThumb('',false,'',true,true);

	}
	
	function saveCustomData($data, $product_id){
		$q = "DELETE FROM #__virtuemart_product_relations WHERE virtuemart_product_id = " . $product_id;
		$this->_db->setQuery ( $q );
		$this->_db->query ();
		
		$q = "INSERT INTO `#__virtuemart_product_relations` (`id`,`virtuemart_product_id`,`related_products`,`type`,`created_on`,`created_by`,`modified_on`,`modified_by`) VALUES ";
		 
		if (is_array($data['related_products']))
		{
			$fields = array();
			for($i=0; $i < count($data['related_products']); $i++)
			{
				
				$fields['virtuemart_product_id'] = $product_id;
				$fields['related_products'] = $data['related_products'][$i];
				$fields['type'] = $data['type'][$i];
				$q .= "('0','" . $product_id . "','" . $fields['related_products'] . "','" . $fields['type'] . "',null,null,null,null),";
			}
			$q = substr($q, 0, strlen($q) - 1);
			$this->_db->setQuery ( $q );
			$this->_db->query ();
		}
	}
}
// pure php no closing tag