<?php
class UpdateCurrentJobProcess extends AbstractProcess{
	public function process(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION['userid'];
		//load user from db
		$user = $this->getUser();

		$current_status=$_POST['current_status'];
		$years_worked=$_POST['years_worked'];
		$months_worked=$_POST['months_worked'];
		$expected_salary_neg=$_POST['expected_salary_neg'];
		$expected_salary=$_POST['expected_salary'];
		$salary_currency=$_POST['salary_currency'];
		$latest_job_title=$_POST['latest_job_title'];


		//for additional field availability status
		$availability_status = $_POST["available_status"];
		$amonth = "";
		$ayear = "";
		$aday = "";
		$available_notice = "";
		if ($availability_status=='b'){
			$amonth = $_POST["amonth"];
			$aday = $_POST["aday"];
			$ayear = $_POST["ayear"];
		}else if ($availability_status=="a"){
			$available_notice = $_POST["available_notice"];
		}

		$position_first_choice=$_POST['position_first_choice'];
		$position_first_choice_exp=$_POST['position_first_choice_exp'];
		$position_second_choice=$_POST['position_second_choice'];
		$position_second_choice_exp=$_POST['position_second_choice_exp'];
		$position_third_choice=$_POST['position_third_choice'];
		$position_third_choice_exp=$_POST['position_third_choice_exp'];

		$history_company_name=$_POST['history_company_name'];
		
		$history_position=$_POST['history_position'];
		$history_monthfrom=$_POST['history_monthfrom'];
		$history_yearfrom=$_POST['history_yearfrom'];
		$history_monthto=$_POST['history_monthto'];
		$history_yearto=$_POST['history_yearto'];
		$history_responsibilities=$_POST['history_responsibilities'];
		$other_choice = $_POST["others"];


		if($current_status=="still studying"){
			$intern_status=1;
			$freshgrad=0;
		}
		else{
			if($current_status=="fresh graduate"){
				$intern_status=0;
				$freshgrad=1;
			}else{
				$intern_status=0;
				$freshgrad=0;
			}
		}


		$data = array(
			'userid' =>$userid,
			'freshgrad' => $freshgrad,
			'intern_status' => $intern_status,
			'years_worked' => $years_worked,
			'months_worked' => $months_worked,
			'expected_salary_neg' => $expected_salary_neg,
			'expected_salary' => $expected_salary,
			'salary_currency' => $salary_currency,
			'latest_job_title' => $latest_job_title,
			"available_status"=>$availability_status,
			"amonth"=>$amonth,
			"ayear"=>$ayear,
			"aday"=>$aday,
			"available_notice"=>$available_notice,
		
			'position_first_choice' => $position_first_choice,
			'position_first_choice_exp' => $position_first_choice_exp,
			'position_second_choice' => $position_second_choice,
			'position_second_choice_exp' => $position_second_choice_exp,
			'position_third_choice' => $position_third_choice,
			'position_third_choice_exp' => $position_first_choice_exp,
			'other_choice'=>$other_choice
		);

		$result=array();
		$result=array_merge($result,$data);
		for($i=0;$i<count($history_company_name);$i++){
			$db_column_suffix = $i+1;
			if ($db_column_suffix>10){
				continue;
			}
			if($i==0)$db_column_suffix = "";
			
			if ($history_monthto[$i]==""||$history_yearto[$i]==""||$history_monthto[$i]=="Present"||$history_yearto[$i]=="Present"){
				if (!$happened){
					$smarty = new Smarty();
					//get the candidate fullname
					
					$pers = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("fname", "lname", "email"))->where("userid = ?", $userid));
					if ($pers){
						if ($pers["fname"]==""&&$pers["lname"]==""){
							$smarty->assign("candidate_fullname", "Applicant");
						}else{
							$smarty->assign("candidate_fullname", $pers["fname"]." ".$pers["lname"]);
						}
						$output = $smarty->fetch("currently_employed.tpl");
						$mail = new Zend_Mail();
						if (TEST){
							$mail->setSubject("TEST - Updates on your Application at Remotestaff");
						}else{
							$mail->setSubject("Updates on your Application at Remotestaff");			
						}
						$mail->setFrom("recruitment@remotestaff.com.au","recruitment@remotestaff.com.au");
						$mail->setBodyHtml($output);
						if (TEST){
							$mail->addTo("devs@remotestaff.com.au");
						}else{
							$mail->addTo($pers["email"]);
						}
						$mail->send($transport);
						$happened = true;				
					}
		
				}
			
				
			}
			$result = array_merge($result,array('companyname'.$db_column_suffix => $history_company_name[$i]));
			$result = array_merge($result,array('position'.$db_column_suffix => $history_position[$i]));
			$result = array_merge($result,array('monthfrom'.$db_column_suffix => $history_monthfrom[$i]));
			$result = array_merge($result,array('yearfrom'.$db_column_suffix => $history_yearfrom[$i]));
			$result = array_merge($result,array('monthto'.$db_column_suffix => $history_monthto[$i]));
			$result = array_merge($result,array('yearto'.$db_column_suffix => $history_yearto[$i]));
			$result = array_merge($result,array('duties'.$db_column_suffix => $history_responsibilities[$i]));
		}


		$sql = $db->select()
		->from('currentjob' , 'userid')
		->where('userid = ?' ,$userid);
		$exists = $db->fetchOne($sql);
		if($exists){
			$where = "userid = ".$userid;
			$db->update('currentjob', $result, $where);
		}else{
			$db->insert('currentjob', $result);
		}
		
		//character reference save
		$names = $_POST["name"];
		$contact_details = $_POST["contact_details"];
		$contact_numbers = $_POST["contact_number"];
		$email_addresses = $_POST["email_address"];
		$ids = $_POST["id"];
		$db->delete("character_references", $db->quoteInto("userid = ?", $userid));
		foreach($names as $key=>$name){
			if ($name){
				$data = array();
				$data["name"] = $name;
				if ($contact_details[$key]){
					$data["contact_details"] = $contact_details[$key];
				}
				if ($email_addresses[$key]){
					$data["email_address"] = $email_addresses[$key];
 				}
				if ($contact_numbers[$key]){
					$data["contact_number"] = $contact_numbers[$key];
				}
				$data["userid"] = $_SESSION["userid"];
				
				if ($ids[$key]){
					$row = $db->fetchRow($db->select()->from(array("cr"=>"character_references"), array("id"))->where("cr.id = ?", $ids[$key]));	
					if ($row){
						$data["date_updated"] = date("Y-m-d h:i:s");
						$db->update("character_references", $data, $db->quoteInto("id = ?", $ids[$key]));					
					}else{
						$data["date_created"] = date("Y-m-d h:i:s");
						$db->insert("character_references", $data);	
					}
				}else{
					$data["date_created"] = date("Y-m-d h:i:s");
					$db->insert("character_references", $data);
				}
						
			}
		}
		
		
		
		echo "<script>alert('Profile has been updated');window.location.href='/portal/personal/myresume.php';</script>";

		header("Location:/portal/personal/myresume.php");
	}


	private function generatePositionExperienceOptions($position_exp,$name){
		if($position_exp=="Yes"){
			$is_yes_checked="checked='checked'";
			$is_no_checked="";
		}
		else{
			$is_yes_checked="";
			$is_no_checked="checked='checked'";
		}
		return '<input type="radio" name="'.$name.'"  id="'.$name.'" value="Yes" '.$is_yes_checked.' /> yes
		<input type="radio" name="'.$name.'"  id="'.$name.'" value="No" '.$is_no_checked.' /> no ';
	}

	private function getSubCategories($category_id){

		$db = $this->db;
		$select = "SELECT sub_category_id, sub_category_name
				FROM job_sub_category 
				WHERE category_id='".$category_id."' 
				ORDER BY sub_category_name";
		$rows = $db->fetchAll($select);

		$subcategories = array();
		foreach($rows as $row){
			$subcategories[$row['sub_category_id']]['category_name'] = $row['sub_category_name'];
		}
		return $subcategories;
	}

	private function getCategories($category = null){

		$db = $this->db;

		$category_filter = '';
		if($category != null){
			$category_filter = 'and  category_id = '.$category;
		}

		$select="SELECT category_id, category_name FROM job_category
			WHERE status='posted' ".$category_filter." 
			ORDER BY category_name";
		$rows = $db->fetchAll($select);

		$categories = array();
		foreach($rows as $row){
			$category = array();
			$category['category']['id'] = $row['category_id'];
			$category['category']['name'] = $row['category_name'];
			$categories[] = $category;
		}
		return $categories;
	}

	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION['userid'];

		//load user from db
		$user = $this->getUser();

		$sql=$db->select()
		->from('currentjob')
		->where('userid = ?' ,$userid);
		$result = $db->fetchRow($sql);

		$freshgrad = $result['freshgrad'];
		$intern_status = $result['intern_status'];
		$years_worked = $result['years_worked'];
		$months_worked = $result['months_worked'];
		$expected_salary_neg = $result['expected_salary_neg'];
		$expected_salary = $result['expected_salary'];
		$salary_currency = $result['salary_currency'];
		$latest_job_title = $result['latest_job_title'];
		$position_first_choice = $result['position_first_choice'];
		$position_first_choice_exp = $result['position_first_choice_exp'];
		$position_second_choice = $result['position_second_choice'];
		$position_second_choice_exp = $result['position_second_choice_exp'];
		$position_third_choice = $result['position_third_choice'];
		$position_third_choice_exp = $result['position_third_choice_exp'];

		$available_status = $result["available_status"];
		$available_notice = $result["available_notice"];
		$aday = $result["aday"];
		$amonth = $result["amonth"];
		$ayear = $result["ayear"];

		$still_studying_selected="";
		$fresh_graduate_selected="";
		$experienced_selected="";
		$selected="checked='checked'";


		if($freshgrad==1){
			$fresh_graduate_selected=$selected;
			$years_worked="";
			$months_worked="";
		}
		else{
			if($intern_status==1){
				$still_studying_selected=$selected;
				$years_worked="";
				$months_worked="";
			}
			else $experienced_selected=$selected;
		}

		$years_worked_options="";
		for($i=0;$i<=16;$i++){
			if($years_worked==$i)$years_worked_options.="<option value='".$i."' selected >".$i."</option>";
			else $years_worked_options.="<option value='".$i."' >".$i."</option>";
		}

		$months_worked_options="";
		for($i=0;$i<=11;$i++){
			if($months_worked==$i)$months_worked_options.="<option value='".$i."' selected >".$i."</option>";
			else $months_worked_options.="<option value='".$i."' >".$i."</option>";
		}

		if($expected_salary_neg=="Yes")$is_negotiable=$selected;

		$salary_currency_array=array("Australian Dollar","Bangladeshi Taka","British Pound","Chinese RenMinBi","Euro","HongKong Dollar","Indian Rupees","Indonesian Rupiah","Japanese Yen","Malaysian Ringgit","New Zealand Dollar","Philippine Peso","Singapore Dollar","Thai Baht","US Dollars","Vietnam Dong");
		$salary_currency_options="<option value='' >Select Currency</option>";

		if($salary_currency == ''){
			$salary_currency = 'Philippine Peso';
		}

		for($i=0;$i<count($salary_currency_array);$i++){
			if($salary_currency_array[$i]==$salary_currency){
				$salary_currency_options.="<option value='".$salary_currency_array[$i]."' selected >".$salary_currency_array[$i]."</option>";
			}
			else{
				$salary_currency_options.="<option value='".$salary_currency_array[$i]."' >".$salary_currency_array[$i]."</option>";
			}
		}

		$categories = $this->getCategories();
		$position_first_choice_options = "<option value=''>Select Position</option>";
		$position_second_choice_options = "<option value=''>Select Position</option>";
		$position_third_choice_options = "<option value=''>Select Position</option>";

		foreach($categories as $key=>$category){

			$categories[$key]['subcategories'] = $this->getSubCategories($category['category']['id']);
			$position_first_choice_options .= "<optgroup label='".$category['category']['name']."'>";;
			$position_second_choice_options .= "<optgroup label='".$category['category']['name']."'>";;
			$position_third_choice_options .= "<optgroup label='".$category['category']['name']."'>";;
			foreach($categories[$key]['subcategories'] as $key2=>$subcategory){

				//create sub-categories option
				$selected = "";
				
				if($subcategory['category_name'] != ''){
					if ($key2==$result["position_first_choice"]){
						$position_first_choice_options .= "<option value='".$key2."' selected>".$subcategory['category_name']."</option>";
					}else{
						$position_first_choice_options .= "<option value='".$key2."'>".$subcategory['category_name']."</option>";
					}
					if ($key2==$result["position_second_choice"]){
						$position_second_choice_options .= "<option value='".$key2."' selected>".$subcategory['category_name']."</option>";
					}else{
						$position_second_choice_options .= "<option value='".$key2."'>".$subcategory['category_name']."</option>";
						
					}
					if ($key2==$result["position_third_choice"]){
						$position_third_choice_options .= "<option value='".$key2."' selected>".$subcategory['category_name']."</option>";	
					}else{
						$position_third_choice_options .= "<option value='".$key2."'>".$subcategory['category_name']."</option>";	
					}
				}
					
			}
			$position_first_choice_options .= "</optgroup>";
			$position_second_choice_options .= "</optgroup>";
			$position_third_choice_options .= "</optgroup>";
		}


		$position_first_choice_exp_options = $this->generatePositionExperienceOptions($position_first_choice_exp,"position_first_choice_exp");
		$position_second_choice_exp_options = $this->generatePositionExperienceOptions($position_second_choice_exp,"position_second_choice_exp");
		$position_third_choice_exp_options = $this->generatePositionExperienceOptions($position_third_choice_exp,"position_third_choice_exp");


		$month_options = '<option value="JAN">JAN </option>
		<option value="FEB">FEB </option> 
		<option selected="selected" value="MAR">MAR </option>
		<option value="APR">APR </option>
		<option value="MAY">MAY </option>
		<option value="JUN">JUN </option>
		<option value="JUL">JUL </option> 
		<option value="AUG">AUG </option>
		<option value="SEP">SEP </option>
		<option value="OCT">OCT </option>
		<option value="NOV">NOV </option>
		<option value="DEC">DEC </option>';

		$year_options = "";
		for($i=$current_year;$i>=1950;$i--){
			$year_options .= '<option value="'.$i.'">'.$i.'</option>';
		}

		$history=array();
		for($i=0;$i<=10;$i++){
			if($i==0)$suffix="";
			else $suffix=$i+1;
			if($result['companyname'.$suffix]!=""){
				$history[$i]['companyname']=$result['companyname'.$suffix];
				$history[$i]['position']=$result['position'.$suffix];
				$history[$i]['monthfrom']=$result['monthfrom'.$suffix];
				$history[$i]['yearfrom']=$result['yearfrom'.$suffix];
				$history[$i]['monthto']=$result['monthto'.$suffix];
				$history[$i]['yearto']=$result['yearto'.$suffix];
				$history[$i]['duties']=$result['duties'.$suffix];
			}
			else break;
		}

		$current_year = date('Y');

		$month_options = '<option value="JAN">JAN </option>
		    <option value="FEB">FEB </option> 
		    <option value="MAR">MAR </option>
		    <option value="APR">APR </option>
		    <option value="MAY">MAY </option>
		    <option value="JUN">JUN </option>
		    <option value="JUL">JUL </option> 
		    <option value="AUG">AUG </option>
		    <option value="SEP">SEP </option>
		    <option value="OCT">OCT </option>
		    <option value="NOV">NOV </option>
		    <option value="DEC">DEC </option>';

		$year_options_from = "";
		for($i=$current_year;$i>=1950;$i--){
			$year_options_from .= '<option value="'.$i.'">'.$i.'</option>';
		}

		$year_options = "<option value=\"Present\">Present</option>";
		for($i=$current_year;$i>=1950;$i--){
			$year_options .= '<option value="'.$i.'">'.$i.'</option>';
		}



		$histories=$history;
		array_push ($histories,array());
		$history_HTML="";
		$i=0;
		foreach($histories as $history){
			if (trim($history['companyname'])!=""){
				$history_HTML .= '<table width="500" border="0" cellspacing="0" cellpadding="0" class="applyform">
					<tr>
					<td width="200" align="right">Company Name:</td>
					<td width="300"><input name="history_company_name[]" type="text" id="history_company_name" value="'.$history['companyname'].'" size="35" /></td>
					</tr>
					<tr>
					  <td align="right">Position Title:</td>
					  <td><input name="history_position[]" type="text" id="history_position" value="'.$history['position'].'" size="35" /></td>
					</tr>
					<tr>
					  <td align="right">Employment Period</td>
					  <td>
						<select name="history_monthfrom[]"> ';
				$history_HTML .= str_replace('value="'.$history['monthfrom'].'"','value="'.$history['monthfrom'].'" selected ',$month_options);
				$history_HTML .= '</select>
						<select name="history_yearfrom[]" >';
				$history_HTML .= str_replace('value="'.$history['yearfrom'].'"','value="'.$history['yearfrom'].'" selected ',$year_options_from);
				$history_HTML .= '</select> to
						<select name="history_monthto[]" >';
				if($i==0){
					if($history['monthto']=='Present') $history_HTML .= '<option value="Present" selected > Present </option>';
					else $history_HTML .= '<option value="Present"> Present </option>';
				}
				$history_HTML .= str_replace('value="'.$history['monthto'].'"','value="'.$history['monthto'].'" selected ',$month_options);
				$history_HTML .= '    </select>
						<select name="history_yearto[]" >';
				
				$history_HTML .= str_replace('value="'.$history['yearto'].'"','value="'.$history['yearto'].'" selected ',$year_options);
				$history_HTML .= '</select>
					</td>
					</tr>
					<tr>
					  <td align="right" valign="top">Responsibilities Achievement</td>
					  <td><textarea name="history_responsibilities[]" cols="35" rows="7" id="textfield4">'.$history['duties'].'</textarea></td>
					</tr>
					</table>';
				$i++;
			}
		}

		$full_months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$month_full_options = "";
		foreach ($full_months as $month){
			if ($amonth==$month){
				$month_full_options .= "<option value='{$month}' selected>{$month}</option>";
			}else{
				$month_full_options .= "<option value='{$month}'>{$month}</option>";
			}
		}

		$available_a = "";
		$available_b = "";
		$available_p = "";
		$available_w = "";

		if ($available_status=="a"){
			$available_a = "checked";
		}else if ($available_status=="b"){
			$available_b = "checked";
		}else if ($available_status=="p"){
			$available_p = "checked";
		}else if ($available_status=="Work Immediately"){
			$available_w = "checked";
		}else{
			$available_a = "checked";
		}
		
		
		$character_references = $db->fetchAll($db->select()->from(array("cr"=>"character_references"))->where("userid = ?",$userid));
		
		$smarty->assign("character_references", $character_references);
		$smarty->assign('fname',$user["fname"]);
		$smarty->assign("available_a", $available_a);
		$smarty->assign("available_b", $available_b);
		$smarty->assign("available_p", $available_p);
		$smarty->assign("available_w", $available_w);

		$smarty->assign("amonth", $amonth);
		$smarty->assign("ayear", $ayear);
		$smarty->assign("aday", $aday);
		$smarty->assign("available_status", $available_status);
		$smarty->assign("available_notice", $available_notice);

		$smarty->assign("month_options", $month_options);
		$smarty->assign('still_studying_selected' , $still_studying_selected);
		$smarty->assign('fresh_graduate_selected',$fresh_graduate_selected);
		$smarty->assign('experienced_selected',$experienced_selected);
		$smarty->assign('years_worked_options',$years_worked_options);
		$smarty->assign('months_worked_options',$months_worked_options);
		$smarty->assign('is_negotiable',$is_negotiable);
		$smarty->assign('expected_salary',$expected_salary);
		$smarty->assign('salary_currency_options',$salary_currency_options);
		$smarty->assign('latest_job_title',$latest_job_title);
		$smarty->assign("month_full_options",$month_full_options);
		$smarty->assign('position_first_choice_options',$position_first_choice_options);
		$smarty->assign('position_second_choice_options',$position_second_choice_options);
		$smarty->assign('position_third_choice_options',$position_third_choice_options);

		$smarty->assign('position_first_choice_exp_options',$position_first_choice_exp_options);
		$smarty->assign('position_second_choice_exp_options',$position_second_choice_exp_options);
		$smarty->assign('position_third_choice_exp_options',$position_third_choice_exp_options);

		$smarty->assign("other_choice", $result["other_choice"]);
		$smarty->assign('history_HTML',$history_HTML);

		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header("Pragma: no-cache");

		$smarty->display('updatecurrentjob.tpl');
	}
}