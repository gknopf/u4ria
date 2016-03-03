<?php

/**
 *
 * Handle the category view
 *
 * @package	VirtueMart
 * @subpackage
 * @author RolandD
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 6504 2012-10-05 09:40:59Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if (!class_exists('VmView'))
    require(JPATH_VM_SITE . DS . 'helpers' . DS . 'vmview.php');

/**
 * Handle the category view
 *
 * @package VirtueMart
 * @author RolandD
 * @todo set meta data
 * @todo add full path to breadcrumb
 */
class VirtuemartViewCategory extends VmView {

    public function display($tpl = null) {


        $show_prices = VmConfig::get('show_prices', 1);
        if ($show_prices == '1') {
            if (!class_exists('calculationHelper'))
                require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'calculationh.php');
        }
        $this->assignRef('show_prices', $show_prices);

        $document = JFactory::getDocument();
        // add javascript for price and cart
        vmJsApi::jPrice();

        $app = JFactory::getApplication();
        $pathway = $app->getPathway();

        /* Set the helper path */
        $this->addHelperPath(JPATH_VM_ADMINISTRATOR . DS . 'helpers');

        //Load helpers
        $this->loadHelper('image');
        $categoryModel = VmModel::getModel('category');
        $productModel = VmModel::getModel('product');


        $categoryId = JRequest::getInt('virtuemart_category_id', false);

        if ($categoryId == NULL) {
            $categoryId = JRequest::getInt('category', false);
            $this->assignRef('csid', $categoryId);
        }

        $product_config_model = VmModel::getModel('Product_Config');
        $product_config = $product_config_model->getProductConfig();
        $this->assignRef('product_config', $product_config);

        $fdate = JRequest::getBool('fdate', null);
        $this->assignRef('fdate', $fdate);

        $sku = JRequest::getVar('sku', '');
        $this->assignRef('sku', $sku);

        $ip_pricefrom = JRequest::getVar('pricefrom', '');
        $this->assignRef('ip_pricefrom', $ip_pricefrom);

        $ip_priceto = JRequest::getVar('priceto', '');
        $this->assignRef('ip_priceto', $ip_priceto);

        $rfromdes = JRequest::getVar('search_in_description', '');
        $this->assignRef('rfromdes', $rfromdes);

        $sinsub = JRequest::getVar('sinsub', '');
        $this->assignRef('sinsub', $sinsub);

        $vendorId = 1;

        $category = $categoryModel->getCategory($categoryId);
        if (!$category->published) {
            vmInfo('COM_VIRTUEMART_CAT_NOT_PUBL', $category->category_name, $categoryId);
            return false;
        }

/////////////////*******//////////////////////
        $db = & JFactory::getDBO();
        $qmfc = '
            SELECT m.virtuemart_manufacturercategories_id,mn.mf_category_name 
            FROM #__virtuemart_manufacturercategories m
            LEFT JOIN #__virtuemart_manufacturercategories_en_gb as mn ON m.virtuemart_manufacturercategories_id = mn.virtuemart_manufacturercategories_id    
            ';
        $qmf = '
            SELECT m.virtuemart_manufacturer_id,mn.mf_name,mc.virtuemart_manufacturercategories_id,mce.mf_category_name
            FROM u4ria_virtuemart_manufacturers m
            JOIN u4ria_virtuemart_manufacturers_en_gb as mn ON m.virtuemart_manufacturer_id = mn.virtuemart_manufacturer_id 
            JOIN u4ria_virtuemart_manufacturercategories as mc on mc.virtuemart_manufacturercategories_id = m.virtuemart_manufacturercategories_id
            JOIN u4ria_virtuemart_manufacturercategories_en_gb as mce on mce.virtuemart_manufacturercategories_id = mc.virtuemart_manufacturercategories_id   
            ';

        $db->setQuery($qmfc);
        $resmfc = $db->loadObjectList();
        $db->setQuery($qmf);
        $resmf = $db->loadObjectList();
        $resmfca = $resmfca;
        foreach ($resmfca as $value) {
            $v = strtolower(substr(trim($value->mf_category_name), 0, 1));
        //    $v = substr($value->mf_category_name, 0, 1);
            $adsas[$v][]=$value;
        }        
        ksort($adsas);
        
