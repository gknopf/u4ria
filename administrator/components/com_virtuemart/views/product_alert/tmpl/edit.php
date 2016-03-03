<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage 	ratings
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: ratings_edit.php 2233 2010-01-21 21:21:29Z SimonHodgkiss $
*
* @todo decide to allow or not a JEditor here instead of a textarea
* @todo comment length check should also occur on the server side (model?)
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
vmJsApi::cssSite();
AdminUIHelper::startAdminArea(); ?>
<?php // pre($this->averageedit) ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<fieldset>
	    <legend><?php echo JText::_('COM_VIRTUEMART_AVERAGE_EDIT'); ?></legend>
	    <table class="admintable">
                <?php  foreach ($this->averageedit as $key => $value) { ?>
                <tr>
                    <td><?php echo $value->rate ?> Start</td>
                    <td>
                        <input id="star_<?php echo $value->rate ?>" class="input_box" name="star_<?php echo $value->rate ?>" value="<?php echo $value->ratingcount ?>" />
                    </td>
                </tr>
                <?php
               
                }?>
	    </table>
	</fieldset>
    <input type="hidden" name="virtuemart_average_rating_id" value="<?php echo $value->virtuemart_average_rating_id; ?>" />
    <input type="hidden" name="virtuemart_product_id" value="<?php echo $value->virtuemart_product_id; ?>" />
    <input type="hidden" name="created_on" value="<?php echo $this->averageedit->created_on; ?>" />
    <input type="hidden" name="modified_on" value="<?php echo $this->averageedit->modified_on; ?>" />
    <input type="hidden" name="published" value="<?php echo $this->averageedit->published; ?>" />
    <input type="hidden" name="totalvote" value="<?php echo $this->averageedit->published; ?>" />

 	<?php echo $this->addStandardHiddenToForm(); ?>
</form>


<?php AdminUIHelper::endAdminArea(); ?>
<?php 
        
function pre($str) {
    echo "<pre>";
    print_r($str);
    echo "</pre>";
}

function ec($str) {
    echo "<pre>";
    echo $str;
    echo "</pre>";
}
?>
