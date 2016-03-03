<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script-->
<script type="text/javascript" src="modules/mod_vm_prod_cat_full/menu/js/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="modules/mod_vm_prod_cat_full/menu/js/jquery.dcmegamenu.1.2.js"></script>

<link href="modules/mod_vm_prod_cat_full/menu/menu.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
        jQuery(document).ready(function(jQuery) {
                jQuery('#mega-menu-tut').dcMegaMenu({
                        rowItems: '3',
                        speed: 'fast'
                });
        });
</script>

<div class="dcjq-mega-menu">


        <?php
        // no direct access
        defined('_JEXEC') or die('Restricted access');

        /**
         * Outputs one level of categories and calls itself for any subcategories
         *
         * @access	public
         * @param int $catPId (the category_id of current parent category)
         * @param int $level (the current category level [main cats are 0, 1st subcats are 1])
         * @param object $params (the params object containing all params for this module)
         * @param int $current_cat (category_id from the request array, if it exists)
         * @return nothing - echos html directly
         * */
// Because this function is declared in the view, need to make sure it hasn't already been declared:
        
        if (!function_exists('vmFCLBuildMenu')) {

                function vmFCLBuildMenu($catPId = 0, $level = 1, $settings, $current_cat = 0, $active = array()) {
                        if ((!$settings['level_end'] || $level < $settings['level_end']) && $rows = modVMFullCategoryList::getCatChildren($catPId)) :

                                if ($level >= $settings['level_start']) :

                                        if ($level == 1) {
                                                ?>
                                                <ul id="mega-menu-tut" class="menu">
                                                        <?php } else { ?>
                                                        <ul>
                                                        <?php
                                                        } endif;
//Anal Toys Bondage Dildos Lubes Luxury Sextoy Vibrators Sexy Wear Men's Sex Toys Additions New Clearance Promotion
//"Get a 5% Rebate Discounts only for this weekend"
                                                foreach ($rows as $row) :
//                                                        if ((($row->virtuemart_category_id != 31 && $row->virtuemart_category_id != 96 && $row->virtuemart_category_id != 113 && $row->virtuemart_category_id != 97 && $row->virtuemart_category_id != 98 && $row->virtuemart_category_id != 99 && $row->virtuemart_category_id != 100 && $row->virtuemart_category_id != 62 && $row->virtuemart_category_id != 101 && $row->virtuemart_category_id != 102 && $row->virtuemart_category_id != 103 && $row->virtuemart_category_id != 104) && $level == 1) || $row->top10 == 1 || $row->top10bs == 1)
                                                        if ((($row->show_in_menu!=1) && $level == 1) || $row->top10 == 1 || $row->top10bs == 1 || $row->top40 == 1){
                                                                continue;
                                                        }
                                                        $cat_active = in_array($row->virtuemart_category_id, $active);
                                                        if ($settings['current_filter'] && $level < count($active) && !$cat_active)
                                                                continue;
               
                                                        if ($level >= $settings['level_start']) :
                                                                $itemid = modVMFullCategoryList::getVMItemId($row->virtuemart_category_id);
                                                                $itemid = ($itemid ? '&Itemid=' . $itemid : '');
                                                                if ($level == 2) {
                                                                        $parent_idx = modVMFullCategoryList::getCatParent($row->virtuemart_category_id);
                                                                        $link = JFilterOutput::ampReplace(JRoute::_('index.php?option=com_virtuemart' . '&view=category&virtuemart_category_id=' . $parent_idx->category_parent_id . $itemid . '#' . JFilterOutput::stringURLSafe($parent_idx->category_name)));
                                                                }
                                                                else
                                                                        $link = JFilterOutput::ampReplace(JRoute::_('index.php?option=com_virtuemart' . '&view=category&virtuemart_category_id=' . $row->virtuemart_category_id . $itemid));
                                                                ?>
                                                                <li<?php echo ($current_cat == $row->virtuemart_category_id ? ' id="current"' : '');
                                                                if ($cat_active) echo ' class="active"'; ?>>
                                                                        <a  href="<?php echo $link ?>" target="_self">
                                                                        <?php echo htmlspecialchars(stripslashes($row->category_name), ENT_COMPAT, 'UTF-8') ?>
                                                                        <?php if ($level != 1) echo "(" . $row->productcount . ")" ?>
                                                                        </a>						
                                                        <?php
                                                        endif;
                                                        // Check for sub categories
                                                        vmFCLBuildMenu($row->virtuemart_category_id, $level + 1, $settings, $current_cat, $active);
                                                        if ($level >= $settings['level_start']) :
                                                                ?>
                                                                </li>
                                                <?php
                                                endif;
                                        endforeach;
                                        if ($level >= $settings['level_start']) :
                                                ?>
                                                </ul>
                                        <?php
                                        endif;
                                endif;
                        }

                }

// With what category, if any, do we start?
// Default to cat filter param:
                $catid = $cat_filter;
                $level = 1;
// Set up current category array (for displaying '.active' class and for current category filter, if applicable)
                $active = array();
                if ($current_cat) {
                        $active = modVMFullCategoryList::getCatParentIds($current_cat);
                        if ($settings['current_filter']) {
                                $catid = $current_cat;
                                $level = count($active);
                                if ($settings['level_start']) {
                                        // Adjust the starting point
                                        array_unshift($active, 0);
                                        $catid = $active[$settings['level_start'] - 1];
                                        $level = $settings['level_start'];
                                }
                        }
                }
                if ($cat_filter && !$settings['current_filter']) {
                        $parents = modVMFullCategoryList::getCatParentIds($cat_filter);
                        $level = count($parents);
                }
// Call the display function for the first menu item:
                vmFCLBuildMenu($catid, $level, $settings, $current_cat, $active);

// Are there any better ways to make this follow joomla's MVC pattern
// (by outputting a tree structure returned by helper class, for ex)? like:
// while ($item) {
                // output
                // $item = $item->child;
//}
// Probably way out of the scope of this module...
// see mod_mainmenu if you don't believe it
                ?>

</div>