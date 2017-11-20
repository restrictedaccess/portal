
var class_ticket = (function(){

	// constructor
    var ticket = function () {
		//this.update_cal();
        // private
        // public (this instance only)
		// initialize detail page
		ticket.onblur_search('client_name0', 'client name');
		$('input#client_name0').blur(function(){ticket.onblur_search('client_name0', 'client name');});
		$('input#client_name0').focus(function(){ticket.onfocus_search('client_name0', 'client name');});
		
		ticket.onblur_search('client_id0', 'id');
		$('input#client_id0').blur(function(){ticket.onblur_search('client_id0', 'id');});
		$('input#client_id0').focus(function(){ticket.onfocus_search('client_id0', 'id');});
		
		ticket.onblur_search('staff_name0', 'staff name');
		$('input#staff_name0').blur(function(){ticket.onblur_search('staff_name0', 'staff name');});
		$('input#staff_name0').focus(function(){ticket.onfocus_search('staff_name0', 'staff name');});
		
		ticket.onblur_search('staff_id0', 'id');
		$('input#staff_id0').blur(function(){ticket.onblur_search('staff_id0', 'id');});
		$('input#staff_id0').focus(function(){ticket.onfocus_search('staff_id0', 'id');});
		
		$('input#client_name0').simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
			autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
			identifier: 'client_name', updateElem:'client_id0'}, //clientNCallback);
			function(param, elID){
				$("input#"+elID).val( param[0] );	});
		
		$('input#client_id0').simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
			autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
			identifier: 'client_id', updateElem:'client_name0'}, //clientIDCallback);
			function(param, elID){$("input#"+elID).val( param[1] +' '+param[2] );});
		
		$('input#staff_name0').simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
			autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
			identifier: 'staff_name', updateElem:'staff_id0'},
			function(param, elID){$("input#"+elID).val( param[0] );});
		
		$('input#staff_id0').simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
			autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
			identifier: 'staff_id', updateElem:'staff_name0'},
			function(param, elID){$("input#"+elID).val( param[1] +' '+param[2] );});
		
		$("input#addfile").click(function() {
			if ($("div#filediv").children().length > 6) return;
			$("input#inpfile0").clone().each(function() {
				var time_sel = $(this).attr('name');
				var inpvar = $(this).attr('name');
				var inpvarid = $(this).attr('id');
				$(this).attr('id', '' );
				$(this).val('');
			}).appendTo("div#filediv");
	
		});
		
		$("input#addstaff").click(function() {
			if ($("table#staff tr").length > 5) return;
			var endtime = $('table#staff tr:last select:eq(1)').val();
	
			$("table#staff tr:last").clone().find("input").each(function() {
				var inpvar = $(this).attr('name');
				var inpvarid = $(this).attr('id');
				
				var id1 = inpvarid.substr(0, inpvarid.length-1);
				var id2 = inpvarid.substr(inpvarid.length-1)
				var sufx = parseInt(id2)+ 1;
				var newid = id1 + sufx;
				
				$(this).attr('id', newid );
				$(this).val('');//.attr('id', function(_, id) { return id + i });
		
				$(this).blur(function(){class_ticket.onblur_search(newid, newid);});
				$(this).focus(function(){class_ticket.onfocus_search(newid, newid);});
				
				if(id1 == 'staff_name') {
					$(this).simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
						autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
						identifier: id1, updateElem: 'staff_id'+sufx}, //clientIDCallback);
						function(param, elID){$("input#"+elID).val( param[0] );	});
				} else {
					$(this).simpleAutoComplete('/portal/ticketmgmt/autocomplete_query.php',{
					autoCompleteClassName: 'autocomplete',	selectedClassName: 'sel', attrCallBack: 'rel',
					identifier: id1, updateElem: 'staff_name'+sufx}, //clientIDCallback);
					function(param, elID){$("input#"+elID).val( param[1] +' '+param[2] );});
				}
			}).end().appendTo("table#staff");
		});
    };
	
	ticket.onblur_search = function(id, str) {
		var inp_search = $('input#'+id);
		inp_search.css('color','#666');
		
		if(inp_search.val() == '') inp_search.val('Search '+str+'...');
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
	
	ticket.refresh_page = function(activeTab) {
		//var date_select = $('select#date_select').val();
		//var time_select = $('select#time_select').val();
		//if(!date_select || !time_select) return;
		$.ajax({
			type: "POST",
			url: "?/loadtab/"+activeTab.substr(1, activeTab.length),
			data: {},
			dataType: "json",
			success: function(data){
				//seminar.populate_table(data, 'process_filter');
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
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
	ticket.retrieve_files = function(id) {
		$('span#task-status').empty().append('The file uploaded successfully!').show().fadeOut(7000);
		$('input#inpfile').val('');
		
		$.ajax({
			type: "POST",
			url: "?/filelisting/",
			data: { 'ticket_id': id},
			dataType: "json",
			success: function(data){
				ticket.populate_files(data);
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
		
	}
	
	ticket.retrieve_comm = function(type, id) {
		//$('span#task-status').empty().append('The file uploaded successfully!').show().fadeOut(7000);
		//$('input#inpfile').val('');
		
		$.ajax({
			type: "POST",
			url: "?/commlisting/",
			data: { 'ticket_id': id, 'comm_type':type},
			dataType: "json",
			success: function(data){
				var tbl = $('table#'+type);
				tbl.find("tr:gt(0)").remove();
				for(var i = 0; i < data.length; i++) {
					var row = data[i];
					tbl.find('tbody').append("<tr>"+
					"<td class='item'>"+row.date+"</a></td><td class='item'>"+row.time+"</td>"+
					"<td class='form2' style='border-top: 1px solid #ddd;'>"+row.content+"</td><td class='item'>"+row.sender+"</td></tr>");
				}
				
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
		
	}
	
	
	ticket.populate_files = function(data) {
		var tbl = $('table#files');
		tbl.find("tr:gt(0)").remove();
					
		var bgcolor = new Array('#d0d8e8', '#e9edf4');
		var rowbg = '';
					
		if(data.length == 0) {
			tbl.find('tbody').append("<tr bgcolor='#e9edf4'><td colspan='2'>No record found!</td></tr>");
			return;
		}
		
		for(var i = 0; i < data.length; i++) {
			var file_row = data[i];
			//rowbg = bgcolor[i % 2];
			
			//var userid = ticket_info.userid;
			//if( parseInt(book_info.userid) > 0) {
			//	userid = "<a href='/available-staff-resume.php?userid="+userid+"' target='_blank'>"+userid+"</a>";			
			//}
			tbl.find('tbody').append("<tr>"+
				"<td class='form2'><a href='/portal/ticketmgmt/"+file_row.filepath+"' target='_blank'>"+file_row.fname+"</a></td>"+
				"<td class='form1'>"+file_row.date+"</td></tr>");
		}
	};
	
	ticket.fileUpload = function() {
		
		// this is just an example of checking file extensions
		// if you do not need extension checking, remove 
		// everything down to line
		// upload_field.form.submit();
		//var upload_field = document.ticketform.inpfile;
		//var upload_field = $('input#inpfile');
	
		var re_text = /\.txt|\.xml|\.zip/i;
		//var filename = upload_field.value;
		//var filename = upload_field.val();
	
		/* Checking file type */
		/*if (filename.search(re_text) == -1)
		{
			alert("File does not have text(txt, xml, zip) extension");
			upload_field.form.reset();
			return false;
		}*/
		
		//upload_field.clone().appendTo("form#uploadform");;
	   //var copy = upload_field.cloneNode(1);
		//document.uploadform.appendChild(copy);
	   ////document.uploadform.logo = upload_field;
	   //alert(filename+':'+document.uploadform.inpfile);
	   
		//var clone = upload_field.clone();
		//clone.attr('id', 'field2');
		//$("form#uploadform").html(clone);
		alert(document.uploadform.inpfile.value);

	
	   document.uploadform.submit();// upload_field.form.submit();
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

	ticket.tooltip = function() {
		$("tbody#tbody_list tr td").find('span').hover(
			function (e) {						
				var mouseX = e.pageX + 10; 
				var mouseY = e.pageY - 15;
				
				var id = $(this).attr('id');

				var info = $(this).data("Data");

				$(this).append("<div class='hover_box' style='width:auto;height:auto;position:absolute'>"+info+"</div>");
				$('div.hover_box').css({'top':y+'px','left':x+'px'}).show();	
			},
			function (e) {$('div.hover_box').remove();});
	};
		
	ticket.tick_untickAll = function(chkall) {
		var tickbox = document.casesform['tick[]'];
		for(var i=0; i < tickbox.length; i++){
			if( tickbox[i].disabled ) continue;
			tick = 1;
			if ( chkall.checked && !tickbox[i].checked )
					tickbox[i].checked = true;
			else if( !chkall.checked && tickbox[i].checked )
					tickbox[i].checked = false;
			else tick = 0;
			
			var row = document.getElementById('row'+tickbox[i].value);
	
		}
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
		var tbl = $('table#logtbl');
		tbl.find("tr:gt(0)").remove();
		
		var bgcolor = new Array('#d0d8e8', '#e9edf4');
		
		logs.animate({'height': 'toggle'},
			function(){
				if( logs.is(':visible') ) {
					$.ajax({
						type: "POST",
						url: "?/historylist/",
						data: { 'ticket_id': id}, dataType: "json",
						success: function(data){
							for(var i = 0; i < data.length; i++) {
								var log_info = data[i];
								rowbg = bgcolor[i % 2];
								tbl.find('tbody').append("<tr bgcolor='"+rowbg+"'>"+
									"<td class='item'>"+log_info.date_updated+"</td>"+
									"<td class='item'>"+log_info.admin_fname+"</td>"+
									"<td class='item'>"+log_info.field_update+"</td></tr>");
							}
							$(window).scrollTop($(window).height()+500);
						}, error: function(XMLHttpRequest, textStatus, errorThrown){
							alert(textStatus + " (" + errorThrown + ")");
						}
					});
					
					logs.show();
					$(window).scrollTop($(window).height()+500);
					$('a#showhide').text('Hide');
					
				} else {
					logs.hide();
					$('a#showhide').text('Show');
				}
			});
	};
	ticket.animate_close = function() {
		$('div#mainbox').animate({'height': 'toggle'},
			function(){$(this).hide();
		});
	};
	return ticket;
})();
