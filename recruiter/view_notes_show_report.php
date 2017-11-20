<?php
include('../conf/zend_smarty_conf.php');

$userid = $_REQUEST["userid"];
$notes_type = $_REQUEST["notes_type"];
$notes_id = $_REQUEST["notes_id"];
$action_type = $_REQUEST["action_type"];
$notes_content = $_REQUEST["notes_content"];

if($notes_type == "communications")
{
	if($action_type == "save")
	{
		$data = array(
		'history' => $notes_content
		);
		$where = "id = ".$notes_id;	
		$db->update('applicant_history' , $data , $where);				
	}
	else
	{
		$sql = $db->select()      
			->from('applicant_history')
			->where('id =?' , $notes_id);
		$result = $db->fetchRow($sql);
		if($result['actions'] == "CSR")
		{
			$sql = $db->select()      
				->from('applicant_history_csr')
				->where('applicant_history_id  =?' , $notes_id);
			$result = $db->fetchRow($sql);
			$comments = "<strong>What was the call about?</strong><br />".$result['note1']."<br /><br />";
			$comments .= "<strong>What did you do to resolve the issue?</strong><br />".$result['note2']."<br /><br />";
			$comments .= "<strong>Where is everything at right now?</strong><br />".$result['note3'];			
		}
		else
		{
			$comments = $result['history'];
		}
	}
}
if($notes_type == "evaluation")
{
	if($action_type == "save")
	{
		$data = array(
		'comments' => $notes_content
		);
		$where = "id = ".$notes_id;	
		$db->update('evaluation_comments' , $data , $where);			
	}
	else
	{
		$sql = $db->select()
			->from('evaluation_comments')
			->where('id =?' , $notes_id);
		$result = $db->fetchRow($sql);
		$comments = $result['comments'];
	}	
}
?>
<table width=100% border=0 cellspacing=5 cellpadding=5 style="border:#CCCCCC solid 1px;" bgcolor="#FFFFCC">
	<tr>
		<td colspan="2"><B>Notes :</B></td>
	</tr>
	<tr>
		<td valign="top" align="left"><img src="../leads_information/media/images/quote.png" /></td><td width="100%" valign="top" align="left" style="border-left: #CCCCCC 1px solid;"><?php echo $comments; ?></td>
	</tr>
	<tr>
		<td align=center colspan="2"><br />
			<INPUT type="reset" value="Close" name="Close" onclick="javascript: edit_notes_show_report_exit(); " style="width:120px">
		</td>
	</tr>
</table>