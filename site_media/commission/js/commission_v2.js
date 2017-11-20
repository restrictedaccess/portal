function getHistories(){
	var commission_id = jQuery('#commission_id').val();
	//console.log(commission_id);
	jQuery.get(PORTAL_DJANGO+"commission/history/"+commission_id, function(response){
		jQuery("#history").html(response);		
	});
}

function highlightElem(){
	jQuery('input[name=subcons]').closest('td').removeClass('alert-success');
	jQuery('input[name=subcons]:checked').closest('td').addClass('alert-success');	
}
function update_payment_status(commission_id, payment_status){
	console.log(commission_id+" "+payment_status);
	var invoice_id = jQuery('#invoice_id').val();
	invoice_id = invoice_id.replace(/\s+/g, ''); // remove all spaces
	
	var error_msg="";
	
	if(invoice_id == ""){	
		jQuery('#invoice_id').addClass("input-focus");
		error_msg += "Please enter Tax Invoice.<br>";
	}
	
	if(error_msg){
		jQuery('#windowTitleDialog').modal({ 
			backdrop: 'static',
			keyboard: false
		});
		jQuery('.modal-body').html(error_msg);
		jQuery('.modal-title').html('Error');
		jQuery('.modal-body').removeClass("alert-success");
		jQuery('.modal-body').addClass("alert-danger");
		jQuery('#modal-close-btn').removeClass("hide");
		jQuery('#modal-ok-btn').addClass("hide");
		
		return false;
	}
	
	
	if(payment_status == "invoiced"){
		var url = PORTAL_DJANGO + "commission/TagAsInvoiced/";
	}
	
	if(payment_status == "paid by client"){
		var url = PORTAL_DJANGO + "commission/TagAsPaidByClient/";
	}
	
	if(payment_status == "paid to staff"){
		var url = PORTAL_DJANGO + "commission/TagAsPaidToStaff/";
	}
	
	var formData = {"commission_id" : commission_id};
	jQuery.post(url, formData, function(data){
		data = jQuery.parseJSON(data);
		console.log(data);
		jQuery('#windowTitleDialog').modal({ 
			backdrop: 'static',
			keyboard: false
		});
			jQuery('.modal-body').html(data.msg);
			if(data.success == true){				
				jQuery('.modal-title').html('Information');
				jQuery('.modal-body').removeClass("alert-danger");
				jQuery('.modal-body').addClass("alert-success");
				jQuery('#modal-ok-btn').addClass("hide");
				jQuery('#modal-close-btn').removeClass("hide");
				jQuery('#modal-close-btn').removeAttr('disabled', 'disabled');
				
				jQuery('#payment-status').val(data.payment_status);
				jQuery('#invoiced').val(data.invoiced);
				jQuery('#paid_by_client').val(data.paid_by_client);
				jQuery('#paid_to_staff').val(data.paid_to_staff);
				jQuery('#status').val(data.status);				
				checkPaymentStatus();
				if(data.create_and_clone){
					if(data.create_and_clone){
						location.href=PORTAL_DJANGO +"commission/"+data.commission_id;
					}
				}
				
			}else{
				jQuery('.modal-title').html('Warning');
				jQuery('.modal-body').removeClass("alert-success");
				jQuery('.modal-body').addClass("alert-danger");
				jQuery('#modal-close-btn').removeClass("hide");
				jQuery('#modal-ok-btn').addClass("hide");
			}
			getHistories();
	});
	console.log(url);
	
}

