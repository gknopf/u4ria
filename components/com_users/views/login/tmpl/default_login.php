<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>
<div id="loginview" class="login<?php echo $this->pageclass_sfx?>">

	<h1>
	        Register And Become a U4ria Member Or Log In To Your Account
                        <?php //echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
        <p> - With U4ria secure server, your payment information is strictly confidential</p>
        <p> - Your personal information is 100% safe with us</p>
        <p> - Your orders will be shipped strictly in discreet packaging </p>
        <div id="lgf">
        <fieldset class="lreg">
            <div class="login-description" style="height: 205px;">

                        <h2>Sign Up</h2>
                        <p>Register for U4ria Account for special Member Benefits</p>
                        <ul>
                                <li>Shop easily anytime from our website</li>
                                <li>Follow up your order status</li>
                                <li>Get latest updates from our website</li>
                                <li>Enjoin our special member discounts</li>
                        </ul>   
                        <button class="regbutton" onclick="location.href='<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>'">SIGN UP >></button>

                </div>
        </fieldset>
        <fieldset class="llog">
            <div class="login-description" style="height: 205px;">
                <h2>Login</h2>
	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	
                <div class="login-description">
                        
	<?php endif ; ?>

		<?php if($this->params->get('logindescription_show') == 1) : ?>
			<?php echo $this->params->get('login_description'); ?>
		<?php endif; ?>

		<?php if (($this->params->get('login_image')!='')) :?>
			<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JTEXT::_('COM_USER_LOGIN_IMAGE_ALT')?>"/>
		<?php endif; ?>

	<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
	</div>
	<?php endif ; ?>

                <form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" style="height: 165px; position: relative">

		
			<?php foreach ($this->form->getFieldset('credentials') as $field): ?>
				<?php if (!$field->hidden): ?>
					<div class="login-fields"><?php echo $field->label; ?>
					<?php echo $field->input; ?></div>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<div class="login-fields">
				<label id="remember-lbl" for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
				<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" />
			</div>
			<?php endif; ?>
			<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
			<?php echo JHtml::_('form.token'); ?>
                                                <div>
	<ul>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
			<?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
		</li>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
			<?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
		</li>
		<?php
		$usersConfig = JComponentHelper::getParams('com_users');
		if ($usersConfig->get('allowUserRegistration')) : ?>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
				<?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
		</li>
		<?php endif; ?>
	</ul>        
</div>
                        <br />
                        <button type="submit" class="regbutton" style="position: absolute;bottom: 0px;">SIGN IN >></button>
            </div>
		</fieldset>
	</form>
                </fieldset>
</div>
</div>

