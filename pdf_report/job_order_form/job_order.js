// JavaScript Document

var xmlHttp
//PATH ="pdf_report/job_order_form/";
PATH ="";

function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.fontWeight="700";
   obj.style.cursor='pointer';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.fontWeight="";
   obj.style.cursor='default';
}

function show_hide(id) 
{
	obj = document.getElementById(id);
	obj.style.display = (obj.style.display == "block") ? "none" : "block";
}
function hide(sid) 
{
   obj = document.getElementById(sid);
   obj.style.display = "none";
}
function hideJobForms(){
	document.getElementById("showForm").innerHTML="Please click one of the Job Specification Forms";	
}
function highlight_tab(tab_id){
	//alert(tab_id);
	
	tab_no = 12;
	var i;
	for(i=1; i<=tab_no; i++){
		if(tab_id == i){
			obj = document.getElementById(i);
			obj.style.backgroundColor='white';
			obj.style.fontWeight="700";
			obj.style.position ="relative";
			obj.style.top ="1px";
			
		}else{
			obj = document.getElementById(i);
			obj.style.backgroundColor='';
			obj.style.fontWeight="";
			obj.style.position ="";
			obj.style.top ="";
			

		}
	}
	
	//obj = document.getElementById(tab_id);
	//obj.style.backgroundColor= ( obj.style.backgroundColor== "yellow") ? "" : "yellow";
	//obj.style.fontWeight= (obj.style.fontWeight=="700") ? "" : "700";
}

function showJobOrderForms(job_order_form_id){
	document.getElementById("showForm").innerHTML = "Loading....";
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	
	highlight_tab(job_order_form_id);
	
	if(job_order_form_id == 1){
		var url=PATH+"AccountsBookkeeperJobOrderForm.php";
		
	}
	if(job_order_form_id == 2){
		var url=PATH+"ApplicationsDeveloperJobOrderForm.php";
	}
	
	if(job_order_form_id == 3){
		var url=PATH+"ContentWriterJobOrderForm.php";
	}
	
	if(job_order_form_id == 4){
		var url=PATH+"CustomerSupportJobOrderForm.php";
	}
	if(job_order_form_id == 5){
		var url=PATH+"DesignerJobOrderForm.php";
	}
	if(job_order_form_id == 6){
		var url=PATH+"DeveloperJobOrderForm.php";
	}
	if(job_order_form_id == 7){
		var url=PATH+"ITStaffJobOrderForm.php";
	}
	if(job_order_form_id == 8){
		var url=PATH+"SEOJobOrderForm.php";
	}
	if(job_order_form_id == 9){
		var url=PATH+"TechSupportJobOrderForm.php";
	}
	if(job_order_form_id == 10){
		var url=PATH+"TelemarketerJobOrderForm.php";
	}
	if(job_order_form_id == 11){
		var url=PATH+"VirtualAssistantJobOrderForm.php";
	}
	if(job_order_form_id == 12){
		var url=PATH+"OthersJobOrderForm.php";
	}
	
	
	
	url=url+"?job_order_id="+job_order_id;
	url=url+"&ran="+Math.random();
	
	//alert(url);
	xmlHttp.onreadystatechange=OnSuccessShowJobOrderForms;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
}

function OnSuccessShowJobOrderForms(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("showForm").innerHTML=xmlHttp.responseText;	
		showOrderList();
		
	}
}

function showOrderList(){
	job_order_id = document.getElementById("job_order_id").value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showOrderList.php";
	url=url+"?job_order_id="+job_order_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowOrderList;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessShowOrderList(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("order_list").innerHTML=xmlHttp.responseText;	
		higlightSelectedChosenTab();
	}
}

function higlightSelectedChosenTab(){
	tab = document.getElementById("tab").value;
	if(tab!=0){
		/*
		for(var i =0 ; i<tab.length; i++){
			if(tab.substr(i,1)!=","){
				id = (tab.substr(i,1));
				obj = document.getElementById(id);
				obj.style.backgroundColor='yellow';
				obj.style.fontWeight="700";
			}
		}
		*/
		var temp = new Array();
		temp = tab.split(" ");
		for(var i =0 ; i<temp.length; i++){
			if(temp[i]!=null && temp[i]!=" " && temp[i]!=""){
				id = temp[i];
				//alert(id);
				obj = document.getElementById(id);
				obj.style.backgroundColor='yellow';
				obj.style.fontWeight="700";
			}
			
		}
		
		
	}
	
	
	
}

