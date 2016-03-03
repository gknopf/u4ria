<?php
/**
*
* Description
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
* @version $Id: category.php 6383 2012-08-27 16:53:06Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

/**
* Class Description
*
* @package VirtueMart
* @author RolandD
*/
class VirtueMartControllerCategory extends JController {

    /**
    * Method Description
    *
    * @access public
    * @author RolandD
    */
    public function __construct() {
     	 parent::__construct();

     	 $this->registerTask('browse','category');
		 $this->registerTask('popupcategory','TopCategory');
		 $this->registerTask('getbrand','getbrand');
   	}

	/**
	* Function Description
	*
	* @author RolandD
	* @author George
	* @access public
	*/
       public function getBrand(){
           $mcid = JRequest::getVar('manufacturercat_id');
           $mcid = (int)substr($mcid,1);
           if(empty($mcid)) $where = '';
           else $where = ' WHERE mc.virtuemart_manufacturercategories_id = '.$mcid.' ';
        $qmf = '
            SELECT m.virtuemart_manufacturer_id,mn.mf_name,mc.virtuemart_manufacturercategories_id,mce.mf_category_name
            FROM u4ria_virtuemart_manufacturers m
            JOIN u4ria_virtuemart_manufacturers_en_gb as mn ON m.virtuemart_manufacturer_id = mn.virtuemart_manufacturer_id 
            JOIN u4ria_virtuemart_manufacturercategories as mc on mc.virtuemart_manufacturercategories_id = m.virtuemart_manufacturercategories_id
            JOIN u4ria_virtuemart_manufacturercategories_en_gb as mce on mce.virtuemart_manufacturercategories_id = mc.virtuemart_manufacturercategories_id   
            '.$where.'
        ';
        $db = & JFactory::getDBO();
        $db->setQuery($qmf);
        $resmf = $db->loadObjectList();
        $mlists2  = '';
        $mlists2  .= '<option value="" >--Select Brand--</option>';
        foreach ($resmf as $value) {
            $mlists2 .= '<option class="c'.$value->virtuemart_manufacturercategories_id.'" value="b'.$value->virtuemart_manufacturer_id.'">'.$value->mf_name.'</option>';
        }        
        $mlists2  .= '</select>';
        
        echo $mlists2;
        jexit();
        
       }
       public function display($cachable = false, $urlparams = false)  {

		if (JRequest::getvar('search')) {
			$view = $this->getView('category', 'html');
                        $view->setLayout('default');
			$view->display();
		} else {
			// Display it all
			$safeurlparams = array('virtuemart_category_id'=>'INT','virtuemart_manufacturer_id'=>'INT','virtuemart_currency_id'=>'INT','return'=>'BASE64','lang'=>'CMD','orderby'=>'CMD','limitstart'=>'CMD','order'=>'CMD','limit'=>'CMD');
			parent::display(true, $safeurlparams);
		}
		if($categoryId = JRequest::getInt('virtuemart_category_id',0)){
			shopFunctionsF::setLastVisitedCategoryId($categoryId);
		}
	}
	public function TopCategory(){
		/* Create the view */
		
		$view = $this->getView('popupcategory', 'html');
		$this->addModelPath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart' . DS . 'models');
		/* Add the default model */
		$view->setModel($this->getModel('category', 'VirtuemartModel'), true);

		/* Add the product model */
		$view->setModel($this->getModel('product', 'VirtuemartModel'));
		
		$data = JRequest::getInt('error');

		/* Set the layout */
		$view->setLayout('default');

		/* Display it all */
		$view->display();
	}	
}
// pure php no closing tag
