<?php

defined('_JEXEC') or die('Restricted access');

// Load the view framework
if (!class_exists('VmView'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmview.php');
jimport('joomla.html.pane');
jimport('joomla.version');
jimport('joomla.filesystem.folder');

/**
 * HTML View class for the configuration maintenance
 *
 * @package		VirtueMart
 * @subpackage 	Config
 * @author 		RickG
 */
class VirtuemartViewReward_point_config extends VmView {

    function display($tpl = null) {
        $this->loadHelper('html');

        $model = VmModel::getModel('reward_point_config');
        $usermodel = VmModel::getModel('user');

        JToolBarHelper::title(JText::_('Product config'), 'head vm_config_48');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        $reward_point_config = $model->getRewardPointConfig();

        $this->assignRef("reward_point_config", $reward_point_config);

        parent::display($tpl);
    }

}

// pure php no closing tag
