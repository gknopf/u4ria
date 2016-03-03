<?php
/**
 *
 *
 * @package   mod_blank30v13
 * copyright Blackdale/Bob Galway
 * @license GPL3
 */

// no direct access
defined('_JEXEC') or die;

//Collect Parameters

$url = JURI::base();

$mode=$params->get('mode');
$codeeditor=$params->get('codeeditor');
$phpcode=$params->get('phpcode');
$phpuse=$params->get('phpuse');
$script=$params->get('script');
$scriptuse=$params->get('scriptuse');
$content1=$params->get('content1');
$content2=$params->get('content2');
$content3=$params->get('content3');
$graphics=$params->get('graphics');
$paddingleft=$params->get('paddingleft');
$paddingright=$params->get('paddingright');
$paddingtop=$params->get('paddingtop');
$paddingbottom=$params->get('paddingbottom');
$margintop=$params->get('margin-top');
$marginbottom=$params->get('margin-bottom');
$marginleftmodule=$params->get('margin-leftmodule');
$colour1='#'.$params->get('colour1');
$colour2='#'.$params->get('colour2');
$trans1=$params->get('trans1');
$trans2=$params->get('trans2');
if($trans1==2){$colour1="transparent";}
if($trans2==2){$colour2="transparent";}
$width=$params->get('width');
$widthunit=$params->get('widthunit');
$itemid=$params->get('itemid');
$contenttitleuse=$params->get('contenttitleuse');
$contentuse=$params->get('contentuse');
$textareause=$params->get('textareause');
$reverse=$params->get('reverse');
$bgautocolour = $params->get('bgautocolour');
$modno_bm = $params->get('modno_bm');
if ($modno_bm==0){$modno_bm="BM".($module->id);}

$custompx = $params->get('custompx');
$keycolour = $params->get('keycolour');
$css="";

// set background colour

if ($keycolour == "blue") {
    $bgcolour = "#aabbff";
}
if ($keycolour == "green") {
    $bgcolour = "#aaffaa";
}
if ($keycolour == "red" ){
    $bgcolour = "#dd2222";
}
if ($keycolour == "orange") {
    $bgcolour = "#cc9944";
}
if ($keycolour == "yellow") {
    $bgcolour = "#dd9";
}
if ($keycolour == "purple") {
    $bgcolour = "#d244f2";
}
if ($keycolour == "grey") {
    $bgcolour = "#dddddd";
}
if($bgautocolour==3){$bgcolour="transparent";}
//modify paths if media libraries available

$surroundstyle = $params->get('surroundstyle');
$surroundpx = substr($surroundstyle,0,2).'px';

$surroundpx = substr($surroundstyle,0,2);

if(substr($surroundpx,0,1)==0){$surroundpx=substr($surroundpx,-1,1);}
$surroundpx .="px";



if($surroundstyle !=="custom"){$lib = substr($surroundstyle,-1,1);}

// define possible paths

$self1= $_SERVER['PHP_SELF'];
$self1=(str_replace("index.php","",$self1));
$self1= ($_SERVER['DOCUMENT_ROOT']).$self1;
$self1=(str_replace("//","/",$self1));
$path1=$self1."modules/mod_bdalemedia1";
$path2=$self1."modules/mod_bdalemedia2";
$path3=$self1."modules/mod_bdalemedia3";
$path4=$self1."modules/mod_bdalebackgrounds";

//Select backgrounds source folder
//xxxxxxxx
if(file_exists($path4)){$bgmodulemedia="mod_bdalebackgrounds";}
else {$bgmodulemedia="mod_blank30v13";}

//Select surrounds source folder

$surmodulemedia='mod_blank30v13';
if((file_exists($path1)&&($lib ==1))||(file_exists($path2)&&($lib ==2))||(file_exists($path3)&&($lib ==3))){$surmodulemedia='mod_bdalemedia'.$lib;}
//yyyyy
// set dimension etc for custom surround

if ($surroundstyle=="custom"){$surroundpx=$custompx;$surmodulemedia="mod_blank30v13";}

//colours & backgrounds

$bgpattern = $params->get('bgpattern');

if($bgpattern == "custom"){$bgmodulemedia="mod_blank30v13";}
$customcolour = $params->get('customcolour');

$bgcustomcolour = '#'.$params->get('bgcustomcolour');

if ($bgautocolour==2){

$bgcolour=$bgcustomcolour;
}

if ($bgpattern == "none") {
    $bguse = 2;
}

if ($bgpattern !=="none") {
    $bguse = 1;
}
if ($bguse == 1) {
    $bg = 'background:' . $bgcolour .
        ' url("'.$url.'modules/'.$bgmodulemedia.'/tmpl/images/backgrounds/' . $bgpattern .
        '.png")';
}
if ($bguse == 2) {
    $bg = 'background-color:' . $bgcolour . ';';

}

//add custom tag to head section

if ($scriptuse==1){
$doc =& JFactory::getDocument();
$doc->addCustomTag( $script );

}

