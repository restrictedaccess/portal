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

<h2>Summary</h2>
<br />


<span style="font-size:13px;font-weight:bold">Today</span>
<table cellpadding='0' cellspacing='0' class='stat0' style='margin-top: 1px;border:1px solid #aaa;'>
<tr><td valign='top' class='stat0'>
    <table cellpadding='0' cellspacing='0' class="stats">
    <tr><td class="header" colspan='4'>Booked Hours</td>
    </tr>
      <tr><td style='padding: 5px 9px 0px 9px;' align='left'><b>UK:</b></td><td align='right'>
	  <a href='?/reports/date/&timezone=UK&date=<?php echo date('m/d/Y');?>'><?php echo $booked_today['uk'];?></a> &nbsp;</td></tr>
      <tr><td style='padding: 0px 9px 0px 9px;' align='left'><b>US:</b></td><td align='right'>
	  <a href='?/reports/date/&timezone=US&date=<?php echo date('m/d/Y');?>'><?php echo $booked_today['us'];?></a> &nbsp;</td></tr>
      <tr><td style='padding: 0px 9px 0px 9px;' align='left'><b>AU:</b></td>
		<td align='right'><a href='?/reports/date/&timezone=AU&date=<?php echo date('m/d/Y');?>'><?php echo $booked_today['au'];?></a> &nbsp;</td></tr>
    </tr>


     </table></td>

    

</tr>
</table>

<br/>
<span style="font-size:15px;font-weight:bold">Monthly Statistics</span>
<table cellpadding='0' cellspacing='0' class='stat0' style='margin-top: 1px;border:1px solid #aaa;'>
<tr><td valign='top' class='stat0'>
    <table cellpadding='0' cellspacing='0' class="stats" border="0">
    <tr><td>&nbsp;</td>
		<?php foreach($month_array as $months => $month):?>
		<td class="header" colspan="4"><?php echo $month;?></td>
		<?php endforeach;?>
		<!--<td class="header" colspan="4">February</td><td class="header" colspan="4">March</td>-->
	</tr>
	
	
	<tr>
		<?php for( $i=0; $i<12; $i++ ):?>
		<td>&nbsp;</td>
			<?php foreach($shift_array as $shifts => $shift):?>
		<td  align="center" style="padding:2px 5px;border-bottom:#666 solid 1px;"><?php echo $shift;?></td>
			<?php endforeach;
		endfor;?>
		
	</tr>
	
	<tr>
		<td class="header">Hours Paid</td>
		
		<?php foreach($paid_array as $hours => $tz_hr):?>
		
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['au'];?></td>
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['uk'];?></td>
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['us'];?></td>
		
		<td>&nbsp;</td>
		<?php endforeach;?>
		
		
	</tr>
	
	<tr>
		<td class="header">Unpaid Hours</td>
		
		<?php foreach($unpaid_array as $hours => $tz_hr):?>
		
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['au'];?></td>
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['uk'];?></td>
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['us'];?></td>
		
		<td>&nbsp;</td>
		<?php endforeach;?>
		
		
	</tr>
	
	<tr>
		<td class="header">Free</td>
		
		<?php foreach($freebooking_array as $hours => $tz_hr):?>
		
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['au'];?></td>
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['uk'];?></td>
		<td  align="center" style="padding:2px 5px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;"><?php echo $tz_hr['us'];?></td>
		
		<td>&nbsp;</td>
		<?php endforeach;?>
		
		
	</tr>
	
	<tr><td class='header'>Booked Seats %</td>
		
		<?php foreach($booked_array as $hours => $tz_hr):?>
			<td  align="center" style="padding:2px 3px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;">
			<?php echo ($tz_hr['au'] > 0) ? sprintf("%2.1f", $tz_hr['au']) : $tz_hr['au'];?>%</td>
			<td  align="center" style="padding:2px 3px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;">
			<?php echo ($tz_hr['uk'] > 0) ? sprintf("%2.1f", $tz_hr['uk']) : $tz_hr['uk'];?>%</td>
			<td  align="center" style="padding:2px 3px;border-right:#666 solid 1px;border-bottom:#666 solid 1px;">
			<?php echo ($tz_hr['us'] > 0) ? sprintf("%2.1f", $tz_hr['us']) : $tz_hr['us'];?>%</td>
			
			<td>&nbsp;</td>
		
		<?php endforeach;?>
	</tr>

    </table></td>


</tr>
</table>


<br />

<?php //if(count($booking_info) > 0):?>	
<!--<div id='invoice_div' style='display:none;'>
	
	

  <div id="clientactive" class="pane_content">-->
	  
	  <div id='result' style='float:left;width:80%;'>
	  <table style='width:50%;padding:5px;border:1px solid #aaaaee;' id='result'>
		<tr style='background:#d0d8e8;height:25px;'>		  
		  <td class='header' colspan='2'>Formula</td>
		  </tr>
		<tr>
		  <td class='item'>Hours Paid:</td><td>From "To Be Paid" to "Paid" per Month</td>
		</tr>
		<tr>
		  <td class='item'>Hours Not Paid:</td><td>All "To Be Paid" per Month</td>
		</tr>
		<tr>
		  <td class='item'>Booked Seat%:</td><td>((No. of Hours per shifting) / (Total seats * 24 * (30.436/3)) * 100</td>
		</tr>
		
  
      </table>

	  </div>
	
  <!--</div>
  

</div>-->
<?php //endif;?>
