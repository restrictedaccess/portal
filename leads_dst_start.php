<?php
include('conf/zend_smarty_conf.php');
$id = $_REQUEST["id"];
//get the csro of lead
if (!$id){
	echo "Lead id is required";
	die;
}
$lead = $db->fetchRow($db->select()->from(array("l"=>"leads"), array("csro_id", "fname"))->where("id = ?", $id));
if ($lead){
	
	if (TEST){
		$site = "devs.remotestaff.com.au";
	}else if (STAGING){
		$site = "staging.remotestaff.com.au";
	} else{
		$site = "remotestaff.com.au";
	}
	//echo $_SERVER["REMOTE_HOST"];
	$signature_notes = "";
	
	if($lead["csro_id"]){
		$sql=$db->select()
			->from('admin')
			->where('admin_id = ?' ,$lead["csro_id"]);
		$admin = $db->fetchRow($sql);
		//echo "<pre>";
		//print_r($admin);
		//exit;
		$agent_code = '101';
		$name = $admin['admin_fname'].' '.$admin['admin_lname'];
		$email = $admin['admin_email'];
		$template = "";
		if ($admin["signature_notes"]){
			$template.=$admin['signature_notes']."<br/>\n";
		}
		if ($name){
			$template.=$name."<br/>\n";
		}
		if ($admin["signature_company"]){
			$template.=$admin["signature_company"]."<br/>\n";
		}
		if ($admin["signature_contact_nos"]){
			$template.=$admin["signature_contact_nos"]."<br/>\n";
		}
		//if ($admin["signature_websites"]){
		//	$template.=$admin["signature_websites"]."<br/>\n";
		//}
		$signature_notes =  $template;
	}
	
	//$signature_template ="<a href='http://$site/$agent_code'>
	//			<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
	$signature_template .= "<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#999999;width:400px\">$signature_notes</p>";

	//echo $signature_template;
	//exit;
	$smarty = new Smarty();
	$smarty->assign("csro_signature_template", $signature_template);
	$smarty->assign("site", $site);
	$smarty->assign("fname", $lead["fname"]);
	echo $smarty->display("leads_dst_start.tpl");
	
}