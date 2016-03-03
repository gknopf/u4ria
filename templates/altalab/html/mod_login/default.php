<?php
/**
 * @package   Template Overrides - RocketTheme
 * @version   3.2.12 October 30, 2011
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Rockettheme Gantry Template uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>
<?php if ($type == 'logout') : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" name="form-login" id="login-form">
<?php if ($params->get('greeting')) : ?>
	<div class="login-greeting" style="padding: 5px;">
	<?php if($params->get('name') == 0) : {
		echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('name'));
                echo ' ';
                echo JText::sprintf('MOD_LOGIN_WELCOME_TO_U4RIA');
	} else : {
		echo JText::sprintf('MOD_LOGIN_HINAME', ',<label style="color: #B00C97; font-size: 12px;">'
                        .$user->get('username').'</label>');
                echo ' ';
                echo JText::sprintf('MOD_LOGIN_WELCOME_TO_U4RIA');
	} endif; ?>
	</div>
<?php endif; ?>
	<div class="readon" style="padding: 5px;">
            <div style="text-align: center;">
            <input style="cursor:pointer" type="button" name="Management" class="regbutton" value="<?php echo JText::_('JMANAGEMENT'); ?>"
                       onclick="location.href='<?php echo JRoute::_('index.php?option=com_users&view=management&userid='); echo $user->get('id'); ?>'"/></br>
            </div>
            <div style="text-align: center;">
            <input style="cursor:pointer" type="submit" name="Submit" class="regbutton" value="<?php echo JText::_('JLOGOUT'); ?>" />
            </div>
            <div style="">
            <br>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=management&tab=membership');?>" style="color: #B00C97;">- Membership Management</a><br>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=management&tab=rewardpoint');?>" style="color: #B00C97;">- Reward Points Management</a><br>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=management&tab=profile');?>" style="color: #B00C97;">- Member Profile</a><br>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=management&tab=address');?>" style="color: #B00C97;">- Address Management</a><br>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=management&tab=transaction');?>" style="color: #B00C97;">- Transaction History</a><br>
            </div>     
	</div>

	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<?php else : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" name="form-login" id="login-form" >
	<?php if ($params->get('pretext')): ?>
	<div class="pretext">
	<p><?php echo $params->get('pretext'); ?></p>
	</div>
	<?php endif; ?>
	<fieldset class="userdata">
	<p id="form-login-username">
		<label for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
		<input id="modlgn-username" type="text" name="username" class="inputbox"  size="18"/>
	</p>
	<p id="form-login-password">
		<label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
		<input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18"/>
	</p>
	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
	<p id="form-login-remember">
		<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
		<label for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
	</p>
	<?php endif; ?>
	<div class="readon"><input type="submit" name="Submit" class="login" value="<?php //echo JText::_('JLOGIN') ?>" /> 
	<input type="button" onclick="location.href='<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>'" name="signup" class="signup" value="<?php //echo JText::_('JLOGIN') ?>" />
	</div>
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHtml::_('form.token'); ?>
	</fieldset>
	<ul>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
			<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
		</li>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
			<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
		</li>
		
	</ul>
	<?php if ($params->get('posttext')): ?>
	<div class="posttext">
		<p><?php echo $params->get('posttext'); ?></p>
	</div>
	<?php endif; ?>
</form>
<?php endif; ?>
