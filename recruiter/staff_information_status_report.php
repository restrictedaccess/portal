<?php
include('../config.php') ;
include('../conf.php') ;
include('../conf/zend_smarty_conf_root.php');

$status = $_REQUEST["status"];
$userid = $_REQUEST["userid"];
$admin_id = $_REQUEST["admin_id"];
?>
<table width="100%" cellpadding="1" cellspacing="0" border="0" bgcolor=#CCCCCC id="staff_information_applicant_status">
	<tr>
    	<td>
            <table width="100%" cellpadding="3" cellspacing="3" border="0" bgcolor=#FFFFCC>
                <tr bgcolor="#FFFFFF">
                    <td width="100%" align="left" valign="top"><div class="hiresteps"><table width="100%"><tr><td><font color="#003366"><strong>Staff Status History</strong></font></td><td align="right"><a href='javascript: staff_information_status_report_exit(); '><img src="../../portal/images/closelabel.gif" border="0" /></a></td></tr></table></div></td>
                </tr>
                <tr>
                    <td valign="top">
						<table width="100%" bgcolor="#FFFFCC" cellspacing="1" cellpadding="1">
							<tr>
								<td width="0%" align="left" valign="top" class="td_info td_la">#</td>
								<td width="40%" align="left" valign="top" class="td_info td_la">Recruiter</td>
								<td width="40%" align="left" valign="top" class="td_info td_la" width="">Status</td>
                                <td width="20%" align="left" valign="top" class="td_info td_la">Date</td>
							</tr>	
							<?php
							$counter = 0;
							$sql1 = $db->select()
										->from(array("s"=>"subcontractors"),
												 array(new Zend_Db_Expr("CONCAT('HIRED') AS status"),
												 		 "date_contracted AS date",
												 		  "s.id AS link_id",
														  "CONCAT('') AS admin_fname",
														  "CONCAT('') AS admin_lname"))
										->where("s.userid = ?", $userid);
							$q ="SELECT ap.status, ap.date, ap.link_id, a.admin_fname, a.admin_lname FROM applicant_status ap, admin a WHERE a.admin_id = ap.admin_id AND ap.personal_id = '$userid'";
							$sql = $db->select()->union(array($sql1, $q))->order("date DESC");
							$result = $db->fetchAll($sql);
							foreach($result as $r)
							{
								$date = new Zend_Date($r['date'], 'YYYY-MM-dd HH:mm:ss');								
								
								$status = "";
								if ($r["link_id"]){
									//validate link id if not exist continue
									if ($r["status"]=="ENDORSED"&&!is_null($r["link_id"])){
										$endorsement = $db->fetchRow($db->select()->from(array("end"=>"tb_endorsement_history"), array("id"))->where("id = ?", $r["link_id"]));
										if (!$endorsement){
											continue;
										}
									}else if ($r["status"]=="SHORTLISTED"&&!is_null($r["link_id"])){
										$shortlist = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"), array("id"))->where("id = ?", $r["link_id"]));	
										if (!$shortlist){
											continue;		
										}
									}
									
									
									if ($r["status"]=="ASL"){
										$sql = $db->select()
												->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.id AS job_sub_category_applicants_id", "jsca.ratings AS ratings"))
												->joinInner(array("subcat"=>"job_sub_category"), "subcat.sub_category_id = jsca.sub_category_id", array("subcat.sub_category_name", "subcat.sub_category_id"))
												->joinInner(array("cat"=>"job_category"), "cat.category_id = jsca.category_id", array("cat.category_name", "cat.category_id", "cat.status"))
												->where("jsca.id = ?", $r["link_id"]);
										$asl = $db->fetchRow($sql);
										$displayed = "Displayed";
										if ($asl["ratings"]=="1"){
											$displayed = "Not Displayed";
										}
										
										//$status = "<span class='delete_status' data-link-id='{$asl["job_sub_category_applicants_id"]}' data-link-type='asl' style='margin-left:-15px;cursor:pointer;text-decoration:underline'>X</span>&nbsp;&nbsp;".$r["status"]." ({$asl["category_name"]}, $displayed, {$asl["sub_category_name"]})";
										$status = $r["status"]." ({$asl["category_name"]}, $displayed, {$asl["sub_category_name"]})";
									}else if ($r["status"]=="ENDORSED"){
										
										$sql =  $db->select()
												->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid", "end.date_endoesed AS date", "end.rejected"))											
												->joinInner(array("pos"=>"posting"), "pos.id = end.position", array("pos.id AS posting_id", "pos.jobposition AS job_title"))			
												->joinInner(array("l"=>"leads"), "l.id = end.client_name", array("CONCAT(l.fname, ' ', l.lname) AS client", "l.id AS lead_id"))
												->where("end.id = ?", $r["link_id"]);
										$endorsement = $db->fetchRow($sql);
										if  ($endorsement["job_title"]!=""){
											$clientLink = "<a href='/portal/leads_information.php?id={$endorsement["lead_id"]}' target='_blank'>{$endorsement["client"]}</a>";
											if ($endorsement["rejected"]==1){
												$status = $r["status"]." To ".$clientLink.", ".$endorsement["job_title"]." <span style='color:#ff0000'>[rejected]</span>";											
											}else{
												$status = $r["status"]." To ".$clientLink.", ".$endorsement["job_title"]."";	
											}
													
										}else{
											$sql =  $db->select()
												->from(array("end"=>"tb_endorsement_history"), array("end.userid AS userid", "end.date_endoesed AS date", "end.rejected"))		
												->joinInner(array("l"=>"leads"), "l.id = end.client_name", array("CONCAT(l.fname, ' ', l.lname) AS client", "l.id AS lead_id"))
												->joinInner(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = end.job_category", array("jsc.sub_category_name AS sub_category_name"))												
												->where("end.id = ?", $r["link_id"]);
											$endorsement = $db->fetchRow($sql);
											$clientLink = "<a href='/portal/leads_information.php?id={$endorsement["lead_id"]}' target='_blank'>{$endorsement["client"]}</a>";
											if ($endorsement["rejected"]==1){
												$status = $r["status"]." To ".$clientLink.", ".$endorsement["sub_category_name"]." <span style='color:#ff0000'>[rejected]</span>";
											}else{
												$status = $r["status"]." To ".$clientLink.", ".$endorsement["sub_category_name"]."";
											}			
										}
										
									}else if ($r["status"]=="SHORTLISTED"){
										$sql = $db->select()
										   ->from(array("sh"=>"tb_shortlist_history"),
										   		array("sh.userid AS userid", "sh.date_listed AS date", "sh.id AS shortlist_id"))
										   	->joinInner(array("pos"=>"posting"), "pos.id = sh.position", array("pos.id AS posting_id", "pos.jobposition AS job_title"))	
										  	->joinInner(array("l"=>"leads"), "l.id = pos.lead_id", array("CONCAT(l.fname, ' ', l.lname) AS client", "l.id AS lead_id"))
										     ->where("sh.id = ?", $r["link_id"])
										     ->where("sh.status = 'ACTIVE'")
										     ->group("sh.id");
										$shortlist = $db->fetchRow($sql);		
										$clientLink = "<a href='/portal/leads_information.php?id={$shortlist["lead_id"]}' target='_blank'>{$shortlist["client"]}</a>";								
										//$status = "<span class='delete_status' data-link-id='{$shortlist["shortlist_id"]}' data-link-type='shortlisted' style='margin-left:-15px;cursor:pointer;text-decoration:underline'>X</span>&nbsp;&nbsp;".$r["status"]." to {$shortlist["job_title"]}, {$clientLink}";
										$status = $r["status"]." to {$shortlist["job_title"]}, {$clientLink}";
									
									}else if ($r["status"]=="HIRED"){
										$row = $db->fetchRow($db->select()->
												from(array("s"=>"subcontractors"), array("s.leads_id", "s.userid", "s.work_status"))
												->joinLeft(array("l"=>"leads"), "l.id = s.leads_id", array("l.fname", "l.lname"))
												->where("s.id = ?", $r["link_id"]));
										$lead_name = $row["fname"]." ".$row["lname"];
										
										
										$history = $db->fetchRow($db->select()->from(array("sh"=>"subcontractors_history"), array())
																->joinLeft(array("adm"=>"admin"), "adm.admin_id = sh.change_by_id", array("admin_fname", "admin_lname"))
																->where("sh.subcontractors_id = ?", $r["link_id"])
																->where("sh.changes_status = 'new'")
																->limit(1)
																);
										if ($history){
											$r["admin_fname"] = $history["admin_fname"];
											$r["admin_lname"] = $history["admin_lname"];
												
										}
										
										
										$status = $r["status"]." ".$row["work_status"]." by <a href='/portal/leads_information.php?id={$row["leads_id"]}'>".$lead_name."</a>";
									}else{
										$status = $r["status"];
									}
								}else{
									
									$status = $r["status"];
								}
								$counter++;
							?>                            
							<tr>
								<td align="left" valign="top" class="td_info td_la"><?php echo $counter; ?></td>
								<?php
								if ($r['admin_fname'].' '.$r['admin_lname']=="RSSC Server"){
									?>
									<td align="left" valign="top" class="td_info">SYSTEM</td>
									<?php
								}else{?>
									<td align="left" valign="top" class="td_info"><?php echo $r['admin_fname'].' '.$r['admin_lname']; ?></td>
								<?php
								}?>
								<td align="left" valign="top" class="td_info"><?php echo $status; ?></td>
                                <td align="left" valign="top" class="td_info"><?php echo $date; ?></td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>                                    