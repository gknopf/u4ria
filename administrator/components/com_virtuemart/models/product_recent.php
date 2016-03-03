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
jimport( 'joomla.application.component.model');

if(!class_exists('VmModel'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmmodel.php');

/**
 * Model class for VirtueMart Labels
 *
 * @package VirtueMart
 * @subpackage Label
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelProduct_recent extends VmModel {

	/**
	 * constructs a VmModel
	 * setMainTable defines the maintable of the model
	 * @author Max Milbers
	 */
	function __construct() {
		parent::__construct('virtuemart_recent_id');
		$this->setMainTable('product_recent');

	}
     
	public function store($data) {

		/* Setup some place holders */
	
		if (!$this->checkExists($data))
		{
			$table = $this->getTable('product_recent');
			
			$table->bindChecknStore($data);
			$errors = $table->getErrors();
			foreach($errors as $error){
				$this->setError($error);
			}
			
			return $table->virtuemart_recent_id;
		}
	}
	
	public function checkExists($data)
	{
		if (is_array($data) && count($data) > 0)
		{
			$select = "virtuemart_recent_id ";
			$joinTable = " FROM `#__virtuemart_product_recent` ";
			$whereClause = " WHERE virtuemart_product_id = " .	$data['virtuemart_product_id']. " AND ip_address = '" . $data['ip_address'] . "'";
			$existAlert = $this->exeSortSearchListQuery(null, $select, $joinTable, $whereClause);
			
		} 
		if (count($existAlert) == 0)
			return false;
		return true;
	}

}
// pure php no closing tag