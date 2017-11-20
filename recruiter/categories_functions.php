<?
function getCategories($category = null){  

	global $db;
	
	$category_filter = '';
	if($category != null){
		$category_filter = 'and  category_id = '.$category;
	}
	
	$select="SELECT category_id, category_name FROM job_category 
		WHERE 1 ".$category_filter." AND (status = 'posted' OR category_id=60)  
		ORDER BY category_name";
    $rows = $db->fetchAll($select);  

	$categories = array();
	foreach($rows as $row){
		$category = array();
		$category['category']['id'] = $row['category_id'];
		$category['category']['name'] = $row['category_name'];
		$categories[] = $category;
	}
	return $categories;
}

function getSubCategories($category_id){  

	global $db;
	if ($category_id=="60"){
		$select = "SELECT sub_category_id, sub_category_name 
		FROM job_sub_category 
		WHERE category_id='".$category_id."' AND status = 'posted' 
		ORDER BY sub_category_name";
	}else{
		$select = "SELECT sub_category_id, sub_category_name 
				FROM job_sub_category 
				WHERE category_id='".$category_id."' 
				ORDER BY sub_category_name";		
	}

    $rows = $db->fetchAll($select);  
	
	$subcategories = array();
	foreach($rows as $row){
		$subcategories[$row['sub_category_id']]['category_name'] = $row['sub_category_name'];
	}
	return $subcategories;
}

