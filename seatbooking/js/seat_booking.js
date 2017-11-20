/* seat_booking.js  - mike 2012-02-13 */

var class_seat = (function(){
	var lead_staff_codes = ['ld', 'js', 'sc', 'as'];
	
	seat_config = {'fintime_select':false};
	
	$("div#typediv input:radio").change(function(){
		var type_id = $(this).attr('id');

		if( type_id == 'addstaff') {
			$('form#mgrform input').attr('disabled', true);
			//$('input#createbutton').removeAttr('disabled');
			//$('input#cancelmgr').removeAttr('disabled');
		} else $('form#mgrform input').removeAttr('disabled');
		
		//$('input#name').attr('disabled', true);
	});
	// constructor
    var seat = function () {
		//this.update_cal();
        // private
        // public (this instance only)
		

    };
	
	
	seat.work_days = "mon,tue,wed,thu,fri"; //legal working days set to deafult

	
	
    seat.setStaffData = function(data) {
		//alert(data.fname+' '+data.lname);
		$('select#client').empty();
		if( data.length > 1 ) $('td#client_header').text('Select Client: ');
		for( var i=0; i<data.length; i++ ) {
			var client_name = data[i].fname +' '+data[i].lname;
			$('select#client').append("<option value='"+data[i].id+"'>"+client_name+"</option>");
		}
		
		return false;
    };
	
	seat.onblur_search = function(id, str) {
		var inp_search = $('input#'+id);
		inp_search.css('color','#666');
		
		if(inp_search.val() == '') inp_search.val('Search '+str+'...');
		return true;
	};
	
	seat.onfocus_search = function(id, str) {
		var inp_search = $('input#'+id);
		inp_search.css('color','');
		if(inp_search.val() == 'Search '+str+'...')
			inp_search.val('');
		else $(inp_search).select();
		return true;
	};
	
	seat.setSelected = function(selId, value) {
		$("select#"+selId+" option[value=" + value +"]").attr("selected","selected");
	};
	
	seat.bookPaymnet = function(selobj) {
		var pymnt = $(selobj).val();
		switch(pymnt) {
			case 'Free':
			case 'Paid':
				class_seat.setSelected('status', 'Confirmed');
				break;
			case 'TBP':
				class_seat.setSelected('status', 'Pending');
				break;
		}

	};
	
	seat.bookStatus = function(selobj) {
		var bstatus = $(selobj).val();
		switch(bstatus) {
			case 'Pending':
				class_seat.setSelected('payment', 'TBP');
				break;
			case 'Confirmed':
				class_seat.setSelected('payment', 'Paid');
				break;
		}
	};
	
	seat.checkBookHours = function(selobj) {
		
		if( $(selobj).attr('id') == 'finish_time' && !seat_config.fintime_select) {
			seat_config.fintime_select = true;
		} else if( !seat_config.fintime_select) {
			return;
		} 
		var start_time = parseInt($('select#start_time').val());
		var finish_time = parseInt($('select#finish_time').val());

		/*if( start_time > finish_time ) {
			alert('Invalid selection of booking hours.');
			return;
		}*/
		
		/*var seat_id = $('input#seat_id').val();
		$.ajax({
			type: "POST",
			url: "seat_booking.php",
			data: { 'task': 'check_time', 'seat_id': seat_id,
				'start', 'finish'},
			dataType: "json",
			success: function(data){
				class_seat.setStaffData(data);
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});*/
	};
	seat.checkBookDate = function() {
		var date_from = $('input#date_from').val();
		alert(date_from);
		var date_to = $('input#date_to').val();
	};
	
	seat.addData = function( id, book_info ){
		alert(id+' - '+book_info['fname']);
		$("tr#"+id).data( "Data", book_info );
	};
	
	seat.client_invoice = function(x) {
		var client_id = $('select#client').val();
		if(!client_id || parseInt(client_id)==0) return;
		var btype = $('select#type').val();
		var bsched = $('select#schedule').val();
		$.ajax({
			type: "POST",
			url: "/portal/seatbooking/seatb.php?/invoice/"+client_id,
			data: { 'type': btype, 'schedule':bsched},
			dataType: "json",
			success: function(book_info){
				$('div#invoice_div').show();
				var tbl = $('table#result');
				tbl.find("tr:gt(0)").remove();
				
				if(book_info.length == 0) return;

				$('a#clientname').text(book_info[0].cfname+' '+book_info[0].clname);
				var datestr = undefined;
				var total_hrs = 0;
				for(var i = 0; i < book_info.length; i++) {
					var info = book_info[i];
					total_hrs += parseInt(info.hrs);
					if( info.cnt > 1 ) {
						datestr = info.book_date1 +' - '+ info.book_date2 +'<br/>' +info.book_start+' to '+info.book_end;
					} else {
						datestr = info.book_date1 +', ' +info.book_start+' to '+info.book_end;
					}
					tbl.find('tbody').append("<tr bgcolor='#fff'>\n"+
					"<td class='item' style='border-left: 1px solid #ddd;'><a href='seatb.php?/staff/&staff_id="+info.userid+"'>"+info.fname+" "+info.lname+"</a></td>\n"+
					"<td class='item' style='border-left: 1px solid #ddd;'>"+datestr+"</td>\n"+
					"<td class='item' style='border-left: 1px solid #ddd;'>"+info.hrs+"</td>\n"+
					"<td class='item' style='border-left: 1px solid #ddd;'>"+info.booking_type+"</td>"+
					"<td class='item' style='border-left: 1px solid #ddd;'>"+info.booking_schedule+"</td></tr>");
				}
				
				tbl.find('tbody').append("<tr style='background:#e9edf4;height:30px;font-weight:bold;'>"+
				"<td valign='middle' colspan='2'>TOTAL</td>"+
				"<td valign='middle' style='padding:5px;'>&nbsp;"+total_hrs+"</td><td></td></tr>");


			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	};
	
	//seat.filter_client = function(client, fldname, fldsearch) {
	seat.filter_client = function(client, params, fldname) {
		var client_id = client.value;
		if(!client_id) return;
		
		$.ajax({
			type: "POST",
			url: "/portal/seatbooking/seatb.php?/filter/leads_id/",
			//data: { 'id': client_id, 'fldname':fldname, 'fldsearch':fldsearch},
			data: { 'id': client_id, 'params':params},
			dataType: "json",
			success: function(data){
				var tbl = $('table#result');
				tbl.find("tr:gt(0)").remove();
				
				var currentURL = window.parent.location.href;
				//var param_array = params.split('=');
				//var fldreport = '';
				$('a#hreftab').text(seat.replaceClientID(client_id));
				
				var book_info = data.booking_info;
				var pages = data.pages;
				var pp = seat.replaceURL(data.pp['display_pages']);
				var display_pages = data.pp['display_pages'];//seat.replaceURL(data.pp['display_pages'], currentURL);
				//alert(currentURL+ '- '+display_pages);
				$('span#totalrec').empty().text(pages['items_total']);
				$('span#pages').empty().html(data.pp['display_pages']);
				$('span#itemspp').empty().html(data.pp['items_pp']);
				$('span#jumpmenu').empty().html(data.pp['jump_menu']);
				for(var i = 0; i < book_info.length; i++) {
					var info = book_info[i];
					var ctr = pages['low'] + i + 1;
					
					if(fldname == 'payment') fldreport = info.booking_payment;
					else fldreport = info.booking_status;
					
					tbl.find('tbody').append("<tr bgcolor='"+info.bgcolor+"'>\n"+
					"<td class='item'>"+ctr+"</td>\n"+
					"<td class='item'><a href='?/reports/seat/&seat_id="+info.seat_id+"'>"+info.seat_id+"</a></td>\n"+
					"<td class='item'><a href='seatb.php?/client/&leads_id="+info.id+"'>"+info.cfname+" "+info.clname+"</a></td>\n"+
					"<td class='item'><a href='seatb.php?/staff/&staff_id="+info.staff_id+"'>"+info.fname+" "+info.lname+"</a></td>\n"+
					"<td class='item'>"+info.hrs+" hrs</td>\n"+
					"<td class='item'><a href='?/reports/date/&date="+info.book_date+"'>"+info.book_date+"</a></td>\n"+
					"<td class='item'>"+fldreport+"</td></tr>");
				}


			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	};
	
	seat.navigateSeat = function(direction) {
		var seat_id = $('input#seat_id').val();
		if(seat_id == 1 && direction == 'previous') return;
		var date1 = $('input#booking_date').val();
		var date2 = $('input#booking_date2').val();
		
		$.ajax({
			type: "POST",
			url: "/portal/seatbooking/seatb.php?/get_seat_booking/",
			data: { 'move': direction, 'seat_id': seat_id, 'date':date1, 'date2':date2},
			dataType: "json",
			success: function(data){
				var sched = data.sched;
				

				$('input#seat_id').val(data.seat_id);
				var $next = $('div#parent');

				//var distance = $('div#parent').css('width');
				

				$('div#container').animate({'width': 'toggle'},
					function(){//$(this).hide();
						
					$(this).show();

					var seat_id = parseInt(data.seat_id);
					
					var ctr = 1;
					for(var i = seat_id; i < seat_id+4; i++) {
						var seatbox = $('div#child'+ctr);
						seatbox.find('p').text(i);
						
						var tbl = $('table#list'+ctr);
						
						tbl.find("tr:gt(0)").remove();
						
						if(sched[i] !== undefined){
							var total_hrs = 0;
	
							for(var j=0; j<sched[i].length; j++) {
								var book_info = sched[i][j];
								
								var booked_hrs = book_info.hrs * book_info.cnt;
								total_hrs += booked_hrs;
								if( book_info.cnt > 1 )
									var datestr = book_info.date_start +' - '+ book_info.date_end +', '+
									book_info.book_start+'-'+book_info.book_end;
								else
									var datestr = book_info.date_start +', '+book_info.book_start+' - '+book_info.book_end;
								
								tbl.find('tbody').append("<tr bgcolor='"+book_info.bgcolor+"'>"+
								"<td class='item'>"+book_info.booking_type+"</td>"+
								"<td class='item'>"+book_info.booking_status+"</td>"+
								"<td class='item'>"+book_info.booking_payment+"</td>"+
								"<td class='item'><a href='seatb.php?/staff/&staff_id="+book_info.staff_id+"'>"+
								book_info.fname+" "+book_info.lname+"</a></td>"+
								"<td class='item'><a href='seatb.php?/client/&leads_id="+book_info.leads_id+"'>"+
								book_info.cfname+" "+book_info.clname+"</a></td>"+
								"<td class='item'>"+datestr+" (<span style='color:#ff0000;'>"+booked_hrs+"</span>hrs)</td></tr>");
								
							}
							tbl.find('tbody').append("<tr bgcolor='#d0d0d0'><td class='item' colspan='5'>TOTAL</td>"+
							"<td class='item'>"+total_hrs+" hour/s</td></tr>");
						} else {
							tbl.find('tbody').append("<tr style='background:#d0d0d0;'><td colspan='6' style='color:#ff0000;'>No record found.</td></tr>");
						}
						ctr++;
					}
					});
				
				
				
				//});
				
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	};
	
	seat.daycount = function(cnt) {
		var date1 = $('input#booking_date').val();
		$('input#booking_date2').val(date1);
	};
	
	seat.replaceURL = function(text, newtext) {
		var exp = /seatb.php[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]$/ig;
		return text.replace(exp, newtext); 
	};
	
	seat.replaceClientID = function(txtid) {
		var hreftab = $('a#hreftab').text();
		var exp = /Client:[0-9]+/ig;
		return hreftab.replace(exp, 'Client:'+txtid); 
	};

	
	return seat;
})();
