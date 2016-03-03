<?php

/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Registration view class for Users.
 *
 * @package		Joomla.Site
 * @subpackage	com_users
 * @since		1.6
 */
class UsersViewManagement extends JViewLegacy {

    protected $data;
    protected $form;
    protected $params;
    protected $state;
    protected $orderList;

    /**
     * Method to display the view.
     *
     * @param	string	The template file to include
     * @since	1.6
     */
    public function display($tpl = null) {
        // Get the view data.
        $mainframe = JFactory::getApplication();
        $pathway = $mainframe->getPathway(); 
        $pathway->addItem(JText::_('JMANAGEMENT'));
        $address_type = JRequest::getVar('address_type', '');
        $this->assignRef('address_type', $address_type);
        if (!class_exists('VirtueMartCart'))
            require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
        $cart = VirtueMartCart::getCart();
        if($address_type == 'BT'){
            $cart->prepareAddressDataInCart('BT', false);            
            $userFields = $cart->BTaddress;  
            $this->assignRef('userFields', $userFields);
        }else if($address_type == 'ST'){
            $cart->prepareAddressDataInCart('ST', false);
            $userFieldsST = $cart->STaddress;                
            $this->assignRef('userFieldsST', $userFieldsST);
        }

        $this->data = $this->get('Data');
        $this->form = $this->get('Form');
        $this->state = $this->get('State');
        $this->params = $this->state->get('params');
        $this->billToAddress = $this->get('BillToAddress');
        $this->shipToAddress = $this->get('ShipToAddress');
        $this->tab = '';
        $this->tab = JRequest::getVar('tab', '');        
        if (!class_exists('VirtueMartCart'))
                require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
        $cart = VirtueMartCart::getCart();
        $this->reward_point = $cart->rewardPointWithOrder();
        $model = $this->getModel('Management');
        $this->orderList = $model->getOrderByUserId(JFactory::getUser()->get('id'));
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        // Check for layout override
        $active = JFactory::getApplication()->getMenu()->getActive();
        if (isset($active->query['layout'])) {
            $this->setLayout($active->query['layout']);
        }

        //Escape strings for HTML output
        $this->pageclass_sfx = htmlspecialchars($this->params->get('pageclass_sfx'));
        $this->prepareDocument();
        if (!class_exists('CurrencyDisplay'))
            require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');
        $currency = CurrencyDisplay::getInstance();
        $currencyDisplay = CurrencyDisplay::getInstance($currency->getCurrencyForDisplay());
        $this->assignRef('currencyDisplay', $currencyDisplay);
        $orderModel = VmModel::getModel('Orders');
        $orderList = $orderModel->getOrderListByMembership($this->data->id);
        $orderListTransaction = $orderModel->getOrderByUserIdSorted($this->data->id);
        $this->assignRef('orderList', $orderList);
        $this->assignRef('orderListTransaction', $orderListTransaction);
        $orderStatusModel = VmModel::getModel('orderstatus');
        $orderStates = $orderStatusModel->getOrderStatusList();
        $_orderStatusList = array();
        foreach ($orderStates as $orderState) {
            //$_orderStatusList[$orderState->virtuemart_orderstate_id] = $orderState->order_status_name;
            //When I use update, I have to use this?
            $_orderStatusList[$orderState->order_status_code] = JText::_($orderState->order_status_name);
        }
        $this->assignRef('orderStatusList', $_orderStatusList);
        $db = JFactory::getDBO();
        $q = 'SELECT * FROM `#__virtuemart_countries` WHERE virtuemart_country_id = "' 
                . (int) $this->billToAddress->virtuemart_country_id . '"';
        $db->setQuery($q);
        $country = $db->loadAssoc();
        $this->assignRef('country', $country);
        $q = 'SELECT * FROM `#__virtuemart_countries` WHERE virtuemart_country_id = "' 
        . (int) $this->shipToAddress->virtuemart_country_id . '"';
        $db->setQuery($q);
        $countryST = $db->loadAssoc();
        $this->assignRef('countryST', $countryST);
        $q = 'SELECT * FROM `#__virtuemart_countries` WHERE virtuemart_country_id = "' 
        . (int) (JFactory::getUser()->get('country')) . '"';
        $db->setQuery($q);
        $countryUser = $db->loadAssoc();
        $this->assignRef('countryUser', $countryUser);
        if($this->tab == 'transaction_detail'){
            $orderId = JRequest::getVar('order_id', '');
            $orderDetail = $orderModel->getOrder($orderId);
            $this->assignRef('orderDetail', $orderDetail);
        }
        parent::display($tpl);
    }

    /**
     * Prepares the document.
     *
     * @since	1.6
     */
    protected function prepareDocument() {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_USERS_REGISTRATION'));
        }

        $title = $this->params->get('page_title', '');
        if (empty($title)) {
            $title = $app->getCfg('sitename');
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }
        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }

}
