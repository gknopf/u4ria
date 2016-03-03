/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */
 /**
 * 
 */
jQuery.noConflict();
jQuery(document).ready(function($){
 if (document.getElementById('slidebox'))
 {	
	var autoPlayTime=7000;
	autoPlayTimer = setInterval( autoPlay, autoPlayTime);
	$('#slidebox .next').click(function () {
		Slidebox('next','stop');
	});
	$('#slidebox .previous').click(function () {
		Slidebox('previous','stop');
	});
	var yPosition=(jQuery('#slidebox').height()-jQuery('#slidebox .next').height())/2;
	$('#slidebox .next').css('top',yPosition);
	$('#slidebox .previous').css('top',yPosition);
	$('#slidebox .thumbs a:first-child').removeClass('thumb').addClass('selected_thumb');
	$("#slidebox .content").each(function(i){
		slideboxTotalContent=i*$('#slidebox').width();	
		$('#slidebox .container').css("width",slideboxTotalContent+$('#slidebox').width());
	});
 }
 function autoPlay(){
		Slidebox('next');
	}
 function Slidebox(slideTo,autoPlay){
	    var animSpeed=1000; //animation speed
	    var easeType='easeInOutExpo'; //easing type
		var sliderWidth=$('#slidebox').width();
		var leftPosition=$('#slidebox .container').css("left").replace("px", "");
		if( !$("#slidebox .container").is(":animated")){
			if(slideTo=='next'){ //next
				if(autoPlay=='stop'){
					clearInterval(autoPlayTimer);
				}
				if(leftPosition==-slideboxTotalContent){
					$('#slidebox .container').animate({left: 0}, animSpeed, easeType); //reset
					$('#slidebox .thumbs a:first-child').removeClass('thumb').addClass('selected_thumb');
					$('#slidebox .thumbs a:last-child').removeClass('selected_thumb').addClass('thumb');
				} else {
					$('#slidebox .container').animate({left: '-='+sliderWidth}, animSpeed, easeType); //next
					$('#slidebox .thumbs .selected_thumb').next().removeClass('thumb').addClass('selected_thumb');
					$('#slidebox .thumbs .selected_thumb').prev().removeClass('selected_thumb').addClass('thumb');
				}
			} else if(slideTo=='previous'){ //previous
				if(autoPlay=='stop'){
					clearInterval(autoPlayTimer);
				}
				if(leftPosition=='0'){
					$('#slidebox .container').animate({left: '-'+slideboxTotalContent}, animSpeed, easeType); //reset
					$('#slidebox .thumbs a:last-child').removeClass('thumb').addClass('selected_thumb');
					$('#slidebox .thumbs a:first-child').removeClass('selected_thumb').addClass('thumb');
				} else {
					$('#slidebox .container').animate({left: '+='+sliderWidth}, animSpeed, easeType); //previous
					$('#slidebox .thumbs .selected_thumb').prev().removeClass('thumb').addClass('selected_thumb');
					$('#slidebox .thumbs .selected_thumb').next().removeClass('selected_thumb').addClass('thumb');
				}
			} else {
				var slide2=(slideTo-1)*sliderWidth;
				if(leftPosition!=-slide2){
					clearInterval(autoPlayTimer);
					$('#slidebox .container').animate({left: -slide2}, animSpeed, easeType); //go to number
					$('#slidebox .thumbs .selected_thumb').removeClass('selected_thumb').addClass('thumb');
					var selThumb=jQuery('#slidebox .thumbs a').eq((slideTo-1));
					selThumb.removeClass('thumb').addClass('selected_thumb');
				}
			}
		}
	}
});



 function Slidebox(slideTo,autoPlay){
	    var animSpeed=1000; //animation speed
	    var easeType='easeInOutExpo'; //easing type
		
		var sliderWidth=jQuery('#slidebox').width();
		var leftPosition=jQuery('#slidebox .container').css("left").replace("px", "");
		if( !jQuery("#slidebox .container").is(":animated")){
			if(slideTo=='next'){ //next
				if(autoPlay=='stop'){
					clearInterval(autoPlayTimer);
				}
				if(leftPosition==-slideboxTotalContent){
					jQuery('#slidebox .container').animate({left: 0}, animSpeed, easeType); //reset
					jQuery('#slidebox .thumbs a:first-child').removeClass('thumb').addClass('selected_thumb');
					jQuery('#slidebox .thumbs a:last-child').removeClass('selected_thumb').addClass('thumb');
				} else {
					jQuery('#slidebox .container').animate({left: '-='+sliderWidth}, animSpeed, easeType); //next
					jQuery('#slidebox .thumbs .selected_thumb').next().removeClass('thumb').addClass('selected_thumb');
					jQuery('#slidebox .thumbs .selected_thumb').prev().removeClass('selected_thumb').addClass('thumb');
				}
			} else if(slideTo=='previous'){ //previous
				if(autoPlay=='stop'){
					clearInterval(autoPlayTimer);
				}
				if(leftPosition=='0'){
					jQuery('#slidebox .container').animate({left: '-'+slideboxTotalContent}, animSpeed, easeType); //reset
					jQuery('#slidebox .thumbs a:last-child').removeClass('thumb').addClass('selected_thumb');
					jQuery('#slidebox .thumbs a:first-child').removeClass('selected_thumb').addClass('thumb');
				} else {
					jQuery('#slidebox .container').animate({left: '+='+sliderWidth}, animSpeed, easeType); //previous
					jQuery('#slidebox .thumbs .selected_thumb').prev().removeClass('thumb').addClass('selected_thumb');
					jQuery('#slidebox .thumbs .selected_thumb').next().removeClass('selected_thumb').addClass('thumb');
				}
			} else {
				var slide2=(slideTo-1)*sliderWidth;
				if(leftPosition!=-slide2){
					clearInterval(autoPlayTimer);
					jQuery('#slidebox .container').animate({left: -slide2}, animSpeed, easeType); //go to number
					jQuery('#slidebox .thumbs .selected_thumb').removeClass('selected_thumb').addClass('thumb');
					var selThumb=jQuery('#slidebox .thumbs a').eq((slideTo-1));
					selThumb.removeClass('thumb').addClass('selected_thumb');
				}
			}
		}
	}