function saveJobOrderForm(job_order_form_id){
	
	
	var job_order_id =  $("job_order_id").value;
	var no_of_staff =  $("no_of_staff").value;
	var staff_start_date =  $("staff_start_date").value;
	
	var duties_responsibilities = $("duties_responsibilities").value;
	var others = $("others").value;
	var additional_essentials = $("additional_essentials").value;
	var term_of_employment= $("term_of_employment").value;
	var notes = $("notes").value;
	var level_status = $("level_status").value;
	
	
	// leads info
	var leads_id = $("leads_id").value;
	var fname = $("fname").value;
	var lname = $("lname").value;
	var email = $("email").value;
	var mobile = $("mobile").value;
	var officenumber = $("officenumber").value;
	var company_name = $("company_name").value;
	var company_position = $("company_position").value;
	var used_rs = $("used_rs").value;
	var company_description = $("company_description").value;
	var company_industry = $("company_industry").value;
	var contact_person = $("contact_person").value;
	
	
	if(no_of_staff==""){
		alert("Please specify no. of staff");
		return false;
	}
	if(level_status=="-"){
		alert("Please select status level");
		return false;
	}
	
	
	var job_order_form_status = $("job_order_form_status").value;
	//alert(job_order_form_status);
		if($("ms_office_skill_rating")){
			var ms_office_skill_rating = $("ms_office_skill_rating").value;
		}
		if($("computer_skill_rating")){
			var computer_skill_rating = $("computer_skill_rating").value;
		}
		if($("invoicing_skill_rating")){
			var invoicing_skill_rating= $("invoicing_skill_rating").value;
		}
		if($("purchasing_skill_rating")){
			var purchasing_skill_rating= $("purchasing_skill_rating").value;
		}
		if($("payroll_skill_rating")){
			var payroll_skill_rating= $("payroll_skill_rating").value;
		}
		if($("acct_recon_skill_rating")){
			var acct_recon_skill_rating = $("acct_recon_skill_rating").value;
		}
		if($("debtor_skill_rating")){
			var debtor_skill_rating = $("debtor_skill_rating").value;
		}
		if($("creditor_acct_recon_skill_rating")){
			var creditor_acct_recon_skill_rating =$("creditor_acct_recon_skill_rating").value;
		}
		if($("creditor_analysis_skill_rating")){
			var creditor_analysis_skill_rating =$("creditor_analysis_skill_rating").value;
		}
		
		
		if($("general_ledger_skill_rating")){
			var general_ledger_skill_rating=$("general_ledger_skill_rating").value;
		}
		if($("knows_gst_skill_rating")){
			var knows_gst_skill_rating=$("knows_gst_skill_rating").value;
		}
		if($("bas_reporting_skill_rating")){
			var bas_reporting_skill_rating=$("bas_reporting_skill_rating").value;
		}
		if($("cash_flow_analysis_skill_rating")){
			var cash_flow_analysis_skill_rating=$("cash_flow_analysis_skill_rating").value;
		}
		if($("myob_skill_rating")){
			var myob_skill_rating=$("myob_skill_rating").value;
		}
		if($("sap_skill_rating")){
			var sap_skill_rating=$("sap_skill_rating").value;
		}
		if($("quickbooks_skill_rating")){
			var quickbooks_skill_rating=$("quickbooks_skill_rating").value;
		}
		if($("payg_skill_rating")){
			var payg_skill_rating=$("payg_skill_rating").value;
		}
		if($("payg_skill_rating")){
			var superannuation_skill_rating=$("payg_skill_rating").value;
		}
		if($("payroll_tax_skill_rating")){
			var payroll_tax_skill_rating=$("payroll_tax_skill_rating").value;
		}

	
		if($("html_skill_rating")){
			var html_skill_rating = $("html_skill_rating").value;
		}
		if($("xhtml_skill_rating")){
			var xhtml_skill_rating = $("xhtml_skill_rating").value;
		}
		if($("css_skill_rating")){
			var css_skill_rating= $("css_skill_rating").value;
		}
		if($("macromedia_skill_rating")){
			var macromedia_skill_rating= $("macromedia_skill_rating").value;
		}
		if($("wordpress_skill_rating")){
			var wordpress_skill_rating= $("wordpress_skill_rating").value;
		}
		if($("mambo_skill_rating")){
			var mambo_skill_rating = $("mambo_skill_rating").value;
		}
	
	
	
		if($("web_dev_html_skill_rating")){
			var web_dev_html_skill_rating = $("web_dev_html_skill_rating").value;
		}
		if($("web_dev_xhtml_skill_rating")){
			var web_dev_xhtml_skill_rating = $("web_dev_xhtml_skill_rating").value;
		}
		if($("web_dev_aspnet_skill_rating")){
			var web_dev_aspnet_skill_rating= $("web_dev_aspnet_skill_rating").value;
		}
		if($("web_dev_asp_skill_rating")){
			var web_dev_asp_skill_rating= $("web_dev_asp_skill_rating").value;
		}
		if($("web_dev_vbnet_skill_rating")){
			var web_dev_vbnet_skill_rating= $("web_dev_vbnet_skill_rating").value;
		}
		if($("web_dev_php_skill_rating")){
			var web_dev_php_skill_rating = $("web_dev_php_skill_rating").value;
		}
		if($("web_dev_javascript_skill_rating")){
			var web_dev_javascript_skill_rating = $("web_dev_javascript_skill_rating").value;
		}
		if($("web_dev_css_skill_rating")){
			var web_dev_css_skill_rating = $("web_dev_css_skill_rating").value;
		}
		if($("web_dev_iis_skill_rating")){
			var web_dev_iis_skill_rating = $("web_dev_iis_skill_rating").value;
		}
		if($("web_dev_flash_skill_rating")){
			var web_dev_flash_skill_rating = $("web_dev_flash_skill_rating").value;
		}
		if($("web_dev_xml_skill_rating")){
			var web_dev_xml_skill_rating = $("web_dev_xml_skill_rating").value;
		}
		if($("web_dev_ajax_skill_rating")){
			var web_dev_ajax_skill_rating = $("web_dev_ajax_skill_rating").value;
		}
		if($("web_dev_dreamweaver_skill_rating")){
			var web_dev_dreamweaver_skill_rating = $("web_dev_dreamweaver_skill_rating").value;
		}
		if($("web_dev_fireworks_skill_rating")){
			var web_dev_fireworks_skill_rating = $("web_dev_fireworks_skill_rating").value;
		}
		if($("web_dev_coldfusion_skill_rating")){
			var web_dev_coldfusion_skill_rating = $("web_dev_coldfusion_skill_rating").value;
		}
		if($("web_dev_actionscript_skill_rating")){
			var web_dev_actionscript_skill_rating = $("web_dev_actionscript_skill_rating").value;
		}
	
		
		if($("web_dev_access_skill_rating")){
			var web_dev_access_skill_rating= $("web_dev_access_skill_rating").value;
		}
		if($("web_dev_sqlserver_skill_rating")){
			var web_dev_sqlserver_skill_rating= $("web_dev_sqlserver_skill_rating").value;
		}
		if($("web_dev_mysql_skill_rating")){
			var web_dev_mysql_skill_rating= $("web_dev_mysql_skill_rating").value;
		}
		
		if($("web_dev_vb_skill_rating")){
			var web_dev_vb_skill_rating= $("web_dev_vb_skill_rating").value;
		}
		if($("web_dev_cnet_skill_rating")){
			var web_dev_cnet_skill_rating= $("web_dev_cnet_skill_rating").value;
		}
		
		if($("web_dev_wordpress_skill_rating")){
			var web_dev_wordpress_skill_rating= $("web_dev_wordpress_skill_rating").value;
		}
		if($("web_dev_mambojoomla_skill_rating")){
			var web_dev_mambojoomla_skill_rating= $("web_dev_mambojoomla_skill_rating").value;
		}
		if($("web_dev_phpbb_skill_rating")){
			var web_dev_phpbb_skill_rating= $("web_dev_phpbb_skill_rating").value;	
		}
		
		if($("web_dev_windows_skill_rating")){
			var web_dev_windows_skill_rating= $("web_dev_windows_skill_rating").value;
		}
		if($("web_dev_unixlinux_skill_rating")){
			var web_dev_unixlinux_skill_rating= $("web_dev_unixlinux_skill_rating").value;
		}
		
		if($("web_dev_windows_skill_rating")){
			var web_dev_msoffice_skill_rating= $("web_dev_windows_skill_rating").value;
		}
		if($("web_dev_photoshop_skill_rating")){
			var web_dev_photoshop_skill_rating= $("web_dev_photoshop_skill_rating").value;	
		}
		
		

		if($("it_dev_html_skill_rating")){
			var it_dev_html_skill_rating = $("it_dev_html_skill_rating").value;
		}
		if($("it_dev_xhtml_skill_rating")){
			var it_dev_xhtml_skill_rating = $("it_dev_xhtml_skill_rating").value;
		}
		if($("it_dev_aspnet_skill_rating")){
			var it_dev_aspnet_skill_rating= $("it_dev_aspnet_skill_rating").value;
		}
		if($("it_dev_asp_skill_rating")){
			var it_dev_asp_skill_rating= $("it_dev_asp_skill_rating").value;
		}
		if($("it_dev_vbnet_skill_rating")){
			var it_dev_vbnet_skill_rating= $("it_dev_vbnet_skill_rating").value;
		}
		if($("it_dev_php_skill_rating")){
			var it_dev_php_skill_rating = $("it_dev_php_skill_rating").value;
		}
		if($("it_dev_javascript_skill_rating")){
			var it_dev_javascript_skill_rating = $("it_dev_javascript_skill_rating").value;
		}
		if($("it_dev_css_skill_rating")){
			var it_dev_css_skill_rating = $("it_dev_css_skill_rating").value;
		}
		if($("it_dev_iis_skill_rating")){
			var it_dev_iis_skill_rating = $("it_dev_iis_skill_rating").value;
		}
		if($("it_dev_flash_skill_rating")){
			var it_dev_flash_skill_rating = $("it_dev_flash_skill_rating").value;
		}
		if($("it_dev_xml_skill_rating")){
			var it_dev_xml_skill_rating = $("it_dev_xml_skill_rating").value;
		}
		if($("it_dev_ajax_skill_rating")){
			var it_dev_ajax_skill_rating = $("it_dev_ajax_skill_rating").value;
		}
		if($("it_dev_dreamweaver_skill_rating")){
			var it_dev_dreamweaver_skill_rating = $("it_dev_dreamweaver_skill_rating").value;
		}
		if($("it_dev_fireworks_skill_rating")){
			var it_dev_fireworks_skill_rating = $("it_dev_fireworks_skill_rating").value;
		}
		if($("it_dev_coldfusion_skill_rating")){
			var it_dev_coldfusion_skill_rating = $("it_dev_coldfusion_skill_rating").value;
		}
		if($("it_dev_actionscript_skill_rating")){
			var it_dev_actionscript_skill_rating = $("it_dev_actionscript_skill_rating").value;
		}
	
		
		if($("it_dev_access_skill_rating")){
			var it_dev_access_skill_rating= $("it_dev_access_skill_rating").value;
		}
		if($("it_dev_sqlserver_skill_rating")){
			var it_dev_sqlserver_skill_rating= $("it_dev_sqlserver_skill_rating").value;
		}
		if($("it_dev_mysql_skill_rating")){
			var it_dev_mysql_skill_rating= $("it_dev_mysql_skill_rating").value;
		}
		
		if($("it_dev_vb_skill_rating")){
			var it_dev_vb_skill_rating= $("it_dev_vb_skill_rating").value;
		}
		if($("it_dev_cnet_skill_rating")){
			var it_dev_cnet_skill_rating= $("it_dev_cnet_skill_rating").value;
		}
		
		if($("it_dev_wordpress_skill_rating")){
			var it_dev_wordpress_skill_rating= $("it_dev_wordpress_skill_rating").value;
		}
		if($("it_dev_mambojoomla_skill_rating")){
			var it_dev_mambojoomla_skill_rating= $("it_dev_mambojoomla_skill_rating").value;
		}
		if($("it_dev_phpbb_skill_rating")){
			var it_dev_phpbb_skill_rating= $("it_dev_phpbb_skill_rating").value;	
		}
		
		if($("it_dev_windows_skill_rating")){
			var it_dev_windows_skill_rating= $("it_dev_windows_skill_rating").value;
		}
		if($("it_dev_unixlinux_skill_rating")){
			var it_dev_unixlinux_skill_rating= $("it_dev_unixlinux_skill_rating").value;
		}
		
		if($("it_dev_windows_skill_rating")){
			var it_dev_msoffice_skill_rating= $("it_dev_windows_skill_rating").value;
		}
		if($("it_dev_photoshop_skill_rating")){
			var it_dev_photoshop_skill_rating= $("it_dev_photoshop_skill_rating").value;	
		}
		//
		if($("seo_html_skill_rating")){
			var seo_html_skill_rating = $("seo_html_skill_rating").value;
		}
		if($("seo_site_analysis_skill_rating")){
			var seo_site_analysis_skill_rating = $("seo_site_analysis_skill_rating").value;
		}
		if($("seo_analytics_skill_rating")){
			var seo_analytics_skill_rating= $("seo_analytics_skill_rating").value;
		}
		if($("seo_link_building_skill_rating")){
			var seo_link_building_skill_rating= $("seo_link_building_skill_rating").value;
		}
		if($("seo_keyword_search_skill_rating")){
			var seo_keyword_search_skill_rating= $("seo_keyword_search_skill_rating").value;
		}
		if($("seo_google_adwords_skill_rating")){
			var seo_google_adwords_skill_rating = $("seo_google_adwords_skill_rating").value;
		}
		if($("seo_content_writing_skill_rating")){
			var seo_content_writing_skill_rating = $("seo_content_writing_skill_rating").value;
		}
		if($("seo_cms_skill_rating")){
			var seo_cms_skill_rating = $("seo_cms_skill_rating").value;
		}
		
		//app
				if($("app_dev_html_skill_rating")){
			var app_dev_html_skill_rating = $("app_dev_html_skill_rating").value;
		}
		if($("app_dev_xhtml_skill_rating")){
			var app_dev_xhtml_skill_rating = $("app_dev_xhtml_skill_rating").value;
		}
		if($("app_dev_aspnet_skill_rating")){
			var app_dev_aspnet_skill_rating= $("app_dev_aspnet_skill_rating").value;
		}
		if($("app_dev_asp_skill_rating")){
			var app_dev_asp_skill_rating= $("app_dev_asp_skill_rating").value;
		}
		if($("app_dev_vbnet_skill_rating")){
			var app_dev_vbnet_skill_rating= $("app_dev_vbnet_skill_rating").value;
		}
		if($("app_dev_php_skill_rating")){
			var app_dev_php_skill_rating = $("app_dev_php_skill_rating").value;
		}
		if($("app_dev_javascript_skill_rating")){
			var app_dev_javascript_skill_rating = $("app_dev_javascript_skill_rating").value;
		}
		if($("app_dev_css_skill_rating")){
			var app_dev_css_skill_rating = $("app_dev_css_skill_rating").value;
		}
		if($("app_dev_iis_skill_rating")){
			var app_dev_iis_skill_rating = $("app_dev_iis_skill_rating").value;
		}
		if($("app_dev_flash_skill_rating")){
			var app_dev_flash_skill_rating = $("app_dev_flash_skill_rating").value;
		}
		if($("app_dev_xml_skill_rating")){
			var app_dev_xml_skill_rating = $("app_dev_xml_skill_rating").value;
		}
		if($("app_dev_ajax_skill_rating")){
			var app_dev_ajax_skill_rating = $("app_dev_ajax_skill_rating").value;
		}
		if($("app_dev_dreamweaver_skill_rating")){
			var app_dev_dreamweaver_skill_rating = $("app_dev_dreamweaver_skill_rating").value;
		}
		if($("app_dev_fireworks_skill_rating")){
			var app_dev_fireworks_skill_rating = $("app_dev_fireworks_skill_rating").value;
		}
		if($("app_dev_coldfusion_skill_rating")){
			var app_dev_coldfusion_skill_rating = $("app_dev_coldfusion_skill_rating").value;
		}
		if($("app_dev_actionscript_skill_rating")){
			var app_dev_actionscript_skill_rating = $("app_dev_actionscript_skill_rating").value;
		}
	
		
		if($("app_dev_access_skill_rating")){
			var app_dev_access_skill_rating= $("app_dev_access_skill_rating").value;
		}
		if($("app_dev_sqlserver_skill_rating")){
			var app_dev_sqlserver_skill_rating= $("app_dev_sqlserver_skill_rating").value;
		}
		if($("app_dev_mysql_skill_rating")){
			var app_dev_mysql_skill_rating= $("app_dev_mysql_skill_rating").value;
		}
		
		if($("app_dev_vb_skill_rating")){
			var app_dev_vb_skill_rating= $("app_dev_vb_skill_rating").value;
		}
		if($("app_dev_cnet_skill_rating")){
			var app_dev_cnet_skill_rating= $("app_dev_cnet_skill_rating").value;
		}
		
		if($("app_dev_wordpress_skill_rating")){
			var app_dev_wordpress_skill_rating= $("app_dev_wordpress_skill_rating").value;
		}
		if($("app_dev_mambojoomla_skill_rating")){
			var app_dev_mambojoomla_skill_rating= $("app_dev_mambojoomla_skill_rating").value;
		}
		if($("app_dev_phpbb_skill_rating")){
			var app_dev_phpbb_skill_rating= $("app_dev_phpbb_skill_rating").value;	
		}
		
		if($("app_dev_windows_skill_rating")){
			var app_dev_windows_skill_rating= $("app_dev_windows_skill_rating").value;
		}
		if($("app_dev_unixlinux_skill_rating")){
			var app_dev_unixlinux_skill_rating= $("app_dev_unixlinux_skill_rating").value;
		}
		
		if($("app_dev_windows_skill_rating")){
			var app_dev_msoffice_skill_rating= $("app_dev_windows_skill_rating").value;
		}
		if($("app_dev_photoshop_skill_rating")){
			var app_dev_photoshop_skill_rating= $("app_dev_photoshop_skill_rating").value;	
		}
		
		//
		if($("campaign_type")){
			var campaign_type = $("campaign_type").value;
		}
		if($("primary_role")){
			var primary_role= $("primary_role").value;
		}
		if($("secondary_role")){
			var secondary_role= $("secondary_role").value;
		}
		
	
	var query = queryString({'job_order_form_id' : job_order_form_id , 'job_order_id' : job_order_id , 'no_of_staff' : no_of_staff, 'staff_start_date' : staff_start_date, 'duties_responsibilities' : duties_responsibilities ,'others' : others , 'additional_essentials' : additional_essentials , 'term_of_employment' : term_of_employment , 'notes' : notes , 'level_status' : level_status , 'leads_id' : leads_id , 'fname' : fname , 'lname' : lname ,  'email' : email , 'mobile' : mobile , 'officenumber' : officenumber , 'company_name' : company_name , 'company_position' : company_position , 'used_rs' : used_rs , 'company_description' : company_description , 'company_industry' : company_industry , 'contact_person' : contact_person , 'ms_office_skill_rating' : ms_office_skill_rating , 'computer_skill_rating' : computer_skill_rating , 'invoicing_skill_rating' : invoicing_skill_rating , 'purchasing_skill_rating' : purchasing_skill_rating , 'payroll_skill_rating' : payroll_skill_rating , 'acct_recon_skill_rating' : acct_recon_skill_rating , 'debtor_skill_rating' : debtor_skill_rating , 'creditor_acct_recon_skill_rating' : creditor_acct_recon_skill_rating , 'creditor_analysis_skill_rating' : creditor_analysis_skill_rating , 'general_ledger_skill_rating' : general_ledger_skill_rating , 'knows_gst_skill_rating' : knows_gst_skill_rating , 'bas_reporting_skill_rating' : bas_reporting_skill_rating , 'cash_flow_analysis_skill_rating' : cash_flow_analysis_skill_rating , 'myob_skill_rating' : myob_skill_rating , 'sap_skill_rating' : sap_skill_rating , 'quickbooks_skill_rating' : quickbooks_skill_rating , 'payg_skill_rating' : payg_skill_rating , 'superannuation_skill_rating' : superannuation_skill_rating , 'payroll_tax_skill_rating' : payroll_tax_skill_rating , 'html_skill_rating' : html_skill_rating , 'xhtml_skill_rating' : xhtml_skill_rating , 'css_skill_rating' : css_skill_rating , 'macromedia_skill_rating' : macromedia_skill_rating , 'wordpress_skill_rating' : wordpress_skill_rating , 'mambo_skill_rating' : mambo_skill_rating , 'web_dev_html_skill_rating' : web_dev_html_skill_rating , 'web_dev_xhtml_skill_rating' : web_dev_xhtml_skill_rating , 'web_dev_aspnet_skill_rating' : web_dev_aspnet_skill_rating , 'web_dev_asp_skill_rating' : web_dev_asp_skill_rating , 'web_dev_vbnet_skill_rating' : web_dev_vbnet_skill_rating , 'web_dev_php_skill_rating' : web_dev_php_skill_rating , 'web_dev_javascript_skill_rating' : web_dev_javascript_skill_rating , 'web_dev_css_skill_rating' : web_dev_css_skill_rating , 'web_dev_iis_skill_rating' : web_dev_iis_skill_rating , 'web_dev_flash_skill_rating' : web_dev_flash_skill_rating , 'web_dev_xml_skill_rating' : web_dev_xml_skill_rating , 'web_dev_ajax_skill_rating' : web_dev_ajax_skill_rating , 'web_dev_dreamweaver_skill_rating' : web_dev_dreamweaver_skill_rating , 'web_dev_fireworks_skill_rating' : web_dev_fireworks_skill_rating , 'web_dev_coldfusion_skill_rating' : web_dev_coldfusion_skill_rating , 'web_dev_actionscript_skill_rating' : web_dev_actionscript_skill_rating , 'web_dev_access_skill_rating' : web_dev_access_skill_rating , 'web_dev_sqlserver_skill_rating' : web_dev_sqlserver_skill_rating , 'web_dev_mysql_skill_rating' : web_dev_mysql_skill_rating , 'web_dev_vb_skill_rating' : web_dev_vb_skill_rating , 'web_dev_cnet_skill_rating' : web_dev_cnet_skill_rating , 'web_dev_wordpress_skill_rating' : web_dev_wordpress_skill_rating , 'web_dev_mambojoomla_skill_rating' : web_dev_mambojoomla_skill_rating , 'web_dev_phpbb_skill_rating' : web_dev_phpbb_skill_rating , 'web_dev_windows_skill_rating' : web_dev_windows_skill_rating , 'web_dev_unixlinux_skill_rating' : web_dev_unixlinux_skill_rating , 'web_dev_msoffice_skill_rating' : web_dev_msoffice_skill_rating , 'web_dev_photoshop_skill_rating' : web_dev_photoshop_skill_rating , 'it_dev_html_skill_rating' : it_dev_html_skill_rating , 'it_dev_xhtml_skill_rating' : it_dev_xhtml_skill_rating , 'it_dev_aspnet_skill_rating' : it_dev_aspnet_skill_rating , 'it_dev_asp_skill_rating' : it_dev_asp_skill_rating , 'it_dev_vbnet_skill_rating' : it_dev_vbnet_skill_rating , 'it_dev_php_skill_rating' : it_dev_php_skill_rating , 'it_dev_javascript_skill_rating' : it_dev_javascript_skill_rating , 'it_dev_css_skill_rating' : it_dev_css_skill_rating , 'it_dev_iis_skill_rating' : it_dev_iis_skill_rating , 'it_dev_flash_skill_rating' : it_dev_flash_skill_rating , 'it_dev_xml_skill_rating' : it_dev_xml_skill_rating , 'it_dev_ajax_skill_rating' : it_dev_ajax_skill_rating , 'it_dev_dreamweaver_skill_rating' : it_dev_dreamweaver_skill_rating , 'it_dev_fireworks_skill_rating' : it_dev_fireworks_skill_rating , 'it_dev_coldfusion_skill_rating' : it_dev_coldfusion_skill_rating , 'it_dev_actionscript_skill_rating' : it_dev_actionscript_skill_rating , 'it_dev_access_skill_rating' : it_dev_access_skill_rating , 'it_dev_sqlserver_skill_rating' : it_dev_sqlserver_skill_rating , 'it_dev_mysql_skill_rating' : it_dev_mysql_skill_rating , 'it_dev_vb_skill_rating' : it_dev_vb_skill_rating , 'it_dev_cnet_skill_rating' : it_dev_cnet_skill_rating , 'it_dev_wordpress_skill_rating' : it_dev_wordpress_skill_rating , 'it_dev_mambojoomla_skill_rating' : it_dev_mambojoomla_skill_rating , 'it_dev_phpbb_skill_rating' : it_dev_phpbb_skill_rating , 'it_dev_windows_skill_rating' : it_dev_windows_skill_rating , 'it_dev_unixlinux_skill_rating' : it_dev_unixlinux_skill_rating , 'it_dev_msoffice_skill_rating' : it_dev_msoffice_skill_rating , 'it_dev_photoshop_skill_rating' : it_dev_photoshop_skill_rating , 'seo_html_skill_rating' : seo_html_skill_rating , 'seo_site_analysis_skill_rating' : seo_site_analysis_skill_rating , 'seo_analytics_skill_rating' : seo_analytics_skill_rating , 'seo_link_building_skill_rating' : seo_link_building_skill_rating , 'seo_keyword_search_skill_rating' : seo_keyword_search_skill_rating , 'seo_google_adwords_skill_rating' : seo_google_adwords_skill_rating , 'seo_content_writing_skill_rating' : seo_content_writing_skill_rating , 'seo_cms_skill_rating' : seo_cms_skill_rating , 'app_dev_html_skill_rating' : app_dev_html_skill_rating , 'app_dev_xhtml_skill_rating' : app_dev_xhtml_skill_rating , 'app_dev_aspnet_skill_rating' : app_dev_aspnet_skill_rating , 'app_dev_asp_skill_rating' : app_dev_asp_skill_rating , 'app_dev_vbnet_skill_rating' : app_dev_vbnet_skill_rating , 'app_dev_php_skill_rating' : app_dev_php_skill_rating , 'app_dev_javascript_skill_rating' : app_dev_javascript_skill_rating , 'app_dev_css_skill_rating' : app_dev_css_skill_rating , 'app_dev_iis_skill_rating' : app_dev_iis_skill_rating , 'app_dev_flash_skill_rating' : app_dev_flash_skill_rating , 'app_dev_xml_skill_rating' : app_dev_xml_skill_rating , 'app_dev_ajax_skill_rating' : app_dev_ajax_skill_rating , 'app_dev_dreamweaver_skill_rating' : app_dev_dreamweaver_skill_rating , 'app_dev_fireworks_skill_rating' : app_dev_fireworks_skill_rating , 'app_dev_coldfusion_skill_rating' : app_dev_coldfusion_skill_rating , 'app_dev_actionscript_skill_rating' : app_dev_actionscript_skill_rating , 'app_dev_access_skill_rating' : app_dev_access_skill_rating , 'app_dev_sqlserver_skill_rating' : app_dev_sqlserver_skill_rating , 'app_dev_mysql_skill_rating' : app_dev_mysql_skill_rating , 'app_dev_vb_skill_rating' : app_dev_vb_skill_rating , 'app_dev_cnet_skill_rating' : app_dev_cnet_skill_rating , 'app_dev_wordpress_skill_rating' : app_dev_wordpress_skill_rating , 'app_dev_mambojoomla_skill_rating' : app_dev_mambojoomla_skill_rating , 'app_dev_phpbb_skill_rating' : app_dev_phpbb_skill_rating , 'app_dev_windows_skill_rating' : app_dev_windows_skill_rating , 'app_dev_unixlinux_skill_rating' : app_dev_unixlinux_skill_rating , 'app_dev_msoffice_skill_rating' : app_dev_msoffice_skill_rating , 'app_dev_photoshop_skill_rating' : app_dev_photoshop_skill_rating , 'campaign_type' : campaign_type , 'primary_role' : primary_role , 'secondary_role' : secondary_role});
	
	//alert(query);
	
	$('btn').value = "Processing...";
	$('btn').disabled = true;
	$('btnc').disabled = true;
	$('inf').style.display='block';
	
	var wd = 400;
	var hg = 100;
	
	var xpos = screen.availWidth/2 - wd/2; 
   	var ypos = screen.availHeight/2 - hg/2; 
	$('inf').style.left = xpos+"px";
	$('inf').style.top = ypos+"px";
	
	var result = doXHR(PATH + 'saveJobOrderOtherDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveJobOrderForm, OnFailSaveJobOrderForm);
	
	
	
}

function OnSuccessSaveJobOrderForm(e){
		/*
		job_order_form_id = xmlHttp.responseText;	
		//alert(job_order_form_id);
		if(job_order_form_id!="" || job_order_form_id!=NULL){
			showJobOrderForms(job_order_form_id);
		}
		alert("Job Specification Form Details has been saved! \nA notification message has been sent to RemoteStaff HR Department !");
		*/
		
		//for debugging purposes comment after using
		if(isNaN(e.responseText)){
			alert("If you see this error. Please contact the administrator or email us this error.\n\n\n"+e.responseText);
		}else{
			job_order_form_id = e.responseText;
			if(job_order_form_id!="" || job_order_form_id!=NULL){
				showJobOrderForms(job_order_form_id);
			}
			alert("Job Specification Form Details has been saved! \nA notification message has been sent to RemoteStaff HR Department !");
			$('inf').style.display='none';
		}
		//document.getElementById("showForm").innerHTML=e.responseText;	
		
	
}

function OnFailSaveJobOrderForm(e){
	alert("Failed to process the form");
}





function saveGeneralSkill(width){
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 1;
	job_requirement = document.getElementById("general_skill").value;
	rating = document.getElementById("general_skill_rating").value;
	groupings = "general";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'general','general_add_form');
}
function OnSuccessSaveGeneralSkill(width){
	if (xmlHttp.readyState==4)
	{
		hide('general_add_form');
		document.getElementById("general").innerHTML=xmlHttp.responseText;	
	}
}

