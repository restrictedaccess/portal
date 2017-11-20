// JavaScript Document
var STICKYPATH = 'sticky_notes/';
//connect(window, "onload", OnLoadStickyNotes);

function highlight(obj) {
   obj.style.backgroundColor='#FFFFDD';
  // obj.style.fontWeight="700";
   
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
  // obj.style.fontWeight="";
}



function showAddNewStickyMessageForm(){
	toggle('add_div');
}

function OnClickAddNewStickyMessage(){
	var message = $('message').value;
	var query = queryString({'message': message});
	var result = doXHR(STICKYPATH + 'AddNewStickyMessage.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddNewStickyMessage, OnFailAddNewStickyMessage);
}
function OnSuccessAddNewStickyMessage(e){
	toggle('add_div');
	toggle('message_status');
	$('message').value = "";
	$('message_status').innerHTML = e.responseText;
	//AutoOnLoadStickyNotes();
}
function OnFailAddNewStickyMessage(e){
	alert("Failed to add new message. Please try again later");
}
function confimedStickyNotes(id){
	if(id =="" || id == null){
		alert("sticky note id is missing");
		return false;
	}
	var query = queryString({'id': id});
	var result = doXHR(STICKYPATH + 'confimedStickyNotes.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessConfimedStickyNotes, OnFailConfimedStickyNotes);
}
function OnSuccessConfimedStickyNotes(e){
	$('message_status').style.display = "block";
	$('message_status').innerHTML = e.responseText;
	AutoOnLoadStickyNotes();
	var ctr = $('ctr').value;
	$('ctr').value = ctr - 1 ; 
	//checkCounter();
}
function OnFailConfimedStickyNotes(e){
	alert("Failed to confim");
}

function checkCounter(){
	var result = doSimpleXMLHttpRequest(STICKYPATH + 'CheckCounter.php');
    result.addCallbacks(OnSuccessCheckCounter, OnFailCheckCounter);
}

function opencloseStickyNotes(){
	toggle('sticky_wrapper');
	toggle('notification_messages_bttn');
}

function OnSuccessCheckCounter(e){
	var count = e.responseText;
	var ctr = $('ctr').value;
	if(count > ctr) {
		$('sticky_wrapper').style.display = 'block';
		$('notification_messages_bttn').style.display = 'none';
		
		AutoOnLoadStickyNotes();
		$('ctr').value = count;
	}else if (count == 0){
		$('notification_messages_bttn').style.display = "block";
	}else{
		// do nothing	
	}
}

function OnFailCheckCounter(e){
	//alert("Failed to count no. of messages.");
	// do nothing
}

function OnLoadStickyNotes(e){
	// 60000 = 1 min
	// 9000 = 1 sec
	var int=self.setInterval(checkCounter,9000)
}

function AutoOnLoadStickyNotes(e){
	$("sticky_holder").innerHTML = "Loading";
	var result = doSimpleXMLHttpRequest(STICKYPATH + 'OnLoadStickyNotes.php');
    result.addCallbacks(OnSuccessOnLoadStickyNotes, OnFailOnLoadStickyNotes);
}

function OnSuccessOnLoadStickyNotes(e){
	$("sticky_holder").innerHTML = e.responseText;
	//OnLoadStickyNotes();
}

function OnFailOnLoadStickyNotes(e){
	alert("Failed to fetch Notification messages.");
	// do nothing
}

