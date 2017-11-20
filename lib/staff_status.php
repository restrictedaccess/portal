<?php
//2011-05-14  Roy Pepito <roy.pepito@remotestaff.com.au>

function staff_status($db, $admin_id, $userid, $status) 
{
	$datetime = date("Y-m-d")." ".date("H:i:s");
	switch($status)
	{
		case "UNPROCESSED":
			//start: remove from inactive_staff
			$where = "userid = ".$userid;	
			$db->delete('inactive_staff', $where);			
			//ended: remove from inactive_staff		
			
			//start: remove from pre-screened
			$where = "userid = ".$userid;	
			$db->delete('pre_screened_staff', $where);			
			//ended: remove from pre-screened
			
			//start: remove from shortlisted
			$where = "userid = ".$userid;	
			$db->delete('tb_shortlist_history', $where);			
			//ended: remove from shortlisted
			
			//start: remove from endorsed
			$where = "userid = ".$userid;
			$db->delete('tb_endorsement_history', $where);			
			//ended: remove from endorsed
			
			//start: remove from asl
			$where = "userid = ".$userid;
			$db->delete('job_sub_category_applicants', $where);			
			//ended: remove from asl	

			//start: resync on solr_candidates for full text search functionality
//			$where = "userid = ".$userid;
//			$db -> delete("solr_candidates", $where);
//							if(TEST){
//								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}else{
//								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}
			//end: resync on solr_candidates for full text search functionality
			break;
			
			
		case "PRE-SCREENED":
			//start: remove from unprocessed
			$where = "userid = ".$userid;	
			$db->delete('unprocessed_staff', $where);			
			//ended: remove from unprocessed
			
			//start: remove from inactive_staff
			$where = "userid = ".$userid;	
			$db->delete('inactive_staff', $where);			
			//ended: remove from inactive_staff 		
			//start: resync on solr_candidates for full text search functionality
//			$where = "userid = ".$userid;
//			$db -> delete("solr_candidates", $where);
//							if(TEST){
//								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}else{
//								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}
			//end: resync on solr_candidates for full text search functionality		
			break;
			
			
		case "INACTIVE":
			//start: remove from pre-screened
			// Changelogs: Remove deleting on Prescreened Candidates - 3-27-2015 @author Marlon 
			$where = "userid = ".$userid;	
			$db->delete('pre_screened_staff', $where); 		
			//ended: remove from pre-screened
			
			//start: remove from shortlisted
			/*
			$where = "userid = ".$userid;	
			$db->delete('tb_shortlist_history', $where);			
			//ended: remove from shortlisted */
			
			/*
			//start: remove from endorsed
			$where = "userid = ".$userid;
			$db->delete('tb_endorsement_history', $where);			
			//ended: remove from endorsed */
			
			//start: remove from endorsed
			$where = "userid = ".$userid;
			$db->delete('unprocessed_staff', $where);	
			//$db->update("tb_shortlist_history", array("feedback"=>"Candidate no longer available"), $where);
			
			/*
			//start: remove from asl
			$where = "userid = ".$userid;
			$db->delete('job_sub_category_applicants', $where);			
			*/
			
			
			//set no display to website
			$where = "userid = ".$userid;
			$db->update("job_sub_category_applicants", array("ratings"=>1), $where);
			//start: resync on solr_candidates for full text search functionality
//			$where = "userid = ".$userid;
//			$db -> delete("solr_candidates", $where);
//							if(TEST){
//								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}else{
//								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}
			//end: resync on solr_candidates for full text search functionality
			//ended: remove from asl		
			break;
			
			
		case "SHORTLISTED":
			//start: remove from unprocessed
			$where = "userid = ".$userid;	
			$db->delete('unprocessed_staff', $where);			
			//ended: remove from unprocessed
			
			//start: remove from prescreen
			$where = "userid = ".$userid;	
			$db->delete('pre_screened_staff', $where);			
			//ended: remove from prescreen
			
			//start: remove from inactive_staff
			$where = "userid = ".$userid;	
			$db->delete('inactive_staff', $where);

			//ended: remove from inactive_staff			
			//start: resync on solr_candidates for full text search functionality
//			$where = "userid = ".$userid;
//			$db -> delete("solr_candidates", $where);
//							if(TEST){
//								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}else{
//								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}
			//end: resync on solr_candidates for full text search functionality	
			break;
			
			
		case "ENDORSED":
			//start: remove from unprocessed
			$where = "userid = ".$userid;	
			$db->delete('unprocessed_staff', $where);			
			//ended: remove from unprocessed
			
			//start: remove from prescreen
			$where = "userid = ".$userid;	
			$db->delete('pre_screened_staff', $where);			
			//ended: remove from prescreen	
			
			//start: remove from inactive_staff
			$where = "userid = ".$userid;	
			$db->delete('inactive_staff', $where);			
			//ended: remove from inactive_staff		
			//start: resync on solr_candidates for full text search functionality
//			$where = "userid = ".$userid;
//			$db -> delete("solr_candidates", $where);
//							if(TEST){
//								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}else{
//								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}
			//end: resync on solr_candidates for full text search functionality		
			break;
			
			
		case "ASL":
			//start: remove from unprocessed
			$where = "userid = ".$userid;	
			$db->delete('unprocessed_staff', $where);			
			//ended: remove from unprocessed
			
			//start: remove from prescreen
			$where = "userid = ".$userid;	
			$db->delete('pre_screened_staff', $where);			
			//ended: remove from prescreen			
			
			//start: remove from inactive_staff
			$where = "userid = ".$userid;	
			$db->delete('inactive_staff', $where);			
			//ended: remove from inactive_staff		
			//start: resync on solr_candidates for full text search functionality
//			$where = "userid = ".$userid;
//			$db -> delete("solr_candidates", $where);
//							if(TEST){
//								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}else{
//								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}
			//end: resync on solr_candidates for full text search functionality		
			break;
			
			
		case "TRIAL":
			break;
			
			
		case "HIRED":
			//start: remove from pre-screened
			$where = "userid = ".$userid;	
			$db->delete('pre_screened_staff', $where);			
			//ended: remove from pre-screened
			
			//start: remove from shortlisted
			$where = "userid = ".$userid;	
			$db->delete('tb_shortlist_history', $where);			
			//ended: remove from shortlisted
			
			//start: remove from inactive_staff
			$where = "userid = ".$userid;	
			$db->delete('inactive_staff', $where);			
			//ended: remove from inactive_staff	
			
			//start: remove from endorsed
			$where = "userid = ".$userid;
			$db->delete('tb_endorsement_history', $where);			
			//ended: remove from endorsed
			
			//start: remove from asl
			$where = "userid = ".$userid;
			$db->delete('job_sub_category_applicants', $where);			
			//ended: remove from asl
			//start: resync on solr_candidates for full text search functionality
//			$where = "userid = ".$userid;
//			$db -> delete("solr_candidates", $where);
//							if(TEST){
//								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}else{
//								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
//							}
			//end: resync on solr_candidates for full text search functionality			
			break;
		default:
			break;
	}

	try{
		global $curl;
		if (TEST){
			$curl->get("http://devs.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
		}else{
			$curl->get("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
		}
	} catch(Exception $e){
		echo $e->__toString();
	}
//	if (TEST){
//		file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
//	}else{
//		file_get_contents("http://sc.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
//	}


}
?>
