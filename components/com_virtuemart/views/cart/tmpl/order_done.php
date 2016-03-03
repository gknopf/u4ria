<?php
defined('_JEXEC') or die('');

/**
*
* Template for the shopping cart
*
* @package	VirtueMart
* @subpackage Cart
* @author Max Milbers
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/



//echo "<h3>".JText::_('COM_VIRTUEMART_CART_ORDERDONE_THANK_YOU')."</h3>";
echo "<h2 class='tdThank'>THANK YOU FOR YOUR PURCHASE !</h2>";

echo $this->html;
echo "<span style='color:gray;font-size: 11pt;line-height: 2;'>You will receive an order confirmation email with details of you order and a link to track its progress.</span>";
?>
<br/>
<a href="<?php echo JURI::root() ?>"><input type="button" value="CONTINUTE SHOPPING" style="border:1px solid gray;padding:1%;background-color:white;cursor:pointer;color:gray;float:right;"></a>
<style>
    .tdThank
    {
        color:gray;
        letter-spacing:1px;
        font-weight: 500;
        margin:20px 0 20px 0;
    }
    .ui-dialog
    {
       display:none !important;
    }
    .ui-widget-overlay
    {
        display:none !important;
    }
    .vmorder-done
    {
        color: gray;
        font-size: 11pt;
        line-height: 1.5;
    }
    #maincontainer
    {
        z-index: 9999;
    }
</style>
