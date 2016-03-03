<?php
/**
*
* Product Videos Model
*
* @package	VirtueMart
* @subpackage Product Videos
* @author RolandD, Patrick Kohl, Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: market_price.php 4286 2011-10-06 18:05:15Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the model framework
jimport( 'joomla.application.component.model');

if(!class_exists('VmModel'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmmodel.php');

/**
 * Model class for VirtueMart Market_prices
 *
 * @package VirtueMart
 * @subpackage Market_price
 * @author RolandD, Max Milbers
 * @todo Replace getOrderUp and getOrderDown with JTable move function. This requires the virtuemart_product_category_xref table to replace the ordering with the ordering column
 */
class VirtueMartModelCategory_videos extends VmModel {

	/**
	 * constructs a VmModel
	 * setMainTable defines the maintable of the model
	 * @author Max Milbers
	 */
	function __construct() {
		parent::__construct('virtuemart_video_id');
		$this->setMainTable('category_videos');

	}


    /**
     * Load a single market_price
     */
     public function getProduct_video() {

     	$this->_data = $this->getTable('category_videos');
     	$this->_data->load($this->_id);

     	return $this->_data;
     }

     /**
	 * Bind the post data to the market_price table and save it
     *
     * @author Roland
     * @author Max Milbers
     * @return boolean True is the save was successful, false otherwise.
	 */
	public function store($data) {

		/* Setup some place holders */
		$table = $this->getTable('category_videos');

		$table->bindChecknStore($data);
		$errors = $table->getErrors();
		foreach($errors as $error){
			$this->setError($error);
		}

		return $table->id;
	}

    /**
     * Select the products to list on the product list page
     */
/*    public function getMarket_priceList() {
     	$db = JFactory::getDBO();
     	// Pagination
     	$this->getPagination();

     	// Build the query
     	$q = "SELECT
			";
     	$db->setQuery($q, $this->_pagination->limitstart, $this->_pagination->limit);
     	return $db->loadObjectList('virtuemart_category_id');
    }
*/



    /**
	 * Retireve a list of countries from the database.
	 *
     * @param string $onlyPuiblished True to only retreive the publish countries, false otherwise
     * @param string $noLimit True if no record count limit is used, false otherwise
	 * @return object List of market_price objects
	 */
	public function getCategory_videos($noLimit=false, $getMedia=false) {

		$this->_noLimit = $noLimit;
		$mainframe = JFactory::getApplication();
// 		$db = JFactory::getDBO();
		$option	= 'com_virtuemart';


		$where = array();

		if ( $search && $search != 'true') {
			$search = '"%' . $this->_db->getEscaped( $search, true ) . '%"' ;
			//$search = $this->_db->Quote($search, false);
			$where[] .= 'LOWER( pr.`virtuemart_category_id` ) LIKE '.$search;
		}

		$select = ' cv.*, p.product_name ';

		$joinedTables = ' FROM `#__virtuemart_category_videos` AS cv ';
		$joinedTables .= ' LEFT JOIN `#__virtuemart_categories` AS p ON cv.virtuemart_category_id = p.virtuemart_category_id ';
		$whereString = ' ';
		if (count($where) > 0) $whereString = ' WHERE '.implode(' AND ', $where).' ' ;

		$ordering = $this->_getOrdering('cv.virtuemart_video_id');
		return $this->_data = $this->exeSortSearchListQuery(0,$select,$joinedTables,$whereString,' ',$ordering );

	}



	function saveCustomData($data, $category_id){
		$q = "DELETE FROM #__virtuemart_category_videos WHERE virtuemart_category_id = " . $category_id;
		$this->_db->setQuery ( $q );
		$this->_db->query ();
		$q = "INSERT INTO `#__virtuemart_category_videos` (`virtuemart_category_id`,`video_title`,`video_link`, `video_type`, `video_thumb`) VALUES ";

		if (is_array($data['video_title']))
		{
			$fields = array();
			for($i=0; $i < count($data['video_title']); $i++)
			{
			  if ($i < 8) {
  				$fields['virtuemart_category_id'] = $category_id;
  				$fields['video_title'] = str_replace("'", "''", $data['video_title'][$i]);
  				$fields['video_link'] = str_replace("'", "''", $data['video_link'][$i]);

  				// get type and thumb for youtube and vimeo
  				if (strpos($fields['video_link'], 'www.youtube.com') !== false) {
  				  $fields['video_type'] = 1;

  				  preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#', $fields['video_link'], $matches);
  				  $video_id = $matches[0];
  				  $fields['video_thumb'] = 'http://img.youtube.com/vi/' . $video_id . '/0.jpg';
  				} else if (strpos($fields['video_link'], 'vimeo.com') !== false) {
  				  $fields['video_type'] = 2;

  				  preg_match('/(\d+)/', $fields['video_link'], $matches);
  				  $video_id = $matches[0];

  				  $vimeo_url = 'http://vimeo.com/api/v2/video/' . $video_id . '.php'; //build url api
  				  $vimeo_data = unserialize(file_get_contents($vimeo_url));

  				  $thumb = $vimeo_data[0]['thumbnail_medium'];
  				  $fields['video_thumb'] = $thumb;
  				}

  				$q .= "('" . (int)$category_id . "','" . $fields['video_title'] . "','" . $fields['video_link'] . "','" . $fields['video_type'] . "','" . $fields['video_thumb'] . "'),";
			  }
			}

			$q = substr($q, 0, strlen($q) - 1);

			$this->_db->setQuery ( $q );
			$this->_db->query ();
		}
	}
}
// pure php no closing tag