function getUniqueResumes($date_start,$date_end,$keyword,$keyword_type,$recruiter,$on_asl,$adv_rate){
	
	global $db;
	
	$availability_filter = "";
	
	$available_status = $_GET["available_status"];
	if (isset($available_status)){
		$availability_filter="cj.available_status = '".addslashes($available_status)."'";
		if ($available_status=="a"){
			$available_notice = $_GET["available_notice"];
			if (isset($available_notice)&&$available_notice!=""){
				$availability_filter.=" AND cj.available_notice = '{$available_notice}'";	
			}
		}else if ($available_status=="b"){
			$available_date = $_GET["available_date"];
			if (isset($available_date)&&$available_date!=""){		
				$availability_filter.=" AND STR_TO_DATE(CONCAT(cj.amonth, ' ', cj.aday, ', ', cj.ayear), '%M %d, %Y') = DATE('{$available_date}')";	
			}
		}
	}
	
	
	$keyword_filter = "";
	$keyword_filter_count = "";
	if(($keyword != NULL)&&($keyword_type != NULL)){
	
		if($keyword_type == 'id'){
			if(strpos($keyword,',')){
				$userids = explode(',',$keyword);
				
				$keyword_filter = ' and (';
				$count = 1;
				foreach($userids as $userid){
					$keyword_filter .= "p.userid='".trim($userid)."' ";
					if($count < count($userids)){
						$keyword_filter .= " or ";
					}
					$count++;
				}
				$keyword_filter .= ")";
				if (!empty($userids)){
					$keyword_filter_count = "p.userid IN (".implode(",", $userids).")";	
				}
				
			}
			else{
				$keyword_filter = "and p.userid='".$keyword."' ";
				$keyword_filter_count = "p.userid = '{$keyword}'";
				
			}
		}
		
		if($keyword_type == 'first_name'){
			$keyword_filter = " and p.fname LIKE '".$keyword."%' ";
			$keyword_filter_count = "p.fname LIKE '".$keyword."%' ";
		}
		
		if($keyword_type == 'last_name'){
			$keyword_filter = "and p.lname LIKE '".$keyword."%' ";
			$keyword_filter_count = "p.lname LIKE '".$keyword."%' ";
		}
		
		if($keyword_type == 'email'){
			$keyword_filter = "and p.email LIKE '".$keyword."%' ";
			$keyword_filter_count = "p.email LIKE '".$keyword."%' ";
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
			
			$keyword_filter = " and p.userid in ('".implode("','",$enotes_user)."') ";
			$keyword_filter_count = "p.userid in ('".implode("','",$enotes_user)."') ";
			
		}
		
		if($keyword_type == 'skills'){
						
			$skill_select = "SELECT userid
				FROM `skills`
				where skill like '%".$keyword."%'";
			$skill_rows = $db->fetchAll($skill_select); 
			
			$skill_user = array();
			foreach($skill_rows as $skill_row){
				$skill_user[] = $skill_row['userid'];
			}
			
			$keyword_filter = " and p.userid in ('".implode("','",$skill_user)."') ";
			$keyword_filter_count = "p.userid in ('".implode("','",$skill_user)."') ";
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
			
			$keyword_filter = " and p.userid in ('".implode("','",$notes_user)."') ";
			$keyword_filter_count = "p.userid in ('".implode("','",$notes_user)."') ";
		}
	}
	
	$recruiter_filter = '';
	$recruiter_filter_count = "";
	if($recruiter != ''){
		$recruiter_filter = ' and rs.admin_id ='.$recruiter;
		$recruiter_filter_count = "rs.admin_id = ".$recruiter;
	}
	
	$on_asl_filter = '';
	$on_asl_filter_count = "";
	if($on_asl != ''){
		if ($on_asl==2){
			$on_asl_filter = " and ratings = 0 AND under_consideration = 1";
			$on_asl_filter_count = "ratings = 0 AND under_consideration = 1";
		}else{
			$on_asl_filter = ' and ratings ='.$on_asl." AND (under_consideration = 0 OR under_consideration IS NULL)";
			$on_asl_filter_count = 'ratings ='.$on_asl." AND (under_consideration = 0 OR under_consideration IS NULL)";
		}
	
	}
	
	$inactive_filter = "";
	$inactive_filter_count = "";
	if (isset($_GET["inactive"])&&$_GET["inactive"]!=""){
		$inactive_filter.=" AND ina.type = '".addslashes($_GET["inactive"])."' ";
		$inactive_filter_count ="ina.type = '".addslashes($_GET["inactive"])."'";
	}else{
		$inactive_filter.=" AND ina.type IS NULL ";
		$inactive_filter_count = "ina.type IS NULL";
	}
	
	
	
		$selectCount = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array(new Zend_Db_Expr("COUNT(jsca.userid) AS count")))
						->joinInner(array("p"=>"personal"), "jsca.userid=p.userid", array())
						->joinLeft(array("st"=>"staff_timezone"), "p.userid=st.userid", array())
						->joinLeft(array("e"=>"evaluation"), "jsca.userid=e.userid", array())
						->joinLeft(array("rs"=>"recruiter_staff"), "jsca.userid=rs.userid", array())
						->joinLeft(array("ad"=>"admin"), "rs.admin_id=ad.admin_id", array())
						->joinLeft(array("cj"=>"currentjob"), "jsca.userid=cj.userid", array())
						->joinLeft(array("ina"=>"inactive_staff"), "jsca.userid = ina.userid", array())
						
						//->where("jsca.sub_category_id = ?", $subcategory_id)
						->group("jsca.userid");
					
		if ($keyword_filter_count!=""){
			$selectCount->where($keyword_filter_count);
		}
		if ($recruiter_filter_count!=""){
			$selectCount->where($recruiter_filter_count);
		}
		if ($inactive_filter_count!=""){
			$selectCount->where($inactive_filter_count);
		}
		if ($on_asl_filter_count!=""){
			$selectCount->having($on_asl_filter_count);
		}
		if ($availability_filter!=""){
			$selectCount->where($availability_filter);
		}
		
		
	if(($date_start != NULL)&&($date_end != NULL)){
		$selectCount->where("DATE(jsca.sub_category_applicants_date_created) >= DATE('{$date_start}') AND DATE(jsca.sub_category_applicants_date_created) <= DATE('{$date_end}')");
		
	}
	
	if (isset($_GET["date_updated_start"])&&isset($_GET["date_updated_end"])&&$_GET["date_updated_start"]!=""&&$_GET["date_updated_end"]!=""){
		$selectCount->where("DATE(p.dateupdated) >= DATE('{$_GET["date_updated_start"]}') AND DATE(p.dateupdated) <= DATE('{$_GET["date_updated_end"]}')");		
	}
	if (isset($_GET["date_registered_start"])&&isset($_GET["date_registered_end"])&&$_GET["date_registered_start"]!=""&&$_GET["date_registered_end"]!=""){
		$selectCount->where("DATE(p.datecreated) >= DATE('{$_GET["date_registered_start"]}') AND DATE(p.datecreated) <= DATE('{$_GET["date_registered_end"]}')");		
	}
	
	
	$rowsCount = $db->fetchAll($selectCount);
	
	
	return count($rowsCount);
}



