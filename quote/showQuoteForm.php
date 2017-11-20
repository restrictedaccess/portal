<?php
include '../config.php';
include '../conf.php';
include '../function.php';

$timezone_identifiers = DateTimeZone::listIdentifiers();
$id = $_REQUEST['id'];
$quote_details_id = $_REQUEST['quote_details_id'];


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

/*
id, quote_id, work_position, salary, client_timezone, client_start_work_hour, client_finish_work_hour, lunch_start, lunch_out, lunch_hour, work_start, work_finish, working_hours, days, quoted_price, work_status, currency, work_description, notes, currency_fee, currency_rate, gst
*/
$query = "SELECT salary, client_timezone, client_start_work_hour, client_finish_work_hour, lunch_start, lunch_out, lunch_hour, work_start, work_finish, working_hours, days, quoted_price,d.id , d.currency , d.work_status ,work_position ,  work_description , currency_rate, gst ,no_of_staff , quoted_quote_range
		   FROM quote_details d 
		   WHERE d.id = $quote_details_id;";

$result = mysql_query($query);
list( $salary, $client_timezone, $client_start_work_hour, $client_finish_work_hour, $lunch_start, $lunch_out, $lunch_hour, $work_start, $work_finish, $working_hours, $days, $quoted_price ,$quote_details_id ,$currency ,$work_status , $work_position ,  $work_description , $currency_rate, $gst ,$no_of_staff , $quoted_quote_range)=mysql_fetch_array($result);
//echo $query;
if ($status == "new") $status = "draft";

if ($gst > 0){
	$checked = 'checked="checked"';
}else{
	$checked = '';
}


if($days==""){
	$days = 5;
}
 
function getCreator($created_by , $created_by_type)
{
	if($created_by_type == 'agent')
	{
		$query = "SELECT fname,work_status FROM agent a WHERE agent_no = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = $row[1]." :".$row[0];
	}
	else if($created_by_type == 'admin')
	{
		$query = "SELECT admin_fname FROM admin a WHERE admin_id = $created_by;";
		$data = mysql_query($query);
		$row = mysql_fetch_array($data);
		$name = "Admin ".$row[0];
	}
	else{
		$name="";
	}
	return $name;
	
}

if($salary==""){
	$salary=0;
}
if($quoted_price==""){
	$quoted_price=0;
}


////

for ($i=0; $i < count($timezone_identifiers); $i++) {
	if($client_timezone == $timezone_identifiers[$i])
	{
		$timezones_Options.="<option selected value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";
	}else{
		$timezones_Options.="<option value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";
	}
}

