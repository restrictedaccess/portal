//2008-09-25 Lawrence Sunglao <locsunglao@yahoo.com>
//grabbed payment details from the personal table
var PATH = './';

function AddBP(){
	$('bp_list').innerHTML = "Refreshing List";
	var agent_no = $('agent_no').value;
	if(agent_no==""){
		alert("Please choose a Business Partner !");
		return false;
	}
    var query = queryString({'agent_no': agent_no});
	d_submit_blank = doXHR(PATH + 'adminAddBPTransferLeads.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	d_submit_blank.addCallbacks(OnSuccessAddBP, OnFailAddBP);
	//alert(agent_no);
}

function OnSuccessAddBP(e) {
	$('bp_list').innerHTML = e.responseText;
	//var invoice_id = getNodeAttribute('invoice_id', 'invoice_id');
	//invoice_details = new ClassInvoiceDetails('invoice_right_pane', invoice_id);
	//div_invoice_list.GetInvoiceList(invoice_id);
}

function OnFailAddBP(e) {
	alert('Failed to Add Business Partner .\nPlease try again later.');
}
function OnFailDeleteBP(e){
	alert('Failed to Delete Business Partner .\nPlease try again later.');
}
	
function deleteBP(id){
	$('bp_list').innerHTML = "Refreshing List";
	if(id==""){
		alert("ID is Missing!");
		return false;
	}
    var query = queryString({'id': id});
	d_submit_blank = doXHR(PATH + 'adminDeleteBPTransferLeads.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	d_submit_blank.addCallbacks(OnSuccessAddBP, OnFailDeleteBP);
}