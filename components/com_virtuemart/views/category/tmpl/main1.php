<?php


//vmdebug('$this->category',$this->category);
vmdebug ('$this->category ' . $this->category->category_name);
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
JHTML::_ ('behavior.modal');
/* javascript for list Slide
  Only here for the order list
  can be changed by the template maker
*/
$image = JURI::base().'components/com_virtuemart/assets/images/vmgeneral/avsgo-button.png' ;
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
";

$document = JFactory::getDocument ();
$document->addScriptDeclaration ($js);
?>

<?php


$sif = TRUE;
if ($this->smod) $sif = FALSE;
if ($this->fdate) $sif = FALSE;
if ($sif) {
	?>
<div class="category_description">
	<div class="category-title">
                <?php if(!empty($this->category->catagory_short_des)) $this->category->catagory_short_des = ' - '.$this->category->catagory_short_des;
                else
                    $this->category->catagory_short_des = '';
                ?>
                <?php echo $this->category->category_name.$this->category->catagory_short_des ?>
        </div>
	<div class="category-info">
            <?php
                echo '<div class="category_imgbox">'.$this->category->images[0]->displayMediaThumb ("", FALSE).'</div>';
                echo $this->category->category_description;
            ?>
        </div>
        <br class="clr">
</div>
<?php
}

/* Show child categories */

