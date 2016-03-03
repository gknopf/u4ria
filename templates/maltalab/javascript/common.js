
jQuery.noConflict();
jQuery(document).ready(function() {
//    var ctrlDown = false;
//    var ctrlKey = 17, vKey = 86, cKey = 67;
//
//    jQuery(document).keydown(function(e) {
//        if (e.keyCode == ctrlKey) ctrlDown = true;
//    }).keyup(function(e) {
//        if (e.keyCode == ctrlKey) ctrlDown = false;
//    });
//
//    jQuery(document).keydown(function(e) {
//      //disable ctr + V, ctr + C
//      if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey)){
//        alert('Thank You for Visiting Our Website');
//        return false;
//      }
//      //disable ctr + A
//      if (ctrlDown && (e.keyCode == 65 || e.keyCode == 97)) {
//        return false;
//      }
//    });
//    
//    //disable point right 
//    jQuery(document).bind("contextmenu",function(e){
//    	return false;
//    });

    
    jQuery("#add_wishlist").click(function() {
        var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=addwishlist";
        var product_id = jQuery('#virtuemart_product_id').val();
        var parameter = {product_id: product_id};

        jQuery.post(url, parameter, function(res) {
            jQuery('#wish_list_wapper').removeClass('unactive');
            jQuery('.add_all').removeClass('unactive');
            jQuery('#wish_list_list').html(res);
        	jQuery('#add_wishlist_wapper').addClass('unactive');
        	jQuery('#remove_wishlist_wapper').removeClass('unactive');
        });
    });
    
    jQuery("#remove_wishlist").click(function() {
        var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=deletewishlist";
        var product_id = jQuery('#virtuemart_product_id').val();
        var parameter = {product_id: product_id};
        
        jQuery.post(url, parameter, function(res) {
        	jQuery('#add_wishlist_wapper').removeClass('unactive');
        	jQuery('#remove_wishlist_wapper').addClass('unactive');
        });
    });
});
jQuery(document).ready(function($) {
    jQuery(".add_size_price").click(function() {
        var color_size_id = $(this).attr("rel").split('-');
        var color_size_name = $(this).attr("alt");

        $('.color_size').removeClass('color_size_selected');
        $(this).parent().addClass('color_size_selected');

        var general_code_url = $('#general_code').attr('rel');
        general_code_url = general_code_url + '&size_color=' + color_size_name;
        $('#general_code').attr('rel', general_code_url);

        $('.product-fields').find('input').removeAttr('checked');
        $('.product-fields').find('input[value="' + color_size_id[0] + '"]').attr('checked', 'checked');

        if (color_size_id[1] != 'undefined') {
            $('.product-fields').find('input[value="' + color_size_id[1] + '"]').attr('checked', 'checked');
        }


        Virtuemart.product($("form.product"));

        $("form.js-recalculate").each(function() {
            if ($(this).find(".product-fields").length) {
                var id = $(this).find('input[name="virtuemart_product_id[]"]').val();
                Virtuemart.setproducttype($(this), id);
            }
        });
    });




    jQuery("#general_code").click(function() {
        var url = $(this).attr("rel");
        var parameter = {};

        jQuery.post(url, parameter, function(res) {
            jQuery('#general_code_mess_box').dialog({
                autoOpen: false,
                modal: true,
                width: 400,
                height: 150
            });

            jQuery('#general_code_mess_box').html('<br/><center>' + res + '</center>');
            jQuery('#general_code_mess_box').dialog('open');
        });
    });
});


function rm_wishlist_popup() {
    jQuery('#wish_list_list').html('');
    jQuery('#wish_list_wapper').addClass('unactive');
}

function delete_wishlist(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=deletewishlist";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {
        jQuery('#wl_' + id).remove();
        var emptyHtmlFlag = jQuery('#wish_list_list').html();

        if (emptyHtmlFlag == '') {
            rm_wishlist_popup();
        }
    });
}


