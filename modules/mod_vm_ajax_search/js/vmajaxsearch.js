
function search_vm_ajax_live(el, prods, lang, myid, url)
{
  str = ajop_escape(el.value, myid);
console.log(el.value);
  var res = document.getElementById("vm_ajax_search_results2"+myid);
  var str_s = jQuery('#vm_ajax_search_search_str2'+myid).val();

 if (res.style.display == 'block') {
	var new_str_flag = false;
	jQuery( ".record_result" ).each(function() {
       var record_result = jQuery(this).attr("rel");
       if (record_result == str_s) {
    	   new_str_flag = true;
       }
	});
	 
   if (new_str_flag == true) {
	  return false;
   }
 }
	
  if (search_timer[myid] != null)
  {
   clearInterval(search_timer[myid]); 
  }
  query = "&keyword="+str+"&prods="+prods+"&lang="+lang+"&myid="+myid;

  if (query == op_last_request)
   {
	
	var res = document.getElementById("vm_ajax_search_results2"+myid);
	if (res.style.display == 'none')
	 {
	   
	   if ((typeof jQuery != 'undefined') && (typeof jQuery.fx != 'undefined'))
	   jQuery('#vm_ajax_search_results2'+myid).fadeIn(700, function() { ; }); 
	   else 
	   res.style.display = 'block'; 

	 }
	 else res.style.display = 'block';
	 
	 return true; 
   }
  else
  {
  op_last_request = query; 
   

  }
  if (prods == null) prods = 5;
  if (str.length==0)
  {
   hide_results_live(myid);
   return;
  }
  
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
	else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  xmlhttp.onreadystatechange=function()
  {
  
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
 	
    var res = document.getElementById("vm_ajax_search_results2"+myid);
    res.style.border="1px solid #A5ACB2";
	
	el = document.getElementById('vm_ajax_search_search_str2'+myid); 
	
	x=getX(el); 
	y=getY(el); 
	
	
    res.style.left = x+'px'; 
	res.style.top = y+40+'px'; 
	res.position = 'absolute'; 
	
	
	
   
	res.innerHTML=xmlhttp.responseText;
	
	op_active_el = res;
	op_active_row = document.getElementById(res.id+'_0');
	op_active_row_n = -1;
	//setActive(op_active_row, op_active_row_n); 
	
	if (res.style.display == 'none')
	 {
	   if ((typeof jQuery != 'undefined') && (typeof jQuery.fx != 'undefined'))
	   jQuery('#vm_ajax_search_results2'+myid).fadeIn(50, function() { ; }); 
	   else 
	   res.style.display = 'block'; 

	 }
	 else res.style.display = 'block'; 
	 
	
    }
  }


  // "/modules/mod_vm_ajax_search/ajax/index.php"
xmlhttp.open("POST", url, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  

xmlhttp.send(query);

}

function getRow(id)
{
  ida = id.split('_'); 
  return ida[ida.length - 1];
  
  
}

function getModuleId(id)
{
  ida = id.split('_'); 
  if (ida.length>2)
  return ida[ida.length - 3];
  else return 0; 
}

function op_hoverme(el)
{
/*
        var d = document.getElementsByName('op_ajax_results'); 
		for (var i = 0; i<d.length; i++)
		{
		  if (d[i].style.display != 'none')
		  {
		    if (op_active_row_n != getRow(d[i].id))
			{
		     op_active_el = d[i];
			 op_active_row = document.getElementById(d[i].id+'_0');
			 op_active_row_n = 0;
			}
			else
			{
			 op_active_row = document.getElementById(d[i].id+'_'+op_active_row_n);
			 if (op_active_row != null)
			 op_active_row.style.backgroundColor = 'white';
			}
			break;
		  }
		}
		if (op_active_el == null) return true;
 */
 setActive(el); 
}


// el is element of the row
function setActive(el, rown)
{
  jQuery('.record_result').removeClass('selectedRow');
  if (rown == null)
   {
     rown = getRow(el.id); 
   }
  
 if (el == null) return;
 if (op_active_row!=null && (el != op_active_row))
 {
  // restore the original color
  //c = el.getAttribute('savedcolor');
  //if (c != null)
  //el.backgroundColor = c; 
  op_active_row.className = op_active_row.className.split(' selectedRow').join(''); 
  
  //op_active_row.style.backgroundColor = 'white';
 }
 op_active_row = el;
 
 if (rown != null)
 {  
	op_active_row_n = rown;
 }
 else
 {
 
 ida = el.id.split('_'); 
 op_active_row_n = ida[ida.length - 1];
 }

 if ((el.getAttribute('savedcolor') == null) || (el.getAttribute('savedcolor') == ''))
  el.setAttribute('savedcolor', el.style.backgroundColor); 
 
 c = el.getAttribute('savedcolor');
 
 //el.style.backgroundColor = el.savedcolor;  
 //el.focus(); 
 if (el.className.indexOf('selectedRow')<=0)
 el.className += ' selectedRow'; 
 
 op_active_row = el;

 
}



