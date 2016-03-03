<?php

defined('_JEXEC') or die('Restricted access');

// Load the view framework
if (!class_exists('VmView'))
    require(JPATH_VM_SITE . DS . 'helpers' . DS . 'vmview.php');

class VirtuemartViewPriceMatch extends VmView {

    function display($tpl = null) {

//        $user = JFactory::getUser();

        
        $pricematch->event = new stdClass();
        $pricematch->event->afterDisplayTitle = '';
        $pricematch->event->beforeDisplayContent = '';
        $pricematch->event->afterDisplayContent = '';
        $dispatcher = & JDispatcher::getInstance();
        JPluginHelper::importPlugin('content');
        jimport('joomla.html.parameter');
        $params = new JParameter('');        
        $pricematch->text = "{rsform 2}";

        if (JVM_VERSION === 2) {
            $results = $dispatcher->trigger('onContentPrepare', array('com_virtuemart.pricematch', &$pricematch, &$params, 0));
            // More events for 3rd party content plugins
            // This do not disturb actual plugins, because we don't modify $product->text
            $res = $dispatcher->trigger('onContentAfterTitle', array('com_virtuemart.pricematch', &$pricematch, &$params, 0));
            $pricematch->event->afterDisplayTitle = trim(implode("\n", $res));

            $res = $dispatcher->trigger('onContentBeforeDisplay', array('com_virtuemart.pricematch', &$pricematch, &$params, 0));
            $pricematch->event->beforeDisplayContent = trim(implode("\n", $res));

            $res = $dispatcher->trigger('onContentAfterDisplay', array('com_virtuemart.pricematch', &$pricematch, &$params, 0));
            $pricematch->event->afterDisplayContent = trim(implode("\n", $res));
        } else {
            $pricematch = $dispatcher->trigger('onPrepareContent', array(& $pricematch, & $params, 0));
        }
            
        $this->assignRef('pricematch', $pricematch);
        parent::display($tpl);
    }

}

// pure php no closing tag
