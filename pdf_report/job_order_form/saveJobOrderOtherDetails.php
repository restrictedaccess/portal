<?php
include '../../conf/zend_smarty_conf.php';
include '../../lib/addLeadsInfoHistoryChanges.php';
include '../../config.php';
include '../../conf.php';
include '../../function.php';
include '../../time.php';

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-Type: text/html; charset=utf-8');
header("Pragma: no-cache");

if($_SESSION['agent_no'] != "" or $_SESSION['agent_no'] != NULL){
	
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$_SESSION['agent_no']);
	$agent = $db->fetchRow($sql);
	
	$name = "BP : ".$agent['fname'].' '.$agent['lname'];
	
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$change_by_type = 'bp';
	$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br />%s</div>" ,$name,$agent['agent_address'],$agent['agent_contact']);
	
	$from_email = $agent['email'];
	$from_name = $agent['fname'].' '.$agent['lname'];
	
}
if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$_SESSION['admin_id']);
	$admin = $db->fetchRow($sql);
	
	$name = "Admin : ".$admin['admin_fname'].' '.$admin['admin_lname'];
	
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$change_by_type = 'admin';
	$signature_notes = sprintf("<div style='color:#999999;'>%s<br />%s<br />%s<br>%s<br>%s</div>" ,$admin['signature_notes'],$name,$admin['signature_company'],$admin['signature_contact_nos'],$admin['signature_websites']);
	
	$from_email = $admin['admin_email'];
	$from_name = $admin['admin_fname'].' '.$admin['admin_lname'];
	
}

if(!$agent and !$admin){
	
	$created_by_id =$_REQUEST['leads_id'];
	$created_by_type = 'lead';
	$change_by_type = 'client';
	
	$from_email = 'noreply@remotestaff.com.au';
	$from_name = 'noreply';
	
}

//echo $_REQUEST['leads_id']."<br>";
//echo $created_by_id."<br>".$created_by_type;exit;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$job_order_id =$_REQUEST['job_order_id'];  
$job_order_form_id = $_REQUEST['job_order_form_id'];

$no_of_staff = $_REQUEST['no_of_staff'];
$staff_start_date = $_REQUEST['staff_start_date'];

$duties_responsibilities = $_REQUEST['duties_responsibilities'];
$others = $_REQUEST['others'];
$additional_essentials=$_REQUEST['additional_essentials'];

$duties_responsibilities = filterfield($duties_responsibilities);
$others = filterfield($others);
$additional_essentials = filterfield($additional_essentials);

$job_order_form_status=$_REQUEST['job_order_form_status'];
$term_of_employment = $_REQUEST['term_of_employment'];
$notes = $_REQUEST['notes'];
$level_status = $_REQUEST['level_status'];

if($level_status=="-"){
	$level_status = "Entry-Level";
}



