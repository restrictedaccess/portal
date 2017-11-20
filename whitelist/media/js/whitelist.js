jQuery(document).ready(function() {
    jQuery(window).load(function (e) {
        console.log(window.location.pathname);
        
    });  
    get_admins();    
    get_whitelisted_admins();
    jQuery('.btn-add').removeAttr("disabled", "disabled");
    
    jQuery('.btn-add').click(function() {
        add_admin_in_whitelist();
    });
});

function add_admin_in_whitelist(){
    var API_URL = jQuery("#API_URL").val();
    var admin_id = jQuery("#admin_id").val();
    
    var id = jQuery("#admins").val();
    
    jQuery('.btn-add').attr("disabled", "disabled");
    var url = API_URL + "/admin/add-admin-in-whitelist/";
    var result = jQuery.post( url, { 'id' : id, 'admin_id' : admin_id} );
	result.done(function( response ) {	
        console.log(response);        
        alert("Admin has been added from the list.");
        jQuery('.btn-add').removeAttr("disabled", "disabled");
        jQuery("#results").html("<p align='center'>Updating list...</p>");
        get_whitelisted_admins();
	});
	result.fail(function( response ) {
        console.log(response);  
        jQuery('.btn-add').removeAttr("disabled", "disabled");
	});
    
}
function get_admins(){
    var API_URL = jQuery("#API_URL").val();
	var url = API_URL + '/admin/get-admins-name/';
	jQuery.ajax({
		type: "GET",
		url: url,
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response){
			var output = "<option value=''>Please select admin</option>";
            jQuery.each(response.admins, function(j, item){
                output += "<option value='"+item.admin_id+"'>"+item.admin_fname+" "+item.admin_lname+" "+item.admin_email+"</option>";
            })
            jQuery("#admins").html(output);
			
		},
		error: function(response) {
			get_admins();
		}
	});
}
function get_whitelisted_admins(){
	var API_URL = jQuery("#API_URL").val();
	var url = API_URL + '/admin/get-whitelisted-admins/';
	jQuery.ajax({
		type: "GET",
		url: url,
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response){
			console.log(response);
			if(response.success){
				
                if(response.admins.length > 0){
                    var output="<ol>";
                    jQuery.each(response.admins, function(i, item){
                                
                        //output += "<tr>";	
                        //output += "<td>"+item.admin_fname+" "+item.admin_lname+" "+item.admin_email+"</td>";
                        //output += "<td><button class='btn btn-remove' data-white-id='"+item.id+"'>delete</button></td>";					
                        //output += "</tr>";
                        
                        output += "<li>";
                            output += "<button class='btn btn-remove' data-white-id='"+item.id+"'>delete</button>";
                            output += item.admin_fname+" "+item.admin_lname+" <em>["+item.admin_email+"]</em>";                      
                        output += "</li>";						
                    });	
                    output += "</ol>";
                }else{
                    var output="<p align='center'>No records to be shown.</p>";
                }
                
				//jQuery("#results table tbody").html(output);
                jQuery("#results").html(output);
				jQuery('.btn-remove').click(function(e) {
                    delete_whitelisted_admin(this);
                });
				
			}
			
		},
		error: function(response) {
			get_whitelisted_admins();
		}
	});
	
}

function delete_whitelisted_admin(o){
    var API_URL = jQuery("#API_URL").val();
    var admin_id = jQuery("#admin_id").val();
    var obj = jQuery(o);
    var id = obj.attr("data-white-id");
    jQuery('.btn-remove').attr("disabled", "disabled");
    var url = API_URL + "/admin/delete-admin-in-whitelist/";
    var result = jQuery.post( url, { 'id' : id, 'admin_id' : admin_id} );
	result.done(function( response ) {	
        console.log(response);        
        alert("Admin has been removed from the list.");
        jQuery("#results").html("<p align='center'>Updating list...</p>");
        get_whitelisted_admins();
	});
	result.fail(function( response ) {
        console.log(response);  
        jQuery('.btn-remove').removeAttr("disabled", "disabled");
	});
    
    
}