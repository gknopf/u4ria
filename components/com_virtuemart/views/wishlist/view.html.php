<?php

defined('_JEXEC') or die('Restricted access');

// Load the view framework
//if(!class_exists('VmView'))require(JPATH_VM_SITE.DS.'helpers'.DS.'vmview.php');

// Set to '0' to use tabs i.s.o. sliders
// Might be a config option later on, now just here for testing.
define('__VM_USER_USE_SLIDERS', 0);

/**
 * HTML View class for maintaining the list of users
 *
 * @package	VirtueMart
 * @subpackage Vendor
 * @author Max Milbers
 */
class VirtuemartViewWishlist extends JViewLegacy {
//class VirtuemartViewWishlist extends VmView {

	function display($tpl = null) {

//		$document = JFactory::getDocument();
//		$mainframe = JFactory::getApplication();
//		$pathway = $mainframe->getPathway();
		//$layoutName = $this->getLayout();

		//$model = VmModel::getModel();
//http://localhost:81/u4rianew/trunk/4_Implementation/u4ria/index.php?
//option=com_virtuemart&view=popupcategory&task=popupcategory
//&virtuemart_category_id=8&tmpl=component
		parent::display($tpl);

	}

}

//No Closing Tag