function getOffset( el ) {
    var _x = 0;
    var _y = 0;
    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
    }
    return { top: _y, left: _x };
}

function hide_now(myid)
{
  // last check
  el = document.getElementById('vm_ajax_search_search_str2'+myid); 
  if (search_has_focus != null)
  if (!search_has_focus[myid])
  {
    if (typeof jQuery != 'undefined')
	{
     jQuery('#vm_ajax_search_results2'+myid).fadeOut('fast', function() { ; }); 
	}
	else
    document.getElementById('vm_ajax_search_results2'+myid).style.display = 'none'; 
  }
}

function hide_results_live(myid)
{ 
 
 if (typeof(search_timer)=='undefined')
  {
    var search_timer = new Array(); 
  }
 if (typeof(search_timer[myid])=='undefined')
  {
     search_timer[myid] = null; 
  }
 search_timer[myid] = setInterval(function(){ hide_now(myid); },100);
 return false; 
}

function search_setText(text, e, myid)
{
 search_has_focus[myid] = false; 
 //return;
 if (e.value == '')
 {
  if (op_savedtext[myid] != null)
  document.getElementById('label_'+e.id).innerHTML = op_savedtext[myid]; 
 }
 setTimeout( function() { hide_results_live(myid); }, 100);
 //aj_inputreset(e);
 //e.value = text;
 //hide_results_live();
 return true;
}

/* 
     Example File From "JavaScript and DHTML Cookbook"
     Published by O'Reilly & Associates
     Copyright 2003 Danny Goodman
*/
function handleArrowKeys(evt, myid) {
    evt = (evt) ? evt : ((window.event) ? event : null);
	/*
	main = document.getElementById('vm_ajax_search_results2'+myid); 
	if (main.style.diplay == 'none') return true; 
	*/
    if (evt) {
	    
		// ctrl alt F
		if (evt.ctrlKey && evt.altKey && evt.keyCode == 70)
		{
			setFocusInput(); 
			return; 
        } 		

		
        var d = document.getElementsByName('op_ajax_results'); 
		for (var i = 0; i<d.length; i++)
		{
		  
		  if (d[i].style.display != 'none')
		  {
		    if (op_active_el != d[i])
			{
		     op_active_el = d[i];
			 //op_active_row = document.getElementById(d[i].id+'_0');
			 //op_active_row_n = 0;
			 
			}
			else
			{
			 //op_active_row = document.getElementById(d[i].id+'_'+op_active_row_n);
			 //if (op_active_row != null)
			 //op_active_row.style.backgroundColor = 'white';
			}
			break;
		  }
		}
		
		
		if (op_active_el == null) return true;
		
		
		
        switch (evt.keyCode) {
            case 37:
				
				
                break;    
            case 38:
				// up

				op_active_row_n = parseInt(op_active_row_n);
				op_active_row_n = op_active_row_n - 1;
				
				if (op_active_row_n < 0) {
					aj_setkeyword(jQuery('#kw_search').val());
					jQuery('.record_result').removeClass('selectedRow');
					op_active_row_n = -1;
					return false;
				}
				
				//op_active_row_n = 0;
				//alert(op_active_row_n);
				myid = getModuleId(op_active_el.id); 
                el = document.getElementById('vm_ajax_search_results2'+myid+'_'+op_active_row_n);
				
				setActive(el, op_active_row_n);
				var key_search = jQuery('.selectedRow').attr('rel');
				if (key_search != 'undefined') {
					aj_setkeyword(key_search);
				}
                return false;
            case 39:
				// right
                //alert('39'); 
                return false;
            case 40:
				// down
				op_active_row_n = parseInt(op_active_row_n);
				op_active_row_n = parseInt(op_active_row_n) + 1;
				
				if (parseInt(op_active_row_n) > op_maxrows) {
					aj_setkeyword(jQuery('#kw_search').val());
					jQuery('.record_result').removeClass('selectedRow');
					
					op_active_row_n = -1;
					return false;
				}
				//alert(op_active_row_n);
				myid = getModuleId(op_active_el.id); 
                el = document.getElementById('vm_ajax_search_results2'+myid+'_'+op_active_row_n);
				setActive(el, op_active_row_n);
				

				var key_search = jQuery('.selectedRow').attr('rel');
				if (key_search != 'undefined') {
					aj_setkeyword(key_search);
				}
                return false;
			case 27:
			  // escape
			  op_active_el.style.display = 'none';
			  return false;
			case 13:
			    // value of the row
				myid = getModuleId(op_active_el.id); 
				rown = op_active_row_n; 
				
				
				d1 = document.getElementById('vm_ajax_search_results2_'+myid+'_value_'+op_active_row_n);
				if (d1 != null) 
				 { 
				  // current input element
				    
				  	return op_processCmd(op_process_cmd, d1.value, op_active_el.id,  op_active_row_n); 
				 
				 
				 }
				 else
				 {
					 d1 = document.getElementById('org_kw_search');
					 return op_processCmd(op_process_cmd, d1.value, op_active_el.id,  op_active_row_n); 
				  //alert (op_active_el.id+'_value_'+op_active_row_n);
				  //alert('2:'+d2.value);
				 }
				//op_active_el.style.display = 'none';
				return false;
         }
    }
}

