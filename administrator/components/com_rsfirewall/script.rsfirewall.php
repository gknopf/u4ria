<?php
/**
* @version 1.4.0
* @package RSFirewall! 1.4.0
* @copyright (C) 2009-2012 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

class com_rsfirewallInstallerScript
{
	function install($parent)
	{
		
	}
	
	function postflight($type, $parent)
	{		
		if ($type == 'install')
		{
			$db =& JFactory::getDBO();
			
			$db->setQuery("UPDATE #__extensions SET `enabled`='1' WHERE `type`='plugin' AND `element`='rsfirewall'");
			$db->query();
			
			$db->setQuery("UPDATE #__extensions SET `enabled`='1' WHERE `type`='module' AND `element`='mod_rsfirewall'");
			$db->query();
			
			$db->setQuery("SELECT id FROM #__modules WHERE `client_id`='1' AND `module`='mod_rsfirewall'");
			$id = $db->loadResult();
			$db->setQuery("INSERT INTO #__modules_menu SET `moduleid`='".$id."', `menuid`='0'");
			$db->query();
		}
		
		if ($type == 'update')
		{
			$sqlfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'install.mysql.utf8.sql';
			$buffer = file_get_contents($sqlfile);
			if ($buffer === false)
			{
				JError::raiseWarning(1, JText::_('JLIB_INSTALLER_ERROR_SQL_READBUFFER'));
				return false;
			}
			
			jimport('joomla.installer.helper');
			$queries = JInstallerHelper::splitSql($buffer);
			if (count($queries) == 0) {
				// No queries to process
				return 0;
			}
			
			$db =& JFactory::getDBO();
			
			// Process each query in the $queries array (split out of sql file).
			foreach ($queries as $query)
			{
				$query = trim($query);
				if ($query != '' && $query{0} != '#')
				{
					$db->setQuery($query);
					if (!$db->query())
					{
						JError::raiseWarning(1, JText::sprintf('JLIB_INSTALLER_ERROR_SQL_ERROR', $db->stderr(true)));
						return false;
					}
				}
			}
		}
	}
	
	function uninstall($parent)
	{
		$db =& JFactory::getDBO();
		
		$plg_installer = new JInstaller();
		$db->setQuery("SELECT extension_id FROM #__extensions WHERE `element`='rsfirewall' AND `type`='plugin' LIMIT 1");
		$plg_id = $db->loadResult();
		if ($plg_id)
			@$plg_installer->uninstall('plugin', $plg_id);
		
		$db->setQuery("SELECT extension_id FROM #__extensions WHERE `element`='mod_rsfirewall' AND `type`='module' AND `client_id`='1' LIMIT 1");
		$plg_id = $db->loadResult();
		if ($plg_id)
			@$plg_installer->uninstall('module', $plg_id);
	}
}