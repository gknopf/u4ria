<?php

defined ('_JEXEC') or die('Restricted access');

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
    $rating = getRatingByProduct($data['idBox']);
//    sbug($rating);
//    $data['virtuemart_average_rating_vote_id'] = empty($vote->virtuemart_average_rating_vote_id) ? 0 : $vote->virtuemart_average_rating_vote_id;

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
    $datavote->vote = (int) $data['rate'];
    $datavote->lastip = $_SERVER['REMOTE_ADDR'];
    $datavote->created_on = $today;


    $db = JFactory::getDBO();
    $db->insertObject('#__virtuemart_average_rating_votes', $datavote);


//********************************
//    if (!empty($rating->rates) && empty($vote)) {
    if (!empty($rating->rates)) {
        $data['rates'] = $rating->rates + $data['rate'];
        $data['ratingcount'] = $rating->ratingcount + 1;
    } else {
//        if (!empty($rating->rates) && !empty($vote->vote)) {
        if (!empty($rating->rates)) {
            $data['rates'] = $rating->rates - $vote->vote + $data['rate'];
            $data['ratingcount'] = $rating->ratingcount;
        } else {
            $data['rates'] = $data['rate'];
            $data['ratingcount'] = 1;
        }
    }

    if (empty($data['rates']) || empty($data['ratingcount'])) {
        $data['rating'] = 0;
    } else {
        $data['rating'] = $data['rates'] / $data['ratingcount'];
    }
//    if (empty($data['created_on'])) {
//        $data['created_on'] = $today;
//    }
    if (empty($data['created_on']) || $data['created_on'] == "0000-00-00 00:00:00") {
        $data['created_on'] = $today;
    }

    $data['virtuemart_average_rating_id'] = empty($rating->virtuemart_average_rating_id) ? 0 : $rating->virtuemart_average_rating_id;

    $dataRating = new stdClass();
    $dataRating->virtuemart_average_rating_id = null;
    $dataRating->virtuemart_product_id = (int) $data['idBox'];
    $dataRating->rates = $data['rates'];
    $dataRating->ratingcount = $data['ratingcount'];
    $dataRating->rating = $data['rating'];
    $dataRating->published = 1;
    $dataRating->created_on = $data['created_on'];
    $dataRating->modified_on = $today;
    if (empty($data['virtuemart_average_rating_id']))
        $db->insertObject('#__virtuemart_average_ratings', $dataRating);
    else {
        $db->updateObject('#__virtuemart_average_ratings', $dataRating, 'virtuemart_product_id', false);
    }
//    
    return true;
}

function getVoteByProduct($product_id) {

    $db = JFactory::getDBO();
    $q = 'SELECT * FROM `#__virtuemart_average_rating_votes` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" ';
    $db->setQuery($q);
    return $db->loadObject();
}

function getStarVoteByProduct($product_id, $star) {

    $db = JFactory::getDBO();
    $q = 'SELECT count(`virtuemart_average_rating_vote_id`) as ns 
        FROM `#__virtuemart_average_rating_votes` 
        WHERE `virtuemart_product_id` = "' . (int) $product_id . '" 
        AND vote = "' . (int) $star . '" 
    ';
    $db->setQuery($q);
    return $db->loadObject();
}

function getRatingByProduct($product_id) {
    $db = JFactory::getDBO();
    $q = 'SELECT * FROM `#__virtuemart_average_ratings` WHERE `virtuemart_product_id` = "' . (int) $product_id . '" ';
    $db->setQuery($q);
    return $db->loadObject();
}

function RatingAction() {

    $aResponse['error'] = false;
    $aResponse['message'] = '';

// ONLY FOR THE DEMO, YOU CAN REMOVE THIS VAR
    $aResponse['totalrates'] = '';
    $aResponse['rated'] = '';
    $aResponse['allrate'] = '';
    $aResponse['s1'] = '';
    $aResponse['s2'] = '';
    $aResponse['s3'] = '';
    $aResponse['s4'] = '';
    $aResponse['s5'] = '';
// END ONLY FOR DEMO


    if (isset($_POST['action'])) {
        if (htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'rating') {
            /*
             * vars
             */
            $id = intval($_POST['idBox']);
            $rate = floatval($_POST['rate']);



            $success = true;
            // else $success = false;
            // json datas send to the js file
            if ($success) {
                
                $ab = addAverageRating($_POST);

                $rating = getRatingByProduct($_POST['idBox']);

                $starvote = getStarVoteByProduct($_POST['idBox'], $_POST['rate']);
                $allcount = array();
                for ($index = 5; $index > 0; $index--) :
                    if ($_POST['rate'] == $index) {
                        $allcount[$index] = $starvote->ns;
                    } else {
                        $allcount[$index] = getStarVoteByProduct($_POST['idBox'], $index)->ns;
                    }
                endfor;
                $aResponse['message'] = 'Your rate has been successfuly recorded. Thanks for your rate :)';

                // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
                $aResponse['totalrates'] .= '(' . $rating->ratingcount . ' votes)';
                $aResponse['rated'] .= '' . $starvote->ns . '';
                $aResponse['allrate'] = $rating->ratingcount;
                $aResponse['s1'] = $allcount[1];
                $aResponse['s2'] = $allcount[2];
                $aResponse['s3'] = $allcount[3];
                $aResponse['s4'] = $allcount[4];
                $aResponse['s5'] = $allcount[5];
                // END ONLY FOR DEMO

                echo json_encode($aResponse);
            } else {
                $aResponse['error'] = true;
//                $aResponse['message'] = 'An error occured during the request. Please retry';
                $aResponse['message'] = '';

                // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
                $aResponse['totalrates'] = '';
                $aResponse['rated'] = '';
                $aResponse['allrate'] = '';
                $aResponse['s1'] = '';
                $aResponse['s2'] = '';
                $aResponse['s3'] = '';
                $aResponse['s4'] = '';
                $aResponse['s5'] = '';
                // END ONLY FOR DEMO


                echo json_encode($aResponse);
            }
        } else {
            $aResponse['error'] = true;
//            $aResponse['message'] = '"action" post data not equal to \'rating\'';
            $aResponse['message'] = '';

            // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
            $aResponse['totalrates'] = '';
            $aResponse['rated'] = '';
            $aResponse['allrate'] = '';
            $aResponse['s1'] = '';
            $aResponse['s2'] = '';
            $aResponse['s3'] = '';
            $aResponse['s4'] = '';
            $aResponse['s5'] = '';
            // END ONLY FOR DEMO


            echo json_encode($aResponse);
        }
    } else {
        $aResponse['error'] = true;
//        $aResponse['message'] = '$_POST[\'action\'] not found';
        $aResponse['message'] = '';

        // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
        $aResponse['totalrates'] = '';
        $aResponse['rated'] = '';
        $aResponse['allrate'] = '';
        $aResponse['s1'] = '';
        $aResponse['s2'] = '';
        $aResponse['s3'] = '';
        $aResponse['s4'] = '';
        $aResponse['s5'] = '';
        // END ONLY FOR DEMO


        echo json_encode($aResponse);
    }
}