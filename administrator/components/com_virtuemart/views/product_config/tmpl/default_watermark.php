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
                <tr class="row1">
                    <td>Enable watermark:</td>
                    <td colspan="3">
                        <?php if($this->productconfig->watermark_action==1) $wck = 'checked'; else $wck =''; ?>
                        <input type="checkbox" name="watermark_action" value="1" <?php echo $wck ?> />
                    </td>
                </tr>
                <tr class="row0">
                    <td colspan="4">
                    <div> <label><?php echo JText::_('Watermark Image'); ?> </label><input type="file" name="watermark" size="10" />
                        <input type="hidden" id="inputwatermark" name="inputwatermark" value="" />  
                        <?php echo JHTML::_('list.images', 'watermark', JURI::root().$this->productconfig->watermark, " ", $this->imagePathWatermark); ?>
                    </div>                         
                    </td>
                </tr>
                <tr class="row1">
                    <td>
                        <?php echo JText::_('Watermark Opacity').':' ?>
                    </td>
                    <td>
                        <input type="text" name="watermark_opacity" value="<?php echo $this->productconfig->watermark_opacity ?>" /><span>Type value from 0 to 100</span>
                    </td>
                    <td>
                        <?php
                        if($this->productconfig->watermark_position == 1) $wpl = 'Top Left';
                        if($this->productconfig->watermark_position == 2) $wpl = 'Top Right';
                        if($this->productconfig->watermark_position == 3) $wpl = 'Bottom Left';
                        if($this->productconfig->watermark_position == 4) $wpl = 'Bottom Right';
                        if($this->productconfig->watermark_position == 5) $wpl = 'Center';
                        ?>
                       <?php echo JText::_('Watermark position').'('.$wpl.')'; ?>
                    </td>
                    <td>
                        <select id="watermark_position" name="watermark_position" >
                            <option value="0">Select Position</option>
                            <option value="1">Top Left Position</option>
                            <option value="2">Top Right Position</option>
                            <option value="3">Bottom Left Position</option>
                            <option value="4">Bottom Right Position</option>
                            <option value="5">Center Position</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="1">
                        <?php echo JText::_("Watermark Preview"); ?>
                    </td>
                    <td colspan="3">
                        <img id="watermarklib" src="<?php echo JURI::root().$this->productconfig->watermark; ?>" />
                    </td>
                </tr>
                <tr class="row0">
                    <td colspan="4">
                        The watermark image should be in one of the following recommended formats:
                        <ul>
                          <li>PNG-8 (recommended)<br>
                            Colors: 256 or less<br>
                            Transparency: On/Off</li>
                          <li>GIF<br>
                            Colors: 256 or less<br>
                            Transparency: On/Off</li>
                          <li>
                                The imagecopymerge function does not properly handle the PNG-24 images; it is therefore not recommend.

                                If you are using Adobe Photoshop to create watermark images, it is recommended that you use "Save for Web" command with the following settings:

                                File Format: PNG-8, non-interlaced
                                Color Reduction: Selective, 256 colors
                                Dithering: Diffusion, 88%
                                Transparency: On, Matte: None
                                Transparency Dither: Diffusion Transparency Dither, 100%                              
                          </li>
                        </ul>  
                    </td>
                </tr>
            </table>

           
        </div>
    </fieldset>

<script type="text/javascript">
	jQuery('#watermark').change( function() {
		var $newimage = jQuery(this).val();
		jQuery('#inputwatermark').val($newimage);
		jQuery('#watermarklib').attr({ src:'<?php echo JURI::root(true).$this->imagePathWatermark ?>'+$newimage, alt:$newimage });
		});                   
</script>