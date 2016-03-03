<?php
/**
 *
 * Label View
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
 * @version $Id: view.html.php 4223 2011-10-02 16:51:31Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if(!class_exists('VmView'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmview.php');
jimport('joomla.html.pane');
/**
 * HTML View class for maintaining the list of labels
 *
 * @package	VirtueMart
 * @subpackage Label
 * @author Patrick Kohl
 */
class VirtuemartViewLabel extends VmView {

	function display($tpl = null) {

		$this->loadHelper('html');
		JView::loadHelper('image');

		// get necessary models
		$model = VmModel::getModel('label');

		$this->SetViewTitle();
		//$this->assignRef('viewName',$viewName);

		$layoutName = JRequest::getWord('layout', 'default');
		
		if ($layoutName == 'edit') {

			$label = $model->getLabel();
			$isNew = ($label->virtuemart_label_id < 1);

			$model->addImages($label);
			$this->assignRef('label',$label);

			/* Process the images */
//			$mediaModel = VmModel::getModel('media');
//			$mediaModel -> setId($label->virtuemart_media_id);
//			$image = $mediaModel->getFile('label','image');
	
			$this->addStandardEditViewCommands($label->virtuemart_label_id);
			
//			if(!class_exists('VirtueMartModelVendor')) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'vendor.php');
//			
//			$virtuemart_vendor_id = VirtueMartModelVendor::getLoggedVendor();
//			$this->assignRef('virtuemart_vendor_id', $virtuemart_vendor_id);


		}
		else {

			$mainframe = JFactory::getApplication();
			$labels = $model->getLabels();
			$this->assignRef('labels',	$labels);
			$this->addStandardDefaultViewCommands();
			$this->addStandardDefaultViewLists($model,'lb_thumb_text');
			$pagination = $model->getPagination();
			$this->assignRef('pagination', $pagination);
			

		}


		parent::display($tpl);
		
	}

}
// pure php no closing tag
