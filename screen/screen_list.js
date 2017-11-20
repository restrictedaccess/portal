$.noConflict();
(function($) {
	currentScrollTop = undefined;
	screc = (function() {
		return {
			tick_untickAll : function(chkall) {
				var tickbox = document.screenform['tick'];
				for(var i=0; i < tickbox.length; i++){
					if( tickbox[i].disabled ) continue;
					tick = 1;
					if ( chkall.checked && !tickbox[i].checked )
							tickbox[i].checked = true;
					else if( !chkall.checked && tickbox[i].checked )
							tickbox[i].checked = false;
					else tick = 0;			
				}
			},
			
			delScreen : function() {
				var tickbox = document.screenform['tick'];
				var email = $('input#email').val();
				var userid = $('input#userid').val();
				var token = $('input#token').val();
				var host = $('input#host').val();
				var tick = new Array();
				if(tickbox == undefined) return;
				for(var i=0; i < tickbox.length; i++){
					if ( tickbox[i].checked ) {
						tick.push(tickbox[i].value);
						//break;
					}
				}
				if(tick.length==0) return;
				if(confirm('Do you want to delete selected screen?')) {
					//$('span#task-status').empty().append('Processing...').show();
					$.ajax({
						type: "POST",
						url: "http://screen.remotestaff.net:5080/screen/screenmanage.jsp",
						data: { 'email': email, 'id':tick.join(','), 'userid':userid, 'token':token,'host':host,'action':'delete'},
						dataType: "json",
						success: function(data){
						//$('span#task-status').hide();
							//$(window).scrollTop($(window).height()+500);
							screc.getData();
						}, error: function(XMLHttpRequest, textStatus, errorThrown){
							alert(textStatus + " (" + errorThrown + ")");
						}
					});
				}
			},
			
			
			getData : function() {
				$.support.cors = true;
				var email = $('input#email').val();
				var userid = $('input#userid').val();
				var token = $('input#token').val();
				var host = $('input#host').val();
				$.ajax({
					type: "GET",
					url: "http://screen.remotestaff.net:5080/screen/screenlist.jsp",
					data: { 'email': email, 'userid':userid, 'token':token, 'host':host},
					dataType: "json",
					success: function(data){
						$('span#totalresult').text(data.length);
						screc.populate_table(data);
						var helpifr = '<iframe src="'+host+'/portal/screen/helper_iframe.php?height='
							+ $(document).height()+'" style="display:none"></iframe>';
						$('body').append(helpifr);
					}, error: function(XMLHttpRequest, textStatus, errorThrown){
						alert(textStatus + " (" + errorThrown + ")");
					}
				});
			},
			
			populate_table : function(data) {
				var tbl = $('table#screen_list');
				tbl.find("tr:gt(0)").remove();
				var bgcolor = new Array('#d0d8e8', '#e9edf4');
				var slink = "http://screen.remotestaff.net:5080/screen/viewer.jsp?file=";
				for(var i = 0; i < data.length; i++) {
					var screen_info = data[i];
					rowbg = bgcolor[i % 2];
					//var user_info = data[i].user_info;
					var taglink = ((screen_info.tags==null)?"<a href='javascript:void(0);' class='taglink' onclick=\"screc.showTag("+screen_info.id+",'"+screen_info.file+"',0);\">add tag</a>":
								screen_info.tags+" (<a href='javascript:void(0);' class='taglink' onclick=\"screc.showTag("+screen_info.id+",'"+screen_info.file+"',1);\">edit</a>)");
										
					tbl.find('tbody').append("<tr bgcolor='"+rowbg+"'>"+
						"<td class='item'><input type='checkbox' name='tick' value='"+screen_info.id+"'/></td>"+
						"<td class='item'><a href='"+slink+screen_info.file+"' target='_blank'>"+slink+screen_info.file+"</td>"+
						"<td class='item'>"+((screen_info.uploaded==null)?'n/a':screen_info.uploaded)+"</td>"+
						"<td class='item'>"+((screen_info.duration==null)?'n/a':screen_info.duration)+"</td>"+
						"<td>"+taglink+"</td></tr>");
					//"<td class='item'><a href='javascript:void(0);' onclick=\"screc.show_modal('"+screen_info.id+"');\">"+((screen_info.tags==null)?'add tag':screen_info.tags)+"</a></td></tr>");
					}
			},
			
			showTag : function(link_id, filename, pulltag) {
				var email = $('input#email').val();
				var userid = $('input#userid').val();
				var token = $('input#token').val();
				var host = $('input#host').val();
				$('input#link_id').val(link_id);
				$('input#link_file').val(filename);
				$('.jqmWindow').jqmShow();
				$(window).scrollTop(0);
				$('input#tags_content').val('');
				if( pulltag == 1 ) {
					$.ajax({
						type: "POST",
						url: "http://screen.remotestaff.net:5080/screen/screenmanage.jsp",
						data: { 'email': email, 'id':link_id, 'action':'gettag', 'userid':userid, 'token':token, 'host':host},
						dataType: "json",
						success: function(data){
							$('input#tags_content').val(data.tags);
				
						}, error: function(XMLHttpRequest, textStatus, errorThrown){
							alert(textStatus + " (" + errorThrown + ")");
						}
					});
				}
			},
			
			setTag : function() {
				var id = $('input#link_id').val();
				var filename = $('input#link_file').val();
				var tag = $('input#tags_content').val();
				var email = $('input#email').val();
				var userid = $('input#userid').val();
				var token = $('input#token').val();
				var host = $('input#host').val();
				if( tag == "") {
					alert("Please enter value in tag/description box!")
					return;
				}
				$.ajax({
					type: "POST",
					url: "http://screen.remotestaff.net:5080/screen/screenmanage.jsp",
					data: { 'email': email, 'id':id, 'action':'addtag', 'tag':tag, 'file':filename, 'userid':userid, 'token':token,'host':host},
					dataType: "json",
					success: function(data){
						//$('span#task-status').hide();
						$('.jqmWindow').jqmHide();
						//document.location.reload(true);
						screc.getData();
			
					}, error: function(XMLHttpRequest, textStatus, errorThrown){
						alert(textStatus + " (" + errorThrown + ")");
					}
				});
			}
	
		}
	}());
	$(document).ready(function() {
		$('#loading').ajaxStart(function() {
			$(this).show();
		}).ajaxStop(function() {
			$(this).hide();
		});
		//screc.getData();
	});
})(jQuery);
