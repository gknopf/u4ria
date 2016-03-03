<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_weblinks
 * @copyright	Copyright (C) 2005 - 2009 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the weblinks functions only once
//require_once dirname(__FILE__).'/helper.php';
//
//$list = modWishlistHelper::getList($params);
//
//if (!count($list)) {
//	return;
//}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_vm_compare', $params->get('layout', 'default'));
