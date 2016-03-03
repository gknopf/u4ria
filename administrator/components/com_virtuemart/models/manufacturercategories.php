<?php

/**
 *
 * Manufacturer category model
 *
 * @package	VirtueMart
 * @subpackage Manufacturer category
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: manufacturercategories.php 6350 2012-08-14 17:18:08Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if (!class_exists('VmModel'))
        require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmmodel.php');

/**
 * Model class for manufacturer category
 *
 * @package	VirtueMart
 * @subpackage Manufacturer category
 * @author
 */
class VirtuemartModelManufacturercategories extends VmModel {

        /**
         * constructs a VmModel
         * setMainTable defines the maintable of the model
         * @author Max Milbers
         */
        function __construct() {
                parent::__construct('virtuemart_manufacturercategories_id');
                $this->setMainTable('manufacturercategories');
                $this->addvalidOrderingFieldName(array('mf_category_name'));
                $config = JFactory::getConfig();
        }

        /**
         * Retrieve the detail record for the current $id if the data has not already been loaded.
         *
         */
        // function getManufacturerCategory(){
        //// $db = JFactory::getDBO();
        // if (empty($this->_data)) {
        // $this->_data = $this->getTable('manufacturercategories');
        // $this->_data->load((int)$this->_id);
        // }
        //// print_r( $this->_db->_sql );
        // if (!$this->_data) {
        // $this->_data = new stdClass();
        // $this->_id = 0;
        // $this->_data = null;
        // }
        // return $this->_data;
        // }
        /**
         * Delete all record ids selected
         *
         * @return boolean True is the remove was successful, false otherwise.
         */
        function store(&$data) {
                $of = $data['mf_category_name'];
                $cdata['vmlang'] = 'en-GB';
                $cdata['category_name'] = 'Top 20 Best Seller For Manufacturer ' . $of;
                $cdata['catagory_short_des'] = '';
                $cdata['slug'] = 'Top 20 Best Seller For ' . $of;
                $cdata['published'] = 1;
                $cdata['category_description'] = '';
                $cdata['top10'] = 0;
                $cdata['top10bs'] = 0;
                $cdata['top_for_manufacturer'] = 1;
                $cdata['top_for_brand'] = 0;
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
                
                $modelcategory = VmModel::getModel('category');

                parent::store($data);
                $cdata['manufacturer_id'] = $data['virtuemart_manufacturercategories_id'];
                $modelcategory->addTopManufacturers($cdata);
        }

