<?php

/**
 *
 * Controller for the front end Manufacturerviews
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: manufacturer.php 2420 2010-06-01 21:12:57Z oscar $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
 * VirtueMart Component Controller
 *
 * @package		VirtueMart
 */
class VirtueMartControllerProductAlert extends JController {

    public function __construct() {
        parent::__construct();

        $this->registerTask('addAlert', 'addAlert');
        $this->registerTask('removeAlert', 'removeAlert');
        $this->registerTask('removeAllAlert', 'removeAllAlert');
        $this->registerTask('addAllToCompate', 'addAllToCompate');
        $this->registerTask('updateEmail', 'updateEmail');
        $this->registerTask('AllToAlert', 'AllToAlert');
    }
    public function AllToAlert(){

        $promotion = $_POST['promotion'];
        $clearance = $_POST['clearance'];
        $price_reduction = $_POST['price_reduction'];
        $new_review = $_POST['new_review'];
        if (!$promotion)
            $promotion = 0;
        if (!$clearance)
            $clearance = 0;
        if (!$price_reduction)
            $price_reduction = 0;
        if (!$new_review)
            $new_review = 0;


        $db = JFactory::getDBO();
        $myuser = &JFactory::getUser();
        $wishlistModel = VmModel::getModel('wishlist');
            $wishlist = $wishlistModel->getWishlistByUser((int) $myuser->id);

            if ($wishlist) {
                foreach ($wishlist as $key => $value) {
                    $compare_list[(int) $value->product_id] = (int) $value->product_id;
                     $qcheck = "SELECT * FROM #__virtuemart_products_alert WHERE virtuemart_product_id=$value->product_id and user_id=$myuser->id";
                    $db->setQuery($qcheck);
                    $fa = $db->loadObject();
                    if(empty($fa)){
                        $query = "INSERT INTO #__virtuemart_products_alert (virtuemart_product_id, user_id,alert_email,alert_product_promotion,alert_product_clearance_sale,alert_product_price_reduction,alert_product_new_review)
                            values($value->product_id,$myuser->id,'$myuser->email',$promotion,$clearance,$price_reduction,$new_review)";
                        $db->setQuery($query);
                        $db->query();
                    }else{
                        $query = "  UPDATE #__virtuemart_products_alert
                                    SET alert_product_promotion = $promotion,
                                        alert_product_clearance_sale = $clearance,
                                        alert_product_price_reduction =$price_reduction,
                                        alert_product_new_review = $new_review
                                    WHERE user_id=$myuser->id AND virtuemart_product_id=$value->product_id";
                        $db->setQuery($query);
                        $db->query();
                    }
                }
            }
//        echo $promotion;
        echo 'All Items added to Alert';
        jExit();
    }
    public function updateEmail() {
        $new_email = $_POST['new_email'];
        $uid = JFactory::getUser()->id;
        $db = JFactory::getDBO();
        $query = "  UPDATE #__virtuemart_products_alert
                    SET alert_email = '$new_email'
                    WHERE user_id=$uid";
        $db->setQuery($query);
        $db->query();
        echo '{"email_update":"'.$query.'"}';
        jExit();
    }
    public function addAllToCompate() {
        $AlertModel = VmModel::getModel('product_alert');
        $ToCompate = $AlertModel->getAllAlertId();
        $_SESSION['compare_list'] = $ToCompate;

        $this->json = new stdClass();
        $this->json->msg = 'All Items added to Comparison';
        $this->json->number = count($ToCompate);
        echo json_encode($this->json);

        jExit();
    }


    public function removeAlert() {
        $id = $_POST['virtuemart_product_alert_id'];
        $db = JFactory::getDBO();
        $query = "  DELETE FROM #__virtuemart_products_alert
                    WHERE virtuemart_product_alert_id=$id";
        $db->setQuery($query);
        $db->query();
        echo '{"delete_ok":"ok"}';
        die();
    }

    public function removeAllAlert() {
        $uid = JFactory::getUser()->id;
        $db = JFactory::getDBO();
        $query = "  DELETE FROM #__virtuemart_products_alert
                    WHERE user_id=$uid";
        $db->setQuery($query);
        $db->query();
        echo '{"delete_ok":"ok"}';
        jExit();
    }

    public function addAlert() {
        $db = JFactory::getDBO();
        $html='';
        $userid = $_POST['uid'];
        $product_id = $_POST['product_id'];
        $email = $_POST['email'];
        $promotion = $_POST['promotion'];
        $clearance = $_POST['clearance'];
        $price_reduction = $_POST['price_reduction'];
        $new_review = $_POST['new_review'];
        $alert_action = $_POST['alert_action'];
//        echo $alert_action; die();
        if (!$promotion)
            $promotion = 0;
        else
            $html='<p><span>Promotion For This Product</span></p>';
        if (!$clearance)
            $clearance = 0;
        else
            $html .='<p><span>Clearance Sale For This Product</span></p>';
        if (!$price_reduction)
            $price_reduction = 0;
        else
            $html .='<p><span>Price Reduction For This Product</span></p>';
        if (!$new_review)
            $new_review = 0;
        else
            $html .='<p><span>New Review For This Product</span></p>';

        $model = VmModel::getModel('product_alert');
        $fdc = $model->getAlert($userid,$product_id);
        
        if (!empty($fdc)):
            $query = "
                UPDATE #__virtuemart_products_alert
                SET alert_product_promotion=$promotion,alert_product_clearance_sale=$clearance,
                    alert_product_price_reduction=$price_reduction,alert_product_new_review = $new_review
                WHERE virtuemart_product_id=$product_id AND user_id=$userid
            ";
            $db->setQuery($query);
            $db->query();
        else :
            $query = "INSERT INTO #__virtuemart_products_alert
                (virtuemart_product_id,user_id,alert_email,alert_product_promotion,alert_product_clearance_sale,alert_product_price_reduction,alert_product_new_review) values
                ($product_id,$userid,'$email',$promotion,$clearance,$price_reduction,$new_review)";
            $db->setQuery($query);
            $db->query();
        endif;


        echo '{"html":"'.$html.'"}';
        jExit();
    }


}

// No closing tag