function getApplicants($subcategory_id,$date_start,$date_end,$keyword,$keyword_type,$recruiter,$on_asl,$adv_rate){

	global $db;
	$availability_filter = "";
	
	$available_status = $_GET["available_status"];
	if (isset($available_status)){
		$availability_filter=" AND cj.available_status = '".addslashes($available_status)."'";
		if ($available_status=="a"){
			$available_notice = $_GET["available_notice"];
			if (isset($available_notice)&&$available_notice!=""){
				$availability_filter.=" AND cj.available_notice = '{$available_notice}'";	
			}
		}else if ($available_status=="b"){
			$available_date = $_GET["available_date"];
			if (isset($available_date)&&$available_date!=""){		
				$availability_filter.=" AND STR_TO_DATE(CONCAT(cj.amonth, ' ', cj.aday, ', ', cj.ayear), '%M %d, %Y') = DATE('{$available_date}')";	
			}
		}
	}
	$keyword_filter = "";
	$keyword_filter_count = "";
	if(($keyword != NULL)&&($keyword_type != NULL)){
	
		if($keyword_type == 'id'){
			if(strpos($keyword,',')){
				$userids = explode(',',$keyword);
				
				$keyword_filter = ' and (';
				$count = 1;
				foreach($userids as $userid){
					$keyword_filter .= "p.userid='".trim($userid)."' ";
					if($count < count($userids)){
						$keyword_filter .= " or ";
					}
					$count++;
				}
				$keyword_filter .= ")";
				
				
			}
			else{
				$keyword_filter = "and p.userid='".$keyword."' ";
				
			}
		}
		
		if($keyword_type == 'first_name'){
			$keyword_filter = " and p.fname LIKE '".$keyword."%' ";
		}
		
		if($keyword_type == 'last_name'){
			$keyword_filter = "and p.lname LIKE '".$keyword."%' ";
		}
		
		if($keyword_type == 'email'){
			$keyword_filter = "and p.email LIKE '".$keyword."%' ";
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
			
			$keyword_filter = " and p.userid in ('".implode("','",$enotes_user)."') ";
			
		}
		
		if($keyword_type == 'skills'){
						
			$skill_select = "SELECT userid
				FROM `skills`
				where skill like '%".$keyword."%'";
			$skill_rows = $db->fetchAll($skill_select); 
			
			$skill_user = array();
			foreach($skill_rows as $skill_row){
				$skill_user[] = $skill_row['userid'];
			}
			
			$keyword_filter = " and p.userid in ('".implode("','",$skill_user)."') ";
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
			
			$keyword_filter = " and p.userid in ('".implode("','",$notes_user)."') ";
		}
	}
	
	$recruiter_filter = '';
	$recruiter_filter_count = "";
	if($recruiter != ''){
		$recruiter_filter = ' and rs.admin_id ='.$recruiter;
	}
	
	$on_asl_filter = '';
	$on_asl_filter_count = "";
	if($on_asl != ''){
		if ($on_asl==2){
			$on_asl_filter = " and ratings = 0 AND under_consideration = 1";
		}else{
			$on_asl_filter = ' and ratings ='.$on_asl." AND (under_consideration = 0 OR under_consideration IS NULL)";
		}
	
	}
	
	$inactive_filter = "";
	$inactive_filter_count = "";
	if (isset($_GET["inactive"])&&$_GET["inactive"]!=""){
		$inactive_filter.=" AND ina.type = '".addslashes($_GET["inactive"])."' ";
	}else{
		//$inactive_filter.=" AND ina.type IS NULL ";
	}
	
	$work_status_filter = "";
	if (isset($_GET["work_availability"])&&$_GET["work_availability"]){
		if ($_GET["work_availability"]=="Full-Time/Part-Time"){
			$work_status_filter .= " AND (e.work_fulltime = 'yes' AND e.work_parttime = 'yes')";			
		}else if ($_GET["work_availability"]=="Full-Time"){
			$work_status_filter .= " AND e.work_fulltime = 'yes' AND e.work_parttime = 'no'";			
		}else if ($_GET["work_availability"]=="Part-Time"){
			$work_status_filter .= " AND e.work_fulltime = 'no' AND e.work_parttime = 'yes'";
		}
	}
	
	
	$time_availability_filter = "";
	
	if (isset($_GET["time_availability"])&&$_GET["time_availability"]){
		if ($_GET["work_availability"]=="Full-Time/Part-Time"){
			if ($_GET["time_availability"]=="Any"){
				$time_availability_filter = " AND st.time_zone IN ('AU', 'US', 'UK')";
			}else{
				$time_availability_filter = " AND st.time_zone = '".addslashes($_GET["time_availability"])."'";
			}
		}else if ($_GET["work_availability"]=="Full-Time"){
			if ($_GET["time_availability"]=="Any"){
				$time_availability_filter = " AND st.time_zone IN ('AU', 'US', 'UK') AND st.type='full_time'";
			}else{
				$time_availability_filter = " AND st.time_zone = '".addslashes($_GET["time_availability"])."' AND st.type='full_time'";
			}
		}else if ($_GET["work_availability"]=="Part-Time"){
			if ($_GET["time_availability"]=="Any"){
				$time_availability_filter = " AND st.time_zone IN ('AU', 'US', 'UK') AND st.type='part_time'";
			}else{
				$time_availability_filter = " AND st.time_zone = '".addslashes($_GET["time_availability"])."' AND st.type='part_time'";
			}
		}else{
			if ($_GET["time_availability"]=="Any"){
				$time_availability_filter = " AND st.time_zone IN ('AU', 'US', 'UK')";
			}else{
				$time_availability_filter = " AND st.time_zone = '".addslashes($_GET["time_availability"])."'";
			}
		}
	}
	
	$city_filter = "";
	if (isset($_GET["city"])&&$_GET["city"]){
		$city_filter = " AND p.city LIKE '%".addslashes($_GET["city"])."%'";
	}
	
	$region_filter = "";
	if (isset($_GET["region"])&&$_GET["region"]){
		$region_filter = " AND p.state LIKE '%".addslashes($_GET["region"])."%'";
	}
	
	$gender_filter = "";
	if (isset($_GET["gender"])&&$_GET["gender"]){
		$gender_filter = " AND p.gender = '".addslashes($_GET["gender"])."'";
	}
	
	$marital_status_filter = "";
	if (isset($_GET["marital_status"])&&$_GET["marital_status"]){
		$marital_status_filter = " AND p.marital_status = '".addslashes($_GET["marital_status"])."'";
	}
	
		$select = "SELECT jsca.sub_category_id,jsca.userid,ratings,jsca.under_consideration, p.lname,p.fname,p.email,p.permanent_residence,e.work_fulltime,e.work_parttime, 
		ad.admin_fname,ad.admin_lname,cj.latest_job_title
		FROM job_sub_category_applicants as jsca
		left join personal as p on jsca.userid=p.userid 
		right join staff_selected_timezones as st on p.userid=st.userid 
		left join evaluation as e on jsca.userid=e.userid
		left join recruiter_staff as rs on jsca.userid=rs.userid
		left join admin as ad on rs.admin_id=ad.admin_id
		left join currentjob as cj on jsca.userid=cj.userid 
		left join inactive_staff as ina on jsca.userid = ina.userid 
		where sub_category_id = '".$subcategory_id."' ".$keyword_filter." ".$recruiter_filter." ".$on_asl_filter." ".$inactive_filter." ".$availability_filter." ".$work_status_filter." ".$time_availability_filter." ".$city_filter." ".$region_filter." ".$gender_filter." ".$marital_status_filter;
		
		
	if(($date_start != NULL)&&($date_end != NULL)){
		$select .= " AND DATE(jsca.sub_category_applicants_date_created) >= '".$date_start."' 
			AND DATE(jsca.sub_category_applicants_date_created) <= '".$date_end."'";
		
	}
	if (isset($_GET["date_updated_start"])&&isset($_GET["date_updated_end"])&&$_GET["date_updated_start"]!=""&&$_GET["date_updated_end"]!=""){
		$select .= " AND (DATE(p.dateupdated) >= DATE('".$_GET["date_updated_start"]."') AND DATE(p.dateupdated) <= DATE('".$_GET["date_updated_end"]."'))";
		
	}
	if (isset($_GET["date_registered_start"])&&isset($_GET["date_registered_end"])&&$_GET["date_registered_start"]!=""&&$_GET["date_registered_end"]!=""){
		$select .= " AND (DATE(p.datecreated) >= DATE('".$_GET["date_registered_start"]."') AND DATE(p.datecreated) <= DATE('".$_GET["date_registered_end"]."'))";
		
	}
	
	$select .= " GROUP BY p.userid";
    $rows = $db->fetchAll($select);  
	
	$applicants = array();
	foreach($rows as $row){
	
		if($row['ratings'] == 1){
			$applicants[$row['userid']]['ratings'] = 'No';
		}
		else{
			if ($row["under_consideration"]){
				$applicants[$row['userid']]['ratings'] = "<font color='#ff0000'>Yes, under consideration</font>";
			}else{		
				
				$applicants[$row['userid']]['ratings'] = 'Yes';	
			}
		}
		
		$applicants[$row['userid']]['fname'] = $row['fname'];
		$applicants[$row['userid']]['lname'] = $row['lname'];
		$applicants[$row['userid']]['email'] = $row['email'];
		$applicants[$row['userid']]['recruiter'] = $row['admin_fname'].' '.$row['admin_lname'];
		$applicants[$row['userid']]['current_job'] = $row['latest_job_title'];

		$select = "SELECT count(*)
			FROM tb_shortlist_history
			WHERE userid = ".$row['userid'];
		$applicants[$row['userid']]['shortlisted'] = $db->fetchOne($select); 
		
		$applicants[$row['userid']]['availability_fulltime'] = $row['work_fulltime'];
		$applicants[$row['userid']]['availability_parttime'] = $row['work_parttime'];
		
		if(($row['work_fulltime'] == 'yes')&&($row['work_parttime'] == 'yes')){
			$applicants[$row['userid']]['availability'] = 'Full/Part Time';
		}
		else{
			if($row['work_fulltime'] == 'yes'){
				$applicants[$row['userid']]['availability'] = 'Full Time';
			}
			else{
				$applicants[$row['userid']]['availability'] = 'Part Time';
			}
		}
		
		$applicants[$row['userid']]['part_time_rate']['AU'] = getPartTimeRate($row['userid'],3,$adv_rate);
		$applicants[$row['userid']]['full_time_rate']['AU'] = getFullTimeRate($row['userid'],3,$adv_rate);
		$applicants[$row['userid']]['part_time_rate']['GBP'] = getPartTimeRate($row['userid'],4,$adv_rate);
		$applicants[$row['userid']]['full_time_rate']['GBP'] = getFullTimeRate($row['userid'],4,$adv_rate);
		$applicants[$row['userid']]['part_time_rate']['USD'] = getPartTimeRate($row['userid'],5,$adv_rate);
		$applicants[$row['userid']]['full_time_rate']['USD'] = getFullTimeRate($row['userid'],5,$adv_rate);	
		
		if($row['permanent_residence'] == 'IN'){
			$applicants[$row['userid']]['part_time_rate']['IN'] = getRateIN($row['userid'],$adv_rate,'PT');
			$applicants[$row['userid']]['full_time_rate']['IN'] = getRateIN($row['userid'],$adv_rate,'FT');
		}
		
		if($row['permanent_residence'] == 'PH'){
			$applicants[$row['userid']]['part_time_rate']['PH'] = getRateIN($row['userid'],$adv_rate,'PT');
			$applicants[$row['userid']]['full_time_rate']['PH'] = getRateIN($row['userid'],$adv_rate,'FT');
		}
		
		
		//fulltime timezone
		$fulltime_timezones = $db->fetchAll($db->select()->from("staff_selected_timezones")->where("userid = ?", $row['userid'])->where("type = ?", "full_time"));
		$parttime_timezones = $db->fetchAll($db->select()->from("staff_selected_timezones")->where("userid = ?", $row['userid'])->where("type = ?", "part_time"));
		
		$applicants[$row['userid']]['time_zone'] = "";
		if (!empty($fulltime_timezones)){
			$selected_timezones = array();
			foreach($fulltime_timezones as $fulltime_timezone){
				$selected_timezones[] = $fulltime_timezone["time_zone"];
			}
			$applicants[$row['userid']]['time_zone'] .= 'Full Time: '.implode(", ", $selected_timezones)."<br/>";	
			
		}
		if (!empty($parttime_timezones)){
			$selected_timezones = array();
			foreach($parttime_timezones as $parttime_timezone){
				$selected_timezones[] = $parttime_timezone["time_zone"];
			}
			$applicants[$row['userid']]['time_zone'] .= 'Part Time: '.implode(", ", $selected_timezones);	
			
		}
	
		
		$select2 = "SELECT skill FROM skills where userid='".$row['userid']."'";
		$rows2 = $db->fetchAll($select2); 
		
		$applicants[$row['userid']]['skills'] = array();
		foreach($rows2 as $row2){
			$skill = $row2['skill'];
			$applicants[$row['userid']]['skills'][] = $skill;
		}
		
		$select3 = "SELECT count( * )
			FROM tb_endorsement_history
			WHERE userid = ".$row['userid'];
		$applicants[$row['userid']]['endorsement_num'] = $db->fetchOne($select3);
		
		
		$select4 = "select sc.leads_id as lead_id,l.lname,l.fname,sc.status,starting_date as cdate, date(sc.resignation_date) as resig_date,date(date_terminated) as term_date
			FROM subcontractors as sc
			JOIN leads as l on sc.leads_id= l.id
			WHERE userid = ".$row['userid'];
		$rs_employment_history = $db->fetchAll($select4);
		
		$applicants[$row['userid']]['rs_employment_history'] = array();
		foreach($rs_employment_history as $row4){
			$employment['lead_id'] = $row4['lead_id']; 
			$employment['client'] = $row4['fname'].' '.$row4['lname'];
			$employment['status'] = 'Started '.$row4['cdate'].'<br>';
			if($row4['status']=='resigned'){
				$employment['status'] .= $row4['status'].' '.$row4['resig_date'];
			}
			if($row4['status']=='terminated'){
				$employment['status'] .= $row4['status'].' '.$row4['term_date'];
			}
			$applicants[$row['userid']]['rs_employment_history'][] = $employment;
		}
		
		
	}
	$result["applicants"] = $applicants;
	return $result;
}

