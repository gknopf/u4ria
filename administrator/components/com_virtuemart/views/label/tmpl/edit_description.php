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
* @version $Id: edit.php 3617 2011-07-05 12:55:12Z enytheme $
*/


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access'); 
?>
<?php echo $this->langList; ?>
<div class="col50">
	<fieldset>
	<legend><?php echo JText::_('COM_VIRTUEMART_PRODUCT_LABEL'); ?></legend>
	<table class="admintable">
	<?php echo VmHTML::row('input','COM_VIRTUEMART_PRODUCT_LABEL_NAME','lb_name',$this->label->lb_name); ?>
	<?php echo VmHTML::row('input','COM_VIRTUEMART_PRODUCT_LABEL_OPACITY','lb_opacity',$this->label->lb_opacity); ?>
	<?php echo VmHTML::row('input','COM_VIRTUEMART_PRODUCT_LABEL_TEXT_COLOUR','lb_colour',$this->label->lb_colour); ?>
		
	</table>
	</fieldset>
</div>
<div class="col50">
	<div class="selectimage">
		<?php 
//		$this->label->images[0]->addHidden('virtuemart_vendor_id',$this->virtuemart_vendor_id);

		echo $this->label->images[0]->displayFilesHandler($this->label->virtuemart_media_id,'label'); ?>
	</div>
</div>
	
