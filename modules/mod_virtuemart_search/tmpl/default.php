<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<!--BEGIN Search Box -->
<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id='.$category_id ); ?>" method="get">
<div class="search<?php echo $params->get('moduleclass_sfx'); ?>">
<?php $output = '<div class="searchmain">
				' . JText::_('COM_VIRTUEMART_CATEGORIES_RELATED_SEARCH') . '
				<input style="vertical-align :middle;" name="keyword" id="mod_virtuemart_search" maxlength="'.$maxlength.'" alt="'.$button_text.'" class="inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';
 $image = JURI::base().'components/com_virtuemart/assets/images/vmgeneral/go-button.gif' ;

			if ($button) :
			    if ($imagebutton) :
			        $button = '<input style="vertical-align :middle;" type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$image.'" onclick="this.form.keyword.focus();"/>';
			    else :
			        $button = '<input type="submit" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" onclick="this.form.keyword.focus();"/>';
			    endif;
			     $output .="<span class=\"useavs\">   Use <a href=\"".JRoute::_ ( 'index.php?option=com_virtuemart&amp;view=avsearch&amp;layout=search&amp;Itemid=162')."\">Advanced Search</a></span>";
			    $manufacture = '</div><div class="searchbrand">Search by Brands <select name="brand">';
				$manufacture .= '<option value="">--All--</option>';
			    foreach ($manufacturers as $manufacturer)
			    {
			    	$manufacture .= '<option value="">' . $manufacturer->mf_name . '</option>';
			    }
			    $manufacture .= '</select>';
			    $output .= " " . $manufacture . $button . " </div>";
				$url = JRoute::_ ( 'index.php?option=com_virtuemart&view=productcompare&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id );
				$my_array = $_SESSION['compare_list'];
				$comparison = '<a class="global-action-url" href="'.$url.'">
                                                <i class="ico">&nbsp;</i>
                                                <span class="action-title">Compare</span>
                                                <span class="global-action-count">(<span id="qty">'.sizeof($my_array).'</span>)</span>
                                            </a>';

				//$output .= $comparison;
			    $langBox = '<div class="langbox">
			    			<img src="' . JURI::base().'templates/u4riatemplate/images/flag1.gif">
			    			<img src="' . JURI::base().'templates/u4riatemplate/images/flag2.gif">
			    			<img src="' . JURI::base().'templates/u4riatemplate/images/flag3.gif">
			    			<select name="language">
			    				<option value="">Select language</option>
			    			</select>
			    			</div>';

			  //  $output .= $langBox;

			endif;

			switch ($button_pos) :
			    case 'top' :
				    $button = $button.'<br />';
				    $output = $button.$output;
				    break;

			    case 'bottom' :
				    $button = '<br />'.$button;
				    $output = $output;
				    break;

			    case 'right' :
				    $output = $output;
				    break;

			    case 'left' :
			    default :
				    $output = $output;
				    break;
			endswitch;

			echo $output;
?>
</div><div class="clr"></div>
		<input type="hidden" name="limitstart" value="0" />
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="view" value="category" />
	  </form>

<!-- End Search Box -->