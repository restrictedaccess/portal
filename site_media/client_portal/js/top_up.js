var GUI_VERSION = '2013-06-27 06:49:00';
var CLIENT_PORTAL_TOPUP_RPC = "/portal/django/client_topup_prepaid_v2/jsonrpc/";

jQuery(document).ready(function(){   	
    console.log(window.location.pathname);
    
    refreshPage();        
    check_version(); 
    get_new_orders();
    //get_running_balance();
    //get_approximate_hours();
    //add_order
              
});

function add_order(){
	var amount = jQuery("#input-amount").val();
	var sign = jQuery(".preset-amount-currency-sign").html();
	if(parseFloat(amount) < 50){
		alert("Minimum of "+sign+"50.00 is required.");
		return false;
	}
	//console.log(amount);
	jQuery(".btn-add-order").attr("disabled", "disabled");
	jQuery(".input-amount-btn").attr("disabled", "disabled");
	jQuery(".input-amount-btn").html("buying...")
	
	var data = {json_rpc:"2.0", id:"ID9", method:"add_order", params:[amount]};
	jQuery.ajax({
	url: CLIENT_PORTAL_TOPUP_RPC,
	type: 'POST',
	data: JSON.stringify(data),
	contentType: 'application/json; charset=utf-8',
	dataType: 'json',
	success: function(response) {
			console.log(response);
			if(response.error){
				var error = response.error.message.split(":");
				alert(error[1]);
				
				jQuery(".btn-add-order").removeAttr("disabled", "disabled");
				jQuery(".input-amount-btn").removeAttr("disabled", "disabled");
				jQuery(".input-amount-btn").html("Pay Now")
								
			}else{
				if(response.result.success){
					location.href="/portal/v2/payments/top-up/"+response.result.order_id;	
				}
				
			}								
		}		
	});
	
}

function add_order_from_billing_cycle(obj){
	var type = jQuery(obj).attr("data-billing-cycle-type");
	var sign = jQuery(obj).attr("data-currency-sign");
	//console.log(sign+""+amount);
	
	
	//if(confirm("Top Up an amount of "+sign+""+amount)){
		
		jQuery(".btn-add-order").attr("disabled", "disabled");
		jQuery(obj).html("buying...");
		
		
		var data = {json_rpc:"2.0", id:"ID9", method:"add_order_from_billing_cycle", params:[type]};
		jQuery.ajax({
		url: CLIENT_PORTAL_TOPUP_RPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
				console.log(response);
				if(response.error){
					var error = response.error.message.split(":");
					alert(error[1]);
					
					jQuery(".btn-add-order").removeAttr("disabled", "disabled");
					jQuery(obj).html("Pay Now");
									
				}else{
					if(response.result.success){
						location.href="/portal/v2/payments/top-up/"+response.result.order_id;	
					}
					
				}								
			}		
		});
	//}
	
	
}

function get_approximate_hours(obj){
	var id = obj.attr("id");
	var amount = obj.val();
	//console.log(id+" "+amount);
	if(isNaN(amount)){
		alert("Please enter a valid amount");
		return false;
	}
	
	
	if(!amount){
		amount = 50;
		obj.val(amount);		
	}
	
	
	
	if(amount){
		var data = {json_rpc:"2.0", id:"ID9", method:"get_approximate_hours", params:[amount]};
		jQuery("#"+id+"-btn").attr("disabled", "disabled");
		jQuery.ajax({
		url: CLIENT_PORTAL_TOPUP_RPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
				jQuery("#"+id+"-result").html(response.result.approximated_hours+" hours work of per staff");
				jQuery("#"+id+"-btn").attr("data-amount", amount);									
				jQuery("#"+id+"-btn").removeAttr("disabled", "disabled");
			}		
		});
	}
}

