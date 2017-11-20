<?php
include('../conf/zend_smarty_conf.php');

include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

include_once('../lib/staff_files_manager.php') ;

if(!$_SESSION['admin_id']){
	header("location:index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE"){ 
	echo "This page is for HR usage only.";
	exit;
}

$admin_id = $_SESSION['admin_id'];
$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);
$recruiter_full_name = $admin['admin_fname']." ".$admin['admin_lname'];
$recruiter_user_type = $admin['status'];

require_once('../lib/paginator.class.php');

$pages = new Paginator;
$lim = $offset.", ".$rowsPerPage;
$condition = "p.status <> 'DELETED'";
$table_from = "";


//START: get posted data
$date_requested1 = $_REQUEST["date_requested1"];
$date_requested2 = $_REQUEST["date_requested2"];
$registered_date_check = $_REQUEST["registered_date_check"];

$date_updated1 = $_REQUEST["date_updated1"];
$date_updated2 = $_REQUEST["date_updated2"];
$updated_date_check = $_REQUEST["updated_date_check"];

$registered_key = $_REQUEST["registered_key"];
$registered_key_type = $_REQUEST["registered_key_type"];
$registered_key_check = $_REQUEST["registered_key_check"];

$search_recruiter_options = $_REQUEST["search_recruiter_options"];
$search_inactive_options = $_REQUEST["search_inactive_options"];

$position = $_REQUEST["position"];

$registered_advance_search = $_REQUEST["registered_advance_search"];

$posting_id = $_REQUEST["posting_id"];

$staff_status = $_REQUEST["staff_status"];
if($staff_status == "" || $staff_status == NULL)
{
	$staff_status = $_SESSION["statf_status"];
	$_REQUEST["staff_status"] = $_SESSION["statf_status"];
}

$search_lead_id = $_REQUEST["search_lead_id"];
//ENDED: get posted data


//START: country filter options
if($condition <> "" && $_SESSION["country_option"] <> 'all') $condition .= " AND ";
if(!isset($_SESSION["country_option"]))
{
	$_SESSION["country_option"] = "philippines";
}
if(@isset($_REQUEST['country_option']))
{
	$_SESSION["country_option"] = $_REQUEST['country_option'] ;
}
	
switch($_SESSION["country_option"])
{
	case "philippines":
		$country_id = "PH";
		break;
	case "china":
		$country_id = "CN";
		break;
	case "india":
		$country_id = "IN";
		break;
	case "all":
		$country_id = "ALL";
		break;			
}

if($country_id <> "ALL")
{
	$condition .= "p.country_id='$country_id'";
}
//ENDED: country filter options


//START: status filter
if($condition <> "" && $_REQUEST["staff_status"] <> "" && $_REQUEST["staff_status"] <> 'ALL') $condition .= " AND ";
switch($_REQUEST["staff_status"]) 
{
	case "ASL":
		$table_from .= "tb_request_for_interview ir";
		$condition .= "p.userid=ir.applicant_id";
		break;
	case "ENDORSED":
		$table_from .= "tb_endorsement_history end";
		if($search_lead_id <> "")
		{
			$condition .= "p.userid=end.userid AND end.client_name = '$search_lead_id'";	
		}
		else
		{
			$condition .= "p.userid=end.userid";	
		}
		break;
	case "SHORTLISTED":
		$table_from .= "tb_shortlist_history ss";
		$condition .= "p.userid=ss.userid";	
		break;
	case "INACTIVE":
		$table_from .= "inactive_staff ina";
		$condition .= "p.userid=ina.userid";		
		break;
	case "PRESCREENED":
		$table_from .= "pre_screened_staff pres";
		$condition .= "p.userid=pres.userid";		
		break;
	case "UNPROCESSED":
		$table_from .= "unprocessed_staff unpro";
		$condition .= "p.userid=unpro.userid";		
		break;
}
//ENDED: status filter


