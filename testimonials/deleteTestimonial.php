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
$testimony_id = $_REQUEST['testimony_id'];


/*

testimony_id, created_by_id, created_by_type, recipient_id, recipient_type, testimony_status, date_created, date_updated, date_posted, testimony
*/
$query = "DELETE FROM testimonials  WHERE testimony_id = $testimony_id;";
		
$result = mysql_query($query);		
if(!$result) die ("Error in Script : <br>".$query);
echo "<div style='padding:5px;background:yellow;color:black;text-align:center;'><b>Testimony Deleted!</b></div>";

$queryTestimonials = "SELECT testimony_id, testimony_status, DATE_FORMAT(date_created,'%D %b %y'), DATE_FORMAT(date_posted,'%D %b %y'), testimony 
		  FROM testimonials 
		  WHERE created_by_id = $leads_id AND created_by_type = 'leads' AND recipient_id = $userid AND recipient_type = 'subcon' ORDER BY date_created DESC;";
$data = mysql_query($queryTestimonials);	
if(!$data) die ("Error in Script : <br>".$queryTestimonials);
while(list($testimony_id, $testimony_status, $date_created, $date_posted, $testimonials)=mysql_fetch_array($data))
{
	?>
		<div id="testimony_id_<?=$testimony_id;?>" style="border-bottom:#666666 dashed 1px; margin-bottom:10px;">
			<div style="background:#FFFFCC; padding-top:2px; padding-bottom:2px; font:7pt Tahoma;">
				<div style="float:left;">Status : <?=strtoupper($testimony_status);?> Date Created : <?=$date_created;?></div>
				<div style="float:right;">
				<a href="javascript:showTestimonialForm(<?=$userid;?>,0)" />
				<img src="./images/add.gif" border="0" />
				</a>
				<a href='javascript:showTestimonialForm(<?=$userid;?>,<?=$testimony_id;?>)' />
				<img src="./images/b_edit.png" border="0" />
				</a>
				<a href='javascript:deleteTestimonial(<?=$userid;?>,<?=$testimony_id;?>)' />
				<img src="./images/delete.png" border="0" />
				</a>
				</div>
				<div style="clear:both"></div>
			</div>
			<div style="padding:5px;"><?=str_replace("\n","<br>",$testimonials);?></div>
		</div>
	<?
}

?>