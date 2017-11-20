$(function(){
	
	//INITIALIZE ALL
	initAll();
	
	//PREVENT REDIRECTION
	$(document).on("click",".navigation a",function(e){
		e.preventDefault();
	});
	
	//SHOW LOGIN
	$(document).on("click",'.login-launcher',function(e){
		e.preventDefault();
		login_launcher();
	});
	
	//VALIDATE LOGIN FORM MODAL
	$("#login_form_modal").validate({ 
		errorElement: 'span',
		errorClass: 'help-block',
		errorPlacement: function(error, element) {
			if(element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		},
		rules:{
			leads_email:{
				required:true,
				email: true
			},
			leads_password:{
				required:true
			}
		},
		highlight: function(element) {
			$(element).closest('.form-group').addClass('has-error');
		},
		unhighlight: function(element) {
			$(element).closest('.form-group').removeClass('has-error');
		},
		submitHandler: function(form) {
			var data = $(form).serializeArray();
			$.post("/portal/custom_get_started/leads_login.php", data, function(response){
				if (response.success){
					window.location.href = "/portal/custom_get_started/step2.php";
				}else{
					var error_message = "The following failed to save because of the following error: \n\n";
					$.each(response.error_message, function(i, item){
						error_message+=item+"\n";
					});
					alert(error_message);
				}
			},'json');
		}
	});
	
	//NOT EQUAL ALT EMAIL VALIDATOR ADD METHOD
	$.validator.addMethod("notEqualAltEmail", function(value, element, param) {
		return this.optional(element) || value != $(param).val();
	}, "Email address must not be equal");
	
	//VALIDATE REGISTER FORM
	$(document).on("click",'#continue_btn',function(e){
		e.preventDefault();
		register_form();
	});
	
	//GET STATE
	$(document).on('change','#leads_country',function(e){
		e.preventDefault();
		getState($(this));
	});
	
	//GET CITY
	$(document).on('change','#leads_state',function(e){
		e.preventDefault();
		getCity($(this));
	});
	
});

//SHOW LOADER TARGETED
function _show_loader_targeted( targeted ) { 
	
	$( targeted ).isLoading( {
		
		text : 'Saving',
		
		position: 'overlay',

		class: 'fa fa-spinner fa-pulse',
		
		tpl : '<span class="isloading-wrapper %wrapper%">%text%<i class="%class%"></i></span>'
	
	} );
	
}

//HIDE LOADER TARGETED
function _hide_loader_targeted( targeted ) {
	
	$( targeted ).isLoading( 'hide' );
	
}

//INITIALIZE ALL FUNCTION
function initAll(){
	initChosen();
}

//INITIALIZE CHOSEN FUNCTION
function initChosen(){
	$('.chosen').chosen({
		width:"100%",
		no_results_text:"Oops, nothing found!",
		allow_single_deselect:true
	});
}

//LOGIN LAUNCHER FUNCTION
function login_launcher(){
	
	//CAST MODAL
	$("#login_modal").modal({backdrop:"static", keyboard:false});
	
	//CLEAR EMAIL AND PASSWORD
	$("#leads_email").val("");
	$("#leads_password").val("");
	
	//RESET FORM
	$('#login_form_modal').validate().resetForm();
	$("#login_form_modal .form-group").removeClass("has-error");
	
}

//LOGIN FORM MODAL FUNCTION
function login_form_modal(){
	
	$("#login_form_modal").validate({
		errorElement: 'span',
		errorClass: 'help-block',
		errorPlacement: function(error, element) {
			if(element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		},
		rules:{
			leads_email:{
				required:true,
				email: true
			},
			leads_password:{
				required:true
			}
		},
		highlight: function(element) {
			$(element).closest('.form-group').addClass('has-error');
		},
		unhighlight: function(element) {
			$(element).closest('.form-group').removeClass('has-error');
		},
		submitHandler: function(form) {
			var data = $(form).serializeArray();
			$.post("/portal/custom_get_started/leads_login.php", data, function(response){
				if (response.success){
					window.location.href = "/portal/custom_get_started/step2.php";
				}else{
					var error_message = "The following failed to save because of the following error: \n\n";
					$.each(response.error_message, function(i, item){
						error_message+=item+"\n";
					});
					alert(error_message);
				}
			},'json');
		}
	});
	
}

//REGISTER FORM FUNCTION
function register_form(){
	
	/*
	$.validator.addMethod("alpha", function(value, element) {
		return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
	},"Please input characters only.");
	
	$("#register-form").validate({
		errorElement: 'span',
		errorClass: 'help-block',
		errorPlacement: function(error, element) {
			if(element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		},
		rules:{ 
			first_name:{
				required:true,
				alpha:true
			},
			last_name:{
				required:true,
				alpha:true
			},
			company_name:{
				required:true
			},
			company_position:{
				required:true,
				alpha:true
			},
			company_phone:{
				required:true,
				digits:true 
			},
			mobile_phone:{
				required:true
			},
			email_address:{
				required:true,
				email:true
			},
			alt_email:{
				notEqualAltEmail:"#email_address_text",
				email:true
			}
		},
		highlight: function(element) {
			$(element).closest('.form-group').addClass('has-error');
		},
		unhighlight: function(element) {
			$(element).closest('.form-group').removeClass('has-error');
		},
		submitHandler: function(form) {
			var answer = confirm( 'Do you want to save this details?' );
			if(answer){
				_show_loader_targeted( 'body' );
				var data = $(form).serialize();
				$.post("/portal/custom_get_started/process_step1.php",data,function(response){
					if (response.success){
						window.location.href = "/portal/custom_get_started/step2.php";
					}else{
						if (response.errors!=undefined){
							var error_message = "The following failed to save because of the following error: \n";
							$.each(response.errors, function(i, item){
								error_message+=item+"\n";
							});
							alert(error_message);
						}else{
							alert("There were some errors. Please review the data and try again");
						}
					}
					_hide_loader_targeted( 'body' ); 
				},'json');
			}
		 }
	});
	*/
	_show_loader_targeted( 'body' );
	var data = $('#register-form').serialize();
	$.post("/portal/custom_get_started/process_step1.php",data,function(response){
		if (response.success){
			window.location.href = "/portal/custom_get_started/step2.php";
		}else{
			/*
			if (response.errors!=undefined){
				var error_message = "The following failed to save because of the following error: \n";
				$.each(response.errors, function(i, item){
					error_message+=item+"\n";
				});
				alert(error_message);
			}else{
				alert("There were some errors. Please review the data and try again");
			}
			*/
			alert('Please fill up required fields!');
		}
		_hide_loader_targeted( 'body' );  
	},'json');
	
}

//GET STATE FUNCTION
function getState(thisObj){
	
	//GET COUNTRY ID
	var country_id = thisObj.chosen().val();
	
	//CHECK COUNTRY ID
	if(country_id == ''){
		
		//SET STATE AND CITY TO EMPTY
		$('#leads_state').html('<option value=""></option>').trigger("chosen:updated");
		$('#leads_city').html('<option value=""></option>').trigger("chosen:updated");
		
	}else{
	
		//GET ALL STATE
		$.post('/portal/custom_get_started/get_state.php',{country_id:country_id},function(response){
			if(response.success){
				var states = '<option value=""></option>';
				$.each(response.result, function(id, country_state){
					states += '<option value="'+id+'">'+country_state+'</option>';
				});
				$('#leads_state').html(states).trigger("chosen:updated");
				$('#leads_city').html('<option value=""></option>').trigger("chosen:updated");
			}else{
				var error_message = "The following failed to save because of the following error: \n\n";
				$.each(response.error_message, function(i, item){
					error_message+=item+"\n";
				});
				alert(error_message);
			}
			
		},'json');
	
	}
	
}

//GET CITY FUNCTION
function getCity(thisObj){
	
	//GET STATE ID
	var state_id = thisObj.chosen().val();
	
	//GET ALL CITY
	$.post('/portal/custom_get_started/get_city.php',{state_id:state_id},function(response){
		if(response.success){
			var cities = '<option value=""></option>';
			$.each(response.result, function(id, state_city){
				cities += '<option value="'+id+'">'+state_city+'</option>';
			});
			$('#leads_city').html(cities).trigger("chosen:updated");
		}else{
			var error_message = "The following failed to save because of the following error: \n\n";
			$.each(response.error_message, function(i, item){
				error_message+=item+"\n";
			});
			alert(error_message);
		}
		
	},'json');
	
}
