<?php
class UpdateEducationForm extends Zend_Form{
	public function init(){
		global $db;
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$view = new Zend_View();
		$view->doctype('XHTML1_TRANSITIONAL');
		$this->setMethod("POST");
		$levels = array("High School Diploma","Vocational Diploma / Short Course Certificate","Bachelor/College Degree","Post Graduate Diploma / Master Degree","Post Graduate Diploma / Master Degree","Professional License (Passed Board/Bar/Professional License Exam)","Doctorate Degree", "Others");
		$levelsOptions = array();
		
		$controls = array();
		foreach($levels as $level){
			$levelsOptions[$level] = $level;
		}
		$educational_level = new Zend_Form_Element_Select("educationallevel");
		$educational_level->setRequired(true);
		$educational_level->setMultiOptions($levelsOptions);
		$educational_level->class = "span5";
		$controls[] = $educational_level;
		
		$training_seminars = new Zend_Form_Element_Textarea("trainings_seminars");
		$training_seminars->setAttrib("rows", 5);
		$training_seminars->class = "span8";
		$controls[] = $training_seminars;


        $licence_certification = new Zend_Form_Element_Textarea("licence_certification");
        $licence_certification->setAttrib("rows", 5);
        $licence_certification->class = "span8";
        $controls[] = $licence_certification;


		$graduate_year = new Zend_Form_Element_Text("graduate_year");
		$graduate_year->class = "span2";
		$controls[] = $graduate_year;
		$college_name = new Zend_Form_Element_Text("college_name");
		$college_name->class="span5";
		$controls[] = $college_name;
		$gpascore = new Zend_Form_Element_Text("gpascore");
		$gpascore->class = "span1";
		$controls[] = $gpascore;
		$major = new Zend_Form_Element_Text("major");
		$major->class = "span5";
		$controls[] = $major;
		$userid = new Zend_Form_Element_Hidden("userid");
		$controls[] = $userid;
		$areas = array("Advertising/Media","Agriculture/Aquaculture/Forestry","Airline Operation/Airport Management","Architecture","Art/Design/Creative Multimedia","Biology","BioTechnology","Business Studies/Administration/Management","Chemistry","Commerce","Computer Science/Information Technology","Dentistry","Economics","Education/Teaching/Training","Engineering (Aviation/Aeronautics/Astronautics)","Engineering (Bioengineering/Biomedical)","Engineering (Chemical)","Engineering (Civil)","Engineering (Computer/Telecommunication)","Engineering (Electrical/Electronic)","Engineering (Environmental/Health/Safety)","Engineering (Industrial)","Engineering (Marine)","Engineering (Material Science)","Engineering (Mechanical)","Engineering (Mechatronic/Electromechanical)","Engineering (Metal Fabrication/Tool & Die/Welding)","Engineering (Mining/Mineral)","Engineering (Others)","Engineering (Petroleum/Oil/Gas)","Finance/Accountancy/Banking","Food & Beverage Services Management","Food Technology/Nutrition/Dietetics","Geographical Science","Geology/Geophysics","History","Hospitality/Tourism/Hotel Management","Human Resource Management","Humanities/Liberal Arts","Journalism","Law","Library Management","Linguistics/Languages","Logistic/Transportation","Maritime Studies","Marketing","Mass Communications","Mathematics","Medical Science","Medicine","Music/Performing Arts Studies","Nursing","Optometry","Others","Personal Services","Pharmacy/Pharmacology","Philosophy","Physical Therapy/Physiotherapy","Physics","Political Science","Property Development/Real Estate Management","Protective Services & Management","Psychology","Quantity Survey","Science & Technology","Secretarial","Social Science/Sociology","Sports Science & Management","Textile/Fashion Design","Urban Studies/Town Planning","Veterinary");
		
		$areasOptions = array();
		foreach($areas as $area){
			$areasOptions[$area] = $area;
		}
		$field_of_study = new Zend_Form_Element_Select("fieldstudy");
		$field_of_study->setRequired(true);
		$field_of_study->class = "span5";
		$field_of_study->setMultiOptions($areasOptions);
		$controls[] = $field_of_study;
		
		
		$grades = array("Grade Point Average (GPA)","Incomplete");
		$gradesOptions = array();
		foreach($grades as $grade){
			$gradesOptions[$grade] = $grade;
		}
		
		$grade = new Zend_Form_Element_Select("grade");
		$grade->setRequired(true);
		$grade->class = "span5";
		$grade->setMultiOptions($gradesOptions);
		
		$controls[] = $grade;
		
		$countries = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia-Herzegovina","Botswana","Bouvet Island","Brazil","British Indian O. Terr.","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Rep.","Chad","Chile","China","Christmas Island","Cocos (Keeling) Isl.","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Diego Garcia","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Isl. (Malvinas)","Faroe Islands","Fiji","Finland","France","France (European Ter.)","French Southern Terr.","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Great Britain (UK)","Greece","Greenland","Grenada","Guadeloupe (Fr.)","Guam (US)","Guatemala","Guinea","Guinea Bissau","Guyana","Guyana (Fr.)","Haiti","Heard &amp; McDonald Isl.","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Ivory Coast","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea (North)","Korea (South)","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia (former Yugo.)","Madagascar (Republic of)","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique (Fr.)","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherland Antilles","Netherlands","New Caledonia (Fr.)","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Isl.","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Polynesia (Fr.)","Portugal","Puerto Rico (US)","Qatar","Reunion (Fr.)","Romania","Russian Federation","Rwanda","Saint Lucia","Samoa","San Marino","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovakia (Slovak Rep)","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia  and  South Sand","Spain","Sri Lanka","St. Helena","St. Pierre &amp; Miquelon","St. Tome and Principe","St.Kitts Nevis Anguilla","St.Vincent &amp; Grenadines","Sudan","Suriname","Svalbard &amp; Jan Mayen Is","Swaziland","Sweden","Switzerland","Syria","Tadjikistan","Taiwan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","US Minor outlying Isl.","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Vietnam","Virgin Islands (British)","Virgin Islands (US)","Wallis &amp; Futuna Islands","Western Sahara","Yemen","Yugoslavia","Zaire","Zambia","Zimbabwe");
		$countriesOptions = array();
		foreach($countries as $country){
			$countriesOptions[$country] = $country;
		}
		$college_country = new Zend_Form_Element_Select("college_country");
		$college_country->setRequired(true);
		$college_country->class="span5";
		$college_country->setMultiOptions($countriesOptions);
		$controls[] = $college_country;
		
		$months = array("Month","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		$monthsOptions = array();
		for($i=0;$i<count($months);$i++){
			if ($i==0){
				$monthsOptions[""] = $months[$i];
			}else{
				$monthsOptions["".$i] = $months[$i]; 				
			}
		}
		
		
		$graduated_month = new Zend_Form_Element_Select("graduate_month");
		$graduated_month->setRequired(true);
		$graduated_month->class = "span2";
		$graduated_month->setMultiOptions($monthsOptions);
		$controls[] = $graduated_month;
		
		//get all elements
		$this->addElements($controls);
		$formElements = $this->getElements();
		foreach($formElements as $formElement){
			$formElement->setView($view);
		}
	
	}
}
