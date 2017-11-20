<?php
class UpdateCandidateProfileForm extends Zend_Form{
	public function init(){
		global $db;
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$view = new Zend_View();
		$view->doctype('XHTML1_TRANSITIONAL');
		$this->setMethod("POST");
		$this->setView($view);
		
		
		$userid = new Zend_Form_Element_Hidden("userid");
		$userid->setRequired(true);
		
		$fname = new Zend_Form_Element_Text("fname");
		$fname->setRequired(true);
		$fname->class = "span4";
		
		$lname = new Zend_Form_Element_Text("lname");
		$lname->setRequired(true);
		$lname->class = "span4";
		
		
		$mname = new Zend_Form_Element_Text("middle_name");
		$mname->class = "span4";
		
		
		$nickname = new Zend_Form_Element_Text("nick_name");
		$nickname->class = "span4";
		
		$bmonth = new Zend_Form_Element_Select("bmonth");
		$bmonth->class = "span2";
		$items = array(
				""=>"Month",
				"1"=>"Jan",
				"2"=>"Feb",
				"3"=>"Mar",
				"4"=>"Apr",
				"5"=>"May",
				"6"=>"Jun",
				"7"=>"Jul",
				"8"=>"Aug",
				"9"=>"Sep",
				"10"=>"Oct",
				"11"=>"Nov",
				"12"=>"Dec"
			);
		$bmonth->setMultiOptions($items);
		
		$bday = new Zend_Form_Element_Select("bday");
		$bday->class = "span2";
		$items = array();
		$items[''] = "";
		for($i=1;$i<=31;$i++){
			$items["$i"] = $i;
		}
		$bday->setMultiOptions($items);
		
		
		$byear = new Zend_Form_Element_Text("byear");
		$byear->class = "span1";
		$byear->setAttrib("placeholder", "Year");
		
		$gender = new Zend_Form_Element_Radio("gender");
		$gender->setRequired(true);
		$gender->addMultiOptions(array("Male"=>"Male", "Female"=>"Female"));
		$gender->setAttrib('label_class', 'radio inline gender');
		
		
		$maritalStatusOptions = array("Single", "Married", "DeFacto", "Its Complicated", "Engaged");
		$maritalStatusItems = array();
		foreach($maritalStatusOptions as $maritalStatusOption){
			$maritalStatusItems[$maritalStatusOption] = $maritalStatusOption;
		}
		
		$maritalStatus = new Zend_Form_Element_Select("marital_status");
		$maritalStatus->setRequired(true);
		$maritalStatus->addMultiOptions($maritalStatusItems);

		$idTypes = array("SSS ID","TIN","Passport","Postal ID","Drivers License","PRC ID");
		$identificationOptions = array();
		foreach($idTypes as $idType){
			$identificationOptions[$idType] = $idType;
		}

		$auth_no_type_id = new Zend_Form_Element_Select("auth_no_type_id");
		$auth_no_type_id->addMultiOptions($identificationOptions);
		$auth_no_type_id->class = "span2";
		
		$msia_new_ic_no = new Zend_Form_Element_Text("msia_new_ic_no");
		$msia_new_ic_no->class = "span3";
		
		$msn_id = new Zend_Form_Element_Text("msn_id");
		$msn_id->class = "span4";
		
		$yahoo_id = new Zend_Form_Element_Text("yahoo_id");
		$yahoo_id->class = "span4";
		
		$icq_id = new Zend_Form_Element_Text("icq_id");
		$icq_id->class = "span4";
		
		$linked_in = new Zend_Form_Element_Text("linked_in");
		$linked_in->class = "span4";
		
		
		$skype_id = new Zend_Form_Element_Text("skype_id");
		$skype_id->class = "span4";
		
		
		$no_of_kids = new Zend_Form_Element_Text("no_of_kids");
		$no_of_kids->class = "span1";
		
		$pregnant_options = array("", "Yes", "No", "No! I'm a Male Applicant", "No, but I wish I was");
		$pregnant_items = array();
		foreach($pregnant_options as $pregnant_option){
			$pregnant_items[$pregnant_option] = $pregnant_option;
		}
		
		$pregnant = new Zend_Form_Element_Select("pregnant");
		$pregnant->addMultiOptions($pregnant_items);
				
		$dmonth = new Zend_Form_Element_Select("dmonth");
		$dmonth->class = "span2";
		$items = array(
				""=>"Month",
				"1"=>"Jan",
				"2"=>"Feb",
				"3"=>"Mar",
				"4"=>"Apr",
				"5"=>"May",
				"6"=>"Jun",
				"7"=>"Jul",
				"8"=>"Aug",
				"9"=>"Sep",
				"10"=>"Oct",
				"11"=>"Nov",
				"12"=>"Dec"
			);
		$dmonth->setMultiOptions($items);
		
		$dday = new Zend_Form_Element_Select("dday");
		$dday->class = "span2";
		$items = array();
		$items[] = "";
		for($i=1;$i<=31;$i++){
			$items[] = $i;
		}
		$dday->setMultiOptions($items);
		
		
		$dyear = new Zend_Form_Element_Text("dyear");
		$dyear->class = "span1";
		$dyear->setAttrib("placeholder", "Year");
		
		$sql = $db->select()
			->from('country')
		
			->order('printable_name');
		
		$nationalities = $db->fetchAll($sql);	
		$items = array();
		foreach($nationalities as $nationality){
			$items[$nationality["printable_name"]] = $nationality["printable_name"];
		}
		
		$nationality = new Zend_Form_Element_Select("nationality");
		$nationality->setMultiOptions($items);
		$sql = $db->select()
			->from('country'); 
		$countries = $db->fetchAll($sql);	
	
		$items = array();
		foreach($countries as $country){
			$items[$country["iso"]] = $country["printable_name"];
		}	
			
		
		
		$permanent_residence = new Zend_Form_Element_Select("permanent_residence");
		$permanent_residence->setMultiOptions($items);
		
		
		$active_visa = new Zend_Form_Element_Radio("active_visa");
		$active_visa->addMultiOptions(array("Yes"=>"Yes", "No"=>"No"));
		$active_visa->setAttrib('label_class', 'radio inline gender');
		
		$pending_visa_application = new Zend_Form_Element_Radio("pending_visa_application");
		$pending_visa_application->addMultiOptions(array("Yes"=>"Yes", "No"=>"No"));
		$pending_visa_application->setAttrib('label_class', 'radio inline gender');
		
		
		
		$alt_email = new Zend_Form_Element_Text("alt_email");
		$alt_email->addValidators(array(array(
			"validator"=>"emailAddress"))
		);
		$alt_email->class = "span4";
		
		$email = new Zend_Form_Element_Text("email");
		$email->class = "span4";
		$email->setRequired(true);
		
		$handphone_country_code = new Zend_Form_Element_Text("handphone_country_code");
		$handphone_country_code->setRequired(true);
		$handphone_country_code->class = "span1";
		
		$handphone_no = new Zend_Form_Element_Text("handphone_no");
		$handphone_no->setRequired(true);
		$handphone_no->class = "span3";		
		
		
		$tel_area_code = new Zend_Form_Element_Text("tel_area_code");
		$tel_area_code->class = "span1";
		
		$tel_no = new Zend_Form_Element_Text("tel_no");
		$tel_no->class = "span3";		
		
		$address = new Zend_Form_Element_Textarea("address1");
		$address->setAttrib("rows", 5);
		$address->class = "span4";
		
		
		$address2 = new Zend_Form_Element_Textarea("address2");
		$address2->setAttrib("rows", 5);
		$address2->class = "span4";
		
		$postcode = new Zend_Form_Element_Text("postcode");
		$postcode->class = "span2";
		
		$country_id = new Zend_Form_Element_Text("country_id");
		$country_id->class = "span4";
		
		
		
		
		$sql = $db->select()
			->from('country'); 
		$countries = $db->fetchAll($sql);	
	
		$items = array();
		foreach($countries as $country){
			$items[$country["iso"]] = $country["printable_name"];
		}	
		
		
		$country = new Zend_Form_Element_Select("country_id");
		$country->class = "span4";
		$country->setMultiOptions($items);
		
		$regions = array('Armm','Bicol Region','C.A.R.','Cagayan Valley','Central Luzon','Central Mindanao','Caraga','Central Visayas','Eastern Visayas','Ilocos Region','National Capital Reg','Northern Mindanao','Southern Mindanao','Southern Tagalog','Western Mindanao','Western Visayas');
		$ph_states_code = array("AR", "BR", "CA", "CG", "CL", "CM", "CR", "CV", "EV", "IL", "NC", "NM", "SM", "ST", "WM", "WV");
		
		$items = array();
		foreach($regions as $key=>$region){
			$items[$ph_states_code[$key]] = $region;
		}
		
		$state = new Zend_Form_Element_Select("state");
		$state->class = "span4";
		$state->setMultiOptions($items);
		
		$city = new Zend_Form_Element_Text("city");
		$city->class = "span2";
		
		$sources = array("Jobstreet", "JobsDB", "Monster.com", "Employee Referral", "Job Fair", "Best Jobs", "Great Jobs", "Hiring Venue", "IT Pinoy", "Jobs Pen", "Jobspot PH", "Job Isaland", "Job Openings PH", "Job Philippines", "Locanto", "OLX", "Philippines JOB PH", "Pinoy Adster", "Resume Promo", "Sulit.com", "The Jobs Daily", "Web Geek PH", "Woop Ads", "Yello", "Facebook", "Linkein", "Tumblr", "Titter", "Skillspages", "Ayosdito", "Pinoy Exchange");
		$options = array();
		$options[""] = "Please Select";
		foreach($sources as $source){
			$options[$source] = $source;
		}
		$external_source = new Zend_Form_Element_Select("external_source");
		$external_source->setMultiOptions($options);
		$external_source->class = "span3";
		$external_source->id = "external_source_select";
		
		
		$external_source_others = new Zend_Form_Element_Text("external_source_others");
		$external_source_others->class = "span3";
		//add all form elements
		$this->addElements(array($userid, $fname, $lname, $mname, $nickname, $bday, $bmonth, $byear, $gender, $maritalStatus, $no_of_kids, $pregnant, $dday, $dmonth, $dyear, $nationality, $permanent_residence, $email,  $address2, $alt_email, $handphone_no, $handphone_country_code, $tel_area_code, $tel_no, $address, $postcode, $country, $state, $city, $english_communication_skill, $auth_no_type_id, $msia_new_ic_no, $yahoo_id, $icq_id, $skype_id, $msn_id, $pending_visa_application, $active_visa, $linked_in, $external_source, $external_source_others));
		//get all elements
		$formElements = $this->getElements();
		foreach($formElements as $formElement){
			$formElement->setView($view);
		}
	}
}