//START: add personal table on the query
if($table_from <> "") 
{ 
	$table_from .= ", personal p"; 
}	
else
{
	$table_from .= "personal p"; 
}
//ENDED: add personal table on the query
	
	
//START: advance search
if(isset($_REQUEST["registered_advance_search"]))
{
	//start: position query
	if($position <> "")
	{
		if($_REQUEST["staff_status"] == "SHORTLISTED")
		{
			if($table_from <> "") $table_from .= ", ";
			$table_from .= "posting pos"; 
			if($condition <> "") $condition .= " AND ";
			$condition .= "p.userid=ss.userid AND ss.position=pos.id AND ss.position = '$position'";				
		}
		else
		{		
			//if($table_from <> "") $table_from .= ", ";
			//$table_from .= "recruiter_staff rec, applicants ap, posting pos";
			//$table_from .= "posting pos";
			if($condition <> "") $condition .= " AND ";
			//$condition .= "p.userid=ap.userid AND ap.posting_id=pos.id AND ap.posting_id = '$position'";
			$condition .= "end.position  = '$position'";
		}
	}
	//ended: position query
	
	//start: recruitment query
	if($search_recruiter_options <> "")
	{
		if($table_from <> "") $table_from .= ", ";
		$table_from .= "recruiter_staff rec";
		if($condition <> "") $condition .= " AND ";
		$condition .= "rec.userid=p.userid AND rec.admin_id='$search_recruiter_options'";
	}
	//ended: recruitment query
	
	//start: inactive query
	if($search_inactive_options <> "")
	{
		if($table_from <> "") $table_from .= ", ";
		$table_from .= "inactive_staff inact";
		if($condition <> "") $condition .= " AND ";
		$condition .= "inact.userid=p.userid AND inact.type='$search_inactive_options'";
	}	
	//ended: inactive query	

	//start: date registered query
	if($registered_date_check == "" || $registered_date_check == NULL)
	{
		if($condition <> "") $condition .= " AND ";
		$condition .= "(DATE(p.datecreated) BETWEEN '$date_requested1' AND '$date_requested2')";
	}
	//ended: date registered query
	
	//start: date updated query
	if($updated_date_check == "" || $updated_date_check == NULL)
	{
		if($table_from <> "") $table_from .= ", ";
		$table_from .= "staff_resume_up_to_date u";
		if($condition <> "") $condition .= " AND ";
		$condition .= "(DATE(u.date) BETWEEN '$date_updated1' AND '$date_updated2') AND p.userid=u.userid";
	}
	//ended: date updated query	

	//start: search by keyword
	if(($registered_key_check == "" || $registered_key_check == NULL) && trim($registered_key) != "")
	{
		if($condition <> "") $condition .= " AND ";
		$key_multi = array();
		if (preg_match("/\,/i", $registered_key)) $key_multi = explode(',', $registered_key);
										
		switch($registered_key_type)
		{
			case "id":
				if (count($key_multi)>0) 
				{
					$key_cond = implode("' OR p.userid='", $key_multi);
					$key_cond = "p.userid='" . $key_cond;
					$key_cond .= "'";
				} else $key_cond = "p.userid='$registered_key'";
				$query = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond ) ORDER BY p.datecreated DESC";
				$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition ( $key_cond )";
				$query2 = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond )";
				break;
					
			case "fname":
				if (count($key_multi)>0) 
				{
					$key_cond = implode("%' OR p.fname LIKE '%", $key_multi);
					$key_cond = "p.fname LIKE '%" . $key_cond;
					$key_cond .= "%'";
				} else $key_cond = "p.fname LIKE '%$registered_key%'";
				$query = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond ) ORDER BY p.datecreated DESC";
				$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition ( $key_cond )";
				$query2 = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond )";
				break;
				
			case "lname":
				if (count($key_multi)>0) 
				{
					$key_cond = implode("%' OR p.lname LIKE '%", $key_multi);
					$key_cond = "p.lname LIKE '%" . $key_cond;
					$key_cond .= "%'";
				} else $key_cond = "p.lname LIKE '%$registered_key%'";
				$query = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond ) ORDER BY p.datecreated DESC";
				$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition ( $key_cond )";
				$query2 = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond )";
				break;
				
			case "email":
				if (count($key_multi)>0) 
				{
					$key_cond = implode("%' OR p.email LIKE '%", $key_multi);
					$key_cond = "p.email LIKE '%" . $key_cond;
					$key_cond .= "%'";
				} else $key_cond = "p.email LIKE '%$registered_key%'";
				$query = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond ) ORDER BY p.datecreated DESC";
				$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition ( $key_cond )";
				$query2 = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond )";
				break;
				
			case "skills":
				$table_from .= " INNER JOIN skills s ON p.userid=s.userid";
				if (count($key_multi)>0) 
				{
					$key_cond = implode("%' OR s.skill LIKE '%", $key_multi);
					$key_cond = "s.skill LIKE '%" . $key_cond;
					$key_cond .= "%'";
				} else $key_cond = "s.skill LIKE '%$registered_key%'";
												
				$query = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond ) ORDER BY p.datecreated DESC";
				$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition ( $key_cond )";
				$query2 = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond )";
				break;										
				
			case "resume_body":
				$table_from .= " INNER JOIN currentjob c ON p.userid=c.userid";
				if (count($key_multi)>0) 
				{
					$key_cond = implode("%' OR c.latest_job_title LIKE '%", $key_multi);
					$key_cond = "c.latest_job_title LIKE '%" . $key_cond;
					$key_cond .= "%'";
				} else $key_cond = "c.latest_job_title LIKE '%$registered_key%'";
				$query = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition (($key_cond) OR (c.duties5 LIKE '%$registered_key%') OR (c.position5 LIKE '%$registered_key%') OR (c.companyname5 LIKE '%$registered_key%') OR (c.duties4 LIKE '%$registered_key%') OR (c.position4 LIKE '%$registered_key%') OR (c.companyname4 LIKE '%$registered_key%') OR (c.duties3 LIKE '%$registered_key%') OR (c.position3 LIKE '%$registered_key%') OR (c.companyname3 LIKE '%$registered_key%') OR (c.duties2 LIKE '%$registered_key%') OR (c.position2 LIKE '%$registered_key%') OR (currentjob.companyname2 LIKE '%$registered_key%') OR (c.duties LIKE '%$registered_key%') OR (c.position LIKE '%$registered_key%') OR (c.companyname LIKE '%$registered_key%') OR (c.freshgrad LIKE '%$registered_key%')) ORDER BY p.datecreated DESC";
				$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition (($key_cond) OR (c.duties5 LIKE '%$registered_key%') OR (c.position5 LIKE '%$registered_key%') OR (c.companyname5 LIKE '%$registered_key%') OR (c.duties4 LIKE '%$registered_key%') OR (c.position4 LIKE '%$registered_key%') OR (c.companyname4 LIKE '%$registered_key%') OR (c.duties3 LIKE '%$registered_key%') OR (c.position3 LIKE '%$registered_key%') OR (c.companyname3 LIKE '%$registered_key%') OR (c.duties2 LIKE '%$registered_key%') OR (c.position2 LIKE '%$registered_key%') OR (currentjob.companyname2 LIKE '%$registered_key%') OR (c.duties LIKE '%$registered_key%') OR (c.position LIKE '%$registered_key%') OR (c.companyname LIKE '%$registered_key%') OR (c.freshgrad LIKE '%$registered_key%'))";
				$query2 = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition (($key_cond) OR (c.duties5 LIKE '%$registered_key%') OR (c.position5 LIKE '%$registered_key%') OR (c.companyname5 LIKE '%$registered_key%') OR (c.duties4 LIKE '%$registered_key%') OR (c.position4 LIKE '%$registered_key%') OR (c.companyname4 LIKE '%$registered_key%') OR (c.duties3 LIKE '%$registered_key%') OR (c.position3 LIKE '%$registered_key%') OR (c.companyname3 LIKE '%$registered_key%') OR (c.duties2 LIKE '%$registered_key%') OR (c.position2 LIKE '%$registered_key%') OR (currentjob.companyname2 LIKE '%$registered_key%') OR (c.duties LIKE '%$registered_key%') OR (c.position LIKE '%$registered_key%') OR (c.companyname LIKE '%$registered_key%') OR (c.freshgrad LIKE '%$registered_key%'))";				

			case "notes":
				$table_from .= " INNER JOIN applicant_history a ON p.userid=a.userid";
				$query = "SELECT DISTINCT(p.userid)
				FROM $table_from WHERE $condition (a.history LIKE '%$registered_key%' OR a.subject LIKE '%$registered_key%') ORDER BY p.datecreated DESC ";
				$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition (a.history LIKE '%$registered_key%' OR a.subject LIKE '%$registered_key%')";
				$query2 = "SELECT  DISTINCT(p.userid) FROM $table_from WHERE $condition (a.history LIKE '%$registered_key%' OR a.subject LIKE '%$registered_key%')";
				break;
				
			case "mobile":
				if (count($key_multi)>0) 
				{
					$key_cond = implode("%' OR p.handphone_no LIKE '%", $key_multi);
					$key_cond = "p.handphone_no LIKE '%" . $key_cond;
					$key_cond .= "%'";
				} else $key_cond = "p.handphone_no LIKE '%$registered_key%'";
				$query = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond ) ORDER BY p.datecreated DESC";
				$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition ( $key_cond )";
				$query2 = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ( $key_cond )";
				break;
				
		}
	}
	//ended: search by keyword
	
	//start: default
	else
	{
		$query = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition ORDER BY p.datecreated DESC ";
		$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition";
		$query2 = "SELECT DISTINCT(p.userid) FROM $table_from WHERE $condition";
	}
	//ended: default
	
} 
//ENDED: advance search


