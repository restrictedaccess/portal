<div style='font:12px Arial; border:#CCCCCC solid 1px; width:720px; padding:10px;'>
<div style='font:12px Arial; color:#999999;'>
		<div style='float:left; width:330px; ' >
			<p><img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='267' height='91' /></p>
			104 / 529 Old South Head Road, Rose Bay, NSW 2029<br />
			Phone:<br />
- 02 8088 7247 (Tam)<br />
- 02 8005 1383 (Angeli)<br />
- 02 8003 4576 (Rhiza)<br />
			Email: admin@remotestaff.com.au
			
		</div>
		<div style=' margin-left:10px; float:left;' >
			<p><img src='http://remotestaff.com.au/portal/images/think_innovation.jpg' width='267' height='91' /></p>
			Think Inovations Pty. Ltd. ABN 37 094 364 511<br />
			Website: www.remotestaff.com.au<br />
		</div>
		<div style='clear:both;'></div>
	</div>
	<hr />
	<!-- Lead Info -->
<div>
	<div style='margin-bottom:10px; margin-top:10px;'>
		<div  >
			<p><label >To :</label>".$leads_name."</p>
			<p><label >Email :</label>".$leads_email."</p>
			<p><label>Company :</label>".$leads_company."</p>
			<p><label>Address :</label>".$leads_address."</p>
		</div>
		<div style='color:#999999;  margin-top:10px;'>
			From : ".getCreator($drafted_by, $drafted_by_type)."
		</div>
	</div>
		<hr />
	<div style='margin-bottom:10px; margin-top:10px;'>
		<p><label style='float:left; display:block; width:90px;'>Status :</label> Waiting for your immediate payment before your recruitment process begin</p>
		<p><label style='float:left; display:block; width:90px;'>Date Created :</label>".$draft_date."</p>
	</div>
	
	<!--Details -->
	<div style=' margin-top:20px;'>
		<div style=' padding:2px; background:#CCCCCC; border:#CCCCCC outset 1px; text-align:right; color:#666666;'>Set-Up Fee Tax Invoice Details</div>
		<div style='padding:10px; margin:5px; text-align:center;'><b>SET-UP FEE TAX INOICE ".$invoice_number."</b></div>
	
		<div style='font-weight:bold; color:#FF0000;'>
			<div style='float:left; width:40px; border:#666666 solid 1px; padding:5px;display:block;'>Item</div>
			<div style='float:left; width:470px; border:#666666 solid 1px; padding:5px;display:block;'>Description</div>
			<div style='float:left; width:150px; border:#666666 solid 1px; padding:5px;display:block;'>Amount</div>
			<div style='clear:both;'></div>
		</div>
		<div id='set_up_fee_invoice_details' >".$data."</div>
	</div>
	<!-- Payment Details -->
		<div id='payment_details' style=' margin-top:10px; padding-right:20px;'>
			<div style='text-align:right;'>".$currency_txt."</div>
			<div>
			<div style=' float:right;width:100px; text-align:right;'>".$currency_symbol." <span id='sub_total'>".number_format($sub_total,2,'.',',')."</span></div>
			<div style='float:right;  display:block;'><b>Sub Total : </b></div>
			<div style='clear:both;'></div>
			</div>
			<div>
			<div style=' float:right;width:100px;text-align:right;'>".$currency_symbol." <span id='gst'>".number_format($gst,2,'.',',')."</span></div>
			<div style='float:right;  display:block;'><b>GST : </b></div>
			<div style='clear:both;'></div>
			</div>
			<div>
			<div style=' float:right; width:100px;text-align:right;'>".$currency_symbol." <span id='total'>".number_format($total_amount,2,'.',',')."</span></div>
			<div style='float:right;  display:block;'><b>TOTAL : </b></div>
			<div style='clear:both;'></div>
			</div>
		</div>
		<div style='margin-top:10px; text-align:center; color:#999999;'><i>
		Think Innovations - Remote Staff only issued electronic Tax Invoices
		</i>
		</div>
		<div style='clear:both;'></div>

</div>