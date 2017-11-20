<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bug Reporting</title>

<script language=javascript src="/portal/js/functions.js"></script>
<script type="text/javascript" src="/portal/js/jquery.js"></script>
<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />

<script type="text/javascript" src="/portal/bugreport/script.js"></script> 
<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>

<link rel="icon" href="/portal/favicon.ico" type="image/x-icon" />
<link rel=stylesheet type=text/css href="/portal/bugreport/css/styles.css">

<link rel=stylesheet type=text/css href="/portal/ticketmgmt/css/tabs.css">
<link rel="stylesheet" type="text/css" href="/portal/seatbooking/css/simpleAutoComplete.css" />
<script type="text/javascript" src="/portal/ticketmgmt/js/simpleAutoComplete.js"></script>

<script type="text/javascript">
<!---
jQuery.noConflict();
jQuery(document).ready(function($) {
	$(window).keydown(function(event){
		if(event.keyCode == 13 && event.target.nodeName == 'INPUT') {
		  event.preventDefault();
		  return false;
		}
	});
		
	$("form#search_form").submit(function() {
		var keyword = $('input#keyword').val();
		if (keyword ) {
			$(this).attr("action", "index.php?/view_all/");
			return true;
		} else { return false; }
    });
	$('textarea').keyup(function(e) {
        while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height()+1);
        };
    });
});

// -->
</script>
</head>
<body>
<iframe id='ajaxframe' name='ajaxframe' style='display:none;height:10px;' src='javascript:false;'></iframe>

<table cellpadding='0' cellspacing='0' border='0' width='100%'>
<tr><td valign="top" >
<img src='/portal/images/remote-staff-logo2.jpg'/>
</td>
</tr>

<tr bgcolor="#7a9512"><td style="width:23%;font:8pt verdana;height:20px;border-bottom:1px solid #7a9512;">
<div style='float:left;width:100%;color:#000;padding-top:2px;'>&#160;&#160;<b>RS - BUG REPORTING PAGE</b></div></td>
<td style="width:77%;font:8pt verdana;height:20px;border-bottom:1px solid #7a9512;">
<div style='float:left;width:100%;font: 8pt verdana;'>
  <table width="100%" border='0'>
	<tr><td align="right" style="font: 8pt verdana;">
	<?php if(!$leads):?>
	<div style="font: 8pt verdana;color:#fff;"></div>
	<?php endif;?>
	</td></tr>
</table>
</div>
</td></tr>
<tr><td style='width:100%'>
<div style='float:left;width:97%;padding:7px;'>
	<?php
	$qausers = new QAusers();
    $users = $qausers->fetchAll();
	$tester = array();
	foreach( $users as $k => $v ) {
		
		$tester[$k]['userid'] = $v['userid'];
		$tester[$k]['email'] = $v['email'];
	}
	
	$logintype = $_SESSION['logintype'];

	$diff_user = new Users( array($_SESSION['emailaddr'], $_SESSION['logintype'],0) );
	//print_r($diff_user->user_info);
	$user_array = array('email'=>$diff_user->user_info['email'], 'userid'=>$diff_user->user_info['id']);
	
	$su = $user_array['userid'] == 6 && $_SESSION['logintype'] == 'admin' ? true : false;
	
	$access_link_allowed = in_array($user_array, $tester) || $su ? true : false;

	if($logintype == 'admin' || ($logintype == 'staff' && $diff_user->user_info['leads_id'] == 11)):
		if( $view_type != 'popup' ):
	?>
	
	<form id='search_form' action='' method='post'>
		<input type='hidden' name='status' id='status' value=''/>
		<input type='hidden' name='tab' id='tab' value='<?php echo $tab;?>'/>
		<input type='hidden' name='leads_id' id='leads_id' value='<?php echo $leads;?>'/>
		<input type='hidden' name='userid' id='userid' value='<?php echo $userid?$userid:($filter['userid']?:$filter['userid']);?>'/>
	
		<div id='avseat' style="float:left;width:100%;border:1px solid #aaa;background:#ddd;">
	
	
		<div style='width:auto;padding:3px;margin-left:auto;margin-right:auto;'>
			<div class='nav main'>
				<ul>
					<?php
					echo "<li><a href='?/index'>Main</a></li>";
					echo "<li><a href='?/view_all/".$user_array['userid']."'>My Tickets</a></li>";
					echo "<li><a href='?/view_myreport/'>My Bug Report</a></li>";
						
					if( $access_link_allowed ) {
						echo "<li><a href='?/view_all'>View All</a></li>";
						echo "<li><a href='?/view_all/deleted'>Trash</a></li>";
					}
						
					// super user
					if( $su ) echo "<li><a href='?/tester'>Tester</a></li>";
						
					?>
					
					<li><a href='?/reportform'>Report a Bug</a></li>
				</ul>
			</div>
			
			
			<!--<span>Keyword:&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Case Age:&nbsp;</span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Case Type:&nbsp;</span>-->
			
			
		</div>
		<div style='float:right;width:150px;right:10px;'>
			<input type='text' class='inputbox' id='keyword' size='5' name='keyword'/>&nbsp;
			<input type='submit' class='button' value="Search" name='submit' title="Filter data"/>
		</div>
			
		</div>
	</form>
	<?php endif;
	endif;?>
</div>
</td></tr>
</table>