function get_running_balance(){
	var data = {json_rpc:"2.0", id:"ID9", method:"get_running_balance", params:[]};
	jQuery("#top-up-result-container").html("");
	jQuery("#new-orders-container").addClass("hide");
	jQuery(".btn-add-order").removeAttr("disabled", "disabled");	
	jQuery(".input-amount-btn").removeAttr("disabled", "disabled");
	
	
	jQuery.ajax({
		url: CLIENT_PORTAL_TOPUP_RPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			if(response.error){
				var error = response.error.message.split(":");
				alert(error[1]);				
			}else{
				//Display packages
				
				
				if(response.result.packages){
					jQuery.each(response.result.packages, function(i, item){				
						
						//console.log(item.type);
						
						//weekly_total_amount_str
						jQuery("#"+item.type+"_total_amount_str").html( response.result.currency_sign+""+money_format(item.total_amount) );
						jQuery("#"+item.type+"_total_amount_str").addClass("hide");
						jQuery("#"+item.type+"-pay-now-btn").attr("data-billing-cycle-type",item.type);
						
						var counter =0;
						var output="";
						jQuery.each(item.staff, function(j, j_item){
							//console.log(j_item);
							counter = counter + 1;
							output += "<tr>";							
						    output += "<td>"+counter+"</td>";
						    output += "<td>"+j_item.description+"</td>";
						    output += "<td class='text-right'>"+j_item.qty+"</td>";							
						    output += "<td class='text-right'>"+response.result.currency_sign+""+j_item.hourly_rate+"</td>";
						    output += "<td class='text-right'>"+response.result.currency_sign+""+j_item.amount+"</td>";
						    output += "</tr>";
						});						
						
						//Amount
						output += "<tr>";													
					    output += "<td colspan='4' class='text-right'><strong>Sub Total</strong></td>";
					    output += "<td class='text-right'>"+response.result.currency_sign+""+money_format(item.amount)+"</td>";
					    output += "</tr>";
					    
					    //GST Amount
					    output += "<tr>";													
					    output += "<td colspan='4' class='text-right'><strong>GST</strong></td>";
					    output += "<td class='text-right'>"+response.result.currency_sign+""+money_format(item.gst_amount)+"</td>";
					    output += "</tr>";
						
						//Total Amount
					    output += "<tr>";													
					    output += "<td colspan='4' class='text-right'><strong>Total Amount</strong></td>";
					    output += "<td class='text-right' style='background:yellow'><strong>"+response.result.currency_sign+""+money_format(item.total_amount)+"</strong></td>";
					    output += "</tr>";		
								
						jQuery("#"+item.type+"_invoice_display tbody").html(output);
							
					});						
				}
				
				jQuery("#top-up-container").removeClass("hide");
				
				jQuery("#new-orders-container").addClass("hide");
				jQuery("#buy-credit").removeClass("hide");
				//jQuery("#preset-qty").removeClass("hide");
				
				//jQuery("#buy-credit tbody").prepend(output);
				jQuery(".preset-amount-currency-sign").html(response.result.currency_sign);
				jQuery(".btn-add-order").attr("data-currency-sign", response.result.currency_sign);
				
				
				jQuery(".btn-add-order").on( "click", function( event ) {        
			        add_order_from_billing_cycle(this);
				});
				
				jQuery(".input-amount-btn").on( "click", function( event ) {        
			        add_order();
				});	
				
				
								
			}
		}		
	});
}

function cancel_order(obj){
	var doc_id = jQuery(obj).attr("data-doc_id");
	//console.log(doc_id);
	var data = {json_rpc:"2.0", id:"ID9", method:"cancel_order", params:[doc_id]};
	
	jQuery(obj).attr("disabled", "disabled");
	jQuery(obj).html("cancelling...");
	
	jQuery.ajax({
		url: CLIENT_PORTAL_TOPUP_RPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			if(response.error){
				var error = response.error.message.split(":");
				alert(error[1]);	
				
				jQuery(obj).removeAttr("disabled", "disabled");
				jQuery(obj).html("cancel invoice");
				
			}else{
				location.href="/portal/django/client_portal/top_up/";				
			}
		}		
	});
}

function  get_new_orders(){
	var data = {json_rpc:"2.0", id:"ID9", method:"get_new_orders", params:[]};
	jQuery("#top-up-result-container").html("");
	jQuery.ajax({
		url: CLIENT_PORTAL_TOPUP_RPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			//console.log(response);
			if(response.error){
				jQuery("#top-up-result-container").addClass("alert alert-danger");
				jQuery("#top-up-result-container").html("<h3>Error in page</h3> <br> Message : "+response.error.message+"<br> Code : "+response.error.code+"<br> Name : "+response.error.name);
			}else{
				//console.log(response.result.length);
				if(response.result.length > 0){
					//There are new invoices 
					var output = "";
					
					
					jQuery.each(response.result, function(i, item){
					
						output += "<tr>";
							output += "<td><a href='/portal/v2/payments/top-up/"+item.order_id+"'>"+item.order_id+"</a></td>";
							output += "<td>"+item.added_on+"</td>";
							output += "<td>"+item.currency_sign+""+item.total_amount+"</td>";
							output += "<td><button type='button' class='btn btn-primary btn-cancel-invoice' data-doc_id='"+item.doc_id+"'>cancel invoice</button></td>";							
						output += "</tr>";		
					});
					
					
					jQuery("#top-up-container").addClass("hide");
					jQuery("#new-orders-container").removeClass("hide");
					jQuery("#new-orders-container table tbody").html(output);
					
					
					jQuery(".btn-cancel-invoice").on( "click", function( e ) {        
				    	cancel_order(this);
					});
					
					
				}else{
					//Display Buy Credits Form					
					//jQuery("#top-up-container").removeClass("hide");
					get_running_balance();
					
				}
			}
			
		}		
	});
}



function refreshPage(){
	jQuery("#top-up-result-container").html("");
	jQuery("#top-up-result-container").removeClass("alert alert-danger");
	jQuery("#top-up-container").addClass("hide");	
	//jQuery("#preset-qty").addClass("hide");	
	jQuery("#input-preset-amount").val(50);
}

function check_version(){	
	
	var data = {json_rpc:"2.0", id:"ID9", method:"check_session", params:[GUI_VERSION]};
	jQuery.ajax({
		url: CLIENT_PORTAL_TOPUP_RPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			//console.log(response);
			if(response.error){
				jQuery("#top-up-result-container").addClass("alert alert-danger");
				jQuery("#top-up-result-container").html("<h3>Error in page</h3> <br> Message : "+response.error.message);
			}else{
				
			}
		}		
	});
}

function money_format(num) {
	num = ""+num;
	var p = num.split(".");
    return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}