//START: search by position advertized
elseif($posting_id <> NULL || $posting_id <> "")
{
	$registered_date_check = "on";
	$updated_date_check = "on";


	if($_REQUEST["staff_status"] == "SHORTLISTED")
	{
		if($table_from <> "") 
		{ 
			$table_from .= ", posting pos"; 
		}
		else
		{
			$table_from = "personal p, posting pos"; 
		}
		if($condition <> "") $condition .= " AND ";
		$condition .= "p.userid=ss.userid AND ss.position=pos.id AND ss.position = '$posting_id'";		
		
		$query = "SELECT DISTINCT(ss.userid)
		FROM ".$table_from." 
		WHERE ".$condition."
		ORDER BY ss.date_listed ";
		$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition";
		$query2 = "SELECT DISTINCT(ss.userid) 
		FROM ".$table_from." 
		WHERE ".$condition;
		
	}
	else
	{
		if($table_from <> "") 
		{ 
			//$table_from .= ", applicants ap, posting pos"; 
			$table_from .= ", applicants ap, posting pos"; 
		}
		else
		{
			$table_from = "personal p, applicants ap, posting pos"; 
		}
		if($condition <> "") $condition .= " AND ";
		$condition .= "p.userid=ap.userid AND ap.posting_id=pos.id AND ap.posting_id = '$posting_id'";	
		
		$query = "SELECT DISTINCT(ap.userid)
		FROM ".$table_from." 
		WHERE ".$condition."
		ORDER BY ap.date_apply ";	
		$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' WHERE $condition";
		$query2 = "SELECT DISTINCT(ap.userid) 
		FROM ".$table_from." 
		WHERE ".$condition;
	}
}
//ENDED: search by position advertized