function delete_wishlist_all()
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=deleteall";
    var parameter = {};

    jQuery.post(url, parameter, function(res) {
        rm_wishlist_popup();
    });
}

function show_wishlist()
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=showwishlist";
    var parameter = {};

    jQuery.post(url, parameter, function(res) {
        jQuery('#wish_list_wapper').removeClass('unactive');

        if (res == 'No data') {
            jQuery('.add_all').addClass('unactive');
            jQuery('#wish_list_list').html('<span style="color:#92278F">' + res + '</span>');
        } else {
            jQuery('#wish_list_list').html(res);
        }
    });
}

function add_compare(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=addcompare";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {

        jQuery('#add_compare').addClass('unactive');
        jQuery('#remove_compare').removeClass('unactive');
        jQuery('#mod_vm_compare').html('Comparison(' + res + ')');
    });
}

function remove_compare(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=deletecompare";
    var parameter = {product_id: id};

    jQuery.post(url, parameter, function(res) {
        jQuery('#remove_compare').addClass('unactive');
        jQuery('#add_compare').removeClass('unactive');
        jQuery('#mod_vm_compare').html('Comparison(' + res + ')');
    });
}

function rm_compare(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=deletecompare";
    var parameter = {product_id: id};

    jQuery.post(url, parameter, function(res) {
        location.reload();
    });
}

function remove_all_compare()
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=deleteallcompare";
    var parameter = {};

    jQuery.post(url, parameter, function(res) {
        location.reload();
    });
}
//Add Comparison
function cl_add_compare(id, name)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=addcompare";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {
        alert('You added product "' + name + '" to comparision');
        jQuery(".compa_on" + id).css("display", "none");
        jQuery(".compa_off" + id).css("display", "block");
    });
}
function cl_rm_compare(id, name)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=deletecompare";
    var parameter = {product_id: id};

    jQuery.post(url, parameter, function(res) {
        alert('You removed product "' + name + '" from comparision');
        jQuery(".compa_on" + id).css("display", "block");
        jQuery(".compa_off" + id).css("display", "none");
    });
}


function remove_all_wishlist()
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=deleteall";
    var parameter = {};

    jQuery.post(url, parameter, function(res) {
        location.reload();
    });
}

function remove_reload_wishlist(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=deletewishlist";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {
        location.reload();
    });
}
//Add Comparison
function cl_add_compare(id, name)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=addcompare";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {
        //   alert('You added product "' + name + '" to comparision');
        jQuery(".compa_on" + id).css("display", "none");
        jQuery(".compa_off" + id).css("display", "block");
    });
}
function cl_rm_compare(id, name)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=deletecompare";
    var parameter = {product_id: id};

    jQuery.post(url, parameter, function(res) {
        //  alert('You removed product "' + name + '" from comparision');
        jQuery(".compa_on" + id).css("display", "block");
        jQuery(".compa_off" + id).css("display", "none");
    });
}

function wishlist_add_compare(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=addcompare";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {

        jQuery('#add_compare_' + id).addClass('unactive');
        jQuery('#remove_compare_' + id).removeClass('unactive');
    });
}

function wishlist_remove_compare(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productcompare&task=deletecompare";
    var parameter = {product_id: id};

    jQuery.post(url, parameter, function(res) {
        jQuery('#add_compare_' + id).removeClass('unactive');
        jQuery('#remove_compare_' + id).addClass('unactive');
    });
}

function update_quantity(product_id)
{
    var quantity_number = jQuery('#product_quantity_' + product_id).val();
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=updatequantity";
    var parameter = {product_id: product_id, quantity_number: quantity_number};

    jQuery.post(url, parameter, function(res) {
    });
}

