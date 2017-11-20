{include file='seat_header.tpl'}

<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
	  
<link rel="stylesheet" type="text/css" href="css/simpleAutoComplete.css" />
<script type="text/javascript" src="js/simpleAutoComplete.js"></script>

<script type="text/javascript">
<!---
{literal}
$(document).ready(function() {	
	class_seat.onblur_search('staff', 'staff');
	$('input#staff').focus(function(){class_seat.onfocus_search('staff', 'staff');});
	
	$('input#staff').simpleAutoComplete('autocomplete_query.php',{
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
{/literal}
// -->
</script>

<h2>Manage Booking Per Staff</h2>
{*<h2>{lang_print id=55}</h2>
<div>{lang_print id=56}</div>*}
<br />
{*<span style="font-size:15px;font-weight:bold">Active Staff List</span>*}

{*<a name="stafflist">*}
{if $task!='perseat'}
<table width="100%" cellspacing="0" >
  <tr bgcolor="#CCCCCC">
  <td style=" padding:5px;">
	<form name='regform' method='POST' action='seat_staff_manage.php' style='padding:0px;'>
	<div style="width:100%;border:1px solid #aaa;">&nbsp;
	<input type="text" id="staff" name="staff" class="inputbox2" style="width:250px;" onblur="class_seat.onblur_search('staff', 'staff');">
	<span><input type="submit" name='submit' value="Submit"></span>
	<input type='hidden' name='task' value='staff_booking' id='task'>
	<input type='hidden' name='staff_id' id='staff_id' value='{$staff_id}'/>
	</div>
	</form>
  </td>
  </tr>
  </table>
{/if}
{*if $staff_id && $seat_id*}
{if $booking_info|@count > 0}
<br/>
{literal}<script type="text/javascript">
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

		  parent.location='seat_staff_manage.php?task=staff_booking&staff_id='+staff_id;
		}
		

		$(activeTab).fadeIn(); //Fade in the active ID content
		$(activeTab).show();
			//css('background', '#e0e0e0');
			
		return false;
	});
	Calendar.setup({inputField : "date_from", trigger : "bd", onSelect : function() { this.hide()}, fdow  : 0, dateFormat : "%Y-%m-%d" });
});
//-->
</script>{/literal}
	
