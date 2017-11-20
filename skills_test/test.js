
jQuery().ready(function($){		
	$('#loading').ajaxStart(function() {
		$(this).show();
	}).ajaxStop(function() {
		$(this).hide();
	});
	
	$("div.category li").click(function() {	
		var activeLink = $(this).find("a").attr("href").split('#')[1];
		var activeTitle = $(this).find("a").text();
		var val = $(this).val();
		$.ajax({
			type: 'GET',
			url:'?/get_test/',
			data:{'cat':activeLink},
			dataType:'json',
			success: function(data){
				var bgcolor = new Array('#E0E5F0', '#e9edf4');
				var tbl = $('table#selected_test');
				tbl.find("tr:gt(0)").remove();
				for(var i = 0; i < data.length; i++) {
					var test_info = data[i];
					rowbg = bgcolor[i % 2];
								
					tbl.find('tbody').append("<tr bgcolor='"+rowbg+"'>"+
						"<td class='item'>"+(i+1)+"</td>"+
						"<td class='item'>"+test_info.assessment_category+"</td>"+
						"<td class='item'><a href='#"+test_info.assessment_id+"'>"+test_info.assessment_title+"</a></td></tr>");
				}
				$('td.item a').click(function(e){
					var assess_id = $(this).attr("href").split('#')[1];
					var test_name = $(this).text();
					showStartTest(assess_id, test_name);
					e.preventDefault();
				});
				if($(window).scrollTop() > $('#testholder').offset().top)
					$(window).scrollTop($('#testholder').offset().top);
				
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	});
	
	/*$(document).scroll(function() {
		var currentScrollTop = $(this).scrollTop();
		if (currentScrollTop > prevScrollTop) {
			//down
			var lasthiddenbox = $('.fadeboxhidden:last');
			//console.log(' scroll: ' + currentScrollTop+'  boxtop:'+boxtop);
			var nextbox = (lasthiddenbox.length > 0) ? lasthiddenbox.next('.fadebox') : $('.fadebox:first');
			
			if( boxtop < currentScrollTop ) {
				$('div#positionlist').addClass('categoryfixed');
			}     
		} else {
			//up
			//console.log(' scroll: ' + currentScrollTop+'  boxtop:'+boxtop);
			if( boxtop > currentScrollTop ) {
				$('div#positionlist').removeClass('categoryfixed');
			}
		}
		prevScrollTop = currentScrollTop ;
	});*/
	
	$('button').keyup(function(event){
		if(event.keyCode == 13){
			switch( $(this).attr('id') ) {
				case 'btn_yes':
					alert('Please click on the button.');
					break;
				case 'btn_no':
					alert('no');
					$('#dialog').jqmHide();
					break;
			}
			
			//$("#id_of_button").click();
		}
	});
	
	$('button#btn_no').click(function(){
		$('#dialog').jqmHide();
	});
	
	$('button#btn_yes').click(function(){
		var aid = $('span#aid').text()
		, referer_url = $('#referer_url')
		$('#dialog').jqmHide();
		
		$.ajax({
			type: 'GET',
			url:'?/request_session/'+aid+'/',
			data:{'noredirect':noredirect},
			dataType:'json',
			success: function(data){
				if(data.error) {
					alert(data.error.Value?data.error.Value:data.error);
					return;
				}
				if(referer_url.length > 0) {
					if(window.opener != undefined) {
						var redirect_url = referer_url.attr('title');
						redirect_url+='&assessment_url='+data.result;
						window.opener.document.location.href=redirect_url;
					} else window.location.href=document.URL+'?assessment_url='+data.result;
					self.close();	
				} else {
				$('body').append( $('<form/>').attr({'action': '?/start_assessment/', 'method': 'post', 'id': 'begin_test'})
								.append( $('<input/>').attr({'type': 'hidden', 'name': 'assessment_url', 'value': data.result}) ) )
							.find('#begin_test').submit();
				}
				
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	});
	
	//create an object to hold a list of box top locations
	//var boxtops = new Object;
	//track whether user has scrolled up or down
	var prevScrollTop = $(document).scrollTop();
	
	//gather all boxes and store their top location
	//--var boxtop = $('div#category').offset().top;
	
	$('#catlisthead').click(function() {
		var currclass = $(this).attr('class').split(' ')[1];
		$(this).removeClass( currclass ).addClass(
			function() {
				if(currclass=='collapse') {
					$('#catlist ul').animate({'height': 'toggle'},
						function(){$(this).hide();});
					return 'expand';
				} else {
					$('#catlist ul').animate({'height': 'toggle'},
						function(){$(this).show();});
					return 'collapse';
				}
			});
	});
	
	$('#postlisthead').click(function() {
		var currclass = $(this).attr('class').split(' ')[1];
		$(this).removeClass( currclass ).addClass(
			function() {
				if(currclass=='collapse') {
					
					$('#postlist ul').animate({'height': 'toggle'},
						function(){$(this).hide();});
					$('#postlist .subtitle').hide();
					return 'expand';
				} else {
					$('#postlist .subtitle').show();
					$('#postlist ul').animate({'height': 'toggle'},
						function(){$(this).show();});
					return 'collapse';
				}
			});
	});
	
	$('.jqmWindow').jqm({overlay: 50, modal: true, trigger: false});

	
});

function showStartTest(id, testname) {
	$('span#aid').text(id);
	$('span#testname').text(testname);
	$('#dialog').jqmShow();
}