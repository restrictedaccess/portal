
var brep = (function($){

	// constructor
    var ticket = function () {
		
		ticket.report_id = 0;
		//this.update_cal();
        // private
        // public (this instance only)
		// initialize detail page
    };
	
	ticket.load_assignto = function(id, display_string, updateID) {
		ticket.onblur_search(id, display_string);
		
		$('input#'+id).blur(function(){ticket.onblur_search(id, display_string);});
		$('input#'+id).focus(function(){ticket.onfocus_search(id, display_string);});
		
		$('input#'+id).simpleAutoComplete('autocomplete_query.php',{
			autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
			identifier: id, updateElem:updateID}, //clientNCallback);
			function(param, elID){
				if(elID == 'userid') $("input#emailaddr").val( param[2]);
				$("input#"+elID).val( param[0]);	});
	};
	
	ticket.onblur_search = function(id, str) {
		var inp_search = $('input#'+id);
		inp_search.css('color','#666');
		
		if(inp_search.val() == '') inp_search.val(str);
		return true;
	};
	
	ticket.onfocus_search = function(id, str) {
		var inp_search = $('input#'+id);
		inp_search.css('color','');
		if(inp_search.val() == 'Search '+str+'...')
			inp_search.val('');
		else $(inp_search).select();
		return true;
	};
	
	
	
	ticket.search_keyword = function() {
		var fieldname = $("input[name=field]:checked").val();
		var field_inp = $('input#'+fieldname).val();
		if(!field_inp) return;
		
		$.ajax({
			type: "POST",
			url: "/seminar/admin.php?/search_keyword/",
			data: { 'fieldname': fieldname, 'field_inp': field_inp},
			dataType: "json",
			success: function(data){
				seminar.populate_table(data, 'process_keyword');
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	};
	ticket.tickfile = function(id) {
		var file_id = $('input#'+id);	
		file_id.attr('disabled', file_id.is(':disabled') ? false : true);
	};
	
	ticket.fileUpload = function(upload_field, root) {
		$('input#new_report').attr('disabled', true);
		$('span#task-status').empty().append('Attaching file...').show();
		// show display message
		if( typeof root === 'undefined' ) {
			var chatcontent = window.parent;
		} else {
			var chatdiv = document.getElementById(root);
			var chatcontent = chatdiv.contentWindow;
		}
		//chatcontent.flash_callback.call_noticeTyping(0, 50, 'sending file');
		// upload_field.form.submit();
	
		var re_text = /\.txt|\.xml|\.zip/i;
		var filename = upload_field.value;
		
		filename = filename.replace(/\s+/g, '_').replace(/\'/, '');
		filename = filename.split(/\\/).pop();
		
		// append message here
		var fileID = filename.replace(/\./g, '');
		$('td#attachedfiles').append("<input type='checkbox' name='"+fileID+"' checked='checked' onclick=\"brep.tickfile('"+fileID+"');\"/><span id='txt_"+fileID+"' class='text'>"+filename+"</span>&nbsp;");
		$('form#bug_form').append("<input type='hidden' id='"+fileID+"' name='fileattach[]' value='"+filename+"'/>");
		
		var attach_file = $('a#attfile');
		if( attach_file.text() == 'Attach file' ) {
			attach_file.text('Attach another file');
			$('button#btn_upload').css({'width':'130px'});
		}
	
		upload_field.form.submit();
		//document.getElementById('upload_status').value = "uploading file...";
		//upload_field.disabled = true;
		return true;

	};

	ticket.exit = function(id) {
		//setTimeout(function(){$('div#'+id).remove();}, 100);
	}

	ticket.recordMouse = function(e) {
		x = e.clientX;
		y = e.clientY;
	};
	
	ticket.data = function(id, data) {
		$("span#"+id).data("Data", data);
	}

	
	
	ticket.delAll = function() {
		var tickbox = document.casesform['tick[]'];
		var tick = 0;
		for(var i=0; i < tickbox.length; i++){
			if ( tickbox[i].checked ) {
				tick = 1;
				break;
			}
		}
		if(!tick) return;
		if(confirm('Do you want to delete selected cases?')) {
			document.casesform.submit();
		}
	}
	
	
	ticket.getHistory = function(id, logs) {
		var tbl = $('table#logs');
		tbl.find("tr:gt(0)").remove();
		
		var bgcolor = new Array('#d0d8e8', '#e9edf4');
		var divres = $('div#divresult');
		if( logs.is(':visible') ) {
			$.ajax({
				type: "POST",
				url: "?/historylist/",
				data: { 'report_id': id},
				dataType: "json",
				success: function(data){			
					for(var i = 0; i < data.length; i++) {
						var log_info = data[i];
						rowbg = bgcolor[i % 2];
						var user_info = data[i].user_info;
								
						tbl.find('tbody').append("<tr bgcolor='"+rowbg+"'>"+
							"<td class='item'>"+log_info.date_updated+"</td>"+
							"<td class='item'>"+user_info.fname+" "+user_info.lname+"</td>"+
							"<td class='item'>"+log_info.field_update+"</td></tr>");
					}
					$(window).scrollTop($(window).height()+500);
					
					//$('div#divresult').css({'height': divres.height() + $(window).scrollTop()} );
					//alert('-'+$(window).height()+':'+$(window).scrollTop());

				}, error: function(XMLHttpRequest, textStatus, errorThrown){
					alert(textStatus + " (" + errorThrown + ")");
				}
			});
			//logs.show();
			$(window).scrollTop($(window).height()+500);
			$('a#showhide').text('Hide');
					
		} else {
			//logs.hide();
			$('a#showhide').text('Show');
		}

	};
	
	ticket.assign_to = function(id, userid, staff_name) {
		var tbl = $('table#logtbl');
		tbl.find("tr:gt(0)").remove();
		$.ajax({
			type: "POST",
			url: "index.php?/assign_report/",
			data: { 'report_id': id, 'userid':userid, 'staff_name': staff_name},
			dataType: "json",
			success: function(data){			
				//$('td#report_assignto').text(data.result);
				alert("Bug report succesfully assigned to '"+staff_name+"'");
				if( data != null && data.status == 'assigned' ) {
					alert("Status is now '"+data.status+"'");
				}
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	};
	
	ticket.change_status = function(id, status) {
		var tbl = $('table#logtbl');
		tbl.find("tr:gt(0)").remove();
		$.ajax({
			type: "POST",
			url: "index.php?/set_status/",
			data: { 'report_id': id, 'status':status},
			dataType: "json",
			success: function(data){			
				$('td#report_status').text(data.result);
				alert("Status has been changed to '"+data.result+"'");
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	};
	
	ticket.animate_close = function() {
		$('div#mainbox').animate({'height': 'toggle'},
			function(){$(this).hide();
		});
	};
	ticket.submit_form = function(formsel) {
		$("form#"+formsel).submit(function(e) {
			$('span#task-status').empty().append('Loading...').show();
			//var btnName = $("input[type=submit][clicked=true]").val();
			$("input[name=id]").val(ticket.report_id);
		});
	};
	
	return ticket;
})(jQuery);
