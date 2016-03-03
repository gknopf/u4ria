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
class VirtuemartViewProduct_Config extends VmView {

    function display($tpl = null) {

        $this->loadHelper('image');
        $this->loadHelper('html');

        $model = VmModel::getModel('product_config');
                
        $usermodel = VmModel::getModel('user');

        JToolBarHelper::title(JText::_('Product config'), 'head vm_config_48');

        JToolBarHelper::save();
        JToolBarHelper::cancel();

        $imagePathTop50 = '/images/high_feature/top50/';
        $imagePathTop100 = '/images/high_feature/top100/';
        $imagePathVideodemo = '/images/high_feature/videodemo/';
        $imagePathHighly = '/images/high_feature/highly/';
        $imagePathWatermark = '/images/high_feature/watermark/';
	
        $this->assignRef('imagePathTop50', $imagePathTop50);
        $this->assignRef('imagePathTop100', $imagePathTop100);
        $this->assignRef('imagePathVideodemo', $imagePathVideodemo);
        $this->assignRef('imagePathHighly', $imagePathHighly); 
        $this->assignRef('imagePathWatermark', $imagePathWatermark); 
        
        $product_config = $model->getProductConfig();
        
        $this->assignRef("productconfig", $product_config);
        
        parent::display($tpl);
    }

}

// pure php no closing tag
