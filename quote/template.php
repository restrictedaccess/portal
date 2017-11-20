<?

include '../config.php';
include '../conf.php';
include '../function.php';

$timezone_identifiers = DateTimeZone::listIdentifiers();
$id = $_REQUEST['id'];


$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}
if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
}

// id, created_by, created_by_type, leads_id, date_quoted, quote_no, status
$query = "SELECT q.quote_no, DATE_FORMAT(date_quoted,'%D %b %Y'),CONCAT(l.fname,' ',l.lname) , l.email,l.company_name, q.created_by, q.created_by_type , DATE_FORMAT(q.date_posted,'%D %b %Y') , l.company_address , q.status , ran
		   FROM quote q 
		   LEFT JOIN leads l ON l.id = q.leads_id 
		    WHERE q.id = $id;";
$result = mysql_query($query);
list($quote_no,$date,$leads_name,$email, $company_name ,$by, $by_type , $date_posted , $company_address , $status , $ran )=mysql_fetch_array($result);
//echo $query;
 if ($status == "new") $status = "draft";
 
function getCreator($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT fname,work_status,lname FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = $row[1]." :".$row[0]." ".$row[2];
	}
	else if($created_by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT admin_fname,admin_lname FROM admin a WHERE admin_id = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Admin ".$row[0]." ".$row[1];
	}
	else{
		$name="";
	}
	return $name;
	
}
function getCreatorEmail($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT * FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$email = $row['email'];
	}
	else if($created_by_type == 'admin')
	{
		//return "Admin Norman";
		$query = "SELECT * FROM admin a WHERE admin_id = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$email = $row['admin_email'];
	}
	else{
		$email="";
	}
	return $email;
	
}



?>

<input type="hidden" id="id" value="<?=$id;?>">
<div id="template">
<div id="quote_status"></div>
<div>
	<div style="float:left; display:block; width:300px;">
		<div><img src='images/remote_staff_logo.png' width='267' height='91' /></div>
		<div style="margin-top:10px; padding:5px;">
		PO  Box  327 Balmain NSW 2041<br />
		PH: 02 9016 4461<br />
		Fax: 02 8088 7242<br />
		Email: <?=getCreatorEmail($by , $by_type);?>
		
		</div>
	</div>
	<div style="float:right; display:block; width:300px; margin-left:0px;">
		<div><img src='images/think_innovations_logo.png' width='267' height='102' /></div>
		<div style="margin-top:10px; padding:5px;">
		Think Inovations Pty. Ltd. ABN 37 094 364 511<br />
		Website: www.remotestaff.com.au<br />

		</div>	
	</div>
	
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px; text-align:center; font:bold 16px Arial;">QUOTE NO. <?=$quote_no;?></div>
<div style="background:#E9E9E9; border:#E9E9E9 outset 1px; padding:5px; margin-top:10px;"><B>Client</B></div>
<div style="border:#E9E9E9 solid 1px; padding:5px;">
	<div>
		<div style="float:left; width:400px;">
			<p><label><b>Leads :</b></label><?=strtoupper($leads_name);?></p>
			<p><label><b>Email : </b></label><?=$email;?></p>
			<p><label><b>Company :</b></label><?=$company_name ? $company_name : '&nbsp;';?></p>
			<p><label><b>Address :</b></label><?=$company_address ? $company_address : '&nbsp;';?></p>
		</div>	
		<div style="float:left;">
			<p><label><b>Quoted By: </b></label><b style="color:#990000;"><?=getCreator($by , $by_type);?></b></p>
			<p><label><b>Quote Date :</b></label> <?=$date;?></p>
			<p><label><b>Quote No.</b></label><?=$quote_no;?></p>
			<p><label><b>Status </b></label><?=strtoupper($status);?></p>
			<p><label><b>Date Posted</b></label><span id="date_posted"><?=$date_posted ? $date_posted : '&nbsp;';?></span></p>		</div>	
		<div style="clear:both;"></div>	
	</div>
