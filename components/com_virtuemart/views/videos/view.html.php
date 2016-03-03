<?php

defined('_JEXEC') or die('Restricted access');

// Load the view framework
//if(!class_exists('VmView'))require(JPATH_VM_SITE.DS.'helpers'.DS.'vmview.php');
// Set to '0' to use tabs i.s.o. sliders
// Might be a config option later on, now just here for testing.
define('__VM_USER_USE_SLIDERS', 0);

/**
 * HTML View class for maintaining the list of users
 *
 * @package	VirtueMart
 * @subpackage Vendor
 * @author Max Milbers
 */
class VirtuemartViewVideos extends JViewLegacy {

//class VirtuemartViewWishlist extends VmView {

    function display($tpl = null) {
        $pid = JRequest::getInt('virtuemart_product_id', 0);
        $cid = JRequest::getInt('virtuemart_category_id', 0);
        if ($pid) {
            $db = JFactory::getDBO();
            //load products videos
            $q = 'SELECT pv.* FROM `#__virtuemart_product_videos` AS pv
				  WHERE pv.`virtuemart_product_id` = "' . (int) $pid . '" ';
            $db->setQuery($q);
            $product_videos = $db->loadObjectList();
            $this->assignRef('videos', $product_videos);
            $product_title = "Product Videos";
            $this->assignRef('page_title', $product_title);
            
        }
        if ($cid) {
            $db = JFactory::getDBO();
            //load products videos
            $q = 'SELECT cv.* FROM `#__virtuemart_category_videos` AS cv 
                      WHERE cv.`virtuemart_category_id` = "' . (int) $cid . '" ';
            $db->setQuery($q);
            $category_videos = $db->loadObjectList();
            $this->assignRef('videos', $category_videos);
            $product_title = "Category Videos";
            $this->assignRef('page_title', $product_title);
            $this->setLayout('videocat');
        }
        parent::display($tpl);
    }

}
