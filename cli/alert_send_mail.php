<?php

// Make sure we're being called from the command line, not a web interface
if (array_key_exists('REQUEST_METHOD', $_SERVER)) die();

/**
 * Finder CLI Bootstrap
 *
 * Run the framework bootstrap with a couple of mods based on the script's needs
 */

// We are a valid entry point.
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

// Load system defines
if (file_exists(dirname(dirname(__FILE__)) . '/defines.php'))
{
	require_once dirname(dirname(__FILE__)) . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', dirname(dirname(__FILE__)));
	require_once JPATH_BASE . '/includes/defines.php';
}

if (!defined('VMLANG')) define('VMLANG', 'en_gb');

// Get the framework.
require_once JPATH_LIBRARIES . '/import.php';

// Bootstrap the CMS libraries.
require_once JPATH_LIBRARIES . '/cms.php';

// Force library to be in JError legacy mode
JError::$legacy = true;

// Import necessary classes not handled by the autoloaders
jimport('joomla.application.menu');
jimport('joomla.environment.uri');
jimport('joomla.event.dispatcher');
jimport('joomla.utilities.utility');
jimport('joomla.utilities.arrayhelper');

jimport('joomla.methods');
jimport('joomla.factory');
// Import the configuration.
require_once JPATH_CONFIGURATION . '/configuration.php';

// System configuration.
$config = new JConfig;

// Configure error reporting to maximum for CLI output.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Library language
$lang = JFactory::getLanguage();

// Try the finder_cli file in the current language (without allowing the loading of the file in the default language)
$lang->load('finder_cli', JPATH_SITE, null, false, false)
// Fallback to the finder_cli file in the default language
|| $lang->load('finder_cli', JPATH_SITE, null, true);

/**
 * A command line cron job to run the alert send mail.
 *
 * @package     Joomla.CLI
 * @subpackage  com_finder
 * @since       2.5
 */
class AlertSendMailCli extends JApplicationCli
{
	public function doExecute()
	{
    $sql_asm = 'SELECT asm.*, p.product_name '
             . 'FROM `#__virtuemart_alert_send_mail` AS asm '
             . 'LEFT JOIN `#__virtuemart_products_' . VMLANG . '` AS p ON p.virtuemart_product_id = asm.product_id '
             . 'ORDER BY asm.id ASC';

    $db = JFactory::getDBO();
    $db->setQuery($sql_asm);
    $result_array = $db->loadObjectList();

    if ($result_array) {
      foreach ($result_array as $key => $value) {
        $sql = 'SELECT u.name, pa.* '
             . 'FROM `#__virtuemart_products_alert` AS pa '
             . 'JOIN `#__users` AS u ON u.id = pa.user_id '
             . 'WHERE pa.virtuemart_product_id = ' . $value->product_id . ' ';

        if ($value->none_send) {
          $sql .= 'AND pa.user_id != ' . $value->none_send . ' ';
        }

        if ($value->type == 1) {
          $sql .= 'AND pa.alert_product_promotion = 1 ';
          $emailBody = $this->getRsformForms(6);
        } else if ($value->type == 2) {
          $sql .= 'AND pa.alert_product_clearance_sale = 1 ';
          $emailBody = $this->getRsformForms(6);
        } else if ($value->type == 3) {
          $sql .= 'AND pa.alert_product_price_reduction = 1 ';
          $emailBody = $this->getRsformForms(6);
        } else if ($value->type == 4) {
          $sql .= 'AND pa.alert_product_new_review = 1 ';
          $emailBody = $this->getRsformForms(7);
        } else {
          continue;
        }

        $sql .= 'ORDER BY pa.virtuemart_product_alert_id ASC';
        $db->setQuery($sql);

        $alert_array = $db->loadObjectList();

        //gui mail cho user
        if ($alert_array) {
          foreach ($alert_array as $k => $v) {
            $config = JFactory::getConfig();

            $link = $config->get('baseUrl') . 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $value->product_id;
            $plink = '<a href="' . $link . '">' . $value->product_name . '</a>';
            $plinkrot = '<a href="' . $link . '">' . $link . '</a>';

            $emailBody->UserEmailText = str_replace('#USER', $v->name, $emailBody->UserEmailText);
            $emailBody->UserEmailText = str_replace('#PRODUCT', $plink, $emailBody->UserEmailText);
            $emailBody->UserEmailText = str_replace('#LINK', $plinkrot, $emailBody->UserEmailText);
            JUtility::sendMail($emailBody->AdminEmailFrom, '', $v->alert_email, $emailBody->UserEmailSubject, $emailBody->UserEmailText, true, '', '');
          }
        }

        //xoa ban ghi trong virtuemart_alert_send_mail
        $sql = 'DELETE FROM #__virtuemart_alert_send_mail WHERE id = ' . $value->id;
        $db = JFactory::getDBO();
        $db->setQuery($sql);
        $db->query ();
      }
    }
	}

	public function getRsformForms($id)
	{
	  $db = JFactory::getDBO();
	  $q_email = 'SELECT * FROM #__rsform_forms WHERE FormId = ' . $id;
	  $db->setQuery($q_email);
	  $emailBody = $db->loadObject();

	  return $emailBody;
	}
}
JApplicationCli::getInstance('AlertSendMailCli')->execute();
