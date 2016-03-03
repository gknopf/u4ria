<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once 'navigate.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/maltalab/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/maltalab/css/menu.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/maltalab/css/custom.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/maltalab/css/sliderbox.css" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->baseurl ?>/templates/maltalab/favicon.ico" />
<?php if($goption=="com_virtuemart"){ ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/maltalab/css/virtuemart.css" type="text/css" />
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl ?>/templates/maltalab/javascript/equalcolumns.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl ?>/templates/maltalab/javascript/slider.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl ?>/templates/maltalab/javascript/common.js" type="text/javascript"></script>
    <?php if($jcarousel): ?>
    <script src="<?php echo $this->baseurl ?>/templates/maltalab/javascript/jquery.jcarousel.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#category_videos').jcarousel({
            scroll:3
        });     
    });
    </script>
<?php endif; ?>
<?php if($view=='productcompare'){ ?>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/maltalab/css/video_slide_skins/productcompare/skin.css" type="text/css" />
<?php } ?>
<?php if($hiddenleft): ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/maltalab/css/video_slide_skins/ie7/skin.css" type="text/css" />
<?php else: ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/maltalab/css/video_slide_skins/tango/skin.css" type="text/css" />
<?php endif; ?>
<script>
// Popup window code
function newWindow(url, name, option) {
	var _name = typeof(name) == "undefined"? 'popUpWindow': name;
	var _option = typeof(option) == "undefined"? 'height=370,width=650,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes': option;
	popupWindow = window.open(
		url, _name, _option)
}

function closeWindow()
{
   if(false == popupWindow.closed)
   {
      popupWindow.close ();
   }
   else
   {
      alert('That window is already closed. Open the window first and try again!');
   }
}
<?php 
if($view!='category' || !$search ) echo "localStorage['brand'] = '';"
?>
</script>
<style type="text/css">
	#maincontainer{width: <?php echo $this->params->get('mainwidth', '1100px'); ?>;margin: 0 auto;}
	#pagewapper {width: <?php echo $this->params->get('pagewapper', '1100px'); ?>;margin: 0 auto;}
	#contentcolumn-left {
		margin: 0 0 0 220px;
                padding-right: 10px;
	}
	#contentcolumn-right {
		margin: 0 215px 0 0;
		height: 100%;
	}
	#contentcolumn-leftright {
		margin: 0 220px;
		height: 100%;
	}
	#contentcolumn-full {
		width: <?php echo $this->params->get('mainwidth', '1100px'); ?>;
		margin: 0 auto;
		height: 100%;
	}
	#leftcolumn {
		float: left;
		width: <?php echo $this->params->get('leftwidth', '200px'); ?>;
		margin-left: -1090px;
		background: transparent;
	}
	#rightcolumn {
		float: left;
		width: <?php echo $this->params->get('rightwidth', '200px'); ?>;
		margin-left: -210px;
		background: transparent;
	}
</style>

</head>
<!--<body  oncontextmenu="return false" onselectstart="return false"
      onkeydown="if ((arguments[0] || window.event).ctrlKey) return false">-->