function getPartTimeRate($userid,$currency_id,$adv_rate){	
	
	global $db;
	$select="SELECT p.amount 
		FROM staff_rate s, product_price_history p 
		WHERE p.currency_id='$currency_id' AND s.userid='$userid' 
		AND s.part_time_product_id=p.product_id 
		ORDER BY p.date DESC 
		LIMIT 1";
	$row = $db->fetchRow($select); 
	
	$part_time_r = $row['amount'];
    $yearly = $part_time_r * 12;
    $weekly = $yearly / 52;
    $daily = $weekly / 5;
    $part_time_h = $daily / 4;
    $part_time_h = round($part_time_h, 2); 

	if($adv_rate == 'monthly'){
		$result = $part_time_r;
	}
	else{
		$result = $part_time_h;
	}
	
	return $result;
}

function getFullTimeRate($userid,$currency_id,$adv_rate){	
	
	global $db;
	$select="SELECT p.amount 
		FROM staff_rate s, product_price_history p 
		WHERE p.currency_id='$currency_id' AND s.userid='$userid' 
		AND s.product_id=p.product_id 
		ORDER BY p.date DESC 
		LIMIT 1";
	$row = $db->fetchRow($select); 
	
    $per_m = $row['amount'];
    $yearly = $per_m * 12;
    $weekly = $yearly / 52;
    $daily = $weekly / 5;
    $per_h = $daily / 8;
    $per_h = round($per_h, 2);
	
	if($adv_rate == 'monthly'){
		$result = $per_m;
	}
	else{
		$result = $per_h;
	}
	
	return $result;
}

function getRateIN($userid,$adv_rate,$availability){	
	
	global $db;
	
	if($availability == 'FT'){
		$column = 'product_id';
	}
	else{
		$column = 'part_time_product_id';
	}
	
	$select="SELECT p.code FROM `staff_rate` as s
		left join products as p on s.part_time_product_id=p.id 
		where s.userid=".$userid;
	$row = $db->fetchRow($select); 
	
    $per_m = str_replace(',','',str_replace('PHP-'.$availability.'-','',str_replace('INR-FT-','',$row['code'])));
    $yearly = $per_m * 12;
    $weekly = $yearly / 52;
    $daily = $weekly / 5;
    $per_h = $daily / 8;
    $per_h = round($per_h, 2);
	 
	if($adv_rate == 'monthly'){
		$result = $per_m;
	}
	else{
		$result = $per_h;
	}
	
	return $result;
}
?>