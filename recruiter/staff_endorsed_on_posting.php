<?php
include_once '../conf/zend_smarty_conf.php';
$posting_id = $_GET["posting_id"];
$type = $_GET["type"];
if (!$posting_id){
	die("Posting Id is required");
}
if (!$type){
	die("Type is required");
}
$sql = null;
if ($type=="unprocessed"){
	$sql = $db->select()->distinct()
		->from(array("u"=>"unprocessed_staff"), array("u.date AS date"))
		->joinInner(array("app"=>"applicants"),"app.userid = u.userid",  array())
		->joinInner(array("pers"=>"personal"), "pers.userid = u.userid", array("u.userid", "fname", "lname"))
		->where("app.posting_id = ?", $posting_id)
		->order("date DESC");
}else if ($type=="prescreened"){
	$sql = $db->select()->distinct()
			->from(array("pres"=>"pre_screened_staff"), array("pres.date AS date"))
			->joinInner(array("app"=>"applicants"),"app.userid = pres.userid",  array())
			->joinInner(array("pers"=>"personal"), "pers.userid = pres.userid", array("pres.userid", "fname", "lname"))
			->where("app.posting_id = ?", $posting_id)
			->order("date DESC");
}else if ($type == "inactive"){
	$sql = $db->select()->distinct()
			->from(array("ina"=>"inactive_staff"), array("ina.date AS date"))
			->joinInner(array("app"=>"applicants"),"app.userid = ina.userid",  array())
			->joinInner(array("pers"=>"personal"), "pers.userid = ina.userid", array("ina.userid", "fname", "lname"))
			->where("app.posting_id = ?", $posting_id)
			->order("date DESC");
}else if ($type=="endorsement"){
	$sql = $db->select()->distinct()
			->from(array("end"=>"tb_endorsement_history"), array("end.date_endoesed AS date"))
			->joinInner(array("pers"=>"personal"), "pers.userid = end.userid", array("end.userid", "fname", "lname"))
			->where("end.position = ?", $posting_id)
			->order("date DESC");
}else if ($type=="shortlist"){
	$sql = $db->select()->distinct()
			->from(array("sh"=>"tb_shortlist_history"), array("sh.date_listed AS date"))
			->joinInner(array("pers"=>"personal"), "pers.userid = sh.userid", array("sh.userid", "fname", "lname"))
			->where("sh.position = ?", $posting_id)
			->order("date DESC");
}else if ($type=="asl"){
	$sql = $db->select()->distinct()
			->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.sub_category_applicants_date_created AS date"))
			->joinInner(array("app"=>"applicants"),"app.userid = jsca.userid",  array())
			->joinInner(array("pers"=>"personal"), "pers.userid = jsca.userid", array("jsca.userid", "fname", "lname"))
			->where("app.posting_id = ?", $posting_id)
			->where("jsca.ratings = 0")
			->order("date DESC");
	
}

if ($sql!=null){
	$applicants = $db->fetchAll($sql);
	
	$smarty = new Smarty();
	$output = "";
	
	if ($type=="unprocessed"){
		$header = "Date Unprocessed";
	}else if ($type=="prescreened"){
		$header = "Date Pre-Screened";
	}else if ($type=="inactive"){
		$header = "Inactive Date";
	}else if ($type=="shortlist"){
		$header = "Date Shortlisted";
	}else if ($type=="endorsement"){
		$header = "Date Endorsed";
	}else if ($type=="asl"){
		$header = "Date Added on ASL";
	}
	$output = "";
	if (!empty($applicants)){
		$i = 1;
		foreach($applicants as $applicant){
			$link = "<a href='/portal/recruiter/staff_information.php?userid={$applicant["userid"]}&page_type=popup' target='_blank'>{$applicant["fname"]} {$applicant["lname"]}</a>";
			ob_start();
			?>
			<tr>
				<td width="5%" align="left" valign="top" class="td_info td_la"><?php echo $i?></td>
				<td width="75%" align="left" valign="top" class="td_info td_la"><?php echo $link?></td>
				<td width="20%" align="center" valign="top" class="td_info td_la"><?php echo date("Y-m-d", strtotime($applicant["date"]))?></td>
			</tr>
			<?php 
			$content = ob_get_clean();
			ob_end_flush();
			$output.=$content;
			$i++;
		}
	}
	$smarty->assign("header", $header);
	$smarty->assign("output", $output);
	$smarty->display("staff_endorsed_on_posting.tpl");
}else{
	die("Invalid Parameter");
}