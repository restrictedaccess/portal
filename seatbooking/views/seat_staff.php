<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
	  
<link rel="stylesheet" type="text/css" href="<?php echo $staticdir;?>/seatbooking/css/simpleAutoComplete.css" />
<script type="text/javascript" src="<?php echo $staticdir;?>/seatbooking/js/simpleAutoComplete.js"></script>

<script type="text/javascript">
<!---
$(document).ready(function() {	
	class_seat.onblur_search('staff', 'staff');
	$('input#staff').focus(function(){class_seat.onfocus_search('staff', 'staff');});
	
	$('input#staff').simpleAutoComplete('/portal/seatbooking/autocomplete_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'staff'
	    }, staffCallback);
	/*Calendar.setup({inputField : "date_to", trigger:  "bd2", onSelect : function() { this.hide()},
			fdow  : 0, dateFormat : "%Y-%m-%d"
    });*/

});
function staffCallback( param ) {
	$("input#staff_id").val( param[0] );
	/*$.ajax({
		type: "POST",
		url: "seat_staff_manage.php",
		data: { 'task': 'staff_booking', 'userid': param[0] },
		dataType: "json",
		success: function(data){
			class_seat.showStaffBooking(data);
		}, error: function(XMLHttpRequest, textStatus, errorThrown){
			alert(textStatus + " (" + errorThrown + ")");
		}
	});*/
}
// -->
</script>

<h2>Manage Booking Per Staff</h2>
<br />

<?php if( !$staff_id ):?>
<table width="98%" cellspacing="0" >
  <tr bgcolor="#CCCCCC">
  <td style=" padding:5px;">
	<form name='regform' method='POST' action='seatb.php?/staff/' style='padding:0px;'>
	<div style="width:100%;border:1px solid #aaa;">&nbsp;
	<input type="text" id="staff" name="staff" class="inputbox2" style="width:250px;" onblur="class_seat.onblur_search('staff', 'staff');">
	<span><input type="submit" name='submit' value="Submit"></span>
	<input type='hidden' name='task' value='staff_booking' id='task'>
	<input type='hidden' name='staff_id' id='staff_id' value='<?php echo $staff_id ?>'/>
	</div>
	</form>
  </td>
  </tr>
  </table>
<?php endif;?>

<?php if( count($booking_info) > 0 ):?>
<br/>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$(".pane_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".pane_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".pane_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		//if( activeTab == 'staffactive' )
		
		var tabIdx = $(this).index();
		if( tabIdx == 0) {
		  $(activeTab).fadeIn(); //Fade in the active ID content
		  $(activeTab).show();
		} else {
		  var staff_id = $('input#staff_id').val();

		  parent.location='seatb.php?/staff/&staff_id='+staff_id;
		}
		

		$(activeTab).fadeIn(); //Fade in the active ID content
		$(activeTab).show();
			//css('background', '#e0e0e0');
			
		return false;
	});
	Calendar.setup({inputField : "date_from", trigger : "bd", onSelect : function() { this.hide()}, fdow  : 0, dateFormat : "%Y-%m-%d" });
});
//-->
</script>
	
