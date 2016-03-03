<?php

/**
 *
 * Description
 *
 * @package	VirtueMart
 * @subpackage
 * @author RolandD, Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: ratings.php 6350 2012-08-14 17:18:08Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if (!class_exists('VmModel')) {
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmmodel.php');
}

/**
 * Model for VirtueMart Products
 *
 * @package VirtueMart
 * @author RolandD
 */
class VirtueMartModelAverage_Ratings extends VmModel {

    var $_productBought = 0;

    /**
     * constructs a VmModel
     * setMainTable defines the maintable of the model
     * @author Max Milbers
     */
    function __construct() {
        parent::__construct();
        $this->setMainTable('average_ratings');
//
//        $layout = JRequest::getString('layout', 'default');
//        $task = JRequest::getCmd('task', 'default');

    }
    
    public function getRatings($search = false, $noLimit=false) {
        
        $this->_noLimit = $noLimit;
        

        $sl = " ar.virtuemart_product_id ,
                st1.ratingcount as c1 ,st2.ratingcount as c2,st3.ratingcount as c3,st4.ratingcount as c4,st5.ratingcount as c5,
                pn.product_name";
        $fr = "
                FROM #__virtuemart_average_ratings as ar
                JOIN #__virtuemart_average_ratings as st1 on st1.virtuemart_product_id = ar.virtuemart_product_id
                JOIN #__virtuemart_average_ratings as st2 on st2.virtuemart_product_id = ar.virtuemart_product_id
                JOIN #__virtuemart_average_ratings as st3 on st3.virtuemart_product_id = ar.virtuemart_product_id
                JOIN #__virtuemart_average_ratings as st4 on st4.virtuemart_product_id = ar.virtuemart_product_id
                JOIN #__virtuemart_average_ratings as st5 on st5.virtuemart_product_id = ar.virtuemart_product_id
                JOIN #__virtuemart_products_en_gb  as pn on pn.virtuemart_product_id = ar.virtuemart_product_id
            ";
        $wh = "
            WHERE st1.rate = 1 AND st2.rate = 2 AND st3.rate = 3 AND st4.rate = 4 AND st5.rate = 5
            ";
        $gr = "
            GROUP BY ar.virtuemart_product_id
            ";
        if ( JRequest::getCmd('view') == 'orders') {
                $ordering = $this->_getOrdering();
        } else {
                $ordering = ' order by ar.virtuemart_product_id DESC';
        }        
        if($search){
                $db = JFactory::getDBO();
                $search = '"%' . $db->getEscaped( $search, true ) . '%"' ;
                $wh .= '  AND pn.product_name LIKE '.$search.'';
        }

        
        $this->_data = $this->exeSortSearchListQuery(0,$sl,$fr,$wh, $gr,$ordering);
        return $this->_data;
    }

    /**
     * Load a single rating
     * @author RolandD
     */
    public function getRating($cids) {

        if (empty($cids)) {
            return;
        }

        $db = JFactory::getDBO();
       $q = "SELECT *
            FROM #__virtuemart_average_ratings
            WHERE virtuemart_product_id=" . $cids[0];
        $db->setQuery($q);
        $reviews = $db->loadObjectList();
        return $reviews;
    }

    function getRatingByProduct($product_id) {
        $q = 'SELECT * FROM `#__virtuemart_average_ratings` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" ';
        $this->_db->setQuery($q);
        return $this->_db->loadObject();
    }





    /**
     * gets a vote by a product id and userId
     *
     * @author Max Milbers
     * @param int $product_id
     */
    function getVoteByProduct($product_id, $userId = 0) {

        if (empty($userId)) {
            $user = JFactory::getUser();
            $userId = $user->id;
        }
        $q = 'SELECT * FROM `#__virtuemart_average_rating_votes` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" AND `created_by` = "' . (int) $userId . '" ';
        $this->_db->setQuery($q);
        return $this->_db->loadObject();
    }

