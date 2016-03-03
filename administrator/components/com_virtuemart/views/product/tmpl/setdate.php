<?php
defined('_JEXEC') or die('Restricted access');
AdminUIHelper::startAdminArea();
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
    <fieldset>
	<legend>
            <?php echo JText::_('COM_VIRTUEMART_PRODUCT_NEW_DATE') ?>
	</legend>
    <table>
        <tr class="row1 ">
            <td width="21%" ><div style="text-align:right;font-weight:bold;">
                <?php echo JText::_('COM_VIRTUEMART_PRODUCT_MONTH_TO_NEW') ?></div>
            </td>
            <td class="monthofnew" colspan="3">
                    <?php
                    $month = date("m");
                    echo '<select name="new_m" class="year_new chzn-done" >';
                    for ($y = 1; $y <= 12; $y++) {
                        if ($month == $y)
                            echo '<option value="' . $y . '" selected>' . $y . '</option>';
                        else
                            echo '<option value="' . $y . '">' . $y . '</option>';
                    }
                    echo '</select>';
                    ?>	
            </td>
            <td><div style="text-align:right;font-weight:bold;">
                 <?php echo JText::_('COM_VIRTUEMART_PRODUCT_YEAR_TO_NEW') ?></div>
            </td>
            <td>
               
                <?php
                //   $month=date("F");
                $year = date("Y");
                echo '<select name="new_y" class="year_new chzn-done" >';
                for ($y = 2007; $y < $year + 10; $y++) {
                    if ($year == $y)
                        echo '<option value="' . $y . '" selected>' . $y . '</option>';
                    else
                        echo '<option value="' . $y . '">' . $y . '</option>';
                }
                echo '</select>';
                ?>
            </td>
            <td>
<div class="toolbar-list" id="toolbar">
<ul>
<li class="button" id="toolbar-new">
<a href="#" onclick="Joomla.submitbutton('settodate')" class="toolbar">
<span class="icon-32-new">
</span>
Set to new date
</a>
</li>

</ul>
<div class="clr"></div>
</div>                
            </td>
        </tr>
    </table>
          </fieldset>

		<input type="hidden" name="pid" value="<?php echo $this->pidx; ?>">
		<input type="hidden" name="task" value="setdate_new">
		<input type="hidden" name="option" value="com_virtuemart">
		<input type="hidden" name="boxchecked" value="0">
		<input type="hidden" name="controller" value="product">
		<input type="hidden" name="view" value="product">
		<input type="hidden" name="3bddfae0e72b45c7486217c6dccb0d6d" value="1">    
</form>
<?php AdminUIHelper::endAdminArea(); ?>