<div id='staff'>
<ul class="tabs">
  <li><a href="#staffactive">{$booking_info[0].fname} {$booking_info[0].lname}{if $seat_id} (<i>Seat: #{$seat_id}){/if}</a></i></li>
  {if $seat_id}<li><a href="#stafflist">View all seats for {$booking_info[0].fname}</a></li>{/if}
</ul>
					
<div class="pane_container">
  <div id="staffactive" class="pane_content">
	  
	  <div id='result' style='float:left;width:100%;'>
		{if $task=='staff_booking'}<table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>
            <tr><td>Total Record: {$total_rec}</td>
            <td>{$items_total}</td>
               <td> &nbsp; {$pages}</td><td> &nbsp; {$items_pp} &nbsp; </td>
              <td>{$jump_menu}</td>
        </tr>
     </table>
		{/if}
	 {* staff list*}	 
	  <table cellpadding='3' cellspacing='3' class='list' width='100%'>
		<tr>
		  {if $task!='perseat'}<td class='header'>Seat#</td>{/if}
		  <td class='header'><a class='header' href='?{$qstring}&orderby=user_id+{if $orderbyfield=='user_id'}{$sortorder}{else}ASC{/if}#stafflist'>Booking Date</a></td>
		  <td class='header'><a class='header' href='?{$qstring}&orderby=user_id+{if $orderbyfield=='user_id'}{$sortorder}{else}ASC{/if}#stafflist'>Booking Time</a></td>
		  <td class='header'>Client</td>
		  <td class='header'>Status</td>
		  <td class='header' style="width:100px;">Booked by / Date when booking is made</td>
		  <td class='header'>Quick Action</td>
		</tr>
		
        {*if $booking_info|@count > 0*}
          {section name=idx loop=$booking_info}
		    {assign var='total_hrs' value=$booking_info[idx].hrs+$total_hrs}

          <tr bgcolor="{cycle values='#d0d8e8,#e9edf4'}" id="book{$booking_info[idx].id}">
			{if $task!='perseat'}<td class='item'>{$booking_info[idx].seat_id}</td>{/if}
			<td class='item'>{$booking_info[idx].book_date}</td>
			<td class='item'>{$booking_info[idx].book_start} to {$booking_info[idx].book_end}</td>
			
			<td class='item'><a href='seat_client_manage.php?task=client_booking&client_id={$booking_info[idx].leads_id}'>{$booking_info[idx].cfname} {$booking_info[idx].clname}</a></td>
			<td class='item'>{$booking_info[idx].booking_status}</td>
			
            <td class='item'>{$booking_info[idx].admin_fname} {$booking_info[idx].admin_lname}, {$booking_info[idx].book_made}</td>
			
			<td class='item'>
			<a href="javascript:confirmCancel('{$booking_info[idx].id}','{$booking_info[idx].seat_id}')">Cancel</a> |
			<a href="javascript:editBooking('{$booking_info[idx].id}','{$booking_info[idx].seat_id}', '{$booking_info[idx].leads_id}','{$booking_info[idx].cfname}', '{$booking_info[idx].clname}', '{$booking_info[idx].date_ymd}',
			'{$booking_info[idx].start_hr}','{$booking_info[idx].end_hr}','{$booking_info[idx].booking_type}','{$booking_info[idx].booking_payment}','{$booking_info[idx].booking_status}');">Modify</a>
			</td>
			
			
          </tr>
          {/section}
		  <tr bgcolor="#d0d0d0"><td class='item'>TOTAL</td>
			<td class='item'>{$total_hrs} hour/s</td><td colspan='5'></td>
		  </tr>
          {*else}
            <tr bgcolor="#d0d0d0"><td colspan='6'>No record found.</td></tr>
          {/if*}
      </table>
	 {* end of list *}
	  </div>
	
  </div>
  
</div>
</div>

{literal}<script type="text/javascript">
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

function editBooking(id, seat, leads, cfname, clname, date, starthr, endhr, type, payment, status) {
  //document.getElementById('createbutton').value = '';
  //document.getElementById('error').innerHTML = '';  
  //document.getElementById('old_password').style.display = '';  
  //document.getElementById('task').value = 'edit';
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
  /*$("select#start_time option[value=" + starthr +"]").attr("selected","selected");
  $("select#finish_time option[value=" + endhr +"]").attr("selected","selected");
  $("select#type option[value=" + type +"]").attr("selected","selected");
  $("select#payment option[value=" + payment +"]").attr("selected","selected");
  $("select#status option[value=" + status +"]").attr("selected","selected");*/
  //$('admin_username').value = username;  
  //$('admin_name').defaultValue = name;  
  //$('admin_name').value = name;  
  //$('admin_email').defaultValue = email;  
  //$('admin_email').value = email;
  var winHeight = $(window).height();
  var winWidth = $(window).width();
  // overwrite width and height to fix IE display
  /*$('div#editbooking').width(winWidth);
  $('div#editbooking').height(winHeight);*/
  $('div#editbooking').show();
}
//-->
</script>{/literal}

{* HIDDEN DIV TO DISPLAY CONFIRMATION MESSAGE *}


<div class='overlay' id='confirmcancel'><span id='task-status'></span>
<div>
  <div style='font-weight:bold;border:none;padding:20px;' id='confirm_text'>Confirm cancel of booking #<span id='booknum'></span></div>
  <br>
	<span style='float:left;border-top:1px solid #aaa;width:100%;text-align:center'>
	<form name='regform' method='POST' target='ajaxframe' action='seat_staff_manage.php' style='padding:0px;'>
	<input type='submit' class='button' value='Continue' id='deletebutton'> <input type='button' class='button' value='Cancel' onClick="$('div#confirmcancel').hide();">
	<input type='hidden' name='task' value='cancel_book' id='task'>
	<input type='hidden' name='book_id' id='book_id'/>
	<input type='hidden' name='seat_id' id='seat_id'/>
	</form>
