<?php
/**
*
* Review controller
*
* @package	VirtueMart
* @subpackage
* @author Max Milberes
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: ratings.php 6219 2012-07-04 16:10:42Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if (!class_exists ('VmController')){
	require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmcontroller.php');
}


/**
 * Review Controller
 *
 * @package    VirtueMart
 * @author Max Milbers
 */
class VirtuemartControllerAverage_Ratings extends VmController {

	public function __construct() {
		parent::__construct();

	}
	function edit(){

		JRequest::setVar('controller', $this->_cname);
		JRequest::setVar('view', $this->_cname);
		JRequest::setVar('layout', 'edit');
// 		JRequest::setVar('hidemenu', 1);

		if(empty($view)){
			$document = JFactory::getDocument();
			$viewType = $document->getType();
			$view = $this->getView($this->_cname, $viewType);
		}


		parent::display();
	}

	function saveAverageRate(){

		$this->storeAverageRate(FALSE);
	}
	function save(){

		$this->storeAverageRate(FALSE);
	}
	/**
	 * Save task for review
	 *
	 * @author Max Milbers
	 */
	function apply(){
		$this->storeAverageRate(TRUE);
	}


	function storeAverageRate($apply){
		JRequest::checkToken() or jexit( 'Invalid Token save' );

		if (empty($data)){
			$data = JRequest::get ('post');
		}

                $db = JFactory::getDBO();
                for ($index = 1; $index < 6; $index++) {  
                    if($data['star_'.$index] < 0) $data['star_'.$index]= 0;
                    $save['virtuemart_average_rating_id']=$data['virtuemart_average_rating_id'];
                    $save['virtuemart_product_id']=$data['virtuemart_product_id'];
                    $save['rate']=$index;
                    $save['ratingcount']=$data['star_'.$index];
                    $save['published']=1;
                    $save['created_on']=$data['created_on'];
                    $save['modified_on']=$data['modified_on'];
                    
                    $q = 'UPDATE #__virtuemart_average_ratings set ratingcount='.$save['ratingcount'].' WHERE rate='.$index.' AND virtuemart_product_id='.$data['virtuemart_product_id'];
                    $db->setQuery($q);
                    $db->query();
//                    vmError(get_class( $this ).'::Error store votes '.$save['ratingcount'].'-'.$save['rate'].'-' .$save['virtuemart_product_id']);
                }

		$redir = $this->redirectPath;
		if($apply){
			$redir = 'index.php?option=com_virtuemart&view=average_ratings&task=edit&cid[]='.$save['virtuemart_product_id'];
		} else {
//			$virtuemart_product_id = JRequest::getInt('virtuemart_product_id',0);
			$redir = 'index.php?option=com_virtuemart&view=average_ratings';
		}

		$this->setRedirect($redir, $msg);
	}
	/**
	 * Save task for review
	 *
	 * @author Max Milbers
	 */
	function cancelEditReview(){

		$virtuemart_product_id = JRequest::getInt('virtuemart_product_id',0);
		$msg = JText::sprintf('COM_VIRTUEMART_STRING_CANCELLED',$this->mainLangKey); //'COM_VIRTUEMART_OPERATION_CANCELED'
		$this->setRedirect('index.php?option=com_virtuemart&view=ratings&task=listreviews&virtuemart_product_id='.$virtuemart_product_id, $msg);
	}
        
}
// pure php no closing tag
