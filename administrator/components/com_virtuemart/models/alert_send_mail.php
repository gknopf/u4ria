<?php

defined('_JEXEC') or die('Restricted access');

// Load the model framework
if (!class_exists('JModel'))
    require JPATH_VM_LIBRARIES . DS . 'joomla' . DS . 'application' . DS . 'component' . DS . 'model.php';

/**
 * Model class for shop configuration
 *
 * @package	VirtueMart
 * @subpackage Config
 * @author Max Milbers
 * @author RickG
 */
class VirtueMartModelAlert_Send_Mail extends JModel {

    function insertRecord($product_id, $type, $none_send = NULL) {
        $db = JFactory::getDBO();


        if ($none_send != NULL) {
          $sql = "INSERT INTO `#__virtuemart_alert_send_mail` (`product_id`,`type`, `none_send`) VALUES " . '(' . $product_id . ',' . $type . ',' . $none_send . ')';
        } else {
          $sql = "INSERT INTO `#__virtuemart_alert_send_mail` (`product_id`,`type`) VALUES " . '(' . $product_id . ',' . $type . ')';
        }

        $db->setQuery($sql);
        $db->query();
    }
}

//pure php no closing tag