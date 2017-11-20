/**
* Single Endorse
*/
jQuery(document).ready(function(){
	jQuery("#leads-form").submit(function(){
		if (!validate(this)){
			return false;
		}
		var dataSend = $(this).serialize();
		dataSend.send = true;
		var userid = $("#userid").val();
		jQuery.post("/portal/endorsement/single-endorse.php?send=1&userid="+userid, dataSend, function(data){
			data = jQuery.parseJSON(data);
			if (data.result){
				alert(data.message);
				window.close();		
			}else{
				alert(data.message);
			}
		});
		return false;
	});
	
});