//START: default query && postings query
else
{
	$registered_date_check = "on";
	$updated_date_check = "on";
	if($table_from == "") 
	{
		$table_from = "personal p"; 
	}	
	if($condition <> "") $condition = "WHERE ".$condition;
	$query = "SELECT DISTINCT(p.userid) FROM ".$table_from." ".$condition." ORDER BY p.datecreated DESC ";
	$query_mass_emailing = "UPDATE $table_from SET mass_emailing_status='WAITING' $condition";
	$query2 = "SELECT DISTINCT(p.userid) FROM ".$table_from." ".$condition;
}
//ENDED: default query && postings query


//START: pages
	//start: calculate pages
	$t = $db->fetchAll($query2);	
	$items = count($t);	
	$pages->items_total = $items;
					
	$pages->mid_range = 7;
	$pages->items_per_page = 100;
	$pages->paginate();
					
	$show_last = ($pages->items_total > $pages->high) ? $pages->high+1 : $pages->items_total;
	//ended: calculate pages
//ENDED: pages


//START: recruiter's options
$search_recruiter_assign_options = "<option value=''>SELECT RECRUITER</option>";
$search_recruiter_options = $_REQUEST["search_recruiter_options"];
$q ="SELECT admin_id, admin_fname, admin_lname 
		FROM admin 
		WHERE status='HR' 
		OR admin_id='39' 
		OR admin_id='41'
		OR admin_id='50'
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81'  AND admin_id <> 161  		
		order by admin_fname";
$temp = 0;
$result = $db->fetchAll($q);
foreach($result as $r)
{	
	if($r['admin_id'] == '56' || $r['admin_id'] == '59')
	{
		//do nothing
	}
	else
	{
		$search_recruiter_assign_options .= "<option value='".$r['admin_id']."'>".strtoupper(stripslashes($r['admin_fname']." ".$r['admin_lname']))."</option>";
		if($r['admin_id'] == $_REQUEST["search_recruiter_options"])
		{
			$temp = 1;
			$search_recruiter_options = $search_recruiter_options."<option value='".$r['admin_id']."' selected>".strtoupper(stripslashes($r['admin_fname']." ".$r['admin_lname']))."</option>";
		}
		$search_recruiter_options = $search_recruiter_options."<option value='".$r['admin_id']."'>".strtoupper(stripslashes($r['admin_fname']." ".$r['admin_lname']))."</option>";
	}
}
if($temp == 0)
{
	$search_recruiter_options = $search_recruiter_options."<option value='' selected>ANY</option>";
}
else
{
	$search_recruiter_options = "<option value=''>ANY</option>".$search_recruiter_options;	
}		
//ENDED: recruiter's options


