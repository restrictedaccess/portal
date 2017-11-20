<?
include "../config.php";
include "../conf.php";
include "../time.php";
include "../function.php";

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$leads_id = $_REQUEST['leads_id'];
$userid = $_REQUEST['userid'];
$testimony = filterfield($_REQUEST['testimony']);

$query = "INSERT INTO testimonials SET 
					created_by_id = $userid, 
					created_by_type = 'subcon', 
					recipient_id = $leads_id, 
					recipient_type = 'leads', 
					date_created = '$ATZ',
					testimony = '$testimony',
					for_id = $userid, 
					for_by_type = 'subcon';";
$result = mysql_query($query);		
if(!$result) die ("Error in Script : <br>".$query);
echo "<div style='padding:5px;background:yellow;color:black;text-align:center;'><b>New Testimony Created!</b></div>";

/*
SELECT * FROM testimonials t;
testimony_id, created_by_id, created_by_type, recipient_id, recipient_type, testimony_status, date_created, date_updated, date_posted, testimony
*/


$queryTestimonials = "SELECT testimony_id, testimony_status, DATE_FORMAT(date_created,'%D %b %y'), DATE_FORMAT(date_posted,'%D %b %y'), testimony , created_by_id, created_by_type , DATE_FORMAT(date_updated,'%D %b %y')
		  FROM testimonials 
		  WHERE for_id = $userid AND for_by_type = 'subcon' AND recipient_id = $leads_id AND recipient_type = 'leads' ORDER BY date_created DESC;";
$data = mysql_query($queryTestimonials);	
if(!$data) die ("Error in Script : <br>".$queryTestimonials);
while(list($testimony_id, $testimony_status, $date_created, $date_posted, $testimonials ,$created_by_id, $created_by_type,$date_updated)=mysql_fetch_array($data))
{
	if($testimony_status=="posted"){ 
		$date = "Posted : ".$date_posted ;
	}else if($testimony_status=="updated"){
		$date = "Updated : ".$date_updated ;
	}else{
		$date = "Created : ".$date_created;
	}
	?>
		<div id="testimony_id_<?=$testimony_id;?>" style="border-bottom:#666666 dashed 1px; margin-bottom:10px;">
			<div style="background:#FFFFCC; padding-top:2px; padding-bottom:2px; font:7pt Tahoma;">
				<div style="float:left;"><b style="color:#FF0000">Status</b> : <b><?=strtoupper($testimony_status);?></b> <br><?=$date;?>  </div>
				<div style="float:right;">
				<a href="javascript:showTestimonialClientForm(<?=$leads_id;?>,0)" />
				Add
				</a>
				<? if ($created_by_id == $userid and $created_by_type == "subcon") {?>
				|
				<a href='javascript:showTestimonialClientForm(<?=$leads_id;?>,<?=$testimony_id;?>)' />
				Edit
				</a>
				|
				<a href='javascript:deleteStaffTestimonial(<?=$leads_id;?>,<?=$testimony_id;?>)' />
				Del
				</a>
				<? } else { echo "&nbsp;";}?>
				</div>
				<div style="clear:both"></div>
			</div>
			<div style="padding:5px;"><?=str_replace("\n","<br>",$testimonials);?></div>
		</div>
	<?
}


?>


