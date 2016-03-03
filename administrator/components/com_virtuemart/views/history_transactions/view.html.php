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
if (!class_exists('VmView'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmview.php');
jimport('joomla.html.pane');

/**
 * HTML View class for maintaining the list of market_prices
 *
 * @package	VirtueMart
 * @subpackage Market_price
 * @author Patrick Kohl
 */
class VirtuemartViewHistory_transactions extends VmView {

    function display($tpl = null) {

        // Load the helper(s)
        $this->loadHelper('html');
        // get necessary models
        $model = VmModel::getModel('history_transactions');
        $this->SetViewTitle();
        $historyTransactionList = $model->getAllHistoryTransaction();
        JToolBarHelper::deleteList();
        $this->addStandardDefaultViewLists($model, 'history_transactions');
        $this->assignRef('historyTransactionList', $historyTransactionList);
        $pagination = $model->getPagination();
        $this->assignRef('pagination', $pagination);
        parent::display($tpl);
    }

}

// pure php no closing tag
