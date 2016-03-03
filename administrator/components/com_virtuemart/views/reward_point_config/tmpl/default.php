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
AdminUIHelper::startAdminArea ();
?>
<form name="adminForm" method="post"  id="adminForm"
      action="index.php?option=com_virtuemart&view=reward_point_config"
      enctype="multipart/form-data">
    <fieldset>
        <legend>Reward Point Config</legend>
        <div class="product_config">
            <table class="adminform">
               <tr class="row0">
                    <td>
                    <div><label> 1 RP =</label>
                        <input type="text" name="rp_sgd" size="10" value="<?php echo $this->reward_point_config->rp_sgd; ?>" />
                        <label>SGD</label>
                    </div>
                    </td>
                </tr>
                <tr class="row1">
                    <td>
                    <div>
                    <label>First time signing</label>
                     <input type="text" name="first_time_signing" size="10" value="<?php echo $this->reward_point_config->first_time_signing; ?>" />
                        <label>%</label>
                    </div>
                    </td>
                </tr>
                               <tr class="row0">
                    <td>
                    <div><label>6 month pay </label>
                        <input type="text" name="six_month_amount" size="10" value="<?php echo $this->reward_point_config->six_month_amount; ?>" />
                        <label style="width: 50px">will have</label>
                        <input type="text" name="six_months_discount" size="10" value="<?php echo $this->reward_point_config->six_months_discount; ?>" />
                        <label>RP</label>
                    </div>
                    </td>
                </tr>
                <tr class="row0">
                    <td>
                    <div><label>Birthday month will x</label>
                        <input type="text" name="birthday_month" size="10" value="<?php echo $this->reward_point_config->birthday_month; ?>" />
                    </div>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>

<!-- Hidden Fields --> <input type="hidden" name="task" value="save" /> <input
	type="hidden" name="option" value="com_virtuemart" /> <input
	type="hidden" name="view" value="reward_point_config" />
	<input type="hidden" name="reward_point_config_id" value="<?php echo $this->reward_point_config->id; ?>" />
<?php
echo JHTML::_ ( 'form.token' );
?>
</form>
<?php
AdminUIHelper::endAdminArea ();
?>
