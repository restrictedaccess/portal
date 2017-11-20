<?php
include('../conf/zend_smarty_conf.php');

$userid = $_REQUEST["userid"];
$notes_type = $_REQUEST["notes_type"];
$notes_id = $_REQUEST["notes_id"];
$action_type = $_REQUEST["action_type"];
$notes_content = $_REQUEST["notes_content"];
$note1 = $_REQUEST["note1"];
$note2 = $_REQUEST["note2"];
$note3 = $_REQUEST["note3"];



if($notes_type == "communications")
{
	if($action_type == "save")
	{
		$sql = $db->select()      
			->from('applicant_history')
			->where('id =?' , $notes_id);
		$result = $db->fetchRow($sql);
		$actions = $result['actions'];
		if($actions == "CSR")
		{
			$data = array(
			'note1' => $note1,
			'note2' => $note2,
			'note3' => $note3
			);
			$where = "applicant_history_id = ".$notes_id;
			$db->update('applicant_history_csr' , $data , $where);
		}
		else
		{
			$data = array(
			'history' => $notes_content
			);
			$where = "id = ".$notes_id;	
			$db->update('applicant_history' , $data , $where);				
		}
	}
	else
	{
		$sql = $db->select()      
			->from('applicant_history')
			->where('id =?' , $notes_id);
		$result = $db->fetchRow($sql);
		$comments = $result['history'];
		$actions = $result['actions'];
		if($actions == "CSR")
		{
			$sql = $db->select()      
				->from('applicant_history_csr')
				->where('applicant_history_id =?' , $notes_id);
			$result = $db->fetchRow($sql);
			$note1 = $result['note1'];
			$note2 = $result['note2'];
			$note3 = $result['note3'];
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

if($action_type <> "save")
{
	if($actions == "CSR")
	{
?>



	<table width=100% border=0 cellspacing=1 cellpadding=2 style="border:#CCCCCC solid 1px;" bgcolor="#FFFFCC">
        	<input type="text" name="notes_id" value="<?php echo $notes_id; ?>" style="width:0px; font:0px tahoma;" /><input type="text" name="notes_type" value="<?php echo $notes_type; ?>" style="width:0px; font:0px tahoma;" /><input type="text" name="action_type" value="save" style="width:0px; font:0px tahoma;" />
			<tr>
            	<td>
                	<B>What was the call about?</B>
					<textarea name="note1" cols="48" rows="3" wrap="physical" class="text"  style="width:100%"><?php echo $note1; ?></textarea>
				</td>
			</tr>
			<tr>
            	<td>
					<B>What did you do to resolve the issue?</B>
					<textarea name="note2" cols="48" rows="3" wrap="physical" class="text"  style="width:100%"><?php echo $note2; ?></textarea>
				</td>
			</tr>
			<tr>
            	<td>
					<B>Where is everything at right now?</B>
					<textarea name="note3" cols="48" rows="3" wrap="physical" class="text"  style="width:100%"><?php echo $note3; ?></textarea>
				</td>
			</tr>
			<tr>
            	<td align=center>
                    <INPUT type="button" value="save" name="Add" style="width:120px" onclick="javascript: save_edit_notes_show_report(this.form, <?php echo $userid; ?>,'<?php echo $notes_type; ?>'); ">&nbsp;<INPUT type="reset" value="Cancel" name="Cancel" onclick="javascript: edit_notes_show_report_exit(); " style="width:120px">
				</td>
			</tr>
		</table>
<?php		
	}
	else
	{
?>
        <table width=100% border=0 cellspacing=1 cellpadding=2 style="border:#CCCCCC solid 1px;" bgcolor="#FFFFCC">
            <input type="hidden" id="edit-notes_id" name="notes_id" value="<?php echo $notes_id; ?>"/>
            <input type="hidden" id="edit-notes_type" name="notes_type" value="<?php echo $notes_type; ?>"/>
            <input type="hidden" id="edit-action_type" name="action_type" value="save"/>
            <tr>
                <!-- <td>
                    <B>Edit Notes :</B>
                    <textarea id="notes_text" name="notes_content" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"><?php echo $comments; ?></textarea>
                </td> -->
                <td>
        		<div class="controls">
        			<B>Edit Notes :</B>
							<textarea id="notes_text" name="notes_content" cols="48" rows="7" wrap="physical" class="span6" style="width:100%"><?php echo $comments; ?></textarea>
				</div>
				
                </td>
            </tr>
            <tr>
                <td align=center>
                    <INPUT type="button" value="save" name="Add" style="width:120px" onclick="javascript: save_edit_notes_show_report(this.form, <?php echo $userid; ?>,'<?php echo $notes_type; ?>'); ">&nbsp;<INPUT type="reset" value="Cancel" name="Cancel" onclick="javascript: edit_notes_show_report_exit(); " style="width:120px">
                </td>
            </tr>
        </table>
<?php
	}
}
?>
