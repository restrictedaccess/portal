<?php
session_start();
	include('../conf/zend_smarty_conf.php');
	if (!isset($_SESSION["userids_booking"])){
		$_SESSION["userids_booking"] = array();
	}
	if (!isset($_SESSION["tracking_codes_booking"])){
		$_SESSION["tracking_codes_booking"] = array();
	}
	//START: order session validator
	$uncheck_id = $_REQUEST["uncheck_id"];
	if(isset($uncheck_id))
	{
		$newList = array();
		foreach($_SESSION["userids_booking"] as $bookedUser){
			if ($bookedUser!=$uncheck_id){
				$newList[] = $bookedUser;
			}
		}
		
		$_SESSION["userids_booking"] = $newList;


		$newList = array();
		foreach($_SESSION["tracking_codes_booking"] as $trackingCode){
			if ($trackingCode!=$_REQUEST["tracking_code"]){
				$newList[] = $trackingCode;
			}
		}

		$_SESSION["tracking_codes_booking"] = $newList;
		
	}
	else if (isset($_REQUEST["userid"]))
	{	
					//START: assign variables values
					$userid = $_REQUEST["userid"]; //currently not being used
					
					$found = false;
					foreach($_SESSION["userids_booking"] as $bookedUser){
						if ($userid==$bookedUser){
							$found = true;
							break;
						}
					}
					if (!$found){
						$_SESSION["userids_booking"][] = $userid;
					}


		$tracking_code = $_REQUEST["tracking_code"]; //currently not being used

		$found = false;
		foreach($_SESSION["tracking_codes_booking"] as $trackingCode){
			if ($tracking_code==$trackingCode){
				$found = true;
				break;
			}
		}
		if (!$found){
			$_SESSION["tracking_codes_booking"][] = $tracking_code;
		}
					
	}
	//ENDED: order session validator		
	$_SESSION["allstaff_request_counter"] = count($_SESSION["userids_booking"]); //total selected products including cancelled
	$_SESSION["allstaff_orders_counter"] = count($_SESSION["userids_booking"]); //total selected products cancelled not included
	//ENDED: assign variables values
	//START: update selected order
	$_SESSION["allstaff_request_selected"] = implode(",", $_SESSION["userids_booking"]);
	//ENDED: update selected order
	
	//START: generate output box from selected order
	include("staff_custom_booking_session_selected.php");
	//ENDED: generate output box from selected order		
	
	echo $return_output;		

?>
