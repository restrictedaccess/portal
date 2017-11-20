<?
include "../../config.php";
include "../../conf.php";
include "../../time.php";
include "../../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$admin_id = $_SESSION['admin_id'];


$for_id = $_REQUEST['created_by_id'];
$for_by_type = $_REQUEST['created_by_type'];

$recipient_id = $_REQUEST['recipient_id'];
$recipient_type = $_REQUEST['recipient_type'];


$testimony_id = $_REQUEST['testimony_id'];
$testimony_status = $_REQUEST['testimony_status']; // 'posted','cancel'

/*
testimony_id, created_by_id, created_by_type, recipient_id, recipient_type, testimony_status, date_created, date_updated, posted_by_id, posted_by_type, date_posted, testimony, for_id, for_by_type

*/



if($testimony_id > 0 ){

	if($testimony_status == "posted"){
		$query = "UPDATE testimonials SET 
						testimony_status = '$testimony_status',
						date_posted = '$ATZ',
						posted_by_id = '$admin_id' ,
						posted_by_type = 'admin'
						WHERE testimony_id = $testimony_id;";
		$result = mysql_query($query);		
		if(!$result) die ("Error in Script : <br>".$query);
		echo "<div style='padding:5px;background:yellow;color:black;text-align:center;'><b>Testimony Approved!</b></div>";
	}
	if($testimony_status == "cancel"){
		$query = "UPDATE testimonials SET 
						testimony_status = '$testimony_status',
						date_updated = '$ATZ'
						WHERE testimony_id = $testimony_id;";
		$result = mysql_query($query);		
		if(!$result) die ("Error in Script : <br>".$query);
		echo "<div style='padding:5px;background:yellow;color:black;text-align:center;'><b>Testimony Cancelled!</b></div>";
	}
}else{
	die("Testimony ID is Missing");
}



$query= "SELECT testimony_id, testimony_status, DATE_FORMAT(date_created,'%D %b %y'), DATE_FORMAT(date_posted,'%D %b %y'), testimony , DATE_FORMAT(date_updated,'%D %b %y')
						  FROM testimonials 
						  WHERE for_id = $for_id AND for_by_type = '$for_by_type' AND recipient_id = $recipient_id AND recipient_type = '$recipient_type' 
						  ORDER BY date_created DESC;";
//echo $query;						  
$result = mysql_query($query);		
if(!$result) die ("Error in Script : <br>".$query);
while(list($testimony_id, $testimony_status, $date_created, $date_posted, $testimonials,$date_updated)=mysql_fetch_array($result))
{
	if($testimony_status=="posted"){ 
		$date = "Posted : ".$date_posted ;
		$date .= " | Created : ".$date_created;
	}else if($testimony_status=="updated"){
		$date = "Updated : ".$date_updated ;
		$date .= " | Created : ".$date_created;
	}else{
		$date = "Created : ".$date_created;
	}
	?>
		<div id="testimony_id_<?=$testimony_id;?>" style="border-bottom:#666666 dashed 1px; margin-bottom:10px;">
			<div style="background:#FFFFCC; padding-top:2px; padding-bottom:2px; font:7pt Tahoma;">
				<div style="float:left;"><b style="color:#FF0000">Status</b> : <b><?=strtoupper($testimony_status);?></b> <br><?=$date;?>  </div>
				<div style="float:right;">
				<a href="javascript:showAdminTestimonialForm(<?=$for_id;?>,'<?=$for_by_type;?>',<?=$recipient_id;?>,'<?=$recipient_type;?>',0)" />
				Add
				</a>
				|
				<a href="javascript:showAdminTestimonialForm(<?=$for_id;?>,'<?=$for_by_type;?>',<?=$recipient_id;?>,'<?=$recipient_type;?>',<?=$testimony_id;?>)" />
				Edit
				</a>
				|
				<a href="javascript:deleteAdminTestimonial(<?=$for_id;?>,'<?=$for_by_type;?>',<?=$recipient_id;?>,'<?=$recipient_type;?>',<?=$testimony_id;?>)" />
				Del
				</a>
				|
				<a href="javascript:approvedAdminTestimonial(<?=$for_id;?>,'<?=$for_by_type;?>',<?=$recipient_id;?>,'<?=$recipient_type;?>',<?=$testimony_id;?>)" />
				Conf
				</a>
				</div>
				<div style="clear:both"></div>
			</div>
			<div style="padding:5px;"><?=str_replace("\n","<br>",$testimonials);?></div>
		</div>
	<?
}						  



?>