<div id='staff'>
<ul class="tabs">
  <li><a href="#staffactive"><?php echo $booking_info[0]['fname'].' '.$booking_info[0]['lname']; if($seat_id):?> (<i>Seat: #<?php echo $seat_id;?>)<?php endif;?></a></i></li>
  <?php if($seat_id):?><li><a href="#stafflist">View all seats for <?php echo $booking_info[0]['fname'];?></a></li><?php endif;?>
</ul>
					
<div class="pane_container">
  <div id="staffactive" class="pane_content">
	  
	  <div id='result' style='float:left;width:100%;'>
		<?php if($task=='staff_booking'):?>
		<table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>
            <tr><td>Total Record: <?php echo $total_rec;?></td>
            <td><?php echo $items_total;?></td>
               <td> &nbsp; <?php echo $pages;?></td><td> &nbsp; <?php echo $items_pp;?> &nbsp; </td>
              <td><?php echo $jump_menu;?></td>
			</tr>
		</table>
		<?php endif;?>
		
	  <table cellpadding='3' cellspacing='3' class='list' width='100%'>
		<tr>
		  <?php if($staff!=='perseat'):?><td class='header'>Seat#</td><?php endif;?>
		  <td class='header'><a class='header' href='?{$qstring}&orderby=user_id+{if $orderbyfield=='user_id'}{$sortorder}{else}ASC{/if}#stafflist'>Booking Date</a></td>
		  <td class='header'><a class='header' href='?{$qstring}&orderby=user_id+{if $orderbyfield=='user_id'}{$sortorder}{else}ASC{/if}#stafflist'>Booking Time</a></td>
		  <td class='header'>Client</td>
		  <td class='header'>Payment</td>
		  <td class='header'>Status</td>
		  <td class='header' style="width:100px;">Booked by / Date when booking is made</td>
		  <td class='header'>Quick Action</td>
		</tr>
		

          <?php foreach($booking_info as $info):
		    $total_hrs = (int)$info['hrs'] + $total_hrs;?>

          <tr bgcolor="<?php echo $info['bgcolor'];?>" id="book<?php echo $info['id'];?>">
			<td class='item'><?php echo $info['seat_id'];?></td>
			<td class='item'><?php echo $info['book_date'];?></td>
			<td class='item'><?php echo $info['book_start'].' to '.$info['book_end'].' &nbsp;('.$info['hrs'].'hrs)';?></td>
			
			<td class='item'><a href='seatb.php?/client/&leads_id=<?php echo $info['leads_id'];?>'><?php echo $info['cfname'].' '.$info['clname'];?></a></td>
			<td class='item'><?php echo ($info['booking_payment']=='TBP')?'To Be Paid':$info['booking_payment'];?></td>
			<td class='item'><?php echo $info['booking_status'];?></td>
			
            <td class='item'><?php echo $info['admin_fname'].' '.$info['admin_lname'].', '.$info['book_made'];?></td>
			
			<td class='item'>
			<a href="javascript:confirmCancel('<?php echo $info['id'];?>','<?php echo $info['seat_id'];?>')">Cancel</a> |
			<a href="javascript:editBooking('<?php echo $info['id'];?>','<?php echo $info['seat_id'];?>', '<?php echo $info['userid'];?>','<?php echo $info['cfname'];?>', '<?php echo $info['clname'];?>', '<?php echo $info['date_ymd'];?>',
			'<?php echo $info['start_hr'];?>','<?php echo $info['end_hr'];?>','<?php echo $info['booking_type'];?>','<?php echo $info['booking_payment'];?>','<?php echo $info['booking_status'];?>','<?php echo $info['timezone'];?>',
			'<?php echo $info['booking_schedule'];?>');">Modify</a>
			</td>
			
			
          </tr>
          <?php endforeach;?>
		  <tr bgcolor="#d0d0d0"><td class='item' colspan='2'>TOTAL</td>
			<td class='item'><?php echo $total_hrs;?> hour/s</td><td colspan='4'></td>
		  </tr>

      </table>
	 <?php /* end of list */?>
	  </div>
	
  </div>
  
</div>
</div>

<script type="text/javascript">
<!--
function confirmCancel(id, seat) {
  $('input#book_id').val(id);
  $('span#booknum').text(id);
  $('input#seat_id').val(seat);
  var winHeight = $(window).height();
  var winWidth = $(window).width();
  // overwrite width and height to fix IE display
  //$('div#confirmcancel').width(winWidth);
  //$('div#confirmcancel').height(winHeight);
  $('div#confirmcancel').show();
}

function editBooking(id, seat, leads, cfname, clname, date, starthr, endhr, type, payment, status, tz,sched) {
  $('span#bookid').empty().text('#'+id);
  $('input#book_id').val(id);
  $('input#seat_id').val(seat);
  $('input#client').val(leads);
  $('select#client_select').empty().append("<option value=''>"+cfname+" "+clname+"</option>");
  $('input#date_from').val(date);
  $('input#date_to').val(date);
  class_seat.setSelected('start_time', starthr);
  class_seat.setSelected('finish_time', endhr);
  class_seat.setSelected('type', type);
  class_seat.setSelected('payment', payment);
  class_seat.setSelected('status', status);
  class_seat.setSelected('timezone', tz);
  class_seat.setSelected('schedule', sched);

  var winHeight = $(window).height();
  var winWidth = $(window).width();
  // overwrite width and height to fix IE display
  /*$('div#editbooking').width(winWidth);
  $('div#editbooking').height(winHeight);*/
  $('div#editbooking').show();
}
//-->
</script>

<?php /* HIDDEN DIV TO DISPLAY CONFIRMATION MESSAGE */ ?>
<div class='overlay' id='confirmcancel'><span id='task-status'></span>
<div>
  <div style='font-weight:bold;border:none;padding:20px;' id='confirm_text'>Confirm cancel of booking #<span id='booknum'></span></div>
  <br>
	<span style='float:left;border-top:1px solid #aaa;width:100%;text-align:center'>
	<form name='regform' method='POST' target='ajaxframe' action='seatb.php?/cancel' style='padding:0px;'>
	<input type='submit' class='button' value='Continue' id='deletebutton'> <input type='button' class='button' value='Cancel' onClick="$('div#confirmcancel').hide();">
	<input type='hidden' name='task' value='cancel_book' id='task'>
	<input type='hidden' name='book_id' id='book_id'/>
	<input type='hidden' name='seat_id' id='seat_id'/>
	</form>
