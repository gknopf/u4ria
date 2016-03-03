<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_articles_latest
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div style="text-align: center;">
    <img width="70" height="70" src="images/Recent-Viewed.png" alt='Recent Viewed' />
</div>
<ul class="view_recent_product" style="padding: 5px;">
<?php foreach ($list as $item) :  ?>
	<li>
		<a href="<?php echo $item->link; ?>">
			<?php echo $item->product->product_name; ?></a>
	</li>
<?php endforeach; ?>
</ul>