<?php

include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

$gs_job_titles_details_id = $_REQUEST['gs_job_titles_details_id'];
$jr_cat_id = $_REQUEST['jr_cat_id'];
$jr_list_id =$_REQUEST['jr_list_id'];
$gs_job_role_selection_id = $_REQUEST['gs_job_role_selection_id'];

//echo $gs_job_titles_details_id."<br>".$jr_cat_id."<br>".$jr_list_id ."<br>".$gs_job_role_selection_id;


//gs_job_titles_details_id, gs_job_role_selection_id, jr_list_id, selected_job_title, level, no_of_staff_needed, job_role_no, status, work_status, working_timezone, start_work, finish_work
$sql = "SELECT * FROM gs_job_titles_details  WHERE  gs_job_titles_details_id = $gs_job_titles_details_id;";
$results = $db->fetchRow($sql);
$job_titles = strtoupper($results['selected_job_title'] ." ".$results['level']." level");



//$query = "SELECT * FROM job_role_cat_list j WHERE jr_list_id = $jr_list_id;";
//$result = $db->fetchRow($query);


$category_id = $jr_cat_id;//$result['jr_cat_id'];
//Categories
//1 = Marketing
//2 = IT
//3 = Office
//4 = Others
//gs_job_titles_credentials_id, gs_job_titles_details_id, gs_job_role_selection_id, description, rating, box
$query = "SELECT * FROM gs_job_titles_credentials g WHERE gs_job_titles_details_id = $gs_job_titles_details_id;";	
$result = $db->fetchAll($query);

foreach ($result as $row){
	if($row['box'] == "campaign_type"){
		$campaign_type = $row['description'];
	}
	//if($row['box'] == "duties_responsibilites"){
	//	$duties_responsibilities = $row['description'];
	//}
	if($row['box'] == "other_skills"){
		$other_skills = $row['description'];
	}
	//if($row['box'] == "responsibilty"){
	//	$responsibilty = $row['description'];
	//}
	if($row['box'] == "comments"){
		$comments = $row['description'];
	}
	
	if($row['box'] == "call_type"){
		$call_type = $row['description'];
	}
	
	if($row['box'] == "q1"){
		$Q1 = $row['description'];
	}
	
	if($row['box'] == "q2"){
		$Q2 = $row['description'];
	}
	
	if($row['box'] == "q3"){
		$Q3 = $row['description'];
	}
	if($row['box'] == "q4"){
		$Q4 = $row['description'];
	}

	if($row['box'] == 'lead_generation'){
		$lead_generation = $row['description'];
	}
	if($row['box'] == 'telemarketer_hrs'){
		$telemarketer_hrs = $row['description'];
	}
	
	if($row['box'] == 'onshore'){
		$onshore = $row['description'];
	}
	if($row['box'] == 'staff_phone'){
		$staff_phone = $row['description'];
	}
	
	if($row['box'] == 'require_graphic'){
		$require_graphic = $row['description'];
	}
	
	
}