        function remove($categoryIds) {
                $table = $this->getTable('manufacturercategories');
                $modelcategory = VmModel::getModel('category');
                foreach ($categoryIds as $categoryId) {
                        if ($table->checkManufacturer($categoryId)) {
                                if (!$table->delete($categoryId)) {
                                        vmError($table->getError());
                                        return false;
                                }
                                $topcatid = $this->getTopBestid($categoryId);
                                $modelcategory->remove($topcatid);
                        } else {
                                vmError(get_class($this) . '::remove ' . $categoryId . ' ' . $table->getError());
                                return false;
                        }
                }
                return true;
        }
        function getTopBestid($id){
                $dbc = JFactory::getDBO();

                $q = '            
                        SELECT c.virtuemart_category_id
                        FROM u4ria_virtuemart_categories as c
                        WHERE c.manufacturer_id = '.$id.'    
                ';

                $dbc->setQuery($q);
                $info = $dbc->loadObject();
                return $info;     
        }
        function getMafuCatInfo($id) {
                $dbc = JFactory::getDBO();

                $q = '            
                        SELECT mcl.*
                        FROM u4ria_virtuemart_manufacturercategories_en_gb as mcl
                        JOIN u4ria_virtuemart_manufacturercategories as mc on mc.virtuemart_manufacturercategories_id = mcl.virtuemart_manufacturercategories_id
                        WHERE mcl.virtuemart_manufacturercategories_id = '.$id.' and mc.published = 1      
                ';

                $dbc->setQuery($q);
                $info = $dbc->loadObject();
                return $info;
        }
        function countProductsMcat($manufu) {
                $dbc = JFactory::getDBO();

                $q = '            
            SELECT count(pm.`virtuemart_product_id`) as total 
            FROM `#__virtuemart_manufacturers` as m
            JOIN `#__virtuemart_product_manufacturers` as pm on m.`virtuemart_manufacturer_id` = pm.`virtuemart_manufacturer_id`
            JOIN `#__virtuemart_products` as p on pm.`virtuemart_product_id` = p.`virtuemart_product_id`
            JOIN `#__virtuemart_manufacturercategories` as mc on mc.`virtuemart_manufacturercategories_id` = m.`virtuemart_manufacturercategories_id`
            WHERE mc.`virtuemart_manufacturercategories_id` = "' . $manufu . '" AND p.`published` ="1"  AND p.`virtuemart_vendor_id` = "1"             
        ';

                $dbc->setQuery($q);
                $count = $dbc->loadResult();
                if (!$count)
                        $count = 0;
                return $count;
        }
        /**
         * Retireve a list of countries from the database.
         *
         * @param string $onlyPuiblished True to only retreive the published categories, false otherwise
         * @param string $noLimit True if no record count limit is used, false otherwise
         * @return object List of manufacturer categories objects
         */
        function getManufacturerCategories($onlyPublished = false, $noLimit = false) {
                $this->_noLimit = $noLimit;
                $select = '* FROM `#__virtuemart_manufacturercategories_' . VMLANG . '` as l';
                $joinedTables = ' JOIN `#__virtuemart_manufacturercategories` as mc using (`virtuemart_manufacturercategories_id`)';
                $where = array();
                if ($onlyPublished) {
                        $where[] = ' `#__virtuemart_manufacturercategories`.`published` = 1';
                }

//		$query .= ' ORDER BY `#__virtuemart_manufacturercategories`.`mf_category_name`';

                $whereString = '';
                if (count($where) > 0)
                        $whereString = ' WHERE ' . implode(' AND ', $where);
                if (JRequest::getCmd('view') == 'manufacturercategories') {
                        $ordering = $this->_getOrdering();
                } else {
                        $ordering = ' order by mf_category_name DESC';
                }
                return $this->_data = $this->exeSortSearchListQuery(0, $select, $whereString, $joinedTables, $ordering);
        }

        function getManuTopBestCategory($bid) {
                $dbc = JFactory::getDBO();

                $q = '            
                        SELECT pc.*
                        FROM u4ria_virtuemart_categories as pc
                        LEFT JOIN u4ria_virtuemart_manufacturercategories as b on b.virtuemart_manufacturercategories_id = pc.manufacturer_id
                        WHERE pc.top_for_manufacturer = 1 and b.virtuemart_manufacturercategories_id =  '.(int)$bid.' and pc.published = 1      
                    ';

                $dbc->setQuery($q);
                $info = $dbc->loadObject();
                return $info->virtuemart_category_id;
        }

        /**
         * Build category filter
         *
         * @return object List of category to build filter select box
         */
        function getCategoryFilter() {
                $db = JFactory::getDBO();
                $query = 'SELECT `virtuemart_manufacturercategories_id` as `value`, `mf_category_name` as text'
                        . ' FROM #__virtuemart_manufacturercategories_' . VMLANG . '`';
                $db->setQuery($query);

                $categoryFilter[] = JHTML::_('select.option', '0', '- ' . JText::_('COM_VIRTUEMART_SELECT_MANUFACTURER_CATEGORY') . ' -');

                $categoryFilter = array_merge($categoryFilter, (array) $db->loadObjectList());


                return $categoryFilter;
        }

        function getMfCategoryName($id) {
                $db = JFactory::getDBO();
                $query = 'SELECT `mf_category_name` '
                        . ' FROM #__virtuemart_manufacturercategories_' . VMLANG . '`'
                        . ' WHERE virtuemart_manufacturercategories_id = ' . (int) $id;

                $db->setQuery($query);
                $result = $db->loadObject();

                if ($result) {
                        return $result->mf_category_name;
                } else {
                        return '';
                }
        }

}

// pure php no closing tag