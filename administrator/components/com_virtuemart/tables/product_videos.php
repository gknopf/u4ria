<?php

/**
 *
 * Product table
 *
 * @package	VirtueMart
 * @subpackage Product
 * @author RolandD
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: product_videos.php 4241 2011-10-03 22:52:05Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if(!class_exists('VmTableData'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmtabledata.php');

/**
 * Product table class
 * The class is is used to manage the products in the shop.
 *
 * @package	VirtueMart
 * @author RolandD
 * @author Max Milbers
 */
class TableProduct_videos extends VmTableData {

    /** @var int Primary key */
    var $virtuemart_product_video_id = 0;
    /** @var int Product id */
    var $virtuemart_product_id = 0;
    /** @var string Product video */

    var $video_title = null;
    var $video_link = null;
    var $video_type = null;
    var $video_thumb = null;

    //------------------------
    /**
     * @author RolandD
     * @param $db A database connector object
     */
    function __construct(&$db) {
        parent::__construct('#__virtuemart_product_videos', 'virtuemart_video_id', $db);
        $this->setPrimaryKey('virtuemart_product_id');
		$this->setLoggable();
		$this->setTableShortCut('pv');
    }

    /**
     * @author Max Milbers
     * @param
     */

	function check(){

		if(!empty($this->product_video)){
			$this->product_video = str_replace(array(',',' '),array('.',''),$this->product_video);
		} else {
			$this->product_video = null;
		}



		return parent::check();
	}



}

// pure php no closing tag
