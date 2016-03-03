<?php
/**
*
* Description
*
* @package  VirtueMart
* @subpackage
* @author RolandD
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: productdetails.php 4627 2011-11-08 23:45:27Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
* VirtueMart Component Controller
*
* @package VirtueMart
* @author RolandD
*/
class VirtueMartControllerProductcompare extends JController
{
  const  PAGE_NUMBER = 5;

  public function __construct() {
    parent::__construct();
//     $this->registerTask( 'recommend','MailForm' );
//     $this->registerTask( 'askquestion','MailForm' );

    $compare_list = $_SESSION['compare_list'];
    $productModel = VmModel::getModel ('product');
    $ratingModel = VmModel::getModel('ratings');
    $categoryModel = VmModel::getModel('category');

    $manufacturercategoriesModel = VmModel::getModel('manufacturercategories');

    $total_number = count($compare_list);
    $page = JRequest::getVar('page', 1);
    $compare_list = array_chunk($compare_list, self::PAGE_NUMBER, true);

    //build paging
    $max_page = count($compare_list);
    $page_array = array();

    if ($max_page > 0) {
      if ($page > $max_page) {
        $page = $max_page;
      }

      foreach ($compare_list as $key => $value) {
        $page_number = $key + 1;

        if ($key < 10) {
          $page_nunmber_text = '0' . $page_number;
        } else {
          $page_nunmber_text = $page_number;
        }

        if ($page_number == $page) {
          $class = 'page current';
        } else {
          $class = 'page';
        }

        $page_array['pages'][] = JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productcompare&page=' . $page_number), $page_nunmber_text, array('class' => $class));
      }

      if ($page != 1) {
        $page_array['pre'] = JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productcompare&page=' . ($page - 1)), '< Previous', array('class' => 'pre'));
      }

      if ($page != $max_page) {
        $page_array['next'] = JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productcompare&page=' . ($page + 1)), 'Next >', array('class' => 'next'));
      }

    }

    $general_info = array();
    $price_array = array();
    $brand_array = array();
    $manufacturer_array = array();
    $average_rating = array();
    $features_array = array();
    $detail_array = array();
    $review_array =array();
    $video_array = array();
    $countweight = 0;
    $countheight = 0;
    $countlength = 0;
    $countwidth = 0;
    $countinsertable_length = 0;
    $countcircumference = 0;
    $countdiameter = 0;
    
    foreach ($compare_list[$page - 1] as $key => $product_id) {
      $product_data = $productModel->getProduct((int)$product_id);

      if (!class_exists('VirtueMartModelCustomfields')) {
        require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'customfields.php');
      }

      //general info
      $productModel->addImages($product_data, 1);
      $general_info[$product_id]['name'] = $product_data->product_name;
      $general_info[$product_id]['image'] = $product_data->images[0]->file_url;

      //price info
      $price_array[$product_id] = $product_data->prices;

      //brand info
      $brand_array[$product_id] = $product_data->mf_name;

      //manufacturer info
      $manufacturer_array[$product_id] = $manufacturercategoriesModel->getMfCategoryName($product_data->virtuemart_manufacturercategories_i);

      //average rating info
      $average_rating[$product_id] = $categoryModel->get5RatingByProduct($product_id);

      if (!class_exists('CurrencyDisplay')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'currencydisplay.php');
      $currency = CurrencyDisplay::getInstance();vmdebug('hmm',$currency);

      //detail info
      $detail_array['color'][$product_id] = NULL;
      $detail_array['weight'][$product_id] = $currency->convertUnit($product_data->product_weight, $product_data->product_weight_uom);
      if($product_data->product_weight > 0){
          $countweight++ ;
      }
      $detail_array['height'][$product_id] = $currency->convertUnit($product_data->product_height, $product_data->product_lwh_uom);
      if($product_data->product_height > 0){
          $countheight++ ;
      }
      $detail_array['width'][$product_id] = $currency->convertUnit($product_data->product_width, $product_data->product_lwh_uom);
      if($product_data->product_width > 0){
          $countwidth++ ;
      }
      $detail_array['length'][$product_id] = $currency->convertUnit($product_data->product_length, $product_data->product_lwh_uom);
      if($product_data->product_length > 0){
          $countlength++ ;
      }
      $detail_array['insertable_length'][$product_id] = $currency->convertUnit($product_data->insertable_length, $product_data->product_lwh_uom);
      if($product_data->insertable_length > 0){
          $countinsertable_length++ ;
      }
      $detail_array['circumference'][$product_id] = $currency->convertUnit($product_data->circumference, $product_data->product_lwh_uom);
      if($product_data->product_weight > 0){
          $countcircumference++ ;
      }
      $detail_array['diameter'][$product_id] = $currency->convertUnit($product_data->diameter, $product_data->product_lwh_uom);
      if($product_data->circumference > 0){
          $countdiameter++ ;
      }
      $detail_array['materials'][$product_id] = $product_data->materials;
      $detail_array['made_in'][$product_id] = $product_data->made_in;
      $detail_array['product_type'][$product_id] = $product_data->product_type;
      $detail_array['product_lining'][$product_id] = $product_data->product_lining;
      $detail_array['cock_ring_style'][$product_id] = $product_data->cock_ring_style;
      $detail_array['product_boning'][$product_id] = $product_data->product_boning;
      $detail_array['bottom_style'][$product_id] = $product_data->bottom_style;
      $detail_array['flavor'][$product_id] = $product_data->flavor;
      $detail_array['lingerie_closure'][$product_id] = $product_data->lingerie_closure;
      $detail_array['lingerie_special_features'][$product_id] = $product_data->lingerie_special_features;
      $detail_array['product_pattern'][$product_id] = $product_data->product_pattern;
      $detail_array['product_top_style'][$product_id] = $product_data->product_top_style;
      $detail_array['product_texture'][$product_id] = $product_data->product_texture;
      $detail_array['safety_features'][$product_id] = $product_data->safety_features;
      $detail_array['material_safety'][$product_id] = $product_data->material_safety;
      $detail_array['care_and_cleaning'][$product_id] = $product_data->care_and_cleaning;
      $detail_array['pump_mechanism'][$product_id] = $product_data->pump_mechanism;
      $detail_array['clitoral_attachment_shape'][$product_id] = $product_data->clitoral_attachment_shape;
      $detail_array['special_features'][$product_id] = $product_data->special_features;
      $detail_array['powered_by'][$product_id] = $product_data->powered_by;
      $detail_array['harness_compatibility'][$product_id] = $product_data->harness_compatibility;
      $detail_array['product_functions'][$product_id] = $product_data->product_functions;
      $detail_array['control_type'][$product_id] = $product_data->control_type;
      $detail_array['product_size'][$product_id] = $product_data->product_size;
      $detail_array['maximum_hip_size'][$product_id] = $product_data->maximum_hip_size;
      $detail_array['maximum_waist_size'][$product_id] = $product_data->maximum_waist_size;
      $detail_array['cup_size'][$product_id] = $product_data->cup_size;
      $detail_array['max_stretched_diameter'][$product_id] = $product_data->max_stretched_diameter;
      $detail_array['unstretched_diameter'][$product_id] = $product_data->unstretched_diameter;
      $detail_array['inner_diameter'][$product_id] = $product_data->inner_diameter;

      if ($product_data->customfieldsCart) {
        $color_list = array();

        foreach ($product_data->customfieldsCart as $key => $value) {
          if ($value->options) {
            if ($value->custom_title == 'Color') {
              foreach ($value->options as $color) {
                if ($color->custom_value) {
                  $color_list[] = $color->custom_value;
                }
              }
            }
          }
        }

        $detail_array['color'][$product_id] = implode(', ', $color_list);
      }

      //review info
      $review_array['average_customer'][$product_id] = $ratingModel->getRatingByProduct($product_id);
      $review_array['top_highly_rated'][$product_id] = $ratingModel->getReviews($product_id);

      //video info
      $video_array[$product_id] = $product_data->product_videos;
    }
    $detail_array['countweight'] = $countweight;
    $detail_array['countlength'] = $countlength;
    $detail_array['countwidth'] = $countwidth;
    $detail_array['countinsertable_length'] = $countinsertable_length;
    $detail_array['countcircumference'] = $countcircumference;
    $detail_array['countdiameter'] = $countdiameter;
    $detail_array['countheight'] = $countheight;
    

