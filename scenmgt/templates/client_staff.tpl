<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title></title>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<link href="static/css/main.css" type="text/css" rel="stylesheet">
		<link href="static/css/tabs.css" type="text/css" rel="stylesheet">
		<link href="static/css/jqm.css" type="text/css" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script type='text/javascript' src='/portal/site_media/parse_document/scripts/respond.min.js'></script>
		<script src="/portal/js/jquery.js"></script>
		<script src="/portal/ticketmgmt/js/jqModal.js"></script>
		<script src="static/js/splitter.js"></script>
		<link rel="stylesheet" type="text/css" href="/portal/aclog/css/styles.css" />
		<link rel='stylesheet' type='text/css' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/smoothness/jquery-ui.css'/>
		{literal}
		<style type='text/css'>
			.ui-state-default { background-color: #88c }
.ui-state-hover { background-color: #bbf }
.ui-state-highlight { background-color: #68f }
.ui-state-error { background-color: #eaa }

.splitter-pane {
	overflow: auto;
}
.splitter-bar-vertical {
	width: 6px;
	/*background-image: url(img/vgrabber.gif);
	background-repeat: no-repeat;
	background-position: center;*/
}
.splitter-bar-vertical-docked {
	width: 10px;
	/*background-image: url(img/vdockbar-trans.gif);
	background-repeat: no-repeat;
	background-position: center;*/
}
.splitter-bar-horizontal {
	height: 6px;
	/*background-image: url(img/hgrabber.gif);
	background-repeat: no-repeat;
	background-position: center;*/
}
.splitter-bar-horizontal-docked {
	height: 10px;
	/*background-image: url(img/hdockbar-trans.gif);
	background-repeat: no-repeat;
	background-position: center;*/
}
.splitter-bar.ui-state-highlight {
	opacity: 0.7;
}
.splitter-iframe-hide {
	visibility: hidden;
}
</style>
		{/literal}
	</head>
	<body>
		<iframe id='ajaxframe' name='ajaxframe' style='display:none;' src='javascript:false;'></iframe>

		<div id="wrapper" class='ui-widget-content' style='float:left'>
			
			<div id='content-container'>
				
				<div id='leftpane'>
					<div class="ui-state-active">&nbsp; Staff Members
					<a href='#' id='add_concern' style='float:right;padding-right:6px;color:#FF0084;'>Add Concern</a>
					</div>
					<div class='contentholder' style='height:auto;width:100%;'>
						<ul class='itemlist' id='staffmember'>
							{if $staff_members|@count > 0 }
							{section name=idx loop=$staff_members}
							<li>
								<input type='checkbox' name='selstaffmember[]' value='{$staff_members[idx].userid}-{$staff_members[idx].fname} {$staff_members[idx].lname}' id='id_{$staff_members[idx].userid}'/>&nbsp;
								<label for='id_{$staff_members[idx].userid}'>
									{$staff_members[idx].fname} {$staff_members[idx].lname} [{$staff_members[idx].userid}]
								</label>
							</li>
							{/section}
							{else}
							<li value='0'>No Staff Found</li>
							{/if}
						</ul>
						
					</div>
				</div>
				
				<div id='rightpane'>
					<div class="ui-state-focus" id='concern-header'>&nbsp; Issue that concerns <span id='concern_for'>ALL staff member</span>
					<!--<a href='#' id='add_concern' style='float:right;padding-right:6px;color:#FF0084;'>View All</a>-->
					</div>
					<ul class='itemlist' id='concernlist'>
						{if $cci|@count > 0 }
							{section name=idx loop=$cci}
						<li>
							<label for='id_{$cci[idx].input_id}' style='left:0;width:100%'>
							{$smarty.section.idx.index+1}.&nbsp;	<a href='#{$cci[idx].concern_id}/&cci={$cci[idx].input_id}&resp={$cci[idx].resp}&qid={$cci[idx].qid}' class='open_concern'>
							{$cci[idx].concern_title|truncate:50:"..."}</a> <span style='float:right'>{$cci[idx].date_created}</span>
							</label>
						</li>
							{/section}
						{else}
						<li value='0'>No client concern found</li>
						{/if}
					</ul>
				</div>
			</div>
			
	
		</div>
		<!--<div class='show_concern'>Please wait...</div>-->

	</body>
	<script src="static/js/call-split-container.js"></script>
	
	<script type='text/javascript'>
	{literal}window.leads_id = {/literal}{$client_name.id};{literal}
	(function($){
		clientstaff = (function(){
			return {
				show_concern:function(el){
					var qrystr = el.attr('href').split('#')[1];
					//qrystr = url.split('/');
					console.log(qrystr);
					window.parent.scenario.showClientConcern(qrystr);
				},
				fetch_concern_data:function(url){
					$.getJSON(url, function(data) {
						$('#concernlist').empty();
						var len=data.length;
						if(len > 0) {
							for(var i=0; i<len; i++) {
							$('#concernlist')
							.append($('<li/>')
									.append($('<label/>').css({'left':'0','width':'100%'})
											.html((i+1) + '.&nbsp; ')
											.append($('<a/>')
													.attr({'href':'#'+data[i]['concern_id']+'/&cci='+data[i].input_id+'&resp='+data[i]['resp']+'&qid='+data[i]['qid']})
													.addClass('open_concern')
													.text(data[i]['concern_title'])
													.click(function(){
														clientstaff.show_concern($(this));
														}))
											.append($('<span/>').css('float','right')
													.text(data[i]['date_created']))
											));
							}
						} else {
							$('#concernlist').append($('<li/>').val(0).text('No client concern found.'));
						}
					});
				}
			}
		}());
	$(document).ready(function(){
		$('a#add_concern').click(function() {
			window.parent.scenario.showAddConcernInput({/literal}{$client_name.id}{literal}); });
												   
		$('a.open_concern').click(function() {
			clientstaff.show_concern($(this));
			/*var cid = $(this).attr('href').split('#')[1];
			console.log(cid);
			window.parent.scenario.showClientConcern(cid);*/
			});
		$('ul#staffmember li').click(function(){
			$('.itemlist li').css('background',''); 
			$(this).css('background','#7A9512');
			var uinfo = $(this).children('input').val().split('-');
			$('#concern_for').text(uinfo[1]);
			clientstaff.fetch_concern_data('?/staff_concern_input/'+uinfo[0]+'/&lead='+window.leads_id);
			/*$.getJSON('?/staff_concern_input/'+uinfo[0]+'/&lead='+window.leads_id, function(data) {
				$('#concernlist').empty();
				var len=data.length;
				if(len > 0) {
					for(var i=0; i<len; i++) {
					$('#concernlist')
					.append($('<li/>')
							.append($('<label/>').css({'left':'0','width':'100%'})
									.html((i+1) + '.&nbsp; ')
									.append($('<a/>').attr({'href':'#'+data[i]['id']})
											.addClass('open_concern')
											.text(data[i]['concern_title'])
											.click(function(){
												clientstaff.show_concern($(this));
												}))
									.append($('<span/>').css('float','right')
											.text(data[i]['date_created']))
									));
					}
				} else {
					$('#concernlist').append($('<li/>').val(0).text('No client concern found.'));
				}
			});*/
			
			var chead = $('#concern-header');
			console.log(chead.children().length);
			if(chead.children().length === 1) {
				chead.append( $('<a/>')
							 .css({'float':'right','padding-right':'6px','color':'#FF0084','cursor':'pointer'})
							 .text('view all')
							 .click(function(){
								$('#concern_for').text('ALL staff member');
								clientstaff.fetch_concern_data('?/client_concern_input/'+window.leads_id);
								/*$.getJSON('?/client_concern_input/'+window.leads_id, function(data) {
									$('#concernlist').empty();
									var len=data.length;
									if(len > 0) {
										for(var i=0; i<len; i++) {
										$('#concernlist')
										.append($('<li/>')
												.append($('<label/>').css({'left':'0','width':'100%'})
														.html((i+1) + '.&nbsp; ')
														.append($('<a/>').attr({'href':'#'+data[i]['id']})
																.addClass('open_concern')
																.text(data[i]['concern_title'])
																.click(function(){
																	clientstaff.show_concern($(this));
																	}))
														.append($('<span/>').css('float','right')
																.text(data[i]['date_created']))
														));
										}
									} else {
										$('#concernlist').append($('<li/>').val(0).text('No client concern found.'));
									}
								});*/
								chead.children('a').remove();
								}));
			}
		});
		/*$('div.show_concern').jqm({ajax: '@href', trigger: 'a#addconcern'});
		$("#content-container").splitter({			
			splitVertical: true,
			outline: true,
			sizeLeft: true,
			resizeTo: window,
			accessKey: "I"
		});*/
		{/literal}parent.window.scenario.showClientName("{$client_name.fname} {$client_name.lname}");{literal}
	});
	})(jQuery);
	{/literal}
	</script>
	
</html>
