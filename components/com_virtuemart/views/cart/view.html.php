<?php

/**
 *
 * View for the shopping cart
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers
 * @author Oscar van Eijk
 * @author RolandD
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 6292 2012-07-20 12:27:44Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if(!class_exists('VmView'))require(JPATH_VM_SITE.DS.'helpers'.DS.'vmview.php');

/**
 * View for the shopping cart
 * @package VirtueMart
 * @author Max Milbers
 * @author Patrick Kohl
 */
class VirtueMartViewCart extends VmView {

	public function display($tpl = null) {
            
		$mainframe = JFactory::getApplication();
		$pathway = $mainframe->getPathway();
		$document = JFactory::getDocument();
                $step = 0;
                $step = JRequest::getVar('step', 0);
                $session =& JFactory::getSession();
                if ($step == 1) {                    
                    $session->set('checkout', 2);
                    $session->set('check', 0);
                }
		$layoutName = $this->getLayout();
		if (!$layoutName)
		$layoutName = JRequest::getWord('layout', 'default');
		$this->assignRef('layoutName', $layoutName);
		$format = JRequest::getWord('format');

		if (!class_exists('VirtueMartCart'))
		require(JPATH_VM_SITE . DS . 'helpers' . DS . 'cart.php');
		$cart = VirtueMartCart::getCart();
		$this->assignRef('cart', $cart);
		//Why is this here, when we have view.raw.php
		if ($format == 'raw') {
			$cart->prepareCartViewData();
			JRequest::setVar('layout', 'mini_cart');
			$this->setLayout('mini_cart');
			$this->prepareContinueLink();
		}
		if ($layoutName == 'select_shipment') {
			$cart->prepareCartViewData();
			if (!class_exists('vmPSPlugin')) require(JPATH_VM_PLUGINS . DS . 'vmpsplugin.php');
			JPluginHelper::importPlugin('vmshipment');
			$this->lSelectShipment();
			$pathway->addItem(JText::_('COM_VIRTUEMART_CART_OVERVIEW'), JRoute::_('index.php?option=com_virtuemart&view=cart'));
			$pathway->addItem(JText::_('COM_VIRTUEMART_CART_SELECTSHIPMENT'));
			$document->setTitle(JText::_('COM_VIRTUEMART_CART_SELECTSHIPMENT'));
		} else if ($layoutName == 'select_payment') {
			/* Load the cart helper */
			//			$cartModel = VmModel::getModel('cart');
			$cart->prepareCartViewData();                        
			$this->lSelectPayment();
			$pathway->addItem(JText::_('COM_VIRTUEMART_CART_OVERVIEW'), JRoute::_('index.php?option=com_virtuemart&view=cart'));
			$pathway->addItem(JText::_('COM_VIRTUEMART_CART_SELECTPAYMENT'));
			$document->setTitle(JText::_('COM_VIRTUEMART_CART_SELECTPAYMENT'));
		} else if ($layoutName == 'order_done') {

			$this->lOrderDone();

			$pathway->addItem(JText::_('COM_VIRTUEMART_CART_THANKYOU'));
			$document->setTitle(JText::_('COM_VIRTUEMART_CART_THANKYOU'));
		} else if ($layoutName == 'default') {
			$cart->prepareCartViewData();
			$cart->prepareAddressRadioSelection();
			$this->prepareContinueLink();
			$this->lSelectCoupon();
			$totalInPaymentCurrency =$this->getTotalInPaymentCurrency();

			$checkoutAdvertise =$this->getCheckoutAdvertise();

			if ($cart && !VmConfig::get('use_as_catalog', 0) && ($session->get('checkout') != 2)) {
				$cart->checkout(false);
			}
                        
			if (($cart->getDataValidated()) && ($session->get('checkout') != 2)) {
				$pathway->addItem(JText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU'));
				$document->setTitle(JText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU'));
				$text = JText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU');
				$checkout_task = 'confirm';
			} else {
				$pathway->addItem(JText::_('COM_VIRTUEMART_CART_CHECKOUT'));
				$document->setTitle(JText::_('COM_VIRTUEMART_CART_CHECKOUT'));
				$text = JText::_('COM_VIRTUEMART_CHECKOUT_TITLE');
				$checkout_task = 'checkout';
			}
                        
			$this->assignRef('checkout_task', $checkout_task);
			$this->checkPaymentMethodsConfigured();
			$this->checkShipmentMethodsConfigured();
			if ($cart->virtuemart_shipmentmethod_id) {
				$shippingText =  JText::_('COM_VIRTUEMART_CART_CHANGE_SHIPPING');
			} else {
				$shippingText = JText::_('COM_VIRTUEMART_CART_EDIT_SHIPPING');
			}
			$this->assignRef('select_shipment_text', $shippingText);

			if ($cart->virtuemart_paymentmethod_id) {
				$paymentText = JText::_('COM_VIRTUEMART_CART_CHANGE_PAYMENT');
			} else {
				$paymentText = JText::_('COM_VIRTUEMART_CART_EDIT_PAYMENT');
			}
			$this->assignRef('select_payment_text', $paymentText);

			if (!VmConfig::get('use_as_catalog')) {
				$checkout_link_html = '<a style="background: #c01878" class="vm-button-correct checkout_link" href="javascript:document.checkoutForm.submit();" ><span>' . $text . '</span></a>';
			} else {
				$checkout_link_html = '';
			}
			$this->assignRef('checkout_link_html', $checkout_link_html);
		}                
//		$cart->calcularMemberLoginPrice();
		$cart->calcularSpecialPrice();
		$freegiftArray = $cart->getFreegift();
		$reward_point = $cart->rewardPointWithOrder();
		$freegift_spend = $freegiftArray['freegiftCurrent'];
		$free_gift_price_percent = ($freegiftArray['freegiftCurrent'] / $freegiftArray['freegiftAmount']) * 320;
		$this->assignRef('reward_point', $reward_point);
		$this->assignRef('freegiftArray', $freegiftArray);
		$this->assignRef('free_gift_price_percent', $free_gift_price_percent);
		$this->assignRef('freegift_spend', $freegift_spend);
		$useSSL = VmConfig::get('useSSL', 0);
		$useXHTML = true;
		$this->assignRef('useSSL', $useSSL);
		$this->assignRef('useXHTML', $useXHTML);
		$this->assignRef('totalInPaymentCurrency', $totalInPaymentCurrency);
		$this->assignRef('checkoutAdvertise', $checkoutAdvertise);
		$cart->setCartIntoSession();
                $currencyDisplay = CurrencyDisplay::getInstance($this->cart->pricesCurrency);
		$this->assignRef('currencyDisplay',$currencyDisplay);
		shopFunctionsF::setVmTemplate($this, 0, 0, $layoutName);
		parent::display($tpl);
	}



	private function prepareContinueLink() {
		// Get a continue link */
		$virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId();
		$categoryLink = '';
		if ($virtuemart_category_id) {
			$categoryLink = '&virtuemart_category_id=' . $virtuemart_category_id;
		}
//		$continue_link = JRoute::_('index.php?option=com_virtuemart&view=category' . $categoryLink);
                $continue_link = 'index.php';
		$continue_link_html = '<a style="background: #c01878" class="vm-button-correct continue_link" href="' . $continue_link . '" ><span>' . JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</span></a>';
		$this->assignRef('continue_link_html', $continue_link_html);
		$this->assignRef('continue_link', $continue_link);
	}

	private function lSelectCoupon() {

		$this->couponCode = (isset($this->cart->couponCode) ? $this->cart->couponCode : '');
		$coupon_text = $this->cart->couponCode ? JText::_('COM_VIRTUEMART_COUPON_CODE_CHANGE') : JText::_('COM_VIRTUEMART_COUPON_CODE_ENTER');
		$this->assignRef('coupon_text', $coupon_text);
	}

	/*
	 * lSelectShipment
	* find al shipment rates available for this cart
	*
	* @author Valerie Isaksen
	*/

	private function lSelectShipment() {
		$found_shipment_method=false;
		$shipment_not_found_text = JText::_('COM_VIRTUEMART_CART_NO_SHIPPING_METHOD_PUBLIC');
		$this->assignRef('shipment_not_found_text', $shipment_not_found_text);
		$this->assignRef('found_shipment_method', $found_shipment_method);

		$shipments_shipment_rates=array();
		if (!$this->checkShipmentMethodsConfigured()) {
			$this->assignRef('shipments_shipment_rates',$shipments_shipment_rates);
			return;
		}
		$selectedShipment = (empty($this->cart->virtuemart_shipmentmethod_id) ? 0 : $this->cart->virtuemart_shipmentmethod_id);

		$shipments_shipment_rates = array();
                $shipments_list = array();
		if (!class_exists('vmPSPlugin')) require(JPATH_VM_PLUGINS . DS . 'vmpsplugin.php');
		JPluginHelper::importPlugin('vmshipment');
		$dispatcher = JDispatcher::getInstance();
		$returnValues = $dispatcher->trigger('plgVmDisplayListFEShipment', array( $this->cart, $selectedShipment, &$shipments_shipment_rates, &$shipments_list));
		// if no shipment rate defined
		$found_shipment_method =count($shipments_shipment_rates);
		$shipment_not_found_text = JText::_('COM_VIRTUEMART_CART_NO_SHIPPING_METHOD_PUBLIC');
		$orderWeight = $this->getOrderWeight($this->cart);
		$address = (($this->cart->ST == 0) ? $this->cart->BT : $this->cart->ST);

		if ($orderWeight > 6000 && $address['virtuemart_country_id'] != 188) {//weight > 6kg
		  $shipment_not_found_text = JText::_('COM_VIRTUEMART_CART_NO_SHIPPING_AND_CONTACT');
		  $found_shipment_method = false;
		}

		$this->assignRef('shipment_not_found_text', $shipment_not_found_text);
		$this->assignRef('shipments_shipment_rates', $shipments_shipment_rates);
		$this->assignRef('found_shipment_method', $found_shipment_method);                $this->assignRef('shipments_list', $shipments_list);
		$this->assignRef('orderWeight', $orderWeight);
		return;
	}

	private function getOrderWeight($cart)
	{
	  $weight = 0;
	  if(count($cart->products) > 0){
	    foreach ($cart->products as $product) {
	      $weight += (ShopFunctions::convertWeigthUnit ($product->package_weight, $product->package_weight_uom, 'G') * $product->quantity);
	    }
	  }
	  return $weight;
	}
	/*
	 * lSelectPayment
	* find al payment available for this cart
	*
	* @author Valerie Isaksen
	*/

	private function lSelectPayment() {
		$payment_not_found_text='';
		$payments_payment_rates=array();
		if (!$this->checkPaymentMethodsConfigured()) {
			$this->assignRef('paymentplugins_payments', $payments_payment_rates);
			$this->assignRef('found_payment_method', $found_payment_method);
		}

		$selectedPayment = empty($this->cart->virtuemart_paymentmethod_id) ? 0 : $this->cart->virtuemart_paymentmethod_id;

		$paymentplugins_payments = array();
		if(!class_exists('vmPSPlugin')) require(JPATH_VM_PLUGINS.DS.'vmpsplugin.php');
		JPluginHelper::importPlugin('vmpayment');
		$dispatcher = JDispatcher::getInstance();
		$returnValues = $dispatcher->trigger('plgVmDisplayListFEPayment', array($this->cart, $selectedPayment, &$paymentplugins_payments));
		// if no payment defined
		$found_payment_method =count($paymentplugins_payments);

		if (!$found_payment_method) {
			$link=''; // todo
			$payment_not_found_text = JText::sprintf('COM_VIRTUEMART_CART_NO_PAYMENT_METHOD_PUBLIC', '<a href="'.$link.'">'.$link.'</a>');
		}

		$orderWeight = $this->getOrderWeight($this->cart);
		$address = (($this->cart->ST == 0) ? $this->cart->BT : $this->cart->ST);

		if ($orderWeight > 6000 && $address['virtuemart_country_id'] != 188) {//weight > 6kg
		  $payment_not_found_text = JText::_('COM_VIRTUEMART_CART_NO_SHIPPING_AND_CONTACT');
		  $found_payment_method = false;
		}

		$this->assignRef('payment_not_found_text', $payment_not_found_text);
		$this->assignRef('paymentplugins_payments', $paymentplugins_payments);
		$this->assignRef('found_payment_method', $found_payment_method);
	}

	private function getTotalInPaymentCurrency() {

		if (empty($this->cart->virtuemart_paymentmethod_id)) {
			return null;
		}

		if (!$this->cart->paymentCurrency or ($this->cart->paymentCurrency==$this->cart->pricesCurrency)) {
			return null;
		}

		$paymentCurrency = CurrencyDisplay::getInstance($this->cart->paymentCurrency);

		$totalInPaymentCurrency = $paymentCurrency->priceDisplay( $this->cart->pricesUnformatted['billTotal'],$this->cart->paymentCurrency) ;

		$currencyDisplay = CurrencyDisplay::getInstance($this->cart->pricesCurrency);
// 		$this->assignRef('currencyDisplay',$currencyDisplay);

		return $totalInPaymentCurrency;
	}
	/*
	 * Trigger to place Coupon, payment, shipment advertisement on the cart
	 */
	private function getCheckoutAdvertise() {
		$checkoutAdvertise=array();
		JPluginHelper::importPlugin('vmcoupon');
		JPluginHelper::importPlugin('vmpayment');
		JPluginHelper::importPlugin('vmshipment');
		$dispatcher = JDispatcher::getInstance();
		$returnValues = $dispatcher->trigger('plgVmOnCheckoutAdvertise', array( $this->cart, &$checkoutAdvertise));
		return $checkoutAdvertise;
}

	private function lOrderDone() {
		$html = JRequest::getVar('html', JText::_('COM_VIRTUEMART_ORDER_PROCESSED'), 'default', 'STRING', JREQUEST_ALLOWRAW);
		$this->assignRef('html', $html);

		//Show Thank you page or error due payment plugins like paypal express
	}

	private function checkPaymentMethodsConfigured() {

		//For the selection of the payment method we need the total amount to pay.
		$paymentModel = VmModel::getModel('Paymentmethod');
		$payments = $paymentModel->getPayments(true, false);
		if (empty($payments)) {

			$text = '';
			if (!class_exists('Permissions'))
			require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'permissions.php');
			if (Permissions::getInstance()->check("admin,storeadmin")) {
				$uri = JFactory::getURI();
				$link = $uri->root() . 'administrator/index.php?option=com_virtuemart&view=paymentmethod';
				$text = JText::sprintf('COM_VIRTUEMART_NO_PAYMENT_METHODS_CONFIGURED_LINK', '<a href="' . $link . '">' . $link . '</a>');
			}

			vmInfo('COM_VIRTUEMART_NO_PAYMENT_METHODS_CONFIGURED', $text);

			$tmp = 0;
			$this->assignRef('found_payment_method', $tmp);

			return false;
		}else{
                    if($this->cart->BT['virtuemart_country_id'] != 188){
                        foreach ($payments as $key=>$method) {  
                            if($method->virtuemart_paymentmethod_id == 6){
                                unset($payments[$key]);
                                break;
                            }
                        }
//                        $stack = array();
//                        foreach ($payments as $key=>$method) {   
//                            $params = explode('|', $method->payment_params);
//                            foreach($params as $item){
//                                    $i = explode('=',$item);
//                                    if(strcmp($i[0],'countries') == 0){
//                                        $country = json_decode($i[1]);                                        
//                                        if (count($country) > 0 && in_array(188,$country)) {
//                                            array_push($stack, $key);
//                                        }
//                                    }
//                            }
//                        }
//                        foreach ($stack as $value) {
//                           unset($payments[$value]);
//                        }
//                        var_dump($payments);
                    }
                }
                $this->assignRef('payments', $payments);
		return true;
	}

	private function checkShipmentMethodsConfigured() {

		//For the selection of the shipment method we need the total amount to pay.
		$shipmentModel = VmModel::getModel('Shipmentmethod');
		$shipments = $shipmentModel->getShipments();
		if (empty($shipments)) {

			$text = '';
			if (!class_exists('Permissions'))
			require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'permissions.php');
			if (Permissions::getInstance()->check("admin,storeadmin")) {
				$uri = JFactory::getURI();
				$link = $uri->root() . 'administrator/index.php?option=com_virtuemart&view=shipmentmethod';
				$text = JText::sprintf('COM_VIRTUEMART_NO_SHIPPING_METHODS_CONFIGURED_LINK', '<a href="' . $link . '">' . $link . '</a>');
			}

			vmInfo('COM_VIRTUEMART_NO_SHIPPING_METHODS_CONFIGURED', $text);

			$tmp = 0;
			$this->assignRef('found_shipment_method', $tmp);

			return false;
		}
		return true;
	}
}

//no closing tag
