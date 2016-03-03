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

?>
    <fieldset>
        <legend>Product Configs</legend>
        <div class="product_config">
            <table class="adminform">
                <tr class="row0">
                    <td>
                    <div><label> <?php echo JText::_('Name'); ?></label> 
                        <input type="text" id="nameattribute1" name="nameattribute1" 
                               value="<?php echo $this->productconfig->name_attribute1 ;?>" />
                        <input type="file" name="top50" size="10" />
                        <input type="hidden" id="inputtop50" name="inputtop50" value="" />
                        <?php echo JHTML::_('list.images', 'top50', JURI::root().$this->productconfig->top50, " ", $this->imagePathTop50); ?>
                        <img id="top50lib" src="<?php echo JURI::root().$this->productconfig->top50; ?>" />
                    </div>                        
                    </td>
                </tr>
                <tr class="row1">
                    <td>
                    <div><label><?php echo JText::_('Name'); ?></label> 
                        <input type="text" id="nameattribute2" name="nameattribute2" 
                               value="<?php echo $this->productconfig->name_attribute2 ;?>" />
                        <input type="file" name="top100" size="10" />
                        <input type="hidden" id="inputtop100" name="inputtop100" value="" />                
                        <?php echo JHTML::_('list.images', 'top100', JURI::root().$this->productconfig->top100, " ", $this->imagePathTop100); ?>
                        <img id="top100lib" src="<?php echo JURI::root().$this->productconfig->top100; ?>" />
                    </div>                        
                    </td>
                </tr>
                <tr class="row0">
                    <td>
                    <div> <label><?php echo JText::_('Name'); ?></label>
                        <input type="text" id="nameattribute3" name="nameattribute3" 
                               value="<?php echo $this->productconfig->name_attribute3 ;?>" />
                        <input type="file" name="videodemo" size="10" />
                        <input type="hidden" id="inputvideodemo" name="inputvideodemo" value="" />       
                        <?php echo JHTML::_('list.images', 'videodemo', JURI::root().$this->productconfig->videodemo, " ", $this->imagePathVideodemo); ?>
                        <img id="videodemolib" src="<?php echo JURI::root().$this->productconfig->videodemo; ?>" />
                    </div>                        
                    </td>
                </tr>
                <tr class="row1">
                    <td>
                    <div> <label><?php echo JText::_('Name'); ?> </label>
                        <input type="text" id="nameattribute4" name="nameattribute4" 
                               value="<?php echo $this->productconfig->name_attribute4 ;?>" />
                        <input type="file" name="highly" size="10" />
                        <input type="hidden" id="inputhighly" name="inputhighly" value="" />  
                        <?php echo JHTML::_('list.images', 'highly', JURI::root().$this->productconfig->highly, " ", $this->imagePathHighly); ?>
                        <img id="highlylib" src="<?php echo JURI::root().$this->productconfig->highly; ?>" />
                    </div>     
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>

<script type="text/javascript">
	jQuery('#top50').change( function() {
		var $newimage = jQuery(this).val();
		jQuery('#inputtop50').val($newimage);
		jQuery('#top50lib').attr({ src:'<?php echo JURI::root(true).$this->imagePathTop50 ?>'+$newimage, alt:$newimage });
		});
	jQuery('#top100').change( function() {
		var $newimage = jQuery(this).val();
		jQuery('#inputtop100').val($newimage);
		jQuery('#top100lib').attr({ src:'<?php echo JURI::root(true).$this->imagePathTop100 ?>'+$newimage, alt:$newimage });
		});                
	jQuery('#videodemo').change( function() {
		var $newimage = jQuery(this).val();
		jQuery('#inputvideodemo').val($newimage);
		jQuery('#videodemolib').attr({ src:'<?php echo JURI::root(true).$this->imagePathVideodemo ?>'+$newimage, alt:$newimage });
		});                
	jQuery('#highly').change( function() {
		var $newimage = jQuery(this).val();
		jQuery('#inputhighly').val($newimage);
		jQuery('#highlylib').attr({ src:'<?php echo JURI::root(true).$this->imagePathHighly ?>'+$newimage, alt:$newimage });
		});
                 
</script>