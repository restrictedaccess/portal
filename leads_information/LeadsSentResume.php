<?php
function LeadsSentResume($leads_id){
		global $db;
	
		$host = $_SERVER['HTTP_HOST'];
		if($host == "localhost") {
			$host = "remotestaff.com.au";
			$path = "http://localhost/home_page/";
		}else{
			$path = "../";
		}	

		
		if($leads_id != ""){
		
			//get all resume sent by the admin or bp
			//id, admin_id, agent_id, userid, lead_id, position_id, status, date_added, final_Interview, comment
			$sql = $db->select()
				->from(array('s' => 'staff_resume_leads_sent') ,array('id', 'admin_id', 'agent_id', 'userid', 'lead_id', 'position_id', 'status', 'date_added', 'final_Interview', 'comment'))
				->join(array('p' => 'personal') , 'p.userid = s.userid' , array('fname' ,'lname'))
				->joinLeft(array('j' => 'job_sub_category') , ' j.sub_category_id = s.position_id' , array('sub_category_name'))
				->joinLeft(array('c' => 'job_category' ), 'c.category_id = j.category_id' , array('category_name'))
				->where('s.lead_id =?' , $leads_id );
			$resumes = $db->fetchAll($sql);
			$resume_result = "<ol>";
			foreach($resumes as $resume){
			
				$staff_name_link = sprintf("<a href=\"javascript:popup_win('".$path."available-staff-resume.php?userid=%s' , 700 , 800)\"><b>%s %s : %s</b></a>",$resume['userid'],$resume['fname'],$resume['lname'] ,$resume['userid'] );
				
				$resume_result .= "<li>";
					
					$resume_result .= $staff_name_link;
					
					if($resume['admin_id'] > 0){
						$sender = getCreator($resume['admin_id'],'admin');
					}else if($resume['agent_id'] > 0){
						$sender = getCreator($resume['agent_id'],'agent');
					}else{
						$sender = 'Unknown';
					}
					
						$resume_result .= "<ul>";
							$resume_result .= "<li>Date Sent :";
								$resume_result .= $resume['date_added'];	
							$resume_result .= "</li>";
							$resume_result .= "<li>Position / Category :";
								$resume_result .= $resume['sub_category_name']." / ".$resume['category_name'];	
							$resume_result .= "</li>";
							$resume_result .= "<li>Status :";
								$resume_result .= $resume['status'];	
							$resume_result .= "</li>";
							$resume_result .= "<li>Sent by :";
								$resume_result .= $sender;	
							$resume_result .= "</li>";
							
						$resume_result .= "</ul>";
				$resume_result .= "</li>";
					
			}
			$resume_result .= "</ol>";
			
				
		}
		return $resume_result;	
}
?>