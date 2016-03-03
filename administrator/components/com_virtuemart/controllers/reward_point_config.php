<?php

defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if (!class_exists('VmController'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmcontroller.php');

jimport('joomla.filesystem.file');

/**
 * Configuration Controller
 *
 * @package    VirtueMart
 * @subpackage Config
 * @author RickG
 */
class VirtuemartControllerReward_Point_Config extends VmController {

    /**
     * Method to display the view
     *
     * @access	public
     * @author
     */
    function __construct() {
        parent::__construct();
    }

    function save($data = 0) {
        $db = JFactory::getDbo();

        $model = VmModel::getModel('reward_point_config');

        $data = array();
        $data['id'] = JRequest::getInt('reward_point_config_id');
        $data['rp_sgd'] = JRequest::getVar('rp_sgd');
        $data['first_time_signing'] = JRequest::getInt('first_time_signing');
        $data['six_month_amount'] = JRequest::getInt('six_month_amount');
        $data['six_months_discount'] = JRequest::getInt('six_months_discount');
        $data['birthday_month'] = JRequest::getInt('birthday_month');

        if ($data) {
          $msg =  $model->updateConfig($data);
        }

        $redir = 'index.php?option=com_virtuemart&view=reward_point_config';
        $this->setRedirect($redir, $msg);
    }

}

//pure php no tag