function checkPaymentStatus(){
	var payment_status = jQuery('#payment-status').val();
	var status = jQuery('#status').val().toLowerCase();
	var invoice_id = jQuery('#invoice_id').val();
	invoice_id = invoice_id.replace(/\s+/g, '');
	
	var invoiced = jQuery('#invoiced').val();
	var paid_by_client = jQuery('#paid_by_client').val();
	var paid_to_staff= jQuery('#paid_to_staff').val();
	
	console.log(status)
	
	jQuery('.tag-btn').attr('disabled', 'disabled');
	
	if(status == 'approved'){
		if(invoice_id){
			jQuery('.tag-btn').removeAttr('disabled', 'disabled');
		}
	}
	
	if(invoiced == 'n'){
		if(invoice_id){
			jQuery('#invoice-btn').removeAttr('disabled', 'disabled');
		}
	}else{
		jQuery('#invoice-btn').attr('disabled', 'disabled');
	}

	if(paid_by_client == 'n'){
		if(invoice_id){
			jQuery('#paid-by-client-btn').removeAttr('disabled', 'disabled');
		}
	}else{
		jQuery('#paid-by-client-btn').attr('disabled', 'disabled');
	}

	if(paid_to_staff == 'n'){
		if(invoice_id){
			jQuery('#paid-to-staff-btn').removeAttr('disabled', 'disabled');
		}
	}else{
		jQuery('#paid-to-staff-btn').attr('disabled', 'disabled');
	}
	
}

function enabledDisabledButton(){
	var status = jQuery('#status').val().toLowerCase();
	var payment_type = jQuery('#payment_type').val();
	
	if(status == 'approved'){
		jQuery('#approve-btn').attr('disabled', 'disabled');
		jQuery('#payment_type').attr('disabled', 'disabled');
		jQuery('#start_date').attr('disabled', 'disabled');
		jQuery('#start_date').removeAttr('style', 'cursor:pointer;');
        jQuery('#commission_amount').attr('disabled', 'disabled');
        
		if(payment_type == 'one time payment'){
			jQuery('#end_date').attr('disabled', 'disabled');
			jQuery('#end_date').removeAttr('style', 'cursor:pointer;');
		}		
	}
	
	if(status == 'cancelled' || status == 'deleted' ){
		/*
		jQuery('.status-btn').attr('disabled', 'disabled');
		jQuery('#update-btn').attr('disabled', 'disabled');	
        
        jQuery('#payment_type').attr('disabled', 'disabled');
        jQuery('#start_date').attr('disabled', 'disabled');
        jQuery('#end_date').attr('disabled', 'disabled');
        jQuery('#commission_amount').attr('disabled', 'disabled');    
		*/
		jQuery('#commission-form').find('input, textarea, button, select').attr('disabled','disabled');
	}
    
    if(status == 'finished'){
        jQuery('.status-btn').attr('disabled', 'disabled');
		//jQuery('#update-btn').attr('disabled', 'disabled');
		jQuery('#payment_type').attr('disabled', 'disabled');
		jQuery('#start_date').attr('disabled', 'disabled');
		jQuery('#start_date').removeAttr('style', 'cursor:pointer;');
        jQuery('#end_date').attr('disabled', 'disabled');
        jQuery('#end_date').removeAttr('style', 'cursor:pointer;');
        jQuery('#commission_amount').attr('disabled', 'disabled');

		
	}
}
function update_commission_status(commission_id, status){
	console.log(commission_id, status);
	var formData = {"commission_id" : commission_id, "status" : status};
	var url = PORTAL_DJANGO + "commission/update_commission_status/";
	if(status == 'approved'){
		var url = PORTAL_DJANGO + "commission/approve_commission/"
	}
	
	jQuery.post(url, formData, function(data){
		data = jQuery.parseJSON(data);
		//console.log(data);
		jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('.modal-body').html(data.msg);
			if(data.success == true){
				jQuery('#status').val(status);
				jQuery('.modal-title').html('Success');
				jQuery('.modal-body').removeClass("alert-danger");
				jQuery('.modal-body').addClass("alert-success");
				jQuery('#modal-ok-btn').addClass("hide");
				jQuery('#modal-close-btn').removeClass("hide");
				jQuery('#modal-close-btn').removeAttr('disabled', 'disabled');
				enabledDisabledButton();
				checkPaymentStatus();
			}else{
				jQuery('.modal-title').html('Warning');
				jQuery('.modal-body').removeClass("alert-success");
				jQuery('.modal-body').addClass("alert-danger");
				jQuery('#modal-close-btn').removeClass("hide");
				jQuery('#modal-ok-btn').addClass("hide");
			}
			getHistories();
	});
}

