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
				echo count ( $this->historyTransactionList );
				?>);" /></th>
			<th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_PRODUCT_NAME' ), 'product_name', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>			
                    <th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_SHOPPER_FORM_USERNAME' ), 'username', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
                    <th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_SHOPPER_FORM_FIRST_NAME' ), 'firstname', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
                    <th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_SHOPPER_FORM_LAST_NAME' ), 'lastname', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
                    <th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_SHOPPER_FORM_EMAIL' ), 'email', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
                    <th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_SHOPPER_FORM_PHONE' ), 'phone', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
                    <th>
				<?php
				echo JHTML::_ ( 'grid.sort', JText::_ ( 'COM_VIRTUEMART_HISTORY_TRANSACTIONS_DATE_BUY' ), 'date_buy', $this->lists ['filter_order_Dir'], $this->lists ['filter_order'] );
				?>
		    </th>
		</tr>
	</thead>
	    <?php
		$k = 0;
		for($i = 0, $n = count ( $this->historyTransactionList ); $i < $n; $i ++) {
			$row = $this->historyTransactionList [$i];			
			$checked = JHTML::_ ( 'grid.id', $i, $row->history_transaction_id, null, 'id' );
//			$editlink = JROUTE::_ ( 'index.php?option=com_virtuemart&view=product_freegift&task=edit&id=' . $row->id );
			?>
	    <tr class="<?php echo "row$k";?>">
		<td width="10">
			<?php	echo $checked;	?>
		</td>
		<td>
			<?php echo $row->product_name;?>
		</td>
             <td>
		    <?php echo ( $row->username);?>
		</td>
                <td>
		    <?php echo ( $row->firstname);?>
		</td>
                <td>
		    <?php echo ( $row->lastname);?>
		</td>
                <td>
		    <?php echo ( $row->email);?>
		</td>
                <td>
		    <?php echo ( $row->phone);?>
		</td>
                <td align="center">
		    <?php echo ( $row->date_buy);?>
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
	type="hidden" name="controller" value="History_Transactions" /> <input
	type="hidden" name="view" value="History_transactions" /> <input type="hidden"
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