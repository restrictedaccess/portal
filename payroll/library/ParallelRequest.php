<?php
// Class to run parallel GET requests and return the value
class ParallelRequest {
	private $mh = NULL;
	private $ch = array();
	private $urls = array();
	
	function __construct($urls) {
		//session_start();
		$this->urls = $urls;
		// Create get requests for URL
		$this->mh = curl_multi_init();		
		
		$options = array(CURLOPT_RETURNTRANSFER => true,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_MAXREDIRS => 5,
						CURLOPT_SSL_VERIFYHOST => false,
						CURLOPT_SSL_VERIFYPEER => false);
		
		foreach($this->urls as $i => $url) {
			$this->ch[$i] = curl_init();//$url);
			$options[CURLOPT_URL] = $url;
			curl_setopt_array($this->ch[$i], $options);
			//curl_setopt($this->ch[$i], CURLOPT_RETURNTRANSFER, 1);
			curl_multi_add_handle($this->mh, $this->ch[$i]);
		}
	}
  
	public function run() {
		// Start request
		$result = array();
		do {
			$execReturnValue = curl_multi_exec($this->mh, $runningHandles);
		} while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
		// process the request
		while ($runningHandles && $execReturnValue == CURLM_OK) {
			// Wait here
			$numberReady = curl_multi_select($this->mh);
			if ($numberReady != -1) {
				// get any new data
				do {
					$execReturnValue = curl_multi_exec($this->mh, $runningHandles);
				} while ($execReturnValue == CURLM_CALL_MULTI_PERFORM);
			}
		}

		// Check for any errors
		if ($execReturnValue != CURLM_OK) {
			trigger_error("Curl multi read error $execReturnValue\n", E_USER_WARNING);
		}

		// fetch the content
		foreach($this->urls as $i => $url) {
			// Check for errors
			$curlError = curl_error($this->ch[$i]);
			if($curlError == "") {
				$output = curl_multi_getcontent($this->ch[$i]);
				preg_match('/\&userid\=(\d+)\&(.*)/', $url, $match);
				$userid = $match[1];
				$result[$userid] = $output;
			} else {
				print "Curl error on handle $i: $curlError\n";
			}
			// Remove and close the handle
			curl_multi_remove_handle($this->mh, $this->ch[$i]);
			curl_close($this->ch[$i]);
		}
		// Clean up the curl_multi handle
		curl_multi_close($this->mh);
    
		// Print the return data
		return $result;
	}

}