<?
include '../config.php';
include '../function.php';
include '../conf.php';

$leads_id = $_REQUEST['leads_id'];
if($leads_id=="")
{
	die("Lead ID is missing..!");
}
$query ="SELECT * FROM leads WHERE id = $leads_id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$row = mysql_fetch_array($result);

	$tracking_no =$row['tracking_no'];
	$timestamp =$row['timestamp'];
	$status =$row['status'];
	$call_time_preference =$row['call_time_preference'];
	$remote_staff_competences =$row['remote_staff_competences'];
	$remote_staff_needed =$row['remote_staff_needed'];
	$remote_staff_needed_when =$row['remote_staff_needed_when'];
	$$remote_staff_one_home =$row['$remote_staff_one_home'];
	$remote_staff_one_office =$row['remote_staff_one_office'];
	$your_questions =$row['your_questions'];
		
	$lname =$row['lname'];
	$fname =$row['fname'];
	$company_position =$row['company_position'];
	$company_name =$row['company_name'];
	$company_address =$row['company_address'];
	$email =$row['email'];
	$website =$row['website'];
	$officenumber =$row['officenumber'];
	$mobile =$row['mobile'];
	$company_description =$row['company_description'];
	$company_industry =$row['company_industry'];
	$company_size =$row['company_size'];
	$outsourcing_experience =$row['outsourcing_experience'];
	$outsourcing_experience_description =$row['outsourcing_experience_description'];
	$company_turnover =$row['company_turnover'];
	
	$your_questions=str_replace("\n","<br>",$your_questions);
	$outsourcing_experience_description=str_replace("\n","<br>",$outsourcing_experience_description);
	$company_description=str_replace("\n","<br>",$company_description);
	
	$rate =$row['rating'];
	$personal_id =$row['personal_id'];
	
	if($rate=="1")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
	
	


?>

<div class="tab_content">
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Rate :</label><span id="rate"><?=$rate ? $rate : '&nbsp;';?></span><span id="rate_mess"></span></p>
<div class="right_controls">
<p><label style="width:160px;">Rate this Lead : <select name="star" id="star"  style="font:10px tahoma;" >
<option value="0">-</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select></label><span><input type="button" name="rate" value="Rate" onClick="rateClient();"  ></span></p>
<p><label style="width:160px;">Edit Lead Information :</label><span><input type="button" name="edit" value="Edit" onClick="editClientInfo();"  ></span></p>
<p><label style="width:160px;">Delete this Lead :</label><span> <input type="button" name="edit" value="Delete" onClick="deleteLead();"  ></span></p>
<p><label style="width:160px;">Move to Follow-Up List : </label><span><input type="button" name="edit" value="Follow-Up" onClick="setLeadStatus('Follow-Up');"  ></span></p>
<p><label style="width:160px;">Move to Keep In-Touch List : </label><span><input type="button" name="edit" value="Keep In-Touch" onClick="setLeadStatus('Keep In-Touch');"  ></span></p>
<p><label style="width:160px;">Make this a Client :</label><span> <input type="button" name="edit" value="Move to Client" onClick="setLeadStatus('Client');"  ></span></p>
</div>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Date Registered :</label><span><?=format_date($timestamp) ? format_date($timestamp) : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Name :</label><span style="color:#FF0000; font-weight:bold;"><?=$fname." ".$lname ? strtoupper($fname." ".$lname) : '&nbsp;&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Lead Status :</label><span style="color:#0000FF; font-weight:bold;"><?=$status ? strtoupper($status) : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Email :</label><span><?=$email ? $email : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Company :</label><span><?=$company_name ? $company_name : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Company Position :</label><span><?=$company_position ? $company_position : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Company Address :</label><span><?=$company_address ? $company_address : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Company No :</label><span><?=$officenumber ? $officenumber : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Company Industry :</label><span><?=$company_industry ? $company_industry : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Website :</label><span><?=$website ? $website : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Company No. of Employee :</label><span><?=$company_size ? $company_size : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Company Turnover in a Year :</label><span><?=$company_turnover ? $company_turnover : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Company Profile :</label><span><?=$company_description ? $company_description : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Call time availability :</label><span><?=$call_time_preference ? $call_time_preference : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>No. of Remote Staff neeeded :</label><span><?=$remote_staff_needed ? $remote_staff_needed : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Remote Staff needed :</label><span><?=$remote_staff_needed_when ? $remote_staff_needed_when : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Remote Staff needed in Home Office :</label><span><?=$remote_staff_one_home ? $remote_staff_one_home : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Remote Staff needed in Office :</label><span><?=$remote_staff_one_office ? $remote_staff_one_office : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Remote Staff responsibilities :</label><span><?=$remote_staff_competences ? $remote_staff_competences : '&nbsp;';?></span></p>
<p onMouseOver="highlight(this);" onMouseOut="unhighlight(this);"><label>Questions / Concern :</label><span><?=$your_questions ? $your_questions : '&nbsp;';?></span></p>
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>

<?
}
else{
?>
Lead Information is Missing or the Lead is Deleted from the List..
<?
}

?>