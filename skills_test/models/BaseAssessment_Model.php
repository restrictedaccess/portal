<?php

/* AssessmentList.php 2013-05-30 $ -msl */

class BaseAssessment_Model {
    
	
	public function getAPIURL(){
		/*
		$base_api_url = $base_api_url = "http://test.api.remotestaff.com.au";
		
		if (!TEST){
			$base_api_url = "https://api.remotestaff.com.au";
		}
		 * 
		 */
		
		global $base_api_url;
		
		
		
		return $base_api_url;
	}
	
	
	public function syncTestToMongo(){
		
		$curl->get($this->getAPIURL() . "/mongo-index/sync-all-candidates?userid=" . $_SESSION["userid"]);
		
	}
	
}



?>