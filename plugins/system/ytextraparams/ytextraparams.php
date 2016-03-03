<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemYtExtraParams extends JPlugin {
	var $_menuid = 0;
	var $_resources = '';
	function plgSystemYtExtraParams(&$subject, $pluginconfig) {
		parent::__construct($subject, $pluginconfig);
		$this->_resources = $this->_getUrl('ytextraparams/xml/');
	}
	function onAfterRender() {
		$app = JFactory::getApplication();
		$option	= JRequest::getVar('option','');
		$task	= JRequest::getVar('task','');
		
		if($app->isAdmin()){
			if ($option=='com_menus' && $task=='edit'){
				$xmlSource = $this->_resources . 'menus_edit_params15.xml';
				$this->_menuid = JRequest::getVar("cid", null,null,"array");
				$body = JResponse::getBody();
				$body = $this->appendExtraParams($body, $xmlSource);
				$content = ob_get_clean ();
				if(!empty($content))
				{
					$body = preg_replace ( '/<\/body>/', $content . "\n</body>", $body );
				}
				JResponse::setBody ( $body );
			}					
		}
	}
	
	function appendExtraParams($bodyContent, $xml) {		
		//$xml = dirname(__FILE__). DS."ytmenu" . DS . 'params' . DS ."params.xml";
		if( !file_exists($xml) ){
			return $bodyContent;
		}
		
		$extraHtml = $this->getYtExtraParams($xml);
		preg_match_all("/<div class=\"panel\">([\s\S]*?)<\/div>/i", $bodyContent, $arr);

		$bodyContent = str_replace($arr[0][count($arr[0])-1].'</div>', $arr[0][count($arr[0])-1].'</div>'.$extraHtml, $bodyContent);
		return $bodyContent;
	}
	function getYtExtraParams($xmlfile = "") {
		$html_content = "";
		
		$paramObjFromXml =  new JParameter('', $xmlfile);
		$label = "Parameters (Yt Extra Params)";
			
		if(isset($paramObjFromXml->_xml["params"]))
		{
			$label = $paramObjFromXml->_xml["params"]->_attributes["label"];
			$paramObjFromXml = $this->bindSetValues( $paramObjFromXml );
		}
		ob_start ();
		echo $paramObjFromXml->render('params', 'params');
		$html_content = ob_get_clean ();
		ob_start ();
		
		$html_content = '<div class="panel">
				<h3 id="yt-extra-params" class="jpane-toggler title" style="color: #0D9FC4;">
				<span>'.JText::_($label).'</span></h3>
				<div class="jpane-slider content" style="border-top: medium none; border-bottom: medium none; overflow: hidden; padding-top: 0px; padding-bottom: 0px;">
				'.$html_content."</div></div>";
		
		return $html_content;
	}
	
	function bindSetValues( $ext_params = null ) {
		if(!empty($this->_menuid)) {
			if(is_array($this->_menuid)){
				$menuid =$this->_menuid[0];
			} else {	
				$menuid = $this->_menuid;
			}
			$db	=& JFactory::getDBO();
			$query = "SELECT params FROM #__menu WHERE id = ".$menuid;
			$db->setQuery($query);
			$row = $db->loadObject();
			
			if(!empty($row)) {
				$params	= new JParameter($row->params);
				$list_params = $ext_params->renderToArray("params", "params");
			
				foreach($list_params as $key=>$value) {
					if(!empty($key) && strpos($key, "ytext_" ) !== false) {
						$tmp_value = $params->get( $key, "" );
						if(is_array($tmp_value)){
							$tmp_value = implode("|",$tmp_value);
						}
						$ext_params->set($key, $tmp_value);
					}
				}
			}
		}
		return $ext_params;
	}
	
	function _getUrl($extp){
		$currDir = str_replace('\\', '/', dirname(__FILE__) . DS);
		$baseDir = str_replace('\\', '/', JString::substr(JURI::base(true), 1) . DS);
		$relativePath = array_pop( explode($baseDir, $currDir, 2) );
		return str_replace('\\', '/', $relativePath . $extp);
	}
	
	function onContentPrepareForm($form, $data) {
		if ($form->getName()=='com_menus.item') {	
			JForm::addFormPath($this->_resources);
			$form->loadFile('menus_edit_params', false);
		}
	}
}