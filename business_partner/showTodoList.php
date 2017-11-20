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
$queryLeads ="SELECT * FROM leads WHERE id = $leads_id;";
$resultLeads=mysql_query($queryLeads);
$rows = mysql_fetch_array($resultLeads);
$lname =$rows['lname'];
$fname =$rows['fname'];
$status =$rows['status'];

?>

<table width="99%" style="border:#666666 solid 1px;" cellspacing="0" cellpadding="3">
<tr bgcolor="#CCCCCC"><td width="8%" valign="top" style="border-bottom:#666666 solid 1px;" align="right"><font color="#999999">Actions&nbsp;|&nbsp;Priority</font>&nbsp;&nbsp;&nbsp;</td>
<td width="21%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; "><b>Subject</b></td>
<td width="26%" valign="top" style="border-bottom:#666666 solid 1px; "><b><font color="#FFFFFF"><? echo $list ? $list : '&nbsp;';?></font></b></td>
<td width="18%" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#999999">Client</font></td>
<td width="11%" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#999999">Date Created</font></td>
<td width="16%" valign="top" style="border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;"><b>Due Date</b></td>
</tr>
<?
//id, agent_no, lead_id, date_created, subject, start_date, due_date, status, priority, percentage, details, folder
if($leads_id!=""){
$sqlList="SELECT  t.id,lead_id, subject, start_date, DATE_FORMAT(due_date,'%a %D %b %Y'), priority,DATE_FORMAT(date_created,'%D %b %Y'),details
FROM todo t 
WHERE agent_no =$agent_no 
AND lead_id = $leads_id
ORDER BY priority DESC;";
}		

if($leads_id==""){
$sqlList="SELECT  t.id,lead_id, subject, start_date, DATE_FORMAT(due_date,'%a %D %b %Y'), priority,DATE_FORMAT(date_created,'%D %b %Y'),details
FROM todo t 
WHERE agent_no =$agent_no 
ORDER BY priority DESC;";
}		

//echo $sqlList;
$result=mysql_query($sqlList);
$counter=0;
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
while(list($id, $lead_id,$subject, $start_date, $due_date, $priority, $date_created,$details,$fname,$lname) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		$rate =$priority;
		if($rate=="1")
		{
			$rate="*";
		}
		if($rate=="2")
		{
			$rate="**";
		}
		if($rate=="3")
		{
			$rate="***";
		}
		if($rate=="4")
		{
			$rate="****";
		}
		if($rate=="5")
		{
			$rate="*****";
		}
?>		
		<tr><td width='8%' valign='top' style="border-bottom:#666666 solid 1px;" ><? if ($folder =="NEW") {?><a href="../todo.php?id=<? echo $id;?>&agentno=<? echo $agent_no;?>&mode=MOVE"><img src="../images/action_check.gif" alt="Finished Move to Archives" align="top" border="0" ></a><? } if ($folder =="ARCHIVE") {?><a href="../todo.php?id=<? echo $id;?>&agentno=<? echo $agent_no;?>&mode=BACK"><img src="../images/arrow_back.gif" alt="Back to Current Active List" align="top" border="0" ></a><? }?>&nbsp;<a href="../todo.php?id=<? echo $id;?>&agentno=<? echo $agent_no;?>&mode=DELETE"><img src="../images/action_delete.gif" alt="Delete" align="top" border="0"></a>&nbsp;<? echo $counter; ?>)<font color="#FF9900" size="3"><b><? echo $rate;?></b></font></td>
		<td colspan="2" valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px; '>
		<a href="javascript:show_hide(<?=$id;?>);" title="<?=$details;?>">
		<? echo strtoupper($subject);?>	
		</a>
		<? if ($lead_id!=""){
		$sqlLead ="SELECT * FROM leads WHERE id = $lead_id;";
		$resulta=mysql_query($sqlLead);
		$rowa = mysql_fetch_array($resulta);
		$lname =$rowa['lname'];
		$fname =$rowa['fname'];
		}?></td>
		<td width='18%' valign='top' style="border-bottom:#666666 solid 1px;"><font color="#CCCCCC"><? if ($fname!=""){echo $fname." ".$lname;} else { echo "&nbsp;";}?></font></td>
		<td width='11%' valign='top' style="border-bottom:#666666 solid 1px;"><font color="#CCCCCC"><? echo $date_created;?></font></td>
		<td width='16%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#666666 solid 1px;'><? echo $due_date;?></td>
		</tr>
		<tr>
		<td colspan="6">
		<div id="<?=$id;?>" style="display:none; padding:5px;">
		<p><a href="<? $_SERVER['PHP_SELF']?>?todo_id=<? echo $id;?>&mode=UPDATE&id=<?=$leads_id;?>">Edit</a></p>
		<? 
			$details = str_replace("\n","<br>",$details);
			echo $details;
		?>
		</div>
		</td>
		</tr>
<?		
	}
}	

?>
</table>