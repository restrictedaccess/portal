$(document).ready(function(){
			$(document).on( 'submit', '#apply-form',function(e){
				e.preventDefault();
				var posting_id = $('#posting_id').val();
				$.post('/portal/convert_ads/validate_ad.php',{ submit_form : '1', posting_id : posting_id },function(response){	
					response = $.parseJSON(response);
					console.log(response);
					if(response.logged){
						if(!response.success){
							alert(response.error_message);
						}else{
							alert(response.success_message);
						}
					}else{
						alert('YOU NEED TO LOGIN FIRST BEFORE YOU CAN APPLY TO THIS JOB POSITION');
						window.open("/portal/index.php");
					}
				});
			});
		});
                