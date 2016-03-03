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
class VirtueMartModelUser_Level extends JModel
{

  function getAll()
  {
      $query = "SELECT * FROM #__virtuemart_user_level WHERE 1";

      $db = JFactory::getDBO();
      $db->setQuery($query);

      return $db->loadObjectList();
  }

  function update($id, $data)
  {
    $db = JFactory::getDBO();
    $query = 'UPDATE #__virtuemart_user_level '
           . 'SET min_amount = ' . (int)$data['min_amount'] . ', max_amount = ' . (int)$data['max_amount'] . ', discount = ' . (int)$data['discount'] . ', duration = ' . (int)$data['duration'] . ' '
           . 'WHERE id = ' . (int)$id;

    $db->setQuery($query);
    $db->query();
  }
  
    function getAllSorted(){
      $query = "SELECT * FROM #__virtuemart_user_level ORDER BY min_amount DESC";

      $db = JFactory::getDBO();
      $db->setQuery($query);

      return $db->loadObjectList();
  }
  function getLevelTypeByLevelId($levelId){
      $query = "SELECT * FROM #__virtuemart_user_level where id = ".$levelId;

      $db = JFactory::getDBO();
      $db->setQuery($query);

      return $db->loadObjectList();
  }
}

//pure php no closing tag