        $mafu .='<ul class="mafulist">';
        foreach (range('a', 'z') as $char) {
            $mafu .='<li class="mark b'.$char.'"><div onclick="mfa(\''.$char.'\');" >'. $char.' >></div>';
            if(!empty($adsas[$char])){
                $mafu .='<ul class="fc'.$char.'" >';
                    foreach ($adsas[$char] as $value) {
                        $mafu .= '<li id="m'.$value->virtuemart_manufacturercategories_id.'" class="click" >'.$value->mf_category_name.'('.$model->countProductsMcat($value->virtuemart_manufacturercategories_id).')</li>';
                    }
                $mafu .='</ul></li>';
            }
        }    
        $mafu .= '</ul>';
        $this->assignRef('amafu', $mafu);
//        echo 'Brand - '.$_SESSION['b'].'<br/>';
//        echo 'Mafu - '.$_SESSION['m'].'<br/>';
        $mlists  = '';
        $mlists  .= '<select id="virtuemart_manufacturercategories_id" name="virtuemart_manufacturercategories_id" width="50%">';
        $mlists  .= '<option value="" >--Select Manufacturer--</option>';
        foreach ($resmfc as $value) {
            if($_SESSION['m']==$value->virtuemart_manufacturercategories_id) $select = "selected"; else $select = "";
            $mlists .= '<option '.$select.' class="csl" id="c'.$value->virtuemart_manufacturercategories_id.'" value="m'.$value->virtuemart_manufacturercategories_id.'">'.$value->mf_category_name.'</option>';
        }        
        $mlists  .= '</select>';
        
        $mlists2  = '';
        $mlists2  .= '<select id="virtuemart_manufacturer_id" name="virtuemart_manufacturer_id" width="50%">';
        $mlists2  .= '<option value="" >--Select Brand--</option>';
        foreach ($resmf as $value) {
            if($_SESSION['b']==$value->virtuemart_manufacturer_id) $select = "selected"; else $select = "";
            $mlists2 .= '<option '.$select.' class="c'.$value->virtuemart_manufacturercategories_id.'" value="b'.$value->virtuemart_manufacturer_id.'">'.$value->mf_name.'</option>';
        }        
        $mlists2  .= '</select>';
        
        $this->assignRef('manufacturercategories', $mlists);
        $this->assignRef('manufacturer', $mlists2);

        ///////////////////******////////////////////

        $categoryModel->addImages($category, 1);
        $perRow = empty($category->products_per_row) ? VmConfig::get('products_per_row', 3) : $category->products_per_row;
//        $categoryModel->setPerRow($perRow);
        $this->assignRef('perRow', $perRow);
        