// leads info
$leads_id=$_REQUEST['leads_id'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$email=$_REQUEST['email'];
$mobile=$_REQUEST['mobile'];
$officenumber=$_REQUEST['officenumber'];
$company_name=$_REQUEST['company_name'];
$company_position=$_REQUEST['company_position'];
$used_rs=$_REQUEST['used_rs'];
$company_description=$_REQUEST['company_description'];
$company_industry=$_REQUEST['company_industry'];
$contact_person=$_REQUEST['contact_person'];

$mobile = filterfield($mobile);
$officenumber = filterfield($officenumber);
$company_name = filterfield($company_name);
$company_position = filterfield($company_position);
$company_description = filterfield($company_description);
$contact_person = filterfield($contact_person);


$site = $_SERVER['HTTP_HOST'];

$sql = "SELECT business_partner_id FROM leads WHERE id = $leads_id;";
$resul = mysql_query($sql);
list($business_partner_id) = mysql_fetch_array($resul);
if($business_partner_id){
	
	$sql = $db->select()
		->from('agent' , Array('fname','lname','email'))
		->where('agent_no =?' , $business_partner_id);
	$business_partner = $db->fetchRow($sql);
	$business_partner_name = $business_partner['fname']." ".$business_partner['lname'];
	$business_partner_email = $business_partner['email'];
	//echo $business_partner_email." ".$business_partner_name;exit;	
}	
	
// check if the leads_id is not null then update the leads info
if($leads_id!=NULL){
	
	$data = array(
			'fname' => stripslashes($fname),
			'lname' => stripslashes($lname),
			'mobile' => stripslashes($mobile),
			'officenumber' => stripslashes($officenumber),
			'company_name' => stripslashes($company_name),
			'company_position' => stripslashes($company_position),
			'outsourcing_experience' => $used_rs,
			'company_description' => stripslashes($company_description),
			'company_industry' => stripslashes($company_industry),
			'contact_person' => stripslashes($contact_person)
		);
	//print_r($data); exit;
	addLeadsInfoHistoryChanges($data , $leads_id , $created_by_id , $change_by_type);
	$where = "id = ".$leads_id;
	$db->update('leads', $data , $where);		
	//exit;
}
//	

if($job_order_form_status==NULL or $job_order_form_status==""){
	if($job_order_form_id==1){
		$ms_office_skill_rating = $_REQUEST['ms_office_skill_rating'];
		$computer_skill_rating = $_REQUEST['computer_skill_rating'];
		
		$invoicing_skill_rating=$_REQUEST['invoicing_skill_rating'];
		$purchasing_skill_rating=$_REQUEST['purchasing_skill_rating'];
		$payroll_skill_rating=$_REQUEST['payroll_skill_rating'];
		
		$acct_recon_skill_rating = $_REQUEST['acct_recon_skill_rating'];
		$debtor_skill_rating = $_REQUEST['debtor_skill_rating'];
		
		$creditor_acct_recon_skill_rating = $_REQUEST['creditor_acct_recon_skill_rating'];
		$creditor_analysis_skill_rating = $_REQUEST['creditor_analysis_skill_rating'];
			
		$general_ledger_skill_rating = $_REQUEST['general_ledger_skill_rating'];
		$knows_gst_skill_rating = $_REQUEST['knows_gst_skill_rating'];
		$bas_reporting_skill_rating = $_REQUEST['bas_reporting_skill_rating'];
		$cash_flow_analysis_skill_rating = $_REQUEST['cash_flow_analysis_skill_rating'];
		
		$myob_skill_rating = $_REQUEST['myob_skill_rating'];
		$sap_skill_rating = $_REQUEST['sap_skill_rating'];
		$quickbooks_skill_rating =$_REQUEST['quickbooks_skill_rating'];	
		
		$payg_skill_rating = $_REQUEST['payg_skill_rating'];
		$superannuation_skill_rating =$_REQUEST['superannuation_skill_rating'];
		$payroll_tax_skill_rating = $_REQUEST['payroll_tax_skill_rating'];
		
		if($ms_office_skill_rating=="") $ms_office_skill_rating="-";
		if($computer_skill_rating=="") $computer_skill_rating="-";
		
		if($invoicing_skill_rating=="") $invoicing_skill_rating="-";
		if($purchasing_skill_rating=="") $purchasing_skill_rating="-";
		if($payroll_skill_rating=="") $payroll_skill_rating="-";
		
		if($acct_recon_skill_rating=="") $acct_recon_skill_rating="-";
		if($debtor_skill_rating=="") $debtor_skill_rating="-";
		
		if($creditor_acct_recon_skill_rating=="") $creditor_acct_recon_skill_rating="-";
		if($creditor_analysis_skill_rating=="") $creditor_analysis_skill_rating="-";
		
		if($general_ledger_skill_rating=="") $general_ledger_skill_rating="-";
		if($knows_gst_skill_rating=="") $knows_gst_skill_rating="-";
		if($bas_reporting_skill_rating=="") $bas_reporting_skill_rating="-";
		if($cash_flow_analysis_skill_rating=="") $cash_flow_analysis_skill_rating="-";
		
		if($myob_skill_rating=="") $myob_skill_rating="-";
		if($sap_skill_rating=="") $sap_skill_rating="-";
		if($quickbooks_skill_rating=="") $quickbooks_skill_rating="-";
		
		if($payg_skill_rating=="") $payg_skill_rating="-";
		if($superannuation_skill_rating=="") $superannuation_skill_rating="-";
		if($payroll_tax_skill_rating=="") $payroll_tax_skill_rating="-";
		
	
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'MS Office Skills', '$ms_office_skill_rating', 'general'),
				($job_order_id, $job_order_form_id, 'Computer Skills', '$computer_skill_rating', 'general');";
		mysql_query($query);
		
		//accounts_clerk
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Invoicing', '$invoicing_skill_rating', 'accounts_clerk'),
				($job_order_id, $job_order_form_id, 'Purchasing', '$purchasing_skill_rating', 'accounts_clerk'),
				($job_order_id, $job_order_form_id, 'Payroll', '$payroll_skill_rating', 'accounts_clerk');";
		mysql_query($query);
		
		//accounts_receivable
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Debtor Account Reconciliation', '$acct_recon_skill_rating', 'accounts_receivable'),
				($job_order_id, $job_order_form_id, 'Debtor Analysis', '$debtor_skill_rating', 'accounts_receivable');";
		mysql_query($query);
		
		//accounts_payable
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Creditor Account Reconciliation', '$creditor_acct_recon_skill_rating', 'accounts_payable'),
				($job_order_id, $job_order_form_id, 'Creditor Analysis', '$creditor_analysis_skill_rating', 'accounts_payable');";
		mysql_query($query);
		//bookkeeper
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'General Ledger', '$general_ledger_skill_rating', 'bookkeeper'),
				($job_order_id, $job_order_form_id, 'Knowledge of Aus GST', '$knows_gst_skill_rating', 'bookkeeper'),
				($job_order_id, $job_order_form_id, 'BAS Reporting', '$bas_reporting_skill_rating', 'bookkeeper'),
				($job_order_id, $job_order_form_id, 'Cash Flow  Analysis', '$cash_flow_analysis_skill_rating', 'bookkeeper');";
		mysql_query($query);
		//accounting_package
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'MYOB', '$myob_skill_rating', 'accounting_package'),
				($job_order_id, $job_order_form_id, 'SAP', '$sap_skill_rating', 'accounting_package'),
				($job_order_id, $job_order_form_id, 'Quickbooks', '$quickbooks_skill_rating', 'accounting_package');";
		mysql_query($query);
		
		//payroll
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'PAYG', '$payg_skill_rating', 'payroll'),
				($job_order_id, $job_order_form_id, 'Superannuation', '$superannuation_skill_rating', 'payroll'),
				($job_order_id, $job_order_form_id, 'Payroll Tax', '$payroll_tax_skill_rating', 'payroll');";
		mysql_query($query);
		
	}
	
	if($job_order_form_id==5){
		$html_skill_rating = $_REQUEST['html_skill_rating'];
		$xhtml_skill_rating = $_REQUEST['xhtml_skill_rating'];
		$css_skill_rating=$_REQUEST['css_skill_rating'];
		$macromedia_skill_rating=$_REQUEST['macromedia_skill_rating'];
		$wordpress_skill_rating=$_REQUEST['wordpress_skill_rating'];
		$mambo_skill_rating = $_REQUEST['mambo_skill_rating'];
		
		if($html_skill_rating=="") $html_skill_rating="-";
		if($xhtml_skill_rating=="") $xhtml_skill_rating="-";
		if($css_skill_rating=="") $css_skill_rating="-";
		if($macromedia_skill_rating=="") $macromedia_skill_rating="-";
		if($wordpress_skill_rating=="") $wordpress_skill_rating="-";
		if($mambo_skill_rating=="") $mambo_skill_rating="-";
		
		//web_open_systems
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'HTML', '$html_skill_rating', 'web_open_systems'),
				($job_order_id, $job_order_form_id, 'XHTML', '$xhtml_skill_rating', 'web_open_systems'),
				($job_order_id, $job_order_form_id, 'Cascading Style Sheets (CCS)', '$css_skill_rating', 'web_open_systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Flash', '$macromedia_skill_rating', 'web_open_systems'),
				($job_order_id, $job_order_form_id, 'Wordpress', '$wordpress_skill_rating', 'web_open_systems'),
				($job_order_id, $job_order_form_id, 'Mambo / Joomla', '$mambo_skill_rating', 'web_open_systems');";
		mysql_query($query);
	}
	if($job_order_form_id==6){
		$web_dev_html_skill_rating = $_REQUEST['web_dev_html_skill_rating'];
		$web_dev_xhtml_skill_rating = $_REQUEST['web_dev_xhtml_skill_rating'];
		$web_dev_aspnet_skill_rating=$_REQUEST['web_dev_aspnet_skill_rating'];
		$web_dev_asp_skill_rating=$_REQUEST['web_dev_asp_skill_rating'];
		$web_dev_vbnet_skill_rating=$_REQUEST['web_dev_vbnet_skill_rating'];
		$web_dev_php_skill_rating = $_REQUEST['web_dev_php_skill_rating'];
		
		$web_dev_javascript_skill_rating = $_REQUEST['web_dev_javascript_skill_rating'];
		$web_dev_css_skill_rating = $_REQUEST['web_dev_css_skill_rating'];
		$web_dev_iis_skill_rating = $_REQUEST['web_dev_iis_skill_rating'];
		$web_dev_flash_skill_rating = $_REQUEST['web_dev_flash_skill_rating'];
		$web_dev_xml_skill_rating = $_REQUEST['web_dev_xml_skill_rating'];
		$web_dev_ajax_skill_rating = $_REQUEST['web_dev_ajax_skill_rating'];
		$web_dev_dreamweaver_skill_rating = $_REQUEST['web_dev_dreamweaver_skill_rating'];
		$web_dev_fireworks_skill_rating = $_REQUEST['web_dev_fireworks_skill_rating'];
		$web_dev_coldfusion_skill_rating = $_REQUEST['web_dev_coldfusion_skill_rating'];
		$web_dev_actionscript_skill_rating = $_REQUEST['web_dev_actionscript_skill_rating'];
		
		if($web_dev_html_skill_rating=="") $web_dev_html_skill_rating="-";
		if($web_dev_xhtml_skill_rating=="") $web_dev_xhtml_skill_rating="-";
		if($web_dev_aspnet_skill_rating=="") $web_dev_aspnet_skill_rating="-";
		if($web_dev_asp_skill_rating=="") $web_dev_asp_skill_rating="-";
		if($web_dev_vbnet_skill_rating=="") $web_dev_vbnet_skill_rating="-";
		if($web_dev_php_skill_rating=="") $web_dev_php_skill_rating="-";
		
		
		if($web_dev_javascript_skill_rating=="") $web_dev_javascript_skill_rating="-";
		if($web_dev_css_skill_rating=="") $web_dev_css_skill_rating="-";
		if($web_dev_iis_skill_rating=="") $web_dev_iis_skill_rating="-";
		if($web_dev_flash_skill_rating=="") $web_dev_flash_skill_rating="-";
		if($web_dev_xml_skill_rating=="") $web_dev_xml_skill_rating="-";
		if($web_dev_ajax_skill_rating=="") $web_dev_ajax_skill_rating="-";
		if($web_dev_dreamweaver_skill_rating=="") $web_dev_dreamweaver_skill_rating="-";
		if($web_dev_fireworks_skill_rating=="") $web_dev_fireworks_skill_rating="-";
		if($web_dev_coldfusion_skill_rating=="") $web_dev_coldfusion_skill_rating="-";
		if($web_dev_actionscript_skill_rating=="") $web_dev_actionscript_skill_rating="-";
		
		//web_systems
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'HTML', '$web_dev_html_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'XHTML', '$web_dev_xhtml_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'ASP.Net', '$web_dev_aspnet_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'ASP Classic', '$web_dev_asp_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'VB.Net', '$web_dev_vbnet_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'PHP', '$web_dev_php_skill_rating', 'web_systems');";
		mysql_query($query);
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Javascript', '$web_dev_javascript_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'Cascading Style Sheets', '$web_dev_css_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'IIS / Apache', '$web_dev_iis_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Flash', '$web_dev_flash_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'XML', '$web_dev_xml_skill_rating', 'web_systems');";
		mysql_query($query);
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'AJAX', '$web_dev_ajax_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Dreamweaver', '$web_dev_dreamweaver_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Fireworks', '$web_dev_fireworks_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'Coldfusion', '$web_dev_coldfusion_skill_rating', 'web_systems'),
				($job_order_id, $job_order_form_id, 'Actionscript', '$web_dev_actionscript_skill_rating', 'web_systems');";
		mysql_query($query);
		
		//web_databases
		$web_dev_access_skill_rating = $_REQUEST['web_dev_access_skill_rating'];
		$web_dev_sqlserver_skill_rating = $_REQUEST['web_dev_sqlserver_skill_rating'];
		$web_dev_mysql_skill_rating=$_REQUEST['web_dev_mysql_skill_rating'];
		
		if($web_dev_access_skill_rating=="") $web_dev_access_skill_rating="-";
		if($web_dev_sqlserver_skill_rating=="") $web_dev_sqlserver_skill_rating="-";
		if($web_dev_mysql_skill_rating=="") $web_dev_mysql_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'MS Access', '$web_dev_access_skill_rating', 'web_databases'),
				($job_order_id, $job_order_form_id, 'SQL Server', '$web_dev_sqlserver_skill_rating', 'web_databases'),
				($job_order_id, $job_order_form_id, 'MySQL', '$web_dev_mysql_skill_rating', 'web_databases');";
		mysql_query($query);
		
		//web_programming_languages
		$web_dev_vb_skill_rating = $_REQUEST['web_dev_vb_skill_rating'];
		$web_dev_cnet_skill_rating = $_REQUEST['web_dev_cnet_skill_rating'];
		
		if($web_dev_vb_skill_rating=="") $web_dev_vb_skill_rating="-";
		if($web_dev_cnet_skill_rating=="") $web_dev_cnet_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Visual Basic', '$web_dev_vb_skill_rating', 'web_programming_languages'),
				($job_order_id, $job_order_form_id, 'Visual C# .Net', '$web_dev_cnet_skill_rating', 'web_programming_languages');";
		mysql_query($query);
		
		//web_open_source_software
		$web_dev_wordpress_skill_rating = $_REQUEST['web_dev_wordpress_skill_rating'];
		$web_dev_mambojoomla_skill_rating = $_REQUEST['web_dev_mambojoomla_skill_rating'];
		$web_dev_phpbb_skill_rating = $_REQUEST['web_dev_phpbb_skill_rating'];
		
		if($web_dev_wordpress_skill_rating=="") $web_dev_wordpress_skill_rating="-";
		if($web_dev_mambojoomla_skill_rating=="") $web_dev_mambojoomla_skill_rating="-";
		if($web_dev_phpbb_skill_rating=="") $web_dev_phpbb_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Wordpress', '$web_dev_wordpress_skill_rating', 'web_open_source_software'),
				($job_order_id, $job_order_form_id, 'Mambo / Joomla', '$web_dev_mambojoomla_skill_rating', 'web_open_source_software'),
				($job_order_id, $job_order_form_id, 'PHPBB2 or PHPBB3', '$web_dev_phpbb_skill_rating', 'web_open_source_software');";
		mysql_query($query);
		
		//web_platforms_environments
		$web_dev_windows_skill_rating = $_REQUEST['web_dev_windows_skill_rating'];
		$web_dev_unixlinux_skill_rating = $_REQUEST['web_dev_unixlinux_skill_rating'];
		
		if($web_dev_windows_skill_rating=="") $web_dev_windows_skill_rating="-";
		if($web_dev_unixlinux_skill_rating=="") $web_dev_unixlinux_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Windows Vista/XP/2000/NT', '$web_dev_windows_skill_rating', 'web_platforms_environments'),
				($job_order_id, $job_order_form_id, 'UNIX / Linux', '$web_dev_unixlinux_skill_rating', 'web_platforms_environments');";
		mysql_query($query);
		
		//web_pc_desktop_products
		$web_dev_msoffice_skill_rating= $_REQUEST['web_dev_msoffice_skill_rating'];
		if($web_dev_msoffice_skill_rating=="") $web_dev_msoffice_skill_rating="-";
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Microsoft Office Suite', '$web_dev_msoffice_skill_rating', 'web_pc_desktop_products');";
		mysql_query($query);
		
		//web_multimedia
		$web_dev_photoshop_skill_rating= $_REQUEST['web_dev_photoshop_skill_rating'];
		if($web_dev_photoshop_skill_rating=="") $web_dev_photoshop_skill_rating="-";
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Adobe PhotoShop / Illustrator', '$web_dev_photoshop_skill_rating', 'web_multimedia');";
		mysql_query($query);
		
	}
	if($job_order_form_id==7){
		$it_dev_html_skill_rating = $_REQUEST['it_dev_html_skill_rating'];
		$it_dev_xhtml_skill_rating = $_REQUEST['it_dev_xhtml_skill_rating'];
		$it_dev_aspnet_skill_rating=$_REQUEST['it_dev_aspnet_skill_rating'];
		$it_dev_asp_skill_rating=$_REQUEST['it_dev_asp_skill_rating'];
		$it_dev_vbnet_skill_rating=$_REQUEST['it_dev_vbnet_skill_rating'];
		$it_dev_php_skill_rating = $_REQUEST['it_dev_php_skill_rating'];
		
		$it_dev_javascript_skill_rating = $_REQUEST['it_dev_javascript_skill_rating'];
		$it_dev_css_skill_rating = $_REQUEST['it_dev_css_skill_rating'];
		$it_dev_iis_skill_rating = $_REQUEST['it_dev_iis_skill_rating'];
		$it_dev_flash_skill_rating = $_REQUEST['it_dev_flash_skill_rating'];
		$it_dev_xml_skill_rating = $_REQUEST['it_dev_xml_skill_rating'];
		$it_dev_ajax_skill_rating = $_REQUEST['it_dev_ajax_skill_rating'];
		$it_dev_dreamweaver_skill_rating = $_REQUEST['it_dev_dreamweaver_skill_rating'];
		$it_dev_fireworks_skill_rating = $_REQUEST['it_dev_fireworks_skill_rating'];
		$it_dev_coldfusion_skill_rating = $_REQUEST['it_dev_coldfusion_skill_rating'];
		$it_dev_actionscript_skill_rating = $_REQUEST['it_dev_actionscript_skill_rating'];
		
		if($it_dev_html_skill_rating=="") $it_dev_html_skill_rating="-";
		if($it_dev_xhtml_skill_rating=="") $it_dev_xhtml_skill_rating="-";
		if($it_dev_aspnet_skill_rating=="") $it_dev_aspnet_skill_rating="-";
		if($it_dev_asp_skill_rating=="") $it_dev_asp_skill_rating="-";
		if($it_dev_vbnet_skill_rating=="") $it_dev_vbnet_skill_rating="-";
		if($it_dev_php_skill_rating=="") $it_dev_php_skill_rating="-";
		
		
		if($it_dev_javascript_skill_rating=="") $it_dev_javascript_skill_rating="-";
		if($it_dev_css_skill_rating=="") $it_dev_css_skill_rating="-";
		if($it_dev_iis_skill_rating=="") $it_dev_iis_skill_rating="-";
		if($it_dev_flash_skill_rating=="") $it_dev_flash_skill_rating="-";
		if($it_dev_xml_skill_rating=="") $it_dev_xml_skill_rating="-";
		if($it_dev_ajax_skill_rating=="") $it_dev_ajax_skill_rating="-";
		if($it_dev_dreamweaver_skill_rating=="") $it_dev_dreamweaver_skill_rating="-";
		if($it_dev_fireworks_skill_rating=="") $it_dev_fireworks_skill_rating="-";
		if($it_dev_coldfusion_skill_rating=="") $it_dev_coldfusion_skill_rating="-";
		if($it_dev_actionscript_skill_rating=="") $it_dev_actionscript_skill_rating="-";
		
		//it_systems
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'HTML', '$it_dev_html_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'XHTML', '$it_dev_xhtml_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'ASP.Net', '$it_dev_aspnet_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'ASP Classic', '$it_dev_asp_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'VB.Net', '$it_dev_vbnet_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'PHP', '$it_dev_php_skill_rating', 'it_systems');";
		mysql_query($query);
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Javascript', '$it_dev_javascript_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'Cascading Style Sheets', '$it_dev_css_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'IIS / Apache', '$it_dev_iis_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Flash', '$it_dev_flash_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'XML', '$it_dev_xml_skill_rating', 'it_systems');";
		mysql_query($query);
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'AJAX', '$it_dev_ajax_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Dreamweaver', '$it_dev_dreamweaver_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Fireworks', '$it_dev_fireworks_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'Coldfusion', '$it_dev_coldfusion_skill_rating', 'it_systems'),
				($job_order_id, $job_order_form_id, 'Actionscript', '$it_dev_actionscript_skill_rating', 'it_systems');";
		mysql_query($query);
		
		//it_databases
		$it_dev_access_skill_rating = $_REQUEST['it_dev_access_skill_rating'];
		$it_dev_sqlserver_skill_rating = $_REQUEST['it_dev_sqlserver_skill_rating'];
		$it_dev_mysql_skill_rating=$_REQUEST['it_dev_mysql_skill_rating'];
		
		if($it_dev_access_skill_rating=="") $it_dev_access_skill_rating="-";
		if($it_dev_sqlserver_skill_rating=="") $it_dev_sqlserver_skill_rating="-";
		if($it_dev_mysql_skill_rating=="") $it_dev_mysql_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'MS Access', '$it_dev_access_skill_rating', 'it_databases'),
				($job_order_id, $job_order_form_id, 'SQL Server', '$it_dev_sqlserver_skill_rating', 'it_databases'),
				($job_order_id, $job_order_form_id, 'MySQL', '$it_dev_mysql_skill_rating', 'it_databases');";
		mysql_query($query);
		
		//it_programming_languages
		$it_dev_vb_skill_rating = $_REQUEST['it_dev_vb_skill_rating'];
		$it_dev_cnet_skill_rating = $_REQUEST['it_dev_cnet_skill_rating'];
		
		if($it_dev_vb_skill_rating=="") $it_dev_vb_skill_rating="-";
		if($it_dev_cnet_skill_rating=="") $it_dev_cnet_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Visual Basic', '$it_dev_vb_skill_rating', 'it_programming_languages'),
				($job_order_id, $job_order_form_id, 'Visual C# .Net', '$it_dev_cnet_skill_rating', 'it_programming_languages');";
		mysql_query($query);
		
		//it_open_source_software
		$it_dev_wordpress_skill_rating = $_REQUEST['it_dev_wordpress_skill_rating'];
		$it_dev_mambojoomla_skill_rating = $_REQUEST['it_dev_mambojoomla_skill_rating'];
		$it_dev_phpbb_skill_rating = $_REQUEST['it_dev_phpbb_skill_rating'];
		
		if($it_dev_wordpress_skill_rating=="") $it_dev_wordpress_skill_rating="-";
		if($it_dev_mambojoomla_skill_rating=="") $it_dev_mambojoomla_skill_rating="-";
		if($it_dev_phpbb_skill_rating=="") $it_dev_phpbb_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Wordpress', '$it_dev_wordpress_skill_rating', 'it_open_source_software'),
				($job_order_id, $job_order_form_id, 'Mambo / Joomla', '$it_dev_mambojoomla_skill_rating', 'it_open_source_software'),
				($job_order_id, $job_order_form_id, 'PHPBB2 or PHPBB3', '$it_dev_phpbb_skill_rating', 'it_open_source_software');";
		mysql_query($query);
		
		//it_platforms_environments
		$it_dev_windows_skill_rating = $_REQUEST['it_dev_windows_skill_rating'];
		$it_dev_unixlinux_skill_rating = $_REQUEST['it_dev_unixlinux_skill_rating'];
		
		if($it_dev_windows_skill_rating=="") $it_dev_windows_skill_rating="-";
		if($it_dev_unixlinux_skill_rating=="") $it_dev_unixlinux_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Windows Vista/XP/2000/NT', '$it_dev_windows_skill_rating', 'it_platforms_environments'),
				($job_order_id, $job_order_form_id, 'UNIX / Linux', '$it_dev_unixlinux_skill_rating', 'it_platforms_environments');";
		mysql_query($query);
		
		//it_pc_desktop_products
		$it_dev_msoffice_skill_rating= $_REQUEST['it_dev_msoffice_skill_rating'];
		if($it_dev_msoffice_skill_rating=="") $it_dev_msoffice_skill_rating="-";
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Microsoft Office Suite', '$it_dev_msoffice_skill_rating', 'it_pc_desktop_products');";
		mysql_query($query);
		
		//it_multimedia
		$it_dev_photoshop_skill_rating= $_REQUEST['it_dev_photoshop_skill_rating'];
		if($it_dev_photoshop_skill_rating=="") $it_dev_photoshop_skill_rating="-";
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Adobe PhotoShop / Illustrator', '$it_dev_photoshop_skill_rating', 'it_multimedia');";
		mysql_query($query);
		
	}
	if($job_order_form_id==8){
		$seo_html_skill_rating = $_REQUEST['seo_html_skill_rating'];
		$seo_site_analysis_skill_rating = $_REQUEST['seo_site_analysis_skill_rating'];
		$seo_analytics_skill_rating=$_REQUEST['seo_analytics_skill_rating'];
		$seo_link_building_skill_rating=$_REQUEST['seo_link_building_skill_rating'];
		$seo_keyword_search_skill_rating=$_REQUEST['seo_keyword_search_skill_rating'];
		$seo_google_adwords_skill_rating = $_REQUEST['seo_google_adwords_skill_rating'];
		$seo_content_writing_skill_rating = $_REQUEST['seo_content_writing_skill_rating'];
		$seo_cms_skill_rating = $_REQUEST['seo_cms_skill_rating'];
		//seo
		if($seo_html_skill_rating=="") $seo_html_skill_rating="-";
		if($seo_site_analysis_skill_rating=="") $seo_site_analysis_skill_rating="-";
		if($seo_analytics_skill_rating=="") $seo_analytics_skill_rating="-";
		if($seo_link_building_skill_rating=="") $seo_link_building_skill_rating="-";
		if($seo_keyword_search_skill_rating=="") $seo_keyword_search_skill_rating="-";
		if($seo_google_adwords_skill_rating=="") $seo_google_adwords_skill_rating="-";
		if($seo_content_writing_skill_rating=="") $seo_content_writing_skill_rating="-";
		if($seo_cms_skill_rating=="") $seo_cms_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'HTML', '$seo_html_skill_rating', 'seo'),
				($job_order_id, $job_order_form_id, 'Site Analysis', '$seo_site_analysis_skill_rating', 'seo'),
				($job_order_id, $job_order_form_id, 'Analytics', '$seo_analytics_skill_rating', 'seo'),
				($job_order_id, $job_order_form_id, 'Link Building', '$seo_link_building_skill_rating', 'seo'),
				($job_order_id, $job_order_form_id, 'Key word Research', '$seo_keyword_search_skill_rating', 'seo'),
				($job_order_id, $job_order_form_id, 'Google AdWords Management', '$seo_google_adwords_skill_rating', 'seo'),
				($job_order_id, $job_order_form_id, 'Content Writing', '$seo_content_writing_skill_rating', 'seo'),
				($job_order_id, $job_order_form_id, 'CMS', '$seo_cms_skill_rating', 'seo');";
		mysql_query($query);
	}

	
	if($job_order_form_id==2){
		$app_dev_html_skill_rating = $_REQUEST['app_dev_html_skill_rating'];
		$app_dev_xhtml_skill_rating = $_REQUEST['app_dev_xhtml_skill_rating'];
		$app_dev_aspnet_skill_rating=$_REQUEST['app_dev_aspnet_skill_rating'];
		$app_dev_asp_skill_rating=$_REQUEST['app_dev_asp_skill_rating'];
		$app_dev_vbnet_skill_rating=$_REQUEST['app_dev_vbnet_skill_rating'];
		$app_dev_php_skill_rating = $_REQUEST['app_dev_php_skill_rating'];
		
		$app_dev_javascript_skill_rating = $_REQUEST['app_dev_javascript_skill_rating'];
		$app_dev_css_skill_rating = $_REQUEST['app_dev_css_skill_rating'];
		$app_dev_iis_skill_rating = $_REQUEST['app_dev_iis_skill_rating'];
		$app_dev_flash_skill_rating = $_REQUEST['app_dev_flash_skill_rating'];
		$app_dev_xml_skill_rating = $_REQUEST['app_dev_xml_skill_rating'];
		$app_dev_ajax_skill_rating = $_REQUEST['app_dev_ajax_skill_rating'];
		$app_dev_dreamweaver_skill_rating = $_REQUEST['app_dev_dreamweaver_skill_rating'];
		$app_dev_fireworks_skill_rating = $_REQUEST['app_dev_fireworks_skill_rating'];
		$app_dev_coldfusion_skill_rating = $_REQUEST['app_dev_coldfusion_skill_rating'];
		$app_dev_actionscript_skill_rating = $_REQUEST['app_dev_actionscript_skill_rating'];
		
		if($app_dev_html_skill_rating=="") $app_dev_html_skill_rating="-";
		if($app_dev_xhtml_skill_rating=="") $app_dev_xhtml_skill_rating="-";
		if($app_dev_aspnet_skill_rating=="") $app_dev_aspnet_skill_rating="-";
		if($app_dev_asp_skill_rating=="") $app_dev_asp_skill_rating="-";
		if($app_dev_vbnet_skill_rating=="") $app_dev_vbnet_skill_rating="-";
		if($app_dev_php_skill_rating=="") $app_dev_php_skill_rating="-";
		
		
		if($app_dev_javascript_skill_rating=="") $app_dev_javascript_skill_rating="-";
		if($app_dev_css_skill_rating=="") $app_dev_css_skill_rating="-";
		if($app_dev_iis_skill_rating=="") $app_dev_iis_skill_rating="-";
		if($app_dev_flash_skill_rating=="") $app_dev_flash_skill_rating="-";
		if($app_dev_xml_skill_rating=="") $app_dev_xml_skill_rating="-";
		if($app_dev_ajax_skill_rating=="") $app_dev_ajax_skill_rating="-";
		if($app_dev_dreamweaver_skill_rating=="") $app_dev_dreamweaver_skill_rating="-";
		if($app_dev_fireworks_skill_rating=="") $app_dev_fireworks_skill_rating="-";
		if($app_dev_coldfusion_skill_rating=="") $app_dev_coldfusion_skill_rating="-";
		if($app_dev_actionscript_skill_rating=="") $app_dev_actionscript_skill_rating="-";
		
		//systems
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'HTML', '$app_dev_html_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'XHTML', '$app_dev_xhtml_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'ASP.Net', '$app_dev_aspnet_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'ASP Classic', '$app_dev_asp_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'VB.Net', '$app_dev_vbnet_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'PHP', '$app_dev_php_skill_rating', 'systems');";
		mysql_query($query);
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Javascript', '$app_dev_javascript_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'Cascading Style Sheets', '$app_dev_css_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'IIS / Apache', '$app_dev_iis_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Flash', '$app_dev_flash_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'XML', '$app_dev_xml_skill_rating', 'systems');";
		mysql_query($query);
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'AJAX', '$app_dev_ajax_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Dreamweaver', '$app_dev_dreamweaver_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'Macromedia Fireworks', '$app_dev_fireworks_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'Coldfusion', '$app_dev_coldfusion_skill_rating', 'systems'),
				($job_order_id, $job_order_form_id, 'Actionscript', '$app_dev_actionscript_skill_rating', 'systems');";
		mysql_query($query);
		
		//databases
		$app_dev_access_skill_rating = $_REQUEST['app_dev_access_skill_rating'];
		$app_dev_sqlserver_skill_rating = $_REQUEST['app_dev_sqlserver_skill_rating'];
		$app_dev_mysql_skill_rating=$_REQUEST['app_dev_mysql_skill_rating'];
		
		if($app_dev_access_skill_rating=="") $app_dev_access_skill_rating="-";
		if($app_dev_sqlserver_skill_rating=="") $app_dev_sqlserver_skill_rating="-";
		if($app_dev_mysql_skill_rating=="") $app_dev_mysql_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'MS Access', '$app_dev_access_skill_rating', 'databases'),
				($job_order_id, $job_order_form_id, 'SQL Server', '$app_dev_sqlserver_skill_rating', 'databases'),
				($job_order_id, $job_order_form_id, 'MySQL', '$app_dev_mysql_skill_rating', 'databases');";
		mysql_query($query);
		
		//programming_languages
		$app_dev_vb_skill_rating = $_REQUEST['app_dev_vb_skill_rating'];
		$app_dev_cnet_skill_rating = $_REQUEST['app_dev_cnet_skill_rating'];
		
		if($app_dev_vb_skill_rating=="") $app_dev_vb_skill_rating="-";
		if($app_dev_cnet_skill_rating=="") $app_dev_cnet_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Visual Basic', '$app_dev_vb_skill_rating', 'programming_languages'),
				($job_order_id, $job_order_form_id, 'Visual C# .Net', '$app_dev_cnet_skill_rating', 'programming_languages');";
		mysql_query($query);
		
		//open_source_software
		$app_dev_wordpress_skill_rating = $_REQUEST['app_dev_wordpress_skill_rating'];
		$app_dev_mambojoomla_skill_rating = $_REQUEST['app_dev_mambojoomla_skill_rating'];
		$app_dev_phpbb_skill_rating = $_REQUEST['app_dev_phpbb_skill_rating'];
		
		if($app_dev_wordpress_skill_rating=="") $app_dev_wordpress_skill_rating="-";
		if($app_dev_mambojoomla_skill_rating=="") $app_dev_mambojoomla_skill_rating="-";
		if($app_dev_phpbb_skill_rating=="") $app_dev_phpbb_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Wordpress', '$app_dev_wordpress_skill_rating', 'open_source_software'),
				($job_order_id, $job_order_form_id, 'Mambo / Joomla', '$app_dev_mambojoomla_skill_rating', 'open_source_software'),
				($job_order_id, $job_order_form_id, 'PHPBB2 or PHPBB3', '$app_dev_phpbb_skill_rating', 'open_source_software');";
		mysql_query($query);
		
		//platforms_environments
		$app_dev_windows_skill_rating = $_REQUEST['app_dev_windows_skill_rating'];
		$app_dev_unixlinux_skill_rating = $_REQUEST['app_dev_unixlinux_skill_rating'];
		
		if($app_dev_windows_skill_rating=="") $app_dev_windows_skill_rating="-";
		if($app_dev_unixlinux_skill_rating=="") $app_dev_unixlinux_skill_rating="-";
		
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Windows Vista/XP/2000/NT', '$app_dev_windows_skill_rating', 'platforms_environments'),
				($job_order_id, $job_order_form_id, 'UNIX / Linux', '$app_dev_unixlinux_skill_rating', 'platforms_environments');";
		mysql_query($query);
		
		//pc_desktop_products
		$app_dev_msoffice_skill_rating= $_REQUEST['app_dev_msoffice_skill_rating'];
		if($app_dev_msoffice_skill_rating=="") $app_dev_msoffice_skill_rating="-";
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Microsoft Office Suappe', '$app_dev_msoffice_skill_rating', 'pc_desktop_products');";
		mysql_query($query);
		
		//multimedia
		$app_dev_photoshop_skill_rating= $_REQUEST['app_dev_photoshop_skill_rating'];
		if($app_dev_photoshop_skill_rating=="") $app_dev_photoshop_skill_rating="-";
		$query="INSERT INTO job_order_details (job_order_id, job_order_form_id, job_requirement, rating, groupings) VALUES 
				($job_order_id, $job_order_form_id, 'Adobe PhotoShop / Illustrator', '$app_dev_photoshop_skill_rating', 'multimedia');";
		mysql_query($query);
		
	}


	

}