if (VmConfig::get ('showCategory', 1) and empty($this->keyword) and !$this->smod and !$this->fdate) {
	if ($this->category->haschildren) {

		// Category and Columns Counter
		$iCol = 1;
		$iCategory = 1;

		// Calculating Categories Per Row
		$categories_per_row = VmConfig::get ('categories_per_row', 3);
		$category_cellwidth = ' width' . floor (100 / $categories_per_row);

		// Separator
		$verticalseparator = " vertical-separator";

		?>

		<div class="category-view">

		<?php // Start the Output

		if (!empty($this->category->children)) {

			foreach ($this->category->children as $category) {
                            $topbs = getTop10BestSeller($category->virtuemart_category_id);
                            $topbs_id = $topbs->virtuemart_category_id;
                            $topbs_url = JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $topbs_id);

                            if($category->top10 !=1&&$category->top10 !="1") {
                                // Show the horizontal seperator
                                if ($iCol == 1 && $iCategory > $categories_per_row) {
                                    ?>
                                    <div class="horizontal-separator"></div>
                                <?php
                                }
                                // this is an indicator wether a row needs to be opened or not
                                if ($iCol == 1) {
                                    ?>


                                <?php
                                }

                                // Show the vertical seperator
                                if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
                                    $show_vertical_separator = ' ';
                                } else {
                                    $show_vertical_separator = $verticalseparator;
                                }

                                // Category Link
                                $caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $this->category->virtuemart_category_id);

                                // Show Category
                                ?>
                                <div id="<?php echo JFilterOutput::stringURLSafe($category->category_name) ?>"
                                     class="category floatleft<?php echo $show_vertical_separator ?>">
                                    <div class="spacer">
                                        <div class="cattitle_lv2">
                                            <h2>
                                                <a href="<?php echo $caturl ?>"
                                                   title="<?php echo $category->category_name ?>">
                                                    <?php echo $category->category_name ?>
                                                    <br/>
                                                </a>
                                            </h2>
                                            <?php echo "<span class=\"totalitem\">(Total " . $category->productcount . " items)</span>" ?>
                                            <?php if ($topbs_id): ?>
                                                <div class="top10bestseller"><a href="<?php echo $topbs_url ?>"> Top 20
                                                        Best Seller</a></div>
                                            <?php endif ?>
                                        </div>


                                    </div>
                                    <div class="subcat">
                                        <?php $numbercattoshow = 0;
                                        $categoryModel = VmModel::getModel('category');
                                        foreach ($category->children as $child) {
                                            $numbercattoshow++;
                                            if ($child->category_name == "Top 20 Best Seller Of " . $category->category_name)
                                                continue;

                                            $caturl3 = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $child->virtuemart_category_id);
//
                                            ?>
                                            <div class="catsub_lv3">
                                                <div class="cattitle_lv3">
                                                    <div class="cattitle_lv3_2">
                                                        <div class="subtitle_img">
                                                            <a href="<?php echo $caturl3 ?>"
                                                               title="<?php echo $child->category_name ?>">
                                                                <?php
                                                                if ($child->images['0']->file_url_thumb)
                                                                    echo '<img src="' . $child->images['0']->file_url_thumb . '"/>';
                                                                else
                                                                    echo '<img src="components/com_virtuemart/assets/images/vmgeneral/noimage.gif"/>';
                                                                ?>
                                                            </a>
                                                        </div>
                                                        <div class="subtitle_mark"></div>
                                                        <div class="subtitle_bottom">
                                                            <a href="<?php echo $caturl3 ?>"
                                                               title="<?php echo $child->category_name ?>">
                                                                <?php
                                                                echo $child->category_name ?><?php echo "<span>(" . $categoryModel->countProducts($child->virtuemart_category_id) . ")" ?>
                                                                <br/>
                                                            </a>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if ($numbercattoshow == 100) break;
                                        } ?>
                                        <div class="clear"></div>

                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <?php
                                $iCategory++;

                                // Do we need to close the current row now?
                                if ($iCol == $categories_per_row) {
                                    ?>
                                    <div class="clear"></div>

                                    <?php
                                    $iCol = 1;
                                } else { ?>
                                    <div class="clear"></div>
                                    <?php
                                    $iCol++;
                                }


                            }

			}
                        echo "<div class=\"top10 videos\"><h3>8 Most Viewed ".$this->category->category_name." Videos</h3>";

                        ?>

                <ul id="category_videos" class="jcarousel-skin-tango">
                    <?php

                    if (is_array($this->category->category_videos) && count($this->category->category_videos) > 0)
                    {
                            foreach ($this->category->category_videos as  $item):
                               $linkvideo = JRoute::_('index.php?option=com_virtuemart&view=videos&tmpl=component&virtuemart_category_id='.$this->category->virtuemart_category_id);
                            ?>
                    <li>            <a  class="" href="<?php echo $linkvideo;?>" target="_blank" onclick="window.open(this.href, 'Video Product Page','left=200,top=10,width=1000,height=1500,toolbar=0,resizable=0, scrollbars=1'); return false;">
                                    <img src="<?php echo $item->video_thumb;?>" width="195" height="130" />
                                    <?php echo $item->video_title;?>
                                    </a>
                   </li>
                            <?php

                            endforeach;
                    }
                    ?>
                </ul>
                                        <div class="most_videos_footer">Ordered from left to right, most popular to least popular</div>
                </div>
                        <?php echo "<div class=\"top10\"><h3>Top 20 ".$this->category->category_name." Best Reviewed, Top Rated, and Highly Recommended New Items</h3>";

                        foreach ($this->category->children as $category) {
                        if($category->top10 =="1"||$category->top10 ==1){

			$caturl = JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id);

				// Show Category
				?>
                                    <div class="catsub_lv3">
                                          <div class="cattitle_lv3">
                                          <div class="cattitle_lv3_2">
						<h2>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
								<?php
                                                                    if($category->images['0']->file_url_thumb)
                                                                        echo '<img width="201" height="138" src="'.$category->images['0']->file_url_thumb.'"/>';
                                                                    else
                                                                        echo '<img width="201" height="138"  src="components/com_virtuemart/assets/images/vmgeneral/noimage.gif"/>';
								 ?>
							</a>
                                                </h2><a href="<?php echo $caturl3 ?>" title="<?php echo $category->category_name ?>">
                                                <?php echo "<span class=\"topcat_name\">".$category->category_name."</span>" ?>
                                                    </a>
                                             </div>



					</div>
                                </div>
                        <?php
                        }
                       }
                       echo "</div>";

		}
		// Do we need a final closing row tag?
		if ($iCol != 1) {
			?>

			<div class="clear"></div>
		</div>
	<?php } ?>

	</div>

	<?php
	}
}
?>

<pre style="float: left;width: 100%;">
<?php // print_r ($this->category->category_videos);
function getTop10BestSeller($virtuemart_category_id){
        $db = JFactory::getDBO();
        $q = "select 	c.virtuemart_category_id,c.top10bs
	from #__virtuemart_categories as c
        JOIN #__virtuemart_category_categories as cc ON c.virtuemart_category_id = cc.category_child_id
        where cc.category_parent_id = ".$virtuemart_category_id." and c.top10bs = 1";

        $db->setQuery($q);
        $db->query();
        $id = $db->loadObject();
        return $id;
}
?>
</pre>
