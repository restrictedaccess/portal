<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']!="")
{
	$user = $_SESSION['admin_id'];
	$type = 'admin';
}
else{
	die("Session Expired. Please re-login again.");
}

$value = $_REQUEST['value'];
$testimony_id = $_REQUEST['testimony_id'];
if($testimony_id!=NULL){
	$query="SELECT recipient_id, recipient_type
	FROM testimonials t WHERE testimony_id = $testimony_id;";
	$result = mysql_query($query);
	list($recipient_id, $recipient_type)=mysql_fetch_array($result);
}

if($value == "subcon"){

		$queryStaff="SELECT DISTINCT(u.userid), CONCAT(u.fname,' ',u.lname),u.image
		FROM personal u
		JOIN subcontractors s ON s.userid = u.userid
		WHERE s.status='ACTIVE' ORDER BY u.fname ASC;";
		$resulta=mysql_query($queryStaff);
		while(list($userid,$staff_name,$image)=mysql_fetch_array($resulta))
		{
			if($recipient_id == $userid and $recipient_type == "subcon")
			{
				$staff_options.= "<option selected value=\"$userid\">$staff_name</option>\n";
			}
			else
			{
				$staff_options.= "<option value=\"$userid\">$staff_name</option>\n";
			}
		}
		echo "<div>
				<div style='float:left; display:block; width:200px;'>Choose Staff</div>
				<div style='float:left; display:block;'>
				  <select name='userid'  id='userid' class='select' style='width:500px;' onchange=javascript:showImage(this.value) >
					".$staff_options."
				  </select>
				</div>
		     </div>";
}

if($value == "leads"){

		$sqlClient="SELECT  DISTINCT(l.id), l.fname, l.lname, l.company_name
		FROM subcontractors as s
		left join leads as l on s.leads_id = l.id
		where l.status = 'Client' order by l.fname";
		
		$resulta=mysql_query($sqlClient);
		while(list($lead_id,$lead_fname,$lead_lname,$lead_company)=mysql_fetch_array($resulta))
		{
			if($recipient_id == $lead_id and $recipient_type == "leads")
			  {
			 $clientoptions .= "<option selected value=\"$lead_id\">$lead_fname&nbsp;$lead_lname&nbsp;[ $lead_company ]</option>\n";
			  }
			  else
			  {
			 $clientoptions .= "<option value=\"$lead_id\">$lead_fname&nbsp;$lead_lname&nbsp;[ $lead_company ]</option>\n";
			  }
		}
		echo "<div>
				<div style='float:left; display:block; width:200px;'>Choose Client</div>
				<div style='float:left; display:block;'>
				  <select name='leads_id'  id='leads_id' class='select' style='width:500px;'  >
					".$clientoptions."
				  </select>
				</div>
		  	  </div>";
}

?>