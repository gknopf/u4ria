<?php

defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if (!class_exists('VmController'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmcontroller.php');

/**
 * Configuration Controller
 *
 * @package    VirtueMart
 * @subpackage Config
 * @author DuongTD
 */
class VirtuemartControllerUser_Level extends VmController {

    /**
     * Method to display the view
     *
     * @access	public
     * @author
     */
    function __construct() {
        parent::__construct();
    }

    function addData($file,$field){
        $model = VmModel::getModel('product_config');

    }

    function save($data = 0) {
        $db = JFactory::getDbo();

        $model = VmModel::getModel('user_level');
        $user_level = JRequest::get('user_level', array());

        if ($user_level['user_level']) {
          foreach ($user_level['user_level'] as $key => $level_info) {
            $msg = $model->update($key, $level_info);
          }
        }

        $redir = 'index.php?option=com_virtuemart&view=user_level';
        $this->setRedirect($redir, $msg);
    }

}
