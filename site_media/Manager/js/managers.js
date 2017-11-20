PATH = "/portal/django/Manager/"

function UpdateManagerInfo(){
    var fname = jQuery('#fname').val();	
	var lname = jQuery('#lname').val();
	var email = jQuery('#email').val();
	//var manager_id = jQuery('#manager_id').val();
	if(confirm("Save changes?")){
		var query = {"fname" : fname, "lname" : lname, "email" : email};
		console.log(query);
		jQuery('#update_btn').html("saving changes...");
		jQuery('#update_btn').attr('disabled', 'disabled');
		var url = PATH + 'UpdateManagerInfo/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				alert(data.msg);
				if(data.success){
					location.href=PATH+'Manager/myaccount/';
				}
				jQuery('#update_btn').html('Save Changes');
				jQuery('#update_btn').removeAttr('disabled', 'disabled');
			},
			error: function(data) {
				alert("There's a problem in saving changes.");
				jQuery('#update_btn').html('Save Changes');
				jQuery('#update_btn').removeAttr('disabled', 'disabled');
			}
		});
	}
}