</div>
<div style="padding:5px;">
<input type="button" value="Add Quote Details" onClick="showQuoteForm(<?=$id;?>);" />
<!--<input type="button" value="Post" onClick="postQuote();">
<input type="button" value="Export to PDF" onClick="self.location='pdf_report/quote/?ran=<? echo $ran;?>'">
-->
<input type="button" value="Delete" onClick="deleteQuote();">
<input type="button" value="Cancel" onClick="hide('template');">
</div>
<div id="message_form" style="padding:5px;"></div>


<div class="quote_details_hdr"><B>QUOTE DETAILS</B></div>
<div id="quote_details"  >
<?
/*
id, quote_id, work_position, salary, client_timezone, client_start_work_hour, client_finish_work_hour, lunch_start, lunch_out, lunch_hour, work_start, work_finish, working_hours, days, quoted_price, work_status, currency, work_description, notes, currency_fee, currency_rate, gst, no_of_staff

*/
$query = "SELECT id , work_position ,client_timezone ,working_hours, days, quoted_price, work_status, currency, work_description, lunch_hour, currency_fee, gst, no_of_staff , quoted_quote_range , client_start_work_hour, client_finish_work_hour FROM quote_details q WHERE quote_id = $id;";
//echo $query;
$result = mysql_query($query);
$counter=0;
while(list($quote_details_id , $work_position ,$client_timezone ,$working_hours, $days, $quoted_price, $work_status, $currency, $work_description , $lunch_hour ,
$currency_fee, $gst , $no_of_staff , $quoted_quote_range , $client_start_work_hour , $client_finish_work_hour )=mysql_fetch_array($result))
{	
	$counter++;
	if($currency == "AUD"){
	$currency_txt = "Sub-Contractor Salary in Australian Dollar (AUD)";
	$currency_symbol = "\$ ";
	}
	
	if($currency == "USD"){
		$currency_txt = "Sub-Contractor Salary in United States Dollar (USD)";
		$currency_symbol = "\$ ";
	}
	
	if($currency == "POUND"){
		$currency_txt = "Sub-Contractor Salary in United Kingdom Pounds (POUNDs)";
		$currency_symbol = "&pound; ";
	}
	$yearly = $quoted_price * 12;
	$weekly = $yearly / 52;
	$daily = $weekly / $days;
	$hourly = $daily / $working_hours;
?>
	<div class="quote_det_wrapper">
	<div >
		<div style="color:#FF0000; float:left;"><b>Sub-Contractor <?=$counter;?></b></div>
		<div style="float:right;"><a href="javascript:ShowMessageForm(<?=$quote_details_id;?>);">Add Notes</a> | <a href="javascript:showQuoteForm(<?=$id;?>,<?=$quote_details_id;?>);">Edit</a> | <a href="javascript:deleteQuoteDetails(<?=$id;?>,<?=$quote_details_id;?>);">Delete</a></div>
		<div style="clear:both;"></div>
	</div>
	<div style="padding:5px;">
		<div style=" float:left; color:#000066;"><b>Job Title : <?=$work_position;?></b></div>
		<div style="float:right;"><?=$currency_txt;?></div>
		<div style="clear:both;"></div>
	<? if ($work_description!="") {?>
		<div style="color:#999999; margin-top:5px;"><b>Descriptions :</b> <i><?=$work_description;?></i></div>
	<? } ?>
	</div>
	<hr />
	<div>
		<div style="float:left; display:block; width:260px; padding-left:10px;">
			<p><?=getWorkStatusLongDescription($work_status);?></p>
			<p><label>Client Timezone : </label><?=$client_timezone ? $client_timezone : "&nbsp;";?></p>
			<p><label>Time : </label><?=setConvertTimezones($client_timezone, $client_timezone , $client_start_work_hour, $client_finish_work_hour);?></p>
			<p><label>Working Hours : </label><?=$working_hours;?></p>
			<p><label>Days Per Week :</label><?=$days;?></p>
			<p><label>Lunch Hour :</label><?=$lunch_hour;?></p>
			
		</div>
		<div style="float:left; display:block; width:200px;">
			<p><label>Yearly :</label> <?=$currency_symbol.number_format($yearly,2,'.',',');?></p>
			<p style="background:#FFFFCC;"><b><label>Monthly : </label><?=$currency_symbol.number_format($quoted_price,2,'.',',');?></b></p>
			<p><label>Weekly : </label><?=$currency_symbol.number_format($weekly,2,'.',',');?></p>
			<p><label>Daily : </label><?=$currency_symbol.number_format($daily,2,'.',',');?></p>
			<p style="background:#FFFFCC;"><b><label>Hourly :</label> <?=$currency_symbol.number_format($hourly,2,'.',',');?></b></p>
		</div>
		<div style="float:right; display:block; width:200px;">
			<p align="right"><label style="width:120px;">Monthly Quoted Price</label> <?=$currency_symbol.number_format($quoted_price,2,'.',',');?></p>
			
			<?
			//echo "No of STaff : ".$no_of_staff;
			if($no_of_staff > 0){
			echo "<p align='right'><label style='width:120px;'>No. of Staff</label> x ".$no_of_staff."</p>";
			echo "<p align='right'>-----------------</p>";
			echo "<p align='right'>".$currency_symbol.number_format($quoted_price*$no_of_staff,2,'.',',')."</p>";
			//"AUD","USD","POUND"
			if($currency == "AUD"){
				echo "<p align='right'><label style='width:120px;'>GST</label>+ ".$currency_symbol.number_format($gst,2,'.',',')."</p>";
			}
			if($currency == "POUND"){
				echo "<p align='right'><label style='width:120px;'>VAT</label>+ ".$currency_symbol.number_format($gst,2,'.',',')."</p>";
			}
			if($currency == "USD"){
				//echo "<p align='right'><label style='width:120px;'>TAX</label>+ ".$currency_symbol.number_format($gst,2,'.',',')."</p>";
				echo "";
			}
			echo "<p align='right'>-----------------</p>";
			echo "<p align='right' style='background:yellow;'><b><label style='width:120px;'>TOTAL</label>".$currency_symbol.number_format($quoted_price*$no_of_staff+$gst,2,'.',',')."</b></p>";
			}
			else{
			echo "<p align='right'><label style='width:120px;'>GST</label>+ ".$currency_symbol.number_format($gst,2,'.',',')."</p>";
			echo "<p align='right'>-----------------</p>";
			echo "<p align='right' style='background:yellow;'><b><label style='width:120px;'>TOTAL</label>".$currency_symbol.number_format($quoted_price+$gst,2,'.',',')."</b></p>";
			}
			?>
		
		</div>
		<div style="clear:both;"></div>
		<?  if($quoted_quote_range!="") { ?>
			<div><b>Quoted Quote Range : </b><?=$quoted_quote_range;?></div>
		<? }?>
	</div>
	
	
	
	<?
	// id, quote_id, created_by, created_by_type, notes, date_note
	$sql = "SELECT id, notes , created_by, created_by_type FROM quote_notes WHERE quote_id = $id AND quote_details_id = $quote_details_id ORDER BY id DESC;";
	$data = mysql_query($sql);
	if(mysql_num_rows($data) > 0) {
	echo '<div style="margin-top:10px;padding:5px;"><b>Notes</b></div>';
	while(list($note_id, $notes , $created_by, $created_by_type)=mysql_fetch_array($data))
	{
		
		$creatorNotes = getCreator($created_by , $created_by_type);
	?>
		<div style="margin-top:5px; border-bottom:#E9E9E9 solid 1px; ">
			<div style="float:left; display:block; width:600px; ">
				<div><i><?=$notes;?></i></div>
				<small style="color:#999999 ; font:10px Tahoma;">- <?=$creatorNotes;?></small>
			</div>
			<div style="float:right;">
				<a href="javascript:deleteNote(<?=$note_id;?>)">X</a>
			</div>
			<div style="clear:both;"></div>
		</div>
		
	<?
	}
	}
	?>
	</div>
	
<?	
}

?>
</div>

<div style="color:#666666; text-align:center;">Quotes are best guess indication and may vary depending on the offshore labour market conditions in any given month. <br />Quotes are valid for only one month
</div>

</div>