if($job_order_form_id==10){
	$campaign_type=$_REQUEST['campaign_type'];
	
	$sqlCheck="SELECT * FROM job_order_details WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id AND groupings = 'campaign_type';";
	$resultCheck = mysql_query($sqlCheck);
	$ctr=@mysql_num_rows($resultCheck);
	if ($ctr > 0 )
	{
		$sql= "UPDATE job_order_details SET job_requirement = '$campaign_type' WHERE job_order_id = $job_order_id AND job_order_form_id = $job_order_form_id AND groupings = 'campaign_type';";
	}
	else
	{	
		$sql= "INSERT INTO job_order_details SET job_order_id = $job_order_id, job_order_form_id = $job_order_form_id, job_requirement = '$campaign_type', groupings = 'campaign_type';";
	}
	$data = mysql_query($sql);
	if(!$data) die("Error In Script . : $sql ");
	

}
$virtual_assistant="";
$primary_role='';
$secondary_role='';
if($job_order_form_id==11){
	$primary_role = $_REQUEST['primary_role'];
	$secondary_role = $_REQUEST['secondary_role'];
	$virtual_assistant = " primary_role = '$primary_role', secondary_role = '$secondary_role', ";
}

if($job_order_form_id==12){
	$primary_role = $_REQUEST['primary_role'];
	$secondary_role = $_REQUEST['secondary_role'];
	$virtual_assistant = " primary_role = '$primary_role', secondary_role = '$secondary_role', ";
}