    /**
     * Save a rating
     * @author  Max Milbers
     */
    public function savestoreAverageRate($data) {

        //Check user_rating


        $db = JFactory::getDBO();
        for ($index = 1; $index < 6; $index++) {  
            if($data['star_'.$index] < 0) $data['star_'.$index]= 0;
            $save['virtuemart_average_rating_id']=$data['virtuemart_average_rating_id'];
            $save['virtuemart_product_id']=$data['virtuemart_product_id'];
            $save['rate']=$index;
            $save['ratingcount']=$data['star_'.$index];
            $save['published']=1;
            $save['created_on']=$data['created_on'];
            $save['modified_on']=$data['modified_on'];
            
            $rating = $this->getTable('average_ratings');
            $rating->bindChecknStore($save,TRUE);            
            $errors = $rating->getErrors();
                foreach($errors as $error){
                        vmError(get_class( $this ).'::Error store votes '.$error);
                }
            
//            $q = 'UPDATE #__virtuemart_average_ratings set ratingcount='.$data['star_'.$index].' WHERE rate='.$index.' AND virtuemart_product_id='.$data['virtuemart_product_id'];
//             $db->setQuery($q);
//             $db->query();
        }
        
    }

    /**
     * removes a product and related table entries
     *
     * @author Max Milberes
     */
    public function remove($ids) {

        $rating = $this->getTable($this->_maintablename);
        $review = $this->getTable('rating_reviews');
        $votes = $this->getTable('rating_votes');

        $ok = TRUE;
        foreach ($ids as $id) {

            $rating->load($id);
            $prod_id = $rating->virtuemart_product_id;

            if (!$rating->delete($id)) {
                vmError(get_class($this) . '::Error deleting ratings ' . $rating->getError());
                $ok = FALSE;
            }

            if (!$review->delete($prod_id, 'virtuemart_product_id')) {
                vmError(get_class($this) . '::Error deleting review ' . $review->getError());
                $ok = FALSE;
            }

            if (!$votes->delete($prod_id, 'virtuemart_product_id')) {
                vmError(get_class($this) . '::Error deleting votes ' . $votes->getError());
                $ok = FALSE;
            }
        }

        return $ok;
    }

    /**
     * Returns the number of reviews assigned to a product
     *
     * @author RolandD
     * @param int $pid Product ID
     * @return int
     */
    public function countReviewsForProduct($pid) {
        $db = JFactory::getDBO();
        $q = "SELECT COUNT(*) AS total
			FROM #__virtuemart_rating_reviews
			WHERE virtuemart_product_id=" . (int) $pid;
        $db->setQuery($q);
        $reviews = $db->loadResult();
        return $reviews;
    }

    public function showReview($product_id) {

        return $this->show($product_id, VmConfig::get('showReviewFor', 'all'));
    }

    public function showRating() {

        return $this->show(0, VmConfig::get('showRatingFor', 'all'));
    }

    public function allowReview($product_id) {
        return $this->show($product_id, VmConfig::get('reviewMode', 'registered'));
    }

    public function allowRating($product_id) {
        //return $this->show($product_id, VmConfig::get('reviewMode','registered'));
        return true;
    }

    /**
     * Decides if the rating/review should be shown on the FE
     * @author Max Milbers
     */
    private function show($product_id, $show) {

        //dont show
        if ($show == 'none') {
            return FALSE;
        }
        //show all
        else {
            if ($show == 'all') {
                return TRUE;
            }
            //show only registered
            else {
                if ($show == 'registered') {
                    $user = JFactory::getUser();
                    return !empty($user->id);
                }
                //show only registered && who bought the product
                else {
                    if ($show == 'bought') {
                        if (!empty($this->_productBought)) {
                            return TRUE;
                        }

                        $user = JFactory::getUser();
                        if (empty($product_id)) {
                            return FALSE;
                        }

                        $db = JFactory::getDBO();
                        $q = 'SELECT COUNT(*) as total FROM `#__virtuemart_orders` AS o LEFT JOIN `#__virtuemart_order_items` AS oi ';
                        $q .= 'ON `o`.`virtuemart_order_id` = `oi`.`virtuemart_order_id` ';
                        $q .= 'WHERE o.virtuemart_user_id = "' . $user->id . '" AND oi.virtuemart_product_id = "' . $product_id . '" ';

                        $db->setQuery($q);
                        $count = $db->loadResult();
                        if ($count) {
                            $this->_productBought = TRUE;
                            return TRUE;
                        } else {
                            return FALSE;
                        }
                    }
                }
            }
        }
    }

}

// pure php no closing tag
