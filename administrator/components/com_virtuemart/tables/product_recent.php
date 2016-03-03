<?php
/**
*
* Alert product table
*
* @package	VirtueMart
* @subpackage Label
* @author Patrick Kohl
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: labels.php 4227 2011-10-03 08:39:27Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if(!class_exists('VmTable'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmtable.php');

/**
 * Label table class
 * The class is used to manage the label table in the shop.
 *
 * @package		VirtueMart
 * @author Max Milbers
 */
class TableProduct_recent extends VmTable {

	/** @var int Primary key */
	var $virtuemart_recent_id = 0;
	var $virtuemart_product_id = 0;
	var $ip_address = '';
	var $created_date = '';
	/**
	 * @author Max Milbers
	 * @param $db A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__virtuemart_product_recent', 'virtuemart_recent_id', $db);

	}

}
// pure php no closing tag