//$query="UPDATE job_order_list SET no_of_staff = '$no_of_staff' , staff_start_date ='$staff_start_date', duties_responsibilities = '$duties_responsibilities', others = '$others', additional_essentials = '$additional_essentials' , $virtual_assistant job_order_form_status = 'finished' , term_of_employment = '$term_of_employment', notes = '$notes' , level_status = '$level_status' WHERE job_order_id = $job_order_id AND  job_order_form_id = $job_order_form_id;";
//$result = mysql_query($query);
//if(!$result) die("Error In Script . : $query ");
$data = array(
    'no_of_staff' => $no_of_staff,
	'staff_start_date' =>$staff_start_date, 
	'duties_responsibilities' => $duties_responsibilities, 
	'others' => $others, 
	'additional_essentials' => $additional_essentials , 
	'primary_role' => $primary_role, 
	'secondary_role' => $secondary_role, 
	'job_order_form_status' => 'finished' , 
	'term_of_employment' => $term_of_employment, 
	'notes' => $notes , 
	'level_status' => $level_status
);

$where = "job_order_id = ".$job_order_id." AND  job_order_form_id = ".$job_order_form_id;	
$db->update('job_order_list', $data , $where);


$query = "SELECT DATE_FORMAT(j.date_filled_up,'%D %b %y') ,j.ran FROM job_order j WHERE leads_id = $leads_id AND job_order_id = $job_order_id;";
$result = mysql_query($query);
list($date_filled_up ,$ran )=mysql_fetch_array($result);

