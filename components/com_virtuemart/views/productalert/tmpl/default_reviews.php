<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_reviews.php 6300 2012-07-26 00:40:10Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die ('Restricted access');
?>
<div>
<?php
		if ($value->review) {
			foreach ($value->review as $review) {
				?>

				<?php // Loop through all reviews
				if (!empty($this->rating_reviews) && $review->published) {
					$reviews_published++;
					?>
					<div class="normal review_box">
            <div class="comment_title">
              <span><?php echo $review->comment_title; ?></span>
              <div class="comment_info">Reviewed:  <span class="hight"><?php echo JHTML::date ($review->created_on, JText::_ ('DATE_FORMAT_LC')); ?></span> by <span class="hight"><?php echo $review->customer ?></span></div>
            </div>
						<div class="vote"><?php echo $stars[(int)$review->vote] ; ?></div>
						<div class="comment_content"><?php echo $review->comment; ?></div>
					</div>
					<?php
				}
				$i++;
			}

		} else {
			// "There are no reviews for this product"
			?>
			<span class="step"><?php echo JText::_ ('COM_VIRTUEMART_NO_REVIEWS') ?></span>
			<?php
		}  ?>
		<div class="clear"></div>
	</div>
