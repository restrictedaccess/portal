<?php
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}

$admin_id = $_SESSION['admin_id'];
$userid=$_REQUEST['userid'];

$queryApplicant="SELECT * FROM personal p  WHERE p.userid=$userid";
$row=$db->fetchRow($queryApplicant);
$name =$row['fname']."  ".$row['lname'];

$timeNum = array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");
$timeArray = array("-","1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am");
for($i=0; $i<count($timeNum); $i++)
{
	if($starting_hours == $timeNum[$i])
	{
		$start_work_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	else
	{
		$start_work_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	if($ending_hours == $timeNum[$i])
	{
		$finish_work_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	else
	{
		$finish_work_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
}


$daynameArray = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
for($i=0;$i<count($daynameArray);$i++)
{
	$daysOptions.="<option value= ".$daynameArray[$i].">".$daynameArray[$i]."</option>";
}



/*
SELECT * FROM evaluation e; 
id, userid, created_by, evaluation_date, work_fulltime, fulltime_sched, work_parttime, parttime_sched, work_freelancer, expected_minimum_salary, notes
*/

$sql = "SELECT id,DATE_FORMAT(evaluation_date,'%D %b %Y') AS evaluation_date, work_fulltime, fulltime_sched, work_parttime, parttime_sched, work_freelancer, expected_minimum_salary FROM evaluation WHERE userid = $userid;";
$row = $db->fetchRow($sql);

$evaluation_id = $row["id"];
$evaluation_date = $row["evaluation_date"];
$work_fulltime = $row["work_fulltime"];
$fulltime_sched = $row["fulltime_sched"];
$work_parttime = $row["work_parttime"];
$parttime_sched = $row["parttime_sched"];
$work_freelancer = $row["work_freelancer"];
$expected_minimum_salary = $row["expected_minimum_salary"];

if($evaluation_date!=""){
	$evaluation_date = "<p><label>Evaluation Date: </label>".$evaluation_date."</p>";
}

if($work_fulltime == "yes"){
	$work_fulltime = 'checked="checked"';
	$show_full_time_div = "style='display:block;'";
}else{
	$show_full_time_div = "style='display:none;'";
}

if($work_parttime == "yes"){
	$work_parttime = 'checked="checked"';
	$show_part_time_div = "style='display:block;'";
}else{
	$show_part_time_div = "style='display:none;'";
}

if ($work_freelancer == "yes"){
	$work_freelancer =  'checked="checked"';
	$show_freelancer_div = "style='display:block;'";
}else{
	$show_freelancer_div = "style='display:none;'";
}


//START - get hot staff
$ctr=$db->fetchRow("SELECT id FROM hot_staff WHERE userid='$userid' LIMIT 1");
$hot = '';
if ($ctr)
{
	$hot = 'checked="checked"';
}
//ENDED - get hot staff


//START - get experienced staff
$ctr=$db->fetchRow("SELECT id FROM experienced_staff WHERE userid='$userid' LIMIT 1");
$experienced = '';
if ($ctr)
{
	$experienced = 'checked="checked"';
}
//ENDED - get experienced staff


//START - full time timezone/shifts and part time timezone/shifts
$result =  $db -> fetchAll("SELECT time_zone, p_timezone, p_time FROM staff_timezone WHERE userid='$userid' LIMIT 1");
foreach ($result as $r)
{
	$data_set = $r["time_zone"];
	$data_set_p = $r["p_timezone"];
	$p_time = $r["p_time"];
}


	//start - get time defirence of part time
	$hr = date("H", strtotime($p_time));
	$min = date("i", strtotime($p_time));
	$hr = $hr + 4;
	if($hr > 24)
	{
		$hr = $hr - 24;
	}
	$p_time2 = $hr.":".$min.":00";
	//ended - get time defirence of part time


	//start - staff timezone full time
	$US = stristr($data_set, "US");
	$AU = stristr($data_set, "AU");
	$UK = stristr($data_set, "UK");
	$ANY = stristr($data_set, "ANY");
	
	$a_n_y = "checked";
	$a_u = "checked";
	$u_k = "checked";
	$u_s = "checked";
	
	if($ANY === FALSE)
	{	
		$a_n_y = "";
	}
	if($AU === FALSE)
	{
		$a_u = "";
	}
	if($UK === FALSE)
	{
		$u_k = "";
	}
	if($US === FALSE)
	{
		$u_s = "";
	}

	$fulltime_timezone = '
						<table>
							<tr>
								<td><strong>SELECTED TIMEZONE: </strong>(autosave) </td>
								<td width=20%>'.$data_set.'</td>
							</tr>        
							<tr>
								<td><strong>Australian Shift</strong><font size=1> (7am to 4pm Manila Time +/-DST)</font></td>
								<td><input type="checkbox" name="tz1_name" id="tz1" onClick="staff_timezone(\''.$userid.'\',1,\'AU\',\'fulltime\');" '.$a_u.' />Yes </td>
							</tr>
							<tr>
								<td><strong>UK Shift</strong><font size=1> (4pm to 1am Manila Time +/-DSTcheckTimeZone)</font></td>
								<td><input type="checkbox" name="tz2_name" id="tz2" onClick="staff_timezone(\''.$userid.'\',2,\'UK\',\'fulltime\');" '.$u_k.' />Yes </td>
							</tr>
							<tr>
								<td><strong>US </strong><font size=1> (Night Shift)</font></td>
								<td><input type="checkbox" name="tz3_name" id="tz3" onClick="staff_timezone(\''.$userid.'\',3,\'US\',\'fulltime\');" '.$u_s.' />Yes </td>
							</tr>
							<tr>
								<td><strong>Any Shift</strong></td>
								<td><input type="checkbox" name="tz4_name" id="tz4" onClick="staff_timezone(\''.$userid.'\',4,\'ANY\',\'fulltime\');" '.$a_n_y.' />Yes </td>
							</tr>
							<tr>
								<td><strong>&nbsp;</strong></td>
								<td>&nbsp;</td>
							</tr>	
							<tr>
								<td><strong>&nbsp;</strong></td>
								<td>&nbsp;</td>
							</tr>							
						</table>                    
						';
	//ended - staff timezone full time					


	//start - staff timezone part time
	$US = stristr($data_set_p, "US");
	$AU = stristr($data_set_p, "AU");
	$UK = stristr($data_set_p, "UK");
	$ANY = stristr($data_set_p, "ANY");
	
	$a_n_y = "checked";
	$a_u = "checked";
	$u_k = "checked";
	$u_s = "checked";
	
	
	//START - any status
	if($ANY === FALSE)
	{	
		$a_n_y = "";
	}
	else
	{
	}
	//ENDED - any status
	
	
	//START - au status w/ time conversation
	if($AU === FALSE)
	{
		$a_u = "";
		$a_u_PT = "";
	}
	else
	{
		//time conversion - AU PART TIME 1
		$ref_date = date("Y-m-d")." ".$p_time;
		$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		date_default_timezone_set("Asia/Manila");
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
							
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		$destination_date = clone $date;
		$destination_date->setTimezone("Australia/Sydney");
		$a_u_PT = $destination_date;
		$a_u_PT = date("g:i a", strtotime($a_u_PT));
		//ended		
		
		//time conversion - AU PART TIME 2
		$ref_date = date("Y-m-d")." ".$p_time2;
		$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		date_default_timezone_set("Asia/Manila");
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
							
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		$destination_date = clone $date;
		$destination_date->setTimezone("Australia/Sydney");
		$a_u_PT2 = $destination_date;
		$a_u_PT2 = date("g:i a", strtotime($a_u_PT2));
		//ended			
	}
	//ENDED - au status w/ time conversation
	
	
	//START - uk status w/ time conversation
	if($UK === FALSE)
	{
		$u_k = "";
		$u_k_PT = "";
	}
	else
	{
		//time conversion - AU PART TIME 1
		$ref_date = date("Y-m-d")." ".$p_time;
		$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		date_default_timezone_set("Asia/Manila");
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');

		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		$destination_date = clone $date;
		$destination_date->setTimezone("Europe/London");
		$u_k_PT = $destination_date;
		$u_k_PT = date("g:i a", strtotime($u_k_PT));
		//ended		
		
		//time conversion - AU PART TIME 2
		$ref_date = date("Y-m-d")." ".$p_time2;
		$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		date_default_timezone_set("Asia/Manila");
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');

		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		$destination_date = clone $date;
		$destination_date->setTimezone("Europe/London");
		$u_k_PT2 = $destination_date;
		$u_k_PT2 = date("g:i a", strtotime($u_k_PT2));
		//ended			
	}
	//ENDED - uk status w/ time conversation
	
	
	//START - us status w/ time conversation
	if($US === FALSE)
	{
		$u_s = "";
		$u_s_PT = "";
	}
	else
	{
		//time conversion - US PART TIME
		$ref_date = date("Y-m-d")." ".$p_time;
		$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		date_default_timezone_set("Asia/Manila");
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
							
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		$destination_date = clone $date;
		$destination_date->setTimezone("America/New_York");
		$u_s_PT = $destination_date;
		$u_s_PT = date("g:i a", strtotime($u_s_PT));
		//ended		
		
		//time conversion - US PART TIME
		$ref_date = date("Y-m-d")." ".$p_time2;
		$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		date_default_timezone_set("Asia/Manila");
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
							
		$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
		$destination_date = clone $date;
		$destination_date->setTimezone("America/New_York");
		$u_s_PT2 = $destination_date;
		$u_s_PT2 = date("g:i a", strtotime($u_s_PT2));
		//ended			
	}
	//ENDED - us status w/ time conversation
		

	$hr = date("H", strtotime($p_time));
	if($hr == "" || $hr == NULL)
	{
		$hr = "<OPTION VALUE='' SELECTED>Hour</OPTION>";
	}
	else
	{
		if($hr <= 12)
		{
			$hr = "<OPTION VALUE='".$hr."' SELECTED>".$hr." AM</OPTION>";
		}
		else
		{
			$hr_display = $hr - 12;
			$hr = "<OPTION VALUE='".$hr."' SELECTED>".$hr_display." PM</OPTION>";
		}
	}
	$min = date("i", strtotime($p_time));
	if($min == "" || $min == NULL)
	{
		$min = '<option value="" selected>Minute</option>';
	}
	else
	{
		$min = '<option value="'.$min.'" selected>'.$min.'</option>';
	}
	$parttime_timezone = '
						<table>
							<tr>
								<td><strong>SELECTED TIMEZONE: </strong>(autosave) </td>
								<td width=20%>'.$data_set_p.'</td>
							</tr>        
							<tr>
								<td><strong>Australian Shift</strong><font size=1> ('.$a_u_PT.' to '.$a_u_PT2.')</font></td>
								<td><input type="checkbox" name="tz1_name" id="tz_pt1" onClick="staff_timezone(\''.$userid.'\',1,\'AU\',\'parttime\');" '.$a_u.' />Yes </td>
							</tr>
							<tr>
								<td><strong>UK Shift</strong><font size=1> ('.$u_k_PT.' to '.$u_k_PT2.')</font></td>
								<td><input type="checkbox" name="tz2_name" id="tz_pt2" onClick="staff_timezone(\''.$userid.'\',2,\'UK\',\'parttime\');" '.$u_k.' />Yes </td>
							</tr>
							<tr>
								<td><strong>US</strong><font size=1> ('.$u_s_PT.' to '.$u_s_PT2.')</font></td>
								<td><input type="checkbox" name="tz3_name" id="tz_pt3" onClick="staff_timezone(\''.$userid.'\',3,\'US\',\'parttime\');" '.$u_s.' />Yes </td>
							</tr>
							<tr>
								<td><strong>Any Shift</strong></td>
								<td><input type="checkbox" name="tz4_name" id="tz_pt4" onClick="staff_timezone(\''.$userid.'\',4,\'ANY\',\'parttime\');" '.$a_n_y.' />Yes </td>
							</tr>
							<tr>
								<td><strong>Time Availability</strong><font size=1> (manila time)</font></td>
								<td>
										<table>
											<tr>
											<td>
												<SELECT ID="start_hour_id" NAME="start_hour" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">
												'.$hr.'
												<OPTION VALUE=1>1 AM</OPTION>
												<OPTION VALUE=2>2 AM</OPTION>
												<OPTION VALUE=3>3 AM</OPTION>
												<OPTION VALUE=4>4 AM</OPTION>
												<OPTION VALUE=5>5 AM</OPTION>
												<OPTION VALUE=6>6 AM</OPTION>
												<OPTION VALUE=7>7 AM</OPTION>
												<OPTION VALUE=8>8 AM</OPTION>
												<OPTION VALUE=9>9 AM</OPTION>
												<OPTION VALUE=10>10 AM</OPTION>
												<OPTION VALUE=11>11 AM</OPTION>
												<OPTION VALUE=12>12 AM</OPTION>
												<OPTION VALUE=13>1 PM</OPTION>
												<OPTION VALUE=14>2 PM</OPTION>
												<OPTION VALUE=15>3 PM</OPTION>
												<OPTION VALUE=16>4 PM</OPTION>
												<OPTION VALUE=17>5 PM</OPTION>
												<OPTION VALUE=18>6 PM</OPTION>
												<OPTION VALUE=19>7 PM</OPTION>
												<OPTION VALUE=20>8 PM</OPTION>
												<OPTION VALUE=21>9 PM</OPTION>
												<OPTION VALUE=22>10 PM</OPTION>
												<OPTION VALUE=23>11 PM</OPTION>
												<OPTION VALUE=24>12 PM</OPTION>
												</SELECT>											
											</td>
											<td>
												<select id="start_minute_id" name="start_minute" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;">
												'.$min.'
												<option value="00">00</option>
												<option value="01">01</option>
												<option value="02">02</option>
												<option value="03">03</option>
												<option value="04">04</option>
												<option value="05">05</option>
												<option value="06">06</option>
												<option value="07">07</option>
												<option value="08">08</option>
												<option value="09">09</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="16">16</option>
												<option value="17">17</option>
												<option value="18">18</option>
												<option value="19">19</option>
												<option value="20">20</option>
												<option value="21">21</option>
												<option value="22">22</option>
												<option value="23">23</option>
												<option value="24">24</option>
												<option value="25">25</option>
												<option value="26">26</option>
												<option value="27">27</option>
												<option value="28">28</option>
												<option value="29">29</option>
												<option value="30">30</option>
												<option value="31">31</option>
												<option value="32">32</option>
												<option value="33">33</option>
												<option value="34">34</option>
												<option value="35">35</option>
												<option value="36">36</option>
												<option value="37">37</option>
												<option value="38">38</option>
												<option value="39">39</option>
												<option value="40">40</option>
												<option value="41">41</option>
												<option value="42">42</option>
												<option value="43">43</option>
												<option value="44">44</option>
												<option value="45">45</option>
												<option value="46">46</option>
												<option value="47">47</option>
												<option value="48">48</option>
												<option value="49">49</option>
												<option value="50">50</option>
												<option value="51">51</option>
												<option value="52">52</option>
												<option value="53">53</option>
												<option value="54">54</option>
												<option value="55">55</option>
												<option value="56">56</option>
												<option value="57">57</option>
												<option value="58">58</option>
												<option value="59">59</option>
												</select>												
											</td>
											<td>
												<input type="button" value="Set" onClick="javascript: staff_time('.$userid.'); " style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;" />
											</td>
											</tr>
										</table>                                            								
								</td>
							</tr>							
						</table>                    
						';
	//ended - staff timezone part time


$shift_Array = array("Morning-Shift","Afternoon-Shift","Night-Shift","Anytime");
for($i=0; $i<count($shift_Array); $i++)
{
	
	//full time shift
	$fulltime_shifts = "<input type='hidden' name='full_time_shift' value=''>";
	if($fulltime_sched == $shift_Array[$i])
	{
		$fulltime_shifts = "<input type='hidden' name='full_time_shift' value='".$shift_Array[$i]."'>"; 
		//$fulltime_shifts .= "<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='full_time_shift' checked='checked' value=".$shift_Array[$i]." ></p>";
	}
	//else
	//{
		//$fulltime_shifts .= "<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='full_time_shift' value=".$shift_Array[$i]." ></p>";
	//}
	//ended
	
	
	//part time shift
	$parttime_shifts = "<input type='hidden' name='part_time_shift' value=''>";
	if($parttime_sched == $shift_Array[$i])
	{
		$parttime_shifts = "<input type='hidden' name='part_time_shift' value='".$shift_Array[$i]."'>";
		//$parttime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='part_time_shift' checked='checked' value=".$shift_Array[$i]." ></p>";
	}
	//else
	//{
	//	$parttime_shifts.="<p><span style='float:left; width:85px;'>".$shift_Array[$i]."</span> <input  type='radio' name='part_time_shift' value=".$shift_Array[$i]." ></p>";
	//}
	//ended
	
}
$fulltime_report = $fulltime_timezone.$fulltime_shifts;
$parttime_report = $parttime_timezone.$parttime_shifts;
//ENDED - full time timezone/shifts and part time timezone/shifts

?>
	<html>
    <head>
    	
    	<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(".evaluate-link").click(function(e){
					var url = jQuery(this).attr("href");
					window.open(url,'_blank','width=477,height=377,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
					e.preventDefault();
				});
			});
    	</script>
    <title>Staff Evaluation</title></head>
	<body>    
	<form name="form">
		<div style="padding:5px; border:#FFFFFF solid 1px;font:12px Arial; background:#FFFFFF;">
        <table width="100%" border="0" cellpadding="3" cellspacing="3">
          <tr>
          	<td colspan="2" width="50%">
                <?php echo $evaluation_date; ?>
                <p>
                	<label>Expected Minimum Salary&nbsp;</label><input type="text" id="expected_minimum_salary" maxlength="15" size="25" value="<?=$expected_minimum_salary;?>" >&nbsp;&nbsp;
                    <input type="checkbox" name="hot" value="hot" <?=$hot;?>><label>Mark as HOT!</label>&nbsp;&nbsp;
                    <input type="checkbox" name="experienced" value="experienced" <?=$experienced;?>><label>Mark as Experienced!</label>
				</p>
                <p>
                    <label>
                    Add Evaluation Comments <input type="text" name="notes" id="notes" style="width:430px; font:11px tahoma;" />
                    <input type="button" value="Add Comment" onClick="javascript: addComment(this.form); " />
                    </label>
                    <input type="userid" name="userid" id="userid" value="<?php echo $userid; ?>" style="width:0px; font:0px tahoma;"/>
                </p>
            </td>
          </tr>
          <tr>
            <td valign="top">
            
            
                <!--START: full time report-->        
                <p>
                	<input type="checkbox" name="full_time_status" value="Full-Time" <?=$work_fulltime;?> onClick="checkCheckBoxes('full_time_status' , 'full_time_div');"  >
                    <label>Willing to Work Full-Time </label>
				</p>
                <div id="full_time_div" <?php echo $show_full_time_div; ?>>
                    <?php echo $fulltime_report; ?>
                </div>
                <!--ENDED: full time report-->
            
            
            </td>
            <td valign="top" width="50%">
            
            
                <!--START: part time-->
                <p>
                    <input type="checkbox" name="part_time_status" value="Part-Time" <?=$work_parttime;?> onClick="checkCheckBoxes('part_time_status' , 'part_time_div');" >
                    <label>Willing to Work Part-Time </label>
                </p>
                <div id="part_time_div" <?=$show_part_time_div;?>>
                    <?php echo $parttime_report; ?>
                </div>
                <!--ENDED: part time-->
            
            
            </td>
          </tr>
          <tr>
            <td colspan="2" valign="top">
                
                
                <!--START: freelancer time schedule -->
                <p>
					<input type="checkbox" name="freelancer_status" value="Part-Time" <?=$work_freelancer;?> onClick="checkCheckBoxes('freelancer_status' , 'freelancer_div');" >                                    
                    <label>Willing to Work Ad Hoc</label> 
                </p>
                <div id="freelancer_div" <?=$show_freelancer_div;?>>
                <p>Working Time</p>
                <p style="color:#999999;"><i>The Applicant must indicate his time availability </i></p>
                <p>
                    <b>Days</b>
                    <select name="days_freelancer" id="days_freelancer"   class="select" style="width:100px;">
                        <?=$daysOptions;?>
                    </select>
                <b>Start :</b>
                    <select name="start_freelancer" id="start_freelancer"  onChange="setWorkHourPartTime();" class="select" style="width:100px;">
                        <?=$start_work_hours_Options;?>
                    </select>
                 <b>Finish :</b> 
                    <select name="out_freelancer" id="out_freelancer" class="select" onChange="setWorkHourPartTime();" style="width:100px;">
                        <?=$finish_work_hours_Options;?>
                    </select>
                &nbsp;<input type='text' name='hour_freelancer' id='hour_freelancer' style='color:#666666;width:20px;' value='' class='text' readonly="true"  />
                &nbsp;Total Working Hours
                &nbsp;<input type="button" value="Add" onClick="addFreelancerTimeSchedule();">
                <div id="freelancer_schedule_list" style="width:500px;">
                    <div style="border:#CCCCCC outset 1px; font: 12px Arial; background:#CCCCCC; padding-top:2px; padding-bottom:2px;">
                        <div style="float:left; width:90px; display:block;font: 12px Arial;"><b>Day</b></div>
                        <div style="float:left; width:200px; display:block;font: 12px Arial;"><b>Schedule</b></div>
                        <div style="float:left; width:60px; display:block;font: 12px Arial;"><b>Hour</b></div>
                        <div class="refresh_btn"><b>Refresh</b></div>
                        <div style="clear:both;"></div>
                    </div>
                    <?php
                    $sql = "SELECT id, day_name, start_str, finsh_str, hour FROM evaluation_freelancer_time_schedule WHERE userid = $userid ORDER BY day_id ASC;";
                    $result = mysql_query($sql);
                    while(list($id, $days, $start_str, $finsh_str, $hour)=mysql_fetch_array($result))
                    {
                    ?>
                        <div style="border-bottom:#CCCCCC solid 1px;font: 12px Arial;">
                            <div style="float:left; width:90px; display:block;font: 12px Arial;"><?=$days;?></div>
                            <div style="float:left; width:200px; display:block;font: 12px Arial;"><?=$start_str;?> - <?=$finsh_str;?></div>
                            <div style="float:left; width:60px; display:block;font: 12px Arial;"><?=$hour;?></div>
                            <div onClick="deleteFreelancerTimeSchedule(<?=$id;?>);" style="float:left; width:20px; display:block;font: 12px Arial; color:#0000FF; cursor:pointer;">X</div>
                            <div style="clear:both;"></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <!--ENDED: freelancer time schedule -->
            </td>
          </tr>
          <tr>
          	<td colspan="2"><input type="button" value="Save & Refresh" onClick="saveEvaluation();"></td>
          </tr>  
        </table>        
		</div>
	</form>
    </body>
    </html>