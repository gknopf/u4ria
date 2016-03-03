<?php
/**
*
* Market_price table
*
* @package	VirtueMart
* @subpackage Market_price
* @author Patrick Kohl
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: market_prices.php 4227 2011-10-03 08:39:27Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if(!class_exists('VmTable'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmtable.php');

/**
 * Market_price table class
 * The class is used to manage the market_price table in the shop.
 *
 * @package		VirtueMart
 * @author Max Milbers
 */
class TableHistory_transactions extends VmTable {

	/** @var int Primary key */
        var $history_transaction_id = 0;
        var $virtuemart_product_id = 0;
	var $user_id = 0;
        var $quantity = 0;
        var $date_buy;

	/**
	 * @author truonghx
	 * @param $db A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__virtuemart_history_transactions', 'history_transaction_id', $db);
		$this->setTableShortCut('vht');
	}

}
// pure php no closing tag
