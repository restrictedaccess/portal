{include file='seat_header.tpl'}
<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />

<link rel=stylesheet type=text/css href="/portal/css/tooltip.css">
<script type="text/javascript" src="/portal/js/tooltip.js"></script>
{literal}
<script language='JavaScript'>
<!---
$(document).ready(function() {
	Calendar.setup({
            inputField : "booking_date",
            trigger    : "bd",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d"
    });
	$('input#cancelbutton').bind('click', function(){history.go(-1);})
	
	//class_seat.onblur_search('staff_search');
	
	/*$('input#search').simpleAutoComplete('autocomplete_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'staff_search'
	    }, staffCallback);*/
});
hilite = function(e) { e.style.background = '#abccdd'; };
lowlite = function(e) { e.style.background = '';};
function submitPage() {
	var bdate = $('input#booking_date').val();
	var starttime = $('select#start_time').val();
	var endtime = $('select#finish_time').val();
	window.location.href='seat_home.php?date='+bdate+'&starttime='+starttime+'&endtime='+endtime;
}
// -->
</script>
<style type='text/css'>
#container{#position: absolute; #top: 50%;display: table-cell; vertical-align: middle;
/*position:absolute;
top: 50%;
display:table-cell; vertical-align: middle;*/
width:100px;height:70px;
   border:1px solid #aaa;
}
#content {#position: relative; #top: -50%;
  /* position: relative;top: -50%;width:30px;height:27px;*/
   border:1px solid #ff0000;
}
.greenBorder {border: 1px solid green;}

#parent {
	/*border: solid 1px #aaa;*/
	text-align: center;
	white-space: nowrap;
	font-size: 18px;
	letter-spacing: 25px;
	line-height: 12px;
	overflow: hidden;
	width: 100%;
	padding:10px;
	border: 1px solid #C0C0C0;
}

.child {
	width: 110px;
	height: 70px;
	border: solid 1px #011a39;
	display: inline-block;
	letter-spacing: normal;
	white-space: normal;
	text-align: normal;
	vertical-align: middle;
}

.child {
	*display: inline;
	*margin: 0 10px 0 10px;
}
.child p {
	border:1px solid #aaa;font-weight:bold;width:20%;height:15%;margin:3px auto;padding:4px;background:#696;
}
.child span {font-size:10px;cursor:pointer;}
.child span.red {color:#ff0000;}
.child span.black {font-size:10px;color:#000;}
</style>
{/literal}
<h2>Seat View</h2>
{*<h2>{lang_print id=55}</h2>*}
<div>Booking and Availabilities for {$dow_str}, {$home_date}</div>
<br />
{*<span style="font-size:15px;font-weight:bold">Quick View Today {$today_date}</span>*}
<table width="100%" cellpadding="1" cellspacing="5">
{*<tr>
<td colspan="2">

Date : <select id="month" onchange="SearchSubconQuickViewByDate(); ClearFromToFields()"><option value="">-</option>{$monthOptions}</select> <select id="year" onchange="SearchSubconQuickViewByDate();ClearFromToFields()"><option value="">-</option>{$yearoptions}</select>
<span style="margin-left:50px; color:#999999;"><em>or</em></span>
<span style="margin-left:100px;">
From : <input type="text" name="from" id="from"  style=" width:72px;" value="{$start_date_ref}" readonly  > <img align="absmiddle" src="./images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />

To : <input type="text" name="to" id="to"  style=" width:72px;" value="{$end_date_ref}" readonly  > <img align="absmiddle" src="./images/calendar_ico.png"   id="bd2" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />


<input type="button" value="Go" onclick="SearchSubconQuickViewByFromTo(); ClearSelectMonthYear();" id="go"  />
</span>

</td>
</tr>*}

<tr>

<td valign="top" width="50%">{*	<div id="compliance_quick_view"></div>*}
	<div style='width:100%;background:#ddd;padding:5px;'>
		<form id='seat_form' action='' method='post' target='ajaxframe'>
		<div style="width:100%;border:1px solid #aaa;">
			<div id='show_count' style='padding:1px 0 10px 5px;'><span style='font-size:13px;'>OPTIONAL FILTER: </span>
				<span style='font-size:12px;'><i>This filter will show you the seats available for the indicated date and time.</i></span></div>
		<span id='show_count'>Date:</span>
		<input type="text" id="booking_date" name="booking_date" value="{$filter_date}" class="inputbox2" readonly style="width:100px;"/> <input type='button' id="bd" value='...' title="Date selector"/>
		&nbsp;
		Start Time: <select name="start_time" id="start_time" class="inputbox2">
				  <option value="0">-</option>
				  {section name=idx loop=$time_sel_value}
					{if $time_sel_value[idx] > 11}
						{assign var='hrs' value=$time_sel_value[idx]-12}
						{assign var='ampm' value='pm'}
					{else}{assign var='hrs' value=$time_sel_value[idx]}
						{assign var='ampm' value='am'}{/if}
					{if $hrs == 0}{assign var='hrs' value=12}{/if}
					  <option value='{$time_sel_value[idx]}'{if $filter_start==$time_sel_value[idx]} selected{/if}>{$hrs|string_format:'%02d'}:00 {$ampm}</option>
				  {/section}
				</select> &nbsp;
			  Finish Time: <select name="finish_time" id="finish_time" class="inputbox2">
				  <option value="0">-</option>
				  {section name=idx loop=$time_sel_value}
				    {if $time_sel_value[idx] > 11}
						{assign var='hrs' value=$time_sel_value[idx]-12}
						{assign var='ampm' value='pm'}
					{else}{assign var='hrs' value=$time_sel_value[idx]}
						{assign var='ampm' value='am'}{/if}
					{if $hrs == 0}{assign var='hrs' value=12}{/if}
					  <option value='{$time_sel_value[idx]}'{if $filter_end==$time_sel_value[idx]} selected{/if}>{$hrs|string_format:'%02d'}:00 {$ampm}</option>
				  {/section}
				</select>

		<input type='button' class='button' value="Show me what's available for this date and time" name='submit' onclick="submitPage()"/>
		{*<span style=" float:right;"><input type="button" onClick="location.href='admin_subcon_staff_shift.php'" value="Export to CSV"></span>*}
		</div></form>
	  </div>
{section name=i start=0 loop=11}
<div id="parent">

	{section name=j start=0 loop=7}
		{assign var='ctr' value=$ctr+1}
		{if !in_array($ctr, $seat_booked)}
			<div class="child">{* onmouseover="hilite(this);" onmouseout="lowlite(this);">*}
			<p>{$ctr}</p>
			{section name=k loop=$seat_schedule[$ctr]}
				{if $smarty.section.k.index < 2}
				&nbsp;<span class='{if $seat_schedule[$ctr][k].booking_status=='Pending'}red{else}black{/if}'
				onmouseover="tooltip('Staff: {$seat_schedule[$ctr][k].fname} {$seat_schedule[$ctr][k].lname}<br/>Client: {$seat_schedule[$ctr][k].cfname} {$seat_schedule[$ctr][k].clname} ');" onmouseout="exit();">
				Booked:{$seat_schedule[$ctr][k].book_start}-{$seat_schedule[$ctr][k].book_end}</span>&nbsp;<br/>
				{/if}
			{/section}
			{*if $seat_schedule[$ctr]|@count > 2}...{/if*}
			<a href='seat_booking.php?seat_id={$ctr}' onclick="return show_hide_box(this, 650, 590, '4px solid #011a39', 330,50);">Quick Book</a>
			</div>
		{/if}
	{/section}

</div>
{/section}

</td>
</tr>
</table>



<br />


{include file='seat_footer.tpl'}
