<?php
/**
 *
 * Template for the shipment selection
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: cart.php 2400 2010-05-11 19:30:47Z milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$session = & JFactory::getSession();
$session->set('check', 2);
?>
<script language=javascript>
var preId;
var preIdChild;
var preLabel;
var prePlace;
function output(myRadio){    
    if(typeof(preId) !== 'undefined' && preId !== null){
       document.getElementById('shipment_description_'+preId).style.display = 'none'; 
    }
//    document.getElementById('billTotalShipment').innerHTML = '11';
    document.getElementById('shipment_description_'+myRadio).style.display = 'inline';
    preId = myRadio;
    if(typeof(preIdChild) !== 'undefined' && preIdChild !== null){
       document.getElementById(preIdChild).checked = false;
    }
    document.getElementById('shipmentHourRequire').value = 0;
}
function output2(myRadio){
    if(typeof(preId) !== 'undefined' && preId !== null){
       document.getElementById('shipment_description_'+preId).style.display = 'none'; 
    }
    document.getElementById('shipment_description_'+myRadio).style.display = 'inline';
    preId = myRadio;
    if(typeof(preIdChild) !== 'undefined' && preIdChild !== null){
       document.getElementById(preIdChild).checked = false;
    }
    document.getElementById('shipmentHourRequire').value = 1;
//    document.getElementById('billTotalShipment').innerHTML = '11';
}
function setIdChild( idChild){
    preIdChild = idChild;
}
function selectradio(myradio){
    document.getElementById('shipment_time').value='';
    if(typeof(preId) !== 'undefined' && preId !== null){
       document.getElementById(preId).style.backgroundColor = 'transparent';
    }
    if(typeof(preLabel) !== 'undefined' && preLabel !== null){
       document.getElementById(preLabel).innerHTML = '';
    }
    if(typeof(prePlace) !== 'undefined' && prePlace !== null){
       document.getElementById(prePlace).value = '';
    }
    if(document.querySelector('input[name="shipment_hour"]:checked') != null){
        document.querySelector('input[name="shipment_hour"]:checked').checked = false;
    }

    document.getElementById('shipment_place').value='';// edit
    document.getElementById('shipment_hour_13').value = '';
    document.getElementById('shipment_15').innerHTML = '';
    document.getElementById('shipment_16').innerHTML = '';
    document.getElementById('shipment_17').innerHTML = '';
    
}
function selectTimeDelivery(idselect, idlabel, idDiv, radio_parent){
    if(!document.getElementById(radio_parent).checked){
        alert('Kindly select method');
        return;
    }
    if(typeof(preId) !== 'undefined' && preId !== null){
       document.getElementById(preId).style.backgroundColor = 'transparent';
    }
	if (jQuery("#"+idDiv+" a").hasClass('disabled')){
		document.getElementById(idlabel).innerHTML="";
		document.getElementById('shipment_time').value="";
		return false;
	}
    preId = idDiv;
    preLabel = idlabel;
    document.getElementById(idlabel).innerHTML=document.getElementById(idselect).innerHTML;
    document.getElementById('shipment_time').value=document.getElementById(idselect).innerHTML;
    document.getElementById(idDiv).style.backgroundColor = '#b60d9d';
}
function selectshipmenthour(myradio, radio_parent, div){	
	jQuery("a").removeClass('disabled');
	if (document.getElementById(myradio).value == "<?php echo date('d-M-Y') ?>") {
		var h = <?php echo date('H') ?>;		
		if (h>=9){
			jQuery("#"+div+" #btnSelectDeliveryTime1").addClass('disabled');
		}
		if (h>=12){
			jQuery("#"+div+" #btnSelectDeliveryTime2").addClass('disabled');
		}
		if (h>=17){
			jQuery("#"+div+" #btnSelectDeliveryTime3").addClass('disabled');
		}
	};
    if(document.querySelector('input[name="virtuemart_shipmentmethod_id"]:checked') != null){
        document.querySelector('input[name="virtuemart_shipmentmethod_id"]:checked').checked = false;
    }    
    if(document.querySelector('input[name="shipment_hour"]:checked') != null){
        document.querySelector('input[name="shipment_hour"]:checked').checked = false;
    }    
    document.getElementById(radio_parent).checked = true;
    document.getElementById(myradio).checked = true;

//    document.getElementById('shipment_15').innerHTML = '';
//    document.getElementById('shipment_16').innerHTML = '';
//    document.getElementById('shipment_17').innerHTML = '';
//    if(typeof(preId) !== 'undefined' && preId !== null){
//        document.getElementById(preId).style.backgroundColor = 'transparent';
//    }
}
function onchangeplace(myradio,radio_parent){
    if(document.querySelector('input[name="virtuemart_shipmentmethod_id"]:checked') != null){
        document.querySelector('input[name="virtuemart_shipmentmethod_id"]:checked').checked = false;
    }
    document.getElementById(radio_parent).checked = true;
    if(document.querySelector('input[name="shipment_hour"]:checked') != null){
        document.querySelector('input[name="shipment_hour"]:checked').checked = false;
    }
    document.getElementById('shipment_place').value = document.getElementById(myradio).value;

//    document.getElementById('shipment_15').innerHTML = '';
//    document.getElementById('shipment_16').innerHTML = '';
//    document.getElementById('shipment_17').innerHTML = '';
//    if(typeof(prePlace) !== 'undefined' && prePlace !== null){
//       document.getElementById(prePlace).value = '';
//    }
//    if(typeof(preId) !== 'undefined' && preId !== null){
//       document.getElementById(preId).style.backgroundColor = 'transparent';
//    }
    prePlace = myradio;
}
</script>
<h2 style="color: #B60D9D;margin: 5px 5px 15px 5px;font-size: 20px;">Shipping Methods</h2>
<div style="width: 100%;">
    <a href="index.php?option=com_users&view=regrequire">
        <img src="components/com_virtuemart/assets/images/sign_in_inactive.jpg"/>
    </a>
    <a href="index.php?option=com_virtuemart&amp;view=user&amp;task=editaddresscheckout&amp;tab=viewaddress">
        <img src="components/com_virtuemart/assets/images/shipping_address_inactive.jpg"/>
    </a>
    <img src="components/com_virtuemart/assets/images/shipping_method_active.jpg"/>
    <?php if(!empty($this->cart->virtuemart_paymentmethod_id) && $this->cart->virtuemart_paymentmethod_id > 0){?>
        <a href="index.php?option=com_virtuemart&view=cart&task=editpayment">
            <img src="components/com_virtuemart/assets/images/payment_method_inactive.jpg"/>
        </a>
        <a href="index.php?option=com_virtuemart&view=cart">
            <img src="components/com_virtuemart/assets/images/confirmation.jpg"/>
        </a>
    <?php }else { ?>
        <img src="components/com_virtuemart/assets/images/payment_method_inactive.jpg"/>
        <img src="components/com_virtuemart/assets/images/confirmation.jpg"/>
    <?php } ?>    
</div>
<label id ="billTotalShipment">
<?php
//echo ($this->cart->pricesUnformatted['billTotal']);
?>
</label>
<form method="post" id="userForm" name="chooseShipmentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">
<style>
tr {border: 1px solid #CCC;}
td {border: 1px solid #CCC; padding: 10px;}

.disabled {
  color: grey!important; 
}
</style>
<table style="width:100%">
<tr >
	<td colspan="2" >
	<div align="center">
	<br/>
	Thank you for your order!
	<br/>
	<br/>
	</div>
	</td>
</tr >
	<tr >
		<td width="50%" ><div align="right"><br/>Your Total Purchase Amount:&nbsp;&nbsp;&nbsp;<br/><br/></div></td>
		<td><br/>&nbsp;&nbsp;&nbsp;<?php echo ($this->cart->pricesUnformatted['billTotal']);?><br/><br/></td>
	</tr>
        <tr >
		<td width="50%" ><div align="right"><br/>Shopping Points Redemptions :&nbsp;&nbsp;&nbsp;<br/><br/></div></td>
		<td><br/>&nbsp;&nbsp;&nbsp;Valued at : <?php echo $this->currencyDisplay->priceDisplay($this->cart->rewardPointsDiscount) ?><br/><br/></td>
	</tr>
        <tr >
		<td width="50%" ><div align="right"><br/>Gift Vouchers or Discount Coupons :&nbsp;&nbsp;&nbsp;<br/><br/></div></td>
		<td><br/>&nbsp;&nbsp;&nbsp;Valued at : <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPriceCoupon']) ?><br/><br/></td>
	</tr>
	<tr>
            <td colspan="2" style="padding-left: 10px;">
	All orders will be processed and dispatched within 12hours. We need at least 4 hours in advance notice to
        arrange for Same day Delivery Service <br/>
        For Singapore order, delivery will be within 1 to 3 working days.<br/>
        A surcharge within $15 to $25 is imposed for an order below a certain purchase amount.<br><br>
        The daily Courier service delivery are:<br/>
        <label style="color: #B00C97;">9AM to 12PM / 2PM to 5PM / 5PM to 8 PM</label><br/>
        Please click the link here for more Delivery details and Method:
        <a href="index.php?option=com_content&view=article&id=29&Itemid=148" style="color: #B00C97;">www.U4riashop.com/delivery_policy</a>
	<br/><br/><br/>
        </td>
</tr>
<tr>
	<td colspan="2" style="padding-left: 10px;">
	<label style="color: #B00C97;">Shipping Method for local Delivery </label><br/><br/>	
        Free delivery will apply to specific delivery methods listed below. Kindly go through our list
        of shipping methods and indicate your preference. If you have any question, call us at +65 63377463
        or send an email to us at u4riashop@gmail.com <br/><br/><br/>
	</td>
</tr>
<tr>
    <td colspan="2" style="text-align: center; font-weight: bold;">
	<br/>
	Please select one of the shipping method below
	<br/>
	<br/>
	</td>
</tr>
</table >
<table  style="width:100%">
    <?php
    if ($this->found_shipment_method) {	   
	// if only one Shipment , should be checked by default
                foreach ($this->shipments_list as $shipment_shipment_rates) {
		    foreach ($shipment_shipment_rates as $shipment_shipment_rate) {
                        $checked = ($this->cart->virtuemart_shipmentmethod_id 
                                == $shipment_shipment_rate->virtuemart_shipmentmethod_id
                                    ? "checked='true'" : "");
                        
                        ?> <tr><td width="50%"> <?php
			echo ('<label style="font-weight: bold;">'.$shipment_shipment_rate->shipment_name.'</label>');
                        echo ($shipment_shipment_rate->shipment_desc);
			?> </td>
			<td>
                            
			<?php 
                        if($shipment_shipment_rate->virtuemart_shipmentmethod_id == 13){ ?>      
                            <div class="sm_title" style="width: 50%;float: left; color: #b60d9d;">
                                Kindly enter your preferred <br>
                                MRT station
                                
                            </div>
                            <div class="sm_input" style="width: 50%;float: left;">
                                <input id="shipment_hour_13" type="text" name="shipment_place" style="width: 80%;"
                                       onchange="onchangeplace('shipment_hour_13','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id; ?>')"
                                       value="<?php
                                       if ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id){
                                        echo $this->cart->shipment_place ;
                                    } ?>"/>
                            </div>
                            <div style="clear: both; padding-bottom: 20px;"></div>
                    <?php } ?>
                            <?php 
                        if($shipment_shipment_rate->virtuemart_shipmentmethod_id == 14){ 
                            if((strcmp($this->cart->shipment_hour ,'MRT Station : City Hall') == 0)
                                            && ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id)){
                                        $checked3 = " checked='true'";
                                    }else{
                                        $checked3 = "";
                                    }
                            if((strcmp($this->cart->shipment_hour ,'MRT Station : Somerset') == 0)
                                            && ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id)){
                                        $checked4 = " checked='true'";
                                    }else{
                                        $checked4 = "";
                                    }
                            if((strcmp($this->cart->shipment_hour ,'MRT Station : PayaLebar') == 0)
                                            && ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id)){
                                        $checked5 = " checked='true'";
                                    }else{
                                        $checked5 = "";
                                    }
                            ?>      
                            <div class="sm_title" style="width: 50%;float: left; color: #b60d9d;">
                                Kindly enter your preferred <br>
                                MRT station
                                
                            </div>
                            <div class="sm_input"  style="width: 50%;float: left;">
                                <input id="shipment_hour_19" type="radio" name="shipment_hour" value="MRT Station : City Hall" 
                                       <?php echo $checked3;?>
                                       onclick="selectshipmenthour('shipment_hour_19','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')" />
                                <span style="line-height: 1.3em;">City Hall </span><br>
                                <input id="shipment_hour_20" type="radio" name="shipment_hour" value="MRT Station : Somerset" 
                                    <?php echo $checked4;?>
                                        onclick="selectshipmenthour('shipment_hour_20','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')" />
                                <span style="line-height: 1.3em;">Somerset </span><br>
                                <input id="shipment_hour_21" type="radio" name="shipment_hour" value="MRT Station : PayaLebar" 
                                       <?php echo $checked5;?> 
                                       onclick="selectshipmenthour('shipment_hour_21','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')" />
                                <span style="line-height: 1.3em;">PayaLebar </span>
                            </div>
                            <div style="clear: both; padding-bottom: 20px;"></div>
                    <?php } ?>
                            <?php 
                        if($shipment_shipment_rate->virtuemart_shipmentmethod_id == 15){ 
                            $nowDate = date('Y-m-d');
                            ?>      
                            <div>
                                <?php for ($index = 0; $index < 5; $index++) {
                                    if((strcmp($this->cart->shipment_hour ,
                                            date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)))) == 0)
                                            && ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id)){
                                        $checked2 = " checked='true'";
                                    }else{
                                        $checked2 = "";
                                    }
                                     echo '<input type="radio" name="shipment_hour" '.$checked2
                                             .' id="shipment_hour_'.$shipment_shipment_rate->virtuemart_shipmentmethod_id.$index
                                             .'" onclick="selectshipmenthour(\'shipment_hour_'.$shipment_shipment_rate->virtuemart_shipmentmethod_id.$index
                                             .'\',\'virtuemart_shipmentmethod_id_' . $shipment_shipment_rate->virtuemart_shipmentmethod_id.'\',\'div3\')" value="'
                                    .date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)) ).'" /> '
                                    .'<span style="line-height: 1.3em;">'.
                                             date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)) ).
                                             '</span>';
                                     if($index == 2){
                                         echo "<br>";
                                     }
                                    else {
                                        echo "<br class='sm_br' style='display: none'>";
                                    }
                               }
                               ?>
                                <label id="shipment_15" style="padding-left: 10px; font-weight: bold;">
                                    <?php 
                                    if ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id){
                                        echo $this->cart->shipment_time ;
                                    }?>
                                </label> 
                            </div>
                            <div class="sm_dt" style="border: 1px solid #CCC; margin: 20px;" id="div3">
                                <div style="height: 20px; border-bottom: 1px solid #CCC; text-align: center;">
                                    Delivery time
                                </div>
                                <div class="sm_dt_item" style="height: 20px; border-bottom: 1px solid #CCC; padding-left: 30px;"
                                     id="div151">
                                    <a id="btnSelectDeliveryTime1" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime1','shipment_15','div151','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime1">9AM to 12PM</label>
                                </div>
                                <div class="sm_dt_item" id="div152" style="height: 20px; border-bottom: 1px solid #CCC; padding-left: 30px;">
                                    <a id="btnSelectDeliveryTime2" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime2','shipment_15','div152','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime2">2PM to 5PM</label>
                                </div>
                                <div class="sm_dt_item" id="div153" style="height: 20px; padding-left: 30px;">
                                    <a id="btnSelectDeliveryTime3" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime3','shipment_15','div153','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime3">5PM to 8PM</label>
                                </div>
                                
                            </div>
                            <div style="clear: both; padding-bottom: 20px;"></div>
                    <?php } ?>
                    <?php 
                        if($shipment_shipment_rate->virtuemart_shipmentmethod_id == 16){ 
                            $nowDate = date('Y-m-d');
                            ?>      
                            <div>
                                <?php for ($index = 0; $index < 5; $index++) {
                                    if((strcmp($this->cart->shipment_hour ,
                                            date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)))) == 0)
                                            && ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id)){
                                        $checked2 = " checked='true'";
                                    }else{
                                        $checked2 = "";
                                    }
                                     echo '<input type="radio" name="shipment_hour" '.$checked2
                                             .' id="shipment_hour_'.$shipment_shipment_rate->virtuemart_shipmentmethod_id.$index
                                             .'" onclick="selectshipmenthour(\'shipment_hour_'.$shipment_shipment_rate->virtuemart_shipmentmethod_id.$index
                                             .'\',\'virtuemart_shipmentmethod_id_' . $shipment_shipment_rate->virtuemart_shipmentmethod_id.'\',\'div1\')" value="'
                                    .date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)) ).'" /> '
                                    .'<span style="line-height: 1.3em;">'.
                                             date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)) ).
                                             '</span>';
                                     if($index == 2){
                                         echo "<br>";
                                     }
                                     else {
                                         echo "<br class='sm_br' style='display: none'>";
                                     }
                               }
                               ?>
                                <label id="shipment_16" style="padding-left: 10px; font-weight: bold;">
                                    <?php 
                                    if ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id){
                                        echo $this->cart->shipment_time ;
                                    }?>
                                </label> 
                            </div>
                            <div class="sm_dt" style="border: 1px solid #CCC; margin: 20px;" id="div1">
                                <div style="height: 20px; border-bottom: 1px solid #CCC; text-align: center;">
                                    Delivery time
                                </div>
                                <div class="sm_dt_item" style="height: 20px; border-bottom: 1px solid #CCC; padding-left: 30px;"
                                     id="div161">
                                    <a id="btnSelectDeliveryTime1" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime1','shipment_16','div161','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime1">9AM to 12PM</label>
                                </div>
                                <div class="sm_dt_item" id="div162" style="height: 20px; border-bottom: 1px solid #CCC; padding-left: 30px;">
                                    <a id="btnSelectDeliveryTime2" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime2','shipment_16','div162','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime2">2PM to 5PM</label>
                                </div>
                                <div class="sm_dt_item" id="div163" style="height: 20px; padding-left: 30px;">
                                    <a id="btnSelectDeliveryTime3" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime3','shipment_16','div163','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime3">5PM to 8PM</label>
                                </div>
                                
                            </div>
                            <div style="clear: both; padding-bottom: 20px;"></div>
                    <?php } ?>
                    <?php 
                        if($shipment_shipment_rate->virtuemart_shipmentmethod_id == 122){ 
                            $nowDate = date('Y-m-d');
                            ?> 
                            <div class="sm_title" style="width: 30%;float: left; color: #b60d9d;">
                                Hotel Name 
                                
                            </div>
                            <div class="sm_input" style="width: 70%;float: left;">
                                <input id="shipment_hour_122" type="text" name="shipment_place" style="width: 80%;"
                                       onchange="onchangeplace('shipment_hour_122','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id; ?>')"
                                       value="<?php
                                       if ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id){
                                        echo $this->cart->shipment_place ;
                                    } ?>"/>
                            </div>
                            <div style="clear: both;"></div>
                            <div>
                                <?php for ($index = 0; $index < 5; $index++) {
                                    if((strcmp($this->cart->shipment_hour ,
                                            date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)))) == 0)
                                            && ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id)){
                                        $checked2 = " checked='true'";
                                    }else{
                                        $checked2 = "";
                                    }
                                     echo '<input type="radio" name="shipment_hour" '.$checked2
                                             .' id="shipment_hour_'.$shipment_shipment_rate->virtuemart_shipmentmethod_id.$index
                                             .'" onclick="selectshipmenthour(\'shipment_hour_'.$shipment_shipment_rate->virtuemart_shipmentmethod_id.$index
                                             .'\',\'virtuemart_shipmentmethod_id_' . $shipment_shipment_rate->virtuemart_shipmentmethod_id.'\',\'div2\')" value="'
                                    .date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)) ).'" /> '
                                    .'<span style="line-height: 1.3em;">'.
                                             date('d-M-Y', strtotime('+'.$index. 'day', strtotime($nowDate)) ).
                                             '</span>';
                                     if($index == 2){
                                         echo "<br>";
                                     }
                                     else {
                                         echo "<br class='sm_br' style='display: none'>";
                                     }
                               }
                               ?>
                                <label id="shipment_17" style="padding-left: 10px; font-weight: bold;">
                                    <?php 
                                    if ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id){
                                        echo $this->cart->shipment_time ;
                                    }?>
                                </label> 
                            </div>
                            <div class="sm_dt" style="border: 1px solid #CCC; margin: 20px;" id="div2">
                                <div style="height: 20px; border-bottom: 1px solid #CCC; text-align: center;">
                                    Delivery time
                                </div>
                                <div class="sm_dt_item" style="height: 20px; border-bottom: 1px solid #CCC; padding-left: 30px;"
                                     id="div171">
                                    <a id="btnSelectDeliveryTime1" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime1','shipment_17','div171','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime1">9AM to 12PM</label>
                                </div>
                                <div class="sm_dt_item" id="div172" style="height: 20px; border-bottom: 1px solid #CCC; padding-left: 30px;">
                                    <a id="btnSelectDeliveryTime2" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime2','shipment_17','div172','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime2">2PM to 5PM</label>
                                </div>
                                <div class="sm_dt_item" id="div173" style="height: 20px; padding-left: 30px;">
                                    <a id="btnSelectDeliveryTime3" style="padding-right: 10px; color: #b60d9d"
                                        href="javascript:void(0);"
                                       onclick="selectTimeDelivery('lblDeliveryTime3','shipment_17','div173','virtuemart_shipmentmethod_id_<?php echo $shipment_shipment_rate->virtuemart_shipmentmethod_id ;?>')">Select</a>
                                    <label id="lblDeliveryTime3">5PM to 8PM</label>
                                </div>
                                
                            </div>
                            <div style="clear: both; padding-bottom: 20px;"></div>
                    <?php } ?>        
                            <div>
                        <?php
                        echo "Total weight: ".$this->orderWeight.$shipment_shipment_rate->weight_unit;
                        echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ".$shipment_shipment_rate->priceShipment;
                        echo '<input type="radio" style="float : right;" name="virtuemart_shipmentmethod_id"'.
                                'onClick="selectradio('.$shipment_shipment_rate->virtuemart_shipmentmethod_id.')"'.
                            'id="virtuemart_shipmentmethod_id_' . $shipment_shipment_rate->virtuemart_shipmentmethod_id.
                                '"   value="' . $shipment_shipment_rate->virtuemart_shipmentmethod_id. '" ' . $checked . ">";
                        
			?>
                            </div> 
                        </td>
			</tr><?php
		    }	
	    }
    
    } else {
	 echo "<h1>".$this->shipment_not_found_text."</h1>";
    }
    ?>
	</table>
    <div style="clear: both;"></div>
    <table  style="width:100%;">
        <tr>
            <td style="padding: 10px;">
                Please do not hesitate to email at u4riashop@gmail.com or reach Benson at 63377463/98515156 should you have other
                specific requirements.
            </td>
        </tr>
        
    </table>
<!--    <table  style="width:100%;">-->
<!--        <tr>-->
<!--            <td style="padding: 10px;">-->
<!--                <label style="font-weight: bold">-->
<!--                To add comments, requests, special messages ("Happy birthday","Happy Anniversary"), kindly fill in bellow-->
<!--                </label>-->
<!--                <br><br>-->
<!--                <textarea style="width: 95%;height: 70px;"></textarea>-->
<!--                <br><br>-->
<!--                <label style="color : red">-->
<!--                *Kindly make changes of date/time/venue 6 hours before each delivery. A extra amount of $15 will be incurred should-->
<!--                buyers make changes after that                -->
<!--                </label>-->
<!--                <br><br>-->
<!--            </td>-->
<!--        </tr>-->
<!--    </table>-->
<br>
<label style="color: red; font-size:18pt;">
    Total : <?php echo $this->currencyDisplay->priceDisplay($this->cart->pricesUnformatted['salesPrice']) ?>
</label>
<br><br>
<button type="submit" class="regbutton" >SUBMIT >></button>
			&nbsp;<?php echo ' or '?>&nbsp;&nbsp;
<button class="regbutton" type="reset" onClick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&amp;view=user&amp;task=editaddresscheckout&amp;tab=viewaddress'); ?>'" >&lt;&lt; BACK</button>
    <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="view" value="cart" />
    <input type="hidden" name="task" value="setshipment" />
    <input type="hidden" name="controller" value="cart" />
    <input type="hidden" id="shipment_time" name="shipment_time" value="  <?php
    if ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id){
        echo $this->cart->shipment_time ;
    }?>"/>
    <input type="hidden" id="shipment_place" name="shipment_place" value="<?php
    if ($this->cart->virtuemart_shipmentmethod_id == $shipment_shipment_rate->virtuemart_shipmentmethod_id){
        echo $this->cart->shipment_place ;
    } ?>"/>
</form>
