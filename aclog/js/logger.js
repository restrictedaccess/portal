(function($) {
	jQuery.noConflict();
	logger = (function(){
		var actctr = 0,
		_src,
        _handler = {
			onMessage : function(event) {
				if (event.origin.indexOf('remotestaff.com') == -1) {
					alert('Origin was not in Remotestaff domain');
					return;
				}
				var data = JSON.parse(event.data);
				_handler.add_entry(data);
				
				var ifrwin = $('#ifrtime', window.parent.document);
				ifrwin.css({'height': ifrwin.get(0).contentWindow.document.body.offsetHeight + 'px'});
				
			},
			
			add_entry : function(data ) {
				
				var _myactivity = $('table#myactivity tr:first');
				var aid = 'act-'+data.id;
				var now = new Date();
				if( $('tr#'+aid).length == 0 ) {
					if(data.activity_status!='finished') {
						actctr++;
						_handler.update_titlebar(actctr);
					}
					var time_ended = data.activity_status=='paused'?data.activity_status +' <span class="paused">(count:'+data.pausecnt+')</span>':(data.activity_status=='finished'?data.time_ended:data.activity_status);
					var task_from_date = data.task_from_date;
					var paused_task = parseInt(data.admin)>0 && task_from_date ? "  &nbsp; <a href=\"javascript:window.top.location='/portal/aclog/?item=myactivity&status=&from_date="+task_from_date+"&to_date="+task_from_date+"'\"><span class='asterisk'>*task from "+data.task_from_date+"</span></a>":'';
					_myactivity.after( $('<tr/>').attr({'id':aid})
								.append( $('<td/>').text(data.time_started) )
								//.append( $('<td/>').attr({'id':'end'+data.id}).text(data.activity_status=='finished'?data.time_ended:data.activity_status) )
								.append( $('<td/>').attr({'id':'end'+data.id}).html(time_ended) )
								.append( $('<td/>').attr({'id':'timer'+data.id}).text( data.time_diff ) )
								.append( $('<td/>').attr({'id':'last'+data.id}).text( data.last_started ) )
								.append( $('<td/>').attr({'id':'detail'+data.id}).addClass('details').html(data.activity_details + paused_task ) )
								.append( $('<td/>').text(data.category.charAt(0).toUpperCase()+data.category.slice(1) ) )
								.append( $('<td/>').attr({'id':'stat'+data.id}).html( data.activity_status=='finished'?'Finished' :
									$('<img/>').attr({'src':'images/stop1red.png', 'title':'click to finish activity'}).addClass('icon')
									.click(function(){
										$('#loading', parent.window.document).show();
										var aid = $(this).closest('tr').attr('id').split('-')[1];
										$.ajax({
											type:'POST',
											url:'?item=setstate',
											data:{'aid': aid, 'status':'finished', 'last':$('#last'+aid).text()},
											dataType:'json',
											success:function(data) {
												$('#end'+aid).text(data.time_ended);
												$('#timer'+aid).text(data.elapsed_time);
												$('#stat'+aid).empty().text('Finished');
												$('#loading', parent.window.document).hide();
												actctr--;
												_handler.update_titlebar(actctr);
											},
											error: function(XMLHttpRequest, textStatus, errorThrown){
												alert(textStatus + " (" + errorThrown + ")");
											}
										});
									} ) // add pause or play button
										.add($('<span/>').html('&nbsp;')
											.add(
												$('<span/>').attr({'id':'state'+data.id})
												.append(
													(data.activity_status=='ongoing'
													? $('<img/>').attr({'src':'images/pause.png', 'title':'click to pause activity'}).addClass('icon')
													: $('<img/>').attr({'id':'state'+data.id, 'src':'images/play.png', 'title':'click to restart activity'}).addClass('icon'))
													// determine the click event for each state
													.click(function(){
														var aid = $(this).closest('tr').attr('id').split('-')[1];
														_handler.status_event(aid, data.activity_status);
													} )
												)
											)
											
											/*.add( (data.activity_status=='ongoing'
												? $('<img/>').attr({'src':'images/pause.png', 'title':'click to pause activity'}).addClass('icon')
													
													
												: $('<img/>').attr({'id':'state'+data.id, 'src':'images/play.png', 'title':'click to resume activity'}).addClass('icon'))
												 // determine the click event for each state
												.click(function(){
													$('#loading', parent.window.document).show();
													var aid = $(this).closest('tr').attr('id').split('-')[1];
													
												} )
											)*/
											 //add( $('<img/>').attr({'src':'images/pause.png', 'title':'click to pause activity'}).addClass('icon'))
											/*.click(function(){
												$('#loading', parent.window.document).show();
												var aid = $(this).closest('tr').attr('id').split('-')[1];
												$.ajax({
													type:'POST',
													url:'?item=pause',
													data:{'aid': aid},
													dataType:'json',
													success:function(data) {
														$('#end'+aid).text(data.time_ended);
														$('#timer'+aid).text(data.elapsed_time);
														$('#stat'+aid).empty().text('Finished');
														$('#loading', parent.window.document).hide();
														actctr--;
														_handler.update_titlebar(actctr);
													},
													error: function(XMLHttpRequest, textStatus, errorThrown){
														alert(textStatus + " (" + errorThrown + ")");
													}
												});
											} )*/
										)
									)
								));
				} // update timer
				else if(data.activity_status=='ongoing') {
					$('#timer'+data.id).text(data.time_diff);
					$('#last'+data.id).text( data.last_started );
				} else if(data.activity_status=='paused' && $('#end'+data.id).text()=='ongoing') {
					$('#end'+data.id).empty().html(data.activity_status+' <span class="paused">(count:'+data.pausecnt+')</span>');
				} else {
					if($('#stat'+data.id).text() != 'Finished' && data.activity_status=='finished') {
						$('#stat'+data.id).text('Finished');
						$('#end'+data.id).text(data.time_ended);
						$('#timer'+data.id).text(data.time_diff);
						actctr--;
						_handler.update_titlebar(actctr);
					}
				}
				
				/*_myactivity.find('tbody').append("<tr>"+
					"<td>"+data.activity_started+"</td>"+
					"<td>"+data.activity_status+"</td>"+
					"<td>running time</td>"+
					"<td>"+data.activity_details+"</td>"+
					"<td>"+data.category+"</td></tr>");*/
			},
			
			status_event : function(aid, status) {
				$('#loading', parent.window.document).show();
				
				var set_status, new_img, new_title;
				if(status=='ongoing') {
					set_status = 'paused';
					
					new_img = 'play.png';
					new_title = 'click to resume activity';
					//new_state = 'pause';
				} else {
					set_status = 'ongoing';
					
					new_img = 'pause.png';
					new_title = 'click to pause activity';
					//new_state = 'ongoing';
				}
				
				$.ajax({
					type:'POST',
					url:'?item=setstate',
					data:{'aid': aid, 'status':set_status, 'last':$('#last'+aid).text()},
					dataType:'json',
					success:function(data) {
						$('td#detail'+aid+' span.paused').remove();
						var act_detail = $('#detail'+aid).text(), endtime = $('#end'+aid),
						time_ended = data.activity_status=='paused'?data.activity_status +' <span class="paused">(count:'+data.pausecnt+')</span>':(data.activity_status=='finished'?data.time_ended:data.activity_status);
						if(set_status=='paused') {
							//set_status = data.time_ended;
							if(endtime.text()=='ongoing') set_status += ' <span class="paused">(count:'+data.pausecnt+')</span>';
							//$('#detail'+aid).append(' <span class="paused">(paused)</span>');
						}
						endtime.html(set_status);
						$('#timer'+aid).text(data.time_diff);
						//$('#detail'+aid).html(act_detail);
						$('#last'+aid).text( data.last_started );
						$('#state'+aid).empty()
						.append($('<img/>').attr({'src':'images/'+new_img, 'title':new_title}).addClass('icon')
								.click(function() {
									_handler.status_event(aid, set_status);
								})
						)
						
						
						$('#loading', parent.window.document).hide();
						//actctr--;
						//_handler.update_titlebar(actctr);
					},
					error: function(XMLHttpRequest, textStatus, errorThrown){
						alert(textStatus + " (" + errorThrown + ")");
					}
				});
			},
			
			update_titlebar : function(ctr) {
				window.parent.document.title = 'Ac-Lo ('+ctr+')';
			}
		};
		
		return {
			init : function() {
				//alert(window.js_userid);
				_src = new EventSource("/portal/aclog/?item=fetchactivity");
				_src.addEventListener('message', _handler.onMessage, false);
				
				_src.addEventListener('error', function(e) {
					if (e.readyState == EventSource.CLOSED) alert("Connection closed");
				}, false);
				
				_src.addEventListener('clientdisconnect', function(e) {
					var act = $('table#myactivity tr:first').find('th').eq(4);
					act.append($('<span/>').text(' idle'));
					console.log(e.data);
					_src.close();
				}, false);
				
				window.onbeforeunload = function(){
					if(actctr > 0) return "You have unfinished activity.";
					//else return false;
				};
			},
			
			eventsrc_state : function(){ return _src.readyState;},
			
			hide_loading : function() {
				$('#loadingimg', window.parent.document).remove();
			},
			
			show_status : function(msg) {
				$('#loading', window.parent.document).fadeOut(5000);
			},
			enable_button : function(selector) {
				$(selector, window.parent.document).removeAttr('disabled');
			}
		}
	}());
	$(document).ready(function() {
		/*$('#loading').ajaxStart(function() {
			$(this).show();
		}).ajaxStop(function() {
			$(this).hide();
		});*/
		
		
		logger.init();
		
		
	});
})(jQuery);