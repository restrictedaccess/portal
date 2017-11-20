var STATUS = new Array('new', 'finished', 'deleted');
var timeoutReference;
var timeout_result;
var clear_update_label_result;

function CheckStatusPercentage(e){
	var workflow_status = jQuery(e).attr('status');
	var workflow_percentage = jQuery(e).attr('percentage');
	
	var status = jQuery('#status').val();
	//var percentage = jQuery('#percentage').val();
	//console.log(workflow_status+' '+workflow_percentage);
	
	if(status == 'finished'){
		jQuery('#percentage').val('100%');
	}else{
		jQuery('#percentage').val(workflow_percentage);
	}
	/*
	if(percentage == '100%'){
		jQuery('#status').val('finished');
	}else{
		console.log(workflow_status);
		jQuery('#status').val(workflow_status);
	}
	*/
}
function AddStaffSettings(){
	var userid = $("#personal_id").val();
	var leads_id = $("#client_id").val();
	
	var setting = $("input[name=staff_setting]:checked");
	var staff_other_email = $('#staff_other_email').val();
	console.log(userid);
	
	//return false;
	if (setting.length > 0){
		if(setting.val() == 'other'){
			if(staff_other_email == ""){
				alert("Please enter an email address");
				return false;
			}
		}
		
		var url = PATH + 'AddStaffSettings/';
		var result = $.post( url, { 'setting' : setting.val(), 'leads_id' :  leads_id, 'staff_other_email' : staff_other_email, 'userid' : userid} );
		result.done(function( data ) {				 
			//$("#client_autoresponder_setting_result").html(data);	
			if(data == 'ok'){
				alert("Saved");
				$("#staff_autoresponder_setting_result").html("<span class='alert alert-success'><strong>Saved !</strong> Staff autoresponder settings</span><br clear='all' />");
			}else{
				alert(data);
				$("#staff_autoresponder_setting_result").html("<span class='alert alert-error'><strong>Error !</strong>"+data+"</span><br clear='all' />");	
			}
		});
		result.fail(function( data ) {
			alert("There is a problem in saving staff autoresponder setting.");	
		});
		
	}else{
		alert("No stasff settings selected");
		return false;
	}
}
function AddClientSettings(){
	//var box = $('input[name=client_setting]').is(':checked'); 
	var setting = $("input[name=client_setting]:checked");
	if (setting.length > 0){
		console.log(setting.val());
		if(setting.val() == 'other'){
			var client_other_email = $('#client_other_email').val();
			if(client_other_email == ""){
				alert("Please enter an email address");
				return false;
			}
		}
		var client_other_email = $('#client_other_email').val();
		var leads_id = $("#client_id").val();
		var url = PATH + 'AddClientSettings/';
		var result = $.post( url, { 'setting' : setting.val(), 'leads_id' :  leads_id, 'client_other_email' : client_other_email} );
		result.done(function( data ) {				 
			//$("#client_autoresponder_setting_result").html(data);	
			if(data == 'ok'){
				alert("Saved");
				$("#client_autoresponder_setting_result").html("<span class='alert alert-success'><strong>Saved !</strong> Client autoresponder settings</span><br clear='all' />");
			}else{
				alert(data);
				$("#client_autoresponder_setting_result").html("<span class='alert alert-error'><strong>Error !</strong>"+data+"</span><br clear='all' />");	
			}
		});
		result.fail(function( data ) {
			alert("There is a problem in saving client autoresponder setting.");	
		});
		
		
	}else{
		alert("No client settings selected");
		return false;
	}
}
function staff_autoresponder_settings(){
	var userid = $("#personal_id").val();
	var leads_id = $("#client_id").val();
	console.log(userid);
	var url = PATH + 'GetStaffSettings/' + userid;
	var result = $.post( url, { 'userid' : userid, 'leads_id' :  leads_id} );
	result.done(function( data ) {				 
		$("#staff_email_settings_form").html(data);	
		$("#staff_setting_btn").click(function (e) {
  			AddStaffSettings();
		});

	});
	result.fail(function( data ) {
		alert("There's a problem in retrieving staff workflow autoresponder settings.");	
	});
}
function client_autoresponder_settings(){
	var client_id = $("#client_id").val();
	console.log(client_id);
	var url = PATH + 'client_autoresponder_settings/' + client_id;
	var result = $.post( url, { 'client_id' : client_id } );
	result.done(function( data ) {				 
		$("#client_autoresponder_settings").html(data);	
		staff_autoresponder_settings();
		$("#personal_id").change(function (e) {
  			staff_autoresponder_settings();
		});
		
		$("#client_setting_btn").click(function (e) {
  			AddClientSettings();
		});
		
	});
	result.fail(function( data ) {
		alert("There's a problem in retrieving client's workflow autoresponder settings.");	
	});
}
function CheckBoxSelected(e){
	console.log(e)
	if($(e).is(':checked')){
		console.log('checked');
		$(e).next().addClass('staff_list_selected');
	}else{
		console.log('unchecked');
		$(e).next().removeClass('staff_list_selected');
	}
}
function checkAllCheckBox(value)
{
	var select_all_staff = document.getElementsByName('select_all_staff');
	var staff = document.getElementsByName('staff');
	if(select_all_staff[0].checked == true){
		
		for(i=0;i<staff.length;i++){
		    staff[i].checked=true;
			staff[i].disabled=false;
	    }
		$('.staff_list').addClass('staff_list_selected');
	}else{
		
		for(i=0;i<staff.length;i++){
		    staff[i].checked=false;
	    }
		
		$('.staff_list').removeClass('staff_list_selected');
	}

}
function CreateTask(e){
	var leads_id = $("#client_id").val();
    //var boxes = $('input[name=staff]:checked');	
	//$(boxes).each(function(){
    		//do stuff here with this
	//});
	var boxes = $('input[name=staff]').is(':checked'); 
	console.log("selected staff => "+ boxes);
}
function GetClientStaff(e){
	var leads_id = $("#client_id").val();
	//console.log("leads_id => "+ leads_id);
	if(leads_id){
		console.log("leads_id => "+ leads_id);
		var url = PATH + 'GetClientStaff/' + leads_id;
		var result = $.post( url, { 'leads_id' : leads_id } );
		result.done(function( data ) {
			$("#assign_staffs").show('slow');					 
			$("#assign_staffs").html(data);	
			
			$(".select_all_staff").click(function(e) {
				checkAllCheckBox(this);
			});
			
			$("input[name=staff]").click(function(e) {
				CheckBoxSelected(this);
			});
			
		});
		result.fail(function( data ) {
			$("#assign_staffs").hide('slow');
			alert("There's a problem in retrieving client's staff");	
		});
	}else{
		$("#assign_staffs").html('<label class="checkbox inline"><input type="checkbox" disabled="disabled" > <small><em>No assign staff yet</em></small></label>');	
		//$("#assign_staffs").hide('slow');
	}
}
function UpdateLabel(e){
	var label = $('#label_hdr_str').val();
	var label_id = $(e).attr('label_id');

	var url = PATH + 'UpdateLabel/';
	var result = $.post( url, { 'label_id' : label_id, 'label' : label } );
	result.done(function( data ) {
		$("#label_hdr_str").html(data);
		$("#"+label_id+"_label_box a").html(data);
		//$('#label_hdr_str').after("<i id='label_update_check' class='icon-ok'></i>");
		jQuery('#label_update_check').show();
		if (clear_update_label_result) clearTimeout(clear_update_label_result);
		clear_update_label_result = setTimeout(function() {
			jQuery('#label_update_check').hide();
		}, 2000); //2 secs
		
	});
	result.fail(function( data ) {
		alert("There's a problem in deleting label");
	});

}

