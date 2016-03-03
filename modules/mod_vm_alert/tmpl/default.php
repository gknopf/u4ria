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
<div style="text-align: center;cursor: pointer;">
    <?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productalert'), '<img width="70" height="70" src="images/Product-Alert.png" alt="Product Alert" />', array('id' => 'mod_vm_alert')); ?>

</div>
<div style="padding: 5px;">

<?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=productalert'), 'Product Alert(' . $total . ')', array('id' => 'mod_vm_alert')); ?>
</div>