<?php

/*
 * @package		Test Plugin for Joomla!
 * @author		Joomla Engineering http://joomlaengineering.com
 * @copyright	Copyright (C) 2010,2011 Matt Thomas | Joomla Engineering. All rights reserved.
 * @license		GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemSetTemplate extends JPlugin {

        function onAfterInitialise() {

                require_once 'Mobile_Detect.php';
//                //Do we use the hard coded value of 'beez5' or the selected template style
//                $pluginState = $this->params->get('pluginState');
//                //This is the template chosen using the paramter type "Template Style"
                $styleTemplate = $this->params->get('styleTemplate');

                $app = &JFactory::getApplication();
                $isSite = $app->isSite();

                if ($isSite) {
                        
//                                JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_templates/tables');
//                                $style = JTable::getInstance('Style', 'TemplatesTable');
//                                $style->load($styleTemplate);
//                                $app->setTemplate($style->template, $style->params);                        
                        
                        
//                        $detect = new Mobile_Detect();
//                        if ($detect->isMobile()) {
//                                JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_templates/tables');
//                                $style = JTable::getInstance('Style', 'TemplatesTable');
//                                $style->load($styleTemplate);
//                                $app->setTemplate($style->template, $style->params);
//				$app->setTemplate($style->template, new JRegistry($style->params));
//				$app->setTemplate($style->template, null);
//                        }
                }
        }

}
