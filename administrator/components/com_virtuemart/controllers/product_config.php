<?php

defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controller');

if (!class_exists('VmController'))
    require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'vmcontroller.php');

jimport('joomla.filesystem.file');

/**
 * Configuration Controller
 *
 * @package    VirtueMart
 * @subpackage Config
 * @author RickG
 */
class VirtuemartControllerProduct_Config extends VmController {

    /**
     * Method to display the view
     *
     * @access	public
     * @author
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Handle the save task
     *
     * @author RickG
     */
    function addData($file,$field){
        $model = VmModel::getModel('product_config');
        $filename = JFile::makeSafe($file['name']);
        if (!empty($filename)) {
            $ok = $model->uploadImage($filename, $field);
            if (!empty($ok)) {
              $msg =  $model->updateConfig($field,$ok);
            }
        }
    }
    function save($data = 0) {

        $db = JFactory::getDbo();

        $model = VmModel::getModel('product_config');

        $imagePathTop50 = 'images/high_feature/top50/';
        $imagePathTop100 = 'images/high_feature/top100/';
        $imagePathVideodemo = 'images/high_feature/videodemo/';
        $imagePathHighly = 'images/high_feature/highly/';
        $imagePathWatermark = 'images/high_feature/watermark/';

        $top50 = JRequest::getVar('top50', null, 'files', 'array');
        $top100 = JRequest::getVar('top100', null, 'files', 'array');
        $videodemo = JRequest::getVar('videodemo', null, 'files', 'array');
        $highly = JRequest::getVar('highly', null, 'files', 'array');
        $watermark = JRequest::getVar('watermark', null, 'files', 'array');

        $inputtop50 = JRequest::getVar('inputtop50','');
        $inputtop50_path = $imagePathTop50.JRequest::getVar('inputtop50','');

        $inputtop100 = JRequest::getVar('inputtop100','');
        $inputtop100_path = $imagePathTop100.JRequest::getVar('inputtop100','');

        $inputvideodemo = JRequest::getVar('inputvideodemo','');
        $inputvideodemo_path = $imagePathVideodemo.JRequest::getVar('inputvideodemo','');

        $inputimagePathHighly = JRequest::getVar('inputhighly','');
        $inputimagePathHighly_path = $imagePathHighly.JRequest::getVar('inputhighly','');

        $inputimagePathWatermark = JRequest::getVar('inputwatermark','');
        $inputimagePathWatermark_path = $imagePathWatermark.JRequest::getVar('inputwatermark','');
        $nameattribute1 = JRequest::getVar('nameattribute1','');
        $nameattribute2 = JRequest::getVar('nameattribute2','');
        $nameattribute3 = JRequest::getVar('nameattribute3','');
        $nameattribute4 = JRequest::getVar('nameattribute4','');
        $model->updateConfigNameAttribute($nameattribute1, $nameattribute2, $nameattribute3, $nameattribute4);
        
        $filename = JFile::makeSafe($top50['name']);
        if (!empty($filename)) {
            $top50_ok = $model->uploadImage($top50, 'top50');
            if (!empty($top50_ok)) {
              $msg =  $model->updateConfig('top50',$top50_ok);
            }
        }  elseif($inputtop50!='') {
            $msg =  $model->updateConfig('top50',$inputtop50_path);
        }

        $filename = JFile::makeSafe($top100['name']);
        if (!empty($filename)) {
            $top100_ok = $model->uploadImage($top100, 'top100');
            if (!empty($top100_ok)) {
              $msg =  $model->updateConfig('top100',$top100_ok);
            }
        }  elseif($inputtop100!='') {
            $msg =  $model->updateConfig('top100',$inputtop100_path);
        }

        $filename = JFile::makeSafe($videodemo['name']);
        if (!empty($filename)) {
            $videodemo_ok = $model->uploadImage($videodemo, 'videodemo');
            if (!empty($videodemo_ok)) {
              $msg =  $model->updateConfig('videodemo',$videodemo_ok);
            }
        }  elseif($inputvideodemo!='') {
            $msg =  $model->updateConfig('videodemo',$inputvideodemo_path);
        }

        $filename = JFile::makeSafe($highly['name']);
        if (!empty($filename)) {
            $highly_ok = $model->uploadImage($highly, 'highly');
            if (!empty($highly_ok)) {
              $msg =  $model->updateConfig('highly',$highly_ok);
            }
        }  elseif($inputimagePathHighly!='') {
            $msg =  $model->updateConfig('highly',$inputimagePathHighly_path);
        }

        $filename = JFile::makeSafe($watermark['name']);
        if (!empty($filename)) {
            $watermark_ok = $model->uploadImage($watermark, 'watermark');
            if (!empty($watermark_ok)) {
              $msg =  $model->updateConfig('watermark',$watermark_ok);
            }
        }  elseif($inputimagePathWatermark!='') {
            $msg =  $model->updateConfig('watermark',$inputimagePathWatermark_path);
        }

        $watermark_opacity = JRequest::getInt('watermark_opacity');
        if(!empty($watermark_opacity)){
            if($watermark_opacity > 100) $watermark_opacity=100;
            elseif($watermark_opacity<0) $watermark_opacity = 0;
            $msg =  $model->updateConfig('watermark_opacity',$watermark_opacity);
        }
        $watermark_position = JRequest::getVar('watermark_position');

        if(!empty($watermark_position)){

            $msg =  $model->updateConfig('watermark_position',$watermark_position);
        }

        $watermark_action = JRequest::getInt('watermark_action');
        if($watermark_action==1){
            $msg =  $model->updateConfig('watermark_action',$watermark_action);
        }else{
            $msg =  $model->updateConfig('watermark_action',0);
        }

        $freegift_percent_allowed = JRequest::getInt('freegift_percent_allowed');

        if($freegift_percent_allowed > 0){
          $msg =  $model->updateConfig('freegift_percent_allowed',$freegift_percent_allowed);
        }else{
          $msg =  $model->updateConfig('freegift_percent_allowed',0);
        }

        $redir = 'index.php?option=com_virtuemart&view=product_config';
        $this->setRedirect($redir, $msg);
    }

}

//pure php no tag
