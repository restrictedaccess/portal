jQuery(document).ready(function(){
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
	jQuery("#language-form").validate({
		errorElement:"span",
		errorPlacement:function(error, element){
			error.addClass("help-inline").appendTo(element.parent(".controls")).parent().parent().removeClass("error").removeClass("success").addClass("error");
		},
		success:function(label){
			label.parent().parent().removeClass("error").removeClass("success").addClass("success");
		},
		rules:{
			language:{
				required:true
			},
			spoken:{
				required:true
			},
			written:{
				required:true
			}
			
			
		}, 
		submitHandler: function(form) {
			var formData = jQuery("#language-form").serialize();
			jQuery.post("/portal/jobseeker/addlanguage.php", formData, function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					jQuery(".alert-success").fadeIn(200);
					 $('html, body').animate({
		  			 	scrollTop:jQuery("body").offset().height
		  			 }, 500);
					
					
					var template = "<tr>";
					var total = jQuery("#applicant_language_list tbody tr").length;
					template += "<td>"+(total+1)+"</td>";
					template += "<td>"+data.language.language+"</td>";
					template += "<td>"+data.language.spoken+"</td>";
					template += "<td>"+data.language.written+"</td>";
					
					template+="<td>";
					template+="<a href='/portal/jobseeker/edit_language.php?id="+data.language.id+"' class='edit_skill'>Edit</a> | ";
					template+="<a href='/portal/jobseeker/delete_language.php?id="+data.language.id+"' class='delete_skill'>Delete</a>";
					
					template+="</td>";
					template += "</tr>";
					jQuery("#language").val("");
					jQuery("#spoken").val("");
					jQuery("#written").val("");
					
					jQuery(template).appendTo(jQuery("#applicant_language_list tbody"));
				}else{
					alert(data.error);
				}
				
			})
			return false;
		}
	});
})