</div>
</div>


<?php /* HIDDEN DIV TO DISPLAY CREATE/EDIT ADMIN */?>
<div id='editbooking' class='overlay'><span id='task-status'></span>

  <div style='width:570px;padding:3px;border:1px solid #011a39;'>
	<div style='text-align:center;padding-left:10px;border:none;font-size:13px;font-weight:bold;'>Modify Booking <span id='bookid'></span></div>
		<form name='regform' method='POST' target='ajaxframe' action='seatb.php?/modify' style='padding:0px;'>
			
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			  <tr><td class='form1' width='27%'>Booking For: </td><td class='form2'><?php echo $booking_info[0]['fname'].' '.$booking_info[0]['lname'];?></td></tr>
			  <tr><td class='form1' id='client_header'>Client Name: </td><td class='form2'>
			  <select class='inputbox2' name='client_select' id='client_select'></select></td></tr>
			  
			  <tr><td class='form1'>Date of Booking: </td><td class='form2'><input type="text" id="date_from" name="date_from" class="inputbox2" style="width:100px;" onchange="class_seat.checkBookDate();"/> <img align="absmiddle" src="/portal/images/calendar_ico.png" id="bd" style="cursor: pointer; " onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''"/>
			  </td></tr>
			  <tr><td class='form2' colspan='2' style='padding-left:80px;'>
			  Start Time: &nbsp;&nbsp;<select name="start_time" id="start_time" onChange="class_seat.checkBookHours(this);" class="inputbox2">
				  <option value="0">-</option>
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
				</select> &nbsp;
			  Finish Time: <select name="finish_time" id="finish_time" onChange="class_seat.checkBookHours(this);" class="inputbox2">
				  <option value="0">-</option>
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
			  <tr><td class='form1'>Timezone: </td><td class='form2'><select class='inputbox2' name='timezone' id='timezone'>
			  <?php foreach($timezone as $tz_option):?>
			  <option value="<?php echo $tz_option['tz'];?>"><?php echo $tz_option['label'];?></option>
			  <?php endforeach;?>
			  </select>
			  </td></tr>
			  <!--<tr><td class='form1'>Booking Type: </td><td class='form2'>-->
			  <tr><td class='form2' colspan='2' style='padding-left:60px;'>Booking Type:&nbsp;
			  <select class='inputbox2' name='type' id='type'>
			  <option value="Trial">Trial</option><option value="Transition">Transition</option><option value="Regular">Regular</option></select>
			  &nbsp;&nbsp;&nbsp;&nbsp;
			  Booking Schedule: <select class='inputbox2' name='schedule' id='schedule'>
			  <option value="Daily">Daily</option><option value="Monthly">Monthly</option></select>
			  </td></tr>
			  <tr><td class='form1'>Booking Payment: </td><td class='form2'>
			  <select class='inputbox2' name='payment' id='payment' onchange='class_seat.bookPaymnet(this);'>
				<?php foreach($payment_types as $payment):?>
				<option value='<?php echo $payment;?>'><?php echo ($payment=='TBP') ? 'To Be Paid' : $payment;?></option>
				<?php endforeach;?>
			  </select>
			</td>
			</tr>
			  <tr><td class='form1'>Booking Status: </td><td class='form2'>
			  <select class='inputbox2' name='status' id='status' onchange='class_seat.bookStatus(this);'>
			  <option value="Confirmed">Confirmed</option><option value="Pending">Pending</option></select></td></tr>
			 <tr>
		<td colspan="2" align='center'>
		  <input type='submit' class='button' id='createbutton' value='Update Bookings'> <input type='button' id='cancelmgr' class='button' value='Cancel' onClick="$('div#editbooking').hide();">
		  <input type='hidden' name='task' value='update' id='task'>
			<input type='hidden' name='staff_id' id='staff_id' value='<?php echo $staff_id;?>'/>
			<input type='hidden' name='book_id' id='book_id'/>
			<input type='hidden' name='client' id='client'/>
			<input type='hidden' name='seat_id' id='seat_id'/>
	  </tr>
		  </table>
		</form>
	</div>
	<script type="text/javascript">
	<!-- 
	function createResult(err_msg, is_error) {
		if( is_error )
			$('span#task-status').empty().append(err_msg).show().fadeOut(8000);
		else {
			var seat_id = $('input#seat_id').val();
			var staff_id = $('input#staff_id').val();
			location.href='seatb.php?/staff/&seat_id='+seat_id+'&staff_id='+staff_id;
		}
	}
	//-->
	</script>
</div>
<?php elseif($staff_id):?>
    <div class='error'>No record found.</div>
<?php endif; ?>