    $view = $this->getView('productcompare', 'html');

    //get wishlist list
    $myuser =& JFactory::getUser();
    $wishlist_list = array();

    if ($myuser->guest) {
      $wishlist_list = $_SESSION['wishlist'];
    } else {
      $wishlistModel = VmModel::getModel('wishlist');
      $wishlist_list = $wishlistModel->getProductIdByUser((int)$myuser->id);
    }

    $view->assignRef('wishlist_list', $wishlist_list);
    $view->assignRef('compare_list', $compare_list[$page - 1]);
    $view->assignRef('general_info', $general_info);
    $view->assignRef('price_array', $price_array);
    $view->assignRef('brand_array', $brand_array);
    $view->assignRef('manufacturer_array', $manufacturer_array);
    $view->assignRef('average_rating', $average_rating);
    $view->assignRef('detail_array', $detail_array);
    $view->assignRef('review_array', $review_array);
    $view->assignRef('video_array', $video_array);
    $view->assignRef('page_array', $page_array);
    $view->assignRef('total_number', $total_number);

    // Display it all
    //$view->display();

  }



  public function Productcompare() {

//    $cart = JRequest::getVar('cart',false,'post');
//    if($cart){
//      require(JPATH_VM_SITE.DS.'controllers'.DS.'cart.php');
//      $controller= new VirtueMartControllerCart();
//      $controller->add();
//    }else{
      $format = JRequest::getWord('format','html');

      /* Create the view */
      $view = $this->getView('productcompare', $format);
      if  ($format == 'pdf') $view->setLayout('pdf');

      $this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart' . DS . 'models');
      /* Add the default model */
      $view->setModel($this->getModel('product','VirtuemartModel'), true);

      /* Add the category model */
      $view->setModel($this->getModel('category', 'VirtuemartModel'));

      $view->setModel($this->getModel( 'ratings', 'VirtuemartModel'));
      $view->setModel( $this->getModel( 'product_relations', 'VirtueMartModel' ));

      /* Display it all */
      $view->display();
//    }
  }

  /**
   * Send the ask question email.
   * @author Kohl Patrick, Christopher Roussel
   */
  public function mailAskquestion () {

    if(!class_exists('shopFunctionsF')) require(JPATH_VM_SITE.DS.'helpers'.DS.'shopfunctionsf.php');
    $mainframe = JFactory::getApplication();
    $vars = array();

    $this->addModelPath(JPATH_VM_ADMINISTRATOR.DS.'models');
    $productModel = $this->getModel('product');

    $cids = JRequest::getVar('cid');
    $vars['product'] = $productModel->getProduct((int)$cids[0]);

    $user = JFactory::getUser();
    if (empty($user->id)) {
      $fromMail = JRequest::getVar('email');  //is sanitized then
      $fromName = JRequest::getVar('name','');//is sanitized then
      $fromMail = str_replace(array('\'','"',',','%','*','/','\\','?','^','`','{','}','|','~'),array(''),$fromMail);
      $fromName = str_replace(array('\'','"',',','%','*','/','\\','?','^','`','{','}','|','~'),array(''),$fromName);
    }
    else {
      $fromMail = $user->email;
      $fromName = $user->name;
     }
     $vars['user'] = array('name' => $fromName, 'email' => $fromMail);

     $vendorModel = $this->getModel('vendor');
    $VendorEmail = $vendorModel->getVendorEmail($vars['product']->virtuemart_vendor_id);
    $vars['vendor'] = array('vendor_store_name' => $fromName );

    if (shopFunctionsF::renderMail('askquestion', $VendorEmail, $vars,'productdetails')) {
      $string = 'COM_VIRTUEMART_MAIL_SEND_SUCCESSFULLY';
    }
    else {
      $string = 'COM_VIRTUEMART_MAIL_NOT_SEND_SUCCESSFULLY';
    }
    $mainframe->enqueueMessage(JText::_($string));

    /* Display it all */
    $view = $this->getView('askquestion', 'html');
    $view->setModel($this->getModel('category', 'VirtuemartModel'));
    $view->setLayout('mail_confirmed');
    $view->display();
  }

  /**
   * Send the Recommend to a friend email.
   * @author Kohl Patrick,
   */
  public function mailRecommend () {

    if(!class_exists('shopFunctionsF')) require(JPATH_VM_SITE.DS.'helpers'.DS.'shopfunctionsf.php');
    $mainframe = JFactory::getApplication();
    $vars = array();

    $this->addModelPath(JPATH_VM_ADMINISTRATOR.DS.'models');
    $productModel = $this->getModel('product');

    $cids = JRequest::getVar('cid');
    $vars['product'] = $productModel->getProduct((int)$cids[0]);

    $user = JFactory::getUser();
      $fromMail = $user->email;
      $fromName = $user->name;
    $vars['user'] = array('name' => $fromName, 'email' => $fromMail);

    $TOMail = JRequest::getVar('email');  //is sanitized then
    $TOMail = str_replace(array('\'','"',',','%','*','/','\\','?','^','`','{','}','|','~'),array(''),$TOMail);
    if (shopFunctionsF::renderMail('recommend', $TOMail, $vars,'productdetails')) {
      $string = 'COM_VIRTUEMART_MAIL_SEND_SUCCESSFULLY';
    }
    else {
      $string = 'COM_VIRTUEMART_MAIL_NOT_SEND_SUCCESSFULLY';
    }
    $mainframe->enqueueMessage(JText::_($string));

    /* Display it all */
    $view = $this->getView('recommend', 'html');
    $view->setModel($this->getModel('category', 'VirtuemartModel'));
    $view->setLayout('mail_confirmed');
    $view->display();
  }

  /**
   *  Ask Question form
   * Recommend form for Mail
   */
  public function MailForm(){

    /* Create the view */
    if (JRequest::getCmd('task') == 'recommend' ) {
      $user = JFactory::getUser();
      if (empty($user->id)) {
        $this->setRedirect(JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.JRequest::getInt('virtuemart_product_id',0) ),JText::_('YOU MUST LOGIN FIRST'));
        return ;
      }
      $view = $this->getView('recommend', 'html');
    } else {
      $view = $this->getView('askquestion', 'html');
    }

    $this->addModelPath( JPATH_VM_ADMINISTRATOR.DS.'models' );

    /* Add the default model */
    $view->setModel($this->getModel('product','VirtuemartModel'), true);

    /* Add the category model */
    $view->setModel($this->getModel('category', 'VirtuemartModel'));

    /* Set the layout */
    $view->setLayout('form');

    /* Display it all */
    $view->display();
  }

  /* Add or edit a review
   TODO  control and update in database the review */
  public function review(){

    $mainframe = JFactory::getApplication();
    // add the ratings admin model

    $this->addModelPath( JPATH_VM_ADMINISTRATOR.DS.'models' );

    /* Create the view */
    $view = $this->getView('productdetails', 'html');

    /* Add the default model */
    $view->setModel($this->getModel('product','VirtuemartModel'), true);

    /* Add the category model */
    $view->setModel($this->getModel('category', 'VirtuemartModel'));

    $view->setModel($model = $this->getModel( 'ratings', 'VirtuemartModel' ));

    /* Get the posted data */
    $data = JRequest::get('post');

    $model->saveRating($data);
    $errors = $model->getErrors();
    if(empty($errors)) $msg = JText::sprintf('COM_VIRTUEMART_STRING_SAVED',JText::_('COM_VIRTUEMART_REVIEW') );
    foreach($errors as $error){
      $msg = ($error).'<br />';
    }

//    $msgtype = '';
//    if ($model->saveRating($data)) $mainframe->enqueueMessage( JText::_('COM_VIRTUEMART_RATING_SAVED_SUCCESSFULLY') );
//    else {
//      $mainframe->enqueueMessage($model->getError());
//      $mainframe->enqueueMessage( JText::_('COM_VIRTUEMART_RATING_NOT_SAVED_SUCCESSFULLY') );
//    }

    $this->setRedirect('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$data['virtuemart_product_id'], $msg);
    /* Display it all */
//    $view->display();
  }

  /**
   * Json task for recalculation of prices
   *
   * @author Max Milbers
   * @author Patrick Kohl
   *
   */
  public function recalculate(){

    //$post = JRequest::get('request');

//    echo '<pre>'.print_r($post,1).'</pre>';
    jimport( 'joomla.utilities.arrayhelper' );
    $virtuemart_product_idArray = JRequest::getVar('virtuemart_product_id',array());  //is sanitized then
    JArrayHelper::toInteger($virtuemart_product_idArray);
    $virtuemart_product_id = $virtuemart_product_idArray[0];
    $customPrices = array();
    $customVariants = JRequest::getVar('customPrice',array());  //is sanitized then
    foreach($customVariants as $customVariant){
      foreach($customVariant as $priceVariant=>$selected){
        //Important! sanitize array to int
        //JArrayHelper::toInteger($priceVariant);
        $customPrices[$priceVariant]=$selected;
      }
    }

    jimport( 'joomla.utilities.arrayhelper' );
    $quantityArray = JRequest::getVar('quantity',array());  //is sanitized then
    JArrayHelper::toInteger($quantityArray);

    $quantity = 1;
    if(!empty($quantityArray[0])){
      $quantity = $quantityArray[0];
    }
    //echo '<pre>'.print_r($quantityArray,1).' and $quantity '.$quantity.'</pre>';

    $this->addModelPath( JPATH_VM_ADMINISTRATOR.DS.'models' );
    $product_model = $this->getModel('product');

    $prices = $product_model->getPrice($virtuemart_product_id,$customPrices,$quantity);
    $priceFormated = array();
    if (!class_exists('CurrencyDisplay')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'currencydisplay.php');
    $currency = CurrencyDisplay::getInstance();vmdebug('hmm',$currency);
    foreach ( $prices as $name => $product_price  ){
      $priceFormated[$name] = $currency->createPriceDiv($name,'',$prices,true);
    }

    // Get the document object.
    $document = JFactory::getDocument();

    // Set the MIME type for JSON output.
    $document->setMimeEncoding( 'application/json' );

    echo json_encode ($priceFormated);
    jexit();
    die;

  }

/*  public function getData() {

    $this->addModelPath( JPATH_VM_ADMINISTRATOR.DS.'models' );


    // Standard model
    //$view->setModel( $this->getModel( 'product', 'VirtueMartModel' ), true );
    $type = JRequest::getWord('type', false);
    // Now display the view.

  }*/


  public function getJsonChild() {
  $view = $this->getView('productdetails', 'json');
    $this->addModelPath( JPATH_VM_ADMINISTRATOR.DS.'models' );
    $view->setModel( $this->getModel('product'));
    $view->display(null);
  }

  public function addcompare()
  {
    $product_id = JRequest::getInt('product_id', NULL);

    $topCompareModel = VmModel::getModel('top_compare');

    if ($product_id !== NULL) {
      $compare_list = $_SESSION['compare_list'];
      $compare_list[$product_id] = $product_id;

      foreach ($compare_list as $value)  {
        if ($value != $product_id) {
          if ($topCompareModel->isExists($product_id, $value)) {
            $topCompareModel->updateCount($product_id, $value);
          } else {
            $topCompareModel->insertRecord($product_id, $value);
          }
        }
      }

      $_SESSION['compare_list'] = $compare_list;
    }

    echo count($compare_list);

    jexit();
  }

  public function deletecompare()
  {
    $product_id = JRequest::getInt('product_id', NULL);

    if ($product_id !== NULL) {
      $compare_list = $_SESSION['compare_list'];
      unset($compare_list[$product_id]);

      $_SESSION['compare_list'] = $compare_list;
    }

    echo count($compare_list);

    jexit();
  }

  public function deleteallcompare()
  {
    $_SESSION['compare_list'] = array();

    jexit();
  }
}
// pure php no closing tag
