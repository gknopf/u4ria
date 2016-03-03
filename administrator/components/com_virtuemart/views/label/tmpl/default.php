<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage Label
* @author Patrick Kohl
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 4071 2011-09-11 10:52:55Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

AdminUIHelper::startAdminArea();

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
    <div id="editcell">
	<table class="adminlist" cellspacing="0" cellpadding="0">
	    <thead>
		<tr>
		    <th width="10">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->labels); ?>);" />
		    </th>
		    <th>
				<?php echo JHTML::_('grid.sort', JText::_('COM_VIRTUEMART_PRODUCT_LABEL_NAME') , 'lb_name', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?>
		    </th>
		    <th>
				<?php echo JHTML::_('grid.sort', JText::_('COM_VIRTUEMART_PRODUCT_LABEL_THUMB_TEXT') , 'lb_thumb_text', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?>
		    </th>
		    <th>
				<?php echo JHTML::_('grid.sort', JText::_('COM_VIRTUEMART_PRODUCT_LABEL_LARGE_TEXT') , 'lb_normal_text', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?>
		    </th>
		    <th>
				<?php echo JHTML::_('grid.sort', JText::_('COM_VIRTUEMART_PRODUCT_LABEL_OPACITY') , 'lb_opacity', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?>
		    </th>
		    <th>
				<?php echo JHTML::_('grid.sort', JText::_('COM_VIRTUEMART_PRODUCT_LABEL_TEXT_COLOUR') , 'lb_filter', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?>
		    </th>
		    <th width="20">
				<?php echo JText::_('COM_VIRTUEMART_PUBLISH'); ?>
		    </th>
		</tr>
	    </thead>
	    <?php
	    $k = 0;
	    for ($i=0, $n=count( $this->labels ); $i < $n; $i++) {
		$row = $this->labels[$i];

		$checked = JHTML::_('grid.id', $i, $row->virtuemart_label_id,null,'virtuemart_label_id');
		$published = JHTML::_('grid.published', $row, $i);
		$editlink = JROUTE::_('index.php?option=com_virtuemart&view=label&task=edit&virtuemart_label_id=' . $row->virtuemart_label_id);
		?>
	    <tr class="<?php echo "row$k"; ?>">
		<td width="10">
			<?php echo $checked; ?>
		</td>
		<td align="left">
		    <a href="<?php echo $editlink; ?>"><?php echo $row->lb_name; ?></a>
		</td>
		<td align="left">
		    <a href="<?php echo $editlink; ?>"><?php echo strip_tags($row->lb_thumb_text); ?></a>
		</td>
		<td>
			<?php echo strip_tags($row->lb_normal_text); ?>
		</td>
		<td>
			<?php echo $row->lb_opacity; ?>
		</td>
		<td>
			<?php echo $row->lb_colour; ?>
		</td>
		<td align="center">
			<?php echo $published; ?>
		</td>
	    </tr>
		<?php
		$k = 1 - $k;
	    }
	    ?>
	    <tfoot>
		<tr>
		    <td colspan="10">
			<?php // echo $this->pagination->getListFooter(); ?>
		    </td>
		</tr>
	    </tfoot>
	</table>
    </div>

    <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="controller" value="label" />
    <input type="hidden" name="view" value="label" />
    <input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['filter_order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['filter_order_Dir']; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>


<?php AdminUIHelper::endAdminArea(); ?>