<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2012 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: view.json.php 6543 2012-10-16 06:41:27Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
jimport( 'joomla.application.component.view');
		// Load some common models
if(!class_exists('VirtueMartModelCustomfields')) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'customfields.php');

/**
 * HTML View class for the VirtueMart Component
 *
 * @package		VirtueMart
 * @author
 */
class VirtuemartViewProduct_freegift extends JView {

	var $json = array();

	function __construct( ){

		$this->type = JRequest::getWord('type', false);
		$this->row = JRequest::getInt('row', false);
		$this->db = JFactory::getDBO();
		$this->model = VmModel::getModel('Customfields') ;

	}
	function display($tpl = null) {

		//$this->loadHelper('customhandler');

		$filter = JRequest::getVar('q', JRequest::getVar('term', false) );
		if ($this->type=='freegift') {
			$query = "SELECT virtuemart_product_id AS id, CONCAT(product_name, '::', product_sku) AS value, product_name , product_s_desc,
			  (SELECT `virtuemart_media_id` FROM `#__virtuemart_product_medias` WHERE `virtuemart_product_id`=  p.`virtuemart_product_id` AND (`ordering` = 0 OR `ordering` = 1)) AS media_id,
			  (SELECT `product_price` FROM `#__virtuemart_product_prices` WHERE `virtuemart_product_id`=  p.`virtuemart_product_id`) AS product_price
				FROM #__virtuemart_products_".VMLANG."
				JOIN `#__virtuemart_products` AS p using (`virtuemart_product_id`)";
			if ($filter) $query .= " WHERE product_name LIKE '%". $this->db->getEscaped( $filter, true ) ."%' or product_sku LIKE '%". $this->db->getEscaped( $filter, true ) ."%' limit 0,10";
			self::setFreegiftHtml($query);
		}else $this->json['ok'] = 0 ;

		if ( empty($this->json)) {
			$this->json['value'] = null;
			$this->json['ok'] = 1 ;
		}

		echo json_encode($this->json);

	}

	public function setFreegiftHtml($query) {
	  $this->db->setQuery($query);
	  $this->json = $this->db->loadObjectList();

	  foreach ($this->json as &$freegift) {
	    $display = '<input type="hidden" value="' . $freegift->id . '" name="freegiftArray[]" />';
	    $thumb = '';

	    if ($freegift->media_id) {
	      if (!class_exists('VirtueMartModelCustomfields')) {
	        require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'customfields.php');
	      }

	      $thumb = VirtueMartModelCustomfields::displayCustomMedia($freegift->media_id);
	    }

	    $title= $freegift->product_s_desc ?  $freegift->product_s_desc : '';
	    $display .= JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=product&task=edit&virtuemart_product_id=' . $freegift->id), $thumb . '<br/><span> ' . $freegift->product_name . '</span>', array('title' => $title));

	    if (!class_exists ('CurrencyDisplay')) {
	      require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');
	    }

	    $currency = CurrencyDisplay::getInstance ();

	    $html = '<div class="vm_thumb_image"><span>' . $display . '</span><br/><span>' . $currency->createPriceDiv('salesPrice', '', $freegift->product_price, true)  . '</span><br/>'
	    . '<div class="vmicon vmicon-16-remove"></div></div>';

	    $freegift->label = $html;
	  }
	}
}
// pure php no closing tag
