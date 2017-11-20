(function($) {	
	test = (function() {
		var _handler = {
			check_inputs : function() {
				var email = false;
				var fname = false;
				if($('ul#selectedtest li').length > 0) {
					$('form#testform  input[name^="emailaddr\\[\\]"]').each(function() {
						if($(this).val() != '') {
							email = true;
							return;
						}
					});
					
					$('form#testform  input[name^="fname\\[\\]"]').each(function() {
						if($(this).val() != '') {
							fname = true;
							return;
						}
					});
				}
				return ( email && fname );
			}
		}
		
		return {
			fetch_testlist : function(cat) {
				$.ajax({
					type: 'POST',
					url:'index.php',
					data:{'item':'testlist', 'cat':cat},
					dataType:'json',
					success: function(data){
						var bgcolor = new Array('#E0E5F0', '#e9edf4');
						var testlist = $('ul#listfromcat');
						testlist.empty();
						for(var i = 0; i < data.length; i++) {
							var test_info = data[i];
							rowbg = bgcolor[i % 2];
										
							testlist.append("<li style='background-color:"+rowbg
									+"' id='test"+test_info.assessment_id+"' value='"+test_info.assessment_id+"'>"+test_info.assessment_title+"</li>");
						}
						$('ul#listfromcat li').dblclick(function(e){
							
							var createbtn = $('button#createsession');
							
							var assess_id = $(this).attr('value');
							var test_name = $(this).text();
							if($('li#sel'+assess_id).length == 0) {
								$('ul#selectedtest').append("<li id='sel"+assess_id+"' value='"+assess_id+"'>"+test_name+"</li>");
								
								$('form#testform').append( $('<input/>').attr({'type': 'hidden', 'name': 'test_id[]', 'value': assess_id, 'id':'test'+assess_id}) );
								
								$(this).hide();
								
								if(_handler.check_inputs()) createbtn.removeAttr('disabled');
								else createbtn.attr('disabled', true);
								
								$('li#sel'+assess_id).dblclick(function(){
									var testselected = $('li#test'+assess_id);
									if(testselected.length > 0) testselected.show();
									
									// remove from selected list
									$(this).remove();
									// remove input from the form
									$("form#testform input[type=hidden]").each(function() {
										if($(this).val() == assess_id) {
											$(this).remove();
											return;
										}
									});
									
									if(_handler.check_inputs()) createbtn.removeAttr('disabled');
									else createbtn.attr('disabled', true);
								});
								
								
								
								e.preventDefault();
							}
						});
						
						if($(window).scrollTop() > $('.testholder').offset().top)
							$(window).scrollTop($('.testholder').offset().top);
						
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert(textStatus + " (" + errorThrown + ")");
					}
				});
			},
			
			
			add_emailfield : function() {
				if ($('#testform table tr').length > 10) return;
				var createbtn = $('button#createsession');
				var new_inp = $("#testform table:last").clone();
				//var emailfld = $(this).attr('name');
				new_inp.find('input').each(function(){
					$(this).val('');
					if( $(this).attr('name') == "emailaddr\\[\\]") {
						$(this).keyup(function(event){
							if(_handler.check_inputs()) createbtn.removeAttr('disabled');
							else createbtn.attr('disabled', true);
						});
					}
				}).end().appendTo('#testform table');
				
			},
			
			confirm_details : function() {
				$('#dialog').jqmShow();
				var name_arr = new Array();
				$('ul#selectedtest li').each(function(){
					name_arr.push($(this).text());	
				});
				$('#div_testname').empty().append( name_arr.join('<br/>') );//<br/>' + $(this).text());
				
				var email_arr = new Array();
				$("form#testform input[type=text]").each(function() {
					if($(this).val() != '') email_arr.push($(this).val());
				});
				$('#div_emailaddr').empty().append( email_arr.join('<br/>') );
			},
			check_inputs : function() { return _handler.check_inputs();},
			hide_loading : function() {
				window.location.href='/portal/test_admin/';
			},
			errormsg : function(msg) {
				alert(msg);
				$('#loading').hide();
				$('#dialog button').removeAttr('disabled');
				$('#dialog').jqmHide();
				return false;
			}
			
		}
	}());
	
	$(document).ready(function() {
		$('#loading').ajaxStart(function() {
			$(this).show();
		}).ajaxStop(function() {
			$(this).hide();
		});
		$("div.category li").click(function() {
			var activeLink = $(this).find("a").attr("href").split('#')[1];
			var activeTitle = $(this).find("a").text();
			$('span#testname').text('('+activeTitle+')');
			test.fetch_testlist(activeLink);
		});
		
		$('a#addemail').click(function(){
			test.add_emailfield();
		});
		
		var createbtn = $('button#createsession');
		// disable first create button
		createbtn.attr('disabled', true);
		// reset email field
		$('form#testform input').val('');
		// check email input
		$('form#testform input[name^="emailaddr\\[\\]"]').keyup(function(event){
			if(test.check_inputs()) createbtn.removeAttr('disabled');
			else createbtn.attr('disabled', true);
		});
		
		$('form#testform input[name^="fname\\[\\]"]').keyup(function(event){
			if(test.check_inputs()) createbtn.removeAttr('disabled');
			else createbtn.attr('disabled', true);
		});
		
		createbtn.click(function(){test.confirm_details();});
		
		$('button#btn_yes').click(function(){
			$('form#testform input[type=text]').each(function() {
				if($(this).val() == '') {
					$(this).closest('tr').remove();
				}
			});
			$('#dialog button').attr('disabled', true);
			$('#loading').show();
			$('form#testform').submit();
		});
		
		$('.confirmWindow').jqm({overlay: 50, modal: true, trigger: false});
	});
})(jQuery);