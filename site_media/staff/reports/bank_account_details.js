var loadedTimesheets = [];

jQuery(document).ready(function(){
	console.log(window.location.pathname);
	
	
	jQuery("#save_changes_btn").on("click", function(e){
		UpdateBankAccountDetails();
	});
})

function UpdateBankAccountDetails(){
	var card_number = jQuery('#card_number').val();
	var account_holders_name = jQuery('#account_holders_name').val();
	
	var bank_name = jQuery('#bank_name').val();
	var bank_branch = jQuery('#bank_branch').val();
	var swift_address = jQuery('#swift_address').val();
	var bank_account_number = jQuery('#bank_account_number').val();
	var bank_account_holders_name = jQuery('#bank_account_holders_name').val();
	
	if(confirm("Save changes?")){
		var bank = {"bank_name" : bank_name, "bank_branch" : bank_branch, "swift_address" : swift_address, "bank_account_number" : bank_account_number, "account_holders_name" : bank_account_holders_name};		
		var sterling = {"card_number": card_number, "account_holders_name" : account_holders_name};
		
		//var query = {"card_number": card_number, "account_holders_name" : account_holders_name, "bank_name" : bank_name, "bank_branch" : bank_branch, "swift_address" : swift_address, "bank_account_number" : bank_account_number, "bank_account_holders_name" : bank_account_holders_name};
		
		var query = {"bank": bank, "sterling" : sterling};
		
		
		console.log(query);
		jQuery('#save_changes_btn').html("saving...");
		jQuery('#save_changes_btn').attr('disabled', 'disabled');
		var url = DJANGO_APP_URL + 'UpdateBankAccountDetails/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				jQuery('#save_changes_btn').html('Save Changes');
				jQuery('#save_changes_btn').removeAttr('disabled', 'disabled');
				alert(data.msg);
			},
			error: function(data) {
				alert("There's a problem in saving your changes.");
				jQuery('#save_changes_btn').html('Save Changes');
				jQuery('#save_changes_btn').removeAttr('disabled', 'disabled');
			}
		});
	}
}