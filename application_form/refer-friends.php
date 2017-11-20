<?php
include '../time.php';
include '../conf/zend_smarty_conf.php';
if (isset($_POST["userid"])){
	$userid = $_POST["userid"];
	for ($i=0;$i<3;$i++){
		if (isset($_POST["firstname"][$i])){
			$firstname = trim($_POST["firstname"][$i]);
			$lastname = trim($_POST["lastname"][$i]);
			$currentposition = trim($_POST["currentposition"][$i]);
			$emailaddress = trim($_POST["emailaddress"][$i]);
			$contactnumber = trim($_POST["contactnumber"][$i]);

			if (!(($firstname!="")&&($lastname!="")&&($currentposition!="")&&(($contactnumber!="")||($emailaddress!="")))){
				continue;
			}
			
			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $emailaddress)) { 
				continue;
			}
			
			$AusTime = date("h:i:s"); 
			$AusDate = date("Y")."-".date("m")."-".date("d");
			$ATZ = $AusDate." ".$AusTime;
			$date = $ATZ;
			$data = array("firstname"=>$firstname, 
						  "lastname"=>$lastname,
			 			  "position"=>$currentposition,
						  "email"=>$emailaddress,
						  "contactnumber"=>$contactnumber,
						  "user_id"=>$userid,
						  "contacted"=>0,
						  "date_created"=>$date);
			
			$db->insert("referrals", $data);
	
		}
		
	}
	echo json_encode(array("result"=>true));
}else{
	echo json_encode(array("result"=>false));
}