<?php

/**
 *
 * Label Model
 *
 * @package	VirtueMart
 * @subpackage Label
 * @author RolandD, Patrick Kohl, Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: label.php 4286 2011-10-06 18:05:15Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the model framework
jimport('joomla.application.component.model');

if (!class_exists('VmModel'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmmodel.php');

/**
 * Model class for VirtueMart Labels
 *
 * @package VirtueMart
 * @subpackage Label
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelLabel extends VmModel {

    /**
     * constructs a VmModel
     * setMainTable defines the maintable of the model
     * @author Max Milbers
     */
    function __construct() {
        parent::__construct('virtuemart_label_id');
        $this->setMainTable('labels');
    }

    /**
     * Load a single label
     */
    public function getLabel() {

        $this->_data = $this->getTable('labels');
        $this->_data->load($this->_id);

        $xrefTable = $this->getTable('label_medias');
        $this->_data->virtuemart_media_id = $xrefTable->load($this->_id);

        return $this->_data;
    }

    /**
     * Bind the post data to the label table and save it
     *
     * @author Roland
     * @author Max Milbers
     * @return boolean True is the save was successful, false otherwise.
     */
    public function store($data) {

        /* Setup some place holders */
        $table = $this->getTable('labels');

        $table->bindChecknStore($data);
        $errors = $table->getErrors();
        foreach ($errors as $error) {
            $this->setError($error);
        }

        // Process the images //
        if (!class_exists('VirtueMartModelMedia'))
            require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'media.php');
        $mediaModel = new VirtueMartModelMedia();
        $mediaModel->storeMedia($data, 'label');
        $errors = $mediaModel->getErrors();
        foreach ($errors as $error) {
            $this->setError($error);
        }
        return $table->virtuemart_label_id;
    }

    /**
     * Select the products to list on the product list page
     */
    /*    public function getLabelList() {
      $db = JFactory::getDBO();
      // Pagination
      $this->getPagination();

      // Build the query
      $q = "SELECT
      ";
      $db->setQuery($q, $this->_pagination->limitstart, $this->_pagination->limit);
      return $db->loadObjectList('virtuemart_product_id');
      }
     */

    /**
     * Returns a dropdown menu with labels
     * @author RolandD
     * @return object List of label to build filter select box
     */
    function getLabelDropDown() {
        $db = JFactory::getDBO();
        $query = "SELECT `virtuemart_label_id` AS `value`, `lb_name` AS text, '' AS disable
				FROM `#__virtuemart_labels`";
        $db->setQuery($query);
        $options = $db->loadObjectList();
        array_unshift($options, JHTML::_('select.option', '0', '- ' . JText::_('COM_VIRTUEMART_SELECT_LABEL') . ' -'));
        return $options;
    }

    /**
     * Retireve a list of countries from the database.
     *
     * @param string $onlyPuiblished True to only retreive the publish countries, false otherwise
     * @param string $noLimit True if no record count limit is used, false otherwise
     * @return object List of label objects
     */
    public function getLabels($onlyPublished = false, $noLimit = false, $getMedia = false) {

        $this->_noLimit = $noLimit;
        $mainframe = JFactory::getApplication();
// 		$db = JFactory::getDBO();
        $option = 'com_virtuemart';


        $where = array();

        if ($search && $search != 'true') {
            $search = '"%' . $this->_db->getEscaped($search, true) . '%"';
            //$search = $this->_db->Quote($search, false);
            $where[] .= 'LOWER( l.lb_thumb_text) LIKE ' . $search;
        }

        if ($onlyPublished) {
            $where[] .= 'l.`published` = 1';
        }

        $whereString = '';
        if (count($where) > 0)
            $whereString = ' WHERE ' . implode(' AND ', $where);

        $select = ' l.*';

        $joinedTables = ' FROM `#__virtuemart_labels` AS l';
        if ($getMedia) {
            $select .= ',mmex.*';
            $joinedTables .= 'LEFT JOIN `#__virtuemart_label_medias` as mmex ON  l.virtuemart_label_id= mmex.`virtuemart_label_id` ';
        }
        $whereString = ' ';
        if (count($where) > 0)
            $whereString = ' WHERE ' . implode(' AND ', $where) . ' ';

        $ordering = $this->_getOrdering('l.lb_name asc, ');
        return $this->_data = $this->exeSortSearchListQuery(0, $select, $joinedTables, $whereString, ' ', $ordering);
    }

    function displayCustomMedia($media_id, $table = 'label') {

        if (!class_exists('TableMedias'))
            require(JPATH_VM_ADMINISTRATOR . DS . 'tables' . DS . 'medias.php');
        //$data = $this->getTable('medias');
        $db = & JFactory::getDBO();
        $data = new TableMedias($db);
        $data->load((int) $media_id);

        if (!class_exists('VmMediaHandler'))
            require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'mediahandler.php');
        $media = VmMediaHandler::createMedia($data, $table);

        return $media->displayMediaThumb('', false, '', true, true);
    }

    public function getLabelId($labelid) {
        $db = JFactory::getDBO();
        $query = "
        select u4ria_virtuemart_labels.*, u4ria_virtuemart_medias.* from u4ria_virtuemart_labels
        JOIN u4ria_virtuemart_label_medias on u4ria_virtuemart_label_medias.virtuemart_label_id =u4ria_virtuemart_labels.virtuemart_label_id
        JOIN u4ria_virtuemart_medias on u4ria_virtuemart_medias.virtuemart_media_id  = u4ria_virtuemart_label_medias.virtuemart_media_id
        WHERE u4ria_virtuemart_labels.virtuemart_label_id =".$labelid;
        $db->setQuery($query);
        $label = $db->loadObject();
        return $label;
    }

}

// pure php no closing tag