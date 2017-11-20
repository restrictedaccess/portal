var page = 1;
var rows = 50;
var hasRequest = false;
function popup_win( loc, wd, hg ) {
   var remote = null;
   var xpos = screen.availWidth/2 - wd/2; 
   var ypos = screen.availHeight/2 - hg/2; 
   remote = window.open('','','width=' + wd + ',height=' + hg + ',resizable=0,scrollbars=1,screenX=0,screenY=0,top='+ypos+',left='+xpos);
   if (remote != null) {
      if (remote.opener == null) {
         remote.opener = self;
      }
      remote.location.href = loc;
      remote.focus();
   } 
   else { 
      self.close(); 
   }
} 
function addPreloader(){
	var top = (jQuery(".rs-preloader").height()/2) - jQuery("#preloader-img").height();
	jQuery("#preloader-img").css("top", top+"px").css("position", "absolute");
	jQuery(".rs-preloader").show();
}

function removePreloader(){
	jQuery(".rs-preloader").hide();
}
function renderResponse(response){
	var output = "";
	jQuery.each(response.rows, function(i,item){
		if (item.mode=="reply"){
			if (!item.read){
				output += "<tr class='danger'>";
			}else{
				output += "<tr>";
			}
			output += "<td>"+(((page-1)*rows)+(i+1))+"</td>";
			if (item.userid!=null){
				if (item.owners!=undefined&&item.owners.length>0){
					output += "<td><a href='/portal/recruiter/staff_information.php?userid="+item.userid+"&page_type=popup' class='popup'>"+item.fname+" "+item.lname+"</a>";		
					output+="<br/><strong>Possible Owners</strong><br/><ul>";
					jQuery.each(item.owners, function(k, owner){
						output += "<li><a href='/portal/recruiter/staff_information.php?userid="+owner.userid+"&page_type=popup' class='popup'>"+owner.candidate_fullname+"</a></li>"
					})
					output+="</li>";
					output += "</td>";
				}else{
					output += "<td><a href='/portal/recruiter/staff_information.php?userid="+item.userid+"&page_type=popup' class='popup'>"+item.fname+" "+item.lname+"</a></td>";					
				}
				
				
			}else{
				output += "<td>Staff: No Record Found</td>";
			}
			output += "<td>Remote Staff</td>";
			output += "<td>"+item.mobile_number+"</td>";
			if (item.recruiter_fullname==null){
				output += "<td>&nbsp;</td>";			
			}else{
				output += "<td>"+item.recruiter_fullname+"</td>";
			}
			if (item.csros==undefined){
				output += "<td>&nbsp;</td>";			
			}else{
				output += "<td>"+item.csros.join(", ")+"</td>";
			}
			output += "<td>"+item.message+"</td>";
			output += "<td>"+item.date_received+"</td>";
			if (!item.read){
				if (item.userid!=null){
					output += "<td><button class='btn btn-primary btn-xs marked_as_read' data-sms_id='"+item.id+"'><i class='glyphicon glyphicon-tag'/> Mark as Read</button> <button class='btn btn-primary btn-xs reply' data-userid='"+item.userid+"' data-sms_id='"+item.id+"'><i class='glyphicon glyphicon-envelope'/> Reply</td>";
				}else{
					output += "<td><button class='btn btn-primary btn-xs marked_as_read' data-sms_id='"+item.id+"'><i class='glyphicon glyphicon-tag'/> Mark as Read</button></td>";
				}
			}else{
				output += "<td><button class='btn btn-danger btn-xs unmarked_as_read' data-sms_id='"+item.id+"'><i class='glyphicon glyphicon-tag'/> Mark as Unread</button></td>";

			}
			output += "</tr>";
		}else{
			output += "<tr>";
			output += "<td>"+(((page-1)*rows)+(i+1))+"</td>";
			output += "<td>Admin: "+item.sender_admin+"</td>";
			if (item.userid!=null){
				if (item.owners!=undefined&&item.owners.length>0){
					output += "<td><a href='/portal/recruiter/staff_information.php?userid="+item.userid+"&page_type=popup' class='popup'>"+item.fname+" "+item.lname+"</a>";		
					output+="<br/><strong>Possible Owners</strong><br/><ul>";
					jQuery.each(item.owners, function(k, owner){
						output += "<li><a href='/portal/recruiter/staff_information.php?userid="+owner.userid+"&page_type=popup' class='popup'>"+owner.candidate_fullname+"</a></li>"
					})
					output+="</li>";
					output += "</td>";
				}else{
					output += "<td><a href='/portal/recruiter/staff_information.php?userid="+item.userid+"&page_type=popup' class='popup'>"+item.fname+" "+item.lname+"</a></td>";					
				}
				
			}else{
				output += "<td>Staff: No Record Found</td>";
			}
			output += "<td><strong>("+item.userid+")</strong> "+item.mobile_number+"</td>";
			if (item.recruiter_fullname==null){
				output += "<td>&nbsp;</td>";			
			}else{
				output += "<td>"+item.recruiter_fullname+"</td>";
			}
			if (item.csros==undefined){
				output += "<td>&nbsp;</td>";			
			}else{
				output += "<td>"+item.csros.join(", ")+"</td>";
			}
			output += "<td>"+item.message+"</td>";
			output += "<td>"+item.date_sent+"</td>";
			output += "<td></td></tr>";
		}

		
	});
	
	jQuery("#sms_logs tbody").html(output);
	var start = ((page-1)*rows) + 1;
	var end = (start + rows) - 1;
	if (end>response.records){
		end = response.records;
		jQuery(".next").addClass("disabled");
	}else{
		jQuery(".next").removeClass("disabled");
	}
	if (page==1){
		jQuery(".prev").addClass("disabled");
	}else{
		jQuery(".prev").removeClass("disabled");
	}	
	
	if (response.records==0){
		jQuery(".start_count").text(0);
	}else{
		jQuery(".start_count").text(start);	
	}
	
	
	var totalPage = Math.ceil(response.records/rows)

	jQuery(".pager").html("");
	for(var i=1;i<=totalPage;i++){
		jQuery("<option value='"+i+"'>"+i+"</option>").appendTo(jQuery(".pager"));
	}
	jQuery(".pager").val(page);
	
	jQuery(".end_count").text(end);
	jQuery(".total_records").text(response.records);
	hasRequest = false;
	removePreloader();
}

