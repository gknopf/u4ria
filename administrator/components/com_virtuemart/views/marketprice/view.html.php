<?php
/**
 *
 * Market_price View
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
 * @version $Id: view.html.php 4223 2011-10-02 16:51:31Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if(!class_exists('VmView'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmview.php');
jimport('joomla.html.pane');
/**
 * HTML View class for maintaining the list of market_prices
 *
 * @package	VirtueMart
 * @subpackage Market_price
 * @author Patrick Kohl
 */
class VirtuemartViewMarketPrice extends VmView {

	function display($tpl = null) {

		// Load the helper(s)
		$this->loadHelper('html');

		// get necessary models
		$model = VmModel::getModel('MarketPrice');
		$this->SetViewTitle();
		$layoutName = JRequest::getWord('layout', 'default');
		if ($layoutName == 'edit') {
			$priceMatch = $model->getMarketPrice();
			$isNew = ($priceMatch->virtuemart_market_price_id < 1);
			$this->assignRef('priceMatch',	$priceMatch);

			
			/* Process the images */
			$this->addStandardEditViewCommands($priceMatch->virtuemart_market_price_id);
			if(!class_exists('VirtueMartModelVendor')) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'vendor.php');
			$virtuemart_vendor_id = VirtueMartModelVendor::getLoggedVendor();
			$this->assignRef('virtuemart_vendor_id', $virtuemart_vendor_id);


		}
		else 
		{
			$mainframe = JFactory::getApplication();
			$market_prices = $model->getMarket_prices();
			
			$this->addStandardDefaultViewCommands();
			$this->addStandardDefaultViewLists($model,'product_name');
			
			
			$this->assignRef('market_prices', $market_prices);
			$pagination = $model->getPagination();
			$this->assignRef('pagination', $pagination);
		}
		parent::display($tpl);
	}

}
// pure php no closing tag
