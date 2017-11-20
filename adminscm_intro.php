<?
include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';
include 'time_recording/TimeRecording.php';

    /**
     *
     * extends TimeRecording class
     *
     */
    class SubconStatus extends TimeRecording {
        /**
        *
        *   returns a string indicating status of the subcontractor
        */
        function GetStatus() {
            if ($this->buttons['lunch_end']) {
                return "Out to lunch.";
            }
            if ($this->buttons['work_start']) {
                //return "Not working.";
				return "Finish Work.";
            }
            else {
                return "Working.&nbsp;<img src='images/onlinenowFINAL.gif' alt='working'>";
            }
        }
    }


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$AustodayDate = date ("jS \of F Y");
$ATZ = $AusDate." ".$AusTime;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<title>Sub-Contractor List</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel="stylesheet" href="css/light_admin.css" type="text/css" />
<script language=javascript src="js/functions.js"></script>
</head>
<body style="background:#73BECE;" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- Sub Contractors Listing--->
<?
//id, leads_id, agent_id, userid, posting_id, date_contracted, client_price, aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days, php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission, think_commission, overtime, company_contract_monthly, company_contract_weekly, company_contract_daily, company_contract_hourly, work_status, others, tax, starting_hours, ending_hours, starting_date, end_date, status

$query="SELECT DISTINCT u.userid, u.fname, u.lname,DATE_FORMAT(starting_date,'%D %b %Y'),agent_commission ,u.image,leads_id,l.fname,l.lname,work_status,starting_hours, ending_hours,lunch_start,lunch_end,lunch_hour
		FROM personal u
		JOIN subcontractors s ON s.userid = u.userid
		JOIN leads l ON l.id = s.leads_id
		WHERE s.status = 'ACTIVE'
		ORDER BY u.fname ASC;";
//echo $query;
$result=mysql_query($query);
?>
<div id="padbox" style="margin-bottom: 12px; border: 0px solid #abccdd; width: 1100px; padding: 8px;" >

<div id="albums">
<?
	$bgcolor="#FFFFFF";
	while(list($userid, $fname, $lname,$starting_date,$agent_commission ,$image,$leads_id,$l_fname,$l_lname,$work_status,$starting_hours, $ending_hours,$lunch_start,$lunch_end,$lunch_hour) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		if($image=="")
		{
			$image="images/Client.png";
		}

	
?>  

<div class="album"><b><?=$counter;?></b>)
		<div class="thumb"><a href="#" title="View Online Resume: <? echo $fname." ".$lname;?>" onClick= "javascript:popup_win('./resume4.php?userid=<? echo $userid;?>',800,500);"><img src="<? echo $image;?>" width="80" height="120" /></a></div>
						<div class="albumdesc">
<h3><a href="#" title="View Online Resume : <? echo $fname." ".$lname;?>" onClick= "javascript:popup_win('./resume4.php?userid=<? echo $userid;?>',800,500);"><? echo $fname." ".$lname;?></a></h3>
<!-- details here -->
<?
$query2="SELECT * FROM currentjob c  WHERE c.userid=$userid";
$result2=mysql_query($query2);
$row2 = mysql_fetch_array ($result2); 
$latest_job_title=$row2['latest_job_title'];
?>
<h2 style="margin-top:5px; margin-bottom:5px;"><? if($latest_job_title!="") { echo $latest_job_title;} else { echo "&nbsp;";}?></h2>
<small>Date Sub-Contracted :<? echo $starting_date;?></small><br>
<small><? echo $work_status."&nbsp;";?></small>
<?
if ($starting_hours=="13")
	{
		$starting_hours = "1:00 pm";
	}
	if ($starting_hours=="14")
	{
		$starting_hours = "2:00 pm";
	}
	if ($starting_hours=="15")
	{
		$starting_hours = "3:00 pm";
	}
	if ($starting_hours=="16")
	{
		$starting_hours = "4:00 pm";
	}
	if ($starting_hours=="17")
	{
		$starting_hours = "5:00 pm";
	}
	if ($starting_hours=="18")
	{
		$starting_hours = "6:00 pm";
	}
	if ($starting_hours=="19")
	{
		$starting_hours = "7:00 pm";
	}
	if ($starting_hours=="20")
	{
		$starting_hours = "8:00 pm";
	}
	if ($starting_hours=="21")
	{
		$starting_hours = "9:00 pm";
	}
	if ($starting_hours=="22")
	{
		$starting_hours = "10:00 pm";
	}
	if ($starting_hours=="23")
	{
		$starting_hours = "11:00 pm";
	}
	if ($starting_hours=="24")
	{
		$starting_hours = "12:00 am";
	}
	
	//////////////////////////////////
	if ($ending_hours=="12")
	{
		$ending_hours = "12:00 pm";
	}
	if ($ending_hours=="13")
	{
		$ending_hours = "1:00 pm";
	}
	if ($ending_hours=="14")
	{
		$ending_hours = "2:00 pm";
	}
	if ($ending_hours=="15")
	{
		$ending_hours = "3:00 pm";
	}
	if ($ending_hours=="16")
	{
		$ending_hours = "4:00 pm";
	}
	if ($ending_hours=="17")
	{
		$ending_hours = "5:00 pm";
	}
	if ($ending_hours=="18")
	{
		$ending_hours = "6:00 pm";
	}
	if ($ending_hours=="19")
	{
		$ending_hours = "7:00 pm";
	}
	if ($ending_hours=="20")
	{
		$ending_hours = "8:00 pm";
	}
	if ($ending_hours=="21")
	{
		$ending_hours = "9:00 pm";
	}
	if ($ending_hours=="22")
	{
		$ending_hours = "10:00 pm";
	}
	if ($ending_hours=="23")
	{
		$ending_hours = "11:00 pm";
	}
	if ($ending_hours=="24")
	{
		$ending_hours = "12:00 am";
	}
	