</div>
</div>


{* HIDDEN DIV TO DISPLAY CREATE/EDIT ADMIN *}
<div id='editbooking' class='overlay'><span id='task-status'></span>

  <div style='width:570px;padding:3px;border:1px solid #011a39;'>
	<div style='text-align:center;padding-left:10px;border:none;font-size:13px;font-weight:bold;'>Modify Booking</div>
		<form name='regform' method='POST' target='ajaxframe' action='seat_staff_manage.php' style='padding:0px;'>
			
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			  <tr><td class='form1' width='27%'>Booking For: </td><td class='form2'>{$booking_info[0].fname} {$booking_info[0].lname}</td></tr>
			  <tr><td class='form1' id='client_header'>Client Name: </td><td class='form2'>
			  <select class='inputbox2' name='client_select' id='client_select'></select></td></tr>
			  
			  <tr><td class='form1'>Date of Booking: </td><td class='form2'><input type="text" id="date_from" name="date_from" class="inputbox2" style="width:100px;" onchange="class_seat.checkBookDate();"/> <img align="absmiddle" src="/portal/images/calendar_ico.png" id="bd" style="cursor: pointer; " onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''"/>
			  {*<span>From:</span><input type="text" id="date_from" name="date_from" class="inputbox2" style="width:100px;" onchange="class_seat.checkBookDate();"/> <img align="absmiddle" src="/portal/images/calendar_ico.png" id="bd" style="cursor: pointer; " onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''"/> &nbsp;
			  <span>to:</span><input type="text" id="date_to" name="date_to" class="inputbox2" readonly style="width:100px;"/> <img align="absmiddle" src="/portal/images/calendar_ico.png" id="bd2" style="cursor: pointer; " onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''"/>*}</td></tr>
			  <tr><td class='form2' colspan='2' style='padding-left:80px;'>
			  Start Time: &nbsp;&nbsp;<select name="start_time" id="start_time" onChange="class_seat.checkBookHours(this);" class="inputbox2">
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
			  <option value="Trial">Trial</option><option value="Nesting">Nesting</option><option value="Regular">Regular</option></select>
			  </td></tr>
			  <tr><td class='form1'>Booking Payment: </td><td class='form2'><select class='inputbox2' name='payment' id='payment' onchange='class_seat.bookPaymnet(this);'>
			  <option value="Free">Free</option><option value="TBP">To Be Paid</option></select>
			</td>
			</tr>
			  <tr><td class='form1'>Booking Status: </td><td class='form2'><select class='inputbox2' name='status' id='status'>
			  <option value="Confirmed">Confirmed</option><option value="Pending">Pending</option></select></td></tr>
			 <tr>
		<td colspan="2" align='center'>
		  <input type='submit' class='button' id='createbutton' value='Update Bookings'> <input type='button' id='cancelmgr' class='button' value='Cancel' onClick="$('div#editbooking').hide();">
		  <input type='hidden' name='task' value='update' id='task'>
			<input type='hidden' name='staff_id' id='staff_id' value='{$staff_id}'/>
			<input type='hidden' name='book_id' id='book_id'/>
			<input type='hidden' name='client' id='client'/>
			<input type='hidden' name='seat_id' id='seat_id'/>
	  </tr>
		  </table>
		</form>
	</div>
	{literal}<script type="text/javascript">
	<!-- 
	function createResult(err_msg, is_error) {
		if( is_error )
			$('span#task-status').empty().append(err_msg).show().fadeOut(8000);
		else {
			var seat_id = $('input#seat_id').val();
			var staff_id = $('input#staff_id').val();
			location.href='seat_staff_manage.php?task={/literal}{$task}{literal}&seat_id='+seat_id+'&staff_id='+staff_id;
		}
	}
	//-->
	</script>{/literal}
</div>
{elseif $task}
    <div class='error'>No record found.</div>
{/if} {* if staff_id and seat_id *}

{include file='seat_footer.tpl'}
