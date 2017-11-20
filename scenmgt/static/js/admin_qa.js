(function($){
	ccqa.allow_edit = false;
	admin_qa = (function(){
		var del_handler = function(el) {
			return function(e) {
				var qid = el.closest('td').attr('id').split('-')[1];
				var qno = el.closest('tr').children('.number').text();
				if(confirm("Do you want to delete question "+qno+" and its response?")) {
					var cid = $('input#concern_id').val();
					if($('form#delqform').length == 0) {
						$('body').append($('<form/>')
										 .attr({'id':'delqform','method':'post','action':'/portal/scenmgt/?/delete_question','target':'ajaxframe'})
										 .append($('<input/>').attr({'type':'hidden','name':'question_id'}).val(qid))
										 .append($('<input/>').attr({'type':'hidden','name':'concern_id'}).val(cid))
										 );
					} else {
						$('form#delqform input[name=question_id]').val(qid);
						$('form#delqform input[name=concern_id]').val(cid);
					}
					$('form#delqform').submit();
					e.preventDefault();
				}
			}
		},
		
		edit_handler = function(el){
			return function(e){
				var qid = el.closest('td').attr('id').split('-')[1];
				$('div.show_concern').jqm({ajax:'?/get_question/'+qid}).jqmShow();
				admin_qa.showQuestionResponseEdit(qid);
				e.stopPropagation(); 
			}
			
		},
		select_handler = function(aid, unselect){
			return function(e){
				//var aid = el.closest('tr').attr('id').split('-')[1];
				unselect = (typeof unselect !== 'undefined') ? unselect : false;
				
				var qid = $('input#question_id').val();
				var leads_id = $('#ifcontent').length > 0 ? $('#ifcontent')[0].contentWindow.leads_id : 0;
				console.log('response:'+aid+' - '+qid);
				var action_str = unselect ? 'unselect' : 'select';
				
				if(confirm("Do you want to "+action_str+" this as the client response?")) {
					if($('form#selrform').length == 0) {
						$('body').append($('<form/>')
										 .attr({'id':'selrform','method':'post','action':'/portal/scenmgt/?/select_response','target':'ajaxframe'})
										 .append($('<input/>').attr({'type':'hidden','name':'answer_id'}).val(aid))
										 .append($('<input/>').attr({'type':'hidden','name':'cc_id'}).val(ccqa.params.cci))
										 .append($('<input/>').attr({'type':'hidden','name':'question_id'}).val(qid))
										 .append($('<input/>').attr({'type':'hidden','name':'leads_id'}).val(leads_id))
										 .append($('<input/>').attr({'type':'hidden','name':'unselect'}).val(unselect))
										 );
					} else {
						$('form#selrform input[name=answer_id]').val(aid);
						$('form#selrform input[name=cc_id]').val(ccqa.params.cci);
						$('form#selrform input[name=question_id]').val(qid);
						$('form#selrform input[name=leads_id]').val(leads_id);
						$('form#selrform input[name=unselect]').val(unselect);
					}
					$('form#selrform').submit();
					e.preventDefault();
				}
				e.stopPropagation();
			}
			
		};
		
	    return {
			
		    endResult:function() {
				//$('div.show_files').jqmHide();
				//$('#ifcontent').reload();
				document.getElementById('ifcontent').contentDocument.location.reload(true);
			    $('#loading').hide();
				$('div.new_concern').jqmHide();
	        },
			
			showClientName:function(str) {
				$('#client_name').text(str);
			},
			/*getQuestion:function() {
				$.getJSON('?/get_question/'+id,{}, function(data) {
				});
			},*/
			
			showQuestionResponseEdit:function(id) {
				$('#loading').show();
				console.log('showQuestionResponseEdit');
				
				$.getJSON('?/get_question_response/'+id, function(answers) {
					
					var atbl = $("table#aetbl");// tbody tr:eq(0)");
					//atbl.find('tr').not(':first').not(':last').remove();
					//var lasttr = $('table#qtbl tbody tr:eq(0)').html();
					console.log('edit...');
					
					//var answers = data['a'];
					//console.log(answers);
					for(var k in answers) {
						if( answers.hasOwnProperty(k)) {
							atbl.find('tr:last').after($('<tr/>').attr('id','ans-edit-'+k).css('background','#ADC09F')
							//atbl.find('tr:last').after($('<tr/>').css('background','#ADC09F')
								  .append($('<td/>').addClass('number').text('A'+k))
								  .append($('<td/>').addClass('response')
										  .append($('<textarea/>').attr({'rows':'2','name':'resp-edit-'+k})
												  .css({'width':'99%'})
												  .val(answers[k]['answer']))
										  //.text(answers[k]['answer'])
										  )
								  );
							
							
							var fup_q = answers[k]['followupq'];
							//console.log('ID:'+fup_q[0]['id']);
							if(fup_q[0]['id'] == null) {
								continue;
							}
							for(var i=0,len=fup_q.length; i<len; i++) {
								//console.log(fup_q[i]['fup_q']);
								$('tr#ans-edit-'+k).after($('<tr/>').css('background','#ffc')
								  .append($('<td/>').addClass('number').css('text-align','right').html('&#8594;'))
								  .append($('<td/>')
										  .append($('<textarea/>').attr({'rows':'2','name':'fup-'+fup_q[i]['id']})
												  .css({'width':'99%'})
												  .val(fup_q[i]['fup_q']))
										  //.text(fup_q[i]['fup_q'])
										  )
								  );
							}
						}
					}
					//admin_qa.onclickResponse();
				});
				
				//$('#loading').hide();
				//$('textarea[name=new_q]').val('');
				$('textarea[name=new_a]').val('');
				//$('button#new_q_btn').attr('disabled', false);
				$('button#new_a_btn').attr('disabled', false);
				/*lasttr.before($('<tr/>')
						  .append($('<td/>').addClass('number').text(''))
						  .append($('<td/>').attr('id','newtda')
								  .append('q*:')
								  .append($('<input/>').attr({'type':'text', 'name':'new_fupq'})
										  .addClass('ui-state-highlight addf'))
								  .append('&nbsp;')
								  .append($('<button/>').addClass('inputbtn').text('add'))
								  )						
						  );*/
				//$('div.new_concern').jqm({ajax:'?/show_form/'+leads_id}).jqmShow();
				console.log($(document).height());
				console.log($('#ccqa').height());
				return false;
			},
			
			showConcernQuestions:function(id, admin) {
				$('#loading').show();
				$('input#concern_id').val(id);
				//console.log('show concern:'+id);
				admin = (typeof admin !== 'undefined') ? admin : 1;
				
				var atbl = $("table#atbl");
				if(atbl.find('tr').length > 2)
					atbl.find('tr:gt(1)').remove();
				
				//console.log('admin:'+admin);
				
				//create text input for adding question
				$('#newq_holder').empty().append(admin_qa.create_input_fld('newq_inp', 'Add question here...', 'new_q', true));
				
				$.getJSON('?/get_client_concern/'+id,{}, function(data) {
					
					var qtbl = $("table#qtbl");// tbody tr:eq(0)");
					//qtbl.find('tr').not(':first').not(':last').remove();
					
					
					
					//console.log('>>>'+data['can-edit']);
					ccqa.allow_edit = data['can-edit'];
					$('#content_title').text(data['concern_title']);
					if($('#concern_title').length) $('#concern_title').text(data['concern_title']);
					
					//if( allow_edit )
						qtbl.find('tr:gt(1)').remove();
					/*else {
						qtbl.find('tr:gt(0)').remove();
						$("table#atbl").find('tr:eq(1)').remove();
					}*/
					
					var questions = data['q'];
					
					for(var i=0,len=questions.length; i<len; i++) {
						var ctr = i+1;
						qtbl.find('tr:last')
						.after($('<tr/>')
							  .append($('<td/>').addClass('number').text('Q'+ctr)
									  .css({'background': function(){
										return questions[i]['id'] !== ccqa.params.qid ? '#7a9512' : '#abccdd';
										}, 'color':'#fff'}))
							  .append($('<td/>').attr('id','q-'+questions[i]['id'])
									  .addClass('questions')
									  .css({'background': function(){
										return questions[i]['id'] === ccqa.params.qid ? '#abccdd' : '';
										}, 'color':'#666'})
									  .append($('<span/>').addClass('question-span')
											  .html(questions[i]['question_text'].replace(/\\/g, ''))
											))
							  );
					}
					
					admin_qa.onclickQuestion();
					
					$('input[name=newq_inp]').attr('disabled',false);
					
					///---------
					if( ccqa.allow_edit ) {
					$(function() {
							
						$("td.questions").hover(
						function (e) {
						//var iconstat = $(this).data("Data").iconstat;
							//$(this).addClass('ui-state-hover');
							//$(this).css({'background-color':'#eee'});
							//--var left = e.pageX ;//- $(this).offset().left + 10;
							//--var top = e.pageY ;//- $(this).offset().top - 20;
							$(this).append($('<div/>').addClass('hover_edit').css({'float':'right','padding':'0 2px'})
										   .append($('<a/>').attr({'href':'#','title':'Edit question'}).css('color','#0073EA').text('edit')
												   .click(edit_handler($(this))
													)).append('&nbsp;|&nbsp;')
										   .append($('<a/>').attr({'href':'#','title':'Delete question'}).css('color','#f00').text('del')
												   .click(del_handler($(this))
														  ))
										   );
							/*$(this).append("<div style='float:right;padding:0 2px'><table width='100%'><tr><td width='90' valign='top'>"+(_chat.userLabel(info))+
								"<br/>"+info.email+"<br/>"+info.contactno+"</td>"+
								"<td id='user-pix' width='60'><img src='"+HOST+"/portal/livechat/image_view.php?photo="+info.image+"&w=60'/></td></tr></table></div>");
								$('div.hover_boxinfo').css({'top':top,'left':left}).delay(900).show(0);*/
						},
						function (e) {
						   /*var iconstat = $(this).data("Data").iconstat;
							$(this).css({'background':'', 'background-image':'url(/livechat/images/'+iconstat+'.png)',
							'background-repeat':'no-repeat', 'background-position':'left'});*/
							//$(this).css({'background-color':''});
							//$(this).removeClass('ui-state-hover');
							$('div.hover_edit').remove();
						});
					});
					}
					
					//-------
				});
				
				
				
				
				$('#loading').hide();
				//$('textarea[name=new_q]').val('');
				//$('textarea[name=new_a]').val('');
				//---$('button#new_q_btn').attr('disabled', false);
				
				$('td.add-q').click(function(){
					admin_qa.btnaddq_event();
				});
				//$('button#new_a_btn').attr('disabled', false);
				/*lasttr.before($('<tr/>')
						  .append($('<td/>').addClass('number').text(''))
						  .append($('<td/>').attr('id','newtda')
								  .append('q*:')
								  .append($('<input/>').attr({'type':'text', 'name':'new_fupq'})
										  .addClass('ui-state-highlight addf'))
								  .append('&nbsp;')
								  .append($('<button/>').addClass('inputbtn').text('add'))
								  )						
						  );*/
				//$('div.new_concern').jqm({ajax:'?/show_form/'+leads_id}).jqmShow();
				console.log($('#ccqa').height());
				return false;
			},
			
			showQuestionResponse:function(id) {
				var leads_id = $('#ifcontent').length > 0 ? $('#ifcontent')[0].contentWindow.leads_id : 0;
				//console.log('client input:'+ccqa.params.cci);
				
				//console.log('leads:'+leads_id);
				$('input#question_id').val(id);
				$('#loading').show();
				// create input text for adding response
				//console.log($('#newa_holder').children().length);
				//if($('#newa_holder').children().length==0)
				$('#newa_holder').empty().append(admin_qa.create_input_fld('newa_inp', 'Add response here...', 'new_a'));
				
				$.getJSON('?/get_question_response/'+id+'/&leads_id='+leads_id, function(answers) {
					
					var atbl = $("table#atbl");// tbody tr:eq(0)");
					//atbl.find('tr').not(':first').not(':last').remove();
					//if( allow_edit )
						atbl.find('tr:gt(1)').remove();
					/*else
						atbl.find('tr:gt(0)').remove();*/
					//var lasttr = $('table#qtbl tbody tr:eq(0)').html();
					//console.log(firsttr.html());
					
					//var answers = data['a'];
					
					var ctr = 0;
					for(var k in answers) {
						if( answers.hasOwnProperty(k)) {
							atbl.find('tr:last')
							.after($('<tr/>').attr('id','ans-'+k)
								   .addClass(function(){
									return k !== ccqa.params.resp ? 'answers' : 'selected-resp';
									})
								   .css('background', function(){
									return k !== ccqa.params.resp ? '#ADC09F' : '#abccdd';
									})
								   .append($('<td/>').addClass('number').text('R'+(++ctr)))
								   .append($('<td/>').addClass('response').attr('id','select-'+k)
										   .html(answers[k]['answer'].replace(/\\/g, '')))
								   );
							
							if( parseInt(ccqa.params.cci) !== 0 && parseInt(ccqa.params.resp) === 0) {
								$('td#select-'+k)
								.append($('<div/>')
										.addClass('hover_select').css({'float':'right','padding':'0 2px'})
										.append($('<a/>').attr({'href':'#','title':'Select response'}).css('color','#0073EA').text('select')
												.click(select_handler(k))
												//.click(select_handler($('td#select-'+k)))
												));
							} else {
								console.log($('tr.selected-resp').length);
								if( $('tr.selected-resp').length > 0 && $('div.hover_select').length == 0) {
									$('tr.selected-resp')
										.append($('<div/>')
												.addClass('hover_select').css({'float':'right','padding':'2px'})
												.append($('<a/>').attr({'href':'#','title':'Unselect response'}).css('color','#0073EA').text('unselect')
														.click(select_handler(k, true))
														//.click(function() {alert("Sorry, can't process as of the moment.");})
														));
								}
							}
							
							var fup_q = answers[k]['followupq'];
							//console.log(fup_q[0]['id']);
							if(fup_q[0]['id'] == null) continue;
							for(var i=0,len=fup_q.length; i<len; i++) {
								//console.log(fup_q[i]['fup_q']);
								$('tr#ans-'+k).after($('<tr/>').css('background','#ffc')
								  .append($('<td/>').addClass('number').css('text-align','right').html('&#8594;'))
								  .append($('<td/>').text(fup_q[i]['fup_q'].replace(/\\/g, '')))
								  );
							}
						}
						
					}
					
					var aRespHeader =$('#resp-header').text().split(' ');
					//console.log(aRespHeader+':'+aRespHeader.length);
					if(aRespHeader.length > 3) {
						aRespHeader.pop();
						$('#resp-header').empty().append(aRespHeader.join(' '));
					}
					$('#resp-header').append(' ('+ctr+')');
					
					if( ccqa.allow_edit ) {
						$('td.response').css('cursor','pointer');
						admin_qa.onclickResponse();
					}
					
					// allow selection of response in client input concern
					
				});
				
				$('#loading').hide();
				//$('textarea[name=new_q]').val('');
				//$('textarea[name=new_a]').val('');
				//$('button#new_q_btn').attr('disabled', false);
				//---$('button#new_a_btn').attr('disabled', false);
				$('td.add-a').click(function(){
					admin_qa.btnadda_event();
				});
				
				
				//$('div.new_concern').jqm({ajax:'?/show_form/'+leads_id}).jqmShow();
				//console.log($(document).height());
				//console.log('ccqa height:'+$('#ccqa').height());
				return false;
			},
			
			onclickQuestion:function() {
				$('td.questions').click(function(){
					var qid = $(this).attr('id').split('-');
					var id = qid[qid.length-1];
					var qctr = $(this).prev('td').text();
					
					$('#resp-header').html('&nbsp;'+qctr+' Possible Response');
					
					$('td.questions').removeClass('set-active'); //reset background
					$(this).addClass('set-active'); //set to active
					
					//$('#qctr').text(qctr);
					if($('button#new_a_btn').attr('disabled'))
						$('button#new_a_btn').attr('disabled', false);
					admin_qa.showQuestionResponse(id);
					//$.getJSON('?/get_question_response/'+id, function(data){
					//});
				});
			},
			
			onclickResponse:function() {
				$('td.response').click(function(){
					//console.log('test: '+$('tr#tr_newans').length);
					var tr = $(this).closest('tr');
					var trid = tr.attr('id');
					
					
					var tr_newans = $('tr#tr_newans_'+trid);
					
					if( tr_newans.length > 0) {
						tr_newans.is(':visible') ? tr_newans.hide() : tr_newans.show();
						//$('textarea[name=new_fupq]').focus();
					} else {
					
						tr.after($('<tr/>').attr('id', 'tr_newans_'+trid)
								  .append($('<td/>').addClass('number').css('text-align','right').html('&#8594;'))
								  .append($('<td/>').attr('id','newtda')
										  .append('q*:')
										  .append($('<textarea/>').attr({'rows':'2', 'name':'new_q'})
												  .addClass('ui-state-highlight addf'))
										  .append('&nbsp;')
										  .append($('<button/>').attr({'id':'add_fupq', 'type':'button'}).addClass('inputbtn').text('add'))
										  )					
								  );
					
						//$('textarea[name=new_fupq]').focus();
						$('button#add_fupq').click(function(e){
							var inp_text = $(this).prev('textarea').val();
							if($.trim(inp_text) == "") return;
							var cid = $('input#concern_id').val();
							var aid = $(this).closest('tr').attr('id').split('-');
							if($('form#aform input[name=concern_id]').length == 0)
								$('form#aform').append($('<input/>').attr({'type':'hidden','name':'concern_id'}).val(cid));
								
							$('form#aform').append($('<input/>').attr({'type':'hidden','name':'answer_id'}).val(aid[aid.length-1]));
							$('form#aform').attr('action','?/add_question');
							
							$(this).attr('disabled', true);
							$('#loading').show();
							$('form#aform').submit();
						});
					}
					$('textarea[name=new_q]').focus();
				});
			},
			
			showClientConcern:function(cid) {
				//console.log('show concern:'+cid);
				$('div.show_concern').jqm({ajax:'?/show_concern/'+cid}).jqmShow();
			},
			
			reset_aform:function(){
				$('form#aform input[name=answer_id]').remove();
				$('form#aform').attr('action','?/add_answer');
			},
			create_textarea_fld:function(inp_name, blur_value, texta_name) {
				return fld =
					$('<textarea/>').attr({'rows':'2', 'name':texta_name})
							.addClass('ui-state-highlight add-inp').val('')
							.blur(function(){
								if( $.trim($(this).val()) === '')
									$(this).replaceWith(admin_qa.create_input_fld(inp_name, blur_value, texta_name) );
							});
				//var textA = $('textarea[name='+texta_name+']');
				//console.log(textA.attr('rows')+':'+texta_name);
				//textA[0].focus();
			},
			
			create_input_fld:function(inp_name, blur_value, texta_name, disabled) {
				disabled = typeof disabled !== 'undefined' ? disabled : false;
				return fld =
					$('<input/>').attr({'type':'text', 'name':inp_name, 'disabled':disabled})
								.addClass('ui-state-highlight add-inp')
								.val(blur_value).css('color','#666')
								.blur(function() {
									$(this).css('color','#666');
									if($(this).val() === '') $(this).val(blur_value);
									return true;
								}).focus(function() {
									$(this).replaceWith( admin_qa.create_textarea_fld(inp_name, blur_value, texta_name) );
									$('textarea[name='+texta_name+']').focus();
								});
			},
			
			btnaddq_event:function(){
				//console.log('btnaddq_event');
				var question_inp = $('textarea[name=new_q]').val();
				if($.trim(question_inp) == "" || typeof question_inp === 'undefined') return;
				//$(this).attr('disabled', true);
				$('td.add-q').unbind('click');
				$('#loading').show();
				$('form#qform').submit();
			},
			btnadda_event:function(){
				console.log('btnadda_event');
				var answer_inp = $('textarea[name=new_a]').val();
				if($.trim(answer_inp) == "" || typeof answer_inp === 'undefined') return;
				//$(this).attr('disabled', true);
				$('td.add-a').unbind('click');
				$('#loading').show();
				$('form#aform').submit();
			}
		}
	}());
	$(document).ready(function(){
		$('#loading').ajaxStart(function() {
			$(this).show();
		}).ajaxStop(function() {
			$(this).hide();
		});
		 
		$('button#new_a_btn').attr('disabled', true);
		$('button#btn_yes').click(function(){
			$(this).attr('disabled', true);
			$('#loading').show();
			$('form#qform').submit();			
		});
		
		$('.jqmClose').click(function(){
				$('div.show_files').jqmHide();
		});
				
			//$('.show_addconcern').jqm({ajax: '@href', trigger: 'a#addconcern'});
			//$('.show_addconcern').jqm({overlay: 50, 'modal':true, trigger: 'a#addconcern'});

		$('a#add_close').click(function(){
			$('.show_addconcern').jqmHide();
		});
				
		
		/*$('td.response').click(function(){
			console.log('test: '+$('tr#tr_newans').length);
			var trid = $(this).attr('id');
			var tr = $(this).closest('tr');
				
			if( $('tr#tr_newans_'+trid).length > 0) return;
			
			tr.after($('<tr/>').attr('id', 'tr_newans_'+trid)
					  .append($('<td/>').addClass('number').css('text-align','right').html('&#8594;'))
					  .append($('<td/>').attr('id','newtda')
							  .append('q*:')
							  .append($('<input/>').attr({'type':'text', 'name':'new_fupq'})
									  .addClass('ui-state-highlight addf'))
							  .append('&nbsp;')
							  .append($('<button/>').addClass('inputbtn').text('add'))
							  )						
					  );
		});*/
		
		/*$('td.add-q').click(function(){
			var question_inp = $('textarea[name=new_q]').val();
			if($.trim(question_inp) == "" || typeof question_inp === 'undefined') return;
			
			$(this).attr('disabled', true);
			$('#loading').show();
			$('form#qform').submit();
		});
		
		$('td.add-a').click(function(){
				var answer_inp = $('textarea[name=new_a]').val();
				if($.trim(answer_inp) == "" || typeof answer_inp === 'undefined') return;
				//var cid = $('input#concern_id').val();
				//console.log('newa:'+cid);
				//$('form#aform').append($('<input/>').attr({'type':'hidden','name':'concern_id'}).val(cid));
				$(this).attr('disabled', true);
				$('#loading').show();
				$('form#aform').submit();
		});*/
				
		$('button#updatequestion').click(function(){
			//var question_inp = $('textarea[name=new_q]').val();
			//if($.trim(question_inp) == "") return;
			console.log($('form#qeform input#question_id').val());
			//$('form#qeform input#question_id').val(id);
			$(this).attr('disabled', true);
			$('#loading').show();
			$('form#qeform').submit();
		});
		//admin_qa.init_input_q();
		//admin_qa.init_input_a();
		//$('#newq_holder').append(admin_qa.create_input_fld('newq_inp', 'Add question here...', 'new_q'));
		//$('#newa_holder').append(admin_qa.create_input_fld('newa_inp', 'Add response here...', 'new_a'));
		//console.log('texta:'+ $('textarea[name=new_q]').length );
		//admin_qa.init_input(newa_inp, 'Add response here...');
		
		/*create_newq_input(
						  append input -> focus -> replacewith( create_newq_texta() ));
		
		create_newq_texta( append_textarea ->focus -> replacewith( create_newq_input() ) );
		
		newq_inp.
			focus(function(){
			$(this).replaceWith($('<textarea/>').attr({'rows':'2', 'name':'new_q'})
								.addClass('ui-state-highlight add-inp').focus()
								);
		});*/
		
		/*$('input[name=newq_inp]').val('Add question here...')
		.add($('input[name=newa_inp]').val('Add Response here...'))
		.css('color','#666')
		.blur(function() {
			$(this).css('color','#666');
			if($(this).val() == '') $(this).val('Search...');
			return true;
		}).focus(function() {
			if($(this).val() == 'Search...') $(this).val('');
			else $(this).select();
		});
		$('input[name=newa_inp]').val('Add Response here...').css('color','#666');*/
				//window.frames['myIFrame'].document.getElementById('myIFrameElemId')
				//var selectuser = window.frames['']document.getElementsByName("selectUser[]");
	});
})(jQuery);