function DeleteLabel(e){
	
	var label = $('#label_hdr_str').val();
	var label_id = $(e).attr('label_id');
	
	console.log("delete => "+ label+" "+label_id);
	
	var url = PATH + 'DeleteLabel/';
	var result = $.post( url, { 'label_id' : label_id } );
	result.done(function( data ) {
		$("#right_col_container").html(data);
		$("#"+label_id+"_label_box").hide('slow');
	});
	result.fail(function( data ) {
		alert("There's a problem in deleting label");	
	});
	
}

function AddNewLabel(e){
	var label = $('#new_label').val();
	console.log(label);
	
	var url = PATH + 'AddNewLabel/';
	var result = $.post( url, { 'label' : label } );
	result.done(function( data ) {
		$("#category_list li:last").before(data);
		$('#new_label').val("");
		$(".workflow_label").click(function(e) {
			GetWorkflow(this);
    	});
	});
	result.fail(function( data ) {
		alert("There's a problem in saving new label");	
	});
}

function GetWorkflow(e){
	var current_user = $('#current_user').val();
	var status = $(e).attr('status');
	console.log(status);
	
	
	var page = $('#page').val();
	if(!status){
		status='new';
	}else{
		$('.active').removeClass('active');
	}
	$(e).parent('li').addClass('active');
	if(!page)page = 1;
	

	if(current_user == 'staff'){
		var url = PATH + 'StaffGetWorkflow/'+status;
	}
	if(current_user == 'client'){
		var url = PATH + 'GetWorkflow/'+status;
	}
	if(current_user == 'manager'){
		var url = PATH + 'GetManagerWorkflow/'+status;
	}
	
	if(!isNaN(status)){
		var url = PATH + 'GetLabelWorkflows/'+status;
	}
	
	
	$('#right_col_container').html("<img src='"+PORTAL+"/images/ajax-loader.gif' >");
	/* Send the data using post */
	
	var result = $.post( url, { status: status } );
	/* Put the results in a div */
	result.done(function( data ) {
		$('#right_col_container').html(data);
		
		
		$(".action_btn").click(function(e) {
			ActionButtons(this);
    	});
		
		$(".task_details").keyup(function() {
			var el = this; // copy of this object for further usage							  
			var workflow_id = $(this).attr('workflow_id')
			if(workflow_id){
				//do nothing
			}else{
				var leads_id = $('#leads_id').val();
				if(leads_id == ""){
					//alert("Please select a client first.");
					$("#select_a_client_first").show();
					$(this).val("");
				    $(this).focus();
					return false;
				}
			}
		
			
			if (timeoutReference) clearTimeout(timeoutReference);
			timeoutReference = setTimeout(function() {
				//SaveUpdateWorkingDetails(el);
				console.log('Disabled auto saving of workflow');
			}, 3000); //3 secs
		});
	
		
		$(".task_details").blur(function(e){
			SaveUpdateWorkingDetails(this);
		});
		
		$(".task_details").keydown(function(e) {
			//console.log(e.keyCode);							
			if(e.keyCode == 13) {
				if (timeoutReference) clearTimeout(timeoutReference);
				SaveUpdateWorkingDetails(this);				
			}
		});
		
		
		
		
		$(".task_details").blur(function(e){
			SaveUpdateWorkingDetails(this);
		});
		
		$(".add_workflow_btn").click(function(e){
			SaveUpdateWorkingDetails(this);
		});
		
		
		//resizing the textbox of label hdr
		function resizeInput() {
    		$(this).attr('size', $(this).val().length);
		}

		$('#label_hdr_str')
			// event handler
			.keyup(resizeInput)
			// resize on page load
			.each(resizeInput);


		$("#update_label_btn").click(function(e){
			UpdateLabel(this);
		});
		
		$("#delete_label_btn").click(function(e){
			DeleteLabel(this);
		});
		
		
		if(status == 'finished' || status == 'deleted'){
			$("#leads_id").attr('disabled','disabled');
			//$("#leads_id").val("");
		}else{
			$("#leads_id").removeAttr('disabled');
		}
		
		if(jQuery('#label_update_check')){
			jQuery('#label_update_check').hide();
		}
		
	});
	result.fail(function( data ) {
		$('#right_col_container').html(result.responseText);
	});
	

}