function wishlist_add_all_compare()
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=addAllToCompate";
    var parameter = {};

    jQuery.post(url, parameter, function(res) {

        jQuery('.icon_uncompare').removeClass('unactive');
        jQuery('.icon_compare').addClass('unactive');

        jQuery('#wishlist_mess_box').attr("title", jQuery('#add_all_compare').attr("title"));
        jQuery('#wishlist_mess_box').dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            height: 150
        });

        res = jQuery.parseJSON(res);
        jQuery('#wishlist_mess_box').html('<br/><center>' + res.msg + '</center>');
        jQuery('#wishlist_mess_box').dialog('open');
        jQuery('#mod_vm_compare').html('Comparison(' + res.number + ')');
    });
}
function alert_add_all_compare()
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=productalert&task=addAllToCompate";
    var parameter = {};

    jQuery.post(url, parameter, function(res) {

        jQuery('.icon_uncompare').removeClass('unactive');
        jQuery('.icon_compare').addClass('unactive');
        jQuery('#wishlist_mess_box').attr("title", jQuery('#add_all_compare').attr("title"));
        jQuery('#wishlist_mess_box').dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            height: 150
        });

        res = jQuery.parseJSON(res);
        jQuery('#wishlist_mess_box').html('<br/><center>' + res.msg + '</center>');
        jQuery('#wishlist_mess_box').dialog('open');
        jQuery('#mod_vm_compare').html('Comparison(' + res.number + ')');
    });
}
function add_to_cart(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=cart&task=addJS";
    var parameter = {virtuemart_product_id: id, quantity: 1};

    jQuery.post(url, parameter, function(res) {
        res = jQuery.parseJSON(res);
        jQuery('#cart_mess_box').attr("title", jQuery('#icon_cart_' + id).attr("title"));

        jQuery('#cart_mess_box').dialog({
            autoOpen: false,
            modal: true,
            width: 350,
            height: 150
        });
        jQuery('#cart_mess_box').html('<center>' + res.msg + '</center>');
        jQuery('#cart_mess_box').dialog('open');
    });
}

function add_all_to_cart(type)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=cart&task=addJS";
    var parameter = {quantity: 1, type: type};

    jQuery.post(url, parameter, function(res) {
        res = jQuery.parseJSON(res);
        jQuery('#cart_mess_box').attr("title", 'Add All Items to Cart');

        jQuery('#cart_mess_box').dialog({
            autoOpen: false,
            modal: true,
            width: 350,
            height: 150
        });
        jQuery('#cart_mess_box').html('<center>' + res.msg + '</center>');
        jQuery('#cart_mess_box').dialog('open');
    });
}
function add_all_to_wishlist(type)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=addAllwishlist";
    var parameter = {quantity: 1, type: type};

    jQuery.post(url, parameter, function(res) {
        res = jQuery.parseJSON(res);
        jQuery('#cart_mess_box').attr("title", 'Add All Items to Wishlist');

        jQuery('#cart_mess_box').dialog({
            autoOpen: false,
            modal: true,
            width: 350,
            height: 150
        });
        jQuery('#cart_mess_box').html('<center><a class="showcart" style="float:none;" href="' + res.url + '">Wishlist Manager</a></center>');
        jQuery('#cart_mess_box').dialog('open');
    });
}
function cl_add_wishlist(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=addwishlist";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {
        jQuery('.cl_add_wishlist_' + id).attr("style", "display:none");
        jQuery('.cl_remove_wishlist_' + id).attr("style", "display:block");
    });
}


function cl_remove_wishlist(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=deletewishlist";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {
        jQuery('.cl_add_wishlist_' + id).attr("style", "display:block");
        jQuery('.cl_remove_wishlist_' + id).attr("style", "display:none");
    });
}


function compare_add_wishlist(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=addwishlist";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {
        jQuery('#add_wishtlist_' + id).addClass('unactive');
        jQuery('#remove_wishlist_' + id).removeClass('unactive');
    });
}

function compare_remove_wishlist(id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=deletewishlist";
    var parameter = {product_id: id};
    jQuery.post(url, parameter, function(res) {
        jQuery('#add_wishtlist_' + id).removeClass('unactive');
        jQuery('#remove_wishlist_' + id).addClass('unactive');
    });
}

