<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$app = JFactory::getApplication();
$templateDir = JURI::base() . 'templates/' . $app->getTemplate();
$sitename = $this->params->get('sitename') ? $this->params->get('sitename') : JFactory::getConfig()->get('sitename');
$slogan = $this->params->get('slogan');
$logotype = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', '') : '';
if ($logoimage) {
  $logoimage = ' style="background-image:url('.JURI::base(true).'/'.$logoimage.');"';
}
?>

<!-- HEADER -->
<header id="t3-header" class="container t3-header">
  <div class="row">

        <div id="header"> <!--header-->
       		
		<?php if ($this->countModules('head-01')) : ?>
		<!-- HEAD 01 -->
		<div class="header1 left <?php $this->_c('head-01')?>">  
			<div class="logo">
				<jdoc:include type="modules" name="<?php $this->_p('head-01') ?>" style="raw" />
			</div>
		</div>
		<!-- //HEAD 01 -->
		<?php endif ?>
		
		<?php if ($this->countModules('head-02')) : ?>
		<!-- HEAD 02 -->
		<div class="header2 left <?php $this->_c('head-02')?>">     
		  <jdoc:include type="modules" name="<?php $this->_p('head-02') ?>" style="raw" />
		</div>
		<!-- //HEAD 02 -->
		<?php endif ?>	
		
		<?php if ($this->countModules('head-03')) : ?>
		<!-- HEAD 03 -->
		<div class="header3 left <?php $this->_c('head-03')?>">     
		  <jdoc:include type="modules" name="<?php $this->_p('head-03') ?>" style="raw" />
		</div>
		<!-- //HEAD 03 -->
		<?php endif ?>	
		
		<?php if ($this->countModules('head-04')) : ?>
		<!-- HEAD 04 -->
		<div class="header4 left <?php $this->_c('head-04')?>">     
		  <jdoc:include type="modules" name="<?php $this->_p('head-04') ?>" style="raw" />
		</div>
		<!-- //HEAD 04 -->
		<?php endif ?>	
		
		
		
		<?php if ($this->countModules('head-search')) : ?>
		<!-- HEAD SEARCH -->
		<div class="span4 head-search<?php $this->_c('head-search')?>">     
		  <jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
		</div>
		<!-- //HEAD SEARCH -->
		<?php endif ?>
		<div class="clr"></div>
		</div>
  </div>
</header>
<!-- //HEADER -->
