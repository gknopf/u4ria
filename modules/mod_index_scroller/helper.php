<?php
/**
 * Helper class for Hello World! module
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:modules/
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class modIndexScrollerHelper
{
    /**
     * Retrieves the hello message
     *
     * @param array $params An object containing the module parameters
     * @access public
     */   
	static function &getList(&$params)
	{ 
		jimport('joomla.application.component.model');
		JModel::addIncludePath(JPATH_ROOT.'/components/com_banners/models', 'BannersModel');
		$document	= JFactory::getDocument();
		$app		= JFactory::getApplication();
		$keywords	= explode(',', $document->getMetaData('keywords'));

		$model = JModel::getInstance('Banners','BannersModel',array('ignore_request'=>true));
		$model->setState('filter.client_id', (int) $params->get('cid'));
		$model->setState('filter.category_id', $params->get('catid', array()));
		$model->setState('filter.ordering', $params->get('ordering'));
		$model->setState('filter.tag_search', $params->get('tag_search'));
		$model->setState('filter.keywords', $keywords);
		$model->setState('filter.language', $app->getLanguageFilter());

		$banners = $model->getItems();
		$model->impress();

		return $banners;
	}
		
    static function getIndexScroller( $params )
    {
        // '.$this->baseurl.'/templates/'.$this->template.'/ 
		
		$HTML = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
<td align="left" valign="top" style="border:1px #cfcfd0 solid; padding:3px;">
<div id="lofslidecontent45" class="lof-slidecontent">
<div class="preload">
<div></div>
</div>
<div class="lof-main-wapper">
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>ZINI will fulfill Adults<br />Secret Dreams come true</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-01.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>World Leader and Famous<br />Aneros Prostate Massager</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-02.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>World Famous<br />E-Stim Kits</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-03.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>World Leader in<br />Male Chastity Device</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-04.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Japan Most Popular Nuru<br /> Premium Body Massage Gel</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-05.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Full Range of Tenga<br /> Available at U4Ria</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-06.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Full Range of<br /> Fleshlight Available at U4Ria</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-07.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Most Advance Sex<br /> toys Made in Japan</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-08.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>World&#8217;s Best <br />Pleasure Objects</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-09.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Emotional Products<br />Luminously Created   for Women</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-10.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Dreamgirl - World Leader <br />
in Contemporary Costume and Lingerie</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-11.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Jimmy Jane Luxury Vibe - <br />Award Winner&#8218; Superstar&#8217;s Most Love</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-12.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>AndroPenis - World <br />
Famous Penis Extender</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-13.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>World Most Popular <br />Sex toys for Couples</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-14.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>World&#8217;s Best <br />Oral Sex Simulator</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-15.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Bswish -Luxury Design<br />at Affordable Price</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-16.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Fairy Wand - Most <br />Popular Massager Wand in Japan</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-17.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Je Joue - Award WInner - <br />Best Sex Toy for Women</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-18.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Fun Factor - Best <br />Seller In Germany</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-19.jpg" title="Newsflash 2">
</div>
<div class="lof-main-item">
<h3>TOP <span>20</span> Sextoy Best-Selling Brands</h3>
<p><span>Naughty Boy - Perfect Combination<br /> as Prostate and penineum stimulator</span>U4Ria</p>
<img src="'.TEMPLATE_URL.'/images/header-20.jpg" title="Newsflash 2">
</div>
</div>
<div class="lof-navigator-outer">
<ul class="lof-navigator">
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-01.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>1</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-02.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>2</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-03.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>3</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-04.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>4</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-05.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>5</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-06.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>6</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-07.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>7</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-08.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>8</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-09.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>9</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-10.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>10</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-11.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>11</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-12.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>12</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-13.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>13</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-14.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>14</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-15.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>15</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-16.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>16</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-17.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>17</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-18.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>18</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-19.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>19</span> </li>
<li class="lof-navigator-item hasLofTip" title="::&lt;img src=&quot;'.TEMPLATE_URL.'/images/header-20.jpg&quot; height=&quot;70&quot; width=&quot;140&quot;&gt;"> <span>20</span> </li>
</ul>
</div>
</div>';




$HTML .= ' 



</td>
</tr>
		
		
		<tr>
        <td align="left" valign="top">&nbsp;</td>
        </tr>
		</table>
		
		';
		
		
		return $HTML;
    }
}
?>