<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Seat Booking</title>
    <link rel=stylesheet type=text/css href="<?php echo $staticdir;?>/seatbooking/css/seat_styles.css">
	<link rel=stylesheet type=text/css href="<?php echo $staticdir;?>/seatbooking/css/styles_global.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $staticdir;?>/seatbooking/css/activecalendar.css" />
	<link rel=stylesheet type=text/css href="<?php echo $staticdir;?>/seatbooking/css/overlay.css">

    <script type="text/javascript" src="<?php echo $staticdir;?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo $staticdir;?>/seatbooking/js/seat_booking.js"></script>
	<link rel=stylesheet type=text/css href="<?php echo $staticdir;?>/css/tooltip.css">
	<script type="text/javascript" src="<?php echo $staticdir;?>/js/tooltip.js"></script>
	
	<script type="text/javascript" src="<?php echo $staticdir;?>/js/jscal2.js"></script> 
	<script type="text/javascript" src="<?php echo $staticdir;?>/js/lang/en.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $staticdir;?>/css/jscal2.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $staticdir;?>/seatbooking/css/simpleAutoComplete.css" />
	<script type="text/javascript" src="<?php echo $staticdir;?>/seatbooking/js/simpleAutoComplete.js"></script>
<style type='text/css'>
<!--
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
-->
</style>
<script type='text/javascript'>
<!--///
var back_link = parent.window.document.getElementById('back_link');

//back_link.style.fontSize = '14px';
//back_link.innerHTML = 'Back';

$(document).ready(function() {
	var seat_id = $('input#seat_id');
	var boxlink = document.createElement('a');
	
	boxlink.href = 'seatb.php?/reserve_seat/&seat_id='+seat_id.val();
    //var boxdiv = window.parent.document.getElementById('id'+seat_id.val());
	var boxdiv = $('#id'+seat_id.val(), window.parent.document);

	var parentHeight = $(window.parent).scrollTop();
	
	$(boxdiv).css({'position':'absolute', 'margin-top':parentHeight+'px'});
	//alert(boxdiv.css('position'));
	//boxdiv.style.position = 'absolute';
	//boxdiv.style.marginTop = parentHeight + 'px';
	
	var close_link = parent.window.document.getElementById('close_link');
	close_link.onclick = closePage;
	
		
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
	
	
	$('input#staff').simpleAutoComplete('/portal/seatbooking/autocomplete_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'staff'
	    }, staffCallback);
	
	$(window).keydown(function(event){
		//alert(event.target.nodeName);
		if(event.keyCode == 13 && event.target.nodeName == 'INPUT') {
		  event.preventDefault();
		  return false;
		}
	});
});
function staffCallback( param )
	{
	  $("input#staff_id").val( param[0] );
	  //$("input#work_email").val( param[1] );
	  
	  $.ajax({
			type: "POST",
			url: "/portal/seatbooking/seatb.php?/show_client",
			data: { 'userid': param[0] },
			dataType: "json",
			success: function(data){
				class_seat.setStaffData(data);
			}, error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(textStatus + " (" + errorThrown + ")");
			}
		});
	}
