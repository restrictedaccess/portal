<div id='template' style='font:12px Arial; padding:10px;  border:#CCCCCC solid 1px;'>
<div>
	<div style='float:left; display:block; width:300px;'>
		<div><img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='267' height='91' /></div>
		<div style='margin-top:10px; padding:5px;'>
		PO Box 1211 Double Bay NSW Australia 1360<br />
		PH: 02 9016 4461<br />
		Fax: 02 8088 7242<br />
		Email: admin@remotestaff.com.au
		
		</div>
	</div>
	<div style='float:right; display:block; width:300px; margin-left:0px;'>
		<div><img src='http://remotestaff.com.au/portal/images/think_innovation.jpg' width='267' height='91' /></div>
		<div style='margin-top:10px; padding:5px;'>
		Think Inovations Pty. Ltd. ABN 37 094 364 511<br />
		Website: www.remotestaff.com.au<br />

		</div>	
	</div>
	
</div>
<div style='clear:both;'></div>
<div style='margin-top:10px; text-align:center; font:bold 16px Arial;'>QUOTE NO. ".$quote_no."</div>
<div style='background:#E9E9E9; border:#E9E9E9 outset 1px; padding:5px; margin-top:10px;'><B>Client</B></div>
<div style='border:#E9E9E9 solid 1px; padding:5px;'>
	<div>
		<div style='float:left; width:400px;'>
			<p><label><b>Leads :</b></label>".strtoupper($leads_name)."</p>
			<p><label><b>Email : </b></label>".$email."</p>
			<p><label><b>Company :</b></label>".$company_name ? $company_name : '&nbsp;'."</p>
			<p><label><b>Address :</b></label>".$company_address ? $company_address : '&nbsp;'."</p>
		</div>	
		<div style='float:left;'>
			<p><label><b>Quoted By: </b></label><b style='color:#990000;'>".getCreator($by , $by_type)."</b></p>
			<p><label><b>Quote Date :</b></label> ".$date."</p>
			<p><label><b>Quote No.</b></label>".$quote_no."</p>
			<p><label><b>Status </b></label>".strtoupper($status)."</p>
			<p><label><b>Date Posted</b></label><span id='date_posted'>".$date_posted ? $date_posted : '&nbsp;'."</span></p>		</div>	
		<div style='clear:both;'></div>	
	</div>
</div>
<div style='background:#D2FFD2 ;border:#D2FFD2 outset 1px; padding:5px; margin-top:10px;'><B>QUOTE DETAILS</B></div>
<div id='quote_details' style='border:#D2FFD2 solid 1px; padding:5px;'>

<div>
		<div style='color:#0000FF; float:left;'><b>Sub-Contractor ".$counter."</b></div>
		<div style='float:right;'>&nbsp;</div>
		<div style='clear:both;'></div>
	</div>
	<div>
		<div style='float:left; display:block; width:300px; padding-left:10px;'>
			<p><b style=' color:#FF0000;'>".$work_position."</b></p>
			<p>".$work_status."</p>
			<p><label>Client Timezone : </label>".$client_timezone."</p>
			<p><label>Working Hours : </label>".$working_hours."</p>
			<p><label>Days Per Week :</label>".$days."</p>
			<p><label>Lunch Hour :</label>".$lunch_hour."</p>
			
		</div>
		<div style='float:left; display:block; width:400px;'>
			<p>".$currency_txt."</p>
			<p><label>Yearly :</label> ".$currency_symbol.number_format($yearly,2,'.',',')."</p>
			<p><label>Monthly : </label>".$currency_symbol.number_format($quoted_price,2,'.',',')."</p>
			<p><label>Weekly : </label>".$currency_symbol.number_format($weekly,2,'.',',')."</p>
			<p><label>Daily : </label>".$currency_symbol.number_format($daily,2,'.',',')."</p>
			<p><label>Hourly :</label> ".$currency_symbol.number_format($hourly,2,'.',',')."</p>
			<p><b>Monthly Quoted Price ".$currency_symbol.number_format($quoted_price,2,'.',',')." + GST ".$currency_symbol.number_format($gst,2,'.',',')."+ Currency Fee ".$currency_symbol.number_format($currency_fee,2,'.',',')."</b></p>
			<p><b style='color:#FF0000'>".$currency_symbol.number_format(($quoted_price+$gst+$currency_fee),2,'.',',')."</b></p>

		</div>
		<div style='clear:both;'></div>
	</div>
	<div style='margin-top:10px;padding:5px; '><b>Sub-Contractor Descriptions</b></div>
	<div style='padding:5px; margin-bottom:10PX; '> - <i>".$work_description."</i></div>
	<div style='margin-top:10px;padding:5px; '><b>Notes</b></div>
	<div style='padding:5px; margin-bottom:3PX; '>
	<div><i>".$notes."</i></div>
	<small style='color:#999999 ; font:10px Tahoma;'>- ".$creatorNotes."</small>
</div>