$timeNum = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","00");
$timeArray = array("1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am");
for($i=0; $i<count($timeNum); $i++)
{
	// Start Work Chosen Country TZ
	if($client_start_work_hour == $timeNum[$i])
	{
		$star_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$star_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	// Finish Work Chosen Country TZ
	if($client_finish_work_hour == $timeNum[$i])
	{
		$finish_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$finish_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	// Lunch Start Phil TZ
	if($lunch_start == $timeNum[$i])
	{
		$lunch_start_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$lunch_start_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	
	// Lunch END Phil TZ
	if($lunch_out == $timeNum[$i])
	{
		$lunch_end_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$lunch_end_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	// Start Work Phil TZ
	//$work_start, $work_finish
	if($work_start == $timeNum[$i])
	{
		$start_work_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$start_work_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	if($work_finish == $timeNum[$i])
	{
		$finish_work_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$finish_work_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
}

//$work_status
//$work_statusLongDescArray = array("Full-Time 9hrs w/ 1hr lunch","Part-Time 4hrs","Project Based","Hourly-Rate");
$work_statusArray = array("Full-Time","Part-Time","Freelancer");
for($i=0;$i<count($work_statusArray);$i++){
	if($work_status == $work_statusArray[$i]){
		$work_status_Options.="<option selected value= ".$work_statusArray[$i].">".getWorkStatusLongDescription($work_statusArray[$i])."</option>";
	}else{
		$work_status_Options.="<option value= ".$work_statusArray[$i].">".getWorkStatusLongDescription($work_statusArray[$i])."</option>";
	}
}

$rateArray=array("AUD","USD","POUND");
$rateSTR=array("AUD","USD","GBP");
for($i=0; $i<count($rateArray);$i++)
{
	if($currency == $rateArray[$i])
	{
		$rate_Options.="<option selected value= ".$rateArray[$i].">".$rateSTR[$i]."</option>";
	}else{
		$rate_Options.="<option value= ".$rateArray[$i].">".$rateSTR[$i]."</option>";
	}
}



if($no_of_staff==""){
	$no_of_staff = 1;
}

?>
<div id="quote_form">
<input type="hidden" id="id" value="<?=$id;?>">
<input type="hidden" id="gst_value" value="<?=$gst;?>">

<div class="hdr"><b>Quote Form</b></div>
<div style="padding:5px; background:#E9E9E9;">
<? if($quote_details_id=="") { ?>
<input type="button" value="Save" onClick="saveQuote();">
<? } else { ?>
<input type="button" value="Update" onClick="updateQuote(<?=$quote_details_id;?>);">
<? }?>
<input type="button" value="Cancel" onClick="showTemplate(<?=$id;?>);">
</div>
<div style="margin-top:20px;">
	<div style="float:left; display:block; width:150px;"><b>Job Position</b></div>
	<input type="text" id="work_position"  class="select" value="<?=$work_position;?>" />
	<div style="clear:both"></div>
</div>
<div style="margin-top:10px;">
	<div style="float:left; display:block; width:150px;"><b>Staff Monthly Salary</b></div>
	<input type="text" id="salary" value=<?=$salary;?> class="select" onKeyUp="setQuote();">
	<div style="clear:both"></div>
</div>
<div style="margin-top:10px;">
	<div style="float:left; display:block; width:150px;"><b>No. of Staff <small>(quantity)</small></b></div>
	<input type="text" id="no_of_staff" name="no_of_staff"  class="select" style="width:40px;" onkeyup="setTotalPrice();" value="<?=$no_of_staff;?>" />
	<span id="total_price" style="margin-left:10px;">here</span>
	<div style="clear:both"></div>
</div>
<div style="margin-top:10px;">
	<div style="float:left; display:block; width:150px;"><b>Work Description</b></div>
	<textarea id="work_description" class="select" rows="4"><?=$work_description;?></textarea>
	<div style="clear:both"></div>
</div>


<div style="margin-top:10px;">
	<div style="float:left; display:block; width:150px;"><b>Choose Timezone</b></div>
	<select name="client_timezone" id="client_timezone"  onChange="setTimeZoneHour();" class="select" >
			<option value="">Please Select</option>
			<?=$timezones_Options;?>
    </select>
	<div style="clear:both"></div>
</div>

<div style="margin-top:10px;">
	<div style="float:left; display:block; width:150px;"><b>Staff Work Status</b></div>
	<select name="work_status" id="work_status"  onChange="setQuote()" class="select" >
			<option value="">Please Select</option>
			<?=$work_status_Options;?>
    </select>
	<div style="clear:both"></div>
</div>


<div style="margin-top:10px;">
	 <div id="client_tz" style="float:left; display:block; width:210px;">
		  <p style="color:#FF0000; "><b>Client Perspective</b></p>
		  <p><label>Start :</label>
		  <select name="client_start_work_hour" id="client_start_work_hour"  onChange="setTimeZoneHour();" class="select" style="width:100px;" >
			<option value="">Please Select</option>
			<?=$star_hours_Options;?>
		  </select>
		  </p>
		   <p><label>Finish :</label>
		 <select name="client_finish_work_hour" id="client_finish_work_hour" class="select" style="width:100px;" onChange="setTimeZoneHour();" >
           <option value="">Please Select</option>
           <?=$finish_hours_Options;?>
         </select>
		  </p>
	</div>
	<div style=" float:left; margin-left:10px; display:block; width:210px;">
 <p style="color:#FF0000"><b>Lunch (Phil Timezone)</b></p>
		<p><label>Start :</label> <select name="lunch_start" id="lunch_start"  onChange="javascript: setWorkHour();" class="select" style="width:100px;" >
	 <option value="">Please Select</option>
      <?=$lunch_start_hours_Options;?>
    </select></p>
	<p><label>Finish :</label><select name="lunch_out" id="lunch_out" class="select" style="width:100px;" onChange="javascript:setWorkHour();" >
	<option value="">Please Select</option>
      <?=$lunch_end_hours_Options;?>
    </select>
	</p>
	<p><label>Lunch Hour</label><input type='text' name='lunch_hour' id='lunch_hour' style='color:#666666;width:20px;' value="<?=$lunch_hour;?>"  class='text' readonly="true"></p>
	</div>
	<div style=" float:left; margin-left:10px; display:block; width:230px;">
	<p style="color:#FF0000; "><b>Staff Perspective (Phil Timezone)</b></p>
	<div id="staff_tz" style="margin-top:10px; " >
	<p><label>Start :</label>
		  <select name="start" id="start"  onChange="setWorkHour();" class="select" style="width:100px;">
		   <option value="">Please Select</option>
			<?=$start_work_hours_Options;?>
		  </select></p>
	<p><label>Finish :</label> <select name="out" id="out" class="select" style="width:100px;" onChange="setWorkHour();" >
	 <option value="">Please Select</option>
			  <?=$finish_work_hours_Options;?>
		</select>
	</p>
	</div>
	<p><label>Working Hour : </label><input type='text' name='hour' id='hour' style='color:#666666;width:20px;' value='<?=$working_hours ? $working_hours : '8';?>' class='text' readonly="true"  /></p>
	<p><label>Days per Week :</label><span><input type='text' name='days'  id='days' style='width:20px;' value="<?=$days;?>" class='text' onKeyUp="javascript:setQuote();" ></span></p>
	</div>
<div style="clear:both"></div>
</div>
<div style="margin-top:10px;">
	<div class="box">
		<div class="hdr"><b>Philippine Pesos</b></div>
		<div id="peso" class="rate"></div>
	</div>
	<div class="box">
		<div class="hdr"><b>Australian Dollar</b></div>
		<div id="aud" class="rate"></div>						  
	</div>
	<div class="box">
		<div class="hdr"><b>US Dollar</b></div>
		<div id="usd" class="rate"></div>							  
	</div>
	<div class="box">
		<div class="hdr"><b>UK Pounds</b></div>
		<div id="uk" class="rate"></div>								  
	</div>
	<div style="clear:both;"></div>
</div>

<div >
<div class="box_margin">&nbsp;</div>
<div class="box_margin">
 Fulltime Margin at 400AUD<br />
                Parttime Margin at 250AUD
</div>
<div class="box_margin">
Fulltime Margin at 400USD<br />
                Parttime Margin at 250USD
</div>
<div class="box_margin">
 Fulltime Margin at 280GBP<br />
                Parttime Margin at 175GBP
</div>

<div style="clear:both;"></div><br />
<div style="padding-left:30px;"><strong>* This above amount is the minimum margin you can add on top of the Staff Monthly Rate converted per currency</strong></div>
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;">
<div class="hdr_quoted"><b>Quoted Charge Out Rate</b></div>
<div id="right_panel_quote">
	<div style="float:left;">
	<div style="margin-top:5px;">
		<div style="float:left; display:block; width:125px;"><b>Quoted Price</b></div>
		<input type="text" id="quoted_price" value="<?=$quoted_price;?>" onKeyUp="setQuoteForClient();" class="select">
		<div style="clear:both"></div>
	</div>
	<div style="margin-top:5px;">
		<div style="float:left; display:block; width:125px;"><b>Quoted Quote Range</b></div>
		<textarea id="quoted_quote_range" class="select" rows="3" ><?=$quoted_quote_range;?></textarea> 
		<div style="clear:both"></div>
	</div>
	<div style="margin-top:5px;">
		<div style="float:left; display:block; width:125px;"><b>Currency Rate</b></div>
		<select name="currency" id="currency"  onChange="setQuoteForClient();" class="select">
							<?=$rate_Options;?>
		  </select>
		<div style="clear:both"></div>
	</div>
	<div style="margin-top:5px;">
		<div id="tax_str" style="float:left; display:block; width:125px; font-weight:bold;">GST</div>
			<span id="tax_input_div"><input type="checkbox" id="gst" name="gst" <?=$checked;?>  /></span>
		<div style="clear:both"></div>
	</div>
	<div style="margin-top:5px;">
		<div style="float:left; display:block; width:125px;"><b>Currency Fee</b></div>
		<input type="text" id="currency_rate" value="<?=$currency_rate;?>" class="select">
		<div style="clear:both"></div>
	</div>
	<div id="client_total_price" style="margin-top:10px;"></div>
	</div>


<div style="float:left; margin-left:10px;">
			  <div class="box">
			  		<div id="quoted_price_hdr" class="hdr_q"></div>
					<div id="quoted_price_div" class="rate"></div>						  
			  </div>
			   <div  style="float:left; margin-left:10px; text-align:center; color:#999999;">
			   All quotes are best estimations <br>
			and could vary between <br>
				$100 to $200 dollars <br>
			from quoted price.
			   </div>
			  <div style="clear:both;"></div>
	  </div>
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
</div>
<div style="padding:5px; background:#E9E9E9;">
<? if($quote_details_id=="") { ?>
<input type="button" value="Save" onClick="saveQuote();">
<? } else { ?>
<input type="button" value="Update" onClick="updateQuote(<?=$quote_details_id;?>);">
<? }?>
<input type="button" value="Cancel" onClick="showTemplate(<?=$id;?>);">
</div>
</div>