function requestNotifViaLongPoll(){
	var admin_status = jQuery("#admin_status").val();
	var admin_id = jQuery("#admin_id").val();
		
	(function poll(){
	    $.ajax({ url: "/portal/sms/get_message.php?admin_id="+admin_id, success: function(response){
	        //Update your dashboard gauge
	       
	       if (response.success&&response.hasMessage){
		       if (!hasRequest){
					addPreloader();
						hasRequest = true;
						page = 1;
						var data = jQuery(this).serialize();
						data += "&page="+page
						jQuery("#sms_sound").each(function(){
							console.log("Playing sound")
							this.play();
						});
						jQuery.get("/portal/sms/list.php?"+data, function(response){
							response = jQuery.parseJSON(response);
							renderResponse(response);		
						})
					}
				}			       
	       
	    }, dataType: "json", complete: poll, timeout: 30000 });
	})();
}

function requestNotif() {
	var baseUrl = jQuery("#base_url").val();
	var host = baseUrl+'sms/notif/';
	
	if (Modernizr.websockets){
		var websocket = new WebSocket(host);
		websocket.onopen = function (evt) { 
			console.log("Successfully connected")
		};
		websocket.onmessage = function(evt) {
			var data = evt.data;
			var response = jQuery.parseJSON(data);
			var admin_status = jQuery("#admin_status").val();
			var admin_id = jQuery("#admin_id").val();
			if (admin_id==response.admin_id){
				if (!hasRequest){
					addPreloader();
					hasRequest = true;
					page = 1;
					var data = jQuery(this).serialize();
					data += "&page="+page
					jQuery("#sms_sound").each(function(){
						this.play();
					});
					jQuery.get("/portal/sms/list.php?"+data, function(response){
						response = jQuery.parseJSON(response);
						renderResponse(response);		
					})
				}
			}
			
			
		};
		websocket.onerror = function (evt) { 
			requestNotifViaLongPoll();
		};
	}else{
		requestNotifViaLongPoll();
	}

}