function CheckPaymentType(){
	var payment_type = jQuery('#payment_type').val();
	if(payment_type == 'one time payment'){
		jQuery('#end_date').val(jQuery('#start_date').val());
	}else{
		jQuery('#end_date').val("");
	}
}

function display_commmissions_count(){
	var url = PORTAL_DJANGO + 'commission/display_commmissions_count/';
	jQuery.ajax({
		type: "GET",
		url: url,
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response){
			if(response.success){
				var output="";
				jQuery.each(response.data, function(i, item) {
					//console.log(item.status);
					//console.log(item.count);
					//output += "<li class='list-group-item'><span class='badge'>"+item.count+"</span>"+item.status+"</li>";
					output += "<a href='"+PORTAL_DJANGO+"commission/show/"+item.status+"' class='list-group-item'><span class='badge'>"+item.count+"</span>"+item.status+"</a>";
				});
				jQuery("#commissions_summary_count").html(output);
			}
		},
		error: function(response) {
			display_commmissions_count();
		}
	});
}


function get_commissions(){
	jQuery("form").each(function () {
		search_commissions(this);
	});
}

function search_commissions(form){
	
	var url = PORTAL_DJANGO + 'commission/search_commissions/';
	var formData = jQuery(form).serialize();
	var obj = jQuery(form)
	var table_id = jQuery(form).attr("data-display-id");
	var num_of_records_obj = jQuery(form).find('.num_or_records');
	
	//console.log(jQuery(num_of_records_obj).html());
	jQuery("#"+table_id +" tbody").html("<tr><td colspan=9>Loading...</td></tr>");

	jQuery.post(url, formData, function(data){
		data = jQuery.parseJSON(data);
		if(data.success){
			var output="";
			jQuery.each(data.commission, function(i, item) {
				output += "<tr>";
					output += "<td><span class='badge'>"+ item.counter+"</span></td>";
					output += "<td><a href='"+PORTAL_DJANGO+"commission/"+item.commission_id+"'>"+ item.commission_id+"</a></td>";
					output += "<td>"+ item.client_name+"</td>";
					output += "<td>"+ item.commission_title+"</td>";
					output += "<td>"+ item.payment_status+"</td>";
					output += "<td>"+ item.payment_method+"</td>";
					output += "<td>"+ item.pay_run+"</td>";
					output += "<td>"+ item.commission_amount+"</td>";
					output += "<td>"+ item.payment_type+"</td>";
					output += "<td>"+ item.start_date+"</td>";
					output += "<td>"+ item.end_date+"</td>";
					output += "<td>"+ item.status+"</td>";
					output += "<td>"+ item.created_by+"</td>";
					output += "<td>"+ item.date_created+"</td>";
					output += "<td>"+ item.csro_name+"</td>";
					output += "<td >";
					//output += "<td>"+ item.subcons+"</td>";
					jQuery.each(item.subcons, function(s, subcon) {
						   output += "<span class='pull-left label label-default subcon'>"+ subcon.toLowerCase()+"</span>";
					});									  
					output += "</td>";
				output += "</tr>";
			});									
			jQuery(num_of_records_obj).html(data.count +" records found");
			jQuery("#"+data.display_id+" tbody").html(output);
			set_up_pagination(form, data.display_id, parseInt(data.pagenum), parseInt(data.maxpage));
		}
		
	});
}

