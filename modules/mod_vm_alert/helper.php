<?php

class ModAlertHelper {

    public function CountAllProduct() {
        $uid = JFactory::getUser()->id;
        $db = JFactory::getDBO();
        $query = "  SELECT count(virtuemart_product_id) as number FROM #__virtuemart_products_alert
                    WHERE user_id=$uid";
        $db->setQuery($query);
        return $db->loadResult();
    }

}

?>
