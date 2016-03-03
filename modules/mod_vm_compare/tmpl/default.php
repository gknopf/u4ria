<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_weblinks
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php $compare_number = 0; ?>
<?php if ($_SESSION['compare_list']): $compare_number = count($_SESSION['compare_list']); endif; ?>
<div style="text-align: center;cursor: pointer;">
    <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productcompare'), '<img width="70" height="70" src="images/Product-Comparision.jpg" alt="Product Comparison" />', array('id' => 'mod_vm_compare')); ?>
</div>
<div style="padding: 5px;">
<?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productcompare'), 'Comparison(' . $compare_number . ')', array('id' => 'mod_vm_compare')); ?>
</div>