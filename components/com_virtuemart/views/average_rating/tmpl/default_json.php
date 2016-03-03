<?php

defined('_JEXEC') or die('Restricted access');
RatingAction();

function sbug($abc) {
    if ($abc) {
        echo "<pre>";
        print_r($abc);
        echo "</pre>";
    }
    else
        echo "Die";
}

function NewcountProducts() {
    $dbc = JFactory::getDBO();
    $q = "select 	count(c.virtuemart_product_id)
    from #__virtuemart_products as c where c.virtuemart_vendor_id = 1 ";
    $dbc->setQuery($q);
    $count = $dbc->loadResult();
    return $count;
}

function addAverageRating($data) {

    $maxrating = 5;
    $vote = getVoteByProduct($data['idBox']);
    $rating = getRatingByProduct($data['idBox'], $data['rate']);

    if ($data['rate'] < 0) {
        $data['rate'] = 0;
    }
    if ($data['rate'] > ($maxrating + 1)) {
        $data['rate'] = $maxrating;
    }

    $date = JFactory::getDate();
    $today = $date->toMySQL();
    $datavote = new stdClass();
    $datavote->virtuemart_average_rating_vote_id = NULL;
    $datavote->virtuemart_product_id = (int) $data['idBox'];
    $datavote->lastip = $_SERVER['REMOTE_ADDR'];
    $datavote->created_on = $today;

//    if(!empty($vote)){
    $db = JFactory::getDBO();
    $db->insertObject('#__virtuemart_average_rating_votes', $datavote);
//    }
//********************************
    if (!empty($rating)) {
        $data['ratingcount'] = $rating->ratingcount + 1;
    } else {
        if (!empty($rating->rate)) {
            $data['ratingcount'] = $rating->ratingcount;
        } else {
//            $data['rate'] = $data['rate'];
            $data['ratingcount'] = 1;
        }
    }


    if (empty($data['created_on']) || $data['created_on'] == "0000-00-00 00:00:00") {
        $data['created_on'] = $today;
    }

//    $data['virtuemart_average_rating_id'] = empty($rating->virtuemart_average_rating_id) ? null : $rating->virtuemart_average_rating_id;

    $dataRating = new stdClass();
    $dataRating->virtuemart_average_rating_id = null;
    $dataRating->virtuemart_product_id = (int) $data['idBox'];
    $dataRating->rate = $data['rate'];
    $dataRating->ratingcount = $data['ratingcount'];
    $dataRating->published = 1;
    $dataRating->created_on = $data['created_on'];
    $dataRating->modified_on = $today;
    if (empty($rating)) {
        for ($index = 1; $index < 6; $index++) {
            if ($data['rate'] != $index) {
                $dataRating->ratingcount = 0;
                $dataRating->rate = $index;
            } else {
                $dataRating->rate = $index;
                $dataRating->ratingcount = 1;
            }
            $db->insertObject('#__virtuemart_average_ratings', $dataRating);
        }
    } else {
        $qr = 'UPDATE `#__virtuemart_average_ratings` set `ratingcount` = `ratingcount`+1 WHERE `virtuemart_product_id` = "' . $dataRating->virtuemart_product_id . '" AND `rate` = "' . $dataRating->rate . '"';
        $db->setQuery($qr);
        $rs = $db->query();
    }
    return true;
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

function getRatingByProduct($product_id, $rate) {
    $db = JFactory::getDBO();
    $q = 'SELECT * FROM `#__virtuemart_average_ratings` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" AND `rate` = "' . (int) $rate . '"';
    $db->setQuery($q);
    return $db->loadObject();
}

function get5RatingByProduct($product_id) {
    $db = JFactory::getDBO();
    $q = 'SELECT * FROM `#__virtuemart_average_ratings` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" ORDER BY rate DESC';
    $db->setQuery($q);
    return $db->loadObjectList();
}

function RatingAction() {

    $aResponse['error'] = false;
    $aResponse['message'] = '';

    $aResponse['totalrates'] = '';
    $aResponse['rated'] = '';
    $aResponse['allrate'] = '';
    $aResponse['s1'] = '';
    $aResponse['s2'] = '';
    $aResponse['s3'] = '';
    $aResponse['s4'] = '';
    $aResponse['s5'] = '';
    if (isset($_POST['action'])) {
        if (htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'rating') {
            $id = intval($_POST['idBox']);
            $rate = floatval($_POST['rate']);
            $success = true;
            if ($success) {
                $ab = addAverageRating($_POST);

                $rating = get5RatingByProduct($_POST['idBox']);

                $starvote = getStarVoteByProduct($_POST['idBox']);

                $allcount = array();
                $i = 5;
                foreach ($rating as $key => $value) {
                    $allcount[$i] = $value->ratingcount;
                    $ave += $value->ratingcount * $value->rate;
                    $totalrate += $value->ratingcount;
                    if($i==$_POST['rate']) {
                        $numratenow = $value->ratingcount;
                    }
                    $i--;
                }

                $aResponse['message'] = 'Your rate has been successfuly recorded. Thanks for your rate :)';

                $aResponse['totalrates'] .= '(' . $totalrate . ' votes)';
                $aResponse['rated'] .= '' . $numratenow . '';
                $aResponse['allrate'] = $totalrate;
                $aResponse['s1'] = $allcount[1];
                $aResponse['s2'] = $allcount[2];
                $aResponse['s3'] = $allcount[3];
                $aResponse['s4'] = $allcount[4];
                $aResponse['s5'] = $allcount[5];

                echo json_encode($aResponse);
            } else {
                $aResponse['error'] = true;
                $aResponse['message'] = '';

                $aResponse['totalrates'] = '';
                $aResponse['rated'] = '';
                $aResponse['allrate'] = '';
                $aResponse['s1'] = '';
                $aResponse['s2'] = '';
                $aResponse['s3'] = '';
                $aResponse['s4'] = '';
                $aResponse['s5'] = '';


                echo json_encode($aResponse);
            }
        } else {
            $aResponse['error'] = true;
            $aResponse['message'] = '';

            $aResponse['totalrates'] = '';
            $aResponse['rated'] = '';
            $aResponse['allrate'] = '';
            $aResponse['s1'] = '';
            $aResponse['s2'] = '';
            $aResponse['s3'] = '';
            $aResponse['s4'] = '';
            $aResponse['s5'] = '';


            echo json_encode($aResponse);
        }
    } else {
        $aResponse['error'] = true;
        $aResponse['message'] = '';

        $aResponse['totalrates'] = '';
        $aResponse['rated'] = '';
        $aResponse['allrate'] = '';
        $aResponse['s1'] = '';
        $aResponse['s2'] = '';
        $aResponse['s3'] = '';
        $aResponse['s4'] = '';
        $aResponse['s5'] = '';


        echo json_encode($aResponse);
    }
}