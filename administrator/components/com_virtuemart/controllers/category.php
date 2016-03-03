<?php

/**
 *
 * Category controller
 *
 * @package	VirtueMart
 * @subpackage Category
 * @author RickG, jseros
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: category.php 6071 2012-06-06 15:33:04Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if (!class_exists('VmController'))
        require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmcontroller.php');

/**
 * Category Controller
 *
 * @package    VirtueMart
 * @subpackage Category
 * @author jseros, Max Milbers
 */
class VirtuemartControllerCategory extends VmController {

        public function __construct() {
                $this->registerTask('settop', 'settop');
                parent::__construct();
                
        }
        function settop(){
                $of = $data['mf_name'];
                $cdata['vmlang'] = 'en-GB';
                $cdata['category_name'] = 'Top 20 Best Seller For ';
                $cdata['catagory_short_des'] = '';
                $cdata['slug'] = 'Top 20 Best Seller For ';
                $cdata['published'] = 1;
                $cdata['category_description'] = '';
                $cdata['top10'] = 0;
                $cdata['top10bs'] = 1;
                $cdata['top_for_manufacturer'] = 0;
                $cdata['top_for_brand'] = 0;
                $cdata['manufacturer_id'] = 0;
                $cdata['brand_id'] = 0;
                $cdata['ordering'] = 1;
                $cdata['category_parent_id'] = 0;
                $cdata['products_per_row'] = '';
                $cdata['limit_list_start'] = 0;
                $cdata['limit_list_step'] = 10;
                $cdata['limit_list_max'] = 0;
                $cdata['limit_list_initial'] = 10;
                $cdata['category_template'] = 0;
                $cdata['category_layout'] = 0;
                $cdata['category_product_layout'] = 0;
                $cdata['customtitle'] = '';
                $cdata['metadesc'] = '';
                $cdata['metakey'] = '';
                $cdata['metarobot'] = '';
                $cdata['metaauthor'] = '';
                $cdata['searchMedia'] = '';
                $cdata['media_published'] = 1;
                $cdata['file_title'] = '';
                $cdata['file_description'] = '';
                $cdata['file_meta'] = '';
                $cdata['file_url'] = 'images/stories/virtuemart/category/';
                $cdata['file_url_thumb'] = '';
                $cdata['media_roles'] = 'file_is_displayable';
                $cdata['media_action'] = 0;
                $cdata['file_is_category_image'] = 1;
                $cdata['active_media_id'] = 0;
                $cdata['option'] = 'com_virtuemart';
                $cdata['video_title_single'] = '';
                $cdata['video_link_single'] = '';
                $cdata['virtuemart_category_id'] = 0;
                $cdata['task'] = 'save';
                $cdata['boxchecked'] = 0;
                $cdata['controller'] = 'category';
                $cdata['view'] = 'category';
                $model = VmModel::getModel('category');
                $adf =  $model->getListCategories();
                foreach ($adf as $k){
                        $cdata['category_name'] = 'Top 20 Best Seller For ' . $k->category_name;
                        $cdata['catagory_short_des'] = '';
                        $cdata['slug'] = 'Top 20 Best Seller For ' . $k->category_name;
                        echo $cdata['category_name'];
                        $model->addTopManufacturers($cdata);
                }

//                jexit();
        }
        /**
         * We want to allow html so we need to overwrite some request data
         *
         * @author Max Milbers
         */
        function save($data = 0) {

                $data = JRequest::get('post');

                $data['category_name'] = JRequest::getVar('category_name', '', 'post', 'STRING', JREQUEST_ALLOWHTML);
                $data['category_description'] = JRequest::getVar('category_description', '', 'post', 'STRING', JREQUEST_ALLOWHTML);

                parent::save($data);
        }

        /**
         * Save the category order
         *
         * @author jseros
         */
        public function orderUp() {
                // Check token
                JRequest::checkToken() or jexit('Invalid Token');

                //capturing virtuemart_category_id
                $id = 0;
                $cid = JRequest::getVar('cid', array(), 'post', 'array');
                JArrayHelper::toInteger($cid);

                if (isset($cid[0]) && $cid[0]) {
                        $id = $cid[0];
                } else {
                        $this->setRedirect('index.php?option=com_virtuemart&view=category', JText::_('COM_VIRTUEMART_NO_ITEMS_SELECTED'));
                        return false;
                }

                //getting the model
                $model = VmModel::getModel('category');

                if ($model->orderCategory($id, -1)) {
                        $msg = JText::_('COM_VIRTUEMART_ITEM_MOVED_UP');
                } else {
                        $msg = $model->getError();
                }

                $this->setRedirect('index.php?option=com_virtuemart&view=category', $msg);
        }

        /**
         * Save the category order
         *
         * @author jseros
         */
        public function orderDown() {
                // Check token
                JRequest::checkToken() or jexit('Invalid Token');

                //capturing virtuemart_category_id
                $id = 0;
                $cid = JRequest::getVar('cid', array(), 'post', 'array');
                JArrayHelper::toInteger($cid);

                if (isset($cid[0]) && $cid[0]) {
                        $id = $cid[0];
                } else {
                        $this->setRedirect('index.php?option=com_virtuemart&view=category', JText::_('COM_VIRTUEMART_NO_ITEMS_SELECTED'));
                        return false;
                }

                //getting the model
                $model = VmModel::getModel('category');

                if ($model->orderCategory($id, 1)) {
                        $msg = JText::_('COM_VIRTUEMART_ITEM_MOVED_DOWN');
                } else {
                        $msg = $model->getError();
                }

                $this->setRedirect('index.php?option=com_virtuemart&view=category', $msg);
        }

        /**
         * Save the categories order
         */
        public function saveOrder() {
                // Check for request forgeries
                JRequest::checkToken() or jexit('Invalid Token');

                $cid = JRequest::getVar('cid', array(), 'post', 'array'); //is sanitized
                JArrayHelper::toInteger($cid);

                $model = VmModel::getModel('category');

                $order = JRequest::getVar('order', array(), 'post', 'array');
                JArrayHelper::toInteger($order);

                if ($model->setOrder($cid, $order)) {
                        $msg = JText::_('COM_VIRTUEMART_NEW_ORDERING_SAVED');
                } else {
                        $msg = $model->getError();
                }
                $this->setRedirect('index.php?option=com_virtuemart&view=category', $msg);
        }

}
