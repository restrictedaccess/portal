		var selected_x_id = 0;

		function hire_status(id) 
		{
			var s = confirm("Would you like to remove this candidate from ASL? (click OK to move this candidate hired and remove from ASL list, click CANCEL to move this record to hired but still available on ASL list.");
			if(s)
			{
				document.location = "request_for_interview.php?hired_visiblity=yes&key={ $key }&date_requested1={ $date_requested1 }&date_requested2={ $date_requested2 }&status={ $status }&stat=HIRED&id="+id;
			}
			else
			{
				document.location = "request_for_interview.php?hired_visiblity=no&key={ $key }&date_requested1={ $date_requested1 }&date_requested2={ $date_requested2 }&status={ $status }&stat=HIRED&id="+id;				
			}
		}
		
		function lead(id) 
		{
			previewPath = "../leads_information.php?id="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			

		function meeting_calendar(id,leads_id,interview_id) 
		{
			previewPath = "../meeting_calendar/index.php?interview_id="+interview_id+"&view_type=view";
			window.open(previewPath,'_blank','width=1000,height=900,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}	
		
		function rescheduled(id,leads_id,interview_id) 
		{
			previewPath = "../meeting_calendar/index.php?interview_id="+interview_id+"&view_type=view&is_rescheduled=Yes";
			window.open(previewPath,'_blank','width=1000,height=900,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}				

		function resume(id) 
		{
			previewPath = "staff_information.php?userid="+id+"&page_type=popup";
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			

		function resume2(id) 
		{
			previewPath = "../../available-staff-resume.php?userid="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}			

		function update(id) 
		{
			previewPath = "../update_endorse_to_client.php?id="+id;
			window.open(previewPath,'_blank','width=500,height=400,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
	
		function showSubMenu(menuId)
		{
			if (curSubMenu!='') 
				hideSubMenu();
			
			eval('document.all.'+menuId).style.visibility='visible';
			curSubMenu=menuId;
		}
		
		function hideSubMenu()
		{
			eval('document.all.'+curSubMenu).style.visibility='hidden';
			curSubMenu='';
		}

		var voucher_obj = makeObject()
		function update_voucher(id,voucher)
		{
			selected_x_id = id;
			var comments = document.getElementById('comments_'+id).value;
			var date_expire = document.getElementById('date_expire_'+id).value;
			voucher_obj.open('get', 'admin_request_for_interview_voucher_update.php?code_number='+voucher+'&date_expire='+date_expire+'&comment='+comments)
			voucher_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			voucher_obj.onreadystatechange = voucher_details_preview 
			voucher_obj.send(1)
			hideSubMenu();
		}
		function voucher_details_preview()
		{
			var data;
			data = voucher_obj.responseText
			if(voucher_obj.readyState == 4)
			{
				document.getElementById('voucher_details_'+selected_x_id).innerHTML = data;
			}
			else
			{
				document.getElementById('voucher_details_'+selected_x_id).innerHTML="<img src='images/ajax-loader.gif'>";
			}
		}	
		function show_hide_search(id, label) 
		{
			var search_box = document.getElementById(id);
			var label_str = document.getElementById(label);
			if (search_box.style.display == 'none') 
			{
				search_box.style.display = '';
				label_str.innerHTML = '[Hide]';
			} 
			else 
			{
				search_box.style.display = 'none';
				label_str.innerHTML = '[Show]';
			}
		}	
		
		//START: update status
		var status_obj = makeObject()
		function update_status(status,id)
		{
			var hired_visiblity = '';
			selected_x_id = id;
			var label = ""
			if (status=="ACTIVE"){
				label = "New"
			}else if (status=="ARCHIVED"){
				label = "Archived"
			}else if (status=="ON-HOLD"){
				label = "On Hold"
			}else if (status=="HIRED"){
				label = "Hired"
			}else if (status=="REJECTED"){
				label = "Rejected"
			}else if (status=="CONFIRMED"){
				label = "Confirmed/In Process"
			}else if (status=="YET TO CONFIRM"){
				label = "Client contacted, no confirmed date"
			}else if (status=="DONE"){
				label = "Interviewed; waiting for feedback"
			}else if (status=="RE-SCHEDULED"){
				label = "Confirmed/Re-Booked"
			}else if (status=="CANCELLED"){
				label = "Cancelled"
			}else if (status=="CHATNOW INTERVIEWED"){
				label = "Contract Page Set"
			}else if (status=="ON TRIAL"){
				label = "On Trial"
			}else{
				label = status
			}
			
			
			var answer = confirm("Are you sure do you want to update the status of this interview to "+label+"?")
			
			
			if (answer){
				if(status == 'HIRED')
				{
					var s = confirm("Would you like to remove this candidate from ASL? (click OK to move this candidate hired and remove from ASL list, click CANCEL to move this record to hired but still available on ASL list.");
					if(s)
					{
						hired_visiblity='yes';
					}
					else
					{
						hired_visiblity='no';
					}
				}
				
				status_obj.open('get', 'request_for_interview_status_update.php?id='+id+'&status='+status+'&hired_visiblity='+hired_visiblity);
				status_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				status_obj.onreadystatechange = update_status_preview; 
				status_obj.send(1);
				
				}
			
		}
		function update_status_preview()
		{
			var data;
			data = status_obj.responseText
			if(status_obj.readyState == 4)
			{
				document.getElementById('status_details_'+selected_x_id).innerHTML = data;
			}
			else
			{
				document.getElementById('status_details_'+selected_x_id).innerHTML="<img src='../images/ajax-loader.gif' width='20'>";
			}
		}		
		//ENDED: update status
		
		//START: update status
		var payment_obj = makeObject()
		function update_payment(status,id)
		{
			selected_x_id = id;
			payment_obj.open('get', 'request_for_interview_payment_update.php?id='+id+'&status='+status)
			payment_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			payment_obj.onreadystatechange = payment_preview 
			payment_obj.send(1)
		}
		function payment_preview()
		{
			var data;
			data = payment_obj.responseText
			if(payment_obj.readyState == 4)
			{
				document.getElementById('payment_details_'+selected_x_id).innerHTML = data;
			}
			else
			{
				document.getElementById('payment_details_'+selected_x_id).innerHTML="<img src='../images/ajax-loader.gif' width='20'>";
			}
		}		
		//ENDED: update status		
		
jQuery(document).ready(function(){
	var currencies = [];
	
	jQuery.get("/portal/recruiter/load_currency.php", function(data){
		currencies = jQuery.parseJSON(data);
	})
	
	
	jQuery("#search").click(function(){
		if (jQuery("#service_type").val()!=""){
			jQuery("#filter-form").attr("action", "?service_type="+jQuery("#service_type").val());			
		}else{
			jQuery("#filter-form").attr("action", "/portal/recruiter/request_for_interview.php");			
		}

	})
	jQuery(".close-cancel").live("click", function(e){
		jQuery(".cancel-panel").fadeOut(100, function(){
			jQuery(this).remove();
		});
		e.preventDefault();
	})
	
	jQuery(".cancel-panel-form").live("submit", function(e){
		var data = jQuery(this).serialize();
		jQuery.post("/portal/recruiter/cancel-interview-request.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				var id = response.id;
				jQuery(".cancel-panel").fadeOut(100, function(){
					jQuery(this).remove();
				});
				jQuery("#status_details_"+id).html(response.status);
			}
		});
		return false;
	});
	
	jQuery(".delete_interview_feedback").click(function(e){
		var ans = confirm("Do you want to delete this feedback?");
		var me = jQuery(this);
		if (ans){
			jQuery.get(me.attr("href"), function(response){
				response = jQuery.parseJSON(response)
				if (response.success){
					jQuery("#feedback_"+me.attr("data-id")).remove();
					alert("Feedback has been successfully removed");
				}
			})
		}
		e.preventDefault();
	})
	
	jQuery(".view_feedback").click(function(e){
		 jQuery(  "#view-feedback-dialog"  ).html("");
		jQuery.get(jQuery(this).attr("href"), function(response){
			 jQuery(  "#view-feedback-dialog"  ).html(response);
			jQuery("#view-feedback-dialog").dialog(
			{height: 430,
			width:840,
			modal: true,
			buttons: {
		        
		        Close: function() {
		          jQuery(  "#view-feedback-dialog"  ).dialog( "close" );
		        }
		      }
			});
			
		});
		e.preventDefault();
	});
	jQuery(".add-feedback").click(function(e){
		var request_for_interview_id = jQuery(this).attr("data-interview-id");
		
		jQuery.get("/portal/recruiter/get_interview_info.php?interview_id="+request_for_interview_id, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				jQuery("#feedback_client_name").text(response.row.client_name);
				jQuery("#feedback_staff_name").text(response.row.staff);
				jQuery("#feedback_request_for_interview_id").val(request_for_interview_id);
			}
			
			jQuery( "#add-feedback-dialog" ).dialog(
			{height: 430,
			width:590,
			modal: true,
			title:'Add feedback for Interview',
			buttons: {
		        "Save Feedback": function() {
		        	var data = jQuery(".add_feedback_form").serialize();
					jQuery.post("/portal/recruiter/add_interview_request_feedback.php", data, function(response){
						response = jQuery.parseJSON(response);
						if (response.success){
							alert("Feedback has been saved");
							jQuery(  "#add-feedback-dialog"  ).dialog( "close" );
							window.location.reload();
						}else{
							alert(response.error);
						}
					})

		        },
		        Cancel: function() {
		          jQuery(  "#add-feedback-dialog"  ).dialog( "close" );
		        }
		      }
			});
			
		})

		e.preventDefault();
	})
	
	jQuery(".cancelled").click(function(e){
		jQuery(".cancel-panel").remove();
		var id = jQuery(this).attr("data-id");
		var statuses = ['STAFF NO SHOW','CLIENT NO SHOW','CLIENT CANCELLED','STAFF CANCELLED'];
		var statusLabels = ['Staff No Show', 'Client No Show', 'Client Cancelled', 'Staff Cancelled'];
		
		var options = "";
		jQuery.each(statuses, function(i, item){
			var selected = "";
			if (i==0){
				selected="checked";
			}
			options+=("<input type='radio' value='"+item+"' name='status' "+selected+"/>"+statusLabels[i]+"<br/>");			
		})
		
		var panel = "<div class='cancel-panel'><div class='title'><a href='#' class='close-cancel'>Close [x]</a></div><form class='cancel-panel-form'><input type='hidden' name='id' value='"+id+"'/>"+options+"<button type='submit button'>Cancel Interview</button></div>";
		var notes_position = jQuery("#notes_"+id).offset().top+90;
		jQuery(panel).css("left", "240px").css("top", notes_position+"px").css("position", "absolute").appendTo("body").hide().fadeIn(100);
		e.preventDefault();
	})
	
	
	function renderResult(me, contractType, staffRate, chargeOut, currency, status, designation, schedule, invoice, startdate, contractSent, gst, docs_received, docs_pending, client_contractSent, staff_docs_received){
		var contractTypes = ['CUSTOM','ASL','BACK ORDER','REPLACEMENT','INHOUSE'];
		var gsts = [{value:"yes", label:"Yes"}, {value:"no", label:"No"}]
		var id = me.attr("data-request-id");
		var contractTypeSelect = "<select name='contract_type'>";
		jQuery.each(contractTypes, function(i, item){
			if (item==contractType){
				contractTypeSelect+=("<option selected>"+item+"</option>");	
			}else{
				contractTypeSelect+=("<option>"+item+"</option>");
			}
		});
		contractTypeSelect += "</select>";
		
		var gstSelect = "<select name='gst'>";
		jQuery.each(gsts, function(i, item){
			if (item.label==gst){
				gstSelect += "<option value='"+item.value+"' selected>"+item.label+"</option>";
			}else{
				gstSelect += "<option value='"+item.value+"'>"+item.label+"</option>";
			}
		});
		gstSelect+= "</select>";
		me.parent("td").find(".gst-label").html(gstSelect);
		me.parent("td").find(".contract-label").html(contractTypeSelect);
		me.parent("td").find(".staffrate-label").html("<input type='text' name='staff_rate' value='"+staffRate+"'/>")
		me.parent("td").find(".chargeout-label").html("<input type='text' name='charge_out' value='"+chargeOut+"'/>")
		me.parent("td").find(".docs-received-label").html("<input type='text' name='docs_received' value='"+docs_received+"'/>")
		me.parent("td").find(".docs-pending-label").html("<input type='text' name='docs_pending' value='"+docs_pending+"'/>")
		
		var currencySelect = "<select name='currency'>";
		if (currencies.length==0){
			jQuery.get("/portal/recruiter/load_currency.php", function(data){
				currencies = jQuery.parseJSON(data);
				var optionSelect = "";
				jQuery.each(currencies, function(i, item){
					if (item.code==currency){
						optionSelect+=("<option selected>"+item+"</option>");	
					}else{
						optionSelect+=("<option>"+item+"</option>");
					}
				});
				me.parent("td").find("select[name=currency]").html(optionSelect);
			})
		}else{
			jQuery.each(currencies, function(i, item){
				if (item.code==currency){
					currencySelect+=("<option value='"+item.id+"' selected>"+item.code+"</option>");	
				}else{
					currencySelect+=("<option value='"+item.id+"'>"+item.code+"</option>");
				}
			});
		}
		currencySelect += "</select>";
		me.parent("td").find(".currency-label").html(currencySelect);
		var statuses = ['Part Time', 'Full Time'];
		var statusSelect = "<select name='status'>";
		jQuery.each(statuses, function(i, item){
			if (item==status){
				statusSelect+=("<option selected>"+item+"</option>");	
			}else{
				statusSelect+=("<option>"+item+"</option>");
			}
		});
		statusSelect += "</select>";
		me.parent("td").find(".status-label").html(statusSelect);
		me.parent("td").find(".designation-label").html("<input type='text' name='designation' value='"+designation+"'/>")
		me.parent("td").find(".schedule-label").html("<input type='text' name='schedule' value='"+schedule+"'/>")
		me.parent("td").find(".invoice-label").html("<input type='text' name='invoice' value='"+invoice+"'/>")
		me.parent("td").find(".staff-docs-received-label").html("<input type='text' name='staff_docs_received' value='"+staff_docs_received+"'/>")
		
		me.parent("td").find(".startdate-label").html("<img align=\"absmiddle\" src=\"../../images/date-picker.gif\" id=\"date_start_date_"+id+"_button\" style=\"cursor: pointer; \" title=\"Select a Date\" alt=\"Select a Date\" onmouseover=\"this.style.background=\'red\'\" onmouseout=\"this.style.background=\'\'\"><input type='text' name='start_date' id='start_date_"+id+"' value='"+startdate+"' maxlength='10'/>")
		Calendar.setup({
			inputField	: "start_date_"+id,
			ifFormat	: "%Y-%m-%d",
			button		: "date_start_date_"+id+"_button",
			align		: "Tl",
			showsTime	: false, 
			singleClick	: true
		});
		var checkbox = '';
		var contractSentDate = '';
		if (jQuery.trim(contractSent)=="No"){
			checkbox = "<input type='checkbox' name='contract_sent'/>";
			contractSentDate = "<img align=\"absmiddle\" src=\"../../images/date-picker.gif\" id=\"date_contract_sent_date_"+id+"_button\" style=\"cursor: pointer; \" title=\"Select a Date\" alt=\"Select a Date\" onmouseover=\"this.style.background=\'red\'\" onmouseout=\"this.style.background=\'\'\"><input type='text' name='contract_sent_date' id='contract_sent_date_"+id+"' maxlength='10'/>";
		}else{
			var contents = contractSent.split(",");
			checkbox = "<input type='checkbox' name='contract_sent' checked/>";
			text = jQuery.trim(contents[1]);
			contractSentDate = "<img align=\"absmiddle\" src=\"../../images/date-picker.gif\" id=\"date_contract_sent_date_"+id+"_button\" style=\"cursor: pointer; \" title=\"Select a Date\" alt=\"Select a Date\" onmouseover=\"this.style.background=\'red\'\" onmouseout=\"this.style.background=\'\'\"><input type='text' name='contract_sent_date' id='contract_sent_date_"+id+"' value='"+text+"' maxlength='10'/>";
		}

		me.parent("td").find(".contract_sent-label").html(checkbox+contractSentDate);
		Calendar.setup({
			inputField	: "contract_sent_date_"+id,
			ifFormat	: "%Y-%m-%d",
			button		: "date_contract_sent_date_"+id+"_button",
			align		: "Tl",
			showsTime	: false, 
			singleClick	: true
		});
		
		
		var client_checkbox = '';
		var client_contractSentDate = '';
		if (jQuery.trim(client_contractSent)=="No"){
			client_checkbox = "<input type='checkbox' name='client_contract_sent'/>";
			client_contractSentDate = "<img align=\"absmiddle\" src=\"../../images/date-picker.gif\" id=\"client_date_contract_sent_date_"+id+"_button\" style=\"cursor: pointer; \" title=\"Select a Date\" alt=\"Select a Date\" onmouseover=\"this.style.background=\'red\'\" onmouseout=\"this.style.background=\'\'\"><input type='text' name='client_contract_sent_date' id='client_contract_sent_date_"+id+"' maxlength='10'/>";
		}else{
			var client_contents = client_contractSent.split(",");
			client_checkbox = "<input type='checkbox' name='client_contract_sent' checked/>";
			text = jQuery.trim(client_contents[1]);
			client_contractSentDate = "<img align=\"absmiddle\" src=\"../../images/date-picker.gif\" id=\"client_date_contract_sent_date_"+id+"_button\" style=\"cursor: pointer; \" title=\"Select a Date\" alt=\"Select a Date\" onmouseover=\"this.style.background=\'red\'\" onmouseout=\"this.style.background=\'\'\"><input type='text' name='client_contract_sent_date' id='client_contract_sent_date_"+id+"' value='"+text+"' maxlength='10'/>";
		}

		me.parent("td").find(".client_contract_sent-label").html(client_checkbox+client_contractSentDate);
		Calendar.setup({
			inputField	: "client_contract_sent_date_"+id,
			ifFormat	: "%Y-%m-%d",
			button		: "client_date_contract_sent_date_"+id+"_button",
			align		: "Tl",
			showsTime	: false, 
			singleClick	: true
		});
		
		
		
		
		
	}
	
	function heightenBox(box){
		box.animate({
			height:420
		}, 100, function(){});
	}
	
	function shortenBox(box){
		box.animate({
			height:130
		}, 100, function(){});
	}
	
	jQuery(".view-more-minimize").live("click", function(e){
		var state = jQuery(this).attr("data-state");
		if (state=="more"){
			heightenBox(jQuery(this).parent().children(".notes_wrapper"))
			jQuery(this).attr("data-state", "less").text("[Minimize]");
		}else{
			shortenBox(jQuery(this).parent().children(".notes_wrapper"))
			jQuery(this).attr("data-state", "more").text("[View More]");
		}
		e.preventDefault();
	})
	
	jQuery(".add-edit-notes").live("click", function(e){
		var mode = jQuery(this).attr("data-mode");
		var id = jQuery(this).attr("data-request-id");
		var text = "";
		var me = jQuery(this);
		if (mode=="AddEdit"){
			
			var contractType = jQuery(this).parent("td").find(".contract-label").text();
			var staffRate = jQuery(this).parent("td").find(".staffrate-label").text();
			var chargeOut = jQuery(this).parent("td").find(".chargeout-label").text();
			var currency = jQuery(this).parent("td").find(".currency-label").text();
			var status = jQuery(this).parent("td").find(".status-label").text();
			var designation = jQuery(this).parent("td").find(".designation-label").text();
			var schedule = jQuery(this).parent("td").find(".schedule-label").text();
			var invoice = jQuery(this).parent("td").find(".invoice-label").text();
			var startdate = jQuery(this).parent("td").find(".startdate-label").text();
			var contractSent = jQuery(this).parent("td").find(".contract_sent-label").text();
			var gst = jQuery(this).parent("td").find(".gst-label").text();
			var docs_received = jQuery(this).parent("td").find(".docs-received-label").text();
			var docs_pending = jQuery(this).parent("td").find(".docs-pending-label").text();
			var client_contractSent = jQuery(this).parent("td").find(".client_contract_sent-label").text();
			var staff_docs_received = jQuery(this).parent("td").find(".staff-docs-received-label").text();
			renderResult(jQuery(this), contractType, staffRate, chargeOut, currency, status, designation, schedule, invoice, startdate, contractSent, gst, docs_received, docs_pending, client_contractSent, staff_docs_received);
			jQuery(this).text("Save Note").attr("data-mode", "Save");
			heightenBox(jQuery(this).parent().children(".notes_wrapper"))
			jQuery(this).parent().find(".view-more-minimize").attr("data-state", "less").text("[Minimize]");
			
		}else{
			
			var sendData = me.parent("td").find(".notebox-form").serialize();
			
			me.attr("disabled", "disabled");
			jQuery.post("/portal/recruiter/add_notes_on_interview_request.php", sendData, function(data){
				data = jQuery.parseJSON(data);
				me.removeAttr("disabled").text("Edit Notes").attr("data-mode", "AddEdit");
				me.parent("td").find(".contract-label").html(data.saveData.contract_type);
				me.parent("td").find(".staffrate-label").html(data.saveData.staff_rate);
				me.parent("td").find(".chargeout-label").html(data.saveData.charge_out);
				me.parent("td").find(".currency-label").html(data.saveData.currency);
				me.parent("td").find(".startdate-label").html(data.saveData.start_date);
				me.parent("td").find(".designation-label").html(data.saveData.designation);
				me.parent("td").find(".status-label").html(data.saveData.status);
				me.parent("td").find(".invoice-label").html(data.saveData.invoice);
				me.parent("td").find(".schedule-label").html(data.saveData.schedule);	
				me.parent("td").find(".gst-label").html(data.saveData.gst);	
				me.parent("td").find(".docs-received-label").html(data.saveData.docs_received);	
				me.parent("td").find(".docs-pending-label").html(data.saveData.docs_pending);	
				me.parent("td").find(".staff-docs-received-label").html(data.saveData.staff_docs_received);	
				
							
				if (data.saveData.contract_sent==1){
					if (data.saveData.contract_sent_date==""){
						me.parent("td").find(".contract_sent-label").html("Yes");
					}else{
						me.parent("td").find(".contract_sent-label").html("Yes, "+data.saveData.contract_sent_date);	
					}
					
				}else{
					me.parent("td").find(".contract_sent-label").html("No");
				}
				if (data.saveData.client_contract_sent==1){
					if (data.saveData.client_contract_sent_date==""){
						me.parent("td").find(".client_contract_sent-label").html("Yes");
					}else{
						me.parent("td").find(".client_contract_sent-label").html("Yes, "+data.saveData.client_contract_sent_date);	
					}
					
				}else{
					me.parent("td").find(".client_contract_sent-label").html("No");
				}
				
				alert("Notes has been saved.");
				
				
			});
		}
	});
})