var PATH = "comments/";
connect(window, 'onload', ShowComments);


function DeleteReply(id){
	if(id == "" || id == null){
		alert("Reply ID is missing");
		return false;
	}
	if(confirm("Remove reply from the list?")){
		var query = queryString({'id' : id });
		var result = doXHR(PATH + 'DeleteReply.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessDeleteReply, OnFailDeleteReply);
	}
}
function OnSuccessDeleteReply(e){
	alert(e.responseText);
	ShowComments();
}
function OnFailDeleteReply(e){
	alert("Failed to removed reply from the list");
}



function UpdateReply(id){
	if(id == "" || id == null){
		alert("Reply ID is missing");
		return false;
	}
	var message = $('reply_edit_text_'+id).value;
	var query = queryString({'id' : id ,'message' : message });
	//alert(query);
	var result = doXHR(PATH + 'UpdateReply.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateReply, OnFailUpdateReply);
}
function OnSuccessUpdateReply(e){
	alert(e.responseText);
	ShowComments();
}
function OnFailUpdateReply(e){
	alert("Failed to update reply");
}



function DeleteComment(comment_id){
	if(comment_id == "" || comment_id == null){
		alert("Comment ID is missing");
		return false;
	}
	if(confirm("Remove comment from the list?")){
		var query = queryString({'comment_id' : comment_id });
		var result = doXHR(PATH + 'DeleteComment.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessDeleteComment, OnFailDeleteComment);
	}
	
}
function OnSuccessDeleteComment(e){
	alert(e.responseText);
	ShowComments();
}
function OnFailDeleteComment(e){
	alert("Failed to remove comment from the list");
}



function ShowComments(){
	$('comments').innerHTML = "<img src='images/loading.gif'/>";
	var result = doSimpleXMLHttpRequest(PATH + 'ShowComments.php');
	result.addCallbacks(OnSuccessShowComments, OnFailShowComments);
}
function OnSuccessShowComments(e){
	$('comments').innerHTML = e.responseText;
}
function OnFailShowComments(e){
	alert("Failed to show all comments");
}


function SaveReply(comment_id){
	if(comment_id == "" || comment_id == null){
		alert("Comment ID is missing");
		return false;
	}
	var message =  $('message_'+comment_id).value;
	var send = getRadioCheckboxValue('send_email_'+comment_id);
	var query = queryString({'comment_id' : comment_id , 'message' : message , 'send' : send });
	//alert(query);
	var result = doXHR(PATH + 'SaveReply.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveReply, OnFailSaveReply);

	function OnSuccessSaveReply(e){
		toggle('reply_div_'+comment_id);
		$('replies_'+comment_id).innerHTML = e.responseText;
	}
	function OnFailSaveReply(e){
		alert("Failed to save the message");
	}
}

function ShowReplyForm(id){
	if(id == "" || id == null){
		alert("Comment ID is missing");
		return false;
	}
	toggle('reply_div_'+id);
	$('reply_div_'+id).innerHTML = "<img src='images/loading.gif' width='15' height='15'/>";
	var query = queryString({'id' : id });
	var result = doXHR(PATH + 'ShowReplyForm.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowReplyForm, OnFailShowReplyForm);
	
	
	function OnSuccessShowReplyForm(e){
		$('reply_div_'+id).innerHTML = e.responseText;
	}
	
	function OnFailShowReplyForm(e){
		alert("Failed to show reply form");
	}

}


function CheckComment(){
	if(document.getElementById('comment').value == ""){
		alert("Please type your comments or suggestions");
		return false;
	}return true;
}

function getRadioCheckboxValue(obj){
	var element = document.getElementsByName(obj);
	var element_value;
	var i;
	for(i=0;i<element.length;i++)
	{
		if(element[i].checked==true) {
			element_value = element[i].value;
			return element_value;
			break;
		}
	}
}