//START: inactive options
switch($search_inactive_options)
{
	case 'NO POTENTIAL':
		$search_inactive_options = "
		<option value='NO POTENTIAL' selected>NO POTENTIAL</option>
		<option value='NOT INTERESTED'>NOT INTERESTED</option>
		<option value='NOT READY'>NOT READY</option>
		<option value='BLACKLISTED'>BLACKLISTED</option>	
		<option value=''>ANY</option>
		";
		break;
	case 'NOT INTERESTED':
		$search_inactive_options = "
		<option value='NO POTENTIAL'>NO POTENTIAL</option>
		<option value='NOT INTERESTED' selected>NOT INTERESTED</option>
		<option value='NOT READY'>NOT READY</option>
		<option value='BLACKLISTED'>BLACKLISTED</option>	
		<option value=''>ANY</option>
		";
		break;
	case 'NOT READY':
		$search_inactive_options = "
		<option value='NO POTENTIAL'>NO POTENTIAL</option>
		<option value='NOT INTERESTED'>NOT INTERESTED</option>
		<option value='NOT READY' selected>NOT READY</option>
		<option value='BLACKLISTED'>BLACKLISTED</option>	
		<option value=''>ANY</option>
		";
		break;
	case 'BLACKLISTED':
		$search_inactive_options = "
		<option value='NO POTENTIAL'>NO POTENTIAL</option>
		<option value='NOT INTERESTED'>NOT INTERESTED</option>
		<option value='NOT READY'>NOT READY</option>
		<option value='BLACKLISTED' selected>BLACKLISTED</option>	
		<option value=''>ANY</option>
		";
		break;
	default:
		$search_inactive_options = "
		<option value='NO POTENTIAL'>NO POTENTIAL</option>
		<option value='NOT INTERESTED'>NOT INTERESTED</option>
		<option value='NOT READY'>NOT READY</option>
		<option value='BLACKLISTED'>BLACKLISTED</option>	
		<option value='' selected>ANY</option>
		";
		break;
}
//ENDED: inactive options


//START: position advertised & position for search dropdown
$position = "<select name='position' id='position_id' style='width:100%'>";
$position .= "<option value=''>ANY</option>\n";
$position_advertised = "<select name=\"menu1\" size=\"20\" style='width:100%' onChange=\"javascript: window.location='?posting_id='+this.value+'&staff_status=".$staff_status."'; \">";
$counter = 0;					
$result = $db->fetchAll("SELECT id, lead_id, date_created, jobposition FROM posting WHERE status='ACTIVE'");
foreach($result as $row)
{
	$l_id = $row['lead_id'];
	$client_name = "";
	if($l_id <> "")
	{
		$sql=$db->select()
		->from('leads')
		->where('id = ?',$l_id)
		->limit(1);
		$l = $db->fetchRow($sql);
		$client_name = $l['fname']." ".$l['lname'];	
	}
	
	if($posting_id == $row['id'])
	{
		$position_advertised .= "<option value=".$row['id']." selected>".$row['jobposition']." (".$client_name.")</option>\n";
	}
	else
	{
		$position_advertised .= "<option value=".$row['id'].">".$row['jobposition']." (".$client_name.")</option>\n";
	} 
	
	if($_REQUEST["position"] == $row['id'])
	{
		$position .= "<option value=".$row['id']." selected>".$row['jobposition']." (".$client_name.")</option>\n";
	}
	else
	{
		$position .= "<option value=".$row['id'].">".$row['jobposition']." (".$client_name.")</option>\n";
	} 	
	$counter++;
}
$position_advertised .= "</select>";
$position .= "</select>";
//ENDED: position advertised & position for search dropdown


//START: update emailing list
if($_REQUEST["mass_email"] == "on" && $_SESSION["mass_email_status"] == "waiting")
{
	//start: insert to emailing list
	mysql_query("UPDATE personal SET mass_emailing_status='DO NOTHING'");
	mysql_query($query_mass_emailing);
	$_SESSION["mass_email_status"] = "executed";
	//ended: insert to emailing list
	header("location: staff_mass_emailing.php"); 
	exit;
}
//ENDED: update emailing list