function set_up_pagination(form, elem_id, pagenum, maxpage){
	//console.log(form, elem_id+" "+pagenum+" "+maxpage);
	//return false;
	var output="";		
	if (pagenum > 1){
		page = pagenum - 1;
		output += "<li><a href='#' data-page-num="+page+"><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";			
	}else{		
		output += "<li class='disabled'><a href='#'><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";
	}
	
	for(var i=1; i<=maxpage; i++ ){
		
		if(pagenum == i){
			output +="<li class='active'><a href='#' data-page-num="+i+">"+i+" <span class='sr-only'>(current)</span></a></li>";
		}else{
			output +="<li><a href='#' data-page-num="+i+">"+i+"</a></li>";
		}
	}
	
	if (pagenum < maxpage){
		page = pagenum + 1;
		output += "<li><a href='#' data-page-num="+page+"><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
	}else{		
		output += "<li class='disabled'><a href='#'><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
	}
	
	jQuery("#pagination-"+elem_id).html(output );
	
	jQuery("#pagination-"+elem_id+" a").click(function(e){
		e.preventDefault();
		var pagenum = jQuery(this).attr("data-page-num");
		console.log(pagenum);
		
		if(pagenum){
			jQuery('input[name=page]').val(pagenum);
			search_commissions(form);
		}
		
	});
	
}


/*
function exportTableToCSV($table, filename) {

	var $rows = $table.find('tr:has(td)'),

		// Temporary delimiter characters unlikely to be typed by keyboard
		// This is to avoid accidentally splitting the actual contents
		tmpColDelim = String.fromCharCode(11), // vertical tab character
		tmpRowDelim = String.fromCharCode(0), // null character

		// actual delimiter characters for CSV format
		colDelim = '","',
		rowDelim = '"\r\n"',

		// Grab text from table into CSV formatted string
		csv = '"' + $rows.map(function (i, row) {
			var $row = $(row),
				$cols = $row.find('td');

			return $cols.map(function (j, col) {
				var $col = $(col),
					text = $col.text();

				return text.replace('"', '""'); // escape double quotes

			}).get().join(tmpColDelim);

		}).get().join(tmpRowDelim)
			.split(tmpRowDelim).join(rowDelim)
			.split(tmpColDelim).join(colDelim) + '"',

		// Data URI
		csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

	jQuery(this).attr({
		'download': filename,
		'href': csvData,
		'target': '_blank'
	});
}
*/

function exportTableToCSV($table, filename) {
	var $headers = $table.find('tr:has(th)')
		,$rows = $table.find('tr:has(td)')

		// Temporary delimiter characters unlikely to be typed by keyboard
		// This is to avoid accidentally splitting the actual contents
		,tmpColDelim = String.fromCharCode(11) // vertical tab character
		,tmpRowDelim = String.fromCharCode(0) // null character

		// actual delimiter characters for CSV format
		,colDelim = '","'
		,rowDelim = '"\r\n"';

		// Grab text from table into CSV formatted string
		var csv = '"';
		csv += formatRows($headers.map(grabRow));
		csv += rowDelim;
		csv += formatRows($rows.map(grabRow)) + '"';

		// Data URI
		var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

	jQuery(this).attr({
		'download': filename,
		'href': csvData
			//,'target' : '_blank' //if you want it to open in a new window
	});

	//------------------------------------------------------------
	// Helper Functions 
	//------------------------------------------------------------
	// Format the output so it has the appropriate delimiters
	function formatRows(rows){
		return rows.get().join(tmpRowDelim)
			.split(tmpRowDelim).join(rowDelim)
			.split(tmpColDelim).join(colDelim);
	}
	// Grab and format a row from the table
	function grabRow(i,row){
		 
		var $row = $(row);
		//for some reason $cols = $row.find('td') || $row.find('th') won't work...
		var $cols = $row.find('td'); 
		if(!$cols.length) $cols = $row.find('th');  

		return $cols.map(grabCol)
					.get().join(tmpColDelim);
	}
	// Grab and format a column from the table 
	function grabCol(j,col){
		var $col = $(col),
			$text = $col.text();

		return $text.replace('"', '""'); // escape double quotes

	}
}

function randString(n)
{
    if(!n)
    {
        n = 7;
    }

    var text = '';
    var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    for(var i=0; i < n; i++)
    {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

    return text;
}