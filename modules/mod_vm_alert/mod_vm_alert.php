<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_weblinks
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
require_once dirname(__FILE__).'/helper.php';
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$total = ModAlertHelper::CountAllProduct();


require JModuleHelper::getLayoutPath('mod_vm_alert', $params->get('layout', 'default'));