//START: search result listings
$counter=$offset;
$counter=0;
$curr_id = 0;
$bgcolor = "#E4E4E4";
$counter_checker = 1;

//if($_REQUEST["staff_status"] == 'ENDORSED'){
//	$query = "SELECT distinct(teh.userid) 
//		FROM posting AS p, tb_endorsement_history AS teh
//		WHERE p.id = ".$_REQUEST["position"]."
//		AND teh.client_name = p.lead_id
//		and teh.position = ".$_REQUEST["position"];
//}
//if($_REQUEST["staff_status"] == 'SHORTLISTED'){
//	$query = "SELECT * FROM `tb_shortlist_history`
//		where position = ".$_REQUEST["position"]; 
//}
//echo $query;

$r_s = mysql_query($query . $pages->limit);
while ($row = @mysql_fetch_assoc($r_s)) 
{
                                        $userid = $row["userid"];
										$counter++;
										
										//start: get experienced staff
										$experienced = '';
										$sql = $db->select()
										->from('experienced_staff','id')
										->where('userid = ?', $userid)
										->limit(1);
										$data = $db->fetchOne($sql);
										if ($data) { $experienced = "checked=checked"; }										
										//ended: get experienced staff
										
										//start: get hot staff
										$hot = '';
										$sql = $db->select()
										->from('hot_staff','id')
										->where('userid = ?', $userid)
										->limit(1);
										$data = $db->fetchOne($sql);
										if ($data) { $hot = "checked=checked"; }
										//ended: get hot staff										
										
										//start: get recruiter
										$assigned_recruiter = "";
										$sql = $db->select()
										->from('recruiter_staff','admin_id')
										->where('userid = ?', $userid)
										->limit(1);
										$a = $db->fetchRow($sql);
										if ($a['admin_id'] <> '') 
										{ 
											$sql = $db->select()
											->from('admin')
											->where('admin_id = ?', $a['admin_id'])
											->limit(1);
											$ad = $db->fetchRow($sql);
											$assigned_recruiter = $ad['admin_fname']." ".$ad['admin_lname'];											
										}
										//ended: get recruiter
										
										//start: get latest staff status
										$sql = $db->select()
										->from('applicant_status','status')
										->where('personal_id = ?', $userid)
										->order('date DESC')
										->limit(1);
										$data = $db->fetchOne($sql);
										$latest_staff_status = $data;										
										//ended: get latest staff status
										
										//start: get latest job title
										$sql = $db->select()
										->from('currentjob','latest_job_title')
										->where('userid = ?', $userid)
										->limit(1);
										$data = $db->fetchOne($sql);
										$latest_job_title = $data;
										//ended: get latest job title
										
										//start: query to get searched result data
                                        if ($userid == 0) continue;
                                        $sql = "SELECT p.userid, p.lname, p.fname, p.email, p.skype_id, p.image, DATE_FORMAT(p.datecreated,'%D %b %Y') date,"
                                        . "p.status p_status, p.voice_path, c.latest_job_title "
                                        . "FROM personal p LEFT JOIN currentjob c ON p.userid=c.userid "
                                        . "WHERE p.userid=".$userid ." ORDER BY date DESC LIMIT 1";
                                        $query_object = mysql_query($sql);
                                        $result = mysql_fetch_array($query_object);	
                                        $lname = $result['lname'];
                                        $fname = $result['fname'];
                                        $email = $result['email'];
                                        $skype_id = $result['skype_id'];
                                        $image= $result['image'];
                                        $date = $result['date'];
                                        $status = $result['status'];
                                        $voice_path = $result['voice_path'];
                                        $latest_job_title = $result['latest_job_title'];
                                        $skill = $result['skill'];
                                        $a_id = $result['a_id'];
                                        $a_status = $result['a_status'];
										//ended: query to get searched result data

										$searched_result_listings .= "
                                        <tr bgcolor='".$bgcolor."'>
											<td valign=top><font color=#999999><strong>#".$counter."</strong></font></td>
                                            <td style=\"border-right: #006699 2px solid;\" align=right width=\"15%\">
                                            	<div id=\"div1".$userid."\">
                                            		<a href='staff_information.php?staff_status=".$_REQUEST["staff_status"]."&userid=".$userid."'><strong>".strtoupper($fname." ".$lname)."</strong></a>
													<div id=\"div_rec".$userid."\"><font color=#FF0000>".$assigned_recruiter."</font></div>
													<div><font size=1>".$latest_job_title."</font></div>
													<div><font size=1>".$email."<br>"."SkypeId : ".$skype_id."</font></div>";
													if($_REQUEST["staff_status"] == "ALL")
													{
														$searched_result_listings .= "<div><font size=1>Status : ".$latest_staff_status."</font></div>";
													}
														if ($voice_path <> "") 
														{ 
															$file_manager = new staff_files_manager('../',$userid) ;
															$staff_voice_file = $file_manager->retrieve_voice_file();														
															$searched_result_listings .= $staff_voice_file;
														}
														
										$searched_result_listings .= "
												</div>
											</td>
                                            <td align=\"left\" width=\"50%\" valign=\"top\">
                                                <div id=\"popup_container".$userid."\"></div> 
                                                <div id=\"div2".$userid."\">
                                                    <em><font size=2>";
														
														if($_REQUEST["staff_status"] <> "ENDORSED")
														{
															$sql_query = mysql_query("SELECT skill FROM skills WHERE userid=".$userid);
															$skill_str = '';
															while ($skillset = mysql_fetch_array($sql_query)) 
															{
																if ($skill_str) $skill_str .= ",&nbsp;&nbsp;";
																$skill_str .= $skillset['skill'];
															}
															$searched_result_listings .= $skill_str;
														}
														else
														{
															$endorsement_history = "";
															$endorsement_history .= '<table>';
															$eq = "SELECT client_name, position, job_category, date_endoesed
															FROM tb_endorsement_history WHERE userid='$userid'
															ORDER BY position ASC;";
															$e_result = $db->fetchAll($eq);
															$e_counter = 0;
															foreach($e_result as $e)
															{
																$e_counter++;
																
																$date_endorsed = date('F j, Y',strtotime($e['date_endoesed'])); //new Zend_Date($e['date_endoesed'], 'YYYY-MM-dd HH:mm:ss');
																
																//start: get lead info
																$sql=$db->select()
																	->from('leads')
																	->where('id = ?' ,$e['client_name']);
																$l_info = $db->fetchRow($sql);
																$lead_name = $l_info['fname']." ".$l_info['lname'];
																//ended: get lead info
																
																//start: get position info
																$sql=$db->select()
																	->from('posting')
																	->where('id = ?' ,$e['position']);
																$p_info = $db->fetchRow($sql);
																$position_name = $p_info['jobposition'];
																//ended: get position info	
																
																//start: get job category info
																if($position_name == "")
																{
																	$sql=$db->select()
																		->from('job_sub_category')
																		->where('sub_category_id = ?' ,$e['job_category']);
																	$p_info = $db->fetchRow($sql);
																	$position_name = $p_info['sub_category_name'];
																}
																//ended: get job category info																	
															
																$endorsement_history .= '	
																<tr>
																	<td class="td_info td_la" valign=top><font size=1>'.$e_counter.'&nbsp;>&nbsp;</font></td>
																	<td class="td_info" valign=top><a href="javascript: lead('.$e['client_name'].'); ">'.$lead_name.'</a></td>
																	<td class="td_info" valign=top>&nbsp;<font size=1>></font>&nbsp;</td>
																	<td class="td_info" valign=top>'.$position_name.'</td>
																	<td class="td_info" valign=top>&nbsp;<font size=1>></font>&nbsp;</td>
																	<td class="td_info td_la" valign=top><font size=1>'.$date_endorsed.'</font></td>
																</tr>';
															}
															$endorsement_history .= '</table>';
															$searched_result_listings .= $endorsement_history;
														}
														
										$searched_result_listings .= "
                                                    </font></em> 
												</div>                                                           
                                            </td>
                                            <td align=\"center\" width=\"15%\" valign=\"top\">
                                            	<div id=\"div3".$userid."\">".$date."</div>
											</td>
                                            <td align=\"center\" width=\"0%\" valign=\"top\">
                                            	<div id=\"div4".$userid."\">
                                                    <input type=\"checkbox\" disabled=\"disabled\" id=\"hot\" name=\"registered_date_check\" onclick=\"javascript: mark_as_hot(".$userid.",this); \" ".$hot." />
                                                    <input type=\"checkbox\" disabled=\"disabled\" id=\"experienced\" name=\"registered_date_check\" onclick=\"javascript: mark_as_experienced(".$userid.",this); \" ".$experienced." />
													<input name=\"app_name".$userid."\" id=\"app_id".$userid."\" type=\"checkbox\" value=\"\" onchange=\"javascript: order(".$userid.");\" ";
													if(strpos(",".$_SESSION['allstaff_request_selected'],$userid)) { $searched_result_listings .= "checked"; }
													$searched_result_listings .= "/>
                                                </div>
                                            </td>
											
                                            <td align=\"center\" width=\"0%\" valign=\"top\">
                                            	<div id=\"div5".$userid."\">
                                                	<input name=\"open_profile\" onclick=\"javascript: delete_staff(".$userid."); \" type=\"radio\" value=\"".$userid."\" />
                                                </div>
											</td>
                                            <td align=\"center\" width=\"0%\" valign=\"top\">
                                            	<div id=\"div6".$userid."\">
                                                	<input name=\"open_profile\" onclick=\"javascript: open_assign_recruiter(".$userid."); \" type=\"radio\" value=\"".$userid."\" />
                                                </div>
											</td>
                                            <td align=\"center\" width=\"0%\" valign=\"top\">
                                            	<div id=\"div7".$userid."\">
                                                	<input name=\"open_profile\" onclick=\"javascript: open_popup_profile(".$userid."); \" type=\"radio\" value=\"".$userid."\" />
                                                </div>
											</td>
										</tr>";
                                        
	if($counter_checker == 1)
	{
		$bgcolor = "#F5F5F5";
		$counter_checker = 0;
	}
	else
	{
		$bgcolor = "#E4E4E4";
		$counter_checker = 1;
	}									
} 
//START: search result listings