function ActionButtons(e){
	var workflow_id = $(e).attr('workflow_id');
	var action = $(e).attr('action');
	//var category = $(e).attr('category');
	//console.log(workflow_id+' '+action);
	
	
	if(action == 'open'){
		window.open(PATH + 'task/' + workflow_id);
	}else{
		SetToFinishedDeleted(workflow_id, action);
	}
}

function SetToFinishedDeleted(workflow_id, action){
	console.log(workflow_id+' '+action);
	var confirmed = true;
	if(action == 'deleted'){
		var confirmed = false;
		if(confirm("Delete Task #"+workflow_id+"?")){
			var confirmed = true;
		}
	}
	
	if(confirmed){
		var url = PATH + 'SetToFinishedDeleted/';
		var result = $.post( url, { 'workflow_id' : workflow_id, 'action' : action} );
		result.done(function( data ) {
			console.log(data);
			$("#"+workflow_id+"_task_box").hide('slow');
			var elm = $("#clicked"),
			count = parseInt(elm.text(), 10);
			elm.text(count - 1); 	
		});
		result.fail(function( data ) {
			alert("There's a problem in updating work details");	
		});
	}
	
}

function SaveUpdateWorkingDetails(e){
	
    // we only want to execute if a timer is pending
    if (!timeoutReference){
        return;
    }
    // reset the timeout then continue on with the code
    timeoutReference = null;
	
	//console.log(e);
	$("#select_a_client_first").hide();
	
	var workflow_id = $(e).attr('workflow_id'); 
	var leads_id = $('#leads_id').val();
	if(workflow_id){
		//update row
		var workflow_work_details = $(e).attr('details');
		var work_details = $('#'+workflow_id+'_task').val();
	
		if(workflow_work_details != work_details){
			//console.log(workflow_id+" => "+work_details);
			//return false;
			if(work_details =="" || work_details == null){
				alert("Please add Work Details");
				$(workflow_id+'_task').value = workflow_work_details;
				$('#'+workflow_id+'_task').focus();
				return false;
			}
			var url = PATH + 'UpdateWorkingDetails/';
			var result = $.post( url, { 'task_id' : workflow_id, 'work_details' : work_details} );
			result.done(function( data ) {
				console.log(data);
			});
			result.fail(function( data ) {
				console.log("There's a problem in updating work details");	
				$('#'+workflow_id+'_task').val(workflow_work_details);
			});
		}
	}else{
		//insert new row
		console.log('insert new row');
		var position = $(e).attr('position');
		var status = $(e).attr('status');
		var label = $(e).attr('label');
		
		var elem = $(e).attr('id');
		var work_details = $("#"+elem).val();
		
		if(work_details !=""){
			var url = PATH + 'SaveWorkingDetails/';
			var result = $.post( url, { 'label' : label, 'status' : status, 'work_details' : work_details, 'leads_id' : leads_id} );
			result.done(function( data ) {
				//console.log(data);
				if(position == 'after'){
					$('#task_list li:first').after(data);
				}else{
					$("#task_list li:last").before(data);
				}
				$("#"+elem).val("");
				$(".action_btn_clone").click(function(e) {
					ActionButtons(this);
				});
				var elm = $("#clicked"),
				count = parseInt(elm.text(), 10);
				elm.text(count + 1);
				
				//
				$(".task_details").keyup(function() {
					var el = this; // copy of this object for further usage
					if (timeoutReference) clearTimeout(timeoutReference);
					timeoutReference = setTimeout(function() {
						//SaveUpdateWorkingDetails(el);
						console.log('Disabled auto saving');
					}, 3000); //3 secs
				});
		
			
				$(".task_details").blur(function(e){
					SaveUpdateWorkingDetails(this);
				});
				//
				$('#save_update_result').show();
				if (timeout_result) clearTimeout(timeout_result);
				timeout_result = setTimeout(function() {
					$('#save_update_result').hide();;
				}, 2000); //2 secs
				
			});
			result.fail(function( data ) {
				alert("There's a problem in updating work details");	
				$("#"+elem).val(work_details);
			});
		}
		
	}
}

