(function($){
	Subcon = (function(){
		
		postJSON = function(url, data, callback) {
			return $.ajax({
				'type': 'POST',
				'url': url,
				'contentType': 'application/json',
				'data': JSON.stringify(data),
				'dataType': 'json',
				'success': callback
			});
		};
		
		

		//sortJsonArrayByProperty(results, 'attributes.OBJECTID');
		
		var data_result,
		sort_dir = -1, //default to ascending
		admin_logged,
		init_post_data,
		_data = {
			sortJsonByProperty : function(objArr, prop, sort_dir){
				if (arguments.length<2) throw new Error("Requires 2 arguments");
				if (objArr && objArr.constructor===Array){
					var propPath = (prop.constructor===Array) ? prop : prop.split(".");
					objArr.sort(function(a,b){
						for (var p in propPath){
							if (a[propPath[p]] && b[propPath[p]]){
								a = a[propPath[p]];
								b = b[propPath[p]];
							}
						}
						// convert numeric strings to integers
						a = a.match(/^\d+$/) ? +a : a;
						b = b.match(/^\d+$/) ? +b : b;
						return ( (a < b) ? -1*sort_dir : ((a > b) ? 1*sort_dir : 0) );
					});
				}
			},
			populate : function(data, fields, number) {
				number = (typeof number !== 'undefined') ? number : 0;
				
				$('#discontbody').find("tr:gt(0)").remove();
				
				for( var i=0, len=data.length; i<len; i++ ) {
					var res = data[i];
					$('#discontbody').append( $('<tr/>').attr('id','row'+i) );
					
					if(number)
						$('tr#row'+i).append( $('<td/>').addClass('number').text( eval('res.'+fields[0]) ) );
					
					for( var j=number; j<fields.length; j++) {
						$('tr#row'+i).append( $('<td/>').attr({'scope':'col'}).text( eval('res.'+fields[j]) ) );
					}
				}
				
				var csro_name = $("select[name=csro] option:selected").text();
				$('#repcnt').text(data.length);
				$('#repcsro').text(csro_name);
			}
		},
		
		_table = {
			csro_listing : function(data) {
				if(data.error) {
					// try to transfer session
					window.location = '/portal/invoice/django_admin_redirect.php?redirect1=/portal/django/admin_subcon_management/session_transfer/&redirect2=/portal/subcon_management/rssc_reports.html';
					return;
				}
				
				for( var i=0, len=data.result.length-1; i<len; i++ ) {
					var res = data.result[i];
					$('select[name=csro]').append( $('<option/>').val(res.csro_id).text(res.fname+' '+res.lname) );
				}
				admin_logged = data.result[i];
				$("select[name=csro] option[value="+admin_logged.admin_id+"]").attr("selected","selected");
				
				init_post_data.params.push(admin_logged.admin_id); //csro default
				Subcon.jsonrpc_request(init_post_data, init_post_data.method);
			},
			
			get_improper_finish_work : function(data) {
				if(data.error) {
					// try to transfer session
					window.location = '/portal/tools/workflow_django_session_transfer.php?redirect1=/portal/django/admin_subcon_management/session_transfer/&redirect2=/portal/subcon_management/rssc_reports.html';
					alert(data.error.message);
					return;
				}
				var fields = ['timestamp','staff_name', 'email', 'userid', 'skype_id', 'notify_type'];
				$('#content').empty()
				.append( $('<div/>').attr('id','tabular')
						.append( $('<table/>').attr( {'summary':'SubconListing', 'id':'disconnected'} )
								.append( $('<tbody/>').attr('id','discontbody')
									.append( $('<tr/>')
											.append( $('<th/>').attr({'scope':'col', 'class':'data'}).css('width','15%').append($('<span/>').addClass('hidden').text('dataname') ) )
											.append( $('<th/>').attr({'scope':'col','title':'Sort Names'}).css({'width':'20%','cursor':'pointer'}).text('Name')
													.click(function(){
														data_result = data.result;
														sort_dir = sort_dir<0 ? 1 : -1;
														_data.sortJsonByProperty(data_result, 'staff_name', sort_dir);
														_data.populate(data_result, fields, 1);
														}) )
											.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Email') )
											.append( $('<th/>').attr({'scope':'col'}).text('UserID') )
											.append( $('<th/>').attr({'scope':'col'}).css('width','17%').text('Skype') )
											.append( $('<th/>').attr({'scope':'col'}).text('Reason') )
									)
								)
						)
					);
				_data.populate(data.result, fields, 1);
			},
			
			get_low_bandwidth : function(data) {
				if(data.error) {
					alert(data.error.message);
					return;
				}
				
				var fields = ['timestamp','staff_name', 'email', 'userid', 'skype_id', 'direction', 'rate'];
				$('#content').empty()
				.append( $('<div/>').attr('id','tabular')
						.append( $('<table/>').attr( {'summary':'SubconListing', 'id':'disconnected'} )
								.append( $('<tbody/>').attr('id','discontbody')
									.append( $('<tr/>')
											.append( $('<th/>').attr({'scope':'col', 'class':'data'}).css('width','15%').append($('<span/>').addClass('hidden').text('dataname') ) )
											//.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Name') )
											.append( $('<th/>').attr({'scope':'col','title':'Sort Names'}).css({'width':'20%','cursor':'pointer'}).text('Name')
													.click(function(){
														data_result = data.result;
														sort_dir = sort_dir<0 ? 1 : -1;
														_data.sortJsonByProperty(data_result, 'staff_name', sort_dir);
														_data.populate(data_result, fields, 1);
														}) )
											.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Email') )
											.append( $('<th/>').attr({'scope':'col'}).text('UserID') )
											.append( $('<th/>').attr({'scope':'col'}).css('width','17%').text('Skype') )
											.append( $('<th/>').attr({'scope':'col'}).text('Direction') )
											.append( $('<th/>').attr({'scope':'col'}).text('Speed mbps') )
									)
								)
						)
					);
				_data.populate(data.result, fields, 1);
				
			},
			get_intermittent : function(data) {
				if(data.error) {
					alert(data.error.message);
					return;
				}
				
				var fields = ['staff_name', 'email', 'userid', 'skype_id', 'direction', 'rate'];
				
				$('#content').empty()
				.append( $('<div/>').attr('id','tabular')
						.append( $('<table/>').attr( {'summary':'SubconListing', 'id':'disconnected'} )
								.append( $('<tbody/>').attr('id','discontbody')
									.append( $('<tr/>')
											//.append( $('<th/>').attr({'scope':'col', 'class':'data'}).append($('<span/>').addClass('hidden').text('dataname') ) )
											.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Name') )
											.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Email') )
											.append( $('<th/>').attr({'scope':'col'}).text('UserID') )
											.append( $('<th/>').attr({'scope':'col'}).css('width','17%').text('Skype') )
											.append( $('<th/>').attr({'scope':'col'}).css('width','15%').text('Connection') )
									)
								)
						)
					);
				
				for( var i=0, len=data.result.length; i<len; i++ ) {
					var res = data.result[i];
					$('#discontbody').append( $('<tr/>')
										.append( $('<td/>').addClass('number').text(res[0]) )
										.append( $('<td/>').attr({'scope':'col'}).text(res[1]) )
										.append( $('<td/>').attr({'scope':'col'}).text(res[2]) )
										.append( $('<td/>').attr({'scope':'col'}).text(res[3]) )
										.append( $('<td/>').attr({'scope':'col', 'id':'inter'+res[2]}) )
									);
					for( var j=0, cnt=res[4].length; j<cnt; j++) {
						$('td#inter'+res[2]).append( $('<div/>').text(res[4][j]));
					}
				}
				$('#repcnt').text(data.result.length);
				var csro_name = $("select[name=csro] option:selected").text();
				$('#repcsro').text(csro_name);
			},
			get_over_quick_break : function(data) {
				if(data.error) {
					alert(data.error.message);
					return;
				}
				
				var fields = ['timestamp','staff_name', 'email', 'userid', 'skype_id', 'start', 'end', 'diff'];
				$('#content').empty()
				.append( $('<div/>').attr('id','tabular')
						.append( $('<table/>').attr( {'summary':'SubconListing', 'id':'disconnected'} )
								.append( $('<tbody/>').attr('id','discontbody')
									.append( $('<tr/>')
											.append( $('<th/>').attr({'scope':'col', 'class':'data'}).append($('<span/>').addClass('hidden').text('dataname') ) )
											//.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Name') )
											.append( $('<th/>').attr({'scope':'col','title':'Sort Names'}).css({'width':'20%','cursor':'pointer'}).text('Name')
													.click(function(){
														data_result = data.result;
														sort_dir = sort_dir<0 ? 1 : -1;
														_data.sortJsonByProperty(data_result, 'staff_name', sort_dir);
														_data.populate(data_result, fields, 1);
														}) )
											.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Email') )
											.append( $('<th/>').attr({'scope':'col'}).text('UserID') )
											.append( $('<th/>').attr({'scope':'col'}).css('width','17%').text('Skype') )
											.append( $('<th/>').attr({'scope':'col'}).text('Start') )
											.append( $('<th/>').attr({'scope':'col'}).text('End') )
											.append( $('<th/>').attr({'scope':'col'}).text('Duration') )
									)
								)
						)
					);
				_data.populate(data.result, fields, 1);
			},
			get_over_lunch_break : function(data) {
				if(data.error) {
					alert(data.error.message);
					return;
				}
				
				var fields = ['timestamp','staff_name', 'email', 'userid', 'skype_id', 'start', 'end', 'diff'];
				$('#content').empty()
				.append( $('<div/>').attr('id','tabular')
						.append( $('<table/>').attr( {'summary':'SubconListing', 'id':'disconnected'} )
								.append( $('<tbody/>').attr('id','discontbody')
									.append( $('<tr/>')
											.append( $('<th/>').attr({'scope':'col', 'class':'data'}).append($('<span/>').addClass('hidden').text('dataname') ) )
											//.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Name') )
											.append( $('<th/>').attr({'scope':'col','title':'Sort Names'}).css({'width':'20%','cursor':'pointer'}).text('Name')
													.click(function(){
														data_result = data.result;
														sort_dir = sort_dir<0 ? 1 : -1;
														_data.sortJsonByProperty(data_result, 'staff_name', sort_dir);
														_data.populate(data_result, fields, 1);
														}) )
											.append( $('<th/>').attr({'scope':'col'}).css('width','20%').text('Email') )
											.append( $('<th/>').attr({'scope':'col'}).text('UserID') )
											.append( $('<th/>').attr({'scope':'col'}).css('width','17%').text('Skype') )
											.append( $('<th/>').attr({'scope':'col'}).text('Start') )
											.append( $('<th/>').attr({'scope':'col'}).text('End') )
											.append( $('<th/>').attr({'scope':'col'}).text('Duration') )
									)	
								)		
						)
					);
				_data.populate(data.result, fields, 1);
			},
			get_multiple_quick_breaks : function(data) {
				if(data.error) {
					alert(data.error.message);
					return;
				}
			
				$('#content').empty()
				.append( $('<div/>').attr('id','tabular')
						.append( $('<table/>').attr( {'summary':'SubconListing', 'id':'disconnected'} )
								.append( $('<tbody/>').attr('id','discontbody')
									.append( $('<tr/>')
											//.append( $('<th/>').attr({'scope':'col', 'class':'data'}).append($('<span/>').addClass('hidden').text('dataname') ) )
											.append( $('<th/>').attr({'scope':'col'}).text('Name') )
											.append( $('<th/>').attr({'scope':'col'}).text('Email') )
											.append( $('<th/>').attr({'scope':'col'}).text('UserID') )
											.append( $('<th/>').attr({'scope':'col'}).text('Skype') )
											.append( $('<th/>').attr({'scope':'col'}).css('width','15%').text('Quick Breaks') )
									)	
								)		
						)
					);
				
				for( var i=0, len=data.result.length; i<len; i++ ) {
					var res = data.result[i];
					$('#discontbody').append( $('<tr/>')
										.append( $('<td/>').attr({'scope':'col'}).text(res[0]) )
										.append( $('<td/>').attr({'scope':'col'}).text(res[1]) )
										.append( $('<td/>').attr({'scope':'col'}).text(res[2]) )
										.append( $('<td/>').attr({'scope':'col'}).text(res[3]) )
										.append( $('<td/>').attr({'scope':'col', 'id':'mqb'+res[2]}) )
									);
					for( var j=0, cnt=res[4].length; j<cnt; j++) {
						$('td#mqb'+res[2]).append( $('<div/>').text(res[4][j]));
					}
				}
				$('#repcnt').text(data.result.length);
				var csro_name = $("select[name=csro] option:selected").text();
				$('#repcsro').text(csro_name);
			}
		}
		
		return {
			init : function(method) {
				HOST = "http://test.remotestaff.com.au";
				URL = "/portal/django/admin_subcon_management/jsonrpc/";
				
				var now = new Date();
				var dd = now.getDate();
				var mm = now.getMonth()+1;
				var yyyy = now.getFullYear();
				var today = yyyy+'-'+mm+'-'+dd;
				
				//initial date value
				$('#from_date').val(today);
				$('#to_date').val(today);
				
				//$('#report-title').text('Improper Finish Work');
				
				$('input[name=report_id]').val('1');
				
				
				//var init_id = 'ID1';
				init_post_data = {'id':'id2', 'jsonrpc':'2.0', 'method':method, 'params': [today, today] };
				
				var getcsro_data = {'id':'id1', 'jsonrpc':'2.0', 'method':'get_csro_list', 'params': [] };
				postJSON(URL, getcsro_data, _table.csro_listing );
				
				/*var finwork_data = {'id':'id2', 'jsonrpc':'2.0', 'method':method,
							  'params': [today] };
				Subcon.jsonrpc_request(finwork_data, method);*/
				//postJSON(URL, finwork_data, eval('_table.'+method) );
				$('#datefrom').text(today);
				$('#dateto').text(today);
				
			},
			jsonrpc_request : function(data, method) {
				var m = method.split('get_')[1];
				var t = m.split('_').join(' ');
				
				$('#report-title').text(t.charAt(0).toUpperCase()+t.slice(1));
				$('input[name=report_method]').val(method);
				
				postJSON(URL, data, eval('_table.'+method) );
			},
			
			open_url : function(loc) {
				var hg = screen.availHeight * 0.8;
				win = window.open(loc, "newwindow", "toolbar=no,menubar=no,scrollbars=no,resizable=yes,location=top,status=0,screenX=0,screenY=0");
				if (win != null) {
				   if (win.opener == null) {
					  win.opener = self;
				   }
				   win.location.href = loc;
				   win.focus();
				} 
				else { 
				   self.close(); 
				}
			},
			//postJSON : postJSON,
			
			get_improper_finish_work : _table.get_improper_finish_work,
			get_low_bandwidth : _table.get_low_bandwidth
		}
	}());
	
	
	$(document).ready(function(){
		var param=/[&?]method=([^&]+)/.exec(location.search),param=param?param[1].replace(/"/g,"&quot;"):"improper_finish_work";
		Calendar.setup({inputField : "from_date", trigger: "from_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		Calendar.setup({inputField : "to_date", trigger: "to_date", onSelect: function() { this.hide()  },//showTime   : 12,
			fdow:0, dateFormat : "%Y-%m-%d"
		});
		
		$('#loading')
		.ajaxStart(function() {
			$(this).show();
			$('input#filter').attr('disabled', true);
		})
		.ajaxStop(function() {
			$(this).hide();
			$('input#filter').attr('disabled', false);
		});
		
		$('#header ul li').hover(function(){
			var child = $(this).children('div');
			if(child == null) return;
			
			var timer = child.data('timer');
			
			if(timer) clearTimeout(timer);
			child.css({'display': 'block'});
		}, function(){
			var child = $(this).children('div');
			if(child == null) return;
			
			child.data('timer', setTimeout(function(){
				child.css({'display': 'none'});//.removeClass('over');
			}, 500));
		});
		
		Subcon.init('get_'+param);
		
		$('input#filter').click(function(e) {
			var csro = $('select[name=csro]').val();
			var method = $('input[name=report_method]').val();
			var from_date = $('input[name=from_date]').val();
			var to_date = $('input[name=to_date]').val();
			var report_id = $('input[name=report_id]').val();
			var report_id = parseInt(report_id);
			var method_data = {'id':'id'+report_id, 'jsonrpc':'2.0', 'method':method,
							  'params': [from_date, to_date, csro] };
			Subcon.jsonrpc_request(method_data, method );
			//update id
			$('input[name=report_id]').val(report_id+1);
			$('#datefrom').text(from_date);
			$('#dateto').text(to_date);
			//e.preventDefault();
		});
		
	});
	
})(jQuery);