//START: result pages
$result_pages = "<table>".
"<tr><td>Total Record: ".$pages->items_total ." &nbsp; &nbsp;</td>".
"<td> [ Showing ".($pages->low+1)." - ".$show_last." ]</td>".
"<td> &nbsp; ".$pages->display_pages()."</td><td> &nbsp; ".$pages->display_items_per_page()." &nbsp; </td>".
"<td>".$pages->display_jump_menu()."</td>".
"</tr></table>";	
$result_pages=str_replace('<option value="All">All</option>','',$result_pages);
//ENDED: result pages


//START: endorsement listings session
include("staff_custom_booking_session_selected.php");
//ENDED: endorsement listings session


//START: caledar date picker jscript
$search_date_requested1 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_requested1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_requested1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
$search_date_requested2 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_requested2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_requested2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';

$search_date_updated1 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_updated1",
		ifFormat	: "%Y-%m-%d",
		button		: "date_updated1_button",
		align		: "Tl",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
$search_date_updated2 = '
<script type="text/javascript">
	Calendar.setup({
		inputField	: "id_date_updated2",
		ifFormat	: "%Y-%m-%d",
		button		: "date_updated2_button",
		align		: "T2",
		showsTime	: false, 
		singleClick	: true
	});
</script> 
';
//ENDED: caledar date picker jscript

