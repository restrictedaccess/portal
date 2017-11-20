var currentMousePos = {x:-1, y:-1};
var baseUrl = "/portal/django/";
//var baseUrl ="http://localhost:8000/"
var portalUrl = "/portal/"
//var portalUrl = "http://localhost/portal/"
	
var applicants = [];
var leads = [];

var calendar;
var months = [
	{
		name:"Jan",
		full:"January"
	},
	{
		name:"Feb",
		full:"February"
	},
	{
		name:"Mar",
		full:"March"
	},
	{
		name:"Apr",
		full:"April"
	},
	{
		name:"May",
		full:"May"
	},
	{
		name:"Jun",
		full:"June"
	},
	{
		name:"Jul",
		full:"July"
	},
	{
		name:"Aug",
		full:"August"
	},
	
	{
		name:"Sep",
		full:"September"
	},
	{
		name:"Oct",
		full:"October"
	},
	{
		name:"Nov",
		full:"November"
	},
	{
		name:"Dec",
		full:"December"
	}
]
function validateEmail(email) { 
    var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return re.test(email);
} 

function deparamAndTransform(){
		var formValues = jQuery.deparam(jQuery("#appointment_form").serialize());
	    var startMonth = formValues.start_month
	    var i;
	    for (i=1;i<=12;i++){
	    	if (months[i-1]!=undefined){
		    	if (months[i-1].name==startMonth){
		    		formValues.start_month = i;
		    		break;
		    	}	
	    	}
	    	
	    }
	    startMonth = (formValues.start_month);
	    formValues.start_month = startMonth
	    formValues.start_date = formValues.start_year+"-"+startMonth+"-"+formValues.start_day
		
		
		var endMonth = formValues.end_month
		for (i=1;i<=12;i++){
			if (months[i-1]!=undefined){
				if (months[i-1].name==endMonth){
		    		formValues.end_month = i;
		    		break;
		    	}	
			}
		}
		endMonth = formValues.end_month
		formValues.end_month = endMonth
		formValues.end_date = formValues.end_year+"-"+formValues.end_month+"-"+formValues.end_day
		if (formValues.online_meeting_select==undefined||formValues.online_meeting_select==""){
			formValues.online_meeting_select = "others"
		}
		return formValues;
	}
	
	
var selectedAppointmentId = "";
	

