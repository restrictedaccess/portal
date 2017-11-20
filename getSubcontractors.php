<?
include 'config.php';
include 'conf.php';
include 'function.php';
include 'time_recording/TimeRecording.php';
$userid = $_REQUEST['userid'];

//$timezone_identifiers = DateTimeZone::listIdentifiers();
//echo $userid;
class SubconStatus extends TimeRecording 
{
	//returns a string indicating status of the subcontractor
	function GetStatus()
	{
		if ($this->buttons['lunch_end']) {
			return "Out to lunch.";
		}
		if ($this->buttons['work_start']) {
			return "Not working.";
		}
		else {
			return "Working.&nbsp;<img src='images/onlinenowFINAL.gif' alt='working' align='absmiddle'>";
		}
	}	
	
	function GetWorkSchedule($userid,$div){
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$sql = "SELECT l.id,l.fname, l.lname , s.starting_hours, s.ending_hours ,s.id , php_monthly , client_price , s.client_timezone , s.client_start_work_hour, s.client_finish_work_hour , l.agent_id , l.business_partner_id
				FROM subcontractors s
				JOIN leads l ON l.id = s.leads_id
				WHERE s.userid = $userid AND s.status = 'ACTIVE' ORDER BY s.starting_hours DESC;";
			$result = mysql_query($sql);
			$num=0;
			
			while(list($lead_id,$l_fname,$l_lname,$starting_hours, $ending_hours,$sid , $php_monthly ,$client_price , $timezone , $client_start_hour , $client_finsh_hour , $agent_id , $business_partner_id )=mysql_fetch_array($result))
			{
				$num++;
				if($php_monthly==""){
					$php_monthly = 0;
				}
				
				if($client_price==""){
					$client_price = 0;
				}
				
				//$aff_name= $agent_id ." ". $business_partner_id;
				
				//Check to whose Client did the Subcon currently working on....
					$sqlCheck="SELECT * FROM timerecord t 
					WHERE leads_id = $lead_id AND userid = $userid AND DATE(time_in) BETWEEN '$AusDate' AND '$AusDate' AND mode = 'regular' ;";
					//echo $sqlCheck;
					$res=mysql_query($sqlCheck);
					$row=mysql_fetch_array($res);
					$time_in = $row['time_in'];
					$time_out = $row['time_out'];
					$mode = $row['mode'];
					$check = @mysql_num_rows($res);
					//echo $check;
					if($time_in!="" and $time_out=="" and $mode == "regular" and $check >0 )
					{
						$online ="<img src='images/navi_bullet.gif' align='absmiddle'>";
						
					}else{ $online ="";}
				
				
				
				$staff_working_hours = setConvertTimezones($timezone, 'Asia/Manila' , $client_start_hour, $client_finsh_hour);
				
		
		echo "
		<div style='padding:1px; font:12px Arial;' class='button_add_notes'>
			<div style='padding:3px;' onClick='show_hide($sid)' onMouseOver='highlight(this)' onMouseOut='unhighlight(this)'>
				<div style='float:left; '>$online $num) <span style='color:#0000FF' ><b>Client : ".$l_fname." ".$l_lname."</b></span>
			</div>
			<div style='float:right;  margin-left:2px;'>".$staff_working_hours."</div>
		<div style='clear:both'></div>
		</div>	
		<div style='color:#666666;' >".checkClientsBPAFF($agent_id , $business_partner_id)."</div>
			<div style='clear:both'></div>
				<div style='padding:3px;' >
				<a href='subconlist.php?subconid=$sid&ap_id=$ap_id&DELETE=TRUE' style='width: 135px;'  title='Delete Staff from this Client' class='a_button' >
		 Delete Staff from this Client</a>
				<a href='#' class='a_button' style='width: 85px;' onClick="."\"javascript:popup_win('./update_subcon_client.php?userid=$userid&leads_id=$lead_id&subcotractors_id=$sid',600,400);\"".">
	Change Employer </a>
		
		<a href='subconlist.php?subcotractors_id=$sid&RESIGN=TRUE' class='a_button' style='width: 90px;'  title='Move to Non Working Staff' >
		Non Working Staff
		</a>
		<a href='subconlist.php?subcotractors_id=$sid&move=TRUE' class='a_button' style='width: 70px;'  title='Move to Reserve Staff' >
		Reserve Staff
		</a>
				</div>
			<div style='clear:both'></div>
		</div>
		<div id=$sid style='display:none; padding:10px; border:#999999 solid 1px;margin:10px'>
			
			<p style='margin-bottom:5px;margin-top:2px;'><label style='float:left; width: 120px; display:block;'>Monthly Peso : </label>P ".number_format($php_monthly,2,'.',',')."</p>
			<p style='margin-bottom:5px;margin-top:2px;'><label style='float:left; width: 120px; display:block;'>Client Price : </label>\$ ".number_format($client_price,2,'.',',')."</p>
		</div>
		";
					  
					  
			}
		}
}

