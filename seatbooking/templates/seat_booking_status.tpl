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

		//$(activeTab).fadeIn(); //Fade in the active ID content
		$(activeTab).show();
			//css('background', '#e0e0e0');
			
		return false;
	});
	
	class_seat.onblur_search('client', 'client');
	$('input#client').focus(function(){class_seat.onfocus_search('client', 'client');});
	
	$('input#client').simpleAutoComplete('autocomplete_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'client'
	    }, staffCallback);
	/*Calendar.setup({inputField : "date_to", trigger:  "bd2", onSelect : function() { this.hide()},
			fdow  : 0, dateFormat : "%Y-%m-%d"
    });*/

});
function staffCallback( param ) {
	$("input#client_id").val( param[0] );
}
{/literal}
// -->
</script>

<h2>Booking By Status</h2>
{*<h2>{lang_print id=55}</h2>
<div>{lang_print id=56}</div>*}
<br />
{*<span style="font-size:15px;font-weight:bold">Active Staff List</span>*}

{*<a name="stafflist">*}

	<div style="width:100%;height:20px;padding:7px;border:1px solid #aaa;">&nbsp;
	<span id='show_count'>Filters: </span>
	<span><a href='?'>View All Bookings</a> | <a href='?booking_status=Pending'>View All Pending Bookings</a> | <a href='?booking_status=Confirmed'>View All Confirmed Bookings</a> | <a href='?booking_status=Cancelled'>View All Cancelled Bookings</a></span>
	
	</div>



{*if $staff_id && $seat_id*}

<br/>
	
<div id='staff'>
<ul class="tabs">
  <li><a href="#bookingstatus">{$status} status</a></i></li>
</ul>
					
<div class="pane_container">
  <div id="bookingstatus" class="pane_content">
	  <table cellpadding='0' cellspacing='0' class='list' style='float:left;width:auto;border:1px solid #aaa;'>
        <tr><td>Total Record: {$total_rec}</td>
            <td>{$items_total}</td>
            <td> &nbsp; {$pages}</td><td> &nbsp; {$items_pp} &nbsp; </td>
            <td>{$jump_menu}</td>
        </tr>
     </table>
	  
	  <div id='result' style='float:left;width:90%;'>
	 {* staff list*}	 
	  <table cellpadding='3' cellspacing='3' class='list' width='100%'>
		<tr>
		  <td class='header'>#</td>
		  <td class='header'>Client Name</td>
		  <td class='header'>Last Booking Date</td>
		  <td class='header'>Status</td>
		</tr>
		
        {if $booking_info|@count > 0}
          {section name=idx loop=$booking_info}

          <tr bgcolor="{cycle values='#d0d8e8,#e9edf4'}">
			<td class='item'>{math equation="x+y" x=$smarty.section.idx.index y=$ipp+1}</td>
			<td class='item'><a href='seat_client_manage.php?task=client_booking&client_id={$booking_info[idx].id}'>{$booking_info[idx].cfname} {$booking_info[idx].clname}</a></td>
			<td class='item'>{$booking_info[idx].book_date}</td>			
			<td class='item'>{$booking_info[idx].booking_status}</td>
			
			
          </tr>
          {/section}
		  {*<tr bgcolor="#d0d0d0"><td class='item'>TOTAL</td>
			<td class='item'>{$total_hrs} hour/s</td><td colspan='5'></td>
		  </tr>*}
          {else}
            <tr bgcolor="#d0d0d0"><td colspan='6'>No record found.</td></tr>
          {/if}
      </table>
	 {* end of list *}
	  </div>
	
  </div>
  
</div>
</div>


{include file='seat_footer.tpl'}