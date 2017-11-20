<?php
//2011-04-26  Roy Pepito <roy.pepito@remotestaff.com.au>
//staff_history(DB, STAFF_ID, (ADMIN-ID || STAFF-ID || AGENT-ID), (ADMIN-TYPE || STAFF-TYPE || AGENT-TYPE), METHOD, ACTION, CHANGES TYPE-optional);

function staff_history($db, $userid, $change_by_id, $change_by_type, $method, $action, $changes_type) 
{
	
	switch($method)
	{

		case "PHOTO":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded a PROFILE PHOTO named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a PROFILE PHOTO named <font color=#FF0000>[".$changes_type."]</font>";
					break;					
			}
			break;
			
		case "VOICE":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded a VOICE file named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "removed VOICE file</font>";
					break;					
			}
			break;
			
		case "OTHER":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded OTHER file named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a OTHER FILE named <font color=#FF0000>[".$changes_type."]</font>";
					break;					
			}
			break;
			
		case "SAMPLE WORK":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded a SAMPLE WORK file named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a SAMPLE WORK named <font color=#FF0000>[".$changes_type."]</font>";
					break;					
			}
			break;
			
		case "EMAIL SAMPLES":
			switch($action)
			{
				case "INSERT":
					$changes = "sent SAMPLES to <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a SETN EMAIL SAMPLES.";
					break;					
			}
			break;			
			
		case "SIGNED CONTRACT":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded a SIGNED CONTRACT file named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a SIGNED CONTRACT named <font color=#FF0000>[".$changes_type."]</font>";
					break;					
			}
			break;
			
		case "CREDIT CARD FORM":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded a CREDIT CARD FORM file named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a CREDIT CARD FORM named <font color=#FF0000>[".$changes_type."]</font>";
					break;					
			}
			break;
			
		case "DIRECT DEBIT FORM":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded a DIRECT DEBIT FORM file named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a DIRECT DEBIT FORM named <font color=#FF0000>[".$changes_type."]</font>";
					break;					
			}
			break;
			
		case "OTHER STAFF FILES":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded a OTHER STAFF FILES file named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a OTHER STAFF FILES named <font color=#FF0000>[".$changes_type."]</font>";
					break;					
			}
			break;
			
		case "RESUME":
			switch($action)
			{
				case "INSERT":
					$changes = "uploaded a RESUME file named <font color=#FF0000>[".$changes_type."]</font>";
					break;
				case "DELETE":
					$changes = "deleted a RESUME FILE named <font color=#FF0000>[".$changes_type."]</font>";
					break;						
			}
			break;
			
		case "STAFF ACCOUNT":
			switch($action)
			{
				case "DELETE":
					$changes = "marked as <font color=#FF0000>DELETED</font>";
					break;
			}
			break;
			
		case "HOT":
			switch($action)
			{
				case "INSERT":
					$changes = "added to <font color=#FF0000>HOT</font> staff listings";
					break;
				case "DELETE":
					$changes = "removed from <font color=#FF0000>HOT</font> staff listings";
					break;
			}
			break;
			
		case "EXPERIENCED":
			switch($action)
			{
				case "INSERT":
					$changes = "added to <font color=#FF0000>EXPERIENCED</font> staff listings.";
					break;
				case "DELETE":
					$changes = "removed from <font color=#FF0000>EXPERIENCED</font> staff listings";
					break;					
			}
			break;	
			
		case "NO SHOW":
			switch($action)
			{
				case "INSERT":
					$changes = "marked as <font color=#FF0000>NO SHOW</font> on ".$changes_type." RECRUITMENT.";
					break;
			}
			break;
			
		case "RECRUITER":
			switch($action)
			{
				case "INSERT":
					$changes = "candidate assigned to recruiter <font color=#FF0000>".$changes_type."</font>";
					break;
				case "UPDATE":
					$changes = "candidate replaced recruiter <font color=#FF0000>".$changes_type."</font>";
					break;
				default:
					break;
			}
			break;		
			
		case "STAFF STATUS":
			switch($action)
			{
				case "INSERT":
					$changes = "added status to <font color=#FF0000>".$changes_type."</font> listings.";
					break;
				default:
					break;
			}
			break;	

		case "COMMUNICATIONS":
			switch($action)
			{
				case "INSERT":
					$changes = "added a communication notes <font color=#FF0000>[".$changes_type."].</font>";
					break;
				case "DELETE":
					$changes = "removed an <font color=#FF0000>[".$changes_type."].</font> notes.";
					break;
				default:
					break;
			}
			break;	
			
		case "PROFILE":
			switch($action)
			{
				case "UPDATE":
					$changes = "updated the <font color=#FF0000>profile.</font>";
					break;
				default:
					break;
			}
			break;	
			
		case "HIGHEST QUALIFICATION":
			switch($action)
			{
				case "INSERT":
					$changes = "added <font color=#FF0000>highest qualification.</font>";
					break;
				default:
					break;
			}
			break;	
			
		case "SKILLS":
			switch($action)
			{
				case "INSERT":
					$changes = "added <font color=#FF0000>skills.</font>";
					break;
				case "DELETE":
					$changes = "deleted a record from <font color=#FF0000>skill's</font> list.";
					break;
				default:
					break;
			}
			break;
			
		case "LANGUAGES":
			switch($action)
			{
				case "INSERT":
					$changes = "added new <font color=#FF0000>language.</font>";
					break;
				case "DELETE":
					$changes = "deleted a record from <font color=#FF0000>languages</font> list.";
					break;
				default:
					break;
			}
			break;	
			
		case "EMPLOYMENT HISTORY":
			switch($action)
			{
				case "INSERT":
					$changes = "added new record on <font color=#FF0000>employment history</font> section.";
					break;
				case "UPDATE":
					$changes = "updated the <font color=#FF0000>employment history</font> section.";
					break;
				default:
					break;
			}
			break;
			
		case "RELEVANT INDUSTRY EXPERIENCE":
			switch($action)
			{
				case "INSERT":
					$changes = "added new record on <font color=#FF0000>relevant industry experience</font> section.";
					break;
				default:
					break;
			}
			break;		
			
		case "EVALUATION SECTION":
			switch($action)
			{
				case "INSERT":
					$changes = "added the following information <br /><font color=#FF0000>[".$changes_type."]</font><br />on the evaluation section.";
					break;
				case "UPDATE":
					$changes = "made the following changes <br/><font color=#FF0000>[".$changes_type."]</font><br />on the evaluation section.";
					break;
				default:
					break;
			}
			break;		
			
		case "STAFF RESUME UP TO DATE":
			switch($action)
			{
				case "INSERT":
					$changes = "confirms <font color=#FF0000>[Staff Resume Up to Date]</font>.";
					break;
				default:
					break;
			}
			break;
		default:
			break;
	}
	
	if($change_by_type == "ADMIN")
	{
		$sql=$db->select()
			->from('admin')
			->where('admin_id = ?' ,$change_by_id);
		$admin = $db->fetchRow($sql);
		$change_by_type = $admin['status'];
		if($change_by_type == "FULL-CONTROL")
		{
			$change_by_type = "ADMIN";
		}
	}
	
	$date_change = date("Y-m-d")." ".date("H:i:s");
	$data= array(
	'userid' => $userid,
	'change_by_id' => $change_by_id,
	'change_by_type' => $change_by_type,
	'changes' => $changes,
	'date_change' => $date_change
	);
	$db->insert('staff_history', $data);
}
?>
