		function sync_to_v2(){
			//jQuery.get("/portal/recruiter/staff_information.php", {only_sync_to_v2:true, userid:jQuery('input[name="userid"]').val()});
		}
		//START: other 
		function check_val()
		{
			var ins = document.getElementsByName('recruitment_job_order_form')
			var i;
			var j=0;
			var vals="without"; //= new Array();
			for(i=0;i<ins.length;i++)
			{
				if(ins[i].checked==true) 
				{
					//vals[j]=ins[i].value;
					//j++;
					vals="with";
				}
			}
			document.form.job_order.value=(vals);
		}
		function leadsNavigation(direction)
		{
			var selObj = document.getElementById("leads");
			current_index = selObj.selectedIndex;
			if(direction!="direct")
			{
				if(direction == "back"){
					if(current_index >0)
					{
						current_index = current_index-1;
					}
					else
					{
						current_index =0 ;
					}	
				}
				if(direction == "forward")
				{
					current_index = current_index+1;
				}
				value = selObj.options[current_index].value;
			}
			else
			{
				value = selObj.value;
			}
			location.href = "<?php=basename($_SERVER['SCRIPT_FILENAME']);?>?id="+value;
		}
		//ENDED: other 

		
		//START: validate
		function checkFields()
		{
			
			var fill = jQuery("input[name=fill]").val();
			if (fill=="EMAIL"){
				var cc = jQuery("input[name=cc]").val();
				var bcc = jQuery("input[name=bcc]").val();
				var i;
				//check cc email format
				var ccs = cc.split(",");
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				for(i=0;i<ccs.length;i++){
					if(!filter.test(jQuery.trim(ccs[i]))){
						if (jQuery.trim(ccs[i])!=""){
							alert("One of the email used in cc is invalid. Please try again.");
							return false;
						}
					}
				}
				var bccs = bcc.split(",");
				//console.log(bccs);
				for(i=0;i<bccs.length;i++){
					if(!filter.test(jQuery.trim(bccs[i]))){
						if (jQuery.trim(bccs[i])!=""){
							alert("One of the email used in bcc is invalid. Please try again.");
							return false;
						}
					}
				}
				
			}
			
			
			if(document.form.star.selectedIndex==0)
			{
				missinginfo = "";
				if(document.form.txt.value=="")
				{
					missinginfo += "\n     -  There is no message or details to be save or send \t \n Please enter details.";
				}
				if (document.form.mode.value =="")
				{
					if (document.form.fill.value=="" )
					{
						missinginfo += "\n     -  Please choose actions.";
					}
					if (document.form.fill.value=="EMAIL" )
					{
						if (document.form.subject.value=="" )
						{
							missinginfo += "\n     -  Please enter a subject in your Email.";
						}
						if (document.form.templates[0].checked==false && document.form.templates[1].checked==false && document.form.templates[2].checked==false)
						{
							missinginfo += "\n     -  Please choose email templates.";
						}
					}
				}	
				//if (missinginfo != "")
				//{
					//missinginfo =" " + "You failed to correctly fill in the required information:\n" +
					//missinginfo + "\n\n";
					//alert(missinginfo);
					//return false;
				//}
				//else return true;
			}
		}
		//ENDED: validate

		
		//START: staff_recruiter stamp update
		var staff_recruiter_stamp_update_obj = makeObject();
		function staff_recruiter_stamp_update(userid,admin_id)
		{
			
			
			if(admin_id == "")
			{
				alert("Please select the recruiter.");
			}
			
			else
			{
			
			
				var name = jQuery("#staff_recruiter_stamp option:selected").text();
				jQuery.get("/portal/recruiter/check_priviledge_on_assigning_staff.php?userid="+userid, function(data){
					data = jQuery.parseJSON(data);
					if (data.success){
						var answer = confirm("Do you want this candidate to reassign recruiter to "+name)
						if (answer){
							jQuery.get("/portal/recruiter/"+'staff_recruiter_update.php?userid='+userid+'&admin_id='+admin_id, function(data){
								var data = jQuery.parseJSON(data);
								if (data.success){
									selectedRecruiter = jQuery("#staff_recruiter_stamp option:selected").val();
									alert("Recruiter has been assigned.");	
								}else{
									alert(data.error);
									jQuery("#staff_recruiter_stamp").val(selectedRecruiter);
								}
												
							});
						}else{
							jQuery("#staff_recruiter_stamp").val(selectedRecruiter);
						}
					}else{
						alert(data.error);
						jQuery("#staff_recruiter_stamp").val(selectedRecruiter);
					}
					sync_to_v2();
				});
				
			}
		}
		//ENDED: staff recruiter stamp update


		//START: staff rate
		var staff_rate_obj = makeObject();
		function update_staff_rate(userid)
		{
			pull_time_rate_var = jQuery("#pull_time_rate_id").val();
			part_time_rate_var = jQuery("#part_time_rate_id").val();
			jQuery.get("staff_rate_update.php?pull_time_rate="+pull_time_rate_var+'&part_time_rate='+part_time_rate_var+'&userid='+userid, function(data){
				alert("Changes has been saved");
				sync_to_v2();
			});
		}
		//ENDED: staff rate


		//START: menu and page redirection
		
		/* function resume_checker(path) 
		{
			window.open("../"+path,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		} */
		function asl_checker(path) 
		{
			window.open("../"+path,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		function popup_calendar(id) 
		{
			previewPath = "../application_calendar/popup_calendar.php?id="+id;
			window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		function admin_edit(userid,p)
		{
			previewPath = "../"+p+"?userid="+userid;
			window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		function bank_accounts(userid)
		{
			previewPath = "../admin_bank_account_details.php?userid="+userid;
			window.open(previewPath,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		function clear_transaction_result()
		{
			document.getElementById('trans_result').innerHTML="";
		}
		function leadsNavigation(direction)
		{
			var selObj = document.getElementById("leads");
			current_index = selObj.selectedIndex;
			if(direction!="direct")
			{
				if(direction == "back")
				{
					if(current_index >0)
					{
						current_index = current_index-1;
					}
					else
					{
						current_index =0 ;
					}	
				}
				if(direction == "forward")
				{
					current_index = current_index+1;
				}
				value = selObj.options[current_index].value;
			}
			else
			{
				value = selObj.value;
			}
			location.href = "<?=basename($_SERVER['SCRIPT_FILENAME']);?>?userid="+value;
		}
		function move(id, status) 
		{
			switch(status)
			{
				case "Category":
					previewPath = "asl_categories.php?userid="+id;
					break;	
				case "Shortlist":
					previewPath = "shortlist_staff.php?userid="+id;
					break;						
				case "Become a Staff":
					previewPath = "/portal/django/subcontractors/create/"+id;
					break;
				case "Edit":
					previewPath = "../move_edit.php?userid="+id;
					break;
				case "Endorse to Client":
					previewPath = "../../admin-endorse-to-client.php?userid="+id;
					break;
			}	
			window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
		function send_sample(id) 
		{
			previewPath = "send_sample_work_to_client.php?userid="+id;
			window.open(previewPath,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}		
		//ENDED: menu and page redirection	


		//START: star rating
		var star_rating_obj = makeObject()
		function change_rating_update(id, rating) 
		{
			star_rating_obj.open('get', '../application_apply_action_change_rating.php?rating='+rating+'&userid='+id)
			star_rating_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			star_rating_obj.onreadystatechange = star_rating_loader 
			star_rating_obj.send(1)
		}	
		function star_rating_loader()
		{
			var data;
			data = star_rating_obj.responseText
			if(star_rating_obj.readyState == 4)
			{
				document.getElementById('star_rating_loader').innerHTML = data;
			}
			else
			{
				document.getElementById("star_rating_loader").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
		}		
		//ENDED: star rating
		
		
		//START: asl interview
		var asl_interview_counter_obj = makeObject()
		var asl_status_update_obj = makeObject()
		function asl_interview_counter(userid) 
		{
			asl_interview_counter_obj.open('get', 'staff_asl_interview_counter_report.php?userid='+userid)
			asl_interview_counter_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			asl_interview_counter_obj.onreadystatechange = asl_interview_counter_loader 
			asl_interview_counter_obj.send(1)
		}	
		function asl_interview_counter_loader()
		{
			var data;
			data = asl_interview_counter_obj.responseText
			if(asl_interview_counter_obj.readyState == 4)
			{
				document.getElementById('reporting_div').innerHTML = data;
			}
			else
			{
				document.getElementById("reporting_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
		}		
		function asl_interview_counter_exit()
		{
			document.getElementById("reporting_div").innerHTML="";
		}
		function asl_status_update(id, rating) 
		{
			asl_status_update_obj.open('get', 'staff_asl_status.php?rating='+rating+'&userid='+id)
			asl_status_update_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			asl_status_update_obj.send(1)
			alert("Changes has been applied.");
		}	
		function update_asl_visiblity(id, rating) 
		{
			asl_status_update_obj.open('get', '../change_top10.php?rating='+rating+'&userid='+id)
			asl_status_update_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			asl_status_update_obj.send(1)
			alert("Changes has been applied.");
		}		
		//ENDED: asl interview
		
		
		//START: staff files
		var staff_files_obj = makeObject()
		function staff_files_counter(userid,type) 
		{
			staff_files_obj.open('get', 'staff_files_uploaded.php?type='+type+'&userid='+userid) 
			staff_files_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			staff_files_obj.onreadystatechange = staff_files_counter_loader 
			staff_files_obj.send(1)
		}	
		function staff_files_counter_loader()
		{
			var data;
			data = staff_files_obj.responseText
			if(staff_files_obj.readyState == 4)
			{
				document.getElementById('staff_files_reporting_div').innerHTML = data;
			}
			else
			{
				document.getElementById("staff_files_reporting_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
		}		
		function staff_files_counter_exit()
		{
			document.getElementById("staff_files_reporting_div").innerHTML="";
		}
		//ENDED: staff files		

		
		//START: applicant status
		

			//start: update
			var app_status_obj = makeObject()
			function app_status_update(userid,admin_id,status)
			{
				app_status_obj.open('get', 'staff_information_status.php?admin_id='+admin_id+'&userid='+userid+'&status='+status)
				app_status_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				app_status_obj.onreadystatechange = app_status_loader 
				app_status_obj.send(1)
			}		
			function app_status_loader()
			{
				var data;
				data = app_status_obj.responseText
				if(app_status_obj.readyState == 4)
				{
					document.getElementById('app_status_loader').innerHTML = data;
				}
				else
				{
					document.getElementById("app_status_loader").innerHTML="<img src='../images/ajax-loader.gif' width=20>";
				}
			}
			//ended: update
			
			//start: reporting
			var app_status_report_obj = makeObject()
			function staff_information_status_report(userid) 
			{
				app_status_report_obj.open('get', 'staff_information_status_report.php?userid='+userid)
				app_status_report_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				app_status_report_obj.onreadystatechange = staff_information_status_report_loader 
				app_status_report_obj.send(1)
			}	
			function staff_information_status_report_loader()
			{
				var data;
				data = app_status_report_obj.responseText
				if(app_status_report_obj.readyState == 4)
				{
					document.getElementById('reporting_div').innerHTML = data;
				}
				else
				{
					document.getElementById("reporting_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}		
			function staff_information_status_report_exit()
			{
				document.getElementById("reporting_div").innerHTML="";
			}				
			//ended: reporting
		
		//ENDED: applicant status
		
		
		//START: no show
		
			//start: no show report
			var no_show_obj = makeObject()
			function staff_no_show_report(userid) 
			{
				no_show_obj.open('get', 'staff_no_show_report.php?userid='+userid)
				no_show_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				no_show_obj.onreadystatechange = staff_no_show_report_loader 
				no_show_obj.send(1)
			}	
			function staff_no_show_report_loader()
			{
				var data;
				data = no_show_obj.responseText
				if(no_show_obj.readyState == 4)
				{
					document.getElementById('reporting_div').innerHTML = data;
				}
				else
				{
					document.getElementById("reporting_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}		
			function staff_no_show_report_exit()
			{
				document.getElementById("reporting_div").innerHTML="";
			}				
			//ended: no show report
			
			//start: no show update
			var no_show_update_obj = makeObject()
			function staff_no_show_update(userid,admin_id)
			{
				var staff_no_show_service_type = document.getElementById("staff_no_show_service_type").value;
				if(staff_no_show_service_type == "")
				{
					alert("Please select the service type.");
				}
				else
				{
					no_show_update_obj.open('get', 'no_show_status.php?admin_id='+admin_id+'&userid='+userid+'&service_type='+staff_no_show_service_type)
					no_show_update_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
					no_show_update_obj.onreadystatechange = staff_no_show_update_loader 
					no_show_update_obj.send(1)
				}
			}		
			function staff_no_show_update_loader()
			{
				var data;
				data = no_show_update_obj.responseText
				if(no_show_update_obj.readyState == 4)
				{
					document.getElementById('no_show_status_loader').innerHTML = data;
				}
				else
				{
					document.getElementById("no_show_status_loader").innerHTML="<img src='../images/ajax-loader.gif' width=20>";
				}
			}
			//ended: no show update	
			
		//ENDED: no show
		
		
		//START: staff resume up to date
		
			//start: staff resume up to date report
			var staff_resume_up_to_date_obj = makeObject()
			function staff_resume_up_to_date_report(userid) 
			{
				staff_resume_up_to_date_obj.open('get', 'staff_resume_up_to_date_report.php?userid='+userid)
				staff_resume_up_to_date_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				staff_resume_up_to_date_obj.onreadystatechange = staff_resume_up_to_date_loader 
				staff_resume_up_to_date_obj.send(1)
			}	
			function staff_resume_up_to_date_loader()
			{
				var data;
				data = staff_resume_up_to_date_obj.responseText
				if(staff_resume_up_to_date_obj.readyState == 4)
				{
					document.getElementById('reporting_div').innerHTML = data;
				}
				else
				{
					document.getElementById("reporting_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}		
			function staff_resume_up_to_date_exit()
			{
				document.getElementById("reporting_div").innerHTML="";
			}				
			//ended: staff resume up to date report
			
			//start: staff resume up to date update
			var staff_resume_up_to_date_update_obj = makeObject()
			function staff_resume_up_to_date_update(userid,admin_id)
			{
				staff_resume_up_to_date_update_obj.open('get', 'staff_resume_up_to_date_status.php?admin_id='+admin_id+'&userid='+userid)
				staff_resume_up_to_date_update_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				staff_resume_up_to_date_update_obj.onreadystatechange = staff_resume_up_to_date_update_loader 
				staff_resume_up_to_date_update_obj.send(1)
			}		
			function staff_resume_up_to_date_update_loader()
			{
				var data;
				data = staff_resume_up_to_date_update_obj.responseText
				if(staff_resume_up_to_date_update_obj.readyState == 4)
				{
					document.getElementById('staff_resume_up_to_date_status_loader').innerHTML = data;
				}
				else
				{
					document.getElementById("staff_resume_up_to_date_status_loader").innerHTML="<img src='../images/ajax-loader.gif' width=20>";
				}
			}
			//ended: staff resume up to date update	
			
		//ENDED: staff resume up to date	
		
		
		
		
		//START: move or update staff status
		var update_status_obj = makeObject()
		function update_status(userid, status, other) 
		{
			if (status=="PRESCREENED"){
				jQuery.get("/portal/recruiter/staff_information_status_update.php?other="+other+'&status='+status+'&userid='+userid, function(data){
					data = jQuery.parseJSON(data);
					if (data.success){
						alert("Staff ID "+userid+" has been sucessfully added to "+status+" listings");
					}else{
						alert(data.error);
					}
					sync_to_v2();
				});
				
			}else{
				update_status_obj.open('get', 'staff_information_status_update.php?other='+other+'&status='+status+'&userid='+userid)
				update_status_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				update_status_obj.send(1)
				alert("Staff ID "+userid+" has been sucessfully added to "+status+" listings");
				if(status == "INACTIVE")
				{
					inactive_staff_option_exit();
					update_inactive_current_status(userid, other);
				}	
			}
			
			
		}	
		//ENDED: move or update staff status
		
		//START: get Email Template
		
		function getEmailTemplate(str){
			var staffName = $("#staff-name").val();
			var email = $("input[name=email]").val();
			
			if (str=="Interview Confirmation (phone only)"){
				jQuery("input[name=subject]").val("")
				var interviewConfirm = "<p style='margin-bottom:1em'>Hi "+staffName+"!</p>";
				interviewConfirm += "<p style='margin-bottom:1em'>It's good to chat with you today.</p>";
				interviewConfirm+="<p style='margin-bottom:1em'>I'm sending you this email to confirm your interview this _____________ at __________ as per our conversation  __________.</p>";
				interviewConfirm+="<p style='margin-bottom:1em'>I have noticed that your resume is not complete. For the interview to be seamless and quick and for us to easily evaluate whether you are qualified or not, please update your resume by following quick and simple steps below. </p>";
				interviewConfirm+="<ul>";
				interviewConfirm+="<li style='margin-bottom:1em'>Log in as a JobSeeker at <a href='https://remotestaff.com.au/portal/'>https://remotestaff.com.au/portal/</a> using "+email+". If you are unsure about your password, get it here <a href='https://remotestaff.com.au/portal/forgotpass.php?user=applicant.'>https://remotestaff.com.au/portal/forgotpass.php?user=applicant.</a></li>";
				interviewConfirm+="<li style='margin-bottom:1em'>Once logged in, under the Control Panel Box on the left hand side of the page, Click on the resume areas you want to update. Update your resume add as much details as you know. </li>";
				interviewConfirm+="<li style='margin-bottom:1em'>Ensure that you have a voice recording uploaded. If you don't have any voice recording attached yet, it is VERY important to upload a voice recording as applicants with voice recording gets hired sooner than those who don't. The voice recording identifies your spoken English skills which is very important as the Clients looking for staff are from the US, UK and Australia.  The voice recording should be minimum 30 seconds and maximum 120 seconds in length. Indicate your first name and a quick summary of work background. </li>";
				interviewConfirm+="</ul>";
				interviewConfirm+="<p style='margin-bottom:1em'>To know more about Remote Staff, take time to watch this 7 Minute video presentation created to help you know more about the company you are applying for.</p>";
				interviewConfirm+="<p style='margin-bottom:1em'><strong style='color:red'>Note: </strong>Kindly add me on Skype at least 10 minutes prior to the interview and please make sure you have a <u>working headset</u> ready for the interview. My Skype ID is _________. Should you need to cancel this interview for whatever reason, please reply back to this email or text "+". Indicate your Full Name and Interview schedule time. </p>";
				interviewConfirm+="<p style='margin-bottom:1em'>Should you have any questions, feel free to contact me through my contact details below.</p>";
				
				return interviewConfirm;
			}else if (str=="After Passing Initial Interview"){
				jQuery("input[name=subject]").val("")
				var passing = "<p style='margin-bottom:1em'>Hi "+staffName+"!</p>";
				passing+="<p style='margin-bottom:1em'>Thank you for your time in attending the initial interview. It's good to chat with you.</p>";
				passing+="<p style='margin-bottom:1em'>This is to let you know that you are qualified to be a Remote Staff Sub Contractor! </p>";
				passing+="<p style='margin-bottom:1em'><strong>What's Next?</strong></p>";
				passing+="<ol>";
				passing+="<li style='margin-bottom:1em'>We will show and present your online resume to our Clients who currently are looking for staff members matching your skill sets and background. The Client will either hire you based on your online resume/evaluation or request final interview.</li>";
				passing+="<li style='margin-bottom:1em'>We will showcase and display your online resume on our websites and actively market you to Clients looking to hire a Remote Staff from the Philippines. The Client, upon viewing your online resume will request for an interview and decide on whether to hire you or not.</li>";
				passing+="</ol>"
				passing+="<p style='margin-bottom:1em'>We will update you with your scheduled Client interview/s, via your phone number and email. Keep your communication line open so as not to miss scheduled interviews !</p>";
				passing+="<p style='margin-bottom:1em'><strong>Important Points To Know: </strong></p>";
				passing+="<p style='margin-bottom:1em'>As indicated on the interview: </p>";
				passing+="<ul>";
				passing+="<li style='margin-bottom:1em'>Internet connection bills, electricity and other associated costs to maintain your Home office is your responsibility unless otherwise specified in the contract.</li>"
				passing+="<li style='margin-bottom:1em'>We follow a fix work-schedule. We do not allow working on a flexi-time. There is a specific work start and work finish time. </li>"
				passing+="<li style='margin-bottom:1em'>A monitoring system will be installed in your computer. This monitoring application is only active during working hour and can be deactivated by you after work or if and when necessary. This monitoring system is in place to promote transparency and trust between Staff and Client which will result to a longer lasting work relationship.</li>"
				passing+="<li style='margin-bottom:1em'>We require all our subcontractors to be on <strong>WIRED INTERNET</strong> connection of at least 1.0 Mbps on download and 0.35 Mbps upload speed.</li>"
				passing+="<li style='margin-bottom:1em'>Your contract with Remote Staff is will be an Independent Contractor agreement not Employment agreement.  This means that Remote Staff is <strong><u>not responsible</u></strong> in collecting your SSS and Taxes. We will <strong>NOT DEDUCT</strong>  anything on your monthly pay. Statutory Benefits or benefits mandated by law are also not applicable. To read and review our full contract agreement HERE.</li>"			
				passing+="</ul>";
				passing+="<p style='margin-bottom:1em'><strong>Timeline : When Do You Get Hired ?</strong></p>";
				passing+="<p style='margin-bottom:1em'>How quickly you will get hired depends mostly on your skill sets, the role you are applying for, competition with other applicants and how your resume is written.</p>";
				passing+="<p style='margin-bottom:1em'>Some applicants get hired within 1 week after receiving this letter (Mostly IT Staff). For others, whose desired role is more saturated (telemarketer, Virtual Assistant, Data Entry, Customer Service etc.) it will take about 2 to 6 weeks before they get invited to an interview. </p>";
				passing+="<p style='margin-bottom:1em'>Remote Staff will spend resources to get you hired. On your end, please keep your communication line open for us to contact you when interviews are requested. Failure to respond to interview requests will automatically remove you off the list as we will assume you are not interested anymore. We will attempt Email and Phone contact. </p>";
				passing+="<p style='margin-bottom:1em'>Every 2 weeks, a Remote Staff representative will give you a call to double check that you're still available and interested. Should you get a job somewhere else within this timeline please let us know my emailing <a href='mailto:recruitment@remotestaff.com.au'>recruitment@remotestaff.com.au</a> so we can remove you off our list."
				passing+="<p style='margin-bottom:1em'>I hope everything is now clear at this point. Should you have any questions, please done hesitate to contact me on my details below.</p>";
				return passing;
			}else if (str=="Upload Photo"){
				jQuery("input[name=subject]").val("")
				var message = "<p style='margin-bottom:1em'>Hi "+staffName+",</p>";
				message+="<p style='margin-bottom:1em'>I was about to endorse you to one of our clients for a possibility of a job but noted that you don't have a picture on your resume. </p>";
				message+="<p style='margin-bottom:1em'>Please upload an ID picture or any picture that presents a professional image of you by following the 3 simple steps below. </p>";
				message+="<ol>";
				message+="<li style='margin-bottom:1em'>Log in as a JobSeeker at <a href='https://remotestaff.com.au/portal/'>https://remotestaff.com.au/portal/</a> using  "+email+". If you are unsure about your password, get it here <a href='https://remotestaff.com.au/portal/forgotpass.php?user=applicant'>https://remotestaff.com.au/portal/forgotpass.php?user=applicant</a> .</li>";
				message+="<li style='margin-bottom:1em'>Once logged in, on the Home Page please click on Upload Picture. </li>";
				message+="<li style='margin-bottom:1em'>Upload your picture.</li>";
				message+="</ol>";
				message+="<p style='margin-bottom:1em'>Note that how you look will not be a factor in deciding whether to hire you or not but it is very important for the Client to at least \"picture\" how you look during the interview.</p>";
				message+="<p style='margin-bottom:1em'>For any questions, please do not hesitate to contact me. </p>"
				
				return message;
			}else if (str=="2 Weeks Follow Up Availability"){
				jQuery("input[name=subject]").val("")
				var message = "<p style='margin-bottom:1em'>Hi "+staffName+",</p>";
				message+="<p style='margin-bottom:1em'>It's been 2 weeks since we last spoke. </p>";
				message+="<p style='margin-bottom:1em'>I am just writing to confirm your availability. I want to know if you are still looking for a job and still interested to join Remote Staff to  have a longer lasting work from home job.</p>";
				message+="<p style='margin-bottom:1em'>At this moment, we still don't have a client who has staffing needs fitting your skill sets and preferred role. However, knowing your background and skill sets we are confident that we will find a client for you to work with SOON.</p>";
				message+="<p style='margin-bottom:1em'>Please let me know of your availability by responding to this email with your current work set up so I can either retain or remove you from our Available Staff List. If I don't get a respond within 5 days from the date of this email I will assume that you are no longer interested and remove your off our list.</p>";
				message+="<p style='margin-bottom:1em'>Hope to hear from you soon. </p>";
				return message;
			}else if (str=="Upload Voice Recording and Portfolio"){
				jQuery("input[name=subject]").val("")
				var message = "<p style='margin-bottom:1em'>Hi "+staffName+",</p>";
				message+="<p style='margin-bottom:1em'>To further evaluate your application and make a decision please upload your Voice Recording and Sample Work / Portfolio by following simple steps below.</p>"
				message+="<ol>";
				message+="<li style='margin-bottom:1em'>Log in as a JobSeeker at <a href='https://remotestaff.com.au/portal/'>https://remotestaff.com.au/portal/</a> using  "+email+". If you are unsure about your password, get it here <a href='https://remotestaff.com.au/portal/forgotpass.php?user=applicant'>https://remotestaff.com.au/portal/forgotpass.php?user=applicant</a> .</li>";
				message+="<li style='margin-bottom:1em'>Once logged in, under the Control Panel Box on the left hand side of the page, Click on Attached Voice Recording, Sample Work and Detailed Resume.</li>";
				message+="<li style='margin-bottom:1em'>Upload your readily available Voice recording  and Sample Work or Portfolio. </li>";
				message+="</ol>";
				message+="<p style='margin-bottom:1em'>Note that if you don't have any voice recording attached yet, it is VERY important to upload a voice recording as applicants with voice recording gets hired sooner than those who don't. The voice recording identifies your spoken English skills which is very important as the Clients looking for staff are from the US, UK and Australia.  The voice recording should be minimum 30 seconds and maximum 120 seconds in length. Indicate your first name and a quick summary of work background.</p>";
				message+="<p style='margin-bottom:1em'>Presenting a sample work is also very important in getting you hired as the client will be able to see your sample work and easily evaluate whether you are qualified for the position you are applying for or not.</p>";
				message+="<p style='margin-bottom:1em'>Let me know if you have any questions. </p>";
				return message;
			}else if (str=="Complete your Resume"){
				jQuery("input[name=subject]").val("")
				var message = "<p style='margin-bottom:1em'>Hi "+staffName+", </p>";
				message+="<p style='margin-bottom:1em'>You have recently registered as a Jobseeker at www.remotestaff.com.au / www.remotestaff.com.ph.</p>";
				message+="<p style='margin-bottom:1em'>Thank you for showing interest in our company and for supplying us information on your profile.</p>";
				message+="<p style='margin-bottom:1em'>I have noted that you missed:</p><br/><br/><br/><br/><br/><br/>";
				message+="<p style='margin-bottom:1em'>In order to process your application, please follow 3 simple steps below: </p>";
				message+="<ol>";
				message+="<li style='margin-bottom:1em'>Log in as a JobSeeker at <a href='https://remotestaff.com.au/portal/'>https://remotestaff.com.au/portal/</a> using  "+email+". If you are unsure about your password, get it here <a href='https://remotestaff.com.au/portal/forgotpass.php?user=applicant'>https://remotestaff.com.au/portal/forgotpass.php?user=applicant</a> .</li>";
				message+="<li style='margin-bottom:1em'>Once logged in, under the Control Panel Box on the left hand side of the page, Click on the resume areas you want to update. Update your resume add as much details as you know.</li>";
				message+="<li style='margin-bottom:1em'>Ensure that you have a voice recording uploaded. If you don't have any voice recording attached yet, it is VERY important to upload a voice recording as applicants with voice recording gets hired sooner than those who don't. The voice recording identifies your spoken English skills which is very important as the Clients looking for staff are from the US, UK and Australia.  The voice recording should be minimum 30 seconds and maximum 120 seconds in length. Indicate your first name and a quick summary of work background. </li>";
				message+="</ol>";
				message+="<p style='margin-bottom:1em'>Focus on completing your online profile/resume. Candidates whose profiles are 100% complete are more likely to get an initial interview than those with only partially completed profiles. </p>";
				message+="<p style='margin-bottom:1em'>To fully understand what Remote Staff is and how we can help you start a rewarding professional work from home job, we invite you to watch our short video presentation <a href='http://www.remotestaff.com.ph/presentations3.php' target='_blank'>HERE</a>.</p>";
				message+="<p style='margin-bottom:1em'>Should you encounter any problem all throughout the registration and application process, I am here to help, just send me an email. </p>";
				message+="<p style='margin-bottom:1em'>PS: LIKE us on Facebook, by clicking the link <a href='https://www.facebook.com/RemoteStaffPhilippines'>https://www.facebook.com/RemoteStaffPhilippines</a> to know about the latest job openings, updates and thousands of Filipino jobseekers who LIKED us!</p>";
				message+="<p style='margin-bottom:1em'>Follow us on TWITTER at <a href='https://twitter.com/remotestaff_pty'>https://twitter.com/remotestaff_pty</a>. By doing so, you are also helping us spread the word about the opportunities and job openings to your friends, family and networks!</p>";
				return message
			}else if (str=="Frequently Asked Questions"){
				jQuery("input[name=subject]").val("")
				var message = "<p style='text-align:center;border:none;color:#000;margin-bottom:1em;font-weight:bold;font-size:18px'>Independent Contractor Agreement Between<br/> Remote Staff and You:  Frequently Asked Questions</p>";
				message+="<p style='margin-bottom:1em'>To View the entirety if the Agreement please go <a href='https://remotestaff.com.au/portal/contract_image/INDEPENDENT_CONTRACTOR_AGREEMENT.pdf'>HERE</a>. Below is a summary of the frequently asked questions regarding the Independent Contractor Agreement. </p>";
				message+="<p style='margin-bottom:1em'><strong><i><u>How long is the duration of the contract ?</u></i></strong></p>";
				message+="<ul><li style='margin-bottom:1em'>The contract is for 1 year. It will be renewed depending on your performance on the anniversary of the contract.</li></ul>";
				message+="<p style='margin-bottom:1em'><strong><i><u>What about SSS, PhilHealth, Pag Ibig  and Tax deductions ?</u></i></strong></p>";
				message+="<ul style='margin-bottom:1em'><li>Your contract with Remote Staff is Independent Contractor in nature. Remote Staff will not collect your SSS, Philhealth, Withholding taxes and Pag Ibig Contributions.</li></ul>";
				message+="<p style='margin-bottom:1em'><strong><i><u> Do you provide any benefits?</u></i></strong></p>";
				message+="<ul><li style='margin-bottom:1em'>Because life is about living, working with Remote Staff provides Real Life Benefits. The benefit of working with Remote Staff is the great lifestyle you can develop while working from home.";
					message+="<ul>";
						message+="<li style='margin-bottom:1em'>You can work anywhere as long as you have a good internet connection and computer. Meaning, you don't need to migrate and live in polluted city centers (Metro Manila) to have and maintain a job</li>";
						message+="<li style='margin-bottom:1em'>Your preparation time to \"get to work\" is less than 30 minutes. Hence, no need to wake up too early.</li>";
						message+="<li style='margin-bottom:1em'>You will not spend time in traffic commuting to and from work. That is averaged 2 hours saved time daily.</li>";
						message+="<li style='margin-bottom:1em'>You will not need to buy \"office clothes/attires\"</li>";
						message+="<li style='margin-bottom:1em'>You will not need to spend money on \"lunches\" and \"coffees\"</li>";
						message+="<li style='margin-bottom:1em'>You will have spare time to spend learning new things and skills</li>";
						message+="<li style='margin-bottom:1em'>You will have more time to spend with your family or yourself</li>";
						message+="<li style='margin-bottom:1em'>Due to more time for yourself and other endeavor, you will be more relaxed, less stressed and healthy</li>";
					message+="</ul>";
				message+="</li></ul>";
				message+="<p style='margin-bottom:1em'><strong><i><u>When do I get a penalty amounting to 50,000 Pesos ?</u></i></strong></p>";
				message+="<p style='margin-bottom:1em'>There are 3 cases where you can get penalized 50,000 Pesos. All cases are preventable depending on your professionalism as an Independent Contractor.</p>";
				message+="<ul>";
					message+="<li style='margin-bottom:1em'>The 50, 000 Pesos penalty will apply to that Independent Contractor who resigns without the agreed on 15 days notice. This can be avoided by giving us 15 days notice before your resignation date.</li>";
					message+="<li style='margin-bottom:1em'>The 50, 000 Pesos penalty will apply to anyone who directly contacts our Clients with the intention to work with them directly without Remote Staff's involvement. This is considered breach of contract as you are in a way \"trying to steal\" our Clients. No Contractor has successfully done this despite attempts as our Clients come back to us to report attempts as they obviously will NOT TRUST anyone who openly breeches a contract.</li>";
					message+="<li style='margin-bottom:1em'>The 50,000 Pesos Penalty will apply to those Independent Contractor who is absent without notice for two consecutive days. This can be avoided by notifying us of your situation, filing a leave request or informing us via text, email or calls regarding your attendance/absence. We have a dedicated team managing all our Contractors attendance notices. </li>";
				message+="</ul>";
				message+="<p style='margin-bottom:1em'><strong><i><u>Do you give annual appraisal to your contractors ?</u></i></strong></p>";
				message+="<ul><li style='margin-bottom:1em'>The Client you are working with has the option to give an annual or 6<sup>th</sup> monthly increase depending on how good your performance is and attendance. So this is dependent on you.</li></ul>"
				message+="<p style='margin-bottom:1em'><strong><i><u>What if I want to continue my PhilHealth, Pag-ibig and SSS ?</u></i></strong></p>";
				message+="<ul><li style='margin-bottom:1em'>You may do voluntary contribution to the above agencies.</li></ul>";
				message+="<p style='margin-bottom:1em'><strong><i><u>What will happen if Client terminates my contract?</u></i></strong></p>";
				message+="<ul><li style='margin-bottom:1em'>If good feedback is received from your previous Client, we will transfer you to another Client.</li></ul>"
				message+="<p style='margin-bottom:1em'><strong><i><u>Do we have holidays and other paid leaves?</u></i></strong></p>";
				message+="<ul>";
					message+="<li style='margin-bottom:1em'>You will follow the official non-working holidays of the country and state of the Client you are working with. (Eg. Thanksgiving for Us Clients, Melbourne Cup Day for Australian Clients etc.)</li>";
					message+="<li style='margin-bottom:1em'>You have the option to file a leave if you want to participate on Philippines non working holidays. We inform our Clients on Philippine Holidays Filipinos observe and most have no problem with this. (Eg. Christmas,  Nov 1 and 2, Easter Holidays etc.)</li>";
					message+="<li style='margin-bottom:1em'>You are only paid for the hours you work so Paid leaves are upon Client's discretion.</li>";
				message+="</ul>";			
				message+="<p style='margin-bottom:1em'><strong><i><u>Do you pay overtime work?</u></i></strong></p>";
				message+="<ul><li style='margin-bottom:1em'>Yes. If overtime work is necessary and approved by your Client, you will get all the hourly payments due to you.</li></ul>";
					
				return message;
			}else if (str=="Invitation to Register from Outside Database"){
				jQuery("input[name=subject]").val("")
				var message = "<p style='margin-bottom:1em'>Hi "+staffName+", </p>";
				message+="<p style='margin-bottom:1em'>Thank you for the interest you've shown to be part of <a href='http://www.remotestaff.com.ph'>www.RemoteStaff.com.ph</a>  you've applied for the &lt;POSITION&gt; at &lt;Website&gt; Last &lt;Date of Application&gt;.</p>";
				message+="<p style='margin-bottom:1em'>You are 4 short steps away from starting a rewarding Work From Home job for our US, UK or Australian clients like our <a href='http://www.remotestaff.com.au/staff_currently_working.php'>400 + staff members</a>. Follow steps below to start working from home now! The whole process will not take more than 30 minutes. </p>";
				message+="<ol style='margin-bottom:1em'>";
					message+="<li style='margin-bottom:1'><strong>Ensure that you have a readily available Home Office Set Up</strong>";
						message+="<p style='margin-bottom:1em'>You should have the following:</p>";
						message+="<ul style='margin-bottom:1em'>";
							message+="<li style='margin-bottom:1em'>WIRED Internet connection ***  (Or Possible access to one if around Metro Manila)";
							message+=("<p><em>*** Meaning the Internet supply comes from \"wires\" like phone lines or cable lines and not from transmitters such as the USB-HSDPA , Canopy-Antenna installed on roofs and 3G enabled phones.</em></p>");
							message+="</li>";
							message+="<li style='margin-bottom:1em'>Working computer whether Desktop or Laptop.";
							message+="<li style='margin-bottom:1em'>For Windows, at least on XP operating system.  For Mac will consider anyone who are on Leopard, Snow Leopard and Lion operating system. Anything below these OS will <u>not be considered</u> as you cannot work from home properly with lower and old OS versions. ";
							message+="<li style='margin-bottom:1em'>Working headset. Or willingness to invest in one. ";
							message+="<li style='margin-bottom:1em'>Access to a private and quiet room";
						message+="</ul>";
					message+="</li>";
					message+="<li style='margin-bottom:1em'><strong>Register at <a href='http://www.remotestaff.com.ph'>www.remotestaff.com.ph</a></strong>" +
							"<ul>" +
								"<li style='margin-bottom:1em'>Register <a href='https://remotestaff.com.au/portal/application_form/registernow-step1-personal-details.php'>HERE</a> and complete the Job Seeker Form. This will serve as your online resume." +
									"<p style='margin-bottom:1em'><em>*** <strong>Fully completed resumes will be processed within 3 business days</strong> â the more we know about you the more we can identify if you are qualified to be hired  for a job.</em></p>" +
									"<p style='margin-bottom:1em'><strong>Incomplete resumes are next to useless and will be given 2nd priority or deleted depending on how much information we have.</strong></p>" +
									"<p style='margin-bottom:1em'><u>Note that investing time completing your resume will help you land the Work From Home job of your dreams sooner than later.</u></p>" +
								"</li>" +
							
								"<li style='margin-bottom:1em'>Ensure that the mobile number, landline number and email address you input on your profiles are correct and working as we will contact you via these details.</li>" +
								"<li style='margin-bottom:1em'>Make sure to upload a voice recording introducing yourself and quick work experience in English.</li>" +
								"<p style='margin-bottom:1em'><em>***You don't need to have a special accent to be considered for a job , all you need is a functional English skills to communicate to our clients from US, UK and Australia. The voice recording is a way to check how functional your spoken English is.</em></p>" +
							"</ul>" +
							"</li>";
					message+="<li style='margin-bottom:1em'><strong>Attend The Initial Interview</strong>" +
							"<p style='margin-bottom:1em'>Once your online resume is complete, one of our Recruiters will get in touch with you within 3 business days via phone call, SMS or email to schedule you for the initial interview. <strong>Keep your communication line open and check your email every day after registration.</strong></p>" +
							"</li>";
					message+="<li style='margin-bottom:1em'><strong>Client Recommendation, Final Interview and Hiring ! ! !</strong>" +
							"<p style='margin-bottom:1em'>After the initial interview, you will be informed on whether you are qualified or not. If qualified, the next step will be presentation of your resume, portfolio and evaluation notes to our clients from the US , UK and Australia looking for Home Based Filipino Staff. The Clients will either hire you on the spot on the basis of your resume /evaluation or request to interview you. </p>" +
							"</li>";
				message+="</ol>";
				//jQuery("input[name=subject]").val("Your Application for ");
				
				return message;
			}else if (str=="Take a Skills Test"){
				jQuery("input[name=subject]").val(str)
				var result = "";
				jQuery.ajax({
         			url:"/portal/application/get_skill_template.php?userid="+jQuery("input[name=userid]").val(),
         			success:function(response){
         				result = response
         			},
         			async:false
         		})
         		return result;
			}else if (str=="Remote Staff Reminders on Pay and RSSC"){
				jQuery("input[name=subject]").val(str)
				var csros = jQuery("input[name=csros]").val();
				var pronoun = "her";
				if (csros.split(",").length>=2||csros.split("and").length>=2){
					pronoun = "them"
				}
				var message =  "<p style='margin-bottom:1em'>Hi "+staffName+", </p>";
				message+="<p style='margin-bottom:1em'>Good Day!</p>";
				message+="<p style='margin-bottom:1em'>To ensure Remote Staff service quality and guarantee <b><i>your payments</i></b> every pay run, please ensure that all working hours are <b>logged into RSSC</b>. Please be reminded that offline (off RSSC)  work is <u>not allowed</u> regardless of what your Client say or what you might think about this matter. You cannot work off RSSC because RSSC logs are part of our Service Agreement with your Client. IF you don't log in, your client <b><i>CAN</i></b> question your work hours and <b><i>CAN CHOOSE</i></b> not to pay. We are requiring you to log in to RSSC to protect you and your interest. </p>";
				message+="<p style='margin-bottom:1em'>In case of minor internet drop where you need to work while internet is down, please contact your CSRO "+csros+" <b>right away</b> to inform "+pronoun+" within the same workday whether by email, call or text message. This way, we can ensure to connect to your Client regarding this and avoid your working hours being questioned.</p>"
				
				message+="<p style='margin-bottom:1em'>Please remember that Remote Staff is here to help both our Client and yourself have a longer lasting work relationship. We both have representation in the Philippines and Australia to make this happen for you. Saying this, you have to help us help you. There are rules and guidelines to be met in order for this to happen.</p>";
				message+="<p style='margin-bottom:1em'>Should you have any questions or suggestions, please do not hesitate to contact me. </p>";
							
				return message;
				
			}else if (str=="AWOL with Remote Staff"){
				jQuery("input[name=subject]").val(str)
				var message =  "<p style='margin-bottom:1em'>Dear "+staffName+", </p>";
				message += "<p style='margin-bottom:1em'>You haven't logged in for the past [number of days missing] days and we were not able to get in touch with you via mobile phone and email.</p>";
				message += "<p style='margin-bottom:1em'>Please know that your client has been looking for you and we are at lost as to where you are at. Also know that this is not an acceptable behavior. You agreed to work for our client and to be logged in during your agreed working hours as well as agreed to notify us in case of absences you cannot avoid.</p>";
				message += "<p style='margin-bottom:1em'>The promise to our client is to give them a dedicated and reliable Filipino staff. By being absent without notice, you are affecting the delivery of this promise not just to [Client Name]  but to other potential client wanting to hire Filipino professionals. We ask you to respect this and get in touch with me ASAP regarding your absences and how you want to move forward.</p>";
				message += "<p style='margin-bottom:1em'>Please note and be reminded of the section on the contract you have agreed and signed below. Note that we will not hesitate to exercise this if we're not able to hear from you by [Date to Respond].</p>";
				message += "<p style='margin-bottom:0em;margin-top:0.5em'><small><i>3.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In the event the Contractor is unavailable to log into the System and perform services for the Client for two (2) consecutive days without notice to Remote Staff, it shall be construed as a breach of the Contractor's duties and in such case is subject to the following:<ol type='a' style='margin-bottom:0em;margin-top:0'><li style='margin-bottom:0'>Penalty in the amount of &#x20B1;50,000 for monetary damages without prejudice to Remote Staff in filing a case against the Contractor in a competent court of law; and</li><li style='margin-bottom:1em'>Banning or black-listing of the Contractor wherein, announcement and notices shall be forwarded to different recruiting agencies including but not limited to JOBSDb, JobStreet, Newspaper, and especially to other remote work environment companies.</li></ol></i></small></p>";
				message += "<p style='margin-bottom:1em'>Please contact me on my contact details below. You have my email, My Skype, Our manila office number (02 8464249). </p>";
				message += "<p style='margin-bottom:1em'>A copy of this letter is also sent via registered post into your residential address. </p>";
				return message;
			}else if (str=="Merry Christmas Contractors"){
				jQuery("input[name=subject]").val(str)
				var result = "";
				jQuery.ajax({
         			url:"/portal/email_templates/subcontractors_christmas/",
         			success:function(response){
         				result = response
         			},
         			async:false
         		})
         		return result;
         	}else if (str=="New Pay Run Cycle"){
				jQuery("input[name=subject]").val(str)
				var result = "";
				jQuery.ajax({
         			url:"/portal/email_templates/new_pay_run_cycle_2014/?sending=yes",
         			success:function(response){
         				result = response
         			},
         			async:false
         		})
         		return result;
         		
			}else{
				return "";
			}
		}
		
		
		//START: reporting functions
		
			//start: other functions
			function inactive_staff_option_open()
			{
				document.getElementById("inactive_staff_loader").innerHTML = document.getElementById("inactive_staff_div").innerHTML;  
			}		
			function inactive_staff_option_exit()
			{
				document.getElementById("inactive_staff_loader").innerHTML="";
			}			
			//ended: other functions
			
			//start: communications history
			function go(id) 
			{
				document.form.fill.value=id;			
			}
			
			
			var checkInterval = 0;
			function showHide(actions)
			{
				jQuery("#message").html("");
				jQuery("#edit_notes_div").html("");
				clearInterval(checkInterval);
				if(actions=="EMAIL")
				{
					var emailTemplates = ["Blank Page", "Invitation to Register from Outside Database", "Interview Confirmation (phone only)", "After Passing Initial Interview", "2 Weeks Follow Up Availability", "Upload Voice Recording and Portfolio", "Upload Photo", "Complete your Resume", "Frequently Asked Questions", "Take a Skills Test", "Remote Staff Reminders on Pay and RSSC", "AWOL with Remote Staff", "Merry Christmas Contractors", "New Pay Run Cycle"]
					
					
					newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";
					newitem+="<tr><td>";
					var staff_email = "";
					jQuery(".staff_email_item").each(function(){
						staff_email = jQuery(this).val();
					});
					var alt_email = jQuery("input[name=alt_email]").val();
					var email = jQuery("input[name=email]").val();
					
					if (email==""){
						email = "<input type='checkbox' name='send_to[]' value='primary' disabled/>";
					}else{
						email = "<input type='checkbox' name='send_to[]' value='primary'/>";
					}
					
					
					if (alt_email==""){
						alt_email = "<input type='checkbox' name='send_to[]' value='alternative' disabled/>";
					}else{
						alt_email = "<input type='checkbox' name='send_to[]' value='alternative'/>";
					}
					
					if (staff_email==""){
						staff_email = "<input type='checkbox' name='send_to[]' value='staff' disabled/>";
					}else{
						staff_email = "<input type='checkbox' name='send_to[]' value='staff'/>";
					}
					
					
					newitem+="<p style='margin-top:0'><strong style='display:inline-block;margin-right:10px;'>Send To: </strong>"+email+"Personal Email "+alt_email+"Alternative Email "+staff_email+"Staff Email</p>";
					
					newitem+="<p><b>Subject :</b>&nbsp;&nbsp;<input type=\"text\"  name=\"subject\" size='50'>&nbsp;&nbsp;<strong>Email Templates: </strong><select name=\"emailTemplates\" id='emailTemplates'>";
					for(var i=0;i<emailTemplates.length;i++){
						newitem+="<option value=\""+emailTemplates[i]+"\">"+emailTemplates[i]+"</option>"
					}
					newitem+="</select>";
					
					newitem+="</p>";
					
					
					newitem+="<p style='margin-top:0'><strong style='display:inline-block;margin-right:35px;'>CC: </strong><input type='text' name='cc' size='50'/></p>";
					newitem+="<p style='margin-top:0'><strong style='display:inline-block;margin-right:28px;'>BCC: </strong><input type='text' name='bcc' size='50'/></p>";
					
					newitem+="<B>Message :</B>";
					newitem+="<div id='message-writer'></div>";
					newitem+="<input type='hidden' name='txt' id='message-writer-text'/>";
					newitem+="</td></tr>";
					newitem+="<tr><td><b>Send Message as :</b><br>";
					newitem+="<input type=\"radio\" name=\"templates\" value=\"signature\" checked=\"checked\"> Signature Template";
					newitem+="&nbsp;&nbsp;&nbsp;";
					newitem+="<input type=\"radio\" name=\"templates\" value=\"plain\"> Plain Text";
					newitem+="&nbsp;&nbsp;&nbsp;";
					newitem+="<input type=\"radio\" name=\"templates\" value=\"promotional\"> Promotional Template";
					newitem+="<br>";
					newitem+="<b>1) Attach File :</b> <input name=\"image\" type=\"file\" id=\"image\" class=text >";
					newitem+="<br>";
					newitem+="<b>2) Attach File :</b> <input name=\"image2\" type=\"file\" id=\"image2\" class=text >";
					newitem+="<br>";
					newitem+="<b>3) Attach File :</b> <input name=\"image3\" type=\"file\" id=\"image3\" class=text >";
					newitem+="<br>";
					newitem+="<b>4) Attach File :</b> <input name=\"image4\" type=\"file\" id=\"image4\" class=text >";
					newitem+="<br>";
					newitem+="<b>5) Attach File :</b> <input name=\"image5\" type=\"file\" id=\"image5\" class=text >";
					newitem+="</td></tr>";
					newitem+="<tr><td align=center>";
					newitem+="<INPUT type=\"submit\" value=\"Send / Save\" name=\"Add\" style=\"width:130px\">";
					newitem+="</td></tr></table>";
					document.getElementById("message").innerHTML=newitem;
					document.form.fill.value=actions;
					$(document).ready(function(){
						$("#message-writer").html(getEmailTemplate("Blank Page"));
						$("#message-writer-text").val($("#message-writer").html());
						$("#message-writer").each(function(){
							this.contentEditable = true;
						});
						checkInterval = setInterval(function() {
							$("#message-writer-text").val($("#message-writer").html());
						}, 500);
						$("#emailTemplates").change(function(){
							var template = $(this).val();
							var content = getEmailTemplate(template);
							$("#message-writer").html(content);
							$("#message-writer-text").val($("#message-writer").html());
						});
					});
					
				}
				else if(actions=="CSR")
				{
					newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";
					newitem+="<tr><td>";
					newitem+="<B>Observation</B>";
					newitem+="<textarea name=\"txt\" cols=\"48\" rows=\"3\" wrap=\"physical\" class=\"text\"  style=\"width:100%\"></textarea>";
					newitem+="</td></tr>";		
					newitem+="<tr><td align=center>";
					newitem+="<INPUT type=\"submit\" value=\"Save\" name=\"Add\" style=\"width:130px\">";
					newitem+="</td></tr></table>";
					document.getElementById("message").innerHTML=newitem;
					document.form.fill.value=actions;					
				}
				else
				{
					newitem="<table width=\"100%\" cellspacing=\"1\" cellpadding=\"2\" style=\"border:#CCCCCC solid 1px;\">";
					newitem+="<tr><td>";
					newitem+="<B>Add Record :</B>";
					newitem+="<textarea name=\"txt\" cols=\"48\" rows=\"7\" wrap=\"physical\" class=\"text\"  style=\"width:100%\"></textarea>";
					newitem+="</td></tr>";
					newitem+="<tr><td align=center>";
					newitem+="<INPUT type=\"submit\" value=\"Save\" name=\"Add\" style=\"width:130px\">";
					newitem+="</td></tr></table>";
					document.getElementById("message").innerHTML=newitem;
					document.form.fill.value=actions;
				
				}
				
				
					
						$('textarea').summernote({
						  toolbar: [
						    //[groupname, [button list]]
						    ['style', ['bold', 'italic', 'underline']],
						    ['fontsize', ['fontsize']],
						    ['para', ['ul', 'ol', 'paragraph']],
						  ],
						  height:200
						});
			}
			//ended: other functions
		
			//start: evaluation report
			var evaluation_obj = makeObject()
			function load_evaulation(userid)
			{
				evaluation_obj.open('get', 'staff_evaluation_loader.php?userid='+userid)
				evaluation_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				evaluation_obj.onreadystatechange = load_evaulation_loader 
				evaluation_obj.send(1)
			}		
			function load_evaulation_loader()
			{
				var data;
				data = evaluation_obj.responseText
				if(evaluation_obj.readyState == 4)
				{
					document.getElementById('evaluation_report_div').innerHTML = data;
					load_all();
				}
				else
				{
					document.getElementById("evaluation_report_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}
			//ended: evaluation report
		
			//start: admin report
			var admin_obj = makeObject()
			function load_admin(userid)
			{
				admin_obj.open('get', 'staff_admin_loader.php?userid='+userid)
				admin_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				admin_obj.onreadystatechange = load_admin_loader 
				admin_obj.send(1)
			}		
			function load_admin_loader()
			{
				var data;
				data = admin_obj.responseText
				if(admin_obj.readyState == 4)
				{
					document.getElementById('admin_report_div').innerHTML = data;
					load_all();
				}
				else
				{
					document.getElementById("admin_report_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}
			//ended: admin report
			
			//start: recruiter report
			var recruiter_obj = makeObject()
			function load_recruiter(userid)
			{
				recruiter_obj.open('get', 'staff_recruiter_loader.php?userid='+userid)
				recruiter_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				recruiter_obj.onreadystatechange = load_recruiter_loader 
				recruiter_obj.send(1)
			}		
			function load_recruiter_loader()
			{
				var data;
				data = recruiter_obj.responseText
				if(recruiter_obj.readyState == 4)
				{
					document.getElementById('recruiter_report_div').innerHTML = data;
				}
				else
				{
					document.getElementById("recruiter_report_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
				load_all();
			}
			//ended: recruiter report			
	
			//start: load all report
			function load_all()
			{
				document.getElementById("all_report").innerHTML = document.getElementById("admin_report_div").innerHTML+"<br />"+document.getElementById("recruiter_report_div").innerHTML+"<br />"+document.getElementById("evaluation_report_div").innerHTML;
			}
			//ended: load all report
			
		//ENDED: reporting functions
	
	
		//START: inactive status
		function update_inactive_current_status(userid, status) 
		{
			var format_value = '';
			format_value = format_value+'<table bgcolor="#FFFFCC" cellpadding="4" cellspacing="4" width="100%">';
			format_value = format_value+'<tr>';
			
			var is_check = '';
			if(status == 'NO POTENTIAL')
			{
				is_check = 'checked';
			}
			format_value = format_value+'<td width="100%" align="right">NO&nbsp;POTENTIAL</td><td><input type="radio" name="inactive_options" value="NO POTENTIAL" onclick ="update_status('+userid+', \'INACTIVE\',\'NO POTENTIAL\');" '+is_check+'></td><td>&nbsp;&nbsp;&nbsp;</td>';

			is_check = '';
			if(status == 'NOT INTERESTED')
			{
				is_check = 'checked';
			}
			format_value = format_value+'<td>NOT&nbsp;INTERESTED</td><td><input type="radio" name="inactive_options" value="NOT INTERESTED" onclick ="update_status('+userid+', \'INACTIVE\',\'NOT INTERESTED\');" '+is_check+'></td><td>&nbsp;&nbsp;&nbsp;</td>';			

			is_check = '';
			if(status == 'NOT READY')
			{
				is_check = 'checked';
			}
			format_value = format_value+'<td>NOT&nbsp;READY</td><td><input type="radio" name="inactive_options" value="NOT READY" onclick ="update_status('+userid+', \'INACTIVE\',\'NOT READY\');" '+is_check+'></td><td>&nbsp;&nbsp;&nbsp;</td>';			

			is_check = '';
			if(status == 'BLACKLISTED')
			{
				is_check = 'checked';
			}
			format_value = format_value+'<td>BLACKLISTED</td><td><input type="radio" name="inactive_options" value="BLACKLISTED" onclick ="update_status('+userid+', \'INACTIVE\',\'BLACKLISTED\');" '+is_check+'></td><td>&nbsp;&nbsp;&nbsp;</td>';			

			format_value = format_value+'<td>&nbsp;&nbsp;&nbsp;</td>';
			format_value = format_value+'<td align="right"><a href="javascript: inactive_staff_option_exit(); "><img src="../images/closelabel.gif" border="0" /></a></td>';
			format_value = format_value+'</tr>';
			format_value = format_value+'</table>';

			document.getElementById("inactive_staff_div").innerHTML = format_value;			
		}	
		//ENDED: inactive status
		
		
		//START: staff view & edit notes
			//construct object
			var edit_notes_obj = makeObject()
			
			//start: delete notes
			function delete_notes_show_report(userid, notes_id, notes_type) 
			{
				edit_notes_obj.open('get', 'delete_notes_show_report.php?userid='+userid+'&notes_id='+notes_id+'&notes_type='+notes_type)
				edit_notes_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				edit_notes_obj.onreadystatechange = view_notes_show_report_loader 
				edit_notes_obj.send(1)

				if(notes_type == 'communications')
				{
					load_admin(userid);
					load_recruiter(userid);
				}
				else if(notes_type == 'evaluation')
				{
					load_evaulation(userid);
				}
				edit_notes_show_report_exit();
			}	
			//ended: view notes
			
			//start: delete notes
			function view_notes_show_report(userid, notes_id, notes_type) 
			{
				edit_notes_obj.open('get', 'view_notes_show_report.php?userid='+userid+'&notes_id='+notes_id+'&notes_type='+notes_type)
				edit_notes_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				edit_notes_obj.onreadystatechange = view_notes_show_report_loader 
				edit_notes_obj.send(1)
			}	
			function view_notes_show_report_loader()
			{
				var data;
				data = edit_notes_obj.responseText
				if(edit_notes_obj.readyState == 4)
				{
					document.getElementById('edit_notes_div').innerHTML = data;
				}
				else
				{
					document.getElementById("edit_notes_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}
			//ended: view notes
			
			//start: edit notes
			function edit_notes_show_report(userid, notes_id, notes_type) 
			{
				jQuery("#message").html("");
				jQuery("#edit_notes_div").html("");
				jQuery("#edit_notes_div").html("<img src='../images/ajax-loader.gif'/>");
				jQuery.get('edit_notes_show_report.php?userid='+userid+'&notes_id='+notes_id+'&notes_type='+notes_type, function(html){
					

					// console.log(html);exit();
					//console.log(html);exit();
					jQuery("#edit_notes_div").html(html);
					$('textarea').summernote({
						  toolbar: [
						    //[groupname, [button list]]
						    ['style', ['bold', 'italic', 'underline']],
						    ['fontsize', ['fontsize']],
						    ['para', ['ul', 'ol', 'paragraph']],
						  ],
						  height:200
						});
					sync_to_v2();
				});
				
			}	
			function save_edit_notes_show_report(form_obj, userid, notes_type) 
			{
				
				
			
				
				var formData = {
						userid: userid,
						notes_content:jQuery("#notes_text").code(),
						notes_content2:jQuery("#notes_text").val(),
						notes_id:jQuery("#edit-notes_id").val(),
						notes_type:jQuery("#edit-notes_type").val(),
						action_type:jQuery("#edit-action_type").val()
							
				};
// 				
					
					//console.log(form);exit();
				
				jQuery.post("edit_notes_show_report.php", formData, function(data){
					if(notes_type == 'communications')
					{
						load_admin(userid);
						load_recruiter(userid);
					}
					else if(notes_type == 'evaluation')
					{
						load_evaulation(userid);
					}
					edit_notes_show_report_exit();
					sync_to_v2();
				});
				
			}			
			function edit_notes_show_report_loader()
			{
				
				
				var data;
				data = edit_notes_obj.responseText
				if(edit_notes_obj.readyState == 4)
				{
					document.getElementById('edit_notes_div').innerHTML = data;
				}
				else
				{
					document.getElementById("edit_notes_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}	
			//ended: edit notes			
			
			//start: relevant industry experience
			var relevant_industry_experience_obj = makeObject()
			function delete_relevant_industry_experience(id,userid) 
			{
				relevant_industry_experience_obj.open('get', 'update_relevant_industry_experience.php?id='+id+'&userid='+userid)
				relevant_industry_experience_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				relevant_industry_experience_obj.onreadystatechange = relevant_industry_experience_loader 
				relevant_industry_experience_obj.send(1)
			}	
			function relevant_industry_experience_loader()
			{
				var data;
				data = relevant_industry_experience_obj.responseText
				if(relevant_industry_experience_obj.readyState == 4)
				{
					document.getElementById('relevant_industry_experience').innerHTML = data;
				}
				else
				{
					document.getElementById("relevant_industry_experience").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}
			//ended: relevant industry experience			
			
			//start: clear notes container for methods edit & view
			function edit_notes_show_report_exit()
			{
				document.getElementById("edit_notes_div").innerHTML="";
			}
			//ended: clear notes container for methods edit & view
			
			//start: asl
			var asl_obj = makeObject()
			function delete_asl(userid,id)
			{
				asl_obj.open('get', 'staff_asl_list.php?action=delete&id='+id+'&userid='+userid)
				asl_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				asl_obj.onreadystatechange = load_asl_loader 
				asl_obj.send(1)
			}		
			function load_asl_loader()
			{
				var data;
				data = asl_obj.responseText
				if(asl_obj.readyState == 4)
				{
					document.getElementById('asl_div').innerHTML = data;
				}
				else
				{
					document.getElementById("asl_div").innerHTML="<img src='../images/ajax-loader.gif'>";
				}
			}
			//ended: asl
		//ENDED: staff view & edit notes
		
		
		//START: get all post values of ajax
		function get_form_values(fobj)
		{
			var str = "";
			var valueArr = null;
			var val = "";
			var cmd = "";
		
			for(var i = 0;i < fobj.elements.length;i++)
			{
				switch(fobj.elements[i].type)
				{
					case "text":
						str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
						break;
					case "textarea":
						str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
						break;
					case "select-one":
						str += fobj.elements[i].name + "=" + fobj.elements[i].options[fobj.elements[i].selectedIndex].value + "&";
						break;
				}
			}
		
			str = str.substr(0,(str.length - 1));
			return str;
		}		
		//ENDED: get all post values of ajax
		
		
		//START: open client profile
		function lead(id) 
		{
			previewPath = "../leads_information.php?id="+id;
			window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}		
		//ENDED: open client profile
		
		//START: open ads
		function ads(id) 
		{
			previewPath = "/portal/Ad.php?id="+id;
			window.open(previewPath);
		}		
		//ENDED: open ads
		
		
		
		
		
		
		//START: confirm file deletion
		function delete_file_confirmation(path,file_name)
		{
			var r=confirm("Are you sure you want to delete this file ["+file_name+"]?");
			if (r==true)
			{
				window.location = "?"+path;
			}
		}		
		//ENDED: confirm file deletion
		
		
		//START: staff sent samples
		var staff_samples_obj = makeObject()
		function staff_samples_counter(userid) 
		{
			staff_samples_obj.open('get', 'staff_samples_sent.php?userid='+userid) 
			staff_samples_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			staff_samples_obj.onreadystatechange = staff_samples_counter_loader 
			staff_samples_obj.send(1)
		}	
		function staff_samples_counter_loader()
		{
			var data;
			data = staff_samples_obj.responseText
			if(staff_samples_obj.readyState == 4)
			{
				document.getElementById('staff_files_reporting_div').innerHTML = data;
			}
			else
			{
				document.getElementById("staff_files_reporting_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
		}		
		function staff_samples_counter_exit()
		{
			document.getElementById("staff_files_reporting_div").innerHTML="";
		}
		function open_staff_samples_message(id)
		{
			document.getElementById("staff_samples_message"+id).style.visibility = "visible";
		}
		function close_staff_samples_message(id)
		{
			document.getElementById("staff_samples_message"+id).style.visibility = "hidden";
		}		
		//ENDED: staff sent samples		
		
		
		//START: file permission
		var staff_file_permission_update_obj = makeObject()
		function staff_file_permission_update(id)
		{
			if(document.getElementById('permission'+id).checked == true)
			{
				staff_file_permission_update_obj.open('get', 'staff_files_uploaded_update_permission.php?action=ADMIN&id='+id)
				staff_file_permission_update_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				staff_file_permission_update_obj.onreadystatechange = staff_file_permission_update_loader 
				staff_file_permission_update_obj.send(1)
			}
			else
			{
				staff_file_permission_update_obj.open('get', 'staff_files_uploaded_update_permission.php?action=ALL&id='+id)
				staff_file_permission_update_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				staff_file_permission_update_obj.onreadystatechange = staff_file_permission_update_loader 
				staff_file_permission_update_obj.send(1)
			}
		}
		function staff_file_permission_update_loader()
		{
			var data;
			data = staff_file_permission_update_obj.responseText
			if(staff_file_permission_update_obj.readyState == 4)
			{
				alert(data);
				document.getElementById("staff_file_permission_update_loader_div").innerHTML="";
			}
			else
			{
				document.getElementById("staff_file_permission_update_loader_div").innerHTML="<img src='../images/ajax-loader.gif'>";
			}
		}		
		//ENDED: file permission.

var selectedRecruiter;

function updateOrdering(){
	var i = 1;
	jQuery(".evaluation_comment").each(function(){
		jQuery(this).attr("data-ordering", i);
		i++;
	})
	
}

function updateOrderingTab(){
	var i = 1;
	jQuery(".evaluation_comment_tab").each(function(){
		jQuery(this).attr("data-ordering", i);
		i++;
	})
	
}

function initSortUpdate(){
	var list = [];
	jQuery(".evaluation_comment").each(function(){
		var data = {
			ordering:jQuery(this).attr("data-ordering"),
			id:jQuery(this).attr("data-id")
		};
		
		list.push(data);
	});
	jQuery.post("/portal/recruiter/update_sorting_evaluation_comments.php", {items:list}, function(response){
		sync_to_v2();
	});
	
}

function updateEmploymentOrdering(){
	var i = 1;
	jQuery(".employment_history").each(function(){
		jQuery(this).attr("data-ordering", i);
		i++;
	})
	
}
function updateEmploymentOriginalOrdering(){
	var i = 1;
	jQuery(".employment_history").each(function(){
		jQuery(this).attr("data-original-ordering", i);
		i++;
	})
	
}


jQuery(document).ready(function(){
	
	
	
	selectedRecruiter = jQuery("#staff_recruiter_stamp").val();	
	
	initSortUpdate();
	updateEmploymentOrdering();
	updateEmploymentOriginalOrdering();
	/**
	 * Make Evaluation Comments sortable
	 */
	
	
	

	jQuery("#evaluation_report_list tbody").sortable().on( "sortupdate", function(){
		var list = [];
		updateOrdering();
		jQuery(".evaluation_comment").each(function(){
			var data = {
				ordering:jQuery(this).attr("data-ordering"),
				id:jQuery(this).attr("data-id")
			};
			
			list.push(data);
		});
		jQuery.post("/portal/recruiter/update_sorting_evaluation_comments.php", {items:list}, function(response){
			sync_to_v2();	
		});
	});
	
	
	/**
	 * Make Evaluation Comments sortable
	 */
	jQuery("#evaluation_report_list_tab tbody").sortable().on( "sortupdate", function(){
		var list = [];
		updateOrderingTab();
		jQuery(".evaluation_comment_tab").each(function(){
			var data = {
				ordering:jQuery(this).attr("data-ordering"),
				id:jQuery(this).attr("data-id")
			};
			
			list.push(data);
		});
		jQuery.post("/portal/recruiter/update_sorting_evaluation_comments.php", {items:list}, function(response){
			sync_to_v2();		
		});
	});
	
	
	jQuery(".withdraw_job_application").live("click", function(e){
		var href = jQuery(this).attr("href");
		var me = jQuery(this);
		var ans = confirm("Do you want to withdraw this application?")
		if (ans){
		
			jQuery.get(href, function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					alert("Application successfully withdrawn.");
					me.parent().parent().fadeOut(100, function(){
						jQuery(this).remove();
					})
				}
				sync_to_v2();
			});	
		}
		e.preventDefault();
	});
	
	
	jQuery(".sms_launcher").click(function(e){
		popup_win( jQuery(this).attr("href"), 600, 400);
		e.preventDefault();
	});
	
	jQuery(".view_logs").click(function(e){
		popup_win( jQuery(this).attr("href"), 800, 600);
		e.preventDefault();
	})
	
	jQuery(".employment_history_list").sortable().on( "sortupdate", function(){
		updateEmploymentOrdering();
		
		var items = [];
		jQuery(".employment_history").each(function(){
			var item = {
				ordering:jQuery(this).attr("data-ordering"),
				original_ordering:jQuery(this).attr("data-original-ordering"),
				
			}
			items.push(item)
		});
		
		var userid = jQuery("input[name=userid]").val();
		var data = {
			userid:userid,
			items:items
		};
		
		jQuery.post("/portal/recruiter/update_employment_history_sorting.php", data, function(response){
			response = jQuery.parseJSON(response);
			sync_to_v2();
		});
		
	});
	
	jQuery(".reject-shortlist").live("click", function(e){
		e.preventDefault();
		var id = jQuery(this).attr("data-id");
		var me = jQuery(this);
		jQuery.get("/portal/recruiter/get_shortlist_details.php?id="+id, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				jQuery("#shortlist_id").val(response.shortlist.id);
				jQuery("#feedback_client_name").text(response.shortlist.lead_fname+" "+response.shortlist.lead_lname);
				jQuery("#feedback_staff_name").text(response.shortlist.candidate_fname+" "+response.shortlist.candidate_lname);
				
				jQuery( "#add-feedback-dialog" ).dialog(
				{height: 350,
				width:590,
				modal: true,
				title:'Add feedback for Shortlist Rejection',
				buttons: {
			        "Save Feedback": function() {
			        	var data = jQuery(".add_feedback_form").serialize();
						jQuery.post("/portal/recruiter/reject_shortlist.php",data, function(response){
							response = jQuery.parseJSON(response);
							if (response.success){
								alert("Shortlist has been successfully rejected.");
								me.removeClass("reject-shortlist").addClass("unreject-shortlist").text("Qualified").css("font-size", "1em");
								jQuery(  "#add-feedback-dialog"  ).dialog( "close" );
								window.location.reload();
							}else{
								alert(response.error);
							}
							sync_to_v2();
						});
						
			        },
			        Cancel: function() {
			          jQuery(  "#add-feedback-dialog"  ).dialog( "close" );
			        }
			      }
				});
			}else{
				alert(response.error);
			}
		});
		//css fix
		jQuery(".ui-dialog .ui-dialog-titlebar-close span").css("margin", "-8px");
		e.preventDefault();
		e.stopPropagation();
		return false;
		
	});
	
	jQuery(".unreject-shortlist").live("click", function(e){
		e.preventDefault();
		var me = jQuery(this);
		var ans = confirm("Do you want to revert the rejection of this shortlist?");
		if (ans){
			jQuery.get("/portal/recruiter/unreject_shortlist.php?id="+me.attr("data-id"), function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					alert("Shortlist's rejection has been successfully reverted");
					window.location.reload();
				}else{
					alert(response.error);
				}
				sync_to_v2();
			});
		}
	});
	
	jQuery(".close_shortlist").live("click", function(){
		jQuery("#shortlist_preview").html("");
	})
	jQuery(".feedback_view").live("click", function(e){
		e.preventDefault();
		jQuery.get(jQuery(this).attr("href"), function(response){
			jQuery("#shortlist_preview").html(response);
			sync_to_v2();
		})
	})
	
	jQuery(".minimize").live("click", function(e){
		jQuery(".drawer").slideUp(250);
		jQuery(this).removeClass("minimize").addClass("maximize").text("[Maximize]");
		e.preventDefault();
	});
	jQuery(".maximize").live("click", function(e){
		jQuery(".drawer").slideDown(250);
		jQuery(this).addClass("minimize").removeClass("maximize").text("[Minimize]");
		e.preventDefault();
	});
	
	
	//change URL to remotestaff.com.au when from sc and action = uploading
	jQuery("input[name=upload_file]").on("click", function(e){
		var host = jQuery("#submit-form").attr("data-host");
		var userid = jQuery("#submit-form").attr("data-userid");
		var admin_id = jQuery("#submit-form").attr("data-admin_id");
		var url = "https://remotestaff.com.au/portal/recruiter/staff_information.php?userid="+userid+"&host="+host+"&admin_id="+admin_id;
		if (host=="sc.remotestaff.com.au"){
			jQuery("#submit-form").attr("action", url);		
		}
	});
	
	jQuery("input[name=picture]").on("click", function(e){
		var host = jQuery("#submit-form").attr("data-host");
		var userid = jQuery("#submit-form").attr("data-userid");
		var admin_id = jQuery("#submit-form").attr("data-admin_id");
		var url = "https://remotestaff.com.au/portal/recruiter/staff_information.php?userid="+userid+"&host="+host+"&admin_id="+admin_id;
		if (host=="sc.remotestaff.com.au"){
			jQuery("#submit-form").attr("action", url);		
		}
	});
	
	
	jQuery(".test_taken_check").on("click",function(e){
		var result_id = jQuery(this).val();
		var result_selected = 0;
		if(jQuery(this).attr('checked')) {
			result_selected = 1;
		} else {
			result_selected = 0;
		}
		jQuery.post('/portal/recruiter/update_test_taken.php',{ result_id : result_id, result_selected : result_selected }, function (response){
			sync_to_v2();
		} );
	});
	
	
	
	
});
		
