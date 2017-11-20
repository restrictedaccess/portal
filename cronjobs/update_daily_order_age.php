<?php
include '../conf/zend_smarty_conf.php';

ini_set('memory_limit', '-1');
try{
	$retries = 0;
	while(true){
		try{
			if (TEST){
				$mongo = new MongoClient(MONGODB_TEST);
				$database = $mongo->selectDB('prod');
			}else{
				$mongo = new MongoClient(MONGODB_SERVER);
				$database = $mongo->selectDB('prod');
			}
			break;
		} catch(Exception $e){
			++$retries;
			
			if($retries >= 100){
				break;
			}
		}
		
	}
		
	$job_orders_collection = $database->selectCollection('job_orders');
	$cursor = $job_orders_collection->find([], [
	    "date_filled_up" => true,
        "tracking_code" => true
    ]);
	
	
	
	while($cursor->hasNext()){
		$result = $cursor->getNext();
		/**
		$now = strtotime(date("Y-m-d"));
		$date_filled_up = $result["date_filled_up"]->sec;
		$datediff = $now - $date_filled_up;
     	$age = floor($datediff/(60*60*24))+1;
		
		 */ 
		
		$start = new DateTime(date("Y-m-d", $result["date_filled_up"] -> sec));
		$end = new DateTime();
		// otherwise the  end date is excluded (bug?)
		$end->modify('+1 day');
        $start->modify("+1 day");

		$interval = $end->diff($start);

		// total days
		$days = $interval->days;

		// create an iterateable period of date (P1D equates to 1 day)
		$period = new DatePeriod($start, new DateInterval('P1D'), $end);

		// best stored as array, so you can add more than one
		//$holidays = array('2012-09-07');

		foreach($period as $dt) {
		    $curr = $dt->format('D');
		    //echo $dt->format("Y-m-d") . " " . $result["tracking_code"] . "<br />";

		    // for the updated question
		    /**
		    if (in_array($dt->format('Y-m-d'), $holidays)) {
		       $days--;
		    }
			 *
			 */

		    // substract if Saturday or Sunday
		    if ($curr == 'Sat' || $curr == 'Sun') {
                --$days;
		    }
		}


		//echo $days; // 4

		$age = intval($days);

		//echo $age;
		
		$job_orders_collection->update(array("tracking_code"=>$result["tracking_code"]), array('$set'=>array("age"=>$age)));
	}

}catch(Exception $e){
	echo $e->__toString();
}