        if ($category->parents) {
            foreach ($category->parents as $c) {
                 if($c->top10==1 OR $c->top10bs==1 OR $c->top_for_manufacturer==1 OR $c->top_for_brand==1 )
                         $c->category_name = "Top 20 Best Seller";
                 if($c->top40 == 1){
                     $c->category_name = "Top 40 Best Seller " . $c->category_name;
                 }
                $pathway->addItem(strip_tags($c->category_name), JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' 
                        . $category->parents[0]->virtuemart_category_id.'#' . JFilterOutput::stringURLSafe($c->category_name)));
            }
        }else{
            if($category->top10==1 OR $category->top10bs==1 OR $category->top_for_manufacturer==1 OR $category->top_for_brand==1 )
                         $category->category_name = "Top 20 Best Seller";
            if($category->top40 == 1){
                $category->category_name = "Top 40 Best Seller " . $category->category_name;
            }
        }
        $categoryModel->addImages($category, 1);
        $cache = JFactory::getCache('com_virtuemart', 'callback');
        $category->children = $categoryModel->getChildCategoryList($vendorId, $categoryId);

        $categoryModel->addImages($category->children, 1);
        foreach ($category->children as $cat) {
//                         if($cat->virtuemart_category_id == $catcurent) $cat->curent = "selected";
            $cat->children = $categoryModel->getChildCategoryList($vendorId, $cat->virtuemart_category_id);
            $categoryModel->addImages($cat->children, 1);
        }



        if (VmConfig::get('enable_content_plugin', 0)) {
            // add content plugin //
            $dispatcher = JDispatcher::getInstance();
            JPluginHelper::importPlugin('content');
            $category->text = $category->category_description;
            if (!class_exists('JParameter'))
                require(JPATH_LIBRARIES . DS . 'joomla' . DS . 'html' . DS . 'parameter.php');

            $params = new JParameter('');

            if (JVM_VERSION === 2) {
                $results = $dispatcher->trigger('onContentPrepare', array('com_virtuemart.category', &$category, &$params, 0));
                // More events for 3rd party content plugins
                // This do not disturb actual plugins, because we don't modify $product->text
                $res = $dispatcher->trigger('onContentAfterTitle', array('com_virtuemart.category', &$category, &$params, 0));
                $category->event->afterDisplayTitle = trim(implode("\n", $res));

                $res = $dispatcher->trigger('onContentBeforeDisplay', array('com_virtuemart.category', &$category, &$params, 0));
                $category->event->beforeDisplayContent = trim(implode("\n", $res));

                $res = $dispatcher->trigger('onContentAfterDisplay', array('com_virtuemart.category', &$category, &$params, 0));
                $category->event->afterDisplayContent = trim(implode("\n", $res));
            } else {
                $results = $dispatcher->trigger('onPrepareContent', array(& $category, & $params, 0));
            }
            $category->category_description = $category->text;
        }


        $this->assignRef('category', $category);

        // Set Canonic link
        if (!empty($tpl)) {
            $format = $tpl;
        } else {
            $format = JRequest::getWord('format', 'html');
        }
        if ($format == 'html') {
            $document->addHeadLink(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $categoryId), 'canonical', 'rel', '');
        }

        // Set the titles
        if ($category->customtitle) {
            $title = strip_tags($category->customtitle);
        } elseif ($category->category_name) {
            $title = strip_tags($category->category_name);
        } else {
            $menus = $app->getMenu();
            $menu = $menus->getActive();
            if ($menu)
                $title = $menu->title;
            // $title = $this->params->get('page_title', '');
            // Check for empty title and add site name if param is set
            if (empty($title)) {
                $title = $app->getCfg('sitename');
            } elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
                $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
            } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
                $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
            }
        }

        if (JRequest::getInt('error')) {
            $title .=' ' . JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
        }
        $bsearch = JRequest::getBool('search', FALSE);
        $this->assignRef('smod', $bsearch);
        // set search and keyword
        if ($keyword = vmRequest::uword('keyword', '0', ' ,-,+')) {
            $pathway->addItem($keyword);
            $title = 'Search for keyword (' . $keyword . ')';
        }else{
            $month = JRequest::getvar('month', null);
            if(!empty($month)){
                $year = JRequest::getvar('year', null);
                $monthName = date("F", mktime(0, 0, 0, $month, 10));
                $titleCategoryMonth = $monthName.' '.$year;
                $pathway->addItem($titleCategoryMonth);
                $this->assignRef('titleCategoryMonth', $titleCategoryMonth);
            }
        }
        $search = JRequest::getvar('keyword', null);
        if ($search !== null) {
            $searchcustom = $this->getSearchCustom();
        }
        $this->assignRef('keyword', $keyword);

        $this->assignRef('search', $search);

        $ratingModel = VmModel::getModel('ratings');
        $showRating = $ratingModel->showRating();
        $this->assignRef('showRating', $showRating);

        // Load the products in the given category
        $products = $productModel->getProductsInCategory($categoryId);
        $productModel->addImages($products, 1);
