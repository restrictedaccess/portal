<?php
include_once '../conf/zend_smarty_conf.php';
include_once '../config.php';
include_once '../conf.php';
session_start();
$endorsedStaffs = $_SESSION["TO_BE_ENDORSED"];
$staffs = array();
if (isset($_GET["json"])){
	$json = $_GET["json"];
	if ($json=="1"){
		$json = true;
	}else{
		$json = false;
	}
}else{
	$json = false;
}
$fetch_from_mongo = 0;
try{

    global $base_api_url;


    global $curl;


    if(!method_exists($curl, "get")){
        $curl = new Curl();
    }

    $default_fetch_from_mongo = $curl->get($base_api_url."/candidates/get-default-resume-settings-value/", array("settings_for" => "fetch_from_mongo"));

    $default_fetch_from_mongo = json_decode($default_fetch_from_mongo, true);

    $fetch_from_mongo = $default_fetch_from_mongo["value"];

    if(isset($_GET["fetch_from_mongo"])){
        $fetch_from_mongo = $_GET["fetch_from_mongo"];
    }
} catch(Exception $e){

}
if (!$json){


	$list = "<ul>";
	if (!empty($endorsedStaffs)){
		if (!isset($couch_resume_db)){
			$couch_resume_db = "resume";
		}
		$couch_client = new couchClient($couch_dsn, $couch_resume_db);
		foreach($endorsedStaffs as $userid){
			$query="SELECT * FROM personal p  WHERE p.userid=$userid";
			$staff = $db->fetchRow($query);
			$found = false;
			//START: check staff on couchDB

            $fetch_from_mongo_successful = false;

            if($fetch_from_mongo){
                try{

                    global $nodejs_api;


                    $mongo_result = $curl->get($nodejs_api."/jobseeker/user-info?userid=". $userid);


                    if(!empty($mongo_result)){
                        $mongo_result = json_decode(json_encode($mongo_result), true);

                        if($mongo_result["success"]){
                            $resume = $mongo_result["result"];
                            $fetch_from_mongo_successful = true;
                            $found = true;
                        }
                    }
                } catch(Exception $e){

                }
            }

            if(!$fetch_from_mongo_successful){

                try {
                    $resume = $couch_client->getDoc($userid);
                    $found = true;
                }
                catch (Exception $e) {
                    if ( $e->getCode() == 404) {
                        $found = false;
                    }
                    else {
                        $found = false;
                    }
                }
            }

			//ENDED: check staff on couchDB
			//START: render HTML
			if ($found){
				$class="<span class='blue'>&nbsp;resume created</span></h4>";
                
                $sql = $db->select()
                          ->from('evaluation_comments')
                          ->where('userid = ?', $userid)
                          ->order("ordering");
                $evaluation_notes = $db->fetchAll($sql);
                $class.="<br/><strong>Select Evaluation Notes To Show</strong>";
                $class.="<br/><div style='overflow:scroll;max-height:18em'>";
                foreach($evaluation_notes as $eval_note){
                    $class.="<label class='checkbox'><input type='checkbox' checked='checked' name='evaluation_notes[]' value='{$eval_note["id"]}' class='evaluation_notes_item' data-userid='{$eval_note["userid"]}' checked='checked'/>{$eval_note["comments"]}</label>";   
                }
                
                $class.="</div>";
                
			}else{
				$class="<span class='red'>&nbsp;resume not yet created</span></h4>";
			}
				
			$list.="<li><h4><a href='/portal/AdminResumeChecker/ResumeChecker.html?userid=".+$staff["userid"]."' class='open-popup'>".$staff["userid"]." ".$staff["fname"]." ".$staff["lname"]."</a>";
			$list.="<input type='hidden' class='found' value='".$found."'/>";
			$list.="$class</li>";
			//ENDED: render HTML
		}
	}
	$list.="</ul>";
	$smarty = new Smarty();
	$smarty->assign("list", $list);
	$smarty->display("load_staff_for_endorsement.tpl");
}else{
	if (!empty($endorsedStaffs)){
		if (!isset($couch_resume_db)){
			$couch_resume_db = "resume";
		}
		$couch_client = new couchClient($couch_dsn, $couch_resume_db);
		$error = false;
		foreach($endorsedStaffs as $userid){
			$found = false;
			//START: check staff on couchDB

            $fetch_from_mongo_successful = false;

            if($fetch_from_mongo){
                try{

                    global $nodejs_api;


                    $mongo_result = $curl->get($nodejs_api."/jobseeker/user-info?userid=". $userid);


                    if(!empty($mongo_result)){
                        $mongo_result = json_decode(json_encode($mongo_result), true);

                        if($mongo_result["success"]){
                            $resume = $mongo_result["result"];
                            $fetch_from_mongo_successful = true;
                            $found = true;
                        }
                    }
                } catch(Exception $e){

                }
            }


            if(!$fetch_from_mongo_successful){

                try {
                    $resume = $couch_client->getDoc($userid);
                    $found = true;
                }
                catch (Exception $e) {
                    if ( $e->getCode() == 404) {
                        $found = false;
                    }
                    else {
                        $found = false;
                    }
                }
            }


			//ENDED: check staff on couchDB
			if (!$found){
				echo json_encode(array("result"=>false));
				$error = true;
				break;
			}
				
		}
		if (!$error){
			echo json_encode(array("result"=>true));
		}
	}
}