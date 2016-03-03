<?php

/**
 *
 * Manufacturer Model
 *
 * @package	VirtueMart
 * @subpackage Manufacturer
 * @author RolandD, Patrick Kohl, Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: manufacturer.php 6350 2012-08-14 17:18:08Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if (!class_exists('VmModel'))
        require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmmodel.php');

/**
 * Model class for VirtueMart Manufacturers
 *
 * @package VirtueMart
 * @subpackage Manufacturer
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelManufacturer extends VmModel {

        /**
         * constructs a VmModel
         * setMainTable defines the maintable of the model
         * @author Max Milbers
         */
        function __construct() {
                parent::__construct('virtuemart_manufacturer_id');
                $this->setMainTable('manufacturers');
                $this->addvalidOrderingFieldName(array('m.virtuemart_manufacturer_id', 'mf_name', 'mf_desc', 'mf_category_name', 'mf_url'));
                $this->removevalidOrderingFieldName('virtuemart_manufacturer_id');
                $this->_selectedOrdering = 'mf_name';
                $this->_selectedOrderingDir = 'ASC';
        }

        /**
         * Load a single manufacturer
         */
        public function getManufacturer() {

                static $_manus = array();
                if (!array_key_exists($this->_id, $_manus)) {
                        $this->_data = $this->getTable('manufacturers');
                        $this->_data->load($this->_id);

                        $xrefTable = $this->getTable('manufacturer_medias');
                        $this->_data->virtuemart_media_id = $xrefTable->load($this->_id);

                        $_manus[$this->_id] = $this->_data;
                }

                return $_manus[$this->_id];
        }

        /**
         * Bind the post data to the manufacturer table and save it
         *
         * @author Roland
         * @author Max Milbers
         * @return boolean True is the save was successful, false otherwise.
         */
        public function store(&$data) {

                //add cat top brand best seller
                $of = $data['mf_name'];
                $cdata['vmlang'] = 'en-GB';
                $cdata['category_name'] = 'Top 20 Best Seller For Brand ' . $of;
                $cdata['catagory_short_des'] = '';
                $cdata['slug'] = 'Top 20 Best Seller For ' . $of;
                $cdata['published'] = 1;
                $cdata['category_description'] = '';
                $cdata['top10'] = 0;
                $cdata['top10bs'] = 0;
                $cdata['top_for_manufacturer'] = 0;
                $cdata['top_for_brand'] = 1;
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
                $modelcategory = VmModel::getModel('category');

                // Setup some place holders
                $table = $this->getTable('manufacturers');

                $table->bindChecknStore($data);
                $errors = $table->getErrors();
                foreach ($errors as $error) {
                        vmError($error);
                }

                // Process the images
                $mediaModel = VmModel::getModel('Media');
                $mediaModel->storeMedia($data, 'manufacturer');
                $errors = $mediaModel->getErrors();
                foreach ($errors as $error) {
                        vmError($error);
                }
                $cdata['brand_id'] = $table->virtuemart_manufacturer_id;
                $modelcategory->addTopManufacturers($cdata);
                return $table->virtuemart_manufacturer_id;
        }

        /**
         * Returns a dropdown menu with manufacturers
         * @author RolandD
         * @return object List of manufacturer to build filter select box
         */
        function getManufacturerDropDown() {
                $db = JFactory::getDBO();
                $query = "SELECT `virtuemart_manufacturer_id` AS `value`, `mf_name` AS text, '' AS disable
						FROM `#__virtuemart_manufacturers_" . VMLANG . "` ";
                $db->setQuery($query);
                $options = $db->loadObjectList();
                array_unshift($options, JHTML::_('select.option', '0', '- ' . JText::_('COM_VIRTUEMART_SELECT_MANUFACTURER') . ' -'));
                return $options;
        }

        function remove($ids) {
                $modelcategory = VmModel::getModel('category');
                foreach ($ids as $categoryId) {
                        $topcatid = $this->getTopBestid($categoryId);
                        if (!empty($topcatid))
                                $modelcategory->remove($topcatid);
                        parent::remove($ids);
                        
                }
                return true;
        }

        function getTopBestid($id) {
                $dbc = JFactory::getDBO();

                $q = '            
                        SELECT c.virtuemart_category_id
                        FROM u4ria_virtuemart_categories as c
                        WHERE c.brand_id = ' . $id . '    
                ';

                $dbc->setQuery($q);
                $info = $dbc->loadObject();
                return $info;
        }

        /**
         * Retireve a list of countries from the database.
         *
         * @param string $onlyPuiblished True to only retreive the publish countries, false otherwise
         * @param string $noLimit True if no record count limit is used, false otherwise
         * @return object List of manufacturer objects
         */
        public function getManufacturers($onlyPublished = false, $noLimit = false, $getMedia = false) {

                $this->_noLimit = $noLimit;
                $mainframe = JFactory::getApplication();
// 		$db = JFactory::getDBO();
                $option = 'com_virtuemart';

//                $virtuemart_manufacturercategories_id = $mainframe->getUserStateFromRequest($option . 'virtuemart_manufacturercategories_id', 'virtuemart_manufacturercategories_id', 0, 'int');
//                $search = $mainframe->getUserStateFromRequest($option . 'search', 'search', '', 'string');


                $where = array();
                if ($virtuemart_manufacturercategories_id > 0) {
                        $where[] .= ' `m`.`virtuemart_manufacturercategories_id` = ' . $virtuemart_manufacturercategories_id;
                }

                if ($search && $search != 'true') {
                        $search = '"%' . $this->_db->getEscaped($search, true) . '%"';
                        //$search = $this->_db->Quote($search, false);
                        $where[] .= ' LOWER( `mf_name` ) LIKE ' . $search;
                }

                if ($onlyPublished) {
                        $where[] .= ' `m`.`published` = 1';
                }

                $whereString = '';
                if (count($where) > 0)
                        $whereString = ' WHERE ' . implode(' AND ', $where);

                $select = ' `m`.*,`#__virtuemart_manufacturers_' . VMLANG . '`.*, mc.`mf_category_name` ';

                $joinedTables = 'FROM `#__virtuemart_manufacturers_' . VMLANG . '` JOIN `#__virtuemart_manufacturers` as m USING (`virtuemart_manufacturer_id`) ';
                $joinedTables .= ' LEFT JOIN `#__virtuemart_manufacturercategories_' . VMLANG . '` AS mc on  mc.`virtuemart_manufacturercategories_id`= `m`.`virtuemart_manufacturercategories_id` ';
                $groupBy = ' ';
                if ($getMedia) {
                        $select .= ',mmex.virtuemart_media_id ';
                        $joinedTables .= 'LEFT JOIN `#__virtuemart_manufacturer_medias` as mmex ON `m`.`virtuemart_manufacturer_id`= mmex.`virtuemart_manufacturer_id` ';
                        $groupBy = ' GROUP BY `m`.`virtuemart_manufacturer_id` ';
                }
                $whereString = ' ';
                if (count($where) > 0)
                        $whereString = ' WHERE ' . implode(' AND ', $where) . ' ';


                $ordering = $this->_getOrdering();
                return $this->_data = $this->exeSortSearchListQuery(0, $select, $joinedTables, $whereString, $groupBy, $ordering);
        }

        function countProducts($manufu) {
                $dbc = JFactory::getDBO();
                $vendorId = 1;

                $q = 'SELECT count(`#__virtuemart_products`.`virtuemart_product_id`) AS total
                FROM `#__virtuemart_products`, `#__virtuemart_product_manufacturers`
                WHERE `#__virtuemart_products`.`virtuemart_vendor_id` = "' . (int) $vendorId . '"
                AND `#__virtuemart_product_manufacturers`.`virtuemart_manufacturer_id` = ' . (int) $manufu . '
                AND `#__virtuemart_products`.`virtuemart_product_id` = `#__virtuemart_product_manufacturers`.`virtuemart_product_id`
                AND `#__virtuemart_products`.`published` = "1" ';

                $dbc->setQuery($q);
                $count = $dbc->loadResult();
                if (!$count)
                        $count = 0;
                return $count;
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

        function getMafuCatInfo($id) {
                $dbc = JFactory::getDBO();

                $q = '            
            SELECT mcl.*
            FROM #__virtuemart_manufacturercategories_en_gb as mcl
            WHERE mcl.virtuemart_manufacturercategories_id = ' . $id . ' and published = 1        
        ';

                $dbc->setQuery($q);
                $info = $dbc->loadObject();
                return $info;
        }

        function getBrandTopBestCategory($bid) {
                $dbc = JFactory::getDBO();

                $q = '            
                        SELECT *
                        FROM #__virtuemart_categories as pc
                        LEFT JOIN #__virtuemart_manufacturers as b on b.virtuemart_manufacturer_id = pc.brand_id
                        WHERE pc.top_for_brand = 1 and b.virtuemart_manufacturer_id = ' . (int) $bid . ' and pc.published = 1       
                    ';

                $dbc->setQuery($q);
                $info = $dbc->loadObject();
                return $info->virtuemart_category_id;
        }

        function getBrandInfo($id) {
                $dbc = JFactory::getDBO();

                $q = '            
            SELECT *
            FROM #__virtuemart_manufacturers_en_gb as ma
            JOIN #__virtuemart_manufacturers as m on m.virtuemart_manufacturer_id = ma.virtuemart_manufacturer_id
            WHERE ma.virtuemart_manufacturer_id = ' . $id . ' and m.published = 1        
        ';

                $dbc->setQuery($q);
                $info = $dbc->loadObject();
                return $info;
        }

}

// pure php no closing tag