<body class=" view_<?php echo $view ?>">
    <a name="up" id="up"></a>
	<!-- #maincontainer -->
	<div id="maincontainer">

		<?php if($this->countModules('head-01 and head-02 and head-03')) : ?>
		<!-- block-position -->
		<div id="header" class="blockhead">
			<div class="header1"><jdoc:include type="modules" name="head-01" style="none" /></div>
			<div class="header2"><jdoc:include type="modules" name="head-02" style="none" /></div>
			<div class="header3"><jdoc:include type="modules" name="head-03" style="none" /></div>
			<div class="header4"><jdoc:include type="modules" name="head-04" style="none" /></div>
			<br class="clr" />
		</div>
		<!-- /block-position -->
		<?php endif; ?>

		<?php if($this->countModules('header_midle')) : ?>
		<!-- #topmenu -->
		<div id="header_midle" class="wapper">
                    <div id="" class="header_line1">
                        <jdoc:include type="modules" name="header_midle" style="none" />
                    </div>
                </div>
		<!-- /#topmenu -->
		<?php endif; ?>

		<?php if($this->countModules('topmenu')) : ?>
		<!-- #topmenu -->
		<div id="nav" class="wapper"><jdoc:include type="modules" name="topmenu" style="xhtml" /></div>
		<!-- /#topmenu -->
		<?php endif; ?>

		<?php if($this->countModules('toymenu')) : ?>
		<!-- #topmenu -->
		<div id="toymenu" class="wapper"><jdoc:include type="modules" name="toymenu" style="xhtml" /></div>
		<!-- /#topmenu -->
		<?php endif; ?>

		<?php if($this->countModules('mainbanner')) : ?>
		<!-- #mainbanner -->
		<div id="mainbanner"><jdoc:include type="modules" name="mainbanner" style="xhtml" /></div>
		<!-- /#mainbanner -->
		<?php endif; ?>
		<?php if($this->countModules('headline')) : ?>
                <div class="headline"><jdoc:include type="modules" name="headline" style="none" /></div>
		<?php endif; ?>
		<?php if($this->countModules('position-hb')) : ?>
                <div class="position-hb"><jdoc:include type="modules" name="position-hb" style="none" /></div>
		<?php endif; ?>
		<?php if($this->countModules('position-1')) : ?>
                    <div class="position-1"><jdoc:include type="modules" name="position-1" style="xhtml" /></div>
		<?php endif; ?>
		<!-- #pagewapper -->
		<div id="pagewapper">
			<!-- #contentwrapper -->
			<div id="contentwrapper">
				<div id="<?php echo $contentID; ?>">

					<!-- innertube-content -->
					<div class="innertube-content">
						<jdoc:include type="message" />
                                                <?php if($this->countModules('breadcrumb') && !$search && $view != "cart") : ?>
                               
                                                <div id="breadcrumb"><jdoc:include type="modules" name="breadcrumb" style="xhtml" /></div>
                                                <div class="clr"></div>
                                      
                                                <?php endif; ?>
                                                <?php if($this->countModules('main-top')) : ?>
                                                    <div class="main-top">
                                                        <jdoc:include type="modules" name="main-top" style="xhtml" />
                                                   </div>

                                                <?php endif; ?>
						<jdoc:include type="component" />
					</div>
					<!-- /innertube-content -->

				</div>
			</div>
			<!-- /#contentwrapper -->

			<!-- #leftcolumn -->
                        <?php if(!$hiddenleft): ?>
			<div id="<?php echo $leftID; ?>">
				<div class="innertube-left"><jdoc:include type="modules" name="position-left" style="xhtml" /></div>
			</div>
                        <?php endif; ?>
			<!-- /#leftcolumn -->

			<!-- #rightcolumn -->
                        <?php if(!$hiddenright): ?>
			<div id="<?php echo $rightID; ?>">
				<div class="innertube-right"><jdoc:include type="modules" name="position-right" style="xhtml" /></div>
			</div>
                        <?php endif; ?>
			<!-- /#rightcolumn -->

			<br class="clr" />
		</div>
                <div id="footer" class="wapper">
		<!-- /#pagewapper -->
                <?php if($this->countModules('footer-1 and footer-2 and footer-3 and footer-4 and footer-5')) : ?>
                <!-- block-position -->
                <div class="block2">
                        <div class="footer-1"><jdoc:include type="modules" name="footer-1" style="xhtml" /></div>
                        <div class="footer-2"><jdoc:include type="modules" name="footer-2" style="xhtml" /></div>
                        <div class="footer-3"><jdoc:include type="modules" name="footer-3" style="xhtml" /></div>
                        <div class="footer-4"><jdoc:include type="modules" name="footer-4" style="xhtml" /></div>
                        <div class="footer-5"><jdoc:include type="modules" name="footer-5" style="xhtml" /></div>
                        <br class="clr" />
                </div>
                <!-- /block-position -->
                <?php endif; ?>
                <hr/>
                <?php if($this->countModules('footer')) : ?>
                <!-- #footer -->
                    <div class="footer_bottom">
                        <jdoc:include type="modules" name="footer" style="xhtml" />
                   </div>
                <!-- /#footer -->
                <?php endif; ?>

                </div>
	</div>
	<!-- /#maincontainer -->



	<jdoc:include type="modules" name="debug" />
</body>
</html>