jQuery(document).ready(function(){
	
	
	jQuery("#appointment_form").submit(function(){
		if (jQuery.browser.webkit){
			return false;
				
		}
	})
	
		
	jQuery("#timezones").val(jQuery("#request_for_interview_timezoneid").val());
	jQuery("#selected_timezone_new_appointment").val(jQuery("#request_for_interview_timezone").val())
	
	jQuery.ajaxSetup({ 
	     beforeSend: function(xhr, settings) {
	         function getCookie(name) {
	             var cookieValue = null;
	             if (document.cookie && document.cookie != '') {
	                 var cookies = document.cookie.split(';');
	                 for (var i = 0; i < cookies.length; i++) {
	                     var cookie = jQuery.trim(cookies[i]);
	                     // Does this cookie string begin with the name we want?
	                 if (cookie.substring(0, name.length + 1) == (name + '=')) {
	                     cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
	                     break;
	                 }
	             }
	         }
	         return cookieValue;
	         }
	         if (!(/^http:.*/.test(settings.url) || /^https:.*/.test(settings.url))) {
	             // Only send the token to relative URLs i.e. locally.
	             xhr.setRequestHeader("X-CSRFToken", getCookie('csrf_token'));
	         }
	     } 
	});
	 $(document).mousemove(function(event) {
        currentMousePos = {
            x: event.pageX,
            y: event.pageY
        };
    });
    
    
    
    //load session from php then throw to python session handling
    jQuery.get(portalUrl+"meeting_calendar/getsession.php", function(data){
    	data = jQuery.parseJSON(data);
    	if (!data.success){
    		window.location.href = "/portal/";
    	}else{
    		var view_other_admin = jQuery("#view_other_admin_field").val();
    		if (view_other_admin=="1"&&data.view_other_calendar=="N"){
    			window.location.href = baseUrl+"meeting_calendar/view/?admin_id="+data.admin_id
    		}
    		if (data.view_other_calendar=="N"){
    			jQuery("#header_admin_select").html("<p style='margin-top:10px'>"+data.name+"</p>");
    		}	
    		
    		
    		jQuery("#login_username").val(data.name);
    		jQuery.post(baseUrl+"meeting_calendar/session_transfer/", {admin_id:data.admin_id}, function(){
  				
    		});
    	}
    });
    
    
   
   var templates_add = jQuery(".without_appointment");
   var templates_update = jQuery(".with_appointment");
   var selectedHour = 0;
   jQuery(".context_menu").remove();
   jQuery(".schedule_plots").live("click", function(e){
   		var top = currentMousePos.y;
   		var left  = currentMousePos.x;
   		selectedHour = jQuery(this).attr("data-hour");
   		jQuery(".context_menu").remove();
   		if (!jQuery(this).hasClass("disabled")&&!jQuery(".header").hasClass("disabled")){
	   		jQuery(templates_add).appendTo(jQuery("body")).hide().css("top", top+"px").css("left", left+"px").fadeIn(100);
   		}
   		e.stopPropagation();
   })
   
   
   jQuery("#header_admin_id").val(jQuery("#admin_id").val());
   
   jQuery(".appointment_item").live("click", function(e){
  		var top = currentMousePos.y;
   		var left  = currentMousePos.x;
   		selectedHour = jQuery(this).parent().parent().attr("data-hour");
   		jQuery(".context_menu").remove();
   		var appointment_id = jQuery(this).attr("data-id");
   		if (!jQuery(this).hasClass("disabled")&&!jQuery(".header").hasClass("disabled")){
	   		jQuery(templates_update).appendTo(jQuery("body")).hide().css("top", top+"px").css("left", left+"px").attr("data-id", appointment_id).fadeIn(100);
   		}
   		e.stopPropagation();	
   });
   jQuery(".context_menu .close_menu a").live("click", function(e){
   		jQuery(this).parent().parent().fadeOut(300, function(){
   			jQuery(this).remove()
   		})
   		e.preventDefault();
   })
   jQuery(".sched_link").live("click", function(e){
   		var appointment_id = jQuery(this).attr("data-id");
   		openAppointment(appointment_id)
   		e.stopPropagation();
   		e.preventDefault();
   });
   
   function reloadPlots(admin_id, selectedDate, selectedTimezone){
   	   jQuery(".schedule_plots").addClass("disabled");
	   var url = baseUrl+"meeting_calendar/load_active_appointments/?selected_date="+selectedDate+"&admin_id="+admin_id+"&selected_timezone="+selectedTimezone;
	   if (selected_request_for_interview_id==undefined){
		   if (jQuery("#request_for_interview_id").val()!=""){
		   		url = baseUrl+"meeting_calendar/load_active_appointments/?selected_date="+selectedDate+"&admin_id="+admin_id+"&selected_timezone="+selectedTimezone+"&request_for_interview_id="+jQuery("#request_for_interview_id").val();   	
		   }	
	   }else{
			url = baseUrl+"meeting_calendar/load_active_appointments/?selected_date="+selectedDate+"&admin_id="+admin_id+"&selected_timezone="+selectedTimezone+"&request_for_interview_id="+selected_request_for_interview_id;   		   	   	
	   }
	   
	   jQuery.get(url, function(data){
	   		data = jQuery.parseJSON(data);
	   		jQuery(".schedule_plots .appointment").html("").removeClass("disabled");
	   		if (data.appointments.length>0){
		   		jQuery(".schedule_plots").removeClass("disabled").addClass("without_appointment").removeClass("with_appointment");
		   		jQuery.each(data.appointments, function(i, item){
		   			var timesplit = item.convertedStartDate;
		   			timesplit = timesplit.split(" ");
		   			var date_timezone = timesplit[0];
		   			var time_timezone = timesplit[1];
		   			time_timezone = time_timezone.split(":")
		   			if (date_timezone==jQuery("#calendar_events").val()){
		   				var plotHour = time_timezone[0].charAt(0);
		   				if (plotHour=="0"){
		   					plotHour = time_timezone[0].charAt(1);
		   				}else{
		   					plotHour = time_timezone[0];
		   				}
		   				jQuery("#hour_"+plotHour).removeClass('disabled').addClass('with_appointment').removeClass("without_appointment");
			   			var startMinute = item.start_minute;
			   			if (parseInt(startMinute)<10){
			   				startMinute = "0"+startMinute;
			   			}
			   			var appointment_class = "";
			   			if (selectedAppointmentId==item.id){
			   				appointment_class = "selected"
			   			}
			   			
			   			
			   			var templateAppointment = "<div class='appointment_item "+appointment_class+"' data-id='"+item.id+"'>";
				   			templateAppointment += "<p><strong>Start Time:</strong> "+item.convertedStartDateAMPM+" "+item.selectedTimezone+"</p>"
				   			templateAppointment += "<p><strong>Start Time(Client):</strong>"+item.originalStartDateAMPM+" "+item.time_zone+"</p>";
				   			templateAppointment += "<p><a href='#' class='sched_link' data-id='"+item.id+"'>"+item.subject+"</a></p>";
			   			templateAppointment +="</div>";
			   			jQuery(templateAppointment).appendTo(jQuery("#hour_"+plotHour).children(".appointment"));
		   			}
		   			
		   			
		   		
		   		});	   			
	   		}else{
	   			jQuery(".schedule_plots").removeClass("disabled").addClass("without_appointment").removeClass("with_appointment");
	   		}

	   });
	   
	   
	   //load all active items
	   var view_mode = jQuery("#view_mode").val();
	   if (view_mode=="my_sched"){
	   		url = baseUrl+"meeting_calendar/load_active_appointments/?selected_date="+selectedDate+"&admin_id="+admin_id+"&selected_timezone="+selectedTimezone;
	   }
	   jQuery.get(url, function(data){
	   		data = jQuery.parseJSON(data);
	   		jQuery("#today_and_other_schedules").html("");
	   		if (data.appointments.length>0){
		   		jQuery.each(data.appointments, function(i, item){
		   			var timesplit = item.convertedStartDate;
		   			timesplit = timesplit.split(" ");
		   			var date_timezone = timesplit[0];
		   			var time_timezone = timesplit[1];
		   			time_timezone = time_timezone.split(":")
	   				var plotHour = time_timezone[0].charAt(0);
	   				if (plotHour=="0"){
	   					plotHour = time_timezone[0].charAt(1);
	   				}else{
	   					plotHour = time_timezone[0];
	   				}
	   				jQuery("#hour_"+plotHour).removeClass('disabled').addClass('with_appointment').removeClass("without_appointment");
		   			var startMinute = item.start_minute;
		   			if (parseInt(startMinute)<10){
		   				startMinute = "0"+startMinute;
		   			}
		   			var originalDate = item.originalStartDate.split(" ")
		   			originalDate = jQuery.trim(originalDate[0]);
		   			var request_for_interview_id = item.request_for_interview.id;
		   			var templateAppointment = "";
		   			if (request_for_interview_id==undefined){
		   				request_for_interview_id = "";
		   				templateAppointment = "<div class='schedule_item span12 ui-state-default' data-id='"+item.id+"' data-date='"+originalDate+"' data-request_for_interview='"+request_for_interview_id+"' data-original_timezone_id='"+item.originalTimezone.id+"' data-original_timezone='"+item.originalTimezone.timezone+"'>";
			   			templateAppointment += "<p class='text'><strong>Start Time:</strong> "+item.convertedStartDateAMPM+" "+item.selectedTimezone+"</p>"
			   			templateAppointment += "<p class='text'><strong>Start Time(Client):</strong>"+item.originalStartDateAMPM+" "+item.time_zone+"</p>";
			   			templateAppointment += "<p><a href='#' class='sched_link' data-id='"+item.id+"'>"+item.subject+"</a></p>";
		   				templateAppointment +="</div>";
		   			}else{
		   				templateAppointment = "<div class='schedule_item span12 ui-state-default request_for_interview_class' data-id='"+item.id+"' data-date='"+originalDate+"' data-request_for_interview='"+request_for_interview_id+"' data-original_timezone_id='"+item.originalTimezone.id+"' data-original_timezone='"+item.originalTimezone.timezone+"'>";
			   			templateAppointment += "<p class='text'><strong>Start Time:</strong> "+item.convertedStartDateAMPM+" "+item.selectedTimezone+"</p>"
			   			templateAppointment += "<p class='text'><strong>Start Time(Client):</strong>"+item.originalStartDateAMPM+" "+item.time_zone+"</p>";
			   			templateAppointment += "<p><a href='#' class='sched_link' data-id='"+item.id+"'>"+item.subject+"</a></p>";
		   				templateAppointment +="</div>";
		   			}
		   			
		   			jQuery(templateAppointment).appendTo(jQuery("#today_and_other_schedules")).hide().fadeIn(200);
		   		
		   		});	   			
	   		}

	   });

	   
	   
	   
   }
   
    calendar = jQuery("#calendar_container").datepicker({
   		dateFormat:"yy-mm-dd",
   		onSelect:function(value, me){
   		   var admin_id = jQuery("#admin_id").val();
		   var selectedTimezone = jQuery("#timezones").val();
		   jQuery("#calendar_events").val(value);
		   var split_date = value.split("-");
		   runInterval();
		   reloadPlots(admin_id, value, selectedTimezone);
   		},
   		onClose:function(){
   			
   		}
   });
   var selected_request_for_interview_id;   
   
   function runInterval(request_for_interview_id){
    	var value = calendar.datepicker("getDate");
		jQuery("#date_selected_header").html(formatDate(value, "EE, NNN dd, yyyy"));
		var calendarValue = formatDate(value, "yyyy-MM-dd");
		selected_request_for_interview_id = request_for_interview_id
		if (calendarValue!=jQuery("#calendar_events").val()){
			jQuery("#calendar_events").val(formatDate(value, "yyyy-MM-dd")).trigger("change");
		}
    }
   jQuery("#calendar_events").change(function(){
   		var admin_id = jQuery("#admin_id").val();
		var selectedTimezone = jQuery("#timezones").val();
		var value = jQuery(this).val();
		if (selected_request_for_interview_id!=undefined){
			reloadPlots(admin_id, value, selectedTimezone, selected_request_for_interview_id)	
		}else{
			reloadPlots(admin_id, value, selectedTimezone);
		}
		
   })
   runInterval(); 
   setInterval(runInterval, 100);
   
  
  
   function setValueCalendar(request_for_interview_id){
   		var value = calendar.datepicker("getDate");
   		var month = value.getMonth()+1;
   		if (month<10){
   			month = "0"+month;
   		}
   		var day = value.getDay()+1;
   		if (day<10){
   			day = "0"+day;
   		}
   		var fulldate = value.getFullYear()+"-"+month+"-"+day;
   		jQuery("#calendar_events").val(fulldate);
   		runInterval(request_for_interview_id);
   }
   var startCounter = 0;
   jQuery("#left_calendar").live("click", function(){
   		startCounter--;
   		calendar.datepicker( "setDate" , startCounter+"d");
 		calendar.trigger('onSelect');
   		setValueCalendar();
   });
   jQuery("#right_calendar").live("click", function(){
   		startCounter++;
   		calendar.datepicker( "setDate" , startCounter+"d");
   		calendar.trigger('onSelect');
   		setValueCalendar();
   });
   jQuery("#today_calendar").live("click", function(){
   		startCounter = 0;
   		calendar.datepicker( "setDate" , startCounter+"d");
   		setValueCalendar()
   })
   
   jQuery("#calendar_container").find(".ui-datepicker-inline").css("margin", "auto");
   
   
   jQuery(".body").click(function(){
   		jQuery(".context_menu").fadeOut(100);
   });
   
   //boot initial appointments
   var selectedDate = jQuery("#calendar_events").val();
   var admin_id = jQuery("#admin_id").val();
   var selectedTimezone = jQuery("#timezones").val();
   reloadPlots(admin_id, selectedDate, selectedTimezone);
   
  	//context menu action
  	jQuery(".context_menu ul li").live("click", function(){
  		var role = jQuery(this).attr("data-role");
  		var appointment_id = jQuery(this).parent().parent().fadeOut(100).attr("data-id");
  		if (role=="new"){
  			newAppointment();
  		}else if (role=="finish"){
  			finishAppointment(appointment_id)
  		}else if (role=="cancel"){
  			cancelAppointment(appointment_id)
  		}else if (role=="delete"){
  			deleteAppointment(appointment_id)
  		}else if (role=="open"){
  			openAppointment(appointment_id)
  		}
  	});
  	
  	function openAppointment(appointment_id){
  		var previewPath = portalUrl+"application_calendar/get_schedule_admin.php?id="+appointment_id;
  		window.open(previewPath,'_blank','width=300,height=200,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
  	}
  	
  	function finishAppointment(appointment_id){
  		var answer = confirm("Do you want to finish this appointment?");
  		if (answer){
  			jQuery.post(baseUrl+"meeting_calendar/finish_appointment/", {appointment_id:appointment_id}, function(data){
  				data = jQuery.parseJSON(data);
  				if (data.success){
  					var selectedDate = jQuery("#calendar_events").val();
				    var admin_id = jQuery("#admin_id").val();
				    var selectedTimezone = jQuery("#timezones").val();
				    reloadPlots(admin_id, selectedDate, selectedTimezone);
  				}else{
  					alert(data.error)
  				}				
  			});
  		}
  	}
  	function cancelAppointment(appointment_id){
  		var answer = confirm("Do you want to cancel this appointment?");
  		if (answer){
  			jQuery.post(baseUrl+"meeting_calendar/cancel_appointment/", {appointment_id:appointment_id}, function(data){
  				data = jQuery.parseJSON(data);
  				if (data.success){
  					var selectedDate = jQuery("#calendar_events").val();
				    var admin_id = jQuery("#admin_id").val();
				    var selectedTimezone = jQuery("#timezones").val();
				    reloadPlots(admin_id, selectedDate, selectedTimezone);
  				}else{
  					alert(data.error)
  				}				
  			});
  		}
  	}
  	function deleteAppointment(appointment_id){
  		var answer = confirm("Do you want to delete this appointment");
  		if (answer){
  			jQuery.post(baseUrl+"meeting_calendar/delete_appointment/", {appointment_id:appointment_id}, function(data){
  				data = jQuery.parseJSON(data);
  				if (data.success){
  					var selectedDate = jQuery("#calendar_events").val();
				    var admin_id = jQuery("#admin_id").val();
				    var selectedTimezone = jQuery("#timezones").val();
				    reloadPlots(admin_id, selectedDate, selectedTimezone);
  				}else{
  					alert(data.error)
  				}
  			});
  		}
  	}
  	
  	function newAppointment(){
  		showModal("Create New Appointment");
  		resetForm();
  		
  		plugValuesToNewAppointment();
  		
  	}
  	function plugValuesToNewAppointment(){
  		var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		var selected_date = jQuery("#calendar_events").val();
		selected_date = selected_date.split("-"); 
		jQuery("#start_month_appointment").val(months[selected_date[1]-1]);
		jQuery("#end_month_appointment").val(months[selected_date[1]-1]);
		var day = selected_date[2];
		if (day.charAt(0)=="0"){
			jQuery("#start_day_appointment").val(day.charAt(1));
			jQuery("#end_day_appointment").val(day.charAt(1));
		}else{
			jQuery("#start_day_appointment").val(selected_date[2]);
			jQuery("#end_day_appointment").val(selected_date[2]);
		}
		
		jQuery("#start_year_appointment").val(selected_date[0]);
		jQuery("#end_year_appointment").val(selected_date[0]);
		jQuery("#start_hour_appointment").val(selectedHour);
		jQuery("#end_hour_appointment").val(selectedHour);
			
  	}
  	function showModal(title){
  		jQuery("#myModal").modal({backdrop: 'static',keyboard: true}).addClass("modal-big");
  		jQuery("#myModalLabel").text(title);
  	}
  	
    function hideModal(){
  		jQuery("#myModal").modal("hide")
  	}
  	
  	
  	var csrf_token = jQuery("#csrf_token").val();
  	
	var uploadedClientItems = [];
	var uploadedApplicantItems = [];
	
  	var runningClient = 0;
  	var allCompleteApplicant = false;
  	var allCompleteClient = false;
  	var submittedClient = false;
  	
	var running = 0;
	var allCompleteApplicant = false;
	var submittedApplicant = false;
	
	function onSaveAppointmentSuccess(data){
		data = jQuery.parseJSON(data);
		if (data.success){
			var selectedDate = jQuery("#calendar_events").val();
		    var admin_id = jQuery("#admin_id").val();
		    var selectedTimezone = jQuery("#timezones").val();
		    reloadPlots(admin_id, selectedDate, selectedTimezone);
		    alert("Message Sent.")
		    jQuery(".save_changes").removeAttr("disabled");
		    hideModal();
		}else{
			alert("The schedule failed to save and send because\n"+data.error+".\nPlease try again")
			jQuery(".save_changes").removeAttr("disabled");
		}
	}
	
	
	
  	//initialize the ajax loader
  	var uploaderClient = new qq.FileUploader({
	    // pass the dom node (ex. $(selector)[0] for jQuery users)
	    element: jQuery("#file_attachment_client")[0],
	    // path to server-side upload script,
	    button:jQuery("#attach_file_client")[0],
	    autoUpload:false,
	    multiple:true,
	    action:baseUrl+"meeting_calendar/upload_attachments/",
	    params: {
	      'csrf_token': csrf_token,
	      'csrf_name': 'csrfmiddlewaretoken',
	      'csrf_xname': 'X-CSRFToken',
	    },
	    onSubmit:function(){
	    	runningClient++;
	    	submittedClient = true;
	    }, 
	    onComplete:function(id, filename){
	    	uploadedClientItems.push(filename);
	    	runningClient--;
	    	if (runningClient==0){
	    		allCompleteClient = true;
	    		var formValues = deparamAndTransform();
	    		if (submittedClient&&submittedApplicant){
	    			if (allCompleteApplicant&&allCompleteClient){
						formValues.uploadedClientItems = uploadedClientItems.join(",");
						formValues.uploadedApplicantItems = uploadedApplicantItems.join(",");
						jQuery.post(baseUrl+"meeting_calendar/save_appointment/", formValues, onSaveAppointmentSuccess);
					
					}
	    		}else{
	    			formValues.uploadedClientItems = uploadedClientItems;
	    			jQuery.post(baseUrl+"meeting_calendar/save_appointment/", formValues, onSaveAppointmentSuccess);
	    		}
				
	    	}
	    }
	});
	
	
	
	
	
	var uploaderApplicant = new qq.FileUploader({
		element:jQuery("#file_attachment_applicant")[0],
		button:jQuery("#attach_file_applicant")[0],
	    autoUpload:false,
	    action:baseUrl+"meeting_calendar/upload_attachments/",
	    multiple:true,
	    params: {
	      'csrf_token': csrf_token,
	      'csrf_name': 'csrfmiddlewaretoken',
	      'csrf_xname': 'X-CSRFToken',
	    },
	    onSubmit: function(){
        	running++;       
        	submittedApplicant = true;                          
    	},
	    onComplete:function(id, filename){
	    	uploadedApplicantItems.push(filename);
			running--;
			if (running==0){
				allCompleteApplicant = true;
				var formValues = deparamAndTransform();
	    		if (submittedClient&&submittedApplicant){
	    			if (allCompleteApplicant&&allCompleteClient){
						formValues.uploadedClientItems = uploadedClientItems.join(",");
						formValues.uploadedApplicantItems = uploadedApplicantItems.join(",");
						jQuery.post(baseUrl+"meeting_calendar/save_appointment/", formValues, onSaveAppointmentSuccess);
					
					}
	    		}else{
	    			formValues.uploadedApplicantItems = uploadedApplicantItems.join(",");
	    			jQuery.post(baseUrl+"meeting_calendar/save_appointment/", formValues, onSaveAppointmentSuccess);
	    		}
			}
			
	    }
	});
	
	if (!jQuery.browser.webkit){
		jQuery(".attacher").css("overflow", "visible").css("overflow", "inherit");
		
	}
	
	jQuery(".qq-upload-button").hide();
	
	
	function validateFields(button){
		var subject = jQuery("#subject_new_appointment").val();
		if (jQuery.trim(subject)==""){
			alert("Subject field is missing.");
			jQuery("#subject_new_appointment").trigger("focus");
			jQuery(button).removeAttr("disabled");
			return false;
		}
		var applicantField = jQuery.trim(jQuery("#applicant_new_appointment").val());
		if (!jQuery("#meeting").is(":checked")){
			if (applicantField==""){
				alert("Applicant field is missing.")
				jQuery("#applicant_new_appointment").trigger("focus")
				jQuery(button).removeAttr("disabled");
				return false;		
			}	
			var countApplicant = applicantField.split("-");
			if (countApplicant.length<2){
				alert("Applicant field is malformed.")
				jQuery("#applicant_new_appointment").trigger("focus")
				jQuery(button).removeAttr("disabled");
				return false;		
			}
		}
		
		var leadsField = jQuery.trim(jQuery("#lead_new_appointment").val());
		if (leadsField==""){
			if (!(jQuery("#initial_interview").is(":checked")||jQuery("#contract_signing").is(":checked")||jQuery("#new_hire_orientation").is(":checked")||jQuery("#meeting").is(":checked"))){
				alert("Lead field is missing.")
				jQuery("#lead_new_appointment").trigger("focus")			
				jQuery(button).removeAttr("disabled");
				return false;			
			}
		}
		if (!jQuery("#meeting").is(":checked")){
			var message_to_applicant = jQuery.trim(jQuery("#message_to_applicant_new_appointment").val());
			if (message_to_applicant==""){
				alert("Message to the applicant is missing");
				jQuery("#message_to_applicant_new_appointment").trigger("focus");
				jQuery(button).removeAttr("disabled");
				return false;
			}
		}
		if (!(jQuery("#initial_interview").is(":checked")||jQuery("#contract_signing").is(":checked")||jQuery("#new_hire_orientation").is(":checked")||jQuery("#meeting").is(":checked"))){
			var message_to_client = jQuery.trim(jQuery("#message_to_client_new_appointment").val());
			if (message_to_client==""){
				alert("Message to the client is missing");
				jQuery("#message_to_client_new_appointment").trigger("focus");
			}
		}
		
		if (!(jQuery("#initial_interview").is(":checked")||jQuery("#contract_signing").is(":checked")||jQuery("#new_hire_orientation").is(":checked")||jQuery("#meeting").is(":checked"))){
			var countLead = leadsField.split("-");
			if (countLead.length<2){
				alert("Lead field is malformed.")
				jQuery("#lead_new_appointment").trigger('focus');
				jQuery(button).removeAttr("disabled");
				return false;		
			}
		}
		if (!jQuery("#online_meeting_checkbox").is(":checked")){
			if (jQuery.trim(jQuery("#location_modal").val())==""){
				alert("Location is required");
				return false;
			}
		}
		
		
		if (jQuery.trim(jQuery("#cc_client").val())!=""){
			var cc_client = jQuery("#cc_client").val();
			cc_client = cc_client.split(",");
			if (cc_client.length>0){
				var invalid = false;
				jQuery.each(cc_client, function(i, item){
					if (!validateEmail(jQuery.trim(item))){
						alert("One of the email in the client's cc/s is not valid");
						invalid = true;
						return false;
					} 
				});
				if (invalid){
					return false;
				}
			}
		}
		
		
		return true;
	}
	
	jQuery(".save_changes").live("click", function(){
		jQuery(this).attr("disabled", "disabled");
		if (validateFields(this)){
			uploaderApplicant.uploadStoredFiles()
			uploaderClient.uploadStoredFiles()
			if (uploaderApplicant.getInProgress()==0&&uploaderClient.getInProgress()==0){
				var formValues = deparamAndTransform();
				jQuery.post(baseUrl+"meeting_calendar/save_appointment/", formValues, onSaveAppointmentSuccess);
			}	
		}else{
			jQuery(this).removeAttr("disabled");
		}
	})
	
	jQuery("#lead_new_appointment").typeahead({
		source:function(query, process){
			return jQuery.get(baseUrl+"meeting_calendar/bootstrap/?type=lead&query="+query, function(data){
				data = jQuery.parseJSON(data);
				var leadsName = []
				jQuery.each(data.leads, function(i, item){
					leadsName.push(item.id+" - "+item.fname+" "+item.lname);
				});
				process(leadsName);
			})
		}
	});
	 function extractor(query) {
        var result = /([^,]+)$/.exec(query);
        if(result && result[1])
            return result[1].trim();
        return '';
    }
	jQuery("#applicant_new_appointment").typeahead({
		source:function(query, process){
			return jQuery.get(baseUrl+"meeting_calendar/bootstrap/?type=applicant&query="+query, function(data){
				data = jQuery.parseJSON(data);
				var applicantsName = []
				jQuery.each(data.applicants, function(i, item){
					applicantsName.push(item.userid+" - "+item.firstname+" "+item.lastname);
				});
				process(applicantsName);
			})
		}
	});
	
	jQuery("#admin_new_appointment").typeahead({
		source:function(query, process){
			queries = query.split(",")
			return jQuery.get(baseUrl+"meeting_calendar/bootstrap/?type=admin&query="+jQuery.trim(queries[queries.length-1]), function(data){
				data = jQuery.parseJSON(data);
				var adminsName = []
				jQuery.each(data.admins, function(i, item){
					adminsName.push(item.admin_id+"-"+item.admin_fname+" "+item.admin_lname);
				});
				process(adminsName);
			})
		},
        updater: function(item) {
            return this.$element.val().replace(/[^,]*$/,'')+item+',';
        },
        matcher: function (item) {
          var tquery = extractor(this.query);
          if(!tquery) return false;
          return ~item.toLowerCase().indexOf(tquery.toLowerCase())
        },
        highlighter: function (item) {
          
          var query = extractor(this.query).replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
          return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
            return '<strong>' + match + '</strong>'
          })
        },
        mode:"multiple"
	});
	
	
	jQuery("#online_meeting_checkbox").live("click", function(){
		if (jQuery(this).is(":checked")){
			jQuery("#online_meeting_select").removeAttr("disabled");
		}else{
			jQuery("#online_meeting_select").attr("disabled", "disabled");
		}
	})
	
	function syncMessageBox(){
		if (jQuery("#online_meeting_select").val()!=""){
			var client_name = jQuery("#lead_new_appointment").val();
			client_name = client_name.split("-");
			client_name = jQuery.trim(client_name[1]);
			var applicant = jQuery("#applicant_new_appointment").val();
			applicant = applicant.split("-");
			var applicant_id = jQuery.trim(applicant[0]);
			applicant = jQuery.trim(applicant[1]);			
			var timezone = jQuery("#selected_timezone_new_appointment").val();
			var facilitator = "";
			jQuery("#admin_id_modal option:selected").each(function(){
				facilitator = jQuery(this).text();
			});
			if (facilitator=="Me"){
				facilitator = "I";
			}
			var type = jQuery("#online_meeting_select").val();
			var month = "";
			jQuery.each(months, function(i, item){
				if (item.name==jQuery("#start_month_appointment").val()){
					month = item.full;
				}
			});
			var startHour = jQuery("#start_hour_appointment").val();
			var ampm = "";
			if (startHour==0){
				startHour = 12;
				ampm = "AM";
			}else if (startHour<12){
				ampm = "AM";				
			}else if (startHour==12){
				ampm = "PM";
			}else{
				startHour = startHour%12;
				ampm = "PM";
			}
			var startMinute = jQuery("#start_minute_appointment").val();
			if (startMinute<10){
				startMinute = "0"+startMinute;
			}
			var fullDate = month+" "+jQuery("#start_day_appointment").val()+", "+jQuery("#start_year_appointment").val()+" "+startHour+":"+startMinute+" "+ampm;
			var loginFull = jQuery("#login_username").val();
			if (!jQuery("#meeting").is(":checked")){
				jQuery.get(portalUrl+"application_calendar/load_template.php?responder_type="+type+"&full_time="+fullDate+"&applicant_name="+applicant+"&client_name="+client_name+"&timezone="+timezone+"&facilitator="+facilitator+"&creator_name="+loginFull+"&userid="+applicant_id, function(data){
					data = jQuery.parseJSON(data);
					jQuery("#message_to_applicant_new_appointment").val(data.output2);
					jQuery("#message_to_client_new_appointment").val(data.output1);
				});				
			}

		}else{
			jQuery("#message_to_applicant_new_appointment").val("");
			jQuery("#message_to_client_new_appointment").val("");
		}
			
	}
	
	
	
	jQuery("#online_meeting_select, #selected_timezone_new_appointment, #start_month_appointment, #start_day_appointment, #admin_id_modal, #start_year_appointment, #start_hour_appointment, #end_month_appointment, #end_day_appointment, #end_year_appointment, #end_hour_appointment, #end_minute_appointment").live("change", function(){
		syncMessageBox();
	});
	
	jQuery("#start_year_appointment, #end_year_appointment, #lead_new_appointment, #applicant_new_appointment").live("keypress", function(){
		syncMessageBox();
	})
	
	function resetForm(){
		$('#appointment_form')[0].reset();
		uploaderClient.clearStoredFiles();
		uploaderApplicant.clearStoredFiles();
		jQuery("#selected_timezone_new_appointment").val(jQuery("#request_for_interview_timezone").val())
	
		uploadedClientItems = [];
		uploadedApplicantItems = [];
	  	runningClient = 0;
	  	allCompleteApplicant = false;
	  	submittedClient = false;
		running = 0;
		allCompleteClient = false;
		submittedApplicant = false;
		jQuery('#appointment_form button').removeAttr("disabled");
		jQuery("#online_meeting_select").attr("disabled", "disabled");
		
	}
	
	jQuery("#timezones").change(function(){
		var selectedDate = jQuery("#calendar_events").val();
	    var admin_id = jQuery("#admin_id").val();
	    var selectedTimezone = jQuery("#timezones").val();
	    reloadPlots(admin_id, selectedDate, selectedTimezone);
	});
	if (jQuery("#request_for_interview_id").val()!=""){
 		jQuery("#initial_interview, #contract_signing, #new_hire_orientation, #meeting").attr("disabled", "disabled");
 	}else{
 		jQuery("#initial_interview, #contract_signing, #new_hire_orientation, #meeting").removeAttr("disabled")
 	}
	
	jQuery("#initial_interview, #contract_signing, #new_hire_orientation, #meeting").live("click", function(){
		var oldValue = jQuery(this).is(":checked");
		jQuery(".checkbox input[type=checkbox]").removeAttr("checked");
		if (oldValue){
			jQuery(this).attr("checked", "checked");
		}
		if (jQuery(this).is(":checked")){
			if (jQuery(this).attr("id")=="meeting"){
				jQuery("#applicant_new_appointment").removeAttr("disabled", "disabled");
				jQuery("#message_to_applicant_new_appointment").removeAttr("disabled", "disabled");
				jQuery("#cc_client").attr("disabled", "disabled");
				jQuery("#cc_main").attr("disabled", "disabled");
				jQuery("#admin_new_appointment").removeAttr("disabled");
			}else{
				jQuery("#applicant_new_appointment").removeAttr("disabled");
				jQuery("#message_to_applicant_new_appointment").removeAttr("disabled");
				jQuery("#cc_client").removeAttr("disabled");
				jQuery("#cc_main").removeAttr("disabled");
				jQuery("#admin_new_appointment").attr("disabled", "disabled");
				jQuery("#lead_new_appointment").attr("disabled", "disabled");
				jQuery("#message_to_client_new_appointment").attr("disabled", "disabled");	
				jQuery("#attach_file_client input[type=file]").attr("disabled", "disabled");
			}
		}else{
			jQuery("#lead_new_appointment").removeAttr("disabled");
			jQuery("#message_to_client_new_appointment").removeAttr("disabled");
			jQuery("#attach_file_client input[type=file]").removeAttr("disabled");
			jQuery("#applicant_new_appointment").removeAttr("disabled");
			jQuery("#message_to_applicant_new_appointment").removeAttr("disabled");
			jQuery("#cc_client").removeAttr("disabled");
			jQuery("#cc_main").removeAttr("disabled")
			jQuery("#admin_new_appointment").attr("disabled", "disabled");
		}
		
	});
	
	
	jQuery(".schedule_item").live("mouseover", function(){
		jQuery(this).addClass("ui-state-hover");
	}).live("mouseout", function(){
		jQuery(this).removeClass("ui-state-hover");
	}).live("click", function(e){
		jQuery("#timezones").val(jQuery(this).attr("data-original_timezone_id"));
		jQuery("#selected_timezone_new_appointment").val(jQuery(this).attr("data-original_timezone"))
		
		var appointment_id = jQuery(this).attr("data-id");
		selectedAppointmentId = appointment_id;
   		var selectedDate = jQuery(this).attr("data-date");
   		var request_for_interview_id = jQuery(this).attr("data-request_for_interview");
   		selected_request_for_interview_id = request_for_interview_id
   		jQuery("#request_for_interview_id").val(request_for_interview_id);
   		selectedDate = selectedDate.split("-")
   		var months = 0;
   		if (selectedDate[1].charAt(0)=="0"){
   			months = selectedDate[1].charAt(1);
   		}else{
   			months = selectedDate[1];
   		}
   		var date = new Date(selectedDate[0], parseInt(months)-1, selectedDate[2]); // replace with your date
	    calendar.datepicker("setDate", date);
   		calendar.trigger('onSelect');
   		setValueCalendar();
   		e.stopPropagation();
   		e.preventDefault();
	})
	

});