$queryJobForms = "SELECT f.job_order_form_title 
					FROM job_order_list j LEFT JOIN  job_order_form f ON f.job_order_form_id = j.job_order_form_id 
					WHERE job_order_id = $job_order_id AND j.job_order_form_status = 'finished';";
$data = mysql_query($queryJobForms);
$details="";
$counter =0;
while(list($job_order_form_title)=mysql_fetch_array($data))
{
	$counter++;
	$details.= $counter.") ".$job_order_form_title."<br>";
		
}


$sql = $db->select()
	->from('job_order' , 'form_filled_up')
	->where('job_order_id =?' , $job_order_id);
$form_filled_up = $db->fetchOne($sql);	

//send email once to the client
if($form_filled_up != 'yes') {
	if($created_by_type!='lead'){
		$body = "<div style='padding:5px;font:12px Arial;'><p>Dear ".stripslashes($fname)." ".stripslashes($lname).", </p>
				 <p>The job specification form below has been filled by ".stripslashes($name)." for you. </p>
				 <p>Job Order #".$job_order_id."</p>
				 <p><a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran'>http://$site/portal/pdf_report/job_order_form/?ran=$ran</a></p>
				 <p><b>Details</b></p>
				 <p>".$details."</p>
				 <p>&nbsp;</p>
				 <p>Should you want to edit and add more to this job specification, please click on the link and overwrite. Please don’t forget to click on “ SUBMIT” button. </p>
				 <img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'>".$signature_notes."</div>";
				 
	}else{
		$body = "<p>Dear ".stripslashes($fname)." ".stripslashes($lname).", </p>
				 <p>Your Remotestaff Job Order #".$job_order_id."</p>
				 <p><a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran'>http://$site/portal/pdf_report/job_order_form/?ran=$ran</a></p>
				 <p><b>Details</b></p>
				 <p>".$details."</p>
				 <p>&nbsp;</p>";
				 
	}
	
	//send email	
	$subject = "REMOTESTAFF Job Specification Form Received [ ".stripslashes($fname)." ".stripslashes($lname)." ]";
	$mail = new Zend_Mail();
	$mail->setSubject($subject);
	$mail->setBodyHtml(stripslashes($body));
	$mail->setFrom($from_email, $from_name);
	
	if(! TEST){
		$mail->addTo($email , stripslashes($fname)." ".stripslashes($lname));
	}else{
		$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	}
	
	$mail->send($transport);
}		 


