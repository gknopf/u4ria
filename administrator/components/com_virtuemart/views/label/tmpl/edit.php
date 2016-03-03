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
* @version $Id: edit.php 3786 2011-08-03 11:39:19Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

AdminUIHelper::startAdminArea();

?>

<form enctype="multipart/form-data" action="index.php" method="post" name="adminForm" id="adminForm">

<?php // Loading Templates in Tabs
$tabarray = array();
$tabarray['description'] = 'COM_VIRTUEMART_DESCRIPTION';
//$tabarray['images'] = 'COM_VIRTUEMART_IMAGE_S';

AdminUIHelper::buildTabs( $this, $tabarray , $this->label->virtuemart_label_id);
// Loading Templates in Tabs END ?>
	<input type="hidden" name="virtuemart_label_id" value="<?php echo $this->label->virtuemart_label_id; ?>" />
	<?php echo $this->addStandardHiddenToForm(); ?>
</form>
<script type="text/javascript">
function toggleDisable( elementOnChecked, elementDisable, disableOnChecked ) {
	try {
		if( !disableOnChecked ) {
			if(elementOnChecked.checked==true) {
				elementDisable.disabled=false;
			}
			else {
				elementDisable.disabled=true;
			}
		}
		else {
			if(elementOnChecked.checked==true) {
				elementDisable.disabled=true;
			}
			else {
				elementDisable.disabled=false;
			}
		}
	}
	catch( e ) {}
}

function toggleFullURL() {
	if( jQuery('#label_full_image_url').val().length>0) document.adminForm.label_full_image_action[1].checked=false;
	else document.adminForm.label_full_image_action[1].checked=true;
	toggleDisable( document.adminForm.label_full_image_action[1], document.adminForm.label_thumb_image_url, true );
	toggleDisable( document.adminForm.label_full_image_action[1], document.adminForm.label_thumb_image, true );
}
</script>
<?php AdminUIHelper::endAdminArea(); ?>