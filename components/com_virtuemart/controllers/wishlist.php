<?php

defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

class VirtueMartControllerWishlist extends JController {

    /**
     * Method Description
     *
     * @access public
     * @author RolandD
     */
    public function __construct() {
        parent::__construct();

        $this->registerTask('addwishlist', 'addwishlist');
        $this->registerTask('addAllwishlist', 'addAllwishlist');
    }

    public function addAllwishlist() {
            $myuser =& JFactory::getUser();
            $db = JFactory::getDbo();
            $query = "
                        SELECT virtuemart_product_id FROM #__virtuemart_products_alert
                        WHERE user_id =" . $myuser->id . "
                        ";
            $db->setQuery($query);
            $lisFromAlertProduct = $db->loadObjectList();
            foreach ($lisFromAlertProduct as $k){
                if($this->checkId($k->virtuemart_product_id)){
                    $q = "INSERT INTO `#__virtuemart_wishlist` (`product_id`, `user_id`, `quantity`,`create_date`) VALUES (" . $k->virtuemart_product_id . ',' . $myuser->id . ',1, NOW())';
                    $db->setQuery($q);
                    $db->query();
                }

            }
            echo '{"url":"'.JRoute::_('index.php?option=com_virtuemart&view=wishlist&task=managerwishlist').'"}';
            die();
    }
    public function checkId($product_id) {
        $db = JFactory::getDbo();
        $myuser =& JFactory::getUser();
        $wq = "
            SELECT product_id FROM #__virtuemart_wishlist
                        WHERE user_id =" . $myuser->id . "  AND product_id = ".$product_id."
            ";
        $db->setQuery($wq);
        $rs = $db->loadObject();
        if(empty($rs)) return true;
        else return false;
    }
    function addwishlist() {
        $myuser = & JFactory::getUser();
        $product_id = JRequest::getInt('product_id', NULL);

        $wishlistHtml = '';
        $wishlist = array();

        if ($myuser->guest) {
            $wishlist = $_SESSION['wishlist'];
            $wishlist[$product_id] = $product_id;
            $_SESSION['wishlist'] = $wishlist;
        } else {
            $wishlistModel = VmModel::getModel('wishlist');
            $data = array();

            $wishlist = $wishlistModel->getProductIdByUser((int) $myuser->id);
            $wishlistInSession = $_SESSION['wishlist'];
            $wishlist_quantity = $_SESSION['wishlist_quantity'];

            if ($wishlistInSession) {
                foreach ($wishlistInSession as $value) {
                    if (!in_array($value, $wishlist)) {
                        $wishlist[$value] = $value;
                        $data['virtuemart_user_id'] = (int) $myuser->id;
                        $data['virtuemart_product_id'] = $value;
                        $data['quantity'] = isset($wishlist_quantity[$value]) ? $wishlist_quantity[$value] : 1;

                        if (!$wishlistModel->checkExistingWishlist($data)) {
                            $wishlistModel->insertWishlist($data);
                        }
                    }
                }

                $_SESSION['wishlist'] = array();
            }

            if (!in_array($product_id, $wishlist)) {
                $wishlist[$product_id] = $product_id;
                $data['virtuemart_user_id'] = (int) $myuser->id;
                $data['virtuemart_product_id'] = $product_id;
                $data['quantity'] = 1;

                if (!$wishlistModel->checkExistingWishlist($data)) {
                    $wishlistModel->insertWishlist($data);
                }
            }
        }

        foreach ($wishlist as $key => $value) {
            $wishlistHtml .= $this->renderWishlist($value);
        }

        echo $wishlistHtml;
        jExit();
    }

    public function deletewishlist() {
        $myuser = & JFactory::getUser();
        $product_id = JRequest::getInt('product_id', NULL);

        if ($myuser->guest) {
            $wishlist = $_SESSION['wishlist'];
            unset($wishlist[$product_id]);

            $_SESSION['wishlist'] = $wishlist;
        } else {
            $user_id = (int) $myuser->id;

            $wishlistModel = VmModel::getModel('wishlist');
            $wishlistModel->delete($product_id, $user_id);
        }

        jExit();
    }

    public function deleteall() {
        $myuser = & JFactory::getUser();

        if ($myuser->guest) {
            $_SESSION['wishlist'] = array();
        } else {
            $user_id = (int) $myuser->id;
            $wishlistModel = VmModel::getModel('wishlist');
            $wishlistModel->deleteAll($user_id);
        }

        jExit();
    }

    public function showwishlist() {
        $myuser = & JFactory::getUser();

        $wishlistHtml = '';
        $wishlist = array();

        if ($myuser->guest) {
            $wishlist = $_SESSION['wishlist'];
        } else {
            $wishlistModel = VmModel::getModel('wishlist');
            $wishlist = $wishlistModel->getProductIdByUser((int) $myuser->id);
        }

        if ($wishlist) {
            foreach ($wishlist as $key => $value) {
                $wishlistHtml .= $this->renderWishlist($value);
            }
        } else {
            $wishlistHtml .= 'No data';
        }

        echo $wishlistHtml;
        jExit();
    }