if($category_id == 1){ // MARKETING CATEGORY
	// Determine if Telemarkter , Marketing Asst. , Graphic Designer, Audio / Video Editing , Writer
	/*
	Telemarketer id's
	1 = AUD
	12 = USD
	23 = POUNDS
	*/
	//for Telemarketer
	if (in_array($jr_list_id, array(1, 12, 23 )) == true) {
		$call_type_flag = "true";
		
		$yes_no_array = array("YES","NO");
		for ($i = 0; $i < count($yes_no_array); $i++) {
			if($Q1 == $yes_no_array[$i])
			{
				$Q1_options .= "<option selected value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
			else
			{
				$Q1_options .= "<option value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
			
			if($Q2 == $yes_no_array[$i])
			{
				$Q2_options .= "<option selected value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
			else
			{
				$Q2_options .= "<option value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
			
			if($Q3 == $yes_no_array[$i])
			{
				$Q3_options .= "<option selected value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
			else
			{
				$Q3_options .= "<option value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}


		}	
		
		$Q4_array = array("SALE","APPOINTMENT SET","SURVEY","INFORMATION UPDATE");
		for ($i = 0; $i < count($Q4_array); $i++) {
			if($Q4 == $Q4_array[$i]){
				$Q4_options .= "<option selected value=\"$Q4_array[$i]\">$Q4_array[$i]</option>\n";
			}else{
				$Q4_options .= "<option value=\"$Q4_array[$i]\">$Q4_array[$i]</option>\n";
			}
		}
		
		$smarty->assign('Q1_options', $Q1_options);
		$smarty->assign('Q2_options', $Q2_options);
		$smarty->assign('Q3_options', $Q3_options);
		$smarty->assign('Q4_options', $Q4_options);
		$smarty->assign('lead_generation', $lead_generation);
		$smarty->assign('telemarketer_hrs', $telemarketer_hrs);
		
	}else{
		$call_type_flag = "false";
	}
	
	$campaign_type_Array=array("Business to Business","Business to Consumer","Both");  
	for ($i = 0; $i < count($campaign_type_Array); $i++) {
		if($campaign_type == $campaign_type_Array[$i])
		{
			$campaign_type_options .= "<option selected value=\"$campaign_type_Array[$i]\">$campaign_type_Array[$i]</option>\n";
		}
		else
		{
			$campaign_type_options .= "<option value=\"$campaign_type_Array[$i]\">$campaign_type_Array[$i]</option>\n";
		}
	}	
	$call_type_array = array("Inbound","Outbound","Both");
	for ($i = 0; $i < count($call_type_array); $i++) {
		if($call_type == $call_type_array[$i])
		{
			$call_type_options .= "<option selected value=\"$call_type_array[$i]\">$call_type_array[$i]</option>\n";
		}
		else
		{
			$call_type_options .= "<option value=\"$call_type_array[$i]\">$call_type_array[$i]</option>\n";
		}
	}
	
	
	
	//Writer id's 5 = AUD, 16 = USD, 27 = POUNDS
	if (in_array($jr_list_id, array(5, 16, 27 )) == true) {
		$writer_type_flag = "true";
		
		$writer_type_array =  array("Article Writer","SEO Writer","Technical / Manual Writer","Web Content Writer","Research Writer","Blogger");
		for ($i = 0; $i < count($writer_type_array); $i++) {
			$queries = "SELECT * FROM gs_job_titles_credentials g WHERE gs_job_titles_details_id = $gs_job_titles_details_id AND box = 'writer_type' AND description = '$writer_type_array[$i]';";	
			$resul = $db->fetchRow($queries);
			if($resul['gs_job_titles_credentials_id'] > 0)	{
				$writer_type_options .= "<input type=\"checkbox\" checked=\"checked\"  name=\"writer_type$gs_job_titles_details_id\" value=\"$writer_type_array[$i]\" /> $writer_type_array[$i] ";
			}else{
				$writer_type_options .= "<input type=\"checkbox\"  name=\"writer_type$gs_job_titles_details_id\" value=\"$writer_type_array[$i]\" /> $writer_type_array[$i] ";
			}

		}
		
	}else{
		$writer_type_flag = "false";
	}
	
	//for Marketing Asst. id's 2 = AUD ,13 = USD ,24 = POUNDS
	if (in_array($jr_list_id, array(2, 13, 24 )) == true) {
		$marketing_asst_flag = "true";
		$yes_no_array = array("YES","NO");
		for ($i = 0; $i < count($yes_no_array); $i++) {
			if($staff_phone == $yes_no_array[$i])
			{
				$staff_phone_options .= "<option selected value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
			else
			{
				$staff_phone_options .= "<option value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
		}		
		
		
	}else{
		$marketing_asst_flag = "false";
	}
	
	//For Graphic Designer
	if (in_array($jr_list_id, array(3, 13, 25 )) == true) {
		$graphic_des_flag = "true";
		$graphic_des_array = array("Photoshop","Corel Draw","Illustrator","Maya","Fireworks");
		for ($i = 0; $i < count($graphic_des_array); $i++) {
			$graphic_des_options .= "<option value=\"$graphic_des_array[$i]\">$graphic_des_array[$i]</option>\n";
		}		
	}else{
		$graphic_des_flag = "false";
	}
	
	$smarty->assign('graphic_des_flag', $graphic_des_flag);
	$smarty->assign('graphic_des_options', $graphic_des_options);
	
	$smarty->assign('marketing_asst_flag', $marketing_asst_flag);
	$smarty->assign('staff_phone_options', $staff_phone_options);
		
	$smarty->assign('writer_type_options', $writer_type_options);
	$smarty->assign('writer_type_flag', $writer_type_flag);
	$smarty->assign('call_type_flag', $call_type_flag);
	$smarty->assign('call_type_options', $call_type_options);

	
}

if($category_id == 2){ //IT CATEGORY
	$system_array = array("HTML","XHTML","ASP.Net","Classic ASP","VB.Net","PHP","JavaScript","Cascading Style Sheets (CSS)","IIS / Apache","Macromedia Flash","XML","AJAX","Macromedia Dreamweaver","Macromedia Fireworks","Coldfusion","ActionScript");
	for ($i = 0; $i < count($system_array); $i++) {
		$system_array_options .= "<option value=\"$system_array[$i]\">$system_array[$i]</option>\n";
	}
	
	$database_array = array("MS Access","SQL Server","MySQL");
	for ($i = 0; $i < count($database_array); $i++) {
		$database_array_options .= "<option value=\"$database_array[$i]\">$database_array[$i]</option>\n";
	}
	
	$app_programming_array = array("Visual Basic","Visual C# .net");
	for ($i = 0; $i < count($app_programming_array); $i++) {
		$app_programming_array_options .= "<option value=\"$app_programming_array[$i]\">$app_programming_array[$i]</option>\n";
	}	
	
	//open_source
	$open_source_array = array("Wordpress","Mambo / Joomla", "PHPBB2 or PHPBB3");
	for ($i = 0; $i < count($open_source_array); $i++) {
		$open_source_array_options .= "<option value=\"$open_source_array[$i]\">$open_source_array[$i]</option>\n";
	}	
	
	//pc_products
	$pc_products_array = array("Microsoft Office Suite");
	for ($i = 0; $i < count($pc_products_array); $i++) {
		$pc_products_array_options .= "<option value=\"$pc_products_array[$i]\">$pc_products_array[$i]</option>\n";
	}
	//platforms
	$platforms_array = array("Windows Vista/XP/2000/NT","UNIX / Linux");
	for ($i = 0; $i < count($platforms_array); $i++) {
		$platforms_array_options .= "<option value=\"$platforms_array[$i]\">$platforms_array[$i]</option>\n";
	}
	
	//multimedia
	$multimedia_array = array("Adobe PhotoShop / Illustrator");
	for ($i = 0; $i < count($multimedia_array); $i++) {
		$multimedia_array_options .= "<option value=\"$multimedia_array[$i]\">$multimedia_array[$i]</option>\n";
	}
	
	
	//$onshore_options
	$yes_no_array = array("YES","NO");
	for ($i = 0; $i < count($yes_no_array); $i++) {
		if($onshore == $yes_no_array[$i])
		{
			$onshore_options .= "<option selected value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
		}
		else
		{
			$onshore_options .= "<option value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
		}
	}		
	
	
	//for Web Designer. id's 8 = AUD ,19 = USD , 30 = POUNDS
	if (in_array($jr_list_id, array(8, 19, 30 )) == true) {
		$web_des_flag = "true";
		$yes_no_array = array("YES","NO");
		for ($i = 0; $i < count($yes_no_array); $i++) {
			if($require_graphic == $yes_no_array[$i])
			{
				$require_graphic_options .= "<option selected value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
			else
			{
				$require_graphic_options .= "<option value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
		}		
		
		
	}else{
		$web_des_flag = "false";
	}
	
	$smarty->assign('web_des_flag', $web_des_flag);
	$smarty->assign('require_graphic_options', $require_graphic_options);
	
	$smarty->assign('system_array_options', $system_array_options);
	$smarty->assign('database_array_options', $database_array_options);
	$smarty->assign('app_programming_array_options', $app_programming_array_options);
	$smarty->assign('open_source_array_options', $open_source_array_options);
	$smarty->assign('pc_products_array_options', $pc_products_array_options);
	$smarty->assign('platforms_array_options', $platforms_array_options);
	$smarty->assign('multimedia_array_options', $multimedia_array_options);
	$smarty->assign('onshore_options', $onshore_options);
}

if($category_id == 3){ //OFFICE CATEGORY
	// general
	$general_array = array("MS Office Skills","Computer Skills");
	for ($i = 0; $i < count($general_array); $i++) {
		$general_array_options .= "<option value=\"$general_array[$i]\">$general_array[$i]</option>\n";
	}
	//Accounts/Clerk
	$account_clerk_array = array("Invoicing","Purchasing"," Payroll");
	for ($i = 0; $i < count($account_clerk_array); $i++) {
		$accounts_clerk_array_options .= "<option value=\"$account_clerk_array[$i]\">$account_clerk_array[$i]</option>\n";
	}
	//Accounts Receivable
	$accounts_receivable_array = array("Debtor Account Reconciliation","Debtor Analysis");
	for ($i = 0; $i < count($accounts_receivable_array); $i++) {
		$accounts_receivable_array_options .= "<option value=\"$accounts_receivable_array[$i]\">$accounts_receivable_array[$i]</option>\n";
	}
	//Accounts Payable
	$accounts_payable_array = array("Creditor Account Reconciliation","Creditor Analysis");
	for ($i = 0; $i < count($accounts_payable_array); $i++) {
		$accounts_payable_array_options .= "<option value=\"$accounts_payable_array[$i]\">$accounts_payable_array[$i]</option>\n";
	}
	//Bookkeeper
	$bookkeeper_array = array("General Ledger","Knowledge of Aus GST","BAS Reporting","Cash Flow Analysis");
	for ($i = 0; $i < count($bookkeeper_array); $i++) {
		$bookkeeper_array_options .= "<option value=\"$bookkeeper_array[$i]\">$bookkeeper_array[$i]</option>\n";
	}
	//Accounting Package 
	$accounting_package_array = array("MYOB","SAP","Quickbooks");
	for ($i = 0; $i < count($accounting_package_array); $i++) {
		$accounting_package_array_options .= "<option value=\"$accounting_package_array[$i]\">$accounting_package_array[$i]</option>\n";
	}
	//Payroll
	$payroll_array = array("PAYG","Superannuation","Payroll Tax");
	for ($i = 0; $i < count($payroll_array); $i++) {
		$payroll_array_options .= "<option value=\"$payroll_array[$i]\">$payroll_array[$i]</option>\n";
	}
	
	
	if (in_array($jr_list_id, array(9,10,11,20,21,22,31,32,33,61,63,65 )) == true) {
		$staff_phone_flag = "true";
		$yes_no_array = array("YES","NO");
		for ($i = 0; $i < count($yes_no_array); $i++) {
			if($staff_phone == $yes_no_array[$i])
			{
				$staff_phone_options .= "<option selected value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
			else
			{
				$staff_phone_options .= "<option value=\"$yes_no_array[$i]\">$yes_no_array[$i]</option>\n";
			}
		}		
		
		
	}else{
		$staff_phone_flag = "false";
	}
	
	
	
	//
	
	$smarty->assign('staff_phone_flag', $staff_phone_flag);
	$smarty->assign('staff_phone_options', $staff_phone_options);
	$smarty->assign('general_array_options', $general_array_options);
	$smarty->assign('accounts_clerk_array_options',$accounts_clerk_array_options);
	$smarty->assign('accounts_receivable_array_options',$accounts_receivable_array_options);
	$smarty->assign('accounts_payable_array_options',$accounts_payable_array_options);
	$smarty->assign('bookkeeper_array_options',$bookkeeper_array_options);
	$smarty->assign('accounting_package_array_options',$accounting_package_array_options);
	$smarty->assign('payroll_array_options',$payroll_array_options);
}


$query = "SELECT * FROM gs_job_titles_credentials g WHERE gs_job_titles_details_id = $gs_job_titles_details_id AND gs_job_role_selection_id = $gs_job_role_selection_id  AND box = 'responsibility';";	
$resulta = $db->fetchAll($query);
$count_responsibilty = count($resulta);


//echo "category_id ".$category_id;


$smarty->assign('job_titles', $job_titles);
$smarty->assign('category_id', $category_id);
$smarty->assign('campaign_type_options', $campaign_type_options);
$smarty->assign('duties_responsibilities', $duties_responsibilities);
$smarty->assign('other_skills', $other_skills);
$smarty->assign('count_responsibilty', $count_responsibilty);
$smarty->assign('comments', $comments);

$smarty->assign('result', $result);
$smarty->assign('gs_job_titles_details_id', $gs_job_titles_details_id);
$smarty->assign('jr_list_id', $jr_list_id);
$smarty->assign('gs_job_role_selection_id', $gs_job_role_selection_id);
$smarty->assign('jr_cat_id',$jr_cat_id);



header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=ISO-8859-1');


if($category_id == 1){
	$class = 'skill_desc';
	$smarty->assign('class', $class);
	$smarty->display('marketing_edit_form.tpl');
	
}

if($category_id == 2){
	$class = 'skill_desc2';
	$smarty->assign('class', $class);
	$smarty->display('it_edit_form.tpl');
}

if($category_id == 3){
	$class = 'skill_desc2';
	$smarty->assign('class', $class);
	$smarty->display('office_edit_form.tpl');
}

if($category_id == 4){
	$class = 'skill_desc';
	$smarty->assign('class', $class);
	$smarty->display('others_edit_form.tpl');
}


?>