// JavaScript Document
var PATH = 'prepaid/';

function ShowClientStaffListForm(e){
	var leads_id = getNodeAttribute(e.src(), 'value');
	var query = queryString({'leads_id' : leads_id });
    //alert(query);
	appear('overlay');
	$('invoice_form').innerHTML = "Loading...";
	var result = doXHR(PATH + 'ShowClientStaffListForm.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowClientStaffListForm, OnFailShowClientStaffListForm);
}

function OnSuccessShowClientStaffListForm(e){
	$('invoice_form').innerHTML = e.responseText;
	connect('close_link', 'onclick', CloseInvoiceForm);
	var staffs_count = $('staffs_count').value;
	var min_date=$('min_date').value;
	var max_date=$('max_date').value;
	
	for (var i = 0; i < staffs_count; i++){
		
		Calendar.setup({
            inputField : "u_"+i,
            trigger    : "u_"+i,
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d",
			min: parseInt(min_date)
            //max: parseInt(max_date)
        });
	}
}
function OnFailShowClientStaffListForm(e){
	alert("Failed to parse client staff");
	fade('overlay');
}

function CloseInvoiceForm(e){
	var leads_id = getNodeAttribute(e.src(), 'leads_id');
	$('c_'+leads_id).checked=false;
	fade('overlay');
	
}
function ValidateConversion(){
	var client = get_val('client');
	if(!$('staffs_count')){
	
	    if(!client){
		    alert("Please choose a client");
		    return false;
	    }
	    var client_name = getNodeAttribute('client_'+client, 'leads_name');//$('client_'+client).innerHTML;
	    if(confirm("Convert regular client "+ client_name + " to a prepaid client ?")){
			//$('convert_btn').value='converting please wait...';
			//$('convert_btn').disabled=true;
		    return true;
	    }
	}else{
		var ctr =0;
		var staffs_count = $('staffs_count').value;
	    for (var i = 0; i < staffs_count; i++){
		     if($('u_'+i).value==''){
				 ctr = ctr + 1;
			 }
		}
		
		if(ctr > 0){
			alert("There are staff contracts that have no Prepaid Starting Date.");
			return false;
		}
		//$('convert_btn').value='converting please wait...';
		//$('convert_btn').disabled=true;
		return true;
	}
	return false;
}

function ShowClientStaff(e){
	var leads_id = getNodeAttribute(e.src(), 'leads_id');
	toggle('client_staff_'+leads_id);
}

function get_val(obj){	
	var ins = document.getElementsByName(obj)
	var i;
	var vals;
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals = ins[i].value;
			break;
		}
	}
	return vals;
}
