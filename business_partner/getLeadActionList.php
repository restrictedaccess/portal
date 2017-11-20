<?
include '../config.php';
include '../conf.php';
if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}
$agent_no = $_SESSION['agent_no'];
$leads_id = $_REQUEST['leads_id'];
if($leads_id=="")
{
	die("Lead ID is missing..!");
}

// email
$sql="SELECT id, history,DATE_FORMAT(date_created,'%D %b %Y') ,subject 
	  FROM history 
	  WHERE agent_no = $agent_no 
	  AND leads_id=$leads_id 
	  AND actions ='EMAIL' 
	  ORDER BY date_created DESC;";
$result=mysql_query($sql);
$counter=0;
while(list($id,$history,$date,$subject) = mysql_fetch_array($result))
{
	$counter++;
	$email_action_list.="<div class='list' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onClick='showLeadActionRecordDetails($id)'>".$counter.") ".$date." - ".$subject."</div>";
	
}

// call
$sql2="SELECT id, history,DATE_FORMAT(date_created,'%D %b %Y') ,subject
	  FROM history 
	  WHERE agent_no = $agent_no 
	  AND leads_id=$leads_id 
	  AND actions ='CALL' 
	  ORDER BY date_created DESC;";
$result2=mysql_query($sql2);
$counter2=0;
while(list($id,$history,$date,$subject) = mysql_fetch_array($result2))
{
	$counter2++;
	$call_action_list.="<div class='list' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onClick='showLeadActionRecordDetails($id)'>".$counter2.") ".$date." - ".$subject."</div>";
	
}
//notes
$sql3="SELECT id, history,DATE_FORMAT(date_created,'%D %b %Y'),subject 
	  FROM history 
	  WHERE agent_no = $agent_no 
	  AND leads_id=$leads_id 
	  AND actions ='MAIL' 
	  ORDER BY date_created DESC;";
$result3=mysql_query($sql3);
$counter3=0;
while(list($id,$history,$date,$subject) = mysql_fetch_array($result3))
{
	$counter3++;
	$notes_action_list.="<div class='list' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onClick='showLeadActionRecordDetails($id)'>".$counter3.") ".$date." - ".$subject."</div>";
	
}

// face to face meeting

$sql4="SELECT id, history,DATE_FORMAT(date_created,'%D %b %Y') ,subject
	  FROM history 
	  WHERE agent_no = $agent_no 
	  AND leads_id=$leads_id 
	  AND actions ='MEETING FACE TO FACE' 
	  ORDER BY date_created DESC;";
$result4=mysql_query($sql4);
$counter4=0;
while(list($id,$history,$date,$subject) = mysql_fetch_array($result4))
{
	$counter4++;
	$meeting_action_list.="<div class='list' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onClick='showLeadActionRecordDetails($id)'>".$counter4.") ".$date." - ".$subject."</div>";
	
}
?>

<div class="action_title">Email</div>
<div class="scroll" >
	<?=$email_action_list;?>
</div>
<div class="action_title">CALL</div>
<div class="scroll" >
	<?=$call_action_list;?>
</div>
<div class="action_title">NOTES</div>
<div class="scroll" >
	<?=$notes_action_list;?>
</div>
<div class="action_title">FACE TO FACE MEETING</div>
<div class="scroll" >
	<?=$meeting_action_list;?>
</div>