$query = "UPDATE job_order SET form_filled_up = 'yes' , date_filled_up = '$ATZ' , response_by_id = $created_by_id , response_by_type = '$created_by_type'  WHERE job_order_id = $job_order_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script . : $query ");



$body = "A new Job order has been added for <br><br>".
			"Name : ".stripslashes($fname)." ".stripslashes($lname)."<br>".
			"Email : ".stripslashes($email)."<br>".
			"Mobile : ".stripslashes($mobile)."<br>".
			"Office : ".stripslashes($officenumber)."<br>".
			"Company : ".stripslashes($company_name)."<br>".
			"Position : ".stripslashes($company_position)."<br>".
			"Company Description : ".stripslashes($company_description)."<br><br>".
			"<hr>".
			"Filled Date : ".$date_filled_up."<br>".
			"Job Order #".$job_order_id."<br>".
		"<a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran'>http://$site/portal/pdf_report/job_order_form/?ran=$ran</a><br>".
			"<b>Details</b><br><br>" .$details;
$subject = "REMOTESTAFF Job Specification Form Received [ ".stripslashes($fname)." ".stripslashes($lname)." ]";
$mail = new Zend_Mail();
$mail->setSubject($subject);
$mail->setBodyHtml(stripslashes($body));
$mail->setFrom('noreply@remotestaff.com.au', 'noreply');
if(! TEST){
	$mail->addTo('ricag@remotestaff.com.au' , 'Rica J.');
	$mail->addTo('applicants@remotestaff.com.au' , 'Applicants');
	if($business_partner_email){
		$mail->addTo($business_partner_email,$business_partner_name);
	}
	
}else{
	$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
}

