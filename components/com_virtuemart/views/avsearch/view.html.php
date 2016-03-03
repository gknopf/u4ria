<?php

defined('_JEXEC') or die('Restricted access');

// Load the view framework
if (!class_exists('VmView'))
    require(JPATH_VM_SITE . DS . 'helpers' . DS . 'vmview.php');

// Set to '0' to use tabs i.s.o. sliders
// Might be a config option later on, now just here for testing.
define('__VM_ORDER_USE_SLIDERS', 0);

/**
 * Handle the orders view
 */
class VirtuemartViewavsearch extends VmView {

    public function display($tpl = null) {
         $mainframe = JFactory::getApplication();
        $pathway = $mainframe->getPathway(); 
        $pathway->addItem(JText::_('COM_VIRTUEMART_ADVANCED_SEARCH'));
        $document = JFactory::getDocument();
        $document->setTitle('Advanced search');
        $model_ma = VmModel::getModel('manufacturer');
        $manufacturers = $model_ma->getManufacturers();
        $this->assignRef('manufacturers', $manufacturers);

        foreach ($manufacturers as $manufacturer) {
            $manufacturer->count = $model_ma->countProducts($manufacturer->virtuemart_manufacturer_id);
        }

        $category_id = '0';
        $model_cat = VmModel::getModel('Category');
        $vendorId = '1';

        $categories = $model_cat->getChildCategoryList($vendorId, $category_id);

        foreach ($categories as $category) {
            if ($category->virtuemart_category_id == $catcurent)
                $category->curent = "selected";
            $category->childs = $model_cat->getChildCategoryList($vendorId, $category->virtuemart_category_id);
            foreach ($category->childs as $cat) {
                if ($cat->virtuemart_category_id == $catcurent)
                    $cat->curent = "selected";
                $cat->childs = $model_cat->getChildCategoryList($vendorId, $cat->virtuemart_category_id);
                foreach ($cat->childs as $cend) {
                    if ($cend->virtuemart_category_id == $catcurent)
                        $cend->curent = "selected";
                    $cend->childs = $model_cat->getChildCategoryList($vendorId, $cend->virtuemart_category_id);
                }
            }
        }

        $this->assignRef('categories', $categories);

        $this->setLayout('search');
        parent::display($tpl);
    }

}
