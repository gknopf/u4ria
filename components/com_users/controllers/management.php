<?php

/**
 *
 * Description
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: productdetails.php 6425 2012-09-11 20:17:08Z Milbo $
 */
// Check to ensure this file is included in Joomla!

defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT . '/controller.php';
// Load the controller framework
jimport('joomla.application.component.controller');
if (!class_exists('VmConfig'))
    require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');

/**
 * VirtueMart Component Controller
 *
 * @package VirtueMart
 * @author RolandD
 */
class UsersControllerManagement extends JController {

    public function __construct() {
        parent::__construct();
        $this->registerTask('recommend', 'MailForm');
        $this->registerTask('askquestion', 'MailForm');

        $path_nano_scroller = JURI::base() . 'components/com_virtuemart/assets/nanoscroller';
        $doc = &JFactory::getDocument();
        $doc->addScript($path_nano_scroller . '/javascripts/overthrow.min.js');
        $doc->addScript($path_nano_scroller . '/javascripts/jquery.nanoscroller.js');
// 		$doc->addScript($path_nano_scroller . '/javascripts/vr_u4ria.js');
        $doc->addStyleSheet($path_nano_scroller . '/css/nanoscroller.css');
    }

    function display($cachable = false, $urlparams = false) {

        $format = JRequest::getWord('format', 'html');
        if ($format == 'pdf') {
            $viewName = 'Pdf';
        } else {
            $viewName = '111';
        }

        $view = $this->getView($viewName, $format);

        $view->display();
    }

    public function editaddress() {
        $data = JRequest::get('post');
        $requestData = JRequest::getVar('shipto_date_of_birth', array(), 'post', 'array');
        if ($requestData['year'] != 0 && $requestData['month'] != 0 && $requestData['day'] != 0) {
            $date = new DateTime($requestData['year'].'-'.$requestData['month'].'-'.$requestData['day']);
            $data['shipto_date_of_birth']  = $date->format('Y-m-d');
        } else {
            $data['shipto_date_of_birth'] = "";
        }
        
        
        $requestData = JRequest::getVar('date_of_birth', array(), 'post', 'array');
        if ($requestData['year'] != 0 && $requestData['month'] != 0 && $requestData['day'] != 0) {
            $date = new DateTime($requestData['year'].'-'.$requestData['month'].'-'.$requestData['day']);
            $data['date_of_birth']  = $date->format('Y-m-d');
         } else {
            $data['date_of_birth'] = "";
        }
        $this->addModelPath(JPATH_VM_ADMINISTRATOR . DS . 'models');
        $userModel = VmModel::getModel('user');

        if ($userModel->store($data)) {
            if (!class_exists('VirtueMartCart'))
                require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
            $cart = VirtueMartCart::getCart();
            $cart->saveAddressInCart($data, $data['address_type']);
            
            $this->setRedirect(JRoute::_('index.php?option=com_users&view=management&tab=address', false));
        }
    }
    public function upgradedmember(){
        $user = JFactory::getUser();
        $model = $model = $this->getModel('Management');
//        $userCurrent = $model->getCurrentUserId($user->id);
        $orderModel = VmModel::getModel('Orders');
        $orderList = $orderModel->getOrderListByMembership($user->id);
        if($user->reward_point < $orderList->rp_upgrade){
           $this->setRedirect(JRoute::_('index.php?option=com_users&view=management&tab=profile'), JText::_('COM_USERS_USER_UPGRADED_FAILED')); 
           return;
        }
        $db = JFactory::getDBO();
        $q = 'UPDATE `#__users` SET date_change_level = \''.date('Y-m-d').'\''
                .' , level_type = '.$orderList->next_user_level_id
                .' , reward_point = reward_point - '.$orderList->rp_upgrade
                .' WHERE id = '.$user->id;
        $db->setQuery($q);
        $db->query();
        $session = JFactory::getSession();
        $session->set('user', new JUser($user->id)); // Force load from database
        $this->setRedirect(JRoute::_('index.php?option=com_users&view=management&tab=membership', JText::_('COM_USERS_USER_UPGRADED_SUCCESS')));
    }
}
// pure php no closing tag

    