    public function managerwishlist() {
        $myuser = &JFactory::getUser();
        $productModel = VmModel::getModel('product');
        $wishlistModel = VmModel::getModel('wishlist');

        $wishlist_list = array();

        if ($myuser->guest) {
            $wishlist = $_SESSION['wishlist'];
            $wishlist_quantity = $_SESSION['wishlist_quantity'];

            if ($wishlist) {
                foreach ($wishlist as $key => $product_id) {
                    $product_data = $productModel->getProduct((int) $product_id);
                    $productModel->addImages($product_data, 1);

                    $product_data->create_date = date();
                    $product_data->quantity = isset($wishlist_quantity[$product_data->virtuemart_product_id]) ? $wishlist_quantity[$product_data->virtuemart_product_id] : 1;

                    $wishlist_list[] = $product_data;
                }
            }
        } else {
            $wishlist = $wishlistModel->getWishlistByUser((int) $myuser->id);

            if ($wishlist) {
                foreach ($wishlist as $key => $value) {
                    $product_data = $productModel->getProduct((int) $value->product_id);
                    $productModel->addImages($product_data, 1);

                    $product_data->create_date = $value->create_date;
                    $product_data->quantity = $value->quantity;
                    $wishlist_list[] = $product_data;
                }
            }
        }


        $view = $this->getView('wishlist', 'html');
        $view->setLayout('default');

        if ($wishlist_list) {
            $currency = CurrencyDisplay::getInstance();
            $view->assignRef('currency', $currency);
        }
        $listid ='';
        for ($index = 0; $index < count($wishlist_list); $index++) {
                $url = 'http://'.$_SERVER['HTTP_HOST'].JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $wishlist_list[$index]->virtuemart_product_id);
                $url = '<a href="'.$url.'">'.$wishlist_list[$index]->product_name.'</a>';
            if($index==0){

//                JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $wishlist_list[$index]->virtuemart_product_id), $wishlist_list[$index]->product_name);
//                $listid .= JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $wishlist_list[$index]->virtuemart_product_id), $wishlist_list[$index]->product_name);
                $listid .= $url;
            }else
                $listid .= '@@@'.$url;
        }
        $sendmail = JRequest::getVar('action');
        if($sendmail=="email"){
//            echo JURI::base();
            echo $listid;
            jexit();
        }

        /******Call RSForm******/
        $emailform->event = new stdClass();
        $pricematch->event->afterDisplayTitle = '';
        $emailform->event->beforeDisplayContent = '';
        $emailform->event->afterDisplayContent = '';
        $dispatcher = & JDispatcher::getInstance();
        JPluginHelper::importPlugin('content');
        jimport('joomla.html.parameter');
        $params = new JParameter('');
        $emailform->text = "{rsform 5}";

        if (JVM_VERSION === 2) {
            $results = $dispatcher->trigger('onContentPrepare', array('com_virtuemart.wishlist', &$emailform, &$params, 0));
            // More events for 3rd party content plugins
            // This do not disturb actual plugins, because we don't modify $product->text
            $res = $dispatcher->trigger('onContentAfterTitle', array('com_virtuemart.wishlist', &$emailform, &$params, 0));
            $emailform->event->afterDisplayTitle = trim(implode("\n", $res));

            $res = $dispatcher->trigger('onContentBeforeDisplay', array('com_virtuemart.wishlist', &$emailform, &$params, 0));
            $emailform->event->beforeDisplayContent = trim(implode("\n", $res));

            $res = $dispatcher->trigger('onContentAfterDisplay', array('com_virtuemart.wishlist', &$emailform, &$params, 0));
            $emailform->event->afterDisplayContent = trim(implode("\n", $res));
        } else {
            $emailform = $dispatcher->trigger('onPrepareContent', array(& $emailform, & $params, 0));
        }


