<?php
/**
 * Controller for some functions use system wide
 * 
 * @author Normaneil E. Macutay <normanm@remotestaff.com.au>
 * @version 0.0.1
 * 
 */

ini_set("memory_limit", -1);
Zend_Loader::loadClass("BaseController", array(CONTROLLERS_PATH));
class UtilitiesController extends BaseController {
	
	/*
	 * Method in displaying RS active company numbers
	 * /utilities/rs-company-phone-numbers
	 * */
	public function rsCompanyPhoneNumbersAction(){
		Zend_Loader::loadClass("PhoneNumbers",array(COMPONENTS_PATH));		
		echo json_encode(array( "success" => true, "result" => PhoneNumbers::showPhoneNumbers() ));
		exit;
	}
	
	/*
	 * Method in getting currency rate and calculating the percentage or margin based setup
	 * @url /utilities/check-invoice-type/?invoice_type=margin&currency=GBP&work_status=Full-Time&salary=0.00&staff_currency=PHP
	 * @param string $invoice_type.
	 * @param string $currency
	 * @param string $work_status.
	 * @param string $salary.
	 * @param string $staff_curnency.
	 * @param int $margin_value
	 * return array of result
	 * */
	public function checkInvoiceTypeAction(){
		$db = Zend_Registry::get("main_db");
		//initialize Validation
		$validator_digit = new Zend_Validate_Digits();
		$validator_float = new Zend_Validate_Float();
		$validator_not_empty = new Zend_Validate_NotEmpty();
		
		
		$invoice_type = $_REQUEST["invoice_type"];
		$currency = $_REQUEST["currency"];
		$work_status = $_REQUEST["work_status"];
		$salary = $_REQUEST["salary"];
		$staff_currency = $_REQUEST["staff_currency"];
		$margin_value = $_REQUEST["margin_value"];
		
		
		
		if (!$validator_not_empty -> isValid($salary)) {
			$errors[] = "Missing Staff Salary.";
		}
		
		if (!$validator_not_empty -> isValid($work_status)) {
			$errors[] = "Missing work status.";
		}
		
		if (!$validator_not_empty -> isValid($invoice_type)) {
			$errors[] = "Missing Invoice Type.";
		}
		
		if (!$validator_not_empty -> isValid($currency)) {
			$errors[] = "Missing Currency.";
		}
		
		if (!$validator_not_empty -> isValid($staff_currency)) {
			$errors[] = "Missing Staff Currency.";
		}
		
		if (!($validator_digit -> isValid($salary) || $validator_float -> isValid($salary))) {
			$errors[] = "Staff Salary is not a valid value";
		}
		
		if (!in_array($currency, array("AUD", "GBP", "USD")) ){
			$errors[]= "Unknown client currency";
			
		}
		
		if (!in_array($staff_currency, array("PHP", "INR")) ){
			$errors[]= "Unknown staff currency";
			
		}
		
		if($margin_value){
			if (!($validator_digit -> isValid($margin_value) || $validator_float -> isValid($margin_value))) {
				$errors[] = "Margin value is not a valid value";
			}
		}
		
		if(!empty($errors)){
			echo json_encode(array("success" => false, "errors" => $errors));
			exit;
		}
		
		
		$curl = Zend_Registry::get('main_curl');
        $base_api_url = Zend_Registry::get('base_api_url');
        $margin =0.00;
		
		$days = 5;
		$working_hours = 8;
		$quoted_price=0.00;
		$new_quoted_price = 0.00;
		
		if($work_status == "Part-Time"){
			$working_hours = 4;
		}else{
			$working_hours = 8;
		}
		
		//Current currency rates
		Zend_Loader::loadClass("Utilities",array(COMPONENTS_PATH));
		$current_currency_rates = Utilities::getCurrencyRates();
		
				
		if($staff_currency == 'INR'){    		
			$CURRENCY_RATES = $current_currency_rates["INR_RATES"];
		}else{
    		$CURRENCY_RATES = $current_currency_rates["PHP_RATES"];			
		}
		
		
		//Calculate the quoted_price
		$quoted_price = $salary / $CURRENCY_RATES[$currency];
		
		$client_price = array(
	        'yearly' =>  $quoted_price * 12 ,
		    'monthly' =>  $quoted_price ,
		    'weekly' =>  ($quoted_price * 12) / 52 ,
		    'daily' =>  (($quoted_price * 12) / 52) / $days ,
		    'hourly' => ((($quoted_price * 12) / 52) / $days) / $working_hours ,
	    );
		
		
		
		
		
		//echo $invoice_type." ".$currency;
		if($invoice_type == "percentage"){
			
			if($margin_value){
				$margin = $margin_value;
			}else{
				//Get the percentage based setup
				$result = json_decode($curl->get($base_api_url."/system-wide/get-percentage-by-currency/?currency={$currency}"), true);
				if($result["success"]){
					$margin = $result["result"]["percent"];
				}	
			}
			
			
			$percentage_value = Utilities::getPercentage( floatval($margin) , floatval($client_price["hourly"]) );			
			$new_hourly_rate = floatval($client_price["hourly"]) + floatval($percentage_value);			
			$new_quoted_price = ( $new_hourly_rate * $working_hours ) * 22;
			 	
		}else{
			//Get current margins
			$result_margins = json_decode($curl->get($base_api_url."/system-wide/get-margins/"), true);
			$margins = array();
			foreach($result_margins["result"]["margins"] as $margin){
				$margins[$margin["key"]] = $margin["value"];
			}
	                
			
			$FULLTIME_MARGINS = Array('AUD' => floatval($margins["fulltime_margin_aud"]), 'USD' => floatval($margins["fulltime_margin_usd"]), 'GBP' => floatval($margins["fulltime_margin_gbp"]));
			$PARTTIME_MARGINS = Array('AUD' => floatval($margins["parttime_margin_aud"]), 'USD' => floatval($margins["parttime_margin_usd"]), 'GBP' => floatval($margins["parttime_margin_gbp"]));
			
			
			//New margin rate if Staff Salary is below 20k
			$NEW_FULLTIME_MARGINS = Array('AUD' => floatval($margins["fulltime_margin_below_20_thousand_aud"]), 'USD' => floatval($margins["fulltime_margin_below_20_thousand_usd"]), 'GBP' => floatval($margins["fulltime_margin_below_20_thousand_gbp"]));
			
			
			//New margin part-time rate if Staff Salary is below 14k
			$NEW_PARTTIME_MARGINS_FOR_14k_BELOW = Array('AUD' => floatval($margins["parttime_margin_below_14_thousand_aud"]), 'USD' => floatval($margins["parttime_margin_below_14_thousand_usd"]), 'GBP' => floatval($margins["parttime_margin_below_14_thousand_gbp"]));
			
			if($work_status == 'Full-Time'){
				if($salary < 20000){				    
				    $margin = $NEW_FULLTIME_MARGINS[$currency];
			    }else{				
					$margin = $FULLTIME_MARGINS[$currency];
				}
				
			}else{
				if($salary < 14000){
					$margin = $NEW_PARTTIME_MARGINS_FOR_14k_BELOW[$currency];				    					
			    }else{
			    	$margin = $PARTTIME_MARGINS[$currency];					
				}
			}
			
			
			$new_quoted_price = ( $quoted_price + $margin ) ;
			
		}
		
		
		
		
		
		
		$data = array(
			"work_status" => $work_status,
			"margin" => $margin,
			"invoice_type" => $invoice_type,
			"quoted_price" => Utilities::formatPrice( $new_quoted_price )
		);
		
		echo json_encode(array("success" => true, "result" => $data));
		exit;
		
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		//exit;
		
		
	}
	