if($userid>0)
{
	$query="SELECT DISTINCT(u.userid),u.fname,u.lname,u.image,u.email,u.handphone_no,skype_id
	FROM personal u
	JOIN subcontractors s ON s.userid = u.userid
	
	WHERE s.status = 'ACTIVE'
	AND u.userid = $userid
	ORDER BY s.id DESC";
	
}else{
	$query="SELECT DISTINCT(u.userid),u.fname,u.lname,u.image,u.email,u.handphone_no,skype_id
	FROM personal u
	JOIN subcontractors s ON s.userid = u.userid
	
	WHERE s.status = 'ACTIVE'
	ORDER BY s.id DESC";
}

//echo $query;
$result=mysql_query($query);
$counter=0;
$bgcolor="#FFFFFF";
while(list($userid,$fname,$lname,$image,$email,$phone,$skype)=mysql_fetch_array($result))
{	
	
	 $fname = str_replace("ñ", 'n',$fname);
	 $lname = str_replace("ñ", 'n',$lname);
	 $counter++;
	
	
?>

<div class="subcon_wrapper" style=" margin-bottom:10px; padding:3px; border:#999999 outset 1px;">
	<div  style="float:left; width:35px;">
		<b><?=$counter;?></b>
	</div>
	<!-- image -->
	<div onMouseOver="highlight(this)" onMouseOut="unhighlight(this)" onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);" title="View Resume of <?=$fname." ".$lname;?> " class="subcon_image" style="float:left; border:#999999 outset 2px; padding:4px; margin-left:5px; ">
		<img src="<? echo "lib/thumbnail_staff_pic.php?file_name=$image";?>"  />
	</div>
	<!-- subcon personal info -->
	<div class="subcon_details" style="float:left; margin-left:2px; width:220px; border:#CCCCCC ridge 1px; height:150px; padding:5px;">
		<p onMouseOver="highlight(this)" onMouseOut="unhighlight(this)" onClick= "javascript:popup_win('./resume3.php?userid=<? echo $userid;?>',800,500);" title="View Resume of <?=$fname." ".$lname;?> "><b>
		<?=strtoupper($fname." ".$lname);?>
		</b></p>
		<p><?=$email ? $email : '&nbsp;';?></p>
		<p><?=$skype ? "Skype : ".$skype : '&nbsp;';?></p>
		<P><? $subcon_status = new SubconStatus($userid); echo $subcon_status->GetStatus();?></P>
		<div><input type="button" style="font:11px tahoma;" value="View Contract Details" onClick="gotoContractDetails(<? echo $userid;?>)" /></div>
		<?
		//Check the subcontractors remotestaff work history if there's any....
		$queryCheckHistory="SELECT CONCAT(l.fname,' ',l.lname) , s.status , DATE_FORMAT(s.starting_date,'%D %b %Y') , DATE_FORMAT(resignation_date,'%D %b %Y'), client_price , 
				php_monthly , starting_hours, ending_hours
				FROM subcontractors s
				LEFT JOIN leads l ON l.id = s.leads_id
				WHERE s.userid = $userid
				AND s.status !='ACTIVE';";
		//echo $query;		
		$resultCheckHistory = mysql_query($queryCheckHistory);
		$num_check=@mysql_num_rows($resultCheckHistory);
		if($num_check > 0){
			echo "<div onClick='show_hide($counter)' style='color:#0000FF; cursor:pointer; margin:5px;' >-- Remote Staff Work History</div>";
		}
		?>
		
		
	</div>
	<!-- Business Partner and Affiliates Section -->
	
	<!-- Clients -->
	<div class="subcon_details" style="float:left; margin-left:2px; border:#CCCCCC ridge 1px; height:150px; padding:5px; overflow: auto; width:580px;">
	<?=$subcon_status->GetWorkSchedule($userid ,"$counter");?>
	
	</div>
<div style="clear:both;"></div>	
</div>
<?
if($num_check > 0)
{
?>
	<div id =<?=$counter;?> style=' margin:5px; display:none; ' >
	<p><b><?=$fname." ".$lname;?> previously worked for the following client(s)</b></p>
	<?
		$client_num=0;
		while(list($client, $status, $starting_date , $resignation_date, $client_price , $php_monthly , $starting_date, $resignation_date)=mysql_fetch_array($resultCheckHistory))
		{
			$client_num++;
			$client_price ? $client_price : '0';
			$php_monthly ? $php_monthly : '0';
		?>	
		<div style="margin:20px; float:left; border:#999999 outset 1px; ">
			<div style="background:#CCCCCC; border:#999999 outset 1px; padding:4px;"><?=$client_num;?>)&nbsp;<b><?=strtoupper($client);?></b></div>		
				<div style="border:#999999 solid 1px; padding:5px;">			
				<p><label>Client Price : </label>$ <?=number_format($client_price,2,'.',',');?></p>
				<p><label>Monthly Peso : </label>P <?=number_format($php_monthly,2,'.',',');?></p>
				<p><label>Date Duration : </label><?=$starting_date." - ".$resignation_date;?></p>
				</div>
		</div>
		<? } ?>	
		<div style="clear:both;"></div>
	</div>
<? }?>
<div style="clear:both;"></div>

<? } ?>