function saveAccountsClerk(width){
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 1;
	job_requirement = document.getElementById("accounts_clerk_skill").value;
	rating = document.getElementById("accounts_clerk_skill_rating").value;
	groupings = "accounts_clerk";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'accounts_clerk','accounts_clerk_add_form');
}
function OnSuccessSaveAccountsClerkSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('accounts_clerk_add_form');
		document.getElementById("accounts_clerk").innerHTML=xmlHttp.responseText;	
	}
}


function saveAccountsReceivableSkill(width){
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 1;
	job_requirement = document.getElementById("accounts_receivable_skill").value;
	rating = document.getElementById("accounts_receivable_skill_rating").value;
	groupings = "accounts_receivable";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'accounts_receivable','accounts_receivable_add_form');
}
function OnSuccessSaveAccountsReceivableSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('accounts_receivable_add_form');
		document.getElementById("accounts_receivable").innerHTML=xmlHttp.responseText;	
	}
}

function saveAccountsPayableSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 1;
	job_requirement = document.getElementById("accounts_payable_skill").value;
	rating = document.getElementById("accounts_payable_skill_rating").value;
	groupings = "accounts_payable";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'accounts_payable','accounts_payable_add_form');
}

function OnSuccessSaveAccountsPayableSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('accounts_payable_add_form');
		document.getElementById("accounts_payable").innerHTML=xmlHttp.responseText;	
	}
}