//-->
</script>
</head>
<body>
	<iframe id='ajaxframe' name='ajaxframe' style='display:none;' src='javascript:false;'></iframe>
    <!-- Insert your content here -->
	<!--<h3><strong>SEAT #<?php //echo $seat_id;?></strong> - Quick Book</h3>-->
	
	<div id='box-result' class='overlay'> <div> <b>BOOKING RESULT</b><br/>
	<div id='result-data' style='padding:5px 20px 5px 20px;border:none;'></div>
	<br/>
	<span style='float:left;border-top:1px solid #aaa;width:100%;text-align:center'>
	<input type='button' name='submit' value='&nbsp; OK &nbsp;' onclick='reloadPage();' /></span></div> </div>
	

	<div style='float:left;width:96%;padding:2px;'>
		<div id='calendar' style='float:left;width:100%;padding-left:10px;'><?php echo $calendar;?></div>
	</div>
	<div style='float:left;width:96%;padding:3px;border:1px solid #011a39;'>
		<form name='regform' method='POST' target='ajaxframe' action='seatb.php?/process_booking/' style='padding:0px;'>
			
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			<tr><td class='form2' colspan='2' style='padding-left:80px;height:40px;'>
			  <!--<tr><td class='form1' width='22%'>-->Booking For: &nbsp;<!--</td><td class='form2'>-->
			  <input type="text" id="staff" name="staff" class="inputbox2" onblur="class_seat.onblur_search('staff', 'staff');">
			  <!--</td></tr>-->
			  <!--<tr>-->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <!--<td class='form1' id='client_header'>Client Name: </td><td class='form2'>-->
			  <span style='color:#333;' id='client_header'>Client Name: </span>
			  <select class='inputbox2' name='client' id='client'></select>
			</td></tr>
			  
			  <tr><td class='form1'>Date of Booking: </td><td class='form2'>
			  <span>From:</span><input type="text" id="date_from" name="date_from" class="inputbox2" style="width:100px;" onchange="class_seat.checkBookDate();"/> <img align="absmiddle" src="/portal/images/calendar_ico.png" id="bd" style="cursor: pointer; " onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''"/> &nbsp;
			  <span>to:</span><input type="text" id="date_to" name="date_to" class="inputbox2" readonly style="width:100px;"/> <img align="absmiddle" src="/portal/images/calendar_ico.png" id="bd2" style="cursor: pointer; " onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''"/></td></tr>
			  <tr><td class='form2' colspan='2' style='padding-left:90px;'>
			  Start Time: &nbsp;&nbsp;<select name="start_time" id="start_time" onChange="class_seat.checkBookHours(this);" class="inputbox2">
				  <option value="">-</option>
				  <?php foreach($time_sel_value as $time_option):
					if( $time_option > 11 ) {
						$hrs = $time_option - 12;
						$ampm = 'pm';
					} else { $hrs = $time_option;
						$ampm ='am';
					}
					if( $hrs == 0 ) $hrs = 12;?>
					
					<option value='<?php echo $time_option;?>'><?php printf('%02d', $hrs); echo ':00'. $ampm;?></option>
				<?php endforeach;?>
				</select> &nbsp;&nbsp; -- &nbsp;&nbsp;
			  Finish Time: <select name="finish_time" id="finish_time" onChange="class_seat.checkBookHours(this);" class="inputbox2">
				  <option value="">-</option>
				  <?php foreach($time_sel_value as $time_option):
					if( $time_option > 11 ) {
						$hrs = $time_option - 12;
						$ampm = 'pm';
					} else { $hrs = $time_option;
						$ampm ='am';
					}
					if( $hrs == 0 ) $hrs = 12;?>
					<option value='<?php echo $time_option;?>'><?php printf('%02d', $hrs); echo ':00'. $ampm;?></option>
				<?php endforeach;?>
				</select>
			  </td></tr>
			  
			  <tr><td class='form1'>Timezone: </td><td class='form2'><select class='inputbox2' name='timezone'>
			  <?php foreach($timezone as $tz_option):?>
			  <option value="<?php echo $tz_option['tz'];?>"><?php echo $tz_option['label'];?></option>
			  <?php endforeach;?>
			  </select>
			  </td></tr>
			  
			  <tr><td class='form2' colspan='2' style='padding-left:70px;'>
			  <!--<tr><td class='form1'>-->
			  Booking Type: &nbsp;&nbsp;<!--</td><td class='form2'>--><select class='inputbox2' name='type' id='type'>
			  <option value="Trial">Trial</option><option value="Transition">Transition</option><option value="Regular">Regular</option>
			  </select> &nbsp; &nbsp;
			  <!--</td>
				<td class='form2'>-->Booking Schedule: <!--</td><td class='form2'>--><select class='inputbox2' name='schedule' id='schedule'>
			  <option value="Daily">Daily</option><option value="Monthly">Monthly</option></select>
			  </td>
			  </tr>
			  <tr><td class='form1'>Booking Payment: </td><td class='form2'><select class='inputbox2' name='payment' id='payment'>
			  <option value="Free">Free</option><option value="TBP">To Be Paid</option></select>
			  </td></tr>
			  <tr><td class='form1'>Noise Level: </td><td class='form2'><select class='inputbox2' name='noise' id='noise'>
			  <option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select>
			  </td></tr>
			 <tr>
		<td colspan="2" align='center'>
		<input type='submit' class='button' id='createbutton' name='createbutton' value='Book now'> <input type='button' id='cancelmgr' class='button' value='Cancel' onClick="closePage();">
		<input type='hidden' name='task' value='create' id='task'>
		<input type='hidden' name='staff_id' id='staff_id'/>
			<input type='hidden' name='seat_id' id='seat_id' value='<?php echo $seat_id;?>'/>
	  </tr>
		  </table>
		</form>
	</div>

	<script type="text/javascript">
	<!--
	function closePage() {
		//var seat_id = document.getElementById('seat_id');
		var seat_id = $('input#seat_id');
		var boxlink = document.createElement('a');
		boxlink.href = 'seatb.php?/reserve_seat/&seat_id='+seat_id.val();
        
        //var boxdiv = window.parent.document.getElementById(boxlink.href);
		var boxdiv = $('#id'+seat_id.val(), window.parent.document);
        //boxdiv.style.display='none';
		boxdiv.hide();
		
		var currentScroll = $(window.parent).scrollTop();
		var currentURL = window.parent.location.href.split('&scroll')[0];
		
		//if (currentURL.charAt( currentURL.length-1 ) != '/') currentURL += '?';
		
		window.parent.location.href = currentURL+'&scroll='+currentScroll;
	}

	function createResult(error_message) {
		$('span#task-status', window.parent.document).empty().append(error_message).show().fadeOut(8000);
	}
	function reloadPage() {
		var el = document.getElementById('box-result');
		el.style.display = (el.style.display == "none") ? "block" : "none";
		var seat_id = document.getElementById('seat_id');
		window.location.href='seatb.php?/reserve_seat/&seat_id='+seat_id.value;
	}
	function showStaffBooking(seat_id, staff_id) {
		window.parent.location.href = 'seatb.php?/staff/seat/&seat_id='+seat_id+'&staff_id='+staff_id;
		
		var boxlink = document.createElement('a');
		boxlink.href = 'seatb.php?/reserve_seat/&seat_id='+seat_id;
		var boxdiv = window.parent.document.getElementById(boxlink.href);
		boxdiv.style.display='none';
	}
	  //-->
	  </script>

  

</body>
</html>