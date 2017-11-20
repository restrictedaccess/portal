window.timepicker = new Array;
window.clicked = undefined;
(function($) {
	dorep = (function(){
		return {
			remove_edit : function(divid) {
				$('#'+divid).remove();
				window.clicked.unbind('click');
				window.clicked = undefined;
			},
			send_newtime : function(aid, newtime) {
				$('#loading', parent.window.document).show();
				$.ajax({
					type:'POST',
					url:'?item=timeedit',
					data:{'aid': aid, 'time':newtime},
					dataType:'json',
					success:function(data) {
						if(data.time_ended) $('#endtime'+aid).text(data.time_ended);						
						
						$('#loading', parent.window.document).hide();
						//actctr--;
						//_handler.update_titlebar(actctr);
					},
					error: function(XMLHttpRequest, textStatus, errorThrown){
						alert(textStatus + " (" + errorThrown + ")");
					}
				});
			},
			restart : function(aid, item) {
				item = (typeof item !== 'undefined') ? item : 'restart';
				$('#loading', parent.window.document).show();
				$.ajax({
					type:'POST',
					url:'?item='+item,
					data:{'aid': aid, 'status': 'ongoing'},
					dataType:'json',
					success:function(data) {				
						if(data == null || data.time_ended != undefined) {
							$('#row'+aid).hide();
						}
						$('#loading', parent.window.document).hide();
					},
					error: function(XMLHttpRequest, textStatus, errorThrown){
						alert(textStatus + " (" + errorThrown + ")");
					}
				});
			}
		}
	}());
	
	jQuery.noConflict();
	$(document).ready(function() {
		$('table#myactivity tr td').find('input').click(function(){
			
			var tdname = $(this).attr('name');
			var cell = $(this).closest('td');
			var divid = tdname+'tp';
			var elapsed_time = $(this).val().split(':');
			if($('#'+divid).length > 0 || window.clicked != undefined) return;
			
			//if(window.timepicker != undefined) 
			window.clicked = tdname;
			//window.timepicker.push(tdname);
			//console.log(window.clicked);
			window.clicked = $('body').click(function(evt) {
				//console.log($('#'+tdname+'tp').length)
				if($('#'+tdname+'tp').length == 0) return;
				var p = $(evt.target).parent().attr('id');
				var c = $(evt.target).attr('id');
				var parentlen = $(evt.target).parents('#'+tdname+'tp').length;
				
				//console.log('hide:'+p+' '+c+' = '+tdname+' > '+$(evt.target).parents('#'+tdname+'tp').length);
				//if((c != tdname) && (p!=divid && c!=divid) ) {
				if((c != tdname) && (c!=divid && parentlen == 0) ) {
					//for(var i=0; i<window.timepicker.length; i++) {
						//console.log(window.timepicker[i]+'tp-remove');
					$('#'+divid).remove();
					//	window.timepicker.splice(i, 1);
					//}
					$(this).unbind('click');
					window.clicked = undefined;
				}
			});
			
			cell.append( $('<div/>').attr({'id':tdname+'tp'}).addClass('timepicker')
						.append( $('<select/>').attr({'id':tdname+'hour'}) )
						.append( $('<select/>').attr({'id':tdname+'minute'}) )
						.append( $('<select/>').attr({'id':tdname+'second'}) )
						.append( $('<button/>').attr({'id':tdname+'cancel'}).text('cancel')
								.focus()
								.click(function(){
									dorep.remove_edit(divid);
								} ))
						.append( $('<button/>').attr({'id':tdname+'done'}).text('update')
								.click(function(e) {
									var hour = $('#'+tdname+'hour').find(':selected').text();
									var minute = $('#'+tdname+'minute').find(':selected').text();
									var second = $('#'+tdname+'second').find(':selected').text();
									$('input[name='+tdname+']').val(hour+':'+minute+':'+second);
									dorep.remove_edit(divid);
									dorep.send_newtime(tdname.split('tdinp')[1], hour+':'+minute+':'+second);
									e.preventDefault();
								}))
					);
			
			for(var i=0; i<24; i++) {
				var numstr = i > 9 ? i : '0' + i.toString();
				$('#'+tdname+'hour').append( "<option>"+numstr+"</option>");
			}
			
			for(var i=0; i<60; i++) {
				var numstr = i > 9 ? i : '0' + i.toString();
				$('#'+tdname+'minute').append( "<option>"+numstr+"</option>");
			}
			
			for(var i=0; i<60; i++) {
				var numstr = i > 9 ? i : '0' + i.toString();
				$('#'+tdname+'second').append( "<option>"+numstr+"</option>");
			}
			
			$('#'+tdname+'hour').val(elapsed_time[0]);
			$('#'+tdname+'minute').val(elapsed_time[1]);
			$('#'+tdname+'second').val(elapsed_time[2]);
		
		});
		
		$('#summaryreport').click(function() {
			//var reportform = $('#filter', window.parent.document);
			window.parent.rep.filterReport(1);
			//reportform.submit();
		});
	});
})(jQuery);