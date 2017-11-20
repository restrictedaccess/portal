// JavaScript Document
var PATH = './';

function ViewLeadsProfile(leads_id){
	popup_win('leads_information/index.php?leads_id='+leads_id , 800, 600);
}


function Uncheck(name){
	var ins = document.getElementsByName(name);
	var i=0;
	//for(i=0;i<ins.length;i++)
	//{
		ins[i].checked=false;
	//}
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

function timedMsg(){
	var t=setTimeout(HideMessage,3000);
}
function HideMessage(){
	toggle('leads_transfer_error_msg');
}

function CheckBP(){
	var agent_id = $('agent_id').value;
	if(agent_id == ""){
		alert("Please select Business Partner");
		return false;
	}
	
}
function Move(status){
	$('status').value = status;
}
function setStar(value){
	
	var newitem ="";
	for(var i=0; i<value;i++){
		newitem +="<img src='images/star.png' align='top'>";
	}
	
	$('star').innerHTML = newitem;
}

function OnSubmitForm(){
	var folder = $('folder').value;
	//alert(folder);
	document.form.action =PATH+"leads.php?lead_status="+folder;
	//return false;
}

function SearchLeadInFolder(value){
	var location_id = $('location_id').value;
	location.href="leads.php?lead_status="+value+"&location_id="+location_id;
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

function paging(agent_id){
	//var rowsPerPage = $('rowsPerPage').value;
	if(agent_id == "" || agent_id == " "){
		alert("Agent Id is missing.\n Please contact Development Team");
		return false;
	}
	var value = $(agent_id+'_select').value;
	//alert(value);
	location.href=value;
	//document.form.action = value;
	//document.form.submit();
	
}



function check_val()
{
	var ins = document.getElementsByName('users')
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
}


function setCalendar(){
	Calendar.setup({
   inputField     :    "event_date",     // id of the input field
				ifFormat       :    "%Y-%m-%d",      // format of the input field
				button         :    "bd",          // trigger for the calendar (button ID)
				align          :    "Tl",           // alignment (defaults to "Bl")
				showsTime	   :    false, 
				singleClick    :    true
			});                     

}
