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
      action="index.php?option=com_virtuemart&view=user_level"
      enctype="multipart/form-data">
<?php // Loading Templates in Tabs
// $tabarray = array();
// $tabarray['featured'] = 'Product Feature';
// $tabarray['watermark'] = 'Product Watermark';


// AdminUIHelper::buildTabs ( $this,  $tabarray, $this->product->virtuemart_product_id );
?>
<fieldset>
    <legend>User Level Config</legend>
    <div class="product_config">
<table class="adminlist">
		<thead>
			<tr>
				<th width="10%" class="nowrap">
					ID
				</th>
				<th width="30%" class="nowrap">
					Level Name
				</th>
				<th width="20%" class="nowrap">
				 Min Amount($)
				</th>
				<th width="20%" class="nowrap" style="display: none">
					Max Amount($)
				</th>
				<th width="20%" class="nowrap">
					Discount(%)
				</th>
				<th width="20%" class="nowrap">
					Duration(month)
				</th>
			</tr>
		</thead>

		<tbody>
		<?php if ($this->userLevelAll) :?>
		  <?php foreach ($this->userLevelAll as $key => $value): ?>
				<tr>
				  <td class="center"><?php echo $value->id; ?></td>
				  <td class="center"><?php echo $value->level_name; ?></td>
				  <td class="center"><input type="text" name="user_level[<?php echo $value->id;?>][min_amount]" size="20" value="<?php echo $value->min_amount; ?>" /></td>
				  <td class="center" style="display: none"><input type="text" name="user_level[<?php echo $value->id;?>][max_amount]" size="20" value="<?php echo $value->max_amount; ?>" /></td>
				  <td class="center"><input type="text" name="user_level[<?php echo $value->id;?>][discount]" size="5" value="<?php echo $value->discount; ?>" /></td>
				  <td class="center"><input type="text" name="user_level[<?php echo $value->id;?>][duration]" size="5" value="<?php echo $value->duration; ?>" /></td>
			</tr>
			<?php endforeach; ?>
		<?php endif;?>
    </tbody>
	</table>
    </div>
</fieldset>
<!-- Hidden Fields -->
<input type="hidden" name="task" value="save" />
<input type="hidden" name="option" value="com_virtuemart" />
<input type="hidden" name="view" value="user_level" />
<?php
echo JHTML::_ ( 'form.token' );
?>
</form>
<?php
AdminUIHelper::endAdminArea ();
?>