?>	
<small><? if ($starting_hours!=""){echo $starting_hours." - ".$ending_hours;}else{ echo "&nbsp;";}?></small>	
<?
	if ($lunch_start=="9")
	{
		$lunch_start = "9:00 am";
	}
	if ($lunch_start=="10")
	{
		$lunch_start = "10:00 am";
	}
	if ($lunch_start=="11")
	{
		$lunch_start = "11:00 am";
	}
	if ($lunch_start=="12")
	{
		$lunch_start = "12:00 pm";
	}
	if ($lunch_start=="13")
	{
		$lunch_start = "1:00 pm";
	}
	if ($lunch_start=="14")
	{
		$lunch_start = "2:00 pm";
	}
	if ($lunch_start=="15")
	{
		$lunch_start = "3:00 pm";
	}
	if ($lunch_start=="16")
	{
		$lunch_start = "4:00 pm";
	}
	if ($lunch_start=="17")
	{
		$lunch_start = "5:00 pm";
	}
	if ($lunch_start=="18")
	{
		$lunch_start = "6:00 pm";
	}
	if ($lunch_start=="19")
	{
		$lunch_start = "7:00 pm";
	}
	if ($lunch_start=="20")
	{
		$lunch_start = "8:00 pm";
	}
	if ($lunch_start=="21")
	{
		$lunch_start = "9:00 pm";
	}
	if ($lunch_start=="22")
	{
		$lunch_start = "10:00 pm";
	}
	if ($lunch_start=="23")
	{
		$lunch_start = "11:00 pm";
	}
	if ($lunch_start=="24")
	{
		$lunch_start = "12:00 am";
	}
	
	//////////////////////////////////
	if ($lunch_end=="10")
	{
		$lunch_end = "10:00 am";
	}
	if ($lunch_end=="11")
	{
		$lunch_end = "11:00 am";
	}
	if ($lunch_end=="12")
	{
		$lunch_end = "12:00 pm";
	}
	if ($lunch_end=="13")
	{
		$lunch_end = "1:00 pm";
	}
	if ($lunch_end=="14")
	{
		$lunch_end = "2:00 pm";
	}
	if ($lunch_end=="15")
	{
		$lunch_end = "3:00 pm";
	}
	if ($lunch_end=="16")
	{
		$lunch_end = "4:00 pm";
	}
	if ($lunch_end=="17")

	{
		$lunch_end = "5:00 pm";
	}
	if ($lunch_end=="18")
	{
		$lunch_end = "6:00 pm";
	}
	if ($lunch_end=="19")
	{
		$lunch_end = "7:00 pm";
	}
	if ($lunch_end=="20")
	{
		$lunch_end = "8:00 pm";
	}
	if ($lunch_end=="21")
	{
		$lunch_end = "9:00 pm";
	}
	if ($lunch_end=="22")
	{
		$lunch_end = "10:00 pm";
	}
	if ($lunch_end=="23")
	{
		$lunch_end = "11:00 pm";
	}
	if ($lunch_end=="24")
	{
		$lunch_end = "12:00 am";
	}
	?>		
<br />
<small>Lunch Break : <?=$lunch_start." - ".$lunch_end;?></small>
<? if($lunch_hour!="") { echo "<br><small>".$lunch_hour." &nbsp;hour lunch break</small><br>";} else { echo "<br><small>&nbsp;</small><br>";}?>	
<? 
$sqlClient="SELECT DISTINCT *
FROM leads l
JOIN timerecord t ON t.leads_id = l.id
WHERE l.id =$leads_id
AND DATE_FORMAT( time_in, '%Y-%m-%d' ) = '$AusDate'
AND t.userid =$userid;";

$result3=mysql_query($sqlClient);
$row3 = mysql_fetch_array ($result3); 
$leads_fname=$row3['fname'];				
$leads_lname=$row3['lname'];
$ctr=@mysql_num_rows($result3);
if ($ctr >0 )
{				
	echo "<small>Client :". $leads_fname." ".$leads_lname."</small><br />";
	$subcon_status = new SubconStatus($userid);
	echo "<small>".$subcon_status->GetStatus()."</small>";
}	
else
{
	echo "<small>Client :".$l_fname." ".$l_lname."</small><br />";
	echo "<small style='color:#660000'>Not yet working..</small>";
}
?>	
<!-- -->

<p>&nbsp;</p>
</div>
<p style="clear: both; "></p>
</div>
<? }?>			
	</div>

</div>
<!-- Sub Contractors Listing ends here--->

</body>
</html>
