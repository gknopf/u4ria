<?php
/**
 *
 * Description
 *
 * @package	VirtueMart
 * @subpackage Config
 * @author RickG
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6053 2012-06-05 12:36:21Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
AdminUIHelper::startAdminArea ();
?>
<form name="adminForm" method="post"  id="adminForm"
      action="index.php?option=com_virtuemart&view=product_config"
      enctype="multipart/form-data">
<?php // Loading Templates in Tabs
$tabarray = array();
$tabarray['featured'] = 'Product Feature';
$tabarray['watermark'] = 'Product Watermark';
$tabarray['freegift'] = 'Free Gift Percent Allowed';

//$tabarray['emails'] = 'COM_VIRTUEMART_PRODUCT_FORM_EMAILS_TAB';
// $tabarray['customer'] = 'COM_VIRTUEMART_PRODUCT_FORM_CUSTOMER_TAB';


AdminUIHelper::buildTabs ( $this,  $tabarray, $this->product->virtuemart_product_id );
?>

<!-- Hidden Fields --> <input type="hidden" name="task" value="save" /> <input
	type="hidden" name="option" value="com_virtuemart" /> <input
	type="hidden" name="view" value="product_config" />
<?php
echo JHTML::_ ( 'form.token' );
?>
</form>
<?php
AdminUIHelper::endAdminArea ();
?>
