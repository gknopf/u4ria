<?php

/**
 *
 * Controller for the cart
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author RolandD
 * @author Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: cart.php 6502 2012-10-04 13:19:26Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
 * Controller for the cart view
 *
 * @package VirtueMart
 * @subpackage Cart
 * @author RolandD
 * @author Max Milbers
 */
class VirtueMartControllerCart extends JController {

    /**
     * Construct the cart
     *
     * @access public
     * @author Max Milbers
     */
    public function __construct() {

        parent::__construct();
        if (VmConfig::get('use_as_catalog', 0)) {
            $app = JFactory::getApplication();
            $app->redirect('index.php');
        } else {
            if (!class_exists('VirtueMartCart'))
                require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
            if (!class_exists('calculationHelper'))
                require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'calculationh.php');
        }
        $this->useSSL = VmConfig::get('useSSL', 0);
        $this->useXHTML = true;
    }

    /**
     * Add the product to the cart
     *
     * @author RolandD
     * @author Max Milbers
     * @access public
     */
    public function add() {
        $mainframe = JFactory::getApplication();
        if (VmConfig::get('use_as_catalog', 0)) {
            $msg = JText::_('COM_VIRTUEMART_PRODUCT_NOT_ADDED_SUCCESSFULLY');
            $type = 'error';
            $mainframe->redirect('index.php', $msg, $type);
        }
        $cart = VirtueMartCart::getCart();
        if ($cart) {
            $virtuemart_product_ids = JRequest::getVar('virtuemart_product_id', array(), 'default', 'array');
            $success = true;
            if ($cart->add($virtuemart_product_ids, $success)) {
                $msg = JText::_('COM_VIRTUEMART_PRODUCT_ADDED_SUCCESSFULLY');
                $type = '';
            } else {
                $msg = JText::_('COM_VIRTUEMART_PRODUCT_NOT_ADDED_SUCCESSFULLY');
                $type = 'error';
            }

            $mainframe->enqueueMessage($msg, $type);
            $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart'));
        } else {
            $mainframe->enqueueMessage('Cart does not exist?', 'error');
        }
    }
    public function addGc() {
        $data = JRequest::get('post');
        JPluginHelper::importPlugin('captcha');
        $dispatcher = JDispatcher::getInstance();
        $res = $dispatcher->trigger('onCheckAnswer',$post['recaptcha_response_field']);
        $mainframe = JFactory::getApplication();
        if(!$res[0]){
            $type = 'error';
            $msg = 'Empty solution not allowed.';
            $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=giftcertificate'), $msg, $type);
        }
//        $mainframe = JFactory::getApplication();
        if (VmConfig::get('use_as_catalog', 0)) {
            $msg = JText::_('COM_VIRTUEMART_PRODUCT_NOT_ADDED_SUCCESSFULLY');
            $type = 'error';
            $mainframe->redirect('index.php', $msg, $type);
        }
        $cart = VirtueMartCart::getCart();
        if ($cart) {
            $virtuemart_product_ids = JRequest::getVar('virtuemart_product_id', array(), 'default', 'array');
            $success = true;
            if ($cart->add($virtuemart_product_ids, $success)) {
                $msg = JText::_('COM_VIRTUEMART_PRODUCT_ADDED_SUCCESSFULLY');
                $type = '';
            } else {
                $msg = JText::_('COM_VIRTUEMART_PRODUCT_NOT_ADDED_SUCCESSFULLY');
                $type = 'error';
            }

            $mainframe->enqueueMessage($msg, $type);
            $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart'));
        } else {
            $mainframe->enqueueMessage('Cart does not exist?', 'error');
        }
    }

    /**
     * Add the product to the cart, with JS
     *
     * @author Max Milbers
     * @access public
     */
    public function addJS() {

        $this->json = new stdClass();
        $cart = VirtueMartCart::getCart(false);

        if ($cart) {
            // Get a continue link */
            $virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId();
            if ($virtuemart_category_id) {
                $categoryLink = '&view=category&virtuemart_category_id=' . $virtuemart_category_id;
            } else {
                $categoryLink = '';
            }

            $type_submit = JRequest::getVar('type', FALSE);

//            $continue_link = JRoute::_('index.php?option=com_virtuemart' . $categoryLink);
            $continue_link = '';
            $virtuemart_product_ids = JRequest::getVar('virtuemart_product_id', array(), 'default', 'array');
            $errorMsg = JText::_('COM_VIRTUEMART_CART_PRODUCT_ADDED');

//            test
            $product_model = VmModel::getModel('product');
            $product = $product_model->getProduct($virtuemart_product_ids, TRUE, TRUE, TRUE, 1);

            $color_list = array();
            $size_list = array();

            if ($product->customfieldsCart) {
                foreach ($product->customfieldsCart as $key => $value) {
                    if ($value->options) {
                        if ($value->custom_title == 'Color') {
                            foreach ($value->options as $color) {
                                if ($color->custom_value) {
                                    $color_list[$color->virtuemart_customfield_id]['custom_value'] = $color->custom_value;
                                    $color_list[$color->virtuemart_customfield_id]['custom_price'] = $color->custom_price;
                                }
                            }
                        } else if ($value->custom_title == 'Size') {
                            foreach ($value->options as $size) {
                                if ($size->custom_value) {
                                    $size_list[$size->virtuemart_customfield_id]['custom_value'] = $size->custom_value;
                                    $size_list[$size->virtuemart_customfield_id]['custom_price'] = $size->custom_price;
                                }
                            }
                        }
                    }
                }
            }

            $size_color_list = array();

            if ($color_list || $size_list) {
                if ($color_list && $size_list) {
                    foreach ($color_list as $color_id => $color_info) {
                        foreach ($size_list as $size_id => $size_info) {
                            $index = $color_id . '-' . $size_id;
                            $size_color_list[$index]['custom_value'] = $size_info['custom_value'] . '/' . $color_info['custom_value'];
                            $size_color_list[$index]['custom_price'] = $color_info['custom_price'] + $size_info['custom_price'];
                        }
                    }
                } else if ($color_list) {
                    $size_color_list = $color_list;
                } else {
                    $size_color_list = $size_list;
                }
            }
$abc='';
            $abc.='<form method="post" class="product js-recalculate color_popup" action="" >';
            if (!empty($product->customfieldsCart)) {
                $abc .= '<div class="product-fields">';
                     foreach ($product->customfieldsCart as $field) {
                        $abc .= '<div>';
					$abc .='<span class="product-fields-title-wrapper"><span class="product-fields-title"><strong>'. JText::_ ($field->custom_title) .'</strong></span>';
                         if ($field->custom_tip) {
                            $abc .= JHTML::tooltip ($field->custom_tip, JText::_ ($field->custom_title), 'tooltip.png');
                        }
                    $abc .= '</span>';
                    $abc .=        '<span class="product-field-desc" style="color:Red;font-weight:bold">Color / Price</span><br/>';
                    $abc .=        '<span class="product-field-display">'. $field->display .'</span>';

                    $abc .=    '</div><br/>';

                    }

                $abc .= '</div>';

            }

            //add to cart
$abc .= '<div class="addtocart-bar">';

$stockhandle = VmConfig::get ('stockhandle', 'none');
if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($product->product_in_stock - $product->product_ordered) < 1) {

    $abc .= '<span class="notify_me">';
    $abc .= '<a href="'. JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='. $product->virtuemart_product_id) .'" style="color: #C01D2E;" class="notify">';
    $abc .=  JText::_ ('COM_VIRTUEMART_CART_NOTIFY') ;
    $abc .= '</a></span><span class="btnoutstock">OUT OF STOCK</span>';
    $abc .= '<span class="note_restock">Estimate restock in 2 -3 weeks</span>';
} else {

    $abc .= '<span class="quantity-box">';
    $abc .= '<input type="text" class="quantity-input js-recalculate" name="quantity[]" onblur="check(this);" value="';
    if (isset($product->step_order_level) && (int)$product->step_order_level > 0) {
        $abc.= $product->step_order_level;
		} else if(!empty($product->min_order_level)){
        $abc.= $product->min_order_level;
		}else {
        $abc.= '1';
		}
    $abc .= '"/>';
    $abc .= '</span>';
    $abc .= ' <span class="quantity-controls js-recalculate">';
    $abc .= '<input type="button" class="quantity-controls quantity-plus"/>';
    $abc .= '<input type="button" class="quantity-controls quantity-minus"/>';
    $abc .= '</span>';
    $abc .= '<span class="addtocart-button" style="position:relative;margin-left:40px">';
 if ($product->product_in_stock > 0):
     $abc .= '<img style="position:absolute;left:5px;top:8px;" class="add_compare_icon" border="0" alt="By now" title="By now" src="images/cart-icon.gif" width="20px">';
     $abc .= shopFunctionsF::getAddToCartButton($product->orderable);
 else:
     $abc .= '<span class="notify_me">NOTIFY ME</span>';
 endif;
    $abc .= '</span>';
 if ($product->product_in_stock > 3):
     $abc .= '<span class="btninstock">IN STOCK</span>';
 elseif ($product->product_in_stock > 0 && $product->product_in_stock <= 3):
     $abc .= '<span class="btnoutstock">LAST 3 PIECES</span>';
 else:
     $abc .= '<span class="btnoutstock">OUT OF STOCK</span>';
     $abc .= '<span class="note_restock">Estimate restock in 2 -3 weeks</span>';
 endif;
 }
            $abc .= '<div class="clear"></div></div>';
            $abc .= '   <input type="hidden" class="pname" value="'. htmlentities($product->product_name, ENT_QUOTES, 'utf-8').'"/>';
            $abc .= '<input type="hidden" name="option" value="com_virtuemart"/>';
		 $abc .= '<input type="hidden" name="view" value="cart"/>';
            $abc .= '<input type="hidden" name="task" value="add"/>';
            $abc .= '<input type="hidden" name="format" value="json"/>';
		 $abc .= '<noscript><input type="hidden" name="task" value="add"/></noscript>';
		 $abc .= '<input type="hidden" name="virtuemart_product_id[]" value="'. $product->virtuemart_product_id .'"/>';
		 $abc .= '<input type="hidden" id="virtuemart_product_id" value="'. $product->virtuemart_product_id .'"/>';
$abc.='</form>';
            $abc.='<script>jQuery(document).ready(function ($) {$(\'form.color_popup span.product-field-display\').find("label.other-customfield").append("<br/>");});</script>';
            $abc.='<style>';
            $abc.='form.color_popup span.quantity-box,form.color_popup span.js-recalculate,form.color_popup span.product-fields-title-wrapper{display:none;} ';
            $abc.='form.color_popup span.btnoutstock {float:left;margin-left:60px;}';
            $abc.='form.color_popup input.addtocart-button:hover {color:#92287f;}';
            $abc.='form.color_popup input.addtocart-button, form.color_popup span.btnoutstock {background:none;border:3px solid #8E0B7C;border-radius:0 27px 27px 0;color:#C01D2E;font:bold 15px arial;padding:6px 25px;}';
            $abc.='</style>';

//            end test

            // [SLam] fix bug: add the same free gift
            if ($type_submit == 'freegift') {
                foreach ($cart->products as $key_temp => $value_temp) {
                    if (in_array($value_temp->virtuemart_product_id, $virtuemart_product_ids)) {
                        $this->json->stat = '3';
                        $this->json->msg = 'You have already added this free gift.';
                        echo json_encode($this->json);
                        jExit();
                    }
                }
            }


            if ($cart->add($virtuemart_product_ids, $errorMsg)) {
                $user = JFactory::getUser();
                if (($user->get('guest') != 1)) {
                    $historyTransactionsModel = VmModel::getModel('History_transactions');
                    $historyTransactionsModel->storeHistoryTransaction($virtuemart_product_ids[0], $user->id);
                }

                if ($errorMsg)
                    $this->json->msg .= '<div style="margin-top: 20px;color: #92278F;margin-bottom: 10px;">' . $errorMsg . '</div>';
                $this->json->msg .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;"><a class="showcart floatright"
                    style="width: 60%;margin-left: 20%;margin-right: 20%;border: 1px solid;background: #F4F4F6;"
                    href="' . JRoute::_("index.php?option=com_virtuemart&view=cart&step=1") . '">' . JText::_('COM_VIRTUEMART_CART_SHOW_MODAL') . ' >></a></div>';

                $this->json->msg .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 30px;"><a class="continue" href="javascript:void(0);"
                    style="width: 60%;margin-left: 20%;margin-right: 20%;border: 1px solid;background: #F4F4F6;"
                    onclick="parent.jQuery.facebox.close()" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . ' >></a></div>';


                $this->json->stat = '1';
            } else {
                $this->json->msg = $abc.'<a class="continue" href="javascript:void(0);" onclick="parent.jQuery.facebox.close()" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
                $this->json->msg .= '<a class="showcart floatright" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart&step=1") . '">' . JText::_('COM_VIRTUEMART_CART_SHOW_MODAL') . '</a>';
                $this->json->msg .= "<br/>" . '<div style="color:red;clear:both;">' . $errorMsg . '</div>';
                $this->json->stat = '2';
            }
            if ($type_submit == 'freegift') {
                if($this->json->stat == '2'){
                    $this->json->stat = '3';
                    echo json_encode($this->json);
                    jExit();
                }
                $freegiftRemain = $cart->addFreeGift($virtuemart_product_ids);
//                $this->json->stat = '3';
//                $this->json->msg = $freegiftRemain;
//                echo json_encode($this->json);
//                jExit();
                if ($freegiftRemain < 0) {
                    $this->json->stat = '3';
                    $this->json->msg = 'Can not add free gift to cart';
                    echo json_encode($this->json);
                    jExit();
                }
            } else if ($type_submit == 'wishlist_all') {
                $myuser = &JFactory::getUser();
                $wishlistModel = VmModel::getModel('wishlist');

                if ($myuser->guest) {
                    $virtuemart_product_ids = $_SESSION['wishlist'];
                } else {
                    $virtuemart_product_ids = $wishlistModel->getProductIdByUser((int) $myuser->id);
                }
            } else if ($type_submit == 'alert_all') {
                $AlertModel = VmModel::getModel('product_alert');
                $virtuemart_product_ids = $AlertModel->getAllAlertId();
            }
        } else {
//            $this->json->msg = '<a href="' . JRoute::_('index.php?option=com_virtuemart') . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
            $this->json->msg = '<a href="' . JRoute::_('index.php') . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
            $this->json->msg .= '<a class="showcart floatright" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart") . '">' . JText::_('COM_VIRTUEMART_CART_SHOW_MODAL') . '</a>';
            $this->json->msg .= '<p>' . JText::_('COM_VIRTUEMART_MINICART_ERROR') . '</p>';
            $this->json->stat = '0';
        }
        echo json_encode($this->json);
        jExit();
    }
    public function addproductjs() {

        $this->json = new stdClass();
        $cart = VirtueMartCart::getCart(false);

        if ($cart) {
            // Get a continue link */
            $virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId();
            if ($virtuemart_category_id) {
                $categoryLink = '&view=category&virtuemart_category_id=' . $virtuemart_category_id;
            } else {
                $categoryLink = '';
            }

            $type_submit = JRequest::getVar('type', FALSE);
//            $continue_link = JRoute::_('index.php?option=com_virtuemart' . $categoryLink);
            $continue_link = '';
            $virtuemart_product_ids = JRequest::getVar('virtuemart_product_id', array(), 'default', 'array');
            if ($type_submit == 'wishlist_all') {
                $myuser = &JFactory::getUser();
                $wishlistModel = VmModel::getModel('wishlist');

                if ($myuser->guest) {
                    $virtuemart_product_ids = $_SESSION['wishlist'];
                } else {
                    $virtuemart_product_ids = $wishlistModel->getProductIdByUser((int) $myuser->id);
                }
            } else if ($type_submit == 'alert_all') {
                $AlertModel = VmModel::getModel('product_alert');
                $virtuemart_product_ids = $AlertModel->getAllAlertId();
            }
//            $a = '';
//            foreach ($virtuemart_product_ids as $value){
//                $a = $a.';'.$value;
//            }
//            $this->json->stat = '3';
//                    $this->json->msg = $a;
//                    echo json_encode($this->json);
//                    jExit();
            $errorMsg = JText::_('COM_VIRTUEMART_CART_PRODUCT_ADDED');
            if ($cart->add($virtuemart_product_ids, $errorMsg)) {
                $user = JFactory::getUser();
                if (($user->get('guest') != 1)) {
                    $historyTransactionsModel = VmModel::getModel('History_transactions');
                    $historyTransactionsModel->storeHistoryTransaction($virtuemart_product_ids[0], $user->id);
                }
                if ($errorMsg)
                    $this->json->msg .= '<div style="margin-top: 20px;color: #92278F;margin-bottom: 10px;">' . $errorMsg . '</div>';
                $this->json->msg .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 10px;"><a class="showcart floatright"
                    style="width: 60%;margin-left: 20%;margin-right: 20%;border: 1px solid;background: #F4F4F6;"
                    href="' . JRoute::_("index.php?option=com_virtuemart&view=cart&step=1") . '">' . JText::_('COM_VIRTUEMART_CART_SHOW_MODAL') . ' >></a></div>';

                $this->json->msg .= '<div style="width: 100%;float: left;margin-top: 10px;margin-bottom: 30px;"><a class="continue" href="javascript:void(0);"
                    style="width: 60%;margin-left: 20%;margin-right: 20%;border: 1px solid;background: #F4F4F6;"
                    onclick="jQuery(\'#cart_mess_box\').dialog(\'close\');" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . ' >></a></div>';


                $this->json->stat = '1';
            } else {
                $this->json->msg = '<a class="continue" href="javascript:void(0);" onclick="jQuery(\'#cart_mess_box\').dialog(\'close\');" >'
                        . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
                $this->json->msg .= '<a class="showcart floatright" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart&step=1") . '">' . JText::_('COM_VIRTUEMART_CART_SHOW_MODAL') . '</a>';
                $this->json->msg .= "<br/>" . '<div style="color:red">' . $errorMsg . '</div>';
                $this->json->stat = '2';
            }
            if ($type_submit == 'freegift') {
                $freegiftRemain = $cart->addFreeGift($virtuemart_product_ids);
//                $this->json->stat = '3';
//                $this->json->msg = $freegiftRemain;
//                echo json_encode($this->json);
//                jExit();
                if ($freegiftRemain < 0) {
                    $this->json->stat = '3';
                    $this->json->msg = 'Can not add free gift to cart';
                    echo json_encode($this->json);
                    jExit();
                }
            }
        } else {
//            $this->json->msg = '<a href="' . JRoute::_('index.php?option=com_virtuemart') . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
            $this->json->msg = '<a href="' . JRoute::_('index.php') . '" >' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
            $this->json->msg .= '<a class="showcart floatright" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart") . '">' . JText::_('COM_VIRTUEMART_CART_SHOW_MODAL') . '</a>';
            $this->json->msg .= '<p>' . JText::_('COM_VIRTUEMART_MINICART_ERROR') . '</p>';
            $this->json->stat = '0';
        }
        echo json_encode($this->json);
        jExit();
    }

    /**
     * Add the product to the cart, with JS
     *
     * @author Max Milbers
     * @access public
     */
    public function viewJS() {

        if (!class_exists('VirtueMartCart'))
            require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
        $cart = VirtueMartCart::getCart(false);
        $this->data = $cart->prepareAjaxData();
//        $cart->calcularMemberLoginPrice();
        $cart->calcularSpecialPrice();
        $lang = JFactory::getLanguage();
        $extension = 'com_virtuemart';
        $lang->load($extension); //  when AJAX it needs to be loaded manually here >> in case you are outside virtuemart !!!
        if ($this->data->totalProduct > 1)
            $this->data->totalProductTxt = JText::sprintf('COM_VIRTUEMART_CART_X_PRODUCTS', $this->data->totalProduct);
        else if ($this->data->totalProduct == 1)
            $this->data->totalProductTxt = JText::_('COM_VIRTUEMART_CART_ONE_PRODUCT');
        else
            $this->data->totalProductTxt = JText::_('COM_VIRTUEMART_EMPTY_CART');
        if ($this->data->dataValidated == true) {
            $taskRoute = '&task=confirm';
            $linkName = JText::_('COM_VIRTUEMART_CART_CONFIRM');
        } else {
            $taskRoute = '';
            $linkName = JText::_('COM_VIRTUEMART_CART_SHOW');
        }
        $this->data->cart_show = '<a class="floatright" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart" . $taskRoute, $this->useXHTML, $this->useSSL) . '">' . $linkName . '</a>';
        $this->data->billTotal = $lang->_('COM_VIRTUEMART_CART_TOTAL') . ' : <strong>' . $cart->pricesUnformatted['billTotal'] . '</strong>';
        echo json_encode($this->data);
        Jexit();
    }

    /**
     * For selecting couponcode to use, opens a new layout
     *
     * @author Max Milbers
     */
    public function edit_coupon() {

        $view = $this->getView('cart', 'html');
        $view->setLayout('edit_coupon');

        // Display it all
        $view->display();
    }

    /**
     * Store the coupon code in the cart
     * @author Max Milbers
     */
    public function setcoupon() {

        /* Get the coupon_code of the cart */
        $coupon_code = JRequest::getVar('coupon_code', ''); //TODO VAR OR INT OR WORD?
        if ($coupon_code) {

            $cart = VirtueMartCart::getCart();
            if ($cart) {
                $app = JFactory::getApplication();
                $msg = $cart->setCouponCode($coupon_code);

                //$cart->setDataValidation(); //Not needed already done in the getCart function
                if ($cart->getInCheckOut() && empty($msg)) {
                    $app = JFactory::getApplication();
                    $app->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=checkout'), $msg);
                } else {
                    $app->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart'), $msg);
                }
            }
        }
        parent::display();
    }

    /**
     * For selecting shipment, opens a new layout
     *
     * @author Max Milbers
     */
    public function edit_shipment() {


        $view = $this->getView('cart', 'html');
        $view->setLayout('select_shipment');

        // Display it all
        $view->display();
    }

    /**
     * Sets a selected shipment to the cart
     *
     * @author Max Milbers
     */
    public function setshipment() {

        /* Get the shipment ID from the cart */
        $mainframe = JFactory::getApplication();
        $msg = '';
        $virtuemart_shipmentmethod_id = JRequest::getInt('virtuemart_shipmentmethod_id', '0');
        if($virtuemart_shipmentmethod_id == 0){
            $msg = JText::_('COM_VIRTUEMART_SELECT_SHIPMENT');
            $mainframe->enqueueMessage($msg, 'error');
            $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment'));
        }
        $cart = VirtueMartCart::getCart();
        if ($cart) {
            //Now set the shipment ID into the cart
            if (!class_exists('vmPSPlugin'))
                require(JPATH_VM_PLUGINS . DS . 'vmpsplugin.php');
            JPluginHelper::importPlugin('vmshipment');
            $shipment_hour = JRequest::getVar('shipment_hour', '');
            $shipment_time = JRequest::getVar('shipment_time', '');
            $shipment_place = JRequest::getVar('shipment_place', '');
            $cart->setShipment($virtuemart_shipmentmethod_id, $shipment_hour, $shipment_time, $shipment_place);
//            echo $shipment_hour.'a'.$shipment_time.'c'.$virtuemart_shipmentmethod_id .'d'.$shipment_place ;die();
            if($virtuemart_shipmentmethod_id == 13 && empty($shipment_place)){
                $msg = JText::_('COM_VIRTUEMART_SELECT_SHIPMENT_DETAIL');
                $mainframe->enqueueMessage($msg, 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment'));
            }
            if($virtuemart_shipmentmethod_id == 14 && empty($shipment_hour)){
                $msg = JText::_('COM_VIRTUEMART_SELECT_SHIPMENT_DETAIL');
                $mainframe->enqueueMessage($msg, 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment'));
            }
//            echo $shipmentHourRequire.'c'.$shipment_hour.'b'.$shipmentTimeRequire.'a'.$shipment_time;die();
            if($virtuemart_shipmentmethod_id >= 15 && $virtuemart_shipmentmethod_id <= 16
                    && (empty($shipment_time) || empty($shipment_hour))){
                $msg = JText::_('COM_VIRTUEMART_SELECT_SHIPMENT_DETAIL');
                $mainframe->enqueueMessage($msg, 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment'));
            }

            if($virtuemart_shipmentmethod_id == 122 && empty($shipment_place)){
                $msg = JText::_('Please fill in your hotel name.');
                $mainframe->enqueueMessage($msg, 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment'));
            }
            if($virtuemart_shipmentmethod_id == 122
                    && (empty($shipment_time) || empty($shipment_hour))){
                $msg = JText::_('COM_VIRTUEMART_SELECT_SHIPMENT_DETAIL');
                $mainframe->enqueueMessage($msg, 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment'));
            }
            //Add a hook here for other payment methods, checking the data of the choosed plugin
            $_dispatcher = JDispatcher::getInstance();
            $_retValues = $_dispatcher->trigger('plgVmOnSelectCheckShipment', array(&$cart));

            $dataValid = true;
            foreach ($_retValues as $_retVal) {
                if ($_retVal === true) {
                    // Plugin completed succesfull; nothing else to do
                    $cart->setCartIntoSession();
                    break;
                } else if ($_retVal === false) {

                    $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $_retVal);
                    break;
                }
            }

            if ($cart->getInCheckOut()) {
                $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=checkout'));
            }
        }
        // 	self::Cart();
        parent::display();
    }

    /**
     * To select a payment method
     *
     * @author Max Milbers
     */
    public function editpayment() {

        $view = $this->getView('cart', 'html');
        $view->setLayout('select_payment');

        // Display it all
        $view->display();
    }

    /**
     * To set a payment method
     *
     * @author Max Milbers
     * @author Oscar van Eijk
     * @author Valerie Isaksen
     */
    function setpayment() {

        /* Get the payment id of the cart */
        //Now set the payment rate into the cart
        $cart = VirtueMartCart::getCart();
        if ($cart) {
            if (!class_exists('vmPSPlugin'))
                require(JPATH_VM_PLUGINS . DS . 'vmpsplugin.php');
            JPluginHelper::importPlugin('vmpayment');
            //Some Paymentmethods needs extra Information like
            $virtuemart_paymentmethod_id = JRequest::getInt('virtuemart_paymentmethod_id', '0');
            if($virtuemart_paymentmethod_id == 0){
                $mainframe = JFactory::getApplication();
                $msg = JText::_('PLEASE SELECT PAYMENT');
                $mainframe->enqueueMessage($msg, 'error');
                $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment'));
            }
            $cart->setPaymentMethod($virtuemart_paymentmethod_id);

            //Add a hook here for other payment methods, checking the data of the choosed plugin
            $msg = '';
            $_dispatcher = JDispatcher::getInstance();
            $_retValues = $_dispatcher->trigger('plgVmOnSelectCheckPayment', array($cart, &$msg));
            $dataValid = true;
            foreach ($_retValues as $_retVal) {
                if ($_retVal === true) {
                    // Plugin completed succesfull; nothing else to do
                    $cart->setCartIntoSession();
                    break;
                } else if ($_retVal === false) {
                    $app = JFactory::getApplication();
                    $app->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $msg);
                    break;
                }
            }
            if ($cart->getInCheckOut()) {
                $app = JFactory::getApplication();
                $app->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart&task=checkout'), $msg);
            }
        }
        parent::display();
    }

    /**
     * Delete a product from the cart
     *
     * @author RolandD
     * @access public
     */
    public function delete() {
        $mainframe = JFactory::getApplication();
        /* Load the cart helper */
        $cart = VirtueMartCart::getCart();
        if ($cart->removeProductCart())
            $mainframe->enqueueMessage(JText::_('COM_VIRTUEMART_PRODUCT_REMOVED_SUCCESSFULLY'));
        else
            $mainframe->enqueueMessage(JText::_('COM_VIRTUEMART_PRODUCT_NOT_REMOVED_SUCCESSFULLY'), 'error');

        $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart'));
    }

    /**
     * Delete a product from the cart
     *
     * @author RolandD
     * @access public
     */
    public function update() {
        $mainframe = JFactory::getApplication();
        /* Load the cart helper */
        $cartModel = VirtueMartCart::getCart();
        if ($cartModel->updateProductCart())
            $mainframe->enqueueMessage(JText::_('COM_VIRTUEMART_PRODUCT_UPDATED_SUCCESSFULLY'));
        else
            $mainframe->enqueueMessage(JText::_('COM_VIRTUEMART_PRODUCT_NOT_UPDATED_SUCCESSFULLY'), 'error');

        $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart'));
    }

    /**
     * Delete a product from the cart
     *
     * @author RolandD
     * @access public
     */
    public function updateJS() {
        /* Load the cart helper */
        $cartModel = VirtueMartCart::getCart();

        $product_id = JRequest::getString('product_id');
        $quantity = JRequest::getInt('quantity');

        $cartModel->updateProductCartJS($product_id, $quantity);
        Jexit();
    }

    /**
     * Checks for the data that is needed to process the order
     *
     * @author Max Milbers
     *
     *
     */
    public function checkout() {
        // if no product return to home page
        $cart = VirtueMartCart::getCart();
        if (count($cart->products) == 0) {
            $this->setRedirect(JRoute::_('index.php?option=com_content&view=featured&Itemid=101', false));
            return;
        }
        // If the user is a guest, redirect to the login page.
        $session = & JFactory::getSession();
        $session ->set('checkout', 0);
        $user = JFactory::getUser();

       //CuongDT When checking out, if guest, redirect to regrequire page
        if (($user->get('guest') == 1)) {

            if ($session->get('check') != 2) {
                // Redirect to login page.
                $this->setRedirect(JRoute::_('index.php?option=com_users&view=regrequire', false));
                return;
            }
        }

        //Tests step for step for the necessary data, redirects to it, when something is lacking

//        $add_reward_point = JRequest::getInt('rp_added_on_confirm', 0);
//        $cart->set_reward_point_added($add_reward_point);
        if ($cart && !VmConfig::get('use_as_catalog', 0)) {

            $cart->checkout();
        }
    }

    /**
     * Executes the confirmDone task,
     * cart object checks itself, if the data is valid
     *
     * @author Max Milbers
     *
     *
     */
    public function confirm() {
        //Use false to prevent valid boolean to get deleted
        $cart = VirtueMartCart::getCart();

//        $add_reward_point = JRequest::getInt('rp_added_on_confirm', 0);
//        $cart->set_reward_point_added($add_reward_point);
//        $cart->rewardPoints = $add_reward_point;
//        $cart->rewardPointsDiscount = $convert_to_price;
        if ($cart) {
//            $session = & JFactory::getSession();
//            $session->set('check', 0);
            $cart->confirmDone();
            $view = $this->getView('cart', 'html');
            $view->setLayout('order_done');
            // Display it all
            $view->display();
        } else {
            $mainframe = JFactory::getApplication();
            $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart'), JText::_('COM_VIRTUEMART_CART_DATA_NOT_VALID'));
        }
    }

    function cancel() {

        $cart = VirtueMartCart::getCart();
        if ($cart) {
            $cart->setOutOfCheckout();
        }
        $mainframe = JFactory::getApplication();
        $mainframe->redirect(JRoute::_('index.php?option=com_virtuemart&view=cart'), 'Cancelled');
    }

    public function addrewardpoint() {
        $this->json = new stdClass();
        $cart = VirtueMartCart::getCart();

        $add_reward_point = JRequest::getVar('add_reward_point', 0);

        $cart->prepareCartViewData();
//        $cart->calcularMemberLoginPrice();
        $cart->calcularSpecialPrice();
        $cart->getFreegift();

        $result = $cart->addRewardPoint($add_reward_point);

        if ($result['error'] == 1) {
            $this->json->msg = $result['msg'];
            $this->json->error = $result['error'];
        } else {
            $this->json->your_balance_rp = $result['your_balance_rp'];
            $this->json->bill_total = $result['bill_total'];
            $this->json->convert_to_price = $result['convert_to_price'];
            $this->json->error = 0;
        }

        echo json_encode($this->json);
        jExit();
    }

}

//pure php no Tag
