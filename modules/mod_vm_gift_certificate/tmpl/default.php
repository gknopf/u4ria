<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_weblinks
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$db = JFactory::getDBO();
   $q = "select virtuemart_category_id
       from u4ria_virtuemart_categories_en_gb
       where category_name = 'Gift Certificates'";
   $db->setQuery($q);
   $db->query();
   $categoryObj = $db->loadObject();
?>
<div style="padding: 5px;">
<?php echo JHTML::link (JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$categoryObj->virtuemart_category_id)
        , 'Gift Certificate', array('id' => 'mod_vm_gift_certificate')); ?>
</div>