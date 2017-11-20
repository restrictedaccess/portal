// JavaScript Document

var PATH = './';

function TransferLeads(){
	var agent_id = $('agent_id').value;
	var leads = $('applicants').value;
	if(agent_id == ""){
		alert("Please select a Business Partner");
		return false;
	}
	
	if(applicants == ""){
		alert("There's no lead selected");
		return false;
	}
	
	$('transfer').value = 'transferring...';
	$('transfer').disabled= true;
	var query = queryString({'agent_id' : agent_id , 'leads' : leads });
	var result = doXHR(PATH + 'TransferLeads.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessTransferLeads, OnFailTransferLeads);
}
function OnSuccessTransferLeads(e){
	var str = e.responseText;
	var n=str.search("Transferring Results");
	if(n==0){
		alert(e.responseText);
		var url = window.location.search;
	    location.href=url;
	}else{
	    alert(e.responseText);
	}
	
	$('transfer').value = 'Transfer to';
	$('transfer').disabled= false;
}
function OnFailTransferLeads(e){
	alert("There's a problem in transferring leads to other BP.");
	$('transfer').value = 'Transfer to';
	$('transfer').disabled= false;
}

function ClearQueryString(e){
	$('page').value=1;
	var path = $('path').value;
	document.form.action ="index.php?"+path;
	document.form.submit();
}
function get_mark_lead_for_value()
{
	var ins = document.getElementsByName('mark_lead_for')
	var i;
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
		    return ins[i].value;
			break;
		}
	}
}
function MarkLead(){
	var obj = $('mark_btn');
	var leads_id = getNodeAttribute(obj, 'leads_id');
	var mark_lead_for = get_mark_lead_for_value();

    var query = queryString({'leads_id' : leads_id , 'mode' : 'mark', 'mark_lead_for' : mark_lead_for });
	//log(query);
	//return false;
	fade('overlay');
	var result = doXHR(PATH + 'mark_unmark.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessMarkUnmark, OnFailMarkUnmark);
	
	
}


function OnSuccessMarkUnmark(e){
	//log(e.responseText);
	if(e.responseText == 'ok'){
	    document.form.submit();
	}else{
		alert(e.responseText);
	}
    /*
	if(mode == 'unmark'){
	    obj.setAttribute("mode", "mark");
	    obj.innerHTML = 'mark this lead';
	}else{
		obj.setAttribute("mode", "unmark");
	    obj.innerHTML = 'unmark this lead'
	}
	*/
}
function OnFailMarkUnmark(e){
	alert("There was a problem in marking and unmarking a lead");
}



function UnMarkLead(leads_id){
    var obj = $('mark_link_'+leads_id);
	var mode = getNodeAttribute(obj, 'mode');

    var query = queryString({'leads_id' : leads_id , 'mode' : 'unmark' , 'mark_lead_for' : 'unmark' });
	var result = doXHR(PATH + 'mark_unmark.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessMarkUnmark, OnFailMarkUnmark);
}


function mark_unmark_lead(leads_id){
	//alert(leads_id);
	var obj = $('mark_link_'+leads_id);
	var mode = getNodeAttribute(obj, 'mode');
    var leads_name = getNodeAttribute(obj, 'leads_name');
    if(mode == 'mark'){
		//alert("Mark this lead");
		appear('overlay');
		$('mark_btn').setAttribute("leads_id", leads_id);
		$('mark_leads_name').innerHTML = leads_name;
		//connect('mark_btn', 'onclick', MarkLead);
	}else{
		UnMarkLead(leads_id);
	}
        
}

function setStar(value){
	
	var newitem ="";
	for(var i=0; i<value;i++){
		newitem +="<img src='../images/star.png' align='top'>";
	}
	
	$('star').innerHTML = newitem;
}
function saveNote(leads_id){

	var note = $('remarks_'+leads_id).value;
	if(note==""){
		alert("Please insert a message");
		return false;
	}
	
	var query = queryString({'leads_id' : leads_id , 'note' : note });
	var result = doXHR(PATH + 'saveNote.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveNote, OnFailSaveNote);
	
	function OnSuccessSaveNote(e){
		$(leads_id+'_latest_notes').innerHTML = e.responseText;
		$('remarks_'+leads_id).value = "";
		toggle('note_form_'+leads_id);
	}
	
	function OnFailSaveNote(e){
		alert("Failed to add your notes");
	}
	
}

function CheckBP(){
	var agent_id = $('agent_id').value;
	if(agent_id == ""){
		alert("Please select a Business Partner");
		return false;
	}
}
function Move(status){
	$('status').value = status;
}

function check_val()
{
	var ins = document.getElementsByName('users')
	var move = document.getElementsByName('move')
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
		vals[j]=ins[i].value;
		j++;
		}
	}
	$('applicants').value=(vals);
	
	for(x=0; x<move.length; x++){
	    if(vals!=""){
			move[x].disabled=false;
		}else{
			move[x].disabled=true;
		}
	}
	
	if($('remove')){
	    if(vals!=""){
		    $('remove').disabled=false;
	    }else{
		    $('remove').disabled=true;
	    }
	}
	
	if($('transfer')){
	    if(vals!=""){
		    $('transfer').disabled=false;
	    }else{
		    $('transfer').disabled=true;
	    }
	}
	
	if($('agent_id')){
	    if(vals!=""){
		    $('agent_id').disabled=false;
	    }else{
		    $('agent_id').disabled=true;
	    }
	}
	
	
}

function setPageNum(page, bp){
	$('page').value=page;
	$('agent_no').value = bp;
	var path = $('path').value;
	document.form.action ='index.php?'+path+"#"+bp;
	//alert(path);
	document.form.submit();
}

function setPageNum2(page){
	$('page').value=page;
	var path = $('path').value;
	//log(path);
	//location.href="index.php?"+path+"&page="+page+"#UNMARKED";
	document.form.action ="index.php?"+path+"&page="+page+"#UNMARKED";
	//alert(path);
	document.form.submit();
}


function CheckFocus(){
	var agent_no = $('agent_no').value;
	if(agent_no !=""){
		$('bp_'+agent_no).focus();
	}
}

function Uncheck(name){
	var ins = document.getElementsByName(name);
	var i=0;
	ins[i].checked=false;
	$(name+'_txt').innerHTML = 'save setting';
}

function SaveSetting(name){
	var ins = document.getElementsByName(name);
	var i=0;
	//alert(name);
	//for(i=0;i<ins.length;i++)
	//{
		if(ins[i].checked==true) {
			var column_name = ins[i].value;
			var column_value = $(ins[i].value).value;
			var mode = 'save';
			//$(name).innerHTML = 'remove setting';
			//document.getElementById(name).innerHTML = 'remove setting';
		}else{
			
			var column_name = ins[i].value;
			var column_value = $(column_name).value;
			var mode = 'remove';
			//$(name).innerHTML = 'save setting';
			//document.getElementById(name).innerHTML = 'save setting';
		}
	//}
	$(name+'_txt').innerHTML = mode + " setting";
	var query = queryString({'column_name' : column_name , 'column_value' : column_value , 'mode' : mode });
	//alert(query);
	var result = doXHR(PATH + 'SaveSetting.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveSetting, OnFailSaveSetting);
	
}

function OnSuccessSaveSetting(e){
	alert(e.responseText);
}
function OnFailSaveSetting(e){
	alert("Failed in configuring setting");
}
