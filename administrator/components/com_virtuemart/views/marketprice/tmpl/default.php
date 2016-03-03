<?php
/**
 *
 * Description
 *
 * @package	VirtueMart
 * @subpackage Market_price
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
defined ( '_JEXEC' ) or die ( 'Restricted access' );

AdminUIHelper::startAdminArea ();

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="editcell">
<table class="adminlist" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th width="10"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?php
				echo count ( $this->market_prices );
				?>);" /></th>
			<th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_MARKETPRICE_PRODUCT' ), 'virtuemart_product_id', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
			<th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_MARKETPRICE_PRICE' ), 'mk_price', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
			<th>
		    	<?php
							echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_MARKETPRICE_LINK' ), 'mk_link', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
							?>
		    </th>
			<th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_MARKETPRICE_COMMENT' ), 'mk_comment', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
			<th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_MARKETPRICE_POST_BY' ), 'mk_price', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
			<th width="20">
				<?php
				echo JText::_ ( 'COM_VIRTUEMART_PUBLISH' );
				?>
		    </th>
		</tr>
	</thead>
	    <?php
		$k = 0;
		for($i = 0, $n = count ( $this->market_prices ); $i < $n; $i ++) {
			$row = $this->market_prices [$i];
			
			$checked = JHTML::_ ( 'grid.id', $i, $row->virtuemart_market_price_id, null, 'virtuemart_market_price_id' );
			$published = JHTML::_ ( 'grid.published', $row, $i );
			$editlink = JROUTE::_ ( 'index.php?option=com_virtuemart&view=marketprice&task=edit&virtuemart_market_price_id=' . $row->virtuemart_market_price_id );
			?>
	    <tr class="<?php echo "row$k";?>">
		<td width="10">
			<?php	echo $checked;	?>
		</td>
		<td>
			<a href="<?php echo $editlink; ?>">	<?php echo $row->product_name;?></a>
		    <?php $link = 'index.php?option=com_virtuemart&view=product&task=edit&virtuemart_product_id=' . $row->virtuemart_product_id . '&product_parent_id=' . $row->product_parent_id;?>
		    <?php echo JHTML::_ ( 'link', JRoute::_ ( $link ), "[view product]", array ('title' => JText::_ ( 'COM_VIRTUEMART_EDIT' ) . ' ' . $row->virtuemart_product_id ) );?></td>

		<td align="right">
		    <?php echo number_format ( $row->mk_price, 2 );?>
		</td>
		<td>
			<?php
						if (! empty ( $row->mk_link ))
							echo '<a href="' . $row->mk_link . '" target="_blank">' . $row->mk_link . '</a>';
						?>
		</td>
		<td>
			<?php
						echo $row->mk_comment;
						?>
		</td>
		<td>
			<?php
						echo $row->username;
						?>
		</td>
		<td align="center">
			<?php
						echo $published;
						?>
		</td>
	</tr>
		<?php
						$k = 1 - $k;
					}
					?>
	    <tfoot>
		<tr>
			<td colspan="10">
			<?php //echo $this->pagination->getListFooter(); 			?>
		    </td>
		</tr>
	</tfoot>
</table>
</div>

<input type="hidden" name="option" value="com_virtuemart" /> <input
	type="hidden" name="controller" value="market_price" /> <input
	type="hidden" name="view" value="market_price" /> <input type="hidden"
	name="task" value="" /> <input type="hidden" name="boxchecked"
	value="0" /> <input type="hidden" name="filter_order"
	value="<?php
	echo $this->lists ['filter_order'];
	?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php
	echo $this->lists ['filter_order_Dir'];
	?>" />
    <?php
				echo JHTML::_ ( 'form.token' );
				?>
</form>


<?php
AdminUIHelper::endAdminArea ();
?>