//        echo "<pre>";
//        print_r($products);die();
//        echo "</pre>";
        $label_model = VmModel::getModel('label');
        foreach ($products as $key => $product) {
            $product->votes = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
//            $product->votes = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
            $product->stock = $productModel->getStockIndicator($product);
            $product->rating = $categoryModel->get5RatingByProduct($product->virtuemart_product_id);
            //add label image 
            if ($product->label_id)
                $product->label = $label_model->getLabelId($product->label_id);

            $compare_list = $_SESSION['compare_list'];
            $product->show_compare_flag = 1;

            if (is_array($compare_list)):
                if (in_array($product->virtuemart_product_id, $compare_list)):
                    $product->show_compare_flag = 2;
                endif;
            endif;
            $products[$key] = $product;
        }

        $this->assignRef('products', $products);

        


        $this->assignRef('virtuemart_manufacturer_id', JRequest::getInt('virtuemart_manufacturer_id', 0));

        $virtuemart_manufacturer_id = JRequest::getInt('virtuemart_manufacturer_id', 0);
        if ($virtuemart_manufacturer_id and !empty($products[0]))
            $title .=' ' . $products[0]->mf_name;



        /* For Search Views */


        $document->setTitle($title);
        // Override Category name when viewing manufacturers products !IMPORTANT AFTER page title.
        if (JRequest::getInt('virtuemart_manufacturer_id') and !empty($products[0]))
            $category->category_name = $products[0]->mf_name;

        $pagination = $productModel->getPagination($perRow);
        $this->assignRef('vmPagination', $pagination);

        $orderByList = $productModel->getOrderByList($categoryId);
        $this->assignRef('orderByList', $orderByList);

        if ($category->metadesc) {
            $document->setDescription($category->metadesc);
        }
        if ($category->metakey) {
            $document->setMetaData('keywords', $category->metakey);
        }
        if ($category->metarobot) {
            $document->setMetaData('robots', $category->metarobot);
        }

        if ($app->getCfg('MetaTitle') == '1') {
            $document->setMetaData('title', $title);
        }
        if ($app->getCfg('MetaAuthor') == '1') {
            $document->setMetaData('author', $category->metaauthor);
        }
        if ($products) {
            $currency = CurrencyDisplay::getInstance();
            $this->assignRef('currency', $currency);
        }
        
        // Add feed links
        if ($products && VmConfig::get('feed_cat_published', 0) == 1) {
            $link = '&format=feed&limitstart=';
            $attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
            $document->addHeadLink(JRoute::_($link . '&type=rss'), 'alternate', 'rel', $attribs);
            $attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
            $document->addHeadLink(JRoute::_($link . '&type=atom'), 'alternate', 'rel', $attribs);
        }
        if (!class_exists('Permissions'))
            require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'permissions.php');
        $showBasePrice = Permissions::getInstance()->check('admin'); //todo add config settings
        $this->assignRef('showBasePrice', $showBasePrice);

        //set this after the $categoryId definition
        $paginationAction = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $categoryId);
        $this->assignRef('paginationAction', $paginationAction);

        shopFunctionsF::setLastVisitedCategoryId($categoryId);
        shopFunctionsF::setLastVisitedManuId($virtuemart_manufacturer_id);

        if (empty($category->category_template)) {
            $category->category_template = VmConfig::get('categorytemplate');
        }

        shopFunctionsF::setVmTemplate($this, $category->category_template, 0, $category->category_layout);

        //get wishlist list
        $myuser = & JFactory::getUser();
        $wishlist_list = array();

        if ($myuser->guest) {
            $wishlist_list = $_SESSION['wishlist'];
        } else {
            $wishlistModel = VmModel::getModel('wishlist');
            $wishlist_list = $wishlistModel->getProductIdByUser((int) $myuser->id);
        }
        

        $topbestseller = $categoryModel->getTopBestSellerSite($categoryId);

        if($category->top10bs == 1){
                $category->parentname = $categoryModel->getParentCategory($categoryId);
        }