$smarty->assign('search_lead_id', $search_lead_id);
$smarty->assign('return_output', $return_output);

$smarty->assign('registered_key_type', $registered_key_type);

$smarty->assign('search_date_requested1', $search_date_requested1);
$smarty->assign('search_date_requested2', $search_date_requested2);

$smarty->assign('search_date_updated1', $search_date_updated1);
$smarty->assign('search_date_updated2', $search_date_updated2);

$smarty->assign('position', $position);
$smarty->assign('position_advertised', $position_advertised);
$smarty->assign('staff_status', $_REQUEST["staff_status"]);
$smarty->assign('country_option', $_SESSION["country_option"]);

$smarty->assign('date_requested1', $date_requested1);
$smarty->assign('date_requested2', $date_requested2);
$smarty->assign('registered_date_check', $registered_date_check);

$smarty->assign('date_updated1', $date_updated1);
$smarty->assign('date_updated2', $date_updated2);
$smarty->assign('updated_date_check', $updated_date_check);

$smarty->assign('registered_key', $registered_key);
$smarty->assign('registered_key_check', $registered_key_check);
$smarty->assign('search_recruiter_options', $search_recruiter_options);
$smarty->assign('search_inactive_options', $search_inactive_options);
$smarty->assign('searched_result_listings', $searched_result_listings);
$smarty->assign('result_pages', $result_pages);
$smarty->assign('search_recruiter_assign_options', $search_recruiter_assign_options);
$smarty->display('staff.tpl');
?>