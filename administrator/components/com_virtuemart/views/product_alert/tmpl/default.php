<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage   ratings
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: ratings.php 2233 2010-01-21 21:21:29Z SimonHodgkiss $
*/

// @todo a link or tooltip to show the details of shop user who posted comment
// @todo more flexible templating, theming, etc..

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
AdminUIHelper::startAdminArea();
/* Get the component name */
$option = JRequest::getWord('option');
//pre($this->ratings);
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="header">
	<div id="filterbox">
	<table>
	  <tr>
		 <td align="left" width="100%">
			<?php echo JText::_('COM_VIRTUEMART_FILTER'); ?>:
			<input type="text" name="filter_alert" value="<?php echo JRequest::getVar('filter_alert', ''); ?>" />
			<button onclick="this.form.submit();"><?php echo JText::_('COM_VIRTUEMART_GO'); ?></button>
			<button onclick="document.adminForm.filter_alert.value='';"><?php echo JText::_('COM_VIRTUEMART_RESET'); ?></button>
		 </td>
	  </tr>
	</table>
	</div>
	<div id="resultscounter" ><?php echo $this->pagination->getResultsCounter();?></div>
</div>

<div style="text-align: left;">
	<table class="adminlist" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th width="5%"><input type="checkbox" name="toggle" value="" onclick="checkAll('<?php echo count($this->listArler); ?>')" /></th>
		<th><?php echo $this->sort('product_name') ; ?></th>
                <th><?php echo JText::_('Product Promotion'); ?></th>
                <th><?php echo JText::_('Product Clearance Sale'); ?></th>
                <th><?php echo JText::_('Product Price Reduction'); ?></th>
                <th><?php echo JText::_('Product New Review'); ?></th>
                <th><?php echo JText::_('Alert Email'); ?></th>
		
	</tr>
	</thead>
	<tbody>
	<?php
	if (count($this->listArler) > 0) {
		$i = 0;
		$k = 0;
		$keyword = JRequest::getWord('keyword');
		foreach ($this->listArler as $key => $Arler) {
			$checked = JHTML::_('grid.id', $i , $Arler->virtuemart_product_alert_id);			
			?>
			<tr class="row<?php echo $k ; ?>">
				<!-- Checkbox -->
				<td><?php echo $checked; ?></td>
				<!-- Product name -->
				<?php $link = 'index.php?option='.$option.'&view=average_ratings&task=edit&cid[]='.$listArler->virtuemart_product_id; ?>
				<td><?php echo JHTML::_('link', $link,$Arler->product_name , array("title" => JText::_('COM_VIRTUEMART_RATING_EDIT_TITLE'))); ?></td>
				<!-- published -->
				<td><?php echo $Arler->alert_product_promotion; ?></td>
				<td><?php echo $Arler->alert_product_clearance_sale; ?></td>
				<td><?php echo $Arler->alert_product_price_reduction; ?></td>
				<td><?php echo $Arler->alert_product_new_review; ?></td>
				<td><?php echo $Arler->alert_email; ?></td>
			</tr>
		<?php
			$k = 1 - $k;
			$i++;
		}
	}
	?>
	</tbody>
	<tfoot>
		<tr>
		<td colspan="16">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
		</tr>
	</tfoot>
	</table>
</div>
<!-- Hidden Fields -->
	<?php echo $this->addStandardHiddenToForm(); ?>
</form>
<?php AdminUIHelper::endAdminArea(); ?>
