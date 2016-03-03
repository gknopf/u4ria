<?php
/**
 * Mod running text for 2.5.x
 * @date 01.04.2012
 * @author Roman Náhlovský web@renat.sk
 * @Copyright (C) 2008 http://web.renat.sk
 * @ All rights reserved
 * @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
 * @version joomla 2.5.x
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$moduleclass_sfx		= $params->get( 'moduleclass_sfx' );
$showtext		= $params->get( 'showtext', '') ;
$bgcolor		= $params->get( 'bgcolor', '') ;
$width		= $params->get( 'width', '200px') ;
$height		= $params->get( 'height', '25px') ;
$speed		= $params->get( 'speed', '2') ;
$pause		= $params->get( 'pause', '1') ;
$fontsize		= $params->get( 'fontsize', '') ;
?>
<style type="text/css">

</style>
<script type="text/javascript">

/***********************************************
* Memory Scroller script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
* adaption data http://web.renat.sk
* advertising www.instudio.in | www.renat.sk | web.renat.sk | uctovnictvo.renat.sk | www.server-renat-sk.eu | www.hracky-detske.sk | www.fotocam.sk | www.kvety-bb.sk | www.tucniaci.eu
***********************************************/

var memorywidth="<?php echo $width; ?>" //scroller width
var memoryheight="<?php echo $height; ?>" //scroller height
var memorybgcolor="<?php echo $bgcolor; ?>" //scroller background
var memorypadding="2px" //padding applied to the scroller. 0 for non.
var borderCSS="border: 0px solid black;" //Border CSS, applied to scroller to give border.

var memoryspeed="<?php echo $speed; ?>" //Scroller speed (larger is faster 1-10)
var pauseit="<?php echo $pause; ?>" //Pause scroller onMousever (0=no. 1=yes)?

var persistlastviewedmsg=1 //should scroller's position persist after users navigate away (1=yes, 0=no)?
var persistmsgbehavior="onload" //set to "onload" or "onclick".

//Specify the scroller's content (don't delete <nobr> tag)
//Keep all content on ONE line, and backslash any single quotations (ie: that\'s great):

var memorycontent='<nobr><span style="font: bold <?php echo $fontsize; ?> Verdana"><?php $pieces = explode(",", $showtext); echo $pieces[0]; ?></span></nobr>'


////NO NEED TO EDIT BELOW THIS LINE////////////
var combinedcssTable="width:"+(parseInt(memorywidth)+6)+"px;background-color:"+memorybgcolor+";"+borderCSS+";"
var combinedcss="width:"+memorywidth+";height:"+memoryheight+";"
var text_ind = 0;
var divonclick=(persistlastviewedmsg && persistmsgbehavior=="onclick")? 'onClick="savelastmsg()" ' : ''
memoryspeed=(document.all)? memoryspeed : Math.max(1, memoryspeed-1) //slow speed down by 1 for NS
var copyspeed=memoryspeed
var pausespeed=(pauseit==0)? copyspeed: 0
var iedom=document.all||document.getElementById;
console.log(memorycontent);
if (iedom)
document.write('<span id="temp" style="visibility:hidden;position:absolute;top:-100px;left:-10000px">'+memorycontent+'</span>')
var actualwidth=''
var memoryscroller

if (window.addEventListener)
window.addEventListener("load", populatescroller, false)
else if (window.attachEvent)
window.attachEvent("onload", populatescroller)
else if (document.all || document.getElementById)
window.onload=populatescroller

function populatescroller(){
memoryscroller=document.getElementById? document.getElementById("memoryscroller") : document.all.memoryscroller
memoryscroller.style.left=parseInt(memorywidth)+8+"px"
if (persistlastviewedmsg && get_cookie("lastscrollerpos")!="")
revivelastmsg()
memoryscroller.innerHTML=memorycontent.split(",")[text_ind]; 
actualwidth=document.all? temp.offsetWidth : document.getElementById("temp").offsetWidth
lefttime=setInterval("scrollmarquee()",20)
}

function get_cookie(Name) {
var search = Name + "="
var returnvalue = ""
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search)
if (offset != -1) {
offset += search.length
end = document.cookie.indexOf(";", offset)
if (end == -1)
end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}

function savelastmsg(){
document.cookie="lastscrollerpos="+memoryscroller.style.left
}

function revivelastmsg(){
lastscrollerpos=parseInt(get_cookie("lastscrollerpos"))
memoryscroller.style.left=parseInt(lastscrollerpos)+"px"
}

if (persistlastviewedmsg && persistmsgbehavior=="onload")
window.onunload=savelastmsg

function scrollmarquee(){
if (parseInt(memoryscroller.style.left)>(actualwidth*(-1)+8))
memoryscroller.style.left=parseInt(memoryscroller.style.left)-copyspeed+"px"
else{
memoryscroller.style.left=parseInt(memorywidth)+8+"px";
text_ind = (text_ind + 1 ) %3;

}
}

if (iedom){
with (document){
document.write('<div class="rt"><table  border="0" cellspacing="0" cellpadding="0" style="'+combinedcssTable+'"><td>')
write('<div style="position:relative;overflow:hidden;'+combinedcss+'" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=memoryspeed" class="outer" >')
write('<div id="memoryscroller" style="position:absolute;left:0px;top:1px;" '+divonclick+'></div>')
write('</div>')
document.write('</td></table></div>')
}
}
</script>
