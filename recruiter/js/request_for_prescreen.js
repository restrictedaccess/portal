
function popup_win(loc, wd, hg) {
	var remote = null;
	var xpos = screen.availWidth / 2 - wd / 2;
	var ypos = screen.availHeight / 2 - hg / 2;
	remote = window.open('', '', 'width=' + wd + ',height=' + hg + ',resizable=0,scrollbars=1,screenX=0,screenY=0,top=' + ypos + ',left=' + xpos);
	if(remote != null) {
		if(remote.opener == null) {
			remote.opener = self;
		}
		remote.location.href = loc;
		remote.focus();
	} else {
		self.close();
	}
}


jQuery(document).ready(function(){
	var dateRegisteredFrom = jQuery("#date_registered_from").val();
	var dateRegisteredTo = jQuery("#date_registered_to").val();
	
	var dateUpdateFrom = jQuery("#date_updated_from").val();
	var dateUpdateTo = jQuery("#date_updated_to").val();	
	
	jQuery("#date_registered_from").datepicker();
	jQuery("#date_registered_to").datepicker();
	jQuery("#date_registered_from").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateRegisteredFrom);
	jQuery("#date_registered_to").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateRegisteredTo);

	jQuery("#date_updated_from").datepicker();
	jQuery("#date_updated_to").datepicker();
	jQuery("#date_updated_from").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateUpdateFrom);
	jQuery("#date_updated_to").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateUpdateTo);

	jQuery(".update_recruiter").live("focus", function(){
		jQuery(this).data("oldValue", jQuery(this).val());
		jQuery(this).data("oldRecruiter", jQuery(this).children("option").filter(":selected").text());
		
	}).live("change", function(){
		var me = jQuery(this);
		var userid = jQuery(this).attr("data-userid");
		
		jQuery.get("/portal/recruiter/"+'check_priviledge_on_assigning_staff.php?userid='+userid, function(responseCheck){
			responseCheck = jQuery.parseJSON(responseCheck);	
			if (responseCheck.success){
				var ans = confirm("Do you want to assign "+me.attr("data-fname")+" to "+me.children("option").filter(":selected").text());
				if (ans){
					admin_id = me.val();
					jQuery.get("/portal/recruiter/"+'staff_recruiter_update.php?userid='+userid+'&admin_id='+admin_id, function(data){
						var data = jQuery.parseJSON(data);
						if (data.success){
							alert(me.attr("data-fname")+" successfully assigned to "+me.children("option").filter(":selected").text()+". Page will be refreshed to reflect changes"); 
							window.location.reload();  
						}else{
							me.val(me.data("oldValue"))
							alert(data.error);
						}
					});	
				}else{
					me.val(me.data("oldValue"))
				}			
			}else{
				alert(responseCheck.error);
			}
		});

	})


	jQuery(".update_availability_status").live("focus", function(){
		jQuery(this).data("oldValue", jQuery(this).val());
	}).live("change", function(){
		var me = jQuery(this);
		var ans = confirm("Do you want to update the availability status from ["+me.data("oldValue")+"] to ["+me.val()+"] of this prescreen request?");
		if (ans){
			var data = {
				id:jQuery(this).attr("data-order_id"),
				availability_status:jQuery(this).val()
			}
			jQuery.post("/portal/recruiter/update_prescreen_order_status.php", data, function(response){
				response = jQuery.parseJSON(response);
				if (!response.success){
					me.val(me.data("oldValue"));
				}
			})
		}else{
			jQuery(this).val(jQuery(this).data("oldValue"));
		}
	});
	
	
	
	jQuery(".launcher").live("click", function(e){
		popup_win(jQuery(this).attr("href"), 800,600);		
		e.preventDefault();
	})
})
