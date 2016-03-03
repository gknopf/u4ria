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
class VirtueMartModelReward_Point_Config extends JModel {

    function getRewardPointConfig() {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__virtuemart_reward_point_config WHERE 1 LIMIT 0, 1";
        $db->setQuery($query);
        $config = $db->loadObject();

        return $config;
    }

    function updateConfig($data) {
        $db = JFactory::getDBO();
        $query = 'UPDATE #__virtuemart_reward_point_config SET rp_sgd = ' . $data['rp_sgd']
                . ', first_time_signing = '  . $data['first_time_signing']
                . ', six_month_amount = ' . $data['six_month_amount']
                . ', six_months_discount = ' . $data['six_months_discount']
                . ', birthday_month = ' . $data['birthday_month']
                . ' WHERE id = ' . $data['id'];

        $db->setQuery($query);
        $db->query();
    }
}

//pure php no closing tag