function saveBookkeeperSkill(width){
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 1;
	job_requirement = document.getElementById("bookkeeper_skill").value;
	rating = document.getElementById("bookkeeper_skill_rating").value;
	groupings = "bookkeeper";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'bookkeeper','bookkeeper_add_form');
}
function OnSuccessSaveBookkeeperSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('bookkeeper_add_form');
		document.getElementById("bookkeeper").innerHTML=xmlHttp.responseText;	
	}
}

function saveAccountingPackage(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 1;
	job_requirement = document.getElementById("accounting_package_skill").value;
	rating = document.getElementById("accounting_package_skill_rating").value;
	groupings = "accounting_package";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'accounting_package','accounting_package_add_form');
}
function OnSuccessSaveAccountingPackage(){
	if (xmlHttp.readyState==4)
	{
		hide('accounting_package_add_form');
		document.getElementById("accounting_package").innerHTML=xmlHttp.responseText;	
	}
}
//
function savePayrollSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 1;
	job_requirement = document.getElementById("payroll_skill").value;
	rating = document.getElementById("payroll_skill_rate").value;
	groupings = "payroll";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'payroll','payroll_add_form');
}
function OnSuccessSavePayrollSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('payroll_add_form');
		document.getElementById("payroll").innerHTML=xmlHttp.responseText;	
	}
}