        $view->assignRef('emailform', $emailform);
        $view->assignRef('wishlist_list', $wishlist_list);
        $view->display();
    }

    private function renderWishlist($product_id) {
        if (!class_exists('CurrencyDisplay')) {
            require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');
        }

        $wishlistModel = VmModel::getModel('wishlist');
        $product_info = $wishlistModel->getProductInfo($product_id);
        $currency = CurrencyDisplay::getInstance();

        $compare_list = $_SESSION['compare_list'];
        $in_compare_flag = FALSE;

        if (is_array($compare_list)) {
            if (in_array($product_info->virtuemart_product_id, $compare_list)) {
                $in_compare_flag = TRUE;
            }
        }

        $html = '';

        if ($product_info) {
            $html = '<div class="wish_list" id="wl_' . $product_info->virtuemart_product_id . '"><div class="wl_image">';
            $html .= JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product_info->virtuemart_product_id), $product_info->thumb, array('title' => $product_info->product_name));

            $html .= '</div><div class="wl_title">';
            $html .= '<span class="p_title">' . JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product_info->virtuemart_product_id), $product_info->product_name, array('title' => $product_info->product_name)) . '</span>';
            $html .= '<span class="wl_price">' . $currency->createPriceDiv('salesPrice', '', $product_info->product_price, true) . '</span>';
            //$html .= '<span class="wl_price">Color: Rose</span>';
            $html .= '</div><div class="cart_compare_remove">';
            $html .= '<span class="remove"><a href="javascript:void(0);"  onclick="delete_wishlist(' . $product_info->virtuemart_product_id . ');" title="Remove from Wishlist">Remove</a></span>';

            if (!$in_compare_flag) {
                $html .= '<span><a id="add_compare_' . $product_info->virtuemart_product_id . '" onclick="wishlist_add_compare(' . $product_info->virtuemart_product_id . ')" title="Add to Comparison" class="add_compare_icon icon_compare" href="javascript:void(0);"><img border="0" width="30px" src="templates/altalab/images/comparison.jpg" title="Add to Comparison" alt="Add to Comparison" class="add_compare_icon"></a></span>';
                $html .= '<span><a id="remove_compare_' . $product_info->virtuemart_product_id . '"  onclick="wishlist_remove_compare(' . $product_info->virtuemart_product_id . ')" class="icon_uncompare unactive" href="javascript:void(0);" title="Remove from Comparison"><img border="0" width="30px" src="templates/altalab/images/comparison_remove.jpg" title="Remove from Comparison" alt="Remove from Comparison" class="add_compare_icon"></a></span>';
            } else {
                $html .= '<span><a id="add_compare_' . $product_info->virtuemart_product_id . '" onclick="wishlist_add_compare(' . $product_info->virtuemart_product_id . ')" title="Add to Comparison" class="icon_compare unactive" href="javascript:void(0);"><img border="0" width="30px" src="templates/altalab/images/comparison.jpg" title="Add to Comparison" alt="Add to Comparison" class="add_compare_icon"></a></span>';
                $html .= '<span><a id="remove_compare_' . $product_info->virtuemart_product_id . '"  onclick="wishlist_remove_compare(' . $product_info->virtuemart_product_id . ')" class="icon_uncompare" href="javascript:void(0);" title="Remove from Comparison"><img border="0" width="30px" src="templates/altalab/images/comparison_remove.jpg" title="Remove from Comparison" alt="Remove from Comparison" class="add_compare_icon"></a></span>';
            }

            $html .= '<span class="add_cart_icon"><a id="icon_cart_' . $product_info->virtuemart_product_id . '" title="Add to Cart" href="javascript:void(0);"  onclick="add_to_cart(' . $product_info->virtuemart_product_id . ')"><img border="0" width="20px" src="images/cart-icon.gif" title="Add to Cart" alt="Add to Cart" class="add_compare_icon"></a></span>';
            $html .= '</div></div>';
        }

        return $html;
    }

    public function updatequantity() {
        $myuser = &JFactory::getUser();
        $wishlistModel = VmModel::getModel('wishlist');

        $product_id = JRequest::getInt('product_id', NULL);
        $quantity_number = JRequest::getInt('quantity_number', NULL);
        $wishlist_quantity = array();

        if ($myuser->guest) {
            $wishlist_quantity = $_SESSION['wishlist_quantity'];
            $wishlist_quantity[$product_id] = $quantity_number;
            $_SESSION['wishlist_quantity'] = $wishlist_quantity;
        } else {
            $wishlistModel->updateQuantity((int) $myuser->id, (int) $product_id, (int) $quantity_number);
        }

        jExit();
    }

    public function addAllToCompate() {
        $myuser = &JFactory::getUser();
        $wishlistModel = VmModel::getModel('wishlist');
        $topCompareModel = VmModel::getModel('top_compare');

        $compare_list = isset($_SESSION['compare_list']) ? $_SESSION['compare_list'] : array();

        if ($myuser->guest) {
            $wishlist = $_SESSION['wishlist'];

            if ($wishlist) {
                foreach ($wishlist as $value) {
                  //insert to top compare
                  if (!in_array($value, $compare_list)) {
                    foreach ($compare_list as $compare_id)  {
                      if ($topCompareModel->isExists($value, $compare_id)) {
                        $topCompareModel->updateCount($value, $compare_id);
                      } else {
                        $topCompareModel->insertRecord($value, $compare_id);
                      }
                    }
                  }

                  $compare_list[$value] = $value;
                }
            }
        } else {
            $wishlist = $wishlistModel->getWishlistByUser((int) $myuser->id);

            if ($wishlist) {
                foreach ($wishlist as $key => $value) {
                    //insert to top compare
                    if (!in_array($value->product_id, $compare_list)) {
                      foreach ($compare_list as $compare_id)  {
                        if ($topCompareModel->isExists($value->product_id, $compare_id)) {
                          $topCompareModel->updateCount($value->product_id, $compare_id);
                        } else {
                          $topCompareModel->insertRecord($value->product_id, $compare_id);
                        }
                      }
                    }

                    $compare_list[(int) $value->product_id] = (int) $value->product_id;
                }
            }
        }

        $_SESSION['compare_list'] = $compare_list;

        $this->json = new stdClass();
        $this->json->msg = 'All Items added to Comparison';
        $this->json->number = count($compare_list);
        echo json_encode($this->json);

        jExit();
    }

}
