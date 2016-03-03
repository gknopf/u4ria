<?php
/**
*
* Set the product dimensions
*
* @package	VirtueMart
* @subpackage Product
* @author RolandD
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: product_edit_dimensions.php 6379 2012-08-25 17:09:39Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');?>
   <table class="adminform">
   <tbody>

    <tr class="row1">
      <td width="21%" valign="top" >
        <div style="text-align:right;font-weight:bold;"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_LENGTH') ?></div>
      </td>
      <td width="79%">
        <input type="text" class="inputbox"  name="product_length" value="<?php echo $this->product->product_length; ?>" size="15" maxlength="15" />   <?php echo " ".$this->lists['product_lwh_uom'];?>
      </td>
    </tr>
    <tr class="row0">
      <td   valign="top" >
        <div style="text-align:right;font-weight:bold;"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_WIDTH') ?></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_width" value="<?php echo $this->product->product_width; ?>" size="15" maxlength="15" />
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div style="text-align:right;font-weight:bold;"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_HEIGHT') ?></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_height" value="<?php echo $this->product->product_height; ?>" size="15" maxlength="15" />
      </td>
    </tr>

    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_INSERTABLE_LENGTH_DESCRIPTION'); ?>">
                <?php echo JText::_('COM_VIRTUEMART_PRODUCT_INSERTABLE_LENGTH') ?>
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="insertable_length" value="<?php echo $this->product->insertable_length; ?>" size="15" maxlength="15"/>&nbsp;
      </td>
    </tr>

    <tr class="row0">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_CIRCUMFERENCE_DESCRIPTION'); ?>">
                <?php echo JText::_('COM_VIRTUEMART_PRODUCT_CIRCUMFERENCE') ?>
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="circumference" value="<?php echo $this->product->circumference; ?>" size="15" maxlength="15"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_DIAMETER_DESCRIPTION'); ?>">
                <?php echo JText::_('COM_VIRTUEMART_PRODUCT_DIAMETER') ?>
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="diameter" value="<?php echo $this->product->diameter; ?>" size="15" maxlength="15"/>&nbsp;
      </td>
    </tr>
    <tr class="row0">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_MATERIALS_DESCRIPTION'); ?>">
                <?php echo JText::_('COM_VIRTUEMART_PRODUCT_MATERIALS') ?>
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="materials" value="<?php echo $this->product->materials; ?>" size="15" maxlength="15"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_MADE_IN_DESCRIPTION'); ?>">
                <?php echo JText::_('COM_VIRTUEMART_PRODUCT_MADE_IN') ?>
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="made_in" value="<?php echo $this->product->made_in; ?>" size="15" maxlength="15"/>&nbsp;
      </td>
    </tr>

    <tr class="row0">
      <td   valign="top" >
        <div style="text-align:right;font-weight:bold;"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_WEIGHT') ?></div>
      </td>
       <td>
        <input type="text" class="inputbox"  name="product_weight" size="15" maxlength="15" value="<?php echo $this->product->product_weight; ?>" />
        <?php echo " ".$this->lists['product_weight_uom'];?>
      </td>
    </tr>
    <!-- Changed Packaging - Begin -->

    <tr class="row0">
      <td  valign="top">
        <div align="right"><strong>
        <span class="hasTip" title="<?php echo JText::sprintf('COM_VIRTUEMART_PRODUCT_PACKAGING_DESCRIPTION',JText::_('COM_VIRTUEMART_UNIT_NAME_L'),JText::_('COM_VIRTUEMART_PRODUCT_UNIT'),JText::_('COM_VIRTUEMART_UNIT_NAME_100ML')); ?>">
        <?php echo JText::_('COM_VIRTUEMART_PRODUCT_PACKAGING') ?>
         </span>
            </strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_packaging" value="<?php echo $this->product->product_packaging; ?>" size="15" maxlength="15" />&nbsp;
		<?php echo " ".$this->lists['product_iso_uom'];?>
      </td>
    </tr>
    <tr class="row0">
      <td   valign="top" >
        <div style="text-align:right;font-weight:bold;">Package Weight</div>
      </td>
       <td>
        <input type="text" class="inputbox"  name="package_weight" size="15" maxlength="15" value="<?php echo $this->product->package_weight; ?>" />
        <?php echo " ".$this->lists['package_weight_uom'];?>
      </td>
    </tr>
    <tr class="row0">
      <td   valign="top" >
        <div style="text-align:right;font-weight:bold;">Package Length</div>
      </td>
       <td>
        <input type="text" class="inputbox"  name="package_length" size="15" maxlength="15" value="<?php echo $this->product->package_length; ?>" />
        <?php echo " ".$this->lists['package_length_uom'];?>
      </td>
    </tr>
    <tr class="row0">
      <td   valign="top" >
        <div style="text-align:right;font-weight:bold;">Package Width</div>
      </td>
       <td>
        <input type="text" class="inputbox"  name="package_width" size="15" maxlength="15" value="<?php echo $this->product->package_width; ?>" />
        <?php echo " ".$this->lists['package_width_uom'];?>
      </td>
    </tr>
    <tr class="row0">
      <td   valign="top" >
        <div style="text-align:right;font-weight:bold;">Package Height</div>
      </td>
       <td>
        <input type="text" class="inputbox"  name="package_height" size="15" maxlength="15" value="<?php echo $this->product->package_height; ?>" />
        <?php echo " ".$this->lists['package_height_uom'];?>
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_BOX_DESCRIPTION'); ?>">
                <?php echo JText::_('COM_VIRTUEMART_PRODUCT_BOX') ?>
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_unit" value="<?php echo $this->product->product_unit; ?>" size="15" maxlength="15"/>&nbsp;
      </td>
    </tr>
        
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Type">
                Type
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_type" value="<?php echo $this->product->product_type; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Lining">
                Lining
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_lining" value="<?php echo $this->product->product_lining; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Cock ring style">
                Cock ring style
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="cock_ring_style" value="<?php echo $this->product->cock_ring_style; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Boning">
                Boning
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_boning" value="<?php echo $this->product->product_boning; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Bottom style">
                Bottom style
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="bottom_style" value="<?php echo $this->product->bottom_style; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Flavor">
                Flavor
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="flavor" value="<?php echo $this->product->flavor; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Lingerie closure">
                Lingerie closure
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="lingerie_closure" value="<?php echo $this->product->lingerie_closure; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Lingerie special features">
                Lingerie special features
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="lingerie_special_features" value="<?php echo $this->product->lingerie_special_features; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Pattern">
                Pattern
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_pattern" value="<?php echo $this->product->product_pattern; ?>" size="100"/>&nbsp;
      </td>
    </tr>    
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Top style">
                Top style
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_top_style" value="<?php echo $this->product->product_top_style; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Texture">
                Texture
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_texture" value="<?php echo $this->product->product_texture; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Safety features">
                Safety features
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="safety_features" value="<?php echo $this->product->safety_features; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Material safety">
                Material safety
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="material_safety" value="<?php echo $this->product->material_safety; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Care and cleaning">
                Care and cleaning
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="care_and_cleaning" value="<?php echo $this->product->care_and_cleaning; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Pump mechanism">
                Pump mechanism
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="pump_mechanism" value="<?php echo $this->product->pump_mechanism; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Clitoral attachment shape">
                Clitoral attachment shape
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="clitoral_attachment_shape" value="<?php echo $this->product->clitoral_attachment_shape; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Special features">
                Special features
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="special_features" value="<?php echo $this->product->special_features; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Powered By">
                Powered By
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="powered_by" value="<?php echo $this->product->powered_by; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Harness compatibility">
                Harness compatibility
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="harness_compatibility" value="<?php echo $this->product->harness_compatibility; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Functions">
                Functions
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_functions" value="<?php echo $this->product->product_functions; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Control type">
                Control type
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="control_type" value="<?php echo $this->product->control_type; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Size">
                Size
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="product_size" value="<?php echo $this->product->product_size; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Maximum hip size">
                Maximum hip size
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="maximum_hip_size" value="<?php echo $this->product->maximum_hip_size; ?>" size="100" />&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Maximum waist size">
                Maximum waist size
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="maximum_waist_size" value="<?php echo $this->product->maximum_waist_size; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Cup Size">
                Cup Size
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="cup_size" value="<?php echo $this->product->cup_size; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Max stretched diameter">
                Max stretched diameter
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="max_stretched_diameter" value="<?php echo $this->product->max_stretched_diameter; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Unstretched diameter">
                Ustretched diameter
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="unstretched_diameter" value="<?php echo $this->product->unstretched_diameter; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <tr class="row1">
      <td   valign="top" >
        <div align="right"><strong>
                <span class="hasTip" title="Inner diameter">Inner diameter
                </span></strong></div>
      </td>
      <td>
        <input type="text" class="inputbox"  name="inner_diameter" value="<?php echo $this->product->inner_diameter; ?>" size="100"/>&nbsp;
      </td>
    </tr>
    <!-- Changed Packaging - End -->
</tbody>
</table>
