<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 6188 2012-06-29 09:38:30Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

vmJsApi::js( 'jquery.noConflict');


if (!empty($this->product->images)) {
	$image = $this->product->images[0];
	?>

<?php
//echo "<pre>";
//print_r($this->product->images);
//echo "</pre>";file_url
?>

<?php
	$count_images = count ($this->product->images);
	if ($count_images > 0) {

            ?>
    <div class="additional-images">
        
            <div class="targetarea diffheight"><img id="multizoom2" 
                                                    alt="" 
                                                    title="" 
                                                    src=""/></div>
            
            <div class="multizoom2 thumbs">
                <?php 
                for ($i = 0; $i < $count_images; $i++) {
                        $image = $this->product->images[$i]; 
                        $product_img = JURI::base().$image->file_url;
                        $product_watermark = JURI::base().$this->product_config->watermark;
                        $watermark_opacity = $this->product_config->watermark_opacity;
                        $watermark_position = $this->product_config->watermark_position;
                        if($this->product_config->watermark_action==1)
//                          $imgsrc =  "libraries/wideimage/demo/image.php?image=1-rainbow.png&output=jpeg&demo=merge&overlay=6-logo.gif&opacity=100";
                        $imgsrc = "image.php?image=".$product_img.'&o='.$watermark_opacity.'&p='.$watermark_position.'&mark='.$product_watermark;
                        else $imgsrc = $product_img;
                        ?>
                <a href="<?php echo $imgsrc ?>" 
                   data-large="<?php echo $imgsrc ?>" 
                   data-title="<?php echo $this->product->product_name ?>">
                    <img src="<?php echo $imgsrc ?>" 
                         alt="<?php echo $this->product->product_name ?>" title="<?php echo $this->product->product_name ?>"/>
                </a>
                <?php } ?>
            </div>
     
    </div>

	<?php
	}
}
$document = JFactory::getDocument();
$document->addScript(JURI::base(true).'/components/com_virtuemart/assets/js/multizoom.js');
$document->addStyleSheet(JURI::base(true).'/components/com_virtuemart/assets/css/multizoom.css', 'text/css');
$document->addScriptDeclaration("
jQuery(document).ready(function($){
    $('#multizoom2').addimagezoom({ 
        magvertcenter: false, // magnified area centers vertically in relation to the zoomable image (optional) - new
        zoomrange: [3, 3],
        magnifiersize: [576,523],
        magnifierpos: 'right',
        cursorshade: true,             
        disablewheel: true,
        rightoffset:5
    });
});
");
