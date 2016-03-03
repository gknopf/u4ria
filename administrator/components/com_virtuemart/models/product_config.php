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
class VirtueMartModelProduct_Config extends JModel {

    function getProductConfig() {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__virtuemart_product_configs WHERE 1";
        $db->setQuery($query);
        $config = $db->loadObject();
        if(empty($config)){
            $db = JFactory::getDBO();
            $query = "INSERT INTO u4ria_virtuemart_product_configs VALUES('','top50.jpg','top100.jpg','highly.jpg','videodemo.jpg','Watermark.gif','100','1', '0')";
            $db->setQuery($query);
            $db->query();
        }
        return $config;
    }

    function updateConfigNameAttribute($field1,$field2,$field3,$field4) {
        $db = JFactory::getDBO();
        $query = "UPDATE #__virtuemart_product_configs SET name_attribute1 = '".$field1
                ."', name_attribute2 = '".$field2."', name_attribute3 = '".$field3."', name_attribute4 = '".$field4."'";
//        print_r($query); die();
        $db->setQuery($query);
        $db->query();
//        return  $query;
    }
    function updateConfig($field,$val) {
        $db = JFactory::getDBO();
        $query = "UPDATE #__virtuemart_product_configs SET $field = '$val'";
        $db->setQuery($query);
        $db->query();
//        return  $query;
    }

    function uploadImage($file, $folder) {
        jimport('joomla.filesystem.file');
        $max = ini_get('upload_max_filesize');
//        $module_dir = $params->get( 'dir' );
        $file_type = '*';

//        $user_names = $params->get( 'user_names' );
        $msg = '';


        $high_feature = '/images/high_feature/' . $folder;
        $root_dir = JPATH_ROOT . $high_feature;


        $done = FALSE;

        if (isset($file)) {
            //Clean up filename to get rid of strange characters like spaces etc
            $filename = JFile::makeSafe($file['name']);

            if ($file['size'] > $max)
                $msg = JText::_('ONLY_FILES_UNDER') . ' ' . $max;
            //Set up the source and destination of the file

            $src = $file['tmp_name'];
            $dest = $root_dir . DS . $filename;
            if (JFile::exists($dest)) {
                $newfilename = date("mdHis") . '_' . $filename;
                $dest = $root_dir . DS . $newfilename;
            } else {
                $newfilename = $filename;
            }

            //First check if the file has the right extension, we need jpg only
            if ($file['type'] == $file_type || $file_type == '*') {
                if (JFile::upload($src, $dest)) {

                    //Redirect to a page of your choice
                    $msg = JText::_('FILE_SAVE_AS') . ' ' . $dest;
                    $done = TRUE;
                } else {
                    //Redirect and throw an error message
                    echo $msg = JText::_('ERROR_IN_UPLOAD');
                }
            } else {
                //Redirect and notify user file is not right extension
                $msg = JText::_('FILE_TYPE_INVALID');
            }

            $msg = "<script>alert('" . $msg . "');</script>";
        }
        return $high_feature.'/'.$newfilename;
    }


}

//pure php no closing tag