// Application Developer

function saveSystemsSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 2;
	job_requirement = document.getElementById("systems_skill").value;
	rating = document.getElementById("systems_skill_rating").value;
	groupings = "systems";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'systems','systems_add_form');
}
function OnSuccessSaveSystemsSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('systems_add_form');
		document.getElementById("systems").innerHTML=xmlHttp.responseText;	
	}
}

function saveDatabasesSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 2;
	job_requirement = document.getElementById("databases_skill").value;
	rating = document.getElementById("databases_skill_rating").value;
	groupings = "databases";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'databases','databases_add_form');
}
function OnSuccessSaveDatabasesSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('databases_add_form');
		document.getElementById("databases").innerHTML=xmlHttp.responseText;	
	}
}

function saveProgrammingLanguagesSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 2;
	job_requirement = document.getElementById("programming_languages_skill").value;
	rating = document.getElementById("programming_languages_skill_rating").value;
	groupings = "programming_languages";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'programming_languages','programming_languages_add_form');
}
function OnSuccessSaveProgrammingLanguagesSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('programming_languages_add_form');
		document.getElementById("programming_languages").innerHTML=xmlHttp.responseText;	
	}
}
function saveOpenSourceSoftwareSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 2;
	job_requirement = document.getElementById("open_source_software_skill").value;
	rating = document.getElementById("open_source_software_skill_rating").value;
	groupings = "open_source_software";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'open_source_software','open_source_software_add_form');
}

function OnSuccessSaveOpenSourceSoftwareSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('open_source_software_add_form');
		document.getElementById("open_source_software").innerHTML=xmlHttp.responseText;	
	}
}

function savePlatformsEnvironmentsSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 2;
	job_requirement = document.getElementById("platforms_environments_skill").value;
	rating = document.getElementById("platforms_environments_skill_rating").value;
	groupings = "platforms_environments";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'platforms_environments','platforms_environments_add_form');
}

function OnSuccessSavePlatformsEnvironmentsSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('platforms_environments_add_form');
		document.getElementById("platforms_environments").innerHTML=xmlHttp.responseText;	
	}

}

function savePcDesktopProductsSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 2;
	job_requirement = document.getElementById("pc_desktop_products_skill").value;
	rating = document.getElementById("pc_desktop_products_skill_rating").value;
	groupings = "pc_desktop_products";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'pc_desktop_products','pc_desktop_products_add_form');
}

function OnSuccessSavePcDesktopProductsSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('pc_desktop_products_add_form');
		document.getElementById("pc_desktop_products").innerHTML=xmlHttp.responseText;	
	}

}

function saveMultimediaSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 2;
	job_requirement = document.getElementById("multimedia_skill").value;
	rating = document.getElementById("multimedia_skill_rating").value;
	groupings = "multimedia";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'multimedia','multimedia_add_form');
}

function OnSuccessSaveMultimediaSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('multimedia_add_form');
		document.getElementById("multimedia").innerHTML=xmlHttp.responseText;	
	}

}

function saveTechnicalAndNonTechnicalSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 3;
	job_requirement = document.getElementById("technical_and_non_technical_skill").value;
	rating = document.getElementById("technical_and_non_technical_skill_rating").value;
	groupings = "technical_and_non_technical";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'technical_and_non_technical','technical_and_non_technical_add_form');
}

function OnSuccessSaveTechnicalAndNonTechnicalSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('technical_and_non_technical_add_form');
		document.getElementById("technical_and_non_technical").innerHTML=xmlHttp.responseText;	
	}

}

function saveCustomerSupportTechnicalAndNonTechnicalSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 4;
	job_requirement = document.getElementById("customer_support_technical_and_non_technical_skill").value;
	rating = document.getElementById("customer_support_technical_and_non_technical_skill_rating").value;
	groupings = "customer_support_technical_and_non_technical";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'customer_support_technical_and_non_technical','customer_support_technical_and_non_technical_add_form');
}

function OnSuccessSaveCustomerSupportTechnicalAndNonTechnicalSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('customer_support_technical_and_non_technical_add_form');
		document.getElementById("customer_support_technical_and_non_technical").innerHTML=xmlHttp.responseText;	
	}

}

function saveWebOpenSystemsSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 5;
	job_requirement = document.getElementById("web_open_systems_skill").value;
	rating = document.getElementById("web_open_systems_skill_rating").value;
	groupings = "web_open_systems";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'web_open_systems','web_open_systems_add_form');
}

function OnSuccessSaveWebOpenSystemsSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('web_open_systems_add_form');
		document.getElementById("web_open_systems").innerHTML=xmlHttp.responseText;	
	}

}


function saveWebSystemsSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 6;
	job_requirement = document.getElementById("web_systems_skill").value;
	rating = document.getElementById("web_systems_skill_rating").value;
	groupings = "web_systems";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'web_systems','web_systems_add_form');
}
function OnSuccessSaveWebSystemsSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('web_systems_add_form');
		document.getElementById("web_systems").innerHTML=xmlHttp.responseText;	
	}
}

function saveWebDatabasesSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 6;
	job_requirement = document.getElementById("web_databases_skill").value;
	rating = document.getElementById("web_databases_skill_rating").value;
	groupings = "web_databases";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'web_databases','web_databases_add_form');
}
function OnSuccessSaveWebDatabasesSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('web_databases_add_form');
		document.getElementById("web_databases").innerHTML=xmlHttp.responseText;	
	}
}


function saveWebProgrammingLanguagesSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 6;
	job_requirement = document.getElementById("web_programming_languages_skill").value;
	rating = document.getElementById("web_programming_languages_skill_rating").value;
	groupings = "web_programming_languages";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'web_programming_languages','web_programming_languages_add_form');
}
function OnSuccessSaveWebProgrammingLanguagesSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('web_programming_languages_add_form');
		document.getElementById("web_programming_languages").innerHTML=xmlHttp.responseText;	
	}
}
function saveWebOpenSourceSoftwareSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 6;
	job_requirement = document.getElementById("web_open_source_software_skill").value;
	rating = document.getElementById("web_open_source_software_skill_rating").value;
	groupings = "web_open_source_software";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'web_open_source_software','web_open_source_software_add_form');
}

function OnSuccessSaveWebOpenSourceSoftwareSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('web_open_source_software_add_form');
		document.getElementById("web_open_source_software").innerHTML=xmlHttp.responseText;	
	}
}

function saveWebPlatformsEnvironmentsSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 6;
	job_requirement = document.getElementById("web_platforms_environments_skill").value;
	rating = document.getElementById("web_platforms_environments_skill_rating").value;
	groupings = "web_platforms_environments";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'web_platforms_environments','web_platforms_environments_add_form');
}

function OnSuccessSaveWebPlatformsEnvironmentsSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('web_platforms_environments_add_form');
		document.getElementById("web_platforms_environments").innerHTML=xmlHttp.responseText;	
	}

}

function saveWebPcDesktopProductsSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 6;
	job_requirement = document.getElementById("web_pc_desktop_products_skill").value;
	rating = document.getElementById("web_pc_desktop_products_skill_rating").value;
	groupings = "web_pc_desktop_products";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'web_pc_desktop_products','web_pc_desktop_products_add_form');
}

function OnSuccessSaveWebPcDesktopProductsSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('web_pc_desktop_products_add_form');
		document.getElementById("web_pc_desktop_products").innerHTML=xmlHttp.responseText;	
	}

}


function saveWebMultimediaSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 6;
	job_requirement = document.getElementById("web_multimedia_skill").value;
	rating = document.getElementById("web_multimedia_skill_rating").value;
	groupings = "web_multimedia";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'web_multimedia','web_multimedia_add_form');
}

function OnSuccessSaveWebMultimediaSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('web_multimedia_add_form');
		document.getElementById("web_multimedia").innerHTML=xmlHttp.responseText;	
	}

}

function saveITSystemsSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 7;
	job_requirement = document.getElementById("it_systems_skill").value;
	rating = document.getElementById("it_systems_skill_rating").value;
	groupings = "it_systems";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'it_systems','it_systems_add_form');
}
function OnSuccessSaveITSystemsSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('it_systems_add_form');
		document.getElementById("it_systems").innerHTML=xmlHttp.responseText;	
	}
}

function saveITDatabasesSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 7;
	job_requirement = document.getElementById("it_databases_skill").value;
	rating = document.getElementById("it_databases_skill_rating").value;
	groupings = "it_databases";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'it_databases','it_databases_add_form');
}
function OnSuccessSaveITDatabasesSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('it_databases_add_form');
		document.getElementById("it_databases").innerHTML=xmlHttp.responseText;	
	}
}


function saveITProgrammingLanguagesSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 7;
	job_requirement = document.getElementById("it_programming_languages_skill").value;
	rating = document.getElementById("it_programming_languages_skill_rating").value;
	groupings = "it_programming_languages";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'it_programming_languages','it_programming_languages_add_form');
}
function OnSuccessSaveITProgrammingLanguagesSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('it_programming_languages_add_form');
		document.getElementById("it_programming_languages").innerHTML=xmlHttp.responseText;	
	}
}
function saveITOpenSourceSoftwareSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 7;
	job_requirement = document.getElementById("it_open_source_software_skill").value;
	rating = document.getElementById("it_open_source_software_skill_rating").value;
	groupings = "it_open_source_software";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'it_open_source_software','it_open_source_software_add_form');
}

function OnSuccessSaveITOpenSourceSoftwareSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('it_open_source_software_add_form');
		document.getElementById("it_open_source_software").innerHTML=xmlHttp.responseText;	
	}
}

function saveITPlatformsEnvironmentsSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 7;
	job_requirement = document.getElementById("it_platforms_environments_skill").value;
	rating = document.getElementById("it_platforms_environments_skill_rating").value;
	groupings = "it_platforms_environments";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'it_platforms_environments','it_platforms_environments_add_form');
}

function OnSuccessSaveITPlatformsEnvironmentsSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('it_platforms_environments_add_form');
		document.getElementById("it_platforms_environments").innerHTML=xmlHttp.responseText;	
	}

}

function saveITPcDesktopProductsSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 7;
	job_requirement = document.getElementById("it_pc_desktop_products_skill").value;
	rating = document.getElementById("it_pc_desktop_products_skill_rating").value;
	groupings = "it_pc_desktop_products";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'it_pc_desktop_products','it_pc_desktop_products_add_form');
}

function OnSuccessSaveITPcDesktopProductsSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('it_pc_desktop_products_add_form');
		document.getElementById("it_pc_desktop_products").innerHTML=xmlHttp.responseText;	
	}

}


function saveITMultimediaSkill(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 7;
	job_requirement = document.getElementById("it_multimedia_skill").value;
	rating = document.getElementById("it_multimedia_skill_rating").value;
	groupings = "it_multimedia";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'it_multimedia','it_multimedia_add_form');
}

function OnSuccessSaveITMultimediaSkill(){
	if (xmlHttp.readyState==4)
	{
		hide('it_multimedia_add_form');
		document.getElementById("it_multimedia").innerHTML=xmlHttp.responseText;	
	}

}

function saveSEOSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 8;
	job_requirement = document.getElementById("seo_skill").value;
	rating = document.getElementById("seo_skill_rating").value;
	groupings = "seo";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'seo','seo_add_form');
}

function OnSuccessSaveSEOSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('seo_add_form');
		document.getElementById("seo").innerHTML=xmlHttp.responseText;	
	}

}
function saveTecSupportSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 9;
	job_requirement = document.getElementById("tech_support_skill").value;
	rating = document.getElementById("tech_support_skill_rating").value;
	groupings = "tech_support";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'tech_support','tech_support_add_form');
}

function OnSuccessSaveTecSupportSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('tech_support_add_form');
		document.getElementById("tech_support").innerHTML=xmlHttp.responseText;	
	}

}

function saveTelemarketerSkills(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 10;
	job_requirement = document.getElementById("telemarketer_skill").value;
	rating = document.getElementById("telemarketer_skill_rating").value;
	groupings = "telemarketer";
	
	if(job_requirement == ""){
		alert("Please enter Skill required !");
		return false;
	}
	if(rating == ""){
		alert("Please enter Ratings of the Skill !");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'telemarketer','telemarketer_add_form');
}

