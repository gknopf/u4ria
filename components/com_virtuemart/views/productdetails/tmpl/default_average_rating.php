<?php defined ('_JEXEC') or die('Restricted access'); ?>

<?php $fivestar = get5RatingByProduct($this->product->virtuemart_product_id) ?>

<?php foreach ($fivestar as $key => $value) : 
    $totalvote += $value->ratingcount*$value->rate;
    $totalrate += $value->ratingcount;
endforeach; ?>

<?php $isDisabled = getIp($this->product->virtuemart_product_id, $_SERVER['REMOTE_ADDR']); ?>
<div class="average-rating">
    <?php if(!$totalrate) $totalrate=0 ?> 
    <span class="average_lable">Average Rating: </span>
    <div class="allrate" data-average="<?php echo $totalvote/$totalrate ?>" data-id="<?php echo $this->product->virtuemart_product_id ?>"></div>
    <span class="total_vote">(<?php echo $totalrate ?> votes)</span>
</div>

<div class="serverResponse">
    <?php if ($isDisabled == 'false'): ?>
    <div class="average_detail" style="display: none;">
    <?php else : ?>
    <div class="average_detail" >
    <?php endif; ?>
        <?php if(empty($fivestar)): ?>        
                        <div class="star  s5">
                        <span class="slb ccs_1 lb5">5 stars</span>
                        <span class="star_average">
                                <span class="srar_percent_5"><span style="width: 0px;"></span></span>                
                        </span>
                        <span class="num_rate_5">0</span></div>

                        <div class="star  s4">
                        <span class="slb ccs_0 lb4">4 stars</span>
                        <span class="star_average">
                                <span class="srar_percent_4"><span style="width: 0px;"></span></span>                
                        </span>
                        <span class="num_rate_4">0</span></div>

                        <div class="star  s3">
                        <span class="slb ccs_0 lb3">3 stars</span>
                        <span class="star_average">
                                <span class="srar_percent_3"><span style="width: 0px;"></span></span>                
                        </span>
                        <span class="num_rate_3">0</span></div>

                                <div class="star  s2">
                        <span class="slb ccs_0 lb2">2 stars</span>
                        <span class="star_average">
                                <span class="srar_percent_2"><span style="width: 0px;"></span></span>                
                        </span>
                        <span class="num_rate_2">0</span></div>

                        <div class="star  s1">
                        <span class="slb ccs_0 lb1">1 stars</span>
                        <span class="star_average">
                                <span class="srar_percent_1"><span style="width: 0px;"></span></span>                
                        </span>
                        <span class="num_rate_1">0</span></div>
                        <div class="clr"></div>
            
       <?php endif; ?>
        <?php foreach ($fivestar as $key => $value) : ?>                
            <div class="star  s<?php echo $value->rate ?>">
                <span class="slb ccs_<?php echo $value->ratingcount ?> lb<?php echo $value->rate ?>"><?php echo $value->rate ?> stars</span>
                <span class="star_average">
                    <?php ?>
                    <span class="srar_percent_<?php echo $value->rate ?>"><span style="width: <?php echo 70 / $totalrate * $value->ratingcount ?>px;"></span></span>                
                </span>
                <span class="num_rate_<?php echo $value->rate ?>"><?php echo $value->ratingcount ?></span>
            </div>
        <?php endforeach; ?>
        <div class="clr"></div> 
    </div>
</div>
<?php
    $lib = JURI::base() . 'components/com_virtuemart/assets/jRating/jquery/';
    $doc = & JFactory::getDocument();
    $doc->addScript($lib . 'jRating.jquery.js');
    $doc->addStyleSheet($lib . 'jRating.jquery.css');
    ?>
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        $j(document).ready(function() {
            $j(".allrate").jRating({
                type: 'small',
                length: 5,
                decimalLength: 1,
                step: true,
                rateMax: 5,
                isDisabled: <?php echo $isDisabled ?>,
                nbRates: 1,
                showRateInfo: true
            });

        });
    </script>
    <?php

    function getIp($product_id, $ip) {
        $db = JFactory::getDBO();
        $q = 'SELECT *
        FROM `#__virtuemart_average_rating_votes` 
        WHERE `virtuemart_product_id` = "' . (int) $product_id . '" 
        AND `lastip` = "' . $ip . '" 
        ';
        $db->setQuery($q);
        $result = $db->loadObject();
        if (empty($result))
            return "false";
        else
            return "true";
    }

    function getVoteByProduct($product_id) {

    $db = JFactory::getDBO();
    $q = 'SELECT * FROM `#__virtuemart_average_rating_votes` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" ';
    $db->setQuery($q);
    return $db->loadObject();
    }

    function getStarVoteByProduct($product_id) {

        $db = JFactory::getDBO();
        $q = 'SELECT `virtuemart_average_rating_vote_id` as ns 
            FROM `#__virtuemart_average_rating_votes` 
            WHERE `virtuemart_product_id` = "' . (int) $product_id . '"         
        ';
        $db->setQuery($q);
        return $db->loadObject();
    }

    function getRatingByProduct($product_id,$rate) {
        $db = JFactory::getDBO();
        $q = 'SELECT * FROM `#__virtuemart_average_ratings` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" AND `rate` = "' . (int) $rate . '"';
        $db->setQuery($q);
        return $db->loadObject();
    }
    
    
    function get5RatingByProduct($product_id) {
        $db = JFactory::getDBO();
        $q = 'SELECT * FROM `#__virtuemart_average_ratings` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" ORDER BY rate DESC ';
        $db->setQuery($q);
        return $db->loadObjectList();
    }