$mail->send($transport);


echo $job_order_form_id;

/*
$message = $fname." ".$lname. " filled up the Job specification form date ".$date_filled_up." <a target=_blank href=http://$site/portal/pdf_report/job_order_form/?ran=$ran>http://$site/portal/pdf_report/job_order_form/?ran=$ran</a>" ;	
$query = "INSERT INTO sticky_notes SET  users_id = $business_partner_id, users_type = 'agent', date_created = '$ATZ', message = '$message' ";	
$result = mysql_query($query);
if(!$result) die ($query."<br>".mysql_error());

	$to = "chrisj@remotestaff.com.au,ricag@remotestaff.com.au,peterb@remotestaff.com.au";
	$subject = "REMOTESTAFF New Job Specification Form Received [ ".$fname." ".$lname." ]";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: info@remotestaff.com.au \r\n"."Reply-To: info@remotestaff.com.au\r\n";	
	$headers .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";
	$body = "A new Job order has been added for <br><br>".
			"Name : ".$fname." ".$lname."<br>".
			"Email : ".$email."<br>".
			"Mobile : ".$mobile."<br>".
			"Office : ".$officenumber."<br>".
			"Company : ".$company_name."<br>".
			"Position : ".$company_position."<br>".
			"Company Description : ".$company_description."<br><br>".
			"<hr>".
			"Filled Date : ".$date_filled_up."<br>".
			"Job Order #".$job_order_id."<br>".
		"<a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran'>http://$site/portal/pdf_report/job_order_form/?ran=$ran</a><br>".
			"<b>Details</b><br><br>" .$details;
	//echo $body;	
	mail($to,$subject, $body, $headers);

//Send a notification email to the  Client 	

	$to = $email;
	$subject = "REMOTESTAFF New Job Specification Form Requested [ ".$fname." ".$lname." ]";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: info@remotestaff.com.au \r\n"."Reply-To: info@remotestaff.com.au\r\n";
	$headers .= 'Bcc: normanm@remotestaff.com.au' . "\r\n";
	$body = "A new Job order has been requested for <br><br>".
			"Name : ".$fname." ".$lname."<br>".
			"Email : ".$email."<br>".
			"Filled Date : ".$date_filled_up."<br><br>".
			"Job Order #".$job_order_id."<br>".
		"<a href='http://$site/portal/pdf_report/job_order_form/?ran=$ran'>http://$site/portal/pdf_report/job_order_form/?ran=$ran</a><br>".
			"<b>Details</b><br><br>" .$details;
	//echo $body;	
	mail($to,$subject, $body, $headers);
	
	
	


echo $job_order_form_id;
*/
?>