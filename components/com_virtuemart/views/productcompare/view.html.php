<?php
/**
*
* Product details view
*
* @package VirtueMart
* @subpackage
* @author RolandD
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: view.html.php 4597 2011-10-31 20:46:38Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if (!class_exists('VmView'))
    require(JPATH_VM_SITE . DS . 'helpers' . DS . 'vmview.php');

/**
* Product details
*
* @package VirtueMart
* @author RolandD
* @author Max Milbers
*/
class VirtueMartViewProductcompare extends VmView {

	/**
	* Collect all data to show on the template
	*
	* @author RolandD, Max Milbers
	*/
	function display($tpl = null) {

		//TODO get plugins running
//		$dispatcher	= JDispatcher::getInstance();
//		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		$show_prices  = VmConfig::get('show_prices',1);
		if($show_prices == '1'){
			if(!class_exists('calculationHelper')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'calculationh.php');
		}
		$this->assignRef('show_prices', $show_prices);

		$document = JFactory::getDocument();

		/* add javascript for price and cart */
		vmJsApi::jPrice();

		$mainframe = JFactory::getApplication();
		$pathway = $mainframe->getPathway();
		$task = JRequest::getCmd('task');

		/* Set the helper path */
		$this->addHelperPath(JPATH_VM_ADMINISTRATOR.DS.'helpers');

		/* Load helpers */
		$this->loadHelper('image');


		/* Load the product */
//		$product = $this->get('product');	//Why it is sensefull to use this construction? Imho it makes it just harder
		$product_model = VmModel::getModel('product');

		$virtuemart_product_idArray = JRequest::getInt('virtuemart_product_id',0);
		if(is_array($virtuemart_product_idArray)){
			$virtuemart_product_id=$virtuemart_product_idArray[0];
		} else {
			$virtuemart_product_id=$virtuemart_product_idArray;
		}

		//checkExistProductCompareList$_SESSION["product_to_compare"] = array();
		$tempProductList = $_SESSION["product_to_compare"];
		if (!$this->checkExistProductCompareList($tempProductList, $virtuemart_product_id))
		{
			$tempProductList[] = $virtuemart_product_id;
			$_SESSION["product_to_compare"] = $tempProductList;
		}
		
		
		$products = $product_model->getProducts($_SESSION["product_to_compare"]);
		$product_model->addImages($products);
                $this->assignRef('products', $products);

		/*foreach($products as $product){
			$product->stock = $product_model->getStockIndicator($product);
			$product->votes = $product_model->getVotes($product->virtuemart_product_id) ;
		}*/

		vmdebug('my count of products '.count($products) );

		if ($products) {
		$currency = CurrencyDisplay::getInstance( );
		$this->assignRef('currency', $currency);
		}

		if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
		$showBasePrice = Permissions::getInstance()->check('admin'); //todo add config settings
		$this->assignRef('showBasePrice', $showBasePrice);


	    if(empty($category->category_template)){
	    	$category->category_template = VmConfig::get('categorytemplate');
	    }

		//shopFunctionsF::setVmTemplate($this,$category->category_template,$product->product_template,$category->category_layout,$product->layout);

		//shopFunctionsF::addProductToRecent($virtuemart_product_id);

		$currency = CurrencyDisplay::getInstance( );
		$this->assignRef('currency', $currency);

		parent::display($tpl);
	}
	
	function checkExistProductCompareList($tempProductList, $productID)
	{
		if ($tempProductList)
		{
			foreach ($tempProductList as $product)
			{
				if ($product == $productID)
					return true;
			}
		}
	 	return false;
	}
	
 	function renderMailLayout() {
		$this->setLayout('mail_html_question');
		$this->comment = JRequest::getString('comment');
	
		$vendorModel = $this->getModel('vendor');
		$this->vendor = $vendorModel->getVendor();
	
		$this->subject = Jtext::_('COM_VIRTUEMART_QUESTION_ABOUT') . $this->product->product_name;
		$this->vendorEmail= $this->user['email'];
		//$this->vendorName= $this->user['email'];
		if (VmConfig::get('order_mail_html')) {
		    $tpl = 'mail_html_question';
		} else {
		    $tpl = 'mail_raw_question';
		}
		$this->setLayout($tpl);
		parent::display( );
    }
	
	private function showLastCategory($tpl) {
			$virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId();
			$categoryLink='';
			if($virtuemart_category_id){
				$categoryLink='&virtuemart_category_id='.$virtuemart_category_id;
			}
			$continue_link = JRoute::_('index.php?option=com_virtuemart&view=category'.$categoryLink);

			$continue_link_html = '<a href="'.$continue_link.'" />'.JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING').'</a>';
			$this->assignRef('continue_link_html', $continue_link_html);
			/* Display it all */
			parent::display($tpl);
	}

}

// pure php no closing tag