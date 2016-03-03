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
        <legend>Freegift Percent Allowed</legend>
        <div class="product_config">
            <table class="adminform">
                <tr class="row1">
                    <label>Free Gift percent allowed:</label>
                    <input type="text" name="freegift_percent_allowed" value="<?php echo $this->productconfig->freegift_percent_allowed; ?>">
                    <label>%</label>
                </tr>
            </table>
        </div>
    </fieldset>