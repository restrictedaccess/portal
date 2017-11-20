(function($){
	var LEADS_ID = 10;
	scenario = (function(){
	    return {
			listClients:function() {
				//$('#loading').empty().append('Loading...').show();
				$('#loading').show();
				$.getJSON('/portal/scenmgt/?/clientlist',{}, function(data) {
					//data.sort();
					//console.log(data);
					$('#selectclientlbl').text('Select Client ('+data.length+')');
					
					$('#leftpane').find("p:gt(0)").remove();
					$('#leftpane')
					.append($('<select/>')
						.attr({'id':'clientselect','size':24}).css({'width':'100%','height':'100%', 'padding':'0 8px'})
						.change(function(e){
							LEADS_ID = $(this).val();
							$('#ifcontent').attr('src', '?/staff_member/'+$(this).val() )
								e.preventDefault();
							}));
					
					
					var aData = new Array;   
					for(var key in data) {
						if(data.hasOwnProperty(key)) {
							//console.log("Key: " + key + ", Value: " + data[key].fname);
							$('#clientselect')
							//.append($('<p/>')
								.append( $('<option/>')
									.val(data[key].id).text(data[key].fname+' '+data[key].lname+' :: '+data[key].id+' ('+data[key].cnt+')')
								//)
								);
							aData.push({'id':data[key].id, 'fname':data[key].fname, 'lname':data[key].lname});
						}
					}
					
					
					// place data to autocomplete search
					$("#client_search").autocomplete(aData,
					{ formatItem: function(item) {
						return item.fname + ' ' +item.lname;
					}}).result(function(event, item) {
						$('#ifcontent').attr('src', '?/staff_member/'+item.id );
						$(this).val('');
					});
					
					
					//for(var i=0,len=data.length; i<len-1; i++) {
					
					//}

					//$('div.show_files').html(data);
					//$('#loading').hide();
					//scenario.addResult('init');
				});
			},
			
		    endResult:function() {
				//$('div.show_files').jqmHide();
				//$('#ifcontent').reload();
				document.getElementById('ifcontent').contentDocument.location.reload(true);
			    $('#loading').hide();
				$('div.new_concern').jqmHide();
	        },
			
			showClientName:function(str) {
				$('#client_name').text(str).css('font-weight','bold');
			},
			showAddConcernInput:function(leads_id) {
				console.log('show concern:'+leads_id);
				$('div.new_concern').jqm({ajax:'?/show_form/'+leads_id}).jqmShow();
			},
			
			showClientConcern:function(cid) {
				//console.log('show concern:'+'?/show_concern/'+cid+'&modal=true');
				$('div.show_concern').jqm({ajax:'?/show_concern/'+cid+'&modal=true'}).jqmShow();
			}
		}
	}());
	$(document).ready(function(){
		$('div.new_concern').jqm({trigger: false});
		$('div.show_concern').jqm({trigger: false});
		$('div.list_concern').jqm({ajax: '@href', trigger:'a#listconcerns'});
		
		$('#loading').ajaxStart(function() {
			$(this).show();
		}).ajaxStop(function() {
			$(this).hide();
		});
		
		$('aside a').click(function(e){
			//console.log($(this).attr('href'));
			$('#ifcontent').attr('src', $(this).attr('href') );
			//console.log($('#ifcontent').attr('src'));
			e.preventDefault();
		});
		
		$('#client_search').val('Search...').css('color','#666')
		.blur(function() {
			$(this).css('color','#666');
			if($(this).val() == '') $(this).val('Search...');
			return true;
		}).focus(function() {
			if($(this).val() == 'Search...') $(this).val('');
			else $(this).select();
		});
		
		scenario.listClients();
	});
})(jQuery);