function op_processCmd(cmd, value, id, row)
{
  if (cmd == 'href')
   document.location = value; 
  return false; 
}
function setFocusInput()
{
/*
   var search_timer = new Array(); 
		  var search_has_focus = new Array(); 
		  var op_active_el = null;
		  var op_active_row = null;
          var op_active_row_n = parseInt("0");
		  var op_last_request = ""; 
          var op_process_cmd = "href"; 
		  var op_controller = ""; 
		  var op_lastquery = "";
		  var op_maxrows = '.$prods.'; 
		  var op_lastinputid = "vm_ajax_search_search_str2'.$myid.'";
		  var op_currentlang = "'.$clang.'";
		  var op_lastmyid = "'.$myid.'"; 
		  var op_ajaxurl = "'.$url.'";
		 */
		 d = document.getElementById(op_lastinputid); 
		 aj_inputclear(d, op_maxrows+1, op_currentlang, op_lastmyid, op_ajaxurl); 
		 d.focus(); 
}
function aj_inputclear(what, prods, lang, myid, url){
  search_has_focus[myid] = true; 
  op_savedtext[myid] = document.getElementById('label_'+what.id).innerHTML; 
  document.getElementById('label_'+what.id).innerHTML = ''; 
  if (what.value != '')
   {
     search_vm_ajax_live(what, prods, lang, myid, url); 
   }
}

function aj_inputreset(what)
{
 //if (what.value == '')
 //document.getElementById('label_'+what.id).innerHTML = document.getElementById('saved_'+what.id).value; 
}

function getY( oElement )
{
var iReturnValue = 0;
while( oElement != null ) {
iReturnValue += oElement.offsetTop;
oElement = oElement.offsetParent;
}
return iReturnValue;
}

function getX( oElement )
{
var iReturnValue = 0;
while( oElement != null ) {
iReturnValue += oElement.offsetLeft;
oElement = oElement.offsetParent;
}
return iReturnValue;
} 


  function ajop_escape(str, myid)
  {
   
   //var x1 = document.getElementById('results_re_2'+myid);
   
   //if (x1 == null || (typeof x1 == 'undefined')) str = '';
   if ((typeof(str) != 'undefined') && (str != null))
   {
     x = str.split("&").join("%26");
     x = str.split(" ").join("%20");
	 
     return x;
   }
   else 
   {
   
   return "";
   }
   return "";
  }

function aj_redirect(id)
{

  x = document.getElementById(id);
  if (x!=null)
  {
    if (x.href != null)
    {
      window.location = x.href;
     
    }
    else
    {
      
    }
  }
  
}
function aj_setkeyword(keyword)
{

//  x = document.getElementById(keyword);
  document.getElementById('vm_ajax_search_search_str2147').value=keyword;
//  document.getElementById('saved_vm_ajax_search_search_str2147').value=keyword;
//  if (x!=null)
//  {
//    if (x.href != null)
//    {
//     // window.location = x.href;
//     document.getElementById('vm_ajax_search_search_str2147').value=id;
//    }
//    else
//    {
//      
//    }
//  }
  
}