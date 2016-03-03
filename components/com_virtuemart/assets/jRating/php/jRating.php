<?php


define('DS', DIRECTORY_SEPARATOR);
$aResponse['error'] = false;
$aResponse['message'] = '';

// ONLY FOR THE DEMO, YOU CAN REMOVE THIS VAR
$aResponse['server'] = '';
// END ONLY FOR DEMO


if (isset($_POST['action'])) {
    if (htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'rating') {
        /*
         * vars
         */
        $id = intval($_POST['idBox']);
        $rate = floatval($_POST['rate']);



        // if request successful
        $success = true;
        // else $success = false;
        // json datas send to the js file
        if ($success) {
            $aResponse['message'] = 'Your rate has been successfuly recorded. Thanks for your rate :)';

            // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
            $aResponse['server'] = '<strong>Success answer :</strong> Success : Your rate has been recorded. Thanks for your rate :)<br />';
            $aResponse['server'] .= '<strong>Rate received :</strong> ' . $rate . '<br />';
            $aResponse['server'] .= '<strong>ID to update :</strong> ' . $id;
            // END ONLY FOR DEMO

            echo json_encode($aResponse);
        } else {
            $aResponse['error'] = true;
            $aResponse['message'] = 'An error occured during the request. Please retry';

            // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
            $aResponse['server'] = '<strong>ERROR :</strong> Your error if the request crash !';
            // END ONLY FOR DEMO


            echo json_encode($aResponse);
        }
    } else {
        $aResponse['error'] = true;
        $aResponse['message'] = '"action" post data not equal to \'rating\'';

        // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
        $aResponse['server'] = '<strong>ERROR :</strong> "action" post data not equal to \'rating\'';
        // END ONLY FOR DEMO


        echo json_encode($aResponse);
    }
} else {
    $aResponse['error'] = true;
    $aResponse['message'] = '$_POST[\'action\'] not found';

    // ONLY FOR THE DEMO, YOU CAN REMOVE THE CODE UNDER
    $aResponse['server'] = '<strong>ERROR :</strong> $_POST[\'action\'] not found';
    // END ONLY FOR DEMO


    echo json_encode($aResponse);
}

function NewcountProducts() {

    $dbc = JFactory::getDBO();
    $vendorId = 1;
    if ($cat_id_list != '') {
        $q = 'SELECT count(#__virtuemart_products.virtuemart_product_id) AS total
                                                FROM `#__virtuemart_products`, `#__virtuemart_product_categories`
                                                WHERE `#__virtuemart_products`.`virtuemart_vendor_id` = 1"
                                                AND `#__virtuemart_product_categories`.`virtuemart_category_id` = 80
                                                AND `#__virtuemart_products`.`virtuemart_product_id` = `#__virtuemart_product_categories`.`virtuemart_product_id`
                                                AND `#__virtuemart_products`.`published` = "1" ';
        $dbc->setQuery($q);
        $count = $dbc->loadResult();
    }
    else
        $count = 0;

    return $count;
}