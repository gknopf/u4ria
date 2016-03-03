<?php

/**
 *
 * Label Model
 *
 * @package	VirtueMart
 * @subpackage Label
 * @author RolandD, Patrick Kohl, Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: label.php 4286 2011-10-06 18:05:15Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.mail.helper');
// Load the model framework
jimport('joomla.application.component.model');

if (!class_exists('VmModel'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmmodel.php');

/**
 * Model class for VirtueMart Labels
 *
 * @package VirtueMart
 * @subpackage Label
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelProduct_Alert extends VmModel {

    /**
     * constructs a VmModel
     * setMainTable defines the maintable of the model
     * @author Max Milbers
     */
    function __construct() {
        parent::__construct('virtuemart_product_alert_id');
        $this->setMainTable('product_alert');
    }

    public function getListAlert($search = false, $noLimit = false) {

        $this->_noLimit = $noLimit;

        $sl = " pa.*,p.*,pl.product_name as product_name
                ";
        $fr = "
                FROM #__virtuemart_products_alert as pa
                JOIN #__virtuemart_products as p ON p.virtuemart_product_id = pa.virtuemart_product_id
                JOIN #__virtuemart_products_en_gb as pl on pl.virtuemart_product_id = pa.virtuemart_product_id
                
            ";
        $wh = "
            WHERE 1
            ";
//        $gr = "
//            GROUP BY ar.virtuemart_product_id
//            ";
        if (JRequest::getCmd('view') == 'orders') {
            $ordering = $this->_getOrdering();
        } else {
            $ordering = ' order by pa.virtuemart_product_id DESC';
        }
        if ($search) {
            $db = JFactory::getDBO();
            $search = '"%' . $db->getEscaped($search, true) . '%"';
            $wh .= '  AND pl.product_name LIKE ' . $search . '';
        }


        $this->_data = $this->exeSortSearchListQuery(0, $sl, $fr, $wh, '', $ordering);
        return $this->_data;
    }

    public function getAllAlertId() {
        $uid = JFactory::getUser()->id;
        if ($uid > 0) {
            $db = JFactory::getDbo();
            $query = "
                        SELECT virtuemart_product_id FROM #__virtuemart_products_alert
                        WHERE user_id =" . $uid . "
                        ";
            $db->setQuery($query);
            $result = $db->loadObjectList();
            $prodcutIdArray = array();

            if ($result) {
                foreach ($result as $value) {
                    $prodcutIdArray[$value->virtuemart_product_id] = $value->virtuemart_product_id;
                }
            }
        }
        return $prodcutIdArray;
    }

    public function getAlert($uid, $product_id) {
        $db = JFactory::getDbo();
        $query = "
        SELECT * FROM #__virtuemart_products_alert
        WHERE user_id =" . $uid . " AND virtuemart_product_id=" . $product_id . "
        ";
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    public function getAllAlertByUser($uid) {
        $db = JFactory::getDbo();
        $query = "
        SELECT p.*, a.*, l.product_name as product_name, m.file_url
        FROM #__virtuemart_products as p
        JOIN #__virtuemart_products_en_gb as l on l.virtuemart_product_id = p.virtuemart_product_id
        JOIN #__virtuemart_products_alert as a on a.virtuemart_product_id = p.virtuemart_product_id
        JOIN #__virtuemart_product_medias as pm on pm.virtuemart_product_id = p.virtuemart_product_id
        JOIN #__virtuemart_medias as m on m.virtuemart_media_id = pm.virtuemart_media_id
        WHERE a.user_id =" . $uid . "
        
        GROUP BY p.virtuemart_product_id
        
        ";
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    public function store($data) {

        /* Setup some place holders */
        $table = $this->getTable('product_alert');

        $table->bindChecknStore($data);
        $errors = $table->getErrors();
        foreach ($errors as $error) {
            $this->setError($error);
        }

        // Process the images //
        if (!class_exists('VirtueMartModelMedia'))
            require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'media.php');
        $mediaModel = new VirtueMartModelMedia();
        $mediaModel->storeMedia($data, 'label');
        $errors = $mediaModel->getErrors();
        foreach ($errors as $error) {
            $this->setError($error);
        }
        return $table->virtuemart_label_id;
    }

    function alertSendMail() {

        $sender_name = JMailHelper::cleanAddress($sender_name);
        $subject = JMailHelper::cleanSubject($subject);
        $body = JMailHelper::cleanBody($body);
        $mode = true; //true=html, false=plain text
        $cc = 'some@mail.com'; //cc setting might not work. Try the bcc instead.
        $bcc[] = 'another@mail.com'; //Is an array of addresses

        if (!JUtility::sendMail($sender_email, $sender_name, $recipient, $subject, $body, $mode, $cc, $bcc)) {
            JError::raiseNotice(500, 'Email failed.');
        }
    }

}

// pure php no closing tag