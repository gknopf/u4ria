<?php

defined('_JEXEC') or die('Restricted access');

// Load the model framework
if (!class_exists('JModel'))
    require JPATH_VM_LIBRARIES . DS . 'joomla' . DS . 'application' . DS . 'component' . DS . 'model.php';

/**
 * Model class for shop configuration
 *
 * @package	VirtueMart
 * @subpackage Config
 * @author Max Milbers
 * @author RickG
 */
class VirtueMartModelTop_Compare extends JModel {

    function insertRecord($product_id, $product_compare_id) {
        $db = JFactory::getDBO();
        $q = "INSERT INTO `#__virtuemart_top_compare` (`product_id`, `product_compare_id`, `count`) VALUES (" . $product_id . ',' . $product_compare_id . ', 1)';
        $db->setQuery($q);
        $db->query();
    }

    function updateCount($product_id, $product_compare_id) {
      $db = JFactory::getDBO();
      $query = 'UPDATE #__virtuemart_top_compare SET `count` = `count` + 1 '
             . 'WHERE (product_id = ' . $product_id . ' AND product_compare_id = ' . $product_compare_id . ') '
             . 'OR (product_id = '. $product_compare_id .' AND product_compare_id = ' . $product_id .')';

      $db->setQuery($query);
      $db->query();
    }

    function isExists($product_id, $product_compare_id) {
        $db = JFactory::getDBO();
        $query = 'SELECT COUNT(*) AS number FROM #__virtuemart_top_compare '
               . 'WHERE (product_id = ' . $product_id . ' AND product_compare_id = ' . $product_compare_id . ') '
               . 'OR (product_id = '. $product_compare_id .' AND product_compare_id = ' . $product_id .')';

        $db->setQuery($query);
        $result = $db->loadObject();

        if ($result && $result->number > 0) {
          return TRUE;
        } else {
          return FALSE;
        }
    }

    function getTopCompare($product_id, $number)
    {
      $db = JFactory::getDBO();
      $query = 'SELECT * FROM #__virtuemart_top_compare '
             . 'WHERE product_id = ' . $product_id . ' OR product_compare_id = ' . $product_id . ' '
             . 'ORDER BY count DESC LIMIT 0, ' . $number;

      $db->setQuery($query);
      $result = $db->loadObjectList();

      return $result;
    }
}