//        print_r($category->parentname);die();
        $this->assignRef('topbestseller', $topbestseller);
        $this->assignRef('wishlist_list', $wishlist_list);
        $srview = JRequest::getVar('search');
        $searchtype = $productModel->keywordCheck();
        $this->assignRef('searchtype', $searchtype);
        if(!empty($srview)) 
        JView::setLayout('default');
        
        parent::display($tpl);
    }

    /*
     * generate custom fields list to display as search in FE
     */

    public function getSearchCustom() {

        $model_ma = VmModel::getModel('manufacturer');
        $manufacturers = $model_ma->getManufacturers();

        foreach ($manufacturers as $manufacturer) {
            $manufacturer->count = $model_ma->countProducts($manufacturer->virtuemart_manufacturer_id);
        }

        $this->assignRef('manufacturers', $manufacturers);
        $category_id = '0';
        $model_cat = VmModel::getModel('Category');
        $vendorId = '1';

        if ($categoryId == NULL) {
            $catcurent = JRequest::getInt('category', false);
            $this->assignRef('csid', $catcurent);
        }

        $categories = $model_cat->getChildCategoryList($vendorId, $category_id);
        foreach ($categories as $category) {
            if ($category->virtuemart_category_id == $catcurent)
                $category->curent = "selected";
            $category->childs = $model_cat->getChildCategoryList($vendorId, $category->virtuemart_category_id);
            $category->cl = $model_cat->getSubcatid($category->virtuemart_category_id);
            foreach ($category->childs as $cat) {
                if ($cat->virtuemart_category_id == $catcurent)
                    $cat->curent = "selected";
                $cat->childs = $model_cat->getChildCategoryList($vendorId, $cat->virtuemart_category_id);
                $cat->cl = $model_cat->getSubcatid($cat->virtuemart_category_id);
                foreach ($cat->childs as $cend) {
                    if ($cend->virtuemart_category_id == $catcurent)
                        $cend->curent = "selected";
                    $cend->cl = $model_cat->getSubcatid($cend->virtuemart_category_id);
                    $cend->childs = $model_cat->getChildCategoryList($vendorId, $cend->virtuemart_category_id);
                    $cat->cl .= $cend->cl;
                }
                $category->cl .= $cat->cl;
            }
        }


        $this->assignRef('categories', $categories);
        $emptyOption = array('virtuemart_custom_id' => 0, 'custom_title' => JText::_('COM_VIRTUEMART_LIST_EMPTY_OPTION'));
        $this->_db = JFactory::getDBO();
        $this->_db->setQuery('SELECT `virtuemart_custom_id`, `custom_title` FROM `#__virtuemart_customs` WHERE `field_type` ="P"');
        $this->options = $this->_db->loadAssocList();

        if ($this->custom_parent_id = JRequest::getInt('custom_parent_id', 0)) {
            $this->_db->setQuery('SELECT `virtuemart_custom_id`, `custom_title` FROM `#__virtuemart_customs` WHERE custom_parent_id=' . $this->custom_parent_id);
            $this->selected = $this->_db->loadObjectList();
            $this->searchCustomValues = '';
            foreach ($this->selected as $selected) {
                $this->_db->setQuery('SELECT `custom_value` as virtuemart_custom_id,`custom_value` as custom_title FROM `#__virtuemart_product_customfields` WHERE virtuemart_custom_id=' . $selected->virtuemart_custom_id);
                $valueOptions = $this->_db->loadAssocList();
                $valueOptions = array_merge(array($emptyOption), $valueOptions);
                $this->searchCustomValues .= JText::_($selected->custom_title) . ' ' . JHTML::_('select.genericlist', $valueOptions, 'customfields[' . $selected->virtuemart_custom_id . ']', 'class="inputbox"', 'virtuemart_custom_id', 'custom_title', 0);
            }
        }

        // add search for declared plugins
        JPluginHelper::importPlugin('vmcustom');
        $dispatcher = JDispatcher::getInstance();
        $plgDisplay = $dispatcher->trigger('plgVmSelectSearchableCustom', array(&$this->options, &$this->searchCustomValues, $this->custom_parent_id));

        if (!empty($this->options)) {
            $this->options = array_merge(array($emptyOption), $this->options);
            // render List of available groups
            $this->searchCustomList = JText::_('COM_VIRTUEMART_SET_PRODUCT_TYPE') . ' ' . JHTML::_('select.genericlist', $this->options, 'custom_parent_id', 'class="inputbox"', 'virtuemart_custom_id', 'custom_title', $this->custom_parent_id);
        } else {
            $this->searchCustomList = '';
        }

        $this->assignRef('searchcustom', $this->searchCustomList);
        $this->assignRef('searchcustomvalues', $this->searchCustomValues);
    }

}

//no closing tag