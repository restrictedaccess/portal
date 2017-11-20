<?php
include('../conf/zend_smarty_conf.php') ;
include '../config.php';
include '../conf.php';
include_once "lib/Force.php";

//temporary disable export function
ini_set("memory_limit", -1);
if(!$_SESSION['admin_id']){
	header("location:/portal/index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE"){ 
	echo "This page is for HR usage only.";
	exit;
}

$admin = $db->fetchRow($db->select()->from(array("adm"=>"admin"), array("export_staff_list"))->where("adm.admin_id = ?", $_SESSION["admin_id"]));
if ($admin&&$admin["export_staff_list"]=="N"){
	echo json_encode(array("notallowed"=>true));
	die;
}


function getApplicants($posting,$page,$date_start,$date_end,$updated_date_start,$updated_date_end,$recruiter,$keyword,$keyword_type,$country){  

	global $db;
	global $result_per_page;
	
	$posting_filter = '';
	if($posting != ''){
		$posting_filter = ' and p.id ='.$posting;
	}
	
	$reg_date_filter = '';
	if(($date_start != '')&&($date_end != '')){
		$reg_date_filter = " and date(pe.datecreated) >='".$date_start."' and date(pe.datecreated) <= '".$date_end."'" ;
	}
	
	/*$update_date_filter = '';
	if(($updated_date_start != '')&&($updated_date_end != '')){
		$update_date_filter = " and date(pe.dateupdated) >='".$updated_date_start."' and date(pe.dateupdated) <= '".$updated_date_end."'" ;
	}*/
	$update_date_filter = '';
	if(($updated_date_start != '')&&($updated_date_end != '')){
		$update_date_filter = " and date(utd.date) >='".$updated_date_start."' and date(utd.date) <= '".$updated_date_end."'" ;
	}
	
	$recruiter_filter = '';
	if($recruiter != ''){
		$recruiter_filter = " and rs.admin_id=".$recruiter;
	}
	
	$country_filter = '';
	if($country != ''){
		$country_filter = " and pe.permanent_residence='".$country."'";
	}
	
	if(($keyword != NULL)&&($keyword_type != NULL)){
	
		if($keyword_type == 'id'){
			if(strpos($keyword,',')){
				$userids = explode(',',$keyword);
				
				$keyword_filter = ' and (';
				$count = 1;
				foreach($userids as $userid){
					$keyword_filter .= " pe.userid='".trim($userid)."' ";
					if($count < count($userids)){
						$keyword_filter .= " or ";
					}
					$count++;
				}
				$keyword_filter .= " )";
			}
			else{
				$keyword_filter = " and pe.userid='".$keyword."' ";  
			}
		}
		
		if($keyword_type == 'first_name'){
			$keyword_filter = " and pe.fname like '%".$keyword."%' ";
		}
		
		if($keyword_type == 'last_name'){
			$keyword_filter = " and pe.lname like '%".$keyword."%' ";
		}
		
		if($keyword_type == 'email'){
			$keyword_filter = " and pe.email like '%".$keyword."%' ";
		}
		
		if($keyword_type == 'resume_body'){
			$keyword_filter =  " and c.latest_job_title LIKE '%".$keyword."%'";
		}
		
		if($keyword_type == 'evaluation_notes'){		  

			$select_enotes = "SELECT distinct userid
				FROM evaluation_comments
				where comments like '%".$keyword."%'";
			$enotes = $db->fetchAll($select_enotes);
			
			$enotes_user = array();
			foreach($enotes as $enote){
				$enotes_user[] = $enote['userid'];
			}
			
			$keyword_filter = " and pe.userid in ('".implode("','",$enotes_user)."') ";
		}
		
		if($keyword_type == 'skills'){

			$skill_filter = "";
			
			$skill_keywords = '';
			if(strpos($keyword,',')){
			
				$skill_keywords = array_filter(explode(',',strtolower($keyword)));
				$count = 1;
				foreach($skill_keywords as $skill_keyword){
					$skill_filter .= " '%".trim($skill_keyword)."' ";
					if($count < count($skill_keywords)){
						$skill_filter .= " or skill LIKE ";
					}
					$count++;
				}
				
			}else{
				$skill_filter = " '%".$keyword."' ";
			}
			
			$skill_select_1 = "SELECT userid
				FROM `skills_myisam`
				where skill LIKE ".$skill_filter;
			
			$skill_filter = "";
			if(strpos($keyword,',')){
				$skill_filter = "'";
				$skill_keywords = array_filter(explode(',',$keyword));
				$count = count($skill_keywords);
				foreach($skill_keywords as $skill_keyword){
					$skill_filter .= " +".trim($skill_keyword)." ";
				}
				$skill_filter.="'";
			}else{
				$skill_filter = " '+".$keyword."' ";
			}
			
			$skill_filter = trim($skill_filter);
			$skill_select_2 = "SELECT userid
				FROM `skills_myisam` WHERE MATCH(skill) AGAINST($skill_filter IN BOOLEAN MODE)";
			
			$skill_select = $skill_select_1." UNION ".$skill_select_2;
			
			
			//echo $skill_select;
			$skill_rows = $db->fetchAll($skill_select); 
			
			
			$skill_user = array();
			foreach($skill_rows as $skill_row){
				$skill_user[] = $skill_row['userid'];
			}
			
			$keyword_filter = " and pe.userid in ('".implode("','",$skill_user)."')  AND (SELECT COUNT(*) FROM skills s WHERE s.userid = pe.userid) > 0 ";
			
		}
		
		if($keyword_type == 'notes'){
						
			$notes_select = "SELECT userid
				FROM applicant_history
				where actions='NOTES'
				and history like '%".$keyword."%'";
			$notes_rows = $db->fetchAll($notes_select); 
			
			$notes_user = array();
			foreach($notes_rows as $notes_row){
				$notes_user[] = $notes_row['userid'];
			}
			
			$keyword_filter = " and pe.userid in ('".implode("','",$notes_user)."') ";
		}
	}
	
	$select_start = '';
	if( $posting != ''){
		$select_start = 'select SQL_CALC_FOUND_ROWS a.userid,p.id,a.status,c.latest_job_title,ad.admin_fname,ad.admin_lname,
			pe.userid, pe.userid AS the_user, pe.external_source, pe.referred_by, pe.fname,pe.lname,pe.email,pe.voice_path,pe.skype_id,pe.yahoo_id,pe.datecreated,pe.dateupdated,pe.permanent_residence
			from posting as p
			left join applicants as a on p.id=a.posting_id
			left join personal as pe on a.userid=pe.userid
			left join currentjob as c on a.userid=c.userid ';
	}
	else{
		$select_start = 'select SQL_CALC_FOUND_ROWS c.latest_job_title,ad.admin_fname,ad.admin_lname,
			pe.userid,pe.fname,pe.lname,pe.email,pe.external_source, pe.referred_by,pe.voice_path,pe.skype_id,pe.yahoo_id,pe.datecreated,pe.dateupdated,pe.permanent_residence
			from personal as pe 
			left join currentjob as c on pe.userid=c.userid ';
	}
	
	$pageStart = ($page-1)*$result_per_page;
	$pageEnd = $pageStart+$result_per_page;
	if (isset($_GET["order_by_export"])){
		$order = $_GET["order_by_export"];		
	}else{
		$order = "DESC";
	}
	
	$select = "
		".$select_start."
		left join recruiter_staff as rs on pe.userid=rs.userid
		left join admin as ad on rs.admin_id=ad.admin_id
		left join staff_resume_up_to_date as utd on pe.userid=utd.userid
		
		where pe.fname <> '' AND pe.lname <> ''  
		".$posting_filter.$reg_date_filter.$update_date_filter.$recruiter_filter.$keyword_filter.$country_filter."
		group by pe.userid 
		order by pe.datecreated $order  
		";
	$limitBy = $_GET["limitby"];
	if ($limitBy=="limitby"){
		$limit = $_GET["limit"];
		$select.=" limit $limit";
		//echo $select;
		$results = $db->fetchAll($select); 
		$total = $db->fetchOne('select FOUND_ROWS()');
		
	}else{
		//echo $select;
		$select.=" limit 10000";
		$results = $db->fetchAll($select); 
		$total = $db->fetchOne('select FOUND_ROWS()');
	}
	
	
	//return $results;
	return array('applicants'=>$results,'total'=>$total);
}
$posting = $_GET['posting'];
$searched = $_GET["searched"];
$page = $_GET['page'];
if($page == ''){
	$page = 1;
}
$date_start = $_GET['date_start']; 
$date_end = $_GET['date_end'];
$date_from = $date_start;
$date_to = $date_end;

$updated_date_start = $_GET['updated_date_start'];
$updated_date_end = $_GET['updated_date_end'];
$recruiter = $_GET['recruiter'];
$keyword = $_GET['keyword'];
$keyword_type = $_GET['keyword_type'];
$country = $_GET['country'];
$result_per_page = $_GET['result_per_page'];


if($result_per_page == ''){
	$result_per_page = 100;
}
$result = getApplicants($posting,$page,$date_start,$date_end,$updated_date_start,$updated_date_end,$recruiter,$keyword,$keyword_type,$country);

if (!isset($_GET["checked"])){
//echo $sql->__toString();
	$seekers = $result["applicants"];
	$csv = "User ID,First Name,Last Name,External Source,Referred By,Register Date,Birth Date,Age\n";
	foreach($seekers as $seeker){
	    
        //check referral
        $referral = $db->fetchRow($db->select()->from(array("r"=>"referrals"), array())->joinInner(array("p"=>"personal"), "p.userid = r.user_id", array("p.fname AS referee_fname", "p.lname AS referee_lname", "p.userid AS referee_userid"))->where("r.jobseeker_id = ?", $seeker["userid"]));
        if ($referral){
            $seeker["referred_by"] = $referral["referee_fname"]." ".$referral["referee_lname"];
        }
        
	    $pers = $db->fetchRow($db->select()->from("personal")->where("userid = ?",$seeker["userid"]));
        $byear = $pers["byear"];
        $bmonth = $pers["bmonth"];
        $bday = $pers["bday"];if ($byear&&$bmonth&&$bday){
            $diff = abs(strtotime(date("Y-m-d"))-strtotime(date("Y-m-d", strtotime($byear."-".$bmonth."-".$bday))));
            $years = floor($diff / (365*60*60*24));
        }else{
            $years = 0;
        }
        $birthday =date("Y-m-d", strtotime($byear."-".$bmonth."-".$bday));
        
		$csv.="\"{$seeker["userid"]}\",\"".$seeker["fname"]."\",\"".$seeker["lname"]."\",\"".$seeker["external_source"]."\",\"".$seeker["referred_by"]."\",=\"".date("Y-m-d", strtotime($seeker["datecreated"]))."\",=\"{$birthday}\",\"{$years}\"\n";
	}
	
	if ($date_from&&$date_to){
    	$fp = fopen("personal-".$date_from."-".$date_to.".csv", "w");
        fwrite($fp, $csv);
        fclose($fp);
        
        output_file("personal-".$date_from."-".$date_to.".csv", "personal-".$date_from."-".$date_to.".csv");
        unlink("personal-".$date_from."-".$date_to.".csv");    
	}else{
	    $fp = fopen("personal.csv", "w");
        fwrite($fp, $csv);
        fclose($fp);
        
        output_file("personal.csv", "personal.csv");
        unlink("personal.csv");
	}
	
}else{
	echo json_encode(array("exceed"=>$result["total"]>10000, "notallowed"=>false));
}