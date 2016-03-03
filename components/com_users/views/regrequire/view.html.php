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
class UsersViewRegrequire extends JViewLegacy {

    protected $data;
    protected $form;
    protected $params;
    protected $state;

    /**
     * Method to display the view.
     *
     * @param	string	The template file to include
     * @since	1.6
     */
    public function display($tpl = null) {
        // Get the view data.
        $this->data = $this->get('Data');
        $this->form = $this->get('Form');
        $this->state = $this->get('State');
        $this->params = $this->state->get('params');
        $mainframe = JFactory::getApplication();
        $pathway = $mainframe->getPathway();
//        $pathway->addItem(JText::_('JMANAGEMENT'));
        $pathway->addItem('Sign In');
        //Get data for edit address
        $address_type = JRequest::getWord('addrtype', 'XT');
	$this->assignRef('address_type', $address_type);
        
        if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');

            VmConfig::loadConfig();
            VmConfig::loadJLang('mod_virtuemart_cart', true);
        if(!class_exists('VirtueMartCart')) require(JPATH_VM_SITE.DS.'helpers'.DS.'cart.php');
        $cart = VirtueMartCart::getCart();
        $fieldtype = $address_type . 'address';
        $cart->prepareAddressDataInCart('BT', $new);
        $userFields = $cart->BTaddress;
        $cart->prepareAddressDataInCart('ST', $new);
        $userFieldsST = $cart->STaddress;
        $this->assignRef('userFields', $userFields);
        $this->assignRef('userFieldsST', $userFieldsST);
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        $this->assignRef('cart', $cart);

        // Check for layout override
        $active = JFactory::getApplication()->getMenu()->getActive();
        if (isset($active->query['layout'])) {
            $this->setLayout($active->query['layout']);
        }

        //Escape strings for HTML output
        $this->pageclass_sfx = htmlspecialchars($this->params->get('pageclass_sfx'));

        $this->prepareDocument();

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