function OnSuccessSavetelemarketerSkills(){
	if (xmlHttp.readyState==4)
	{
		hide('telemarketer_add_form');
		document.getElementById("telemarketer").innerHTML=xmlHttp.responseText;	
	}

}

function saveTelemarketerTimeSched(width){
	
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id = 10;
	job_requirement = document.getElementById("time_sched_skill").value;
	rating = 0;//document.getElementById("telemarketer_skill_rating").value;
	groupings = "time_sched";
	
	if(job_requirement == ""){
		alert("Please enter Staff Time Schedule!");
		return false;
	}
	
	SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,'time_sched','time_sched_add_form');
}

function OnSuccessSaveTelemarketerTimeSched(){
	if (xmlHttp.readyState==4)
	{
		hide('time_sched_add_form');
		document.getElementById("time_sched").innerHTML=xmlHttp.responseText;	
	}

}
////
function deleteJobOrderDetails(job_order_details_id,groupings,width,job_order_form_id){
	if(job_order_details_id==""){
		alert("Job Specification Details Id is Missing !");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	job_order_id =  document.getElementById("job_order_id").value;
	
	
	var url=PATH+"deleteJobOrderDetails.php";
	url=url+"?job_order_id="+job_order_id;
	url=url+"&job_order_details_id="+job_order_details_id;
	url=url+"&job_order_form_id="+job_order_form_id;
	url=url+"&groupings="+groupings;
	url=url+"&width="+width;
	url=url+"&ran="+Math.random();
	if(groupings == "general"){
		xmlHttp.onreadystatechange=OnSuccessSaveGeneralSkill;
	}
	if (groupings == "accounts_clerk"){
		xmlHttp.onreadystatechange=OnSuccessSaveAccountsClerkSkill;
	}
	if (groupings == "accounts_receivable"){
		xmlHttp.onreadystatechange=OnSuccessSaveAccountsReceivableSkill;
	}
	if (groupings == "accounts_payable"){
		xmlHttp.onreadystatechange=OnSuccessSaveAccountsPayableSkill;
	}
	if (groupings == "bookkeeper"){
		xmlHttp.onreadystatechange=OnSuccessSaveBookkeeperSkill;
	}
	if (groupings == "accounting_package"){
		xmlHttp.onreadystatechange=OnSuccessSaveAccountingPackage;
	}
	if (groupings == "payroll"){
		xmlHttp.onreadystatechange=OnSuccessSavePayrollSkill;
	}
	if (groupings == "systems"){
		xmlHttp.onreadystatechange=OnSuccessSaveSystemsSkill;
	}
	if (groupings == "databases"){
		xmlHttp.onreadystatechange=OnSuccessSaveDatabasesSkill;
	}
	if (groupings == "programming_languages"){
		xmlHttp.onreadystatechange=OnSuccessSaveProgrammingLanguagesSkill;
	}
	
	if (groupings == "open_source_software"){
		xmlHttp.onreadystatechange=OnSuccessSaveOpenSourceSoftwareSkill;
	}
	if (groupings == "platforms_environments"){
		xmlHttp.onreadystatechange=OnSuccessSavePlatformsEnvironmentsSkill;
	}
	if (groupings == "pc_desktop_products"){
		xmlHttp.onreadystatechange=OnSuccessSavePcDesktopProductsSkills;
	}
	if (groupings == "multimedia"){
		xmlHttp.onreadystatechange=OnSuccessSaveMultimediaSkill;
	}
	if (groupings == "technical_and_non_technical"){
		xmlHttp.onreadystatechange=OnSuccessSaveTechnicalAndNonTechnicalSkills;
	}
	if (groupings == "customer_support_technical_and_non_technical"){
		xmlHttp.onreadystatechange=OnSuccessSaveCustomerSupportTechnicalAndNonTechnicalSkills;
	}
	if (groupings == "web_open_systems"){
		xmlHttp.onreadystatechange=OnSuccessSaveWebOpenSystemsSkills;
	}
	if (groupings == "web_systems"){
		xmlHttp.onreadystatechange=OnSuccessSaveWebSystemsSkill;
	}
	if (groupings == "web_databases"){
		xmlHttp.onreadystatechange=OnSuccessSaveWebDatabasesSkill;
	}
	if (groupings == "web_programming_languages"){
		xmlHttp.onreadystatechange=OnSuccessSaveWebProgrammingLanguagesSkill;
	}
	if (groupings == "web_open_source_software"){
		xmlHttp.onreadystatechange=OnSuccessSaveWebOpenSourceSoftwareSkill;
	}
	if (groupings == "web_platforms_environments"){
		xmlHttp.onreadystatechange=OnSuccessSaveWebPlatformsEnvironmentsSkill;
	}
	if (groupings == "web_pc_desktop_products"){
		xmlHttp.onreadystatechange=OnSuccessSaveWebPcDesktopProductsSkills;
	}
	if (groupings == "web_multimedia"){
		xmlHttp.onreadystatechange=OnSuccessSaveWebMultimediaSkill;
	}
	if (groupings == "it_open_systems"){
		xmlHttp.onreadystatechange=OnSuccessSaveITOpenSystemsSkills;
	}
	if (groupings == "it_systems"){
		xmlHttp.onreadystatechange=OnSuccessSaveITSystemsSkill;
	}
	if (groupings == "it_databases"){
		xmlHttp.onreadystatechange=OnSuccessSaveITDatabasesSkill;
	}
	if (groupings == "it_programming_languages"){
		xmlHttp.onreadystatechange=OnSuccessSaveITProgrammingLanguagesSkill;
	}
	if (groupings == "it_open_source_software"){
		xmlHttp.onreadystatechange=OnSuccessSaveITOpenSourceSoftwareSkill;
	}
	if (groupings == "it_platforms_environments"){
		xmlHttp.onreadystatechange=OnSuccessSaveITPlatformsEnvironmentsSkill;
	}
	if (groupings == "it_pc_desktop_products"){
		xmlHttp.onreadystatechange=OnSuccessSaveITPcDesktopProductsSkills;
	}
	if (groupings == "it_multimedia"){
		xmlHttp.onreadystatechange=OnSuccessSaveITMultimediaSkill;
	}
	if (groupings == "seo"){
		xmlHttp.onreadystatechange=OnSuccessSaveSEOSkills;
	}
	if (groupings == "tech_support"){
		xmlHttp.onreadystatechange=OnSuccessSaveTecSupportSkills;
	}
	if (groupings == "telemarketer"){
		xmlHttp.onreadystatechange=OnSuccessSavetelemarketerSkills;
	}
	if (groupings == "time_sched"){
		xmlHttp.onreadystatechange=OnSuccessSaveTelemarketerTimeSched;
	}
	
	
	
	
	
	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}



function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	  {
  		// Firefox, Opera 8.0+, Safari
		  xmlHttp=new XMLHttpRequest();
	  }
	catch (e)
	  {
		  // Internet Explorer
		  try
	      {
		    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	      }
         catch (e)
    	 {
		    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
         }
      }
return xmlHttp;
}
