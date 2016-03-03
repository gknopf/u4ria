<?php
/**
*
* Market_price controller
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
* @version $Id: market_price.php 3595 2011-07-02 15:29:14Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if(!class_exists('VmController'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmcontroller.php');


/**
 * Market_price Controller
 *
 * @package    VirtueMart
 * @subpackage Market_price
 * @author
 *
 */
class VirtuemartControllerHistory_Transactions extends VmController {

	/**
	 * Method to display the view
	 *
	 * @access	public
	 * @author
	 */
	function __construct() {
		parent::__construct('id');

	}
	
	/**
	 * Handle the save task
	 * Checks already in the controller the rights todo so and sets the data by filtering the post
	 *
	 * @author Max Milbers
	 */
	function save(){

		/* Load the data */
		$data = JRequest::get('post');
		/* add the mf desc as html code */

		parent::save($data);
	}

}
// pure php no closing tag