	/*
	 * Method in breaking down of client quoted price
	 * @url /utilities/breakdown-client-price/?quoted_price=1000&work_status=Full-Time&currency=GBP
	 * return string
	 *
	 */
	 
	public function breakdownClientPriceAction()	{
		$db = Zend_Registry::get("main_db");
		if(!$_REQUEST["work_status"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Staff work status is missing."));
            exit;
		}
		
		
		if(!$_REQUEST["currency"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Client currency is missing."));
            exit;
		}
		
		
		$quoted_price = $_REQUEST["quoted_price"];
		if(!$quoted_price){
			$quoted_price = 0;
		}
		
		$work_status = $_REQUEST["work_status"];
		$currency = $_REQUEST["currency"];
		$days = 5;
		$working_hours = 8;
		
		if($work_status == "Part-Time"){
			$working_hours = 4;
		}else{
			$working_hours = 8;
		}
		
		Zend_Loader::loadClass("Utilities",array(COMPONENTS_PATH));
		
		$sql = $db->select()
    		->from('currency_lookup')
    		->where('code =?', $currency);
		$currency_lookup = $db->fetchRow($sql);
		
		//Client Configured Price
		$data = array(
	        'yearly' => Utilities::formatPrice( $quoted_price * 12 ),
		    'monthly' => Utilities::formatPrice( $quoted_price ),
		    'weekly' => Utilities::formatPrice( ($quoted_price * 12) / 52 ),
		    'daily' => Utilities::formatPrice( (($quoted_price * 12) / 52) / $days ),
		    'hourly' => Utilities::formatPrice( ((($quoted_price * 12) / 52) / $days) / $working_hours ),
		    'currency' => $currency,
		    'sign' => $currency_lookup['sign']
	    );
		
		echo json_encode(array('success' => true ,'result' => $data ));
        exit;
			
	}
	
	
	/**
	 * Method in breaking down of staff salary and converting it to different currencies rate.
	 * @url /utilities/breakdown-salary/?salary=18000&work_status=Full-Time&staff_currency=PHP
	 *  return string
	 * */
	public function breakdownSalaryAction()	{
		
		$db = Zend_Registry::get("main_db");
		//if(!$_REQUEST["salary"]){
		//	echo json_encode(array('success' => false ,'msg' => "Error : Staff salary cannot be null."));
        //    exit;
		//}
		
		if(!$_REQUEST["work_status"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Staff work status is missing."));
            exit;
		}
		
		
		if(!$_REQUEST["staff_currency"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Staff currency is missing."));
            exit;
		}
		
		$curl = Zend_Registry::get('main_curl');
        $base_api_url = Zend_Registry::get('base_api_url');
		
		//Get current margins
		$result_margins = json_decode($curl->get($base_api_url."/system-wide/get-margins/"), true);
		$margins = array();
		foreach($result_margins["result"]["margins"] as $margin){
			$margins[$margin["key"]] = $margin["value"];
		}
                
		
		$FULLTIME_MARGINS = Array('AUD' => floatval($margins["fulltime_margin_aud"]), 'USD' => floatval($margins["fulltime_margin_usd"]), 'GBP' => floatval($margins["fulltime_margin_gbp"]));
		$PARTTIME_MARGINS = Array('AUD' => floatval($margins["parttime_margin_aud"]), 'USD' => floatval($margins["parttime_margin_usd"]), 'GBP' => floatval($margins["parttime_margin_gbp"]));
		
		
		//New margin rate if Staff Salary is below 20k
		$NEW_FULLTIME_MARGINS = Array('AUD' => floatval($margins["fulltime_margin_below_20_thousand_aud"]), 'USD' => floatval($margins["fulltime_margin_below_20_thousand_usd"]), 'GBP' => floatval($margins["fulltime_margin_below_20_thousand_gbp"]));
		//$NEW_PARTTIME_MARGINS = Array('AUD' => 150, 'USD' => 150, 'GBP' => 91.5);
		
		//New margin part-time rate if Staff Salary is below 14k
		$NEW_PARTTIME_MARGINS_FOR_14k_BELOW = Array('AUD' => floatval($margins["parttime_margin_below_14_thousand_aud"]), 'USD' => floatval($margins["parttime_margin_below_14_thousand_usd"]), 'GBP' => floatval($margins["parttime_margin_below_14_thousand_gbp"]));

		
		Zend_Loader::loadClass("Utilities",array(COMPONENTS_PATH));
		
		
		//Current currency rates
		$current_currency_rates = Utilities::getCurrencyRates();
		$staff_currency = $_REQUEST["staff_currency"];
				
		if($staff_currency == 'INR'){    		
			$CURRENCY_RATES = $current_currency_rates["INR_RATES"];
		}else{
    		$CURRENCY_RATES = $current_currency_rates["PHP_RATES"];			
		}
		
		
		$staff_salary = $_REQUEST["salary"];
		if(!$staff_salary){
			$staff_salary = 0;
		}
		$work_status = $_REQUEST["work_status"];
		$days = 5;
		$working_hours = 8;
		
		if($work_status == "Part-Time"){
			$working_hours = 4;
		}else{
			$working_hours = 8;
		}
		
		$quote_price=array();

		
		//Staff Configured Salary
		$sql = $db->select()
    		->from('currency_lookup')
    		->where('code =?', $staff_currency);
		$currency_lookup = $db->fetchRow($sql);
		
		$data = array(
	        'yearly' => Utilities::formatPrice( $staff_salary * 12 ),
		    'monthly' => Utilities::formatPrice( $staff_salary ),
		    'weekly' => Utilities::formatPrice( ($staff_salary * 12) / 52 ),
		    'daily' => Utilities::formatPrice( (($staff_salary * 12) / 52) / $days ),
		    'hourly' => Utilities::formatPrice( ((($staff_salary * 12) / 52) / $days) / $working_hours ),
		    'currency' => $staff_currency,
		    'sign' => $currency_lookup['sign']
	    );
	    
	    
		
		//$quote_price["STAFF"]=$data;
		$quote_price[]=$data;
		
		foreach(array_keys($CURRENCY_RATES) as $code){
			//echo $code." => ".$CURRENCY_RATES[$code]."<br>";
			
			$salary = $staff_salary / $CURRENCY_RATES[$code];		
			
			$sql = $db->select()
	    		->from('currency_lookup')
	    		->where('code =?', $code);
			$currency_lookup = $db->fetchRow($sql);
			
			$data = array(
		        'yearly' => Utilities::formatPrice( $salary * 12 ),
			    'monthly' => Utilities::formatPrice( $salary ),
			    'weekly' => Utilities::formatPrice( ($salary * 12) / 52 ),
			    'daily' => Utilities::formatPrice( (($salary * 12) / 52) / $days ),
			    'hourly' => Utilities::formatPrice( ((($salary * 12) / 52) / $days) / $working_hours ),
			    'currency' => $code,
			    'currency_rate' => $CURRENCY_RATES[$code],
			    'sign' => $currency_lookup['sign']
	    	);
			
			if($_REQUEST['work_status'] == 'Full-Time'){
				if($_REQUEST['salary'] < 20000){
				    $data['margin'] = array("margin_type" => "Full-Time", "rate" => $NEW_FULLTIME_MARGINS[$code]); 
			    }else{
					$data['margin'] = array("margin_type" => "Full-Time", "rate" => $FULLTIME_MARGINS[$code]);
				}
				
			}else{
				if($_REQUEST['salary'] < 14000){				    
					$data['margin'] = array("margin_type" => "Part-Time", "rate" => $NEW_PARTTIME_MARGINS_FOR_14k_BELOW[$code]);
			    }else{
					$data['margin'] = array("margin_type" => "Part-Time", "rate" => $PARTTIME_MARGINS[$code]);
				}
			}
			
			
			//$quote_price[$code]=$data;
			$quote_price[]=$data;
		}
    
		
		
		echo json_encode(array('success' => true ,'result' => $quote_price, 'staff_salary' => Utilities::formatPrice( $staff_salary )  ));
        exit;
		
		
		echo "<pre>";
		print_r($CURRENCY_RATES);
		echo "<hr>";
		print_r($quote_price);
		echo "</pre>";		
		exit;
	}
	
	/*
	 * Method in converting time. Depending on the mode of conversion
	 * @url /utilities/configure-time/?staff_timezone=Asia%2FManila&work_start=08%3A00%3A00&work_status=Full-Time&client_timezone=Australia%2FSydney&client_start_work_hour=08%3A00%3A00&mode=staff
	 * @param string staff_timezone. Staff timezone ["Asia/Manila", "Asia/Kolkota"]
	 * @param time work_start. Staff start working hours.
	 * @param string work_status. Staff Work status must be ["Full-Time", "Part-Time"]
	 * @param string client_timezone. Client preffered working timezone.
	 * @param time client_start_work_hour. Client preffered start working time.
	 * @param string mode. Mode of convertion of time. ["staff", "client"]
	 * return string.
	 * */
	public function configureTimeAction(){
		
		if(!$_REQUEST["staff_timezone"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Staff timezone is missing."));
            exit;
		}
		
		if(!$_REQUEST["work_start"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Staff start work hour is missing."));
            exit;
		}
		
		if(!$_REQUEST["work_status"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Staff work status is missing."));
            exit;
		}
		
		if(!$_REQUEST["client_timezone"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Client timezone is missing."));
            exit;
		}
		
		if(!$_REQUEST["client_start_work_hour"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Client preffered start work hour is missing."));
            exit;
		}
		
		if(!$_REQUEST["mode"]){
			echo json_encode(array('success' => false ,'msg' => "Error : Mode of time conversion is missing."));
            exit;
		}
		
		Zend_Loader::loadClass("Utilities",array(COMPONENTS_PATH));
		
		$hour=9;
		if($_REQUEST["work_status"]== "Part-Time"){
			$hour="+4 hours";	
		}else{
			$hour="+9 hours";
		}
		
		if($_REQUEST["mode"] == "staff"){
			$work_start = $_REQUEST["work_start"];
			$client_start_work_hour = Utilities::convertTimezones($_REQUEST["staff_timezone"], $_REQUEST["client_timezone"] , $work_start);	
		}else{
			$client_start_work_hour = $_REQUEST["client_start_work_hour"];
			$work_start = Utilities::convertTimezones($_REQUEST["client_timezone"], $_REQUEST["staff_timezone"] , $client_start_work_hour);	
		}
		
		
		$work_start = sprintf("%s %s", date("Y-m-d"), $work_start);
		$client_start_work_hour = sprintf("%s %s", date("Y-m-d"), $client_start_work_hour);
		
		$work_finished =  date('H:i:s', strtotime("{$hour}",strtotime($work_start)));
		$client_finish_work_hour =  date('H:i:s', strtotime("{$hour}",strtotime($client_start_work_hour)));
		
		$data = array(
			"work_start" => date("H:i:s", strtotime($work_start)) ,		
			"work_finished" => $work_finished,
			"client_start_work_hour" => date("H:i:s", strtotime($client_start_work_hour)) ,
			"client_finish_work_hour" => $client_finish_work_hour
		);
		
		
		echo json_encode(array('success' => true ,'result' => $data));
        exit;
		
		
	}
	
	/*
	 * Method in getting all endorsed and interviewed candidates to leads
	 * @url /utilities/get-endorsed-interviewed-candidates/?leads_id=11500
	 * @param int $leads_id. Remotestaff DB leads.id 
	 * 
	 */	 
	public function getEndorsedInterviewedCandidatesAction(){
		if(!$_REQUEST["leads_id"]){            
            echo json_encode(array('success' => false ,'msg' => "Leads Id is missing."));
            exit;       
        }
		Zend_Loader::loadClass("LeadsEndorsedInterviewedCandidates",array(COMPONENTS_PATH));
		$applicants = LeadsEndorsedInterviewedCandidates::getEndorsedInterviewedCandidate($_REQUEST["leads_id"]);
		
		echo json_encode(array('success' => true , 'applicants' => $applicants ));
        exit;
	}
    
}
