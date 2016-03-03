<?php
defined('_JEXEC') or die;

function countProducts($month,$year) {
    $dbc = JFactory::getDBO();
    $vendorId = 1;
    
   $q = 'SELECT count(#__virtuemart_products.virtuemart_product_id) AS total
    FROM `#__virtuemart_products` 
    WHERE `#__virtuemart_products`.`virtuemart_vendor_id` = "'.(int)$vendorId.'"

    AND `#__virtuemart_products`.`new_m` = '.(int)$month.'
    AND `#__virtuemart_products`.`new_y` = '.(int)$year.'
    AND `#__virtuemart_products`.`published` = "1" ';
    $dbc->setQuery($q);
    $count = $dbc->loadResult();
    if(!$count) $count=0;
    return $count;
}
$base = strtotime(date('Y-m',time()) . '-01 00:00:01');
$month1 = date("F", strtotime('+0 month', $base));
$months1 = date("m", strtotime('+0 month', $base));
$month2 = date("F",strtotime('-1 month', $base));
$months2 = date("m",strtotime('-1 month', $base));
$month3 = date("F",strtotime('-2 month', $base));
$months3 = date("m",strtotime('-2 month', $base));
$year = date("Y");
?>
<ul class="VMmenu">
    <li><a href="<?php echo "index.php?keyword=&option=com_virtuemart&page=shop.browse&search=true&view=category&limitstart=0&fdate=true&month=".$months1."&year=".$year ?>"><?php echo $month1.' '.$year; ?>(<?php echo countProducts($months1, $year) ?>)</a></li>
    <li><a href="<?php echo "index.php?keyword=&option=com_virtuemart&page=shop.browse&search=true&view=category&limitstart=0&fdate=true&month=".$months2."&year=".$year ?>"><?php echo $month2.' '.$year; ?>(<?php echo countProducts($months2, $year) ?>)</a></li>
    <li><a href="<?php echo "index.php?keyword=&option=com_virtuemart&page=shop.browse&search=true&view=category&limitstart=0&fdate=true&month=".$months3."&year=".$year ?>"><?php echo $month3.' '.$year; ?>(<?php echo countProducts($months3, $year) ?>)</a></li>
</ul>