if ($graphics==1){$css=

"td.corner1_" . $modno_bm ."{width:".$surroundpx.";height:".$surroundpx.";padding:0;margin:0;background:url(".$url."modules/".$surmodulemedia."/tmpl/images/surrounds/" .
    $surroundstyle . "/" . $keycolour .
    "/corner1.png) no-repeat ;

}
td.corner2_" . $modno_bm .
    "{width:".$surroundpx.";height:".$surroundpx.";padding:0;margin:0;background:url(".$url."modules/".$surmodulemedia."/tmpl/images/surrounds/" .
    $surroundstyle . "/" . $keycolour .
    "/corner2.png) no-repeat ;

}
td.corner3_" . $modno_bm .
    "{width:".$surroundpx.";height:".$surroundpx.";padding:0;margin:0;background:url(".$url."modules/".$surmodulemedia."/tmpl/images/surrounds/" .
    $surroundstyle . "/"  . $keycolour .
    "/corner3.png) no-repeat ;

}
td.corner4_" . $modno_bm .
    "{width:".$surroundpx.";height:".$surroundpx.";padding:0;margin:0;background:url(".$url."modules/".$surmodulemedia."/tmpl/images/surrounds/" .
    $surroundstyle . "/"  . $keycolour.
    "/corner4.png) no-repeat ;

}

#contenttable" . $modno_bm . "{";

//test for null background

if(!empty($colour2)){$css.="background:".$colour2;}

$css .="}
#inner" . $modno_bm . "{
padding:3px;
" . $bg ."}

#contenttable" . $modno_bm . " td, #contenttable" . $modno_bm . " tr,#contenttable" . $modno_bm . "{
border:0px;
padding:0px;
margin:0px;

}";

}

$css.="
#blank".$modno_bm."{";
if (!empty($margintop)){$css.="margin-top:".$margintop."px;";}
if (!empty($marginbottom)){$css.="margin-bottom:".$marginbottom."px;";}
if (!empty($marginleftmodule)){$css.="margin-left:".$marginleftmodule."px;";}
$css.="overflow:hidden;";
if (!empty($paddingleft)){$css.="padding-left:".$paddingleft."px;";}
if (!empty($paddingright)){$css.="padding-right:".$paddingright."px;";}
if (!empty($paddingtop)){$css.="padding-top:".$paddingtop."px;";}
if (!empty($paddingbottom)){$css.="padding-bottom:".$paddingbottom."px;";}
$css.="width:".$width.$widthunit.";";

//test for null background

if(!empty($colour1)){$css.="background:".$colour1;}

$css .= "}";

//add CSS to head section of page

$doc =&JFactory::getDocument();
$doc->addStyleDeclaration($css,'text/css');

// deselect unwanted content

if ($textareause==2){$codeeditor="";}
if ($phpuse==2){$phpcode="";}

echo '<div id="blank'.$modno_bm.'" >';

// add graphics

if ($graphics==1){
echo "<div class=\"holder" . $modno_bm . "\">

<table summary=\"graphics\" width=\"" . $width .$widthunit.
    "\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"overflow:hidden;border-collapse:collapse;\" id=\"contenttable" . $modno_bm . "\">

<tr>
<td class=\"corner1_" . $modno_bm . "\" >
</td>
<td style=\"background:url(".$url."modules/".$surmodulemedia."/tmpl/images/surrounds/" . $surroundstyle .
    "/"  . $keycolour . "/top.png) repeat-x\">
</td>
<td class=\"corner2_" . $modno_bm . "\" >
</td>

</tr>

<tr>

<td style=\"background:url(".$url."modules/".$surmodulemedia."/tmpl/images/surrounds/" . $surroundstyle .
    "/"  . $keycolour . "/sidel.png) repeat-y;\">
</td>
<td ><div id=\"inner" . $modno_bm . "\">";}

//Code to retrieve article

$article="";

// 1.  title retrieval

$db=& JFactory::getDBO();
if (($contenttitleuse==1)&&($itemid !="a")){
    $db->setQuery('SELECT * FROM `#__content` WHERE `id`= '.$itemid.' ORDER BY `id`');
    $contents = $db->loadObjectList();
    if(isset($contents[0]) ){$article ='<h4 id="title_'.$modno_bm.'" style="overflow:hidden">'.($contents[0]->title).'</h4>';}
}

//2 . content retrieval

if (($contentuse==1)&&($itemid !="a")) {
    $db->setQuery('SELECT * FROM `#__content` WHERE `id`= '.$itemid.' ORDER BY `id`');
    $contents = $db->loadObjectList();
    if(isset($contents[0]) ){$article.='<div>'.($contents[0]->introtext ).($contents[0]->fulltext ).'</div>';}

}

// contentselection/order

$codeeditor="<div>".$codeeditor."</div>";
$article="<div>".$article."</div>";

if ($content1==1){echo $codeeditor;}
if ($content1==2){echo "<div>";eval( $phpcode);echo "</div>";}
if ($content1==3){echo $article;}


if ($content2==1){echo $codeeditor;}
if ($content2==2){echo  "<div>";eval( $phpcode);echo "</div>";}
if ($content2==3){echo $article;}


if ($content3==1){echo $codeeditor;}
if ($content3==2){echo  "<div>";eval( $phpcode);echo "</div>";}
if ($content3==3){echo $article;}

// add graphics

if ($graphics==1){

echo   "</div>
</td>
<td  style=\"background:url(".$url."modules/".$surmodulemedia."/tmpl/images/surrounds/" . $surroundstyle .
    "/" . $keycolour . "/sider.png) repeat-y;\">
</td>

</tr>

<tr>

<td class=\"corner3_" . $modno_bm . "\" >
</td>
<td style=\"background:url(".$url."modules/".$surmodulemedia."/tmpl/images/surrounds/" . $surroundstyle .
    "/"  . $keycolour . "/base.png) repeat-x\">
</td>
<td class=\"corner4_" . $modno_bm . "\" >
</td>

</tr>
</table>
</div>";}

echo "</div>";


?>



