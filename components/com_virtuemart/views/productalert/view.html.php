<?php

/**
 *
 * Manufacturer View
 *
 * @package	VirtueMart
 * @subpackage Manufacturer
 * @author Kohl Patrick
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 2641 2010-11-09 19:25:13Z milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if (!class_exists('VmView'))
    require(JPATH_VM_SITE . DS . 'helpers' . DS . 'vmview.php');

/**
 * HTML View class for maintaining the list of manufacturers
 *
 * @package	VirtueMart
 * @subpackage Manufacturer
 * @author Kohl Patrick
 */
class VirtuemartViewProductAlert extends VmView {

    function display($tpl = null) {

        $user = JFactory::getUser();
        $model = VmModel::getModel('product_alert');
        
        $alert = $model->getAllAlertByUser($user->id);
                
        
        $ratingModel = VmModel::getModel('ratings');
        foreach ($alert as $value) {
            $value->review  = $ratingModel->getReviews($value->virtuemart_product_id);
//            print_r($value->review);
        }
//        die();
        $this->assignRef('alert', $alert);
        parent::display($tpl);
    }

}

// pure php no closing tag
