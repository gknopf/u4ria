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
 * @version $Id: products.php 6306 2012-08-06 14:19:51Z Milbo $
 */
if (!class_exists('VmTable'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmtable.php');

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * Product table class
 * The class is is used to manage the products in the shop.
 *
 * @package	VirtueMart
 * @author RolandD
 * @author Max Milbers
 */
class TableProducts extends VmTable {

    /** @var int Primary key */
    var $virtuemart_product_id = 0;

    /** @var integer Product id */
    var $virtuemart_vendor_id = 0;

    /** @var string File name */
    var $product_parent_id = 0;

    /** @var string File title */
    var $product_sku = '';

    /** @var string Name of the product */
    var $product_name = '';
    var $slug = '';

    /** @var string File description */
    var $product_s_desc = '';

    /** @var string File extension */
    var $product_desc = '';

    /** @var int File is an image or other */
    var $product_weight = 0;

    /** @var int File image height */
    var $product_weight_uom = '';

    /** @var int File image width */
    var $product_length = 0;

    /** @var int File thumbnail image height */
    var $product_width = 0;

    /** @var int File thumbnail image width */
    var $product_height = 0;

    /** @var int File thumbnail image width */
    var $product_lwh_uom = '';
    var $package_weight_uom = '';
    var $package_length_uom = '';
    var $package_width_uom = '';
    var $package_height_uom = '';

    /** @var int File thumbnail image width */
    var $product_url = '';

    /** @var int File thumbnail image width */
    var $product_in_stock = 0;

    var $product_ordered = 0;

    /** @var int File thumbnail image width */
    var $low_stock_notification = 0;

    /** @var int File thumbnail image width */
    var $product_available_date = null;

    /** @var int File thumbnail image width */
    var $product_availability = null;

    /** @var int File thumbnail image width */
    var $product_special = null;

    /** @var int product internal ordering, it is for the ordering for child products under a parent null */
    var $ordering = null;

    /** @var int File thumbnail image width */
    var $product_sales = 0;

    /** @var int File thumbnail image width */
    var $product_unit = null;

    /** @var int File thumbnail image width */
    var $product_packaging = null;

    /** @var int File thumbnail image width */
    var $product_params = null;

    /** @var string Internal note for product */
    var $intnotes = '';

    /** @var string custom title */
    var $customtitle = '';

    /** @var string Meta description */
    var $metadesc = '';

    /** @var string Meta keys */
    var $metakey = '';

    /** @var string Meta robot */
    var $metarobot = '';

    /** @var string Meta author */
    var $metaauthor = '';

    /** @var string Name of the details page to use for showing product details in the front end */
    var $layout = '';

    /** @var int published or unpublished */
    var $published = 1;
    var $label_id = 0;
    var $product_recommended = 0;
    var $product_bestseller = 0;
    var $product_top100 = 0;
    var $product_top50 = 0;
    var $product_highly = 0;
    var $product_with_video_demo = 0;
    var $is_free_gift = 0;
    var $reward_point = 0;
    var $gift_point = 0;
    var $new_m = 0;
    var $new_y = 0;
    var $product_detail = '';
    var $product_feature = '';

    var $insertable_length = 0;
    var $circumference = 0;
    var $diameter = 0;
    var $materials = '';
    var $made_in = '';
    var $product_type = '';
    var $product_lining = '';
    var $cock_ring_style = '';
    var $product_boning = '';
    var $bottom_style = '';
    var $flavor = '';
    var $lingerie_closure = '';
    var $lingerie_special_features = '';
    var $product_pattern = '';
    var $product_top_style = '';
    var $product_texture = '';
    var $safety_features = '';
    var $material_safety = '';
    var $care_and_cleaning = '';
    var $pump_mechanism = '';
    var $clitoral_attachment_shape = '';
    var $special_features = '';
    var $powered_by = '';
    var $harness_compatibility = '';
    var $product_functions = '';
    var $control_type = '';
    var $product_size = '';
    var $maximum_hip_size = '';
    var $maximum_waist_size = '';
    var $cup_size = '';
    var $max_stretched_diameter = '';
    var $unstretched_diameter = '';
    var $inner_diameter = '';
    var $package_weight = '';
    var $package_length = '';
    var $package_width = '';
    var $package_height = '';

    /**
     * @author Max Milbers
     * @param $db A database connector object
     */
    function __construct($db) {
        parent::__construct('#__virtuemart_products', 'virtuemart_product_id', $db);

        //In a VmTable the primary key is the same as the _tbl_key and therefore not needed
// 		$this->setPrimaryKey('virtuemart_product_id');
        $this->setObligatoryKeys('product_name');
        $this->setLoggable();
        $this->setTranslatable(array('product_name', 'product_s_desc', 'product_desc', 'metadesc', 'metakey', 'customtitle', 'product_detail', 'product_feature'));
        $this->setSlug('product_name');
        $this->setTableShortCut('p');

        //We could put into the params also the product_availability and the low_stock_notification
        $varsToPushParam = array(
            'min_order_level' => array(null, 'float'),
            'max_order_level' => array(null, 'float'),
            'step_order_level' => array(null, 'float'),
            //'product_packaging'=>array(null,'float'),
           // 'product_box' => array(null, 'float')
        );

        $this->setParameterable('product_params', $varsToPushParam);
    }

}

// pure php no closing tag