jQuery(document).ready(function(){
	jQuery("#inputDateFrom").datepicker();
	jQuery("#inputDateTo").datepicker();
	jQuery("#inputDateFrom").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#inputDateTo").datepicker("option", "dateFormat", "yy-mm-dd");	
	if (!hasRequest){
		addPreloader();
		hasRequest = true;
		page = 1;
		var data = jQuery("#filter-form").serialize();
		data += "&page="+page
		
		jQuery.get("/portal/sms/list.php?"+data, function(response){
			response = jQuery.parseJSON(response);
			renderResponse(response);		
		})
	}
	
	jQuery("#filter-form").submit(function(){
		if (!hasRequest){
			addPreloader();
			hasRequest = true;
			page = 1;
			var data = jQuery(this).serialize();
			data += "&page="+page
			
			jQuery.get("/portal/sms/list.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				renderResponse(response);		
			})
		}
		
		return false;
	});
	
	jQuery(".pager").on("change", function(){
		if (!hasRequest){
			addPreloader();
			hasRequest = true;
			page = jQuery(this).val();
			var data = jQuery("#filter-form").serialize();
			data += "&page="+page
			
			jQuery.get("/portal/sms/list.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				renderResponse(response);		
			})
		}
		
		return false;
	});
	
	//call web socket
	requestNotif();
})

jQuery(document).on("click", ".popup", function(e){
	var href = jQuery(this).attr("href")
	window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	e.preventDefault();	
})
jQuery(document).on("click", ".next", function(e){
	if (!jQuery(this).hasClass("disabled")){
		if (!hasRequest){
			addPreloader();
			hasRequest = true;
			page+=1;
			var data = jQuery("#filter-form").serialize();
			data += "&page="+page
			jQuery.get("/portal/sms/list.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				renderResponse(response);		
			})			
		}			
	}
	e.preventDefault();
})
jQuery(document).on("click", ".prev", function(e){
	if (!jQuery(this).hasClass("disabled")){
		if (!hasRequest){
			addPreloader();
			hasRequest = true;
			page-=1;
			var data = jQuery("#filter-form").serialize();
			data += "&page="+page
			jQuery.get("/portal/sms/list.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				renderResponse(response);		
			})			
		}			
	}
	e.preventDefault();
})

jQuery(document).on("click", ".marked_as_read", function(e){
	var sms_id = jQuery(this).attr("data-sms_id");
	var me = jQuery(this);
	jQuery.get("/portal/sms/mark_as_read.php?sms_id="+sms_id, function(response){
		me.parent().parent().removeClass("danger");
		me.removeClass("btn-primary").addClass("btn-danger").removeClass("marked_as_read").addClass("unmarked_as_read").html("Mark as Unread <i class='glyphicon glyphicon-tag'></i>");
	})
	e.preventDefault();
});
jQuery(document).on("click", ".unmarked_as_read", function(e){
	var sms_id = jQuery(this).attr("data-sms_id");
	var me = jQuery(this);
	jQuery.get("/portal/sms/mark_as_unread.php?sms_id="+sms_id, function(response){
		me.parent().parent().addClass("danger");
		me.removeClass("btn-danger").addClass("btn-primary").removeClass("unmarked_as_read").addClass("marked_as_read").html("Mark as Read <i class='glyphicon glyphicon-tag'></i>");
	})
	e.preventDefault();
});
jQuery(document).on("click", ".reply", function(e){
	var sms_id = jQuery(this).attr("data-sms_id");
	var me = jQuery(this);
	jQuery.get("/portal/sms/mark_as_read.php?sms_id="+sms_id, function(response){
		me.parent().parent().removeClass("danger");
		var userid = me.attr("data-userid");
		popup_win("/portal/recruiter/sms_sender.php?userid="+userid, 640, 400);
	})
	e.preventDefault();
});