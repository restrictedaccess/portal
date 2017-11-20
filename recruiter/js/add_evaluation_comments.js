jQuery(document).ready(function(){
	
	jQuery("#add-evaluation-comments").submit(function(){
		var formData = {
				userid: jQuery("#userid").val(),
				notes:tinyMCE.getInstanceById("notes").getContent()	
		};
		jQuery.post("/portal/recruiter/category/addEvaluationComment.php", formData, function(data){
			if (window.opener!=undefined){
				window.opener.parent.location.reload()	
			}
			alert("Evaluation comment has been added.");
			window.close();
		});
		return false;
	})
});