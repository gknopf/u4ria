<?php

defined('_JEXEC') or die('Restricted access');

// Load the view framework
if (!class_exists('VmView'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmview.php');

/**
 * HTML View class for the configuration maintenance
 *
 * @package		VirtueMart
 * @subpackage 	Config
 * @author 		DuongTD
 */
class VirtuemartViewUser_Level extends VmView
{
  function display($tpl = null)
  {
    $this->loadHelper('image');
    $this->loadHelper('html');

    $userLevelModel = VmModel::getModel('user_level');
    $userLevelAll =  $userLevelModel->getAll();

    JToolBarHelper::title(JText::_('Product config'), 'head vm_config_48');
    JToolBarHelper::save();

    $this->assignRef('userLevelAll', $userLevelAll);
    parent::display($tpl);
  }
}