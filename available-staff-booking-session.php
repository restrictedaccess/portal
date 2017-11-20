<?php
	include 'conf.php';
	include 'config.php';

	include('../conf/zend_smarty_conf.php');
	include 'lib/AvailableStaffCheckSum.php';

	$uncheck_id = @$_REQUEST["uncheck_id"];
	if(@$_REQUEST["reset"] == "true")
	{
		$_SESSION["selectedStaff"] = array();
		$_SESSION["request_selected"] = "";
		$_SESSION["request_counter"] = 0; //total selected products including cancelled
		$_SESSION["orders_counter"] = 0; //total selected products cancelled not included		
		//session_destroy(); 
	}
	elseif(isset($uncheck_id))
	{
		$newList = array();
		foreach($_SESSION["selectedStaff"] as $selectedStaff){
			if ($selectedStaff["jsca_id"]!=$uncheck_id){
				$newList[] = $selectedStaff;
			}
		}
		$_SESSION["selectedStaff"] = $newList;
		
		$_SESSION["orders_counter"] = $_SESSION["orders_counter"] - 1;	//total selected products cancelled not included	
		
		$_SESSION["selection_status".$uncheck_id] = 0;
		
		//header
		$look = "<!-- header".$uncheck_id." -->";
		$rep =  "<!-- header".$uncheck_id;
		$_SESSION["request_enterface"]=str_replace($look,$rep,$_SESSION["request_enterface"]);
		//footer
		$look = "<!-- footer".$uncheck_id." -->";
		$rep =  " -->";
		$_SESSION["request_enterface"]=str_replace($look,$rep,$_SESSION["request_enterface"]);
		
		
		//header selected
		$look = "<!-- selected header".$uncheck_id." -->";
		$rep =  "<!-- selected header".$uncheck_id;
		$_SESSION["request_selected"]=str_replace($look,$rep,$_SESSION["request_selected"]);
		//footer selected
		$look = "<!-- selected footer".$uncheck_id." -->";
		$rep =  " -->";
		$_SESSION["request_selected"]=str_replace($look,$rep,$_SESSION["request_selected"]);		
		
		//header selected send resume
		$look = "<!-- ".$uncheck_id." --><!-- email resume";
		$rep = "";
		$_SESSION["request_selected"] = str_replace($look,$rep,$_SESSION["request_selected"]);
		//footer selected send resume
		$look = "end email resume --><!-- ".$uncheck_id." -->";
		$rep =  "";
		$_SESSION["request_selected"] = str_replace($look,$rep,$_SESSION["request_selected"]);		

	}
	else
	{	
		$id = $_REQUEST["id"];
		$userid = $_REQUEST["userid"];
		$name = $_REQUEST["name"];
		$_SESSION["selection_status".$id] = 1;
		$_SESSION["request_counter"] = $_SESSION["request_counter"] + 1; //total selected products including cancelled
		$_SESSION["orders_counter"] = $_SESSION["orders_counter"] + 1; //total selected products cancelled not included
		
		$_SESSION["selectedStaff"][] = array("jsca_id"=>$id, "user_id"=>$userid); 
		//get skill
		$sql="SELECT sub_category_name FROM job_sub_category WHERE sub_category_id='".$_SESSION["position_id"]."'";
		$s = mysql_query($sql);
		while(list($sub_category_name)=mysql_fetch_array($s))
		{
			$skill_selected = $sub_category_name;
		}
		//end

		$_SESSION["request_selected"] = $_SESSION["request_selected"].'
			<!-- selected header'.$id.' -->
			<tr>
				<!-- '.$id.' --><!-- email resume 
					<td align="left" valign="middle" class="stname">
					<input type="hidden" name="position'.$_SESSION["request_counter"].'" value="'.$_SESSION["position_id"].'">
					<input name="send_resume'.$_SESSION["request_counter"].'" type="checkbox" value="'.$userid.'" style="color:#000000; font:arial; font-weight:normal; font-size:11px; padding:0px 1px 2px 2px; border:1px #666666 solid;" checked>
					</td>
				end email resume --><!-- '.$id.' -->
				<td align="left" valign="middle" class="stname"><a href="javascript: resume('.$userid.'); ">'.$name.'</a></td>
				<td align="left" valign="middle" class="stskill">'.$skill_selected.'</td>
				<td align="left" valign="middle" class="staction"><a href="javascript: cancel_selected_order('.$id.'); "><img src="images/action_delete.gif" border="0"></a></td>
			</tr>
			<!-- selected footer'.$id.' -->';
	}
	echo $_SESSION["request_selected"];
?>