function email_to_friend(type)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=wishlist&task=managerwishlist";
    var parameter = {action: 'email'};
    jQuery.post(url, parameter, function(res) {        
        jQuery('#listid').val(res);      
   //     alert(res.productlist);
        jQuery('#sendmailfriend').dialog('open');      
    });
}

function mailedit()
{

    jQuery('#email_edit').dialog('open');
    jQuery("#email_form").submit(function(e) {
        e.preventDefault();
        var url = vmSiteurl + "index.php?option=com_virtuemart&view=productalert&task=updateEmail";
        jQuery.post(url, jQuery("#email_form").serialize(), function() {
        }, "json");
        jQuery('.email').val = jQuery('#new_email').val;
        jQuery('#email_edit').dialog('close');
    });
}

function add_reward_point()
{
    var add_reward_point = jQuery('#add_reward_point').val();

    var url = vmSiteurl + "index.php?option=com_virtuemart&view=cart&task=addrewardpoint";
    var parameter = {add_reward_point: add_reward_point};

    jQuery.post(url, parameter, function(res) {
        res = jQuery.parseJSON(res);
        res.msg;

        jQuery('#rp_added_on_confirm').val(add_reward_point);

        if (res.error == 0) {
            jQuery('#your_balance_rp').html(res.your_balance_rp);
            jQuery('#current_reward_point').val(res.your_balance_rp);

            jQuery('.PricebillTotal').html(res.bill_total);
        } else {
            jQuery('#freegift_mess_box').attr("title", "Add Gift Points");
            jQuery('#freegift_mess_box').dialog({
                autoOpen: false,
                modal: true,
                width: 400,
                height: 150
            });

            jQuery('#freegift_mess_box').html('<br/><center>' + res.msg + '</center>');
            jQuery('#freegift_mess_box').dialog('open');
        }
    });
}

function add_free_gift(freegift_id)
{
    var url = vmSiteurl + "index.php?option=com_virtuemart&view=cart&task=addJS";
    var parameter = {virtuemart_product_id: freegift_id, quantity: 1, type: 'freegift'};

    jQuery.post(url, parameter, function(res) {
        res = jQuery.parseJSON(res);
        if (res.stat == '3') {
            jQuery('#freegift_mess_box').dialog({
                autoOpen: false,
                modal: true,
                width: 350,
                height: 150
            });
            jQuery('#freegift_mess_box').html('<center>' + res.msg + '</center>');
            jQuery('#freegift_mess_box').dialog('open');
        } else {
            location.reload();
        }
    });
}

function update_cart()
{
	location.reload();
	
//	var count = 0;
//	var indexed = 0;
//	jQuery("form.inline").each(function() {
//		if (jQuery(this).find('span').hasClass("cart_freegift_quantity") == false) {
//			count++;
//		}
//	});
//	
//	jQuery("form.inline").each(function() {
//		if (jQuery(this).find('span').hasClass("cart_freegift_quantity") == false) {
//		  var url = vmSiteurl + "index.php?option=com_virtuemart&view=cart&task=updateJS";
//		  var quantity = jQuery(this).find('input[name="quantity"]').val();
//		  var product_id = jQuery(this).find('input[name="cart_virtuemart_product_id"]').val();
//		  var parameter = {product_id: product_id, quantity: quantity};
//
//		  jQuery.post(url, parameter, function(res) {
//			  indexed++;
//
//			  if (indexed == count) {
//		            jQuery('#freegift_mess_box').attr("title", "Update Cart");
//		            jQuery('#freegift_mess_box').dialog({
//		                autoOpen: false,
//		                modal: true,
//		                width: 400,
//		                height: 150
//		            });
//
//		            jQuery('#freegift_mess_box').html('<br/><center>Update cart success.</center>');
//		            jQuery('#freegift_mess_box').dialog('open');
//		            location.reload();
//			  }
//		  });
//		}
//	});
}
