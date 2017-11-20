jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);
		//get_all_contact_nos_by_type('aus');
		//get_all_contact_nos_by_type('usa');
		//get_all_contact_nos_by_type('php');
		get_all_contact_nos();
	});
	
	jQuery('#add_contact_link').click(function() {
		add_edit_contact_no(null);
	});
	
	jQuery('#add_update_btn').click(function() {
		save_update_contact_no(this);
	});
	
	
});

function delete_contact_no(obj){
	var id = jQuery(obj).attr('contact_no_id')
	
	console.log('delete contact no =>'+id);
	
	var query = {"id" : id};
	jQuery(obj).html("removing...");
	jQuery(obj).attr('disabled', 'disabled');
	jQuery(obj).attr('disabled', 'disabled');
	//console.log(query);
	//return false;
	var url = 'delete_contact_no.php';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			console.log(data);
			if(data.success){
				get_all_contact_nos()
			}
		},
		error: function(data) {
			alert("There's a problem in deleting contact no.");
			jQuery(obj).html('remove');
			jQuery(obj).removeAttr('disabled', 'disabled');
			jQuery(obj).removeAttr('disabled', 'disabled');
		}
	});
}

function update_contact_no(id){
	//console.log(id);
	var contact_no = jQuery('#contact_no').val();
	var description = jQuery('#description').val();
	var site = jQuery('#site').val();
	var type = jQuery('#type').val();
	
	if(contact_no == "" || contact_no == " "){
		alert("Please enter contact number.");
		return false;
	}
	
	
	var query = {"id" : id, "contact_no": contact_no, "description" : description, "site" : site, "type" : type};
	jQuery('#add_update_btn').html("updating...");
	jQuery('#add_update_btn').attr('disabled', 'disabled');
	jQuery('#close_btn').attr('disabled', 'disabled');
	
	//console.log(query);
	var url = 'update_contact_no.php';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			console.log(data);
			jQuery('#add_update_btn').html('Update');
			jQuery('#add_update_btn').removeAttr('disabled', 'disabled');
			jQuery('#close_btn').removeAttr('disabled', 'disabled');
			//if(data.success){
			//	alert(data.msg);
			//}
			jQuery('#windowTitleDialog').modal('hide');
			get_all_contact_nos();
		},
		error: function(data) {
			alert("There's a problem in adding contact no.");
			jQuery('#add_update_btn').html('Update');
			jQuery('#add_update_btn').removeAttr('disabled', 'disabled');
			jQuery('#close_btn').removeAttr('disabled', 'disabled');
		}
	});
	
}
function add_edit_contact_no(id){
	var url = 'add_edit_contact_no.php';
	var result = jQuery.post( url, { 'id' : id } );
	
	result.done(function( data ) {
		jQuery('#windowTitleDialog').modal({ 
			backdrop: 'static',
			keyboard: false
		});
		jQuery('#contract_result').html(data)
		if(id){
			jQuery('#add_update_btn').html('Update');
			jQuery('#add_update_btn').attr('contact_no_id', id);
		}else{
			jQuery('#add_update_btn').html('Add');
			jQuery('#add_update_btn').removeAttr('contact_no_id');
		}
		
		
	});
	result.fail(function( data ) {
		console.log("There is a problem in loading contact nos form..");	
	});
	
}

function save_update_contact_no(obj){
	//console.log(obj);
	var contact_no_id = jQuery(obj).attr('contact_no_id');
	if(contact_no_id){
		console.log('update => ' + contact_no_id);
		update_contact_no(contact_no_id);
	}else{
		console.log('add new');	
		add_contact_no();
	}
}
function add_contact_no(){
	var contact_no = jQuery('#contact_no').val();
	var description = jQuery('#description').val();
	var site = jQuery('#site').val();
	var type = jQuery('#type').val();
	
	if(contact_no == "" || contact_no == " "){
		alert("Please enter contact number.");
		return false;
	}
	
	var query = {"contact_no": contact_no, "description" : description, "site" : site, "type" : type};
	//console.log(query);
	jQuery('#add_update_btn').html("adding...");
	jQuery('#add_update_btn').attr('disabled', 'disabled');
	jQuery('#close_btn').attr('disabled', 'disabled');
	
	var url = 'add_contact_no.php';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			console.log(data);
			jQuery('#add_update_btn').html('Add');
			jQuery('#add_update_btn').removeAttr('disabled', 'disabled');
			jQuery('#close_btn').removeAttr('disabled', 'disabled');
			
			if(data.success){
				jQuery('#contact_no').val("");
				jQuery('#description').val("");
				jQuery('#type').val("");
				jQuery('#windowTitleDialog').modal('hide');
				get_all_contact_nos()
			}
		},
		error: function(data) {
			alert("There's a problem in adding contact no.");
			jQuery('#add_update_btn').html('Add');
			jQuery('#add_update_btn').removeAttr('disabled', 'disabled');
			jQuery('#close_btn').removeAttr('disabled', 'disabled');
		}
	});
}

function get_all_contact_nos(){
	var url = 'get_all_contact_nos.php';
	var result = jQuery.post( url );
	
	result.done(function( data ) {
		jQuery('#nos_list').html(data);
		
		jQuery('.edit_btn').click(function() {
			var contact_no_id =jQuery(this).attr('contact_no_id');
			console.log(contact_no_id);
			add_edit_contact_no(contact_no_id)
		});
		jQuery('.del_btn').click(function() {
			//var contact_no_id =jQuery(this).attr('contact_no_id');
			//console.log('delete => '+contact_no_id);
			delete_contact_no(this);
		});
		
		
	});
	result.fail(function( data ) {
		console.log("There is a problem in parsing contact nos..");	
	});
}
function get_all_contact_nos_by_type(site){
	var url = 'get_contact_nos.php';
	var result = jQuery.post( url, { 'site' : site } );
	
	result.done(function( data ) {
		//console.log(data);
		jQuery('#'+site+'_list').html(data);
		
	});
	result.fail(function( data ) {
		console.log("There is a problem in parsing contact nos..");	
	});
	
}