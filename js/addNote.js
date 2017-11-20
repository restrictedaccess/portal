// JavaScript Document
var PATH = './';
function saveNote(leads_id,created_by_id){
	var remarks = $('remarks_'+leads_id).value;
	
	if(remarks==""){
		alert("Please insert a message");
		return false;
	}
	
	var remark_created_by = 'BP';
	var query = queryString({'leads_id' : leads_id , 'created_by_id' : created_by_id, 'remarks' : remarks, 'remark_created_by' : remark_created_by });
	var result = doXHR(PATH + 'leads_add_remark.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveNote, OnFailSaveNote);
	
	function OnSuccessSaveNote(e){
		$('note_book_'+leads_id).innerHTML = e.responseText;
		toggle('note_form_'+leads_id);
	}
	function OnFailSaveNote(e){
		alert("Failed to add notes");
	}
	
}

function saveNote2(leads_id,created_by_id){
	var remarks = $('remarks_'+leads_id).value;
	
	if(remarks==""){
		alert("Please insert a message");
		return false;
	}
	
	var remark_created_by = 'ADMIN';
	var query = queryString({'leads_id' : leads_id , 'created_by_id' : created_by_id, 'remarks' : remarks, 'remark_created_by' : remark_created_by });
	var result = doXHR(PATH + 'leads_add_remark.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveNote, OnFailSaveNote);
	
	function OnSuccessSaveNote(e){
		$('note_book_'+leads_id).innerHTML = e.responseText;
		toggle('note_form_'+leads_id);
	}
	function OnFailSaveNote(e){
		alert("Failed to add notes");
	}
	
}


function closeNoteForm(id){
	//toggle('note_form_'+id);
}


