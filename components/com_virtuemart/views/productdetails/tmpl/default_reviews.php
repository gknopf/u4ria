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
defined('_JEXEC') or die('Restricted access');

// Customer Reviews
if ($this->allowRating || $this->showReview) {
    $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);
    $ratingsShow = VmConfig::get('vm_num_ratings_show', 5); // TODO add  vm_num_ratings_show in vmConfig
    $stars = array();
    $showall = JRequest::getBool('showall', 0);
    $ratingWidth = $maxrating * 15;
    for ($num = 0; $num <= $maxrating; $num++) {
        $stars[] = '
				<span title="' . (JText::_("COM_VIRTUEMART_RATING_TITLE") . $num . '/' . $maxrating) . '" class="vmicon ratingbox" style="display:inline-block;width:' . 15 * $maxrating . 'px;">
					<span class="stars-orange" style="width:' . (15 * $num) . 'px">
					</span>
				</span>';
    }
    ?>

<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>



    <div class="customer-reviews">
        <form method="post" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id); ?>" name="reviewForm" id="reviewform">
            <?php
        }

        if ($this->showReview) {
            ?>
            <div class="cus_view">
                <h4><?php echo JText::_('COM_VIRTUEMART_REVIEWS') ?></h4>
                <?php if ($this->showRating): ?>
                    <?php $maxrating = VmConfig::get('vm_maximum_rating_scale', 5); ?>
                    <?php if (empty($this->rating)): ?>
                        <span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                    <?php else: ?>
                        <?php $ratingwidth = $this->rating->rating * 15; ?>
                        <span class="vote">
                        <?php echo $this->product->product_name; ?>
                            <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($this->rating->rating) . '/' . $maxrating) ?>" class="ratingbox" style="display:inline-block;margin-left: 10px;">
                            <span class="stars-orange" style="width:<?php echo $ratingwidth . 'px'; ?>"></span>
                        </span>
                        <span>(<?php echo $this->rating->ratingcount; ?> reviews)</span>
                    </span>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="order_by">
                    <?php
                    $uri = JURI::getInstance();
                    $uri->setVar('review_order', 0);
                    $newest_uri = $uri->toString();
                    $uri->setVar('review_order', 1);
                    $top_rating_uri = $uri->toString();
                    ?>
                    <span>
                    Order by: <a href="<?php echo $newest_uri; ?>#product_review" class="newest_top <?php if ($this->review_order == 1): echo 'un_sorted';
                        endif; ?>">Newest</a> |
                    <a href="<?php echo $top_rating_uri; ?>#product_review" class="newest_top <?php if ($this->review_order == 0): echo 'un_sorted';
                    endif; ?>">Top Rated</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php if ($this->allowReview) { ?>
                            Click <a href="<?php echo JURI::current() ?>#write-reviews" class="click_here">HERE</a> to add your review to earn $50 voucher
                        <?php }?>
                </span>
                </div>
            </div>
            <div class="average_review">
                <div class="average_review_title">Average Customer Review:</div>
                <div class="serverResponse">
                    <div class="average_detail">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <div class="star  s<?php echo $i; ?>">
                                <span class="slb <?php if (isset($this->average_reviews[$i])): echo 'ccs_1';
                    else: echo 'ccs_0';
                    endif; ?> lb<?php echo $i; ?>"><?php echo $i; ?> stars</span>
                                <span class="star_average">
                                    <span class="srar_percent_<?php echo $i; ?>">
                                        <span style="width: <?php if (isset($this->average_reviews[$i])): echo $this->average_reviews[$i]['percent'];
                    else: echo '0';
                    endif; ?>px;"></span>
                                    </span>
                                </span>
                                <span class="num_rate_<?php echo $i; ?>">
        <?php if (isset($this->average_reviews[$i])): echo $this->average_reviews[$i]['count'];
        else: echo '0';
        endif; ?>
                                </span>
                            </div>
                <?php endfor; ?>
                        <div class="clr"></div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
            <div class="list-reviews">
                <?php
                $i = 0;
                $review_editable = TRUE;
                $reviews_published = 0;
                if ($this->rating_reviews) {
                    foreach ($this->rating_reviews as $review) {
// 				if ($i % 2 == 0) {
// 					$color = 'normal';
// 				} else {
// 					$color = 'highlight';
// 				}

                        /* Check if user already commented */
                        // if ($review->virtuemart_userid == $this->user->id ) {
//				if ($review->created_by == $this->user->id && !$review->review_editable) {
//					$review_editable = FALSE;
//				}
                        ?>

            <?php
            // Loop through all reviews
            if (!empty($this->rating_reviews) && $review->published) {
                $reviews_published++;
                ?>
                            <div id="review_<?php echo $review->virtuemart_rating_review_id; ?>" class="normal review_box">
                                <div class="comment_title">
                                    <span><?php echo $review->comment_title; ?></span>
                                    <div class="comment_info">Reviewed:  <span class="hight"><?php echo JHTML::date($review->created_on, JText::_('DATE_FORMAT_LC')); ?></span> by <span class="hight"><?php echo $review->customer ?></span></div>
                                </div>
                                <div class="vote"><?php echo $stars[(int) $review->vote]; ?></div>
                                <div class="comment_content"><?php echo $review->comment; ?></div>
                            </div>
                            <?php
                        }
                        $i++;
                        if ($i == $ratingsShow && !$showall) {
                            /* Show all reviews ? */
                            if ($reviews_published >= $ratingsShow) {
                                $uri = JURI::getInstance();
                                $uri->setVar('showall', 1);
                                $more_reviews = $uri->toString();

                                $attribute = array('class' => 'view_review_all', 'title' => JText::_('COM_VIRTUEMART_MORE_REVIEWS'));
                                echo JHTML::link($more_reviews . '#product_review', ' See all ' . count($this->rating_reviews) . ' customer reviews', $attribute);
                            }
                            break;
                        }
                    }

                    if ($reviews_published >= $ratingsShow && $showall) {
                        $uri = JURI::getInstance();
                        $uri->setVar('showall', 0);
                        $see_less = $uri->toString();

                        $attribute = array('class' => 'view_review_all un_sorted', 'title' => 'See less customer reviews');
                        echo JHTML::link($see_less . '#product_review', ' See all ' . count($this->rating_reviews) . ' customer reviews', $attribute);
                    }
                } else {
                    // "There are no reviews for this product"
                    ?>
                    <span class="step"><?php echo JText::_('COM_VIRTUEMART_NO_REVIEWS') ?></span>
                <?php }
            ?>
                <div class="clear"></div>
            </div>
                <?php
                // Writing A Review
                //print_r($review_editable);die;
                if ($this->allowReview) {
                    ?>
                <div class="write-reviews" id="write-reviews">

                    <?php
                    // Show Review Length While Your Are Writing
                    $reviewJavascript = "
			function check_reviewform() {
				var form = document.getElementById('reviewform');

				var ausgewaehlt = false;

				// for (var i=0; i<form.vote.length; i++) {
					// if (form.vote[i].checked) {
						// ausgewaehlt = true;
					// }
				// }
					// if (!ausgewaehlt)  {
						// alert('" . JText::_('COM_VIRTUEMART_REVIEW_ERR_RATE', FALSE) . "');
						// return false;
					// }
					//else

				  if (form.comment_title.value.length < " . VmConfig::get('reviews_minimum_comment_title_length', 1) . ") {
						alert('" . addslashes('Please input review title!') . "');
						return false;
					}
					else if (form.comment_title.value.length > " . VmConfig::get('reviews_maximum_comment_title_length', 100) . ") {
						alert('" . addslashes('Review title max ' . VmConfig::get('reviews_maximum_comment_title_length', 100)) . " characters');
						return false;
					}


					if (form.comment.value.length < " . VmConfig::get('reviews_minimum_comment_length', 100) . ") {
						alert('" . addslashes(JText::sprintf('COM_VIRTUEMART_REVIEW_ERR_COMMENT1_JS', VmConfig::get('reviews_minimum_comment_length', 100))) . "');
						return false;
					}
					else if (form.comment.value.length > " . VmConfig::get('reviews_maximum_comment_length', 2000) . ") {
						alert('" . addslashes(JText::sprintf('COM_VIRTUEMART_REVIEW_ERR_COMMENT2_JS', VmConfig::get('reviews_maximum_comment_length', 2000))) . "');
						return false;
					}
					else {
						return true;
					}


				}

				function refresh_counter() {
					var form = document.getElementById('reviewform');
					form.counter.value= form.comment.value.length;
				}
                                jQuery.noConflict();
                                jQuery(function($) {
					var steps = " . $maxrating . ";
					var parentPos= $('.write-reviews .ratingbox').position();
					var boxWidth = $('.write-reviews .ratingbox').width();// nbr of total pixels
					var starSize = (boxWidth/steps);
					var ratingboxPos= $('.write-reviews .ratingbox').offset();

					$('.write-reviews .ratingbox').mousemove( function(e){
						var span = $(this).children();
						var dif = e.pageX-ratingboxPos.left; // nbr of pixels
						difRatio = Math.floor(dif/boxWidth* steps )+1; //step

						if (difRatio == 0) {
						  difRatio = 1;
	          }

						span.width(difRatio*starSize);
						$('#vote').val(difRatio);
            $(this).attr('title','" . JText::_("COM_VIRTUEMART_RATING_TITLE") . "'+difRatio+'/'+ steps);

						//console.log('note = ', difRatio);
					});
				});




				";
                    $document = JFactory::getDocument();
                    $document->addScriptDeclaration($reviewJavascript);

                    if ($this->showRating) {
                        if ($this->allowRating && $review_editable) {
                            ?>
                            <h4 ><?php echo JText::_('COM_VIRTUEMART_WRITE_REVIEW') ?></h4>
                            <span class="step"><?php echo JText::_('COM_VIRTUEMART_RATING_FIRST_RATE') ?> </span>
                            <div class="rating">
                                <label for="vote"><?php echo $stars[$maxrating]; ?></label>
                                <input type="hidden" id="vote" value="<?php echo $maxrating ?>" name="vote">

                            </div>

                <?php
            }
        }
        if ($review_editable) {
            ?>
                        <br/>
                        <div class="comment_form_wapper">
                            <span class="step title_review">Review Title: </span>
                            <br/>
                            <input type="text" value="<?php echo $this->review->comment_title; ?>" name="comment_title" class="vm-default" id="comment_title" >
                            <br/><br/>
                            <span class="step title_review"><?php echo JText::sprintf('COM_VIRTUEMART_REVIEW_COMMENT', VmConfig::get('reviews_minimum_comment_length', 100), VmConfig::get('reviews_maximum_comment_length', 2000)); ?></span>
                            <br/>
                            <textarea class="virtuemart" title="<?php echo JText::_('COM_VIRTUEMART_WRITE_REVIEW') ?>" class="inputbox" id="comment" onblur="refresh_counter();" onfocus="refresh_counter();" onkeyup="refresh_counter();" name="comment" rows="8" cols="60"><?php
                            if (!empty($this->review->comment)) {
                                echo $this->review->comment;
                            }
                            ?></textarea>
                            <br/>
                            <?php
                                JPluginHelper::importPlugin('captcha');
                                $dispatcher = JDispatcher::getInstance();
                                $dispatcher->trigger('onInit','dynamic_recaptcha_1');

//html code inside form tag


# are we submitting the page?

                            
                            ?>
<dt><br/>
                                        <label style="color: #B60D9D; font-weight: bold">Security check : </label>
                                        <label>Your privacy is important to us, we DO NOT rent, sell or reveal your personal infomation to 3rd parties. To learn more, read our privacy <a style="color: #B00C97;" href="index.php?option=com_content&view=article&id=17&Itemid=142">policy page</a>.</label>
                                        </dt> <br/>
                            <div id="dynamic_recaptcha_1"></div>
                            <span class="submit_wapper">
                                <input class="submit_review" type="submit" onclick="return(check_reviewform());" name="submit_review" title="<?php echo JText::_('COM_VIRTUEMART_REVIEW_SUBMIT') ?>" value="<?php echo JText::_('COM_VIRTUEMART_REVIEW_SUBMIT') ?>"/>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo JText::_('COM_VIRTUEMART_REVIEW_COUNT') ?>
                                <input type="text" value="0" size="4" class="vm-default review_counter" name="counter" maxlength="4" readonly="readonly"/>
                            </span>
                            <br/>
                            <br/>
                        </div>
                    <?php
                } else {
                    echo '<strong>' . JText::_('COM_VIRTUEMART_DEAR') . $this->user->name . ',</strong><br />';
                    echo JText::_('COM_VIRTUEMART_REVIEW_ALREADYDONE');
                }
                ?></div><?php
            }
        }

        if ($this->allowRating || $this->showReview) {
            ?>
            <input type="hidden" name="virtuemart_product_id" value="<?php echo $this->product->virtuemart_product_id; ?>"/>
            <input type="hidden" name="option" value="com_virtuemart"/>
            <input type="hidden" name="virtuemart_category_id" value="<?php echo JRequest::getInt('virtuemart_category_id'); ?>"/>
            <input type="hidden" name="virtuemart_rating_review_id" value="0"/>
            <input type="hidden" name="task" value="review"/>
        </form>
    </div>
    <?php
}
