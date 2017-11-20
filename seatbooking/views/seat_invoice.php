<script type="text/javascript" src="/portal/js/jscal2.js"></script> 
<script type="text/javascript" src="/portal/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/portal/css/jscal2.css" />
	  
<link rel="stylesheet" type="text/css" href="<?php echo $staticdir;?>/seatbooking/css/simpleAutoComplete.css" />
<script type="text/javascript" src="<?php echo $staticdir;?>/seatbooking/js/simpleAutoComplete.js"></script>

<script type="text/javascript">
<!---
$(document).ready(function() {
		
	class_seat.onblur_search('client', 'client');
	$('input#client').focus(function(){class_seat.onfocus_search('client', 'client');});
	
	$('input#client').simpleAutoComplete('/portal/seatbooking/autocomplete_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'client'
	    }, staffCallback);

});
function staffCallback( param ) {
	$("input#leads_id").val( param[0] );
}
// -->
</script>

<h2>Invoicing Report</h2>
<br />

<table width="100%" cellspacing="0" >
  <tr bgcolor="#CCCCCC">
  <td style=" padding:5px;">
	<form name='regform' method='POST' action='seatb.php?/client/' style='padding:0px;'>
	<div style="width:100%;border:1px solid #aaa;">&nbsp;
	<span style='font-weight:bold;'>Show Total Unpaid Booking for:</span>
	<select name="client" id="client" class="inputbox2" onchange="class_seat.client_invoice();"><option value='0'>- select here -</option>
    <?php foreach($client_select as $client):?>
        <option value='<?php echo $client['id'];?>'><?php echo $client['fname'].' '.$client['lname'];?></option>
    <?php endforeach;?>
    </select>
	<!--<span><input type="submit" name='submit' value="Submit"></span>-->
	</div>
	</form>
  </td>
  </tr>
  </table>
<div class='smallbox_content' style='font-size:13px;'>This will query the list of pending, to be paid of that client.</div>

<br/>

<?php //if(count($booking_info) > 0):?>	
<div id='invoice_div' style='display:none;'>
	
	<div style='float:left;width:100%;padding:5px;'>
			<!--<form id='seat_form' action='' method='post' target='ajaxframe'>-->
			<div id='avseat' style="width:100%;border:1px solid #aaa;background:#ddd;">
				<div id='show_count' style='padding:1px 5px;'><span style='font-size:13px;'>OPTIONAL FILTER: </span>
					<!--<span style='font-size:12px;'><i>This filter will show you the seats available for the indicated date and time.</i></span>--></div>
			<span id='show_count'>Booking Type:</span>
			<select class='inputbox2' name='type' id='type'>
			  <option value="">-- select --</option>
			  <option value="Trial">Trial</option><option value="Transition">Transition</option><option value="Regular">Regular</option>
			</select>
			&nbsp;&nbsp;OR&nbsp;&nbsp;
			<span id='show_count'>Schedule:</span>
			<select class='inputbox2' name='schedule' id='schedule'>
			  <option value="">-- select --</option>
			  <option value="Daily">Daily</option><option value="Monthly">Monthly</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<!--<div style='padding:5px;'>-->
			<input type='button' class='button' value="Filter" name='submit' onclick="class_seat.client_invoice();"/>
			<!--<input type='button' class='button' value="Show me the booking for this date and time" name='submit' onclick="submitPage()" title="This filter will show you the reserved seats for the indicated date and time."/>
			</div>-->
			</div><!--</form>-->
		</div>
	
	
	<ul class="tabs">
	  <li><a href='#clientactive' id='clientname'></a></i></li>
	</ul>
	
 <div class="pane_container">
  <div id="clientactive" class="pane_content">
	  
	  <div id='result' style='float:left;width:80%;'>
	  <table style='width:100%;padding:5px;border:1px solid #aaaaee;' id='result'>
		<tr style='background:#d0d8e8;height:25px;'>		  
		  <td class='invoice_header'>Staff Name</td>
		  <td class='invoice_header'>Booking Date / Hours</td>
		  <td class='invoice_header'># of Hours</td>
		  <td class='invoice_header'>Type</td>
		  <td class='invoice_header'>Schedule</td>
		</tr>
		
  
      </table>

	  </div>
	
  </div>
  
 </div>
</div>
<?php //endif;?>
