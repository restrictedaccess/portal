{* $Id: seat_booking.tpl 2012-02-10 mike  $ *}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Seat Booking</title>
    <link rel=stylesheet type=text/css href="./css/seat_styles.css">
	<link rel=stylesheet type=text/css href="./css/styles_global.css">
	<link rel="stylesheet" type="text/css" href="./css/activecalendar.css" />
	<link rel=stylesheet type=text/css href="./css/overlay.css">

    <script type="text/javascript" src="/portal/js/jquery.js"></script>
	<script type="text/javascript" src="js/seat_booking.js"></script>
	<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
	<script type="text/javascript" src="/portal/js/tooltip.js"></script>
	
	<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
	<script type="text/javascript" src="/portal/js/lang/en.js"></script>
	<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
	<link rel="stylesheet" type="text/css" href="css/simpleAutoComplete.css" />
	<script type="text/javascript" src="js/simpleAutoComplete.js"></script>
<style type='text/css'>
<!--
{literal}
.rad
{
	height:20px;
	width:50px;
}
body {overflow:hidden}
	
.month_tbl {
    width:98%;
    border:#solid 1px #ff0000;
    font-size:12px;font-family:helvetica;
}
.month_tbl td {
	height:10px;
   /*  height:15px;
   background-color:#fff;*/
}
#tblocks td {
   border:1px solid #aaa;
}
#month_tbl input[disabled="true"] {
	color:#ff0000;
	background:#692;
}
.set_steps {padding:6px;text-align:left;}
.set_steps span.header {font-weight:bold;text-decoration:underline;}
{/literal}
-->
</style>
<script type='text/javascript'>
<!--///
{literal}
var back_link = parent.window.document.getElementById('back_link');

//back_link.style.fontSize = '14px';
//back_link.innerHTML = 'Back';

$(document).ready(function() {
	Calendar.setup({inputField : "date_from", trigger : "bd", onSelect : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0, dateFormat : "%Y-%m-%d"
    });
	Calendar.setup({inputField : "date_to", trigger:  "bd2", onSelect : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0, dateFormat : "%Y-%m-%d"
    });
	
	//$('input#cancelbutton').bind('click', function(){history.go(-1);})
	
	class_seat.onblur_search('staff', 'staff');
	$('input#staff').focus(function(){class_seat.onfocus_search('staff', 'staff');});
	
	
	$('input#staff').simpleAutoComplete('autocomplete_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'staff'
	    }, staffCallback);
	
	function staffCallback( param )
	{
	  $("input#staff_id").val( param[0] );
	  //$("input#work_email").val( param[1] );
	  
	  $.ajax({
			type: "POST",
			url: "seat_booking.php",
			data: { 'task': 'get_client', 'userid': param[0] },
			dataType: "json",
			success: function(data){
				class_seat.setStaffData(data);
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	}
});
{/literal}
//-->
</script>
</head>
<body><span id='task-status'></span>
	<iframe id='ajaxframe' name='ajaxframe' style='display:none;' src='javascript:false;'></iframe>
    <!-- Insert your content here -->
    {*<div id='task-status' style='display:none;'>status</div>
	0) 2012-02-20, 12pm to 5pm (5) - <span style='color:#696'>Success</span><br/>
    1) 2012-02-21, 12pm to 5pm (5) - <span style='color:#696'>Success</span><br/>
    2) 2012-02-22, 12pm to 5pm (5) - <span style='color:#696'>Success</span>
	*}
	<h3><strong>SEAT #{$seat}</strong> - Quick Book</h3>
	{*<a href='?item=monhr' {if $item eq 'monhr'}class='here'{/if}>Back</a>*}
	{*<form name='regform' method='POST' action='as_staff.php' style='padding:0px;'>*}
	<div id='box-result' class='overlay'> <div> <b>BOOKING RESULT</b><br/>
	<div id='result-data' style='padding:5px 20px 5px 20px;border:none;'></div>
	<br/>
	<span style='float:left;border-top:1px solid #aaa;width:100%;text-align:center'>
	<input type='button' name='submit' value='&nbsp; OK &nbsp;' onclick='reloadPage();' /></span></div> </div>
	{* end of booking result *}

	<div style='float:left;width:96%;padding:2px;'>
		<div id='calendar' style='float:left;width:100%;padding-left:10px;'>{$calendar}</div>
	</div>
	<div style='float:left;width:96%;padding:3px;border:1px solid #011a39;'>
		<form name='regform' method='POST' target='ajaxframe' action='seat_booking.php' style='padding:0px;'>
			
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			  <tr><td class='form1' width='22%'>Booking For: </td><td class='form2'>
			  <input type="text" id="staff" name="staff" class="inputbox2" onblur="class_seat.onblur_search('staff', 'staff');">
			  </td></tr>
			  <tr><td class='form1' id='client_header'>Client Name: </td><td class='form2'>
			  <select class='inputbox2' name='client' id='client'></select></td></tr>
			  
			  <tr><td class='form1'>Date of Booking </td><td class='form2'>
			  <span>From:</span><input type="text" id="date_from" name="date_from" class="inputbox2" style="width:100px;" onchange="class_seat.checkBookDate();"/> <img align="absmiddle" src="/portal/images/calendar_ico.png" id="bd" style="cursor: pointer; " onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''"/> &nbsp;
			  <span>to:</span><input type="text" id="date_to" name="date_to" class="inputbox2" readonly style="width:100px;"/> <img align="absmiddle" src="/portal/images/calendar_ico.png" id="bd2" style="cursor: pointer; " onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''"/></td></tr>
			  <tr><td class='form2' colspan='2' style='padding-left:70px;'>
			  Start Time: &nbsp;<select name="start_time" id="start_time" onChange="class_seat.checkBookHours(this);" class="inputbox2">
				  <option value="0">-</option>
				  {section name=idx loop=$time_sel_value}
					{if $time_sel_value[idx] > 11}
						{assign var='hrs' value=$time_sel_value[idx]-12}
						{assign var='ampm' value='pm'}
					{else}{assign var='hrs' value=$time_sel_value[idx]}
						{assign var='ampm' value='am'}{/if}
					{if $hrs == 0}{assign var='hrs' value=12}{/if}
					  <option value='{$time_sel_value[idx]}'>{$hrs|string_format:'%02d'}:00 {$ampm}</option>
				  {/section}
				</select> &nbsp;
			  Finish Time: <select name="finish_time" id="finish_time" onChange="class_seat.checkBookHours(this);" class="inputbox2">
				  <option value="0">-</option>
				  {section name=idx loop=$time_sel_value}
				    {if $time_sel_value[idx] > 11}
						{assign var='hrs' value=$time_sel_value[idx]-12}
						{assign var='ampm' value='pm'}
					{else}{assign var='hrs' value=$time_sel_value[idx]}
						{assign var='ampm' value='am'}{/if}
					{if $hrs == 0}{assign var='hrs' value=12}{/if}
					  <option value='{$time_sel_value[idx]}'>{$hrs|string_format:'%02d'}:00 {$ampm}</option>
				  {/section}
				</select>
			  </td></tr>
			  <tr><td class='form1'>Booking Type: </td><td class='form2'><select class='inputbox2' name='type' id='type'>
			  <option value="Trial">Trial</option><option value="Nesting">Nesting</option><option value="Regular">Regular</option>
			  </td></tr>
			  <tr><td class='form1'>Booking Payment: </td><td class='form2'><select class='inputbox2' name='payment' id='payment'>
			  <option value="Free">Free</option><option value="TBP">To Be Paid</option></select>
			</td>
			</tr>
			 <tr>
		<td colspan="2" align='center'>
		  <input type='submit' class='button' id='createbutton' value='Book now'> <input type='button' id='cancelmgr' class='button' value='Cancel' onClick="closePage();">
		  <input type='hidden' name='task' value='create' id='task'>
			<input type='hidden' name='staff_id' id='staff_id'/>
			<input type='hidden' name='seat_id' id='seat_id' value='{$seat}'/>
	  </tr>
		  </table>
		</form>
	</div>
	{literal}
	<script type="text/javascript">
	<!--
	function closePage() {
		var seat_id = document.getElementById('seat_id');
		var boxlink = document.createElement('a');
		boxlink.href = 'seat_booking.php?seat_id='+seat_id.value;
        
        var boxdiv = window.parent.document.getElementById(boxlink.href);
        boxdiv.style.display='none';
	}

	function createResult(error_message) {
		$('span#task-status').empty().append(error_message).show().fadeOut(8000);
	}
	function reloadPage() {
		var el = document.getElementById('box-result');
		el.style.display = (el.style.display == "none") ? "block" : "none";
		var seat_id = document.getElementById('seat_id');
		window.location.href='seat_booking.php?seat_id='+seat_id.value;
	}
	function showStaffBooking(seat_id, staff_id) {
		window.parent.location.href = 'seat_staff_manage.php?task=perseat&seat_id='+seat_id+'&staff_id='+staff_id;
		
		var boxlink = document.createElement('a');
		boxlink.href = 'seat_booking.php?seat_id='+seat_id;
		var boxdiv = window.parent.document.getElementById(boxlink.href);
		boxdiv.style.display='none';
	}
	  //-->
	  </script>
	  {/literal}
  

</body>
</html>