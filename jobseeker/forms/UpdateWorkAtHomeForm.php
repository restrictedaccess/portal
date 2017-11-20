<?php
class UpdateWorkAtHomeForm extends Zend_Form{
	public function init(){
		global $db;
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$view = new Zend_View();
		$view->doctype('XHTML1_TRANSITIONAL');
		$this->setMethod("POST");
		$this->setView($view);
		
		$elements = array();
		
		$yearOptions = array();
		$yearOptions[""] = "Year";
		for($i=0;$i<=15;$i++){
			$yearOptions["".$i] = $i;
		}
		
		$userid = new Zend_Form_Element_Hidden("userid");
		$elements[] = $userid;
		
		$start_worked_from_home_year = new Zend_Form_Element_Select("start_worked_from_home_year");
		$start_worked_from_home_year->setMultiOptions($yearOptions);
		$start_worked_from_home_year->class = "span2";
		$elements[] = $start_worked_from_home_year;
		
		$monthOptions = array();
		$monthOptions[""] = "Month";
		for($i=0;$i<12;$i++){
			$monthOptions["".$i] = $i;
		}
		$start_worked_from_home_month = new Zend_Form_Element_Select("start_worked_from_home_month");
		$start_worked_from_home_month->setMultiOptions($monthOptions);
		$start_worked_from_home_month->class = "span2";
		$elements[] = $start_worked_from_home_month;
		
		$start_worked_from_home = new Zend_Form_Element_Radio("work_from_home_before");
		$start_worked_from_home->addMultiOptions(array("1"=>"Yes", "0"=>"No"));
		$start_worked_from_home->setAttrib('label_class', 'radio inline');
		$elements[] = $start_worked_from_home;
		
		
		$has_baby = new Zend_Form_Element_Radio("has_baby");
		$has_baby->addMultiOptions(array("1"=>"Yes", "0"=>"No"));
		$has_baby->setAttrib('label_class', 'radio inline');
		$elements[] = $has_baby;
		
		
		$mainCaregiver = new Zend_Form_Element_Text("main_caregiver");
		$elements[] = $mainCaregiver;
		
		$reason_to_wfh = new Zend_Form_Element_Textarea("reason_to_wfh");
		$reason_to_wfh->setAttrib("rows", "5");
		$elements[] = $reason_to_wfh;
		
		$timespanOption = array();
		$timespanOption[""] = "-";
		$timespanList = array("1 month", "3 months", "6 months", "9 months", "1 year", "2 years", "as long as possible");
		foreach($timespanList as $timespanItem){
			$timespanOption[$timespanItem] = $timespanItem;
		}
		
		$timespan = new Zend_Form_Element_Select("timespan");
		$timespan->setMultiOptions($timespanOption);
		$elements[] = $timespan;
		
		$home_working_environment_option = array();
		$home_working_environment_list = array("private room"=>"Private Room", "shared room"=>"Shared Room", "living room"=>"Living Room"); 
		$home_working_environment = new Zend_Form_Element_Radio("home_working_environment");
		$home_working_environment->setMultiOptions($home_working_environment_list);		
		$home_working_environment->setAttrib('label_class', 'radio inline');
		$elements[] = $home_working_environment;
		
		
		$internetConnectionList = array("PLDT MyDSL", "PLDT WeRoam Wireless", "BayanTel DSL", "Globelines Broadband", "Globelines Wireless/WiMax/Tattoo", "Smart Bro Wireless","Sun Broadband Wireless","Others" );
		$internetConnectionOption = array();
		$internetConnectionOption[""] = "-";
		foreach($internetConnectionList as $item){
			$internetConnectionOption[$item] = $item;			
		}
		$internetConnection = new Zend_Form_Element_Select("isp");
		$internetConnection->setMultiOptions($internetConnectionOption);
		$elements[] = $internetConnection;
		
		$internetConnectionOther = new Zend_Form_Element_Text("internet_connection_others");
		$elements[] = $internetConnectionOther;
		
		
		$internetPlan = new Zend_Form_Element_Text("internet_connection");
		$elements[] =$internetPlan;
		
		$speedTest = new Zend_Form_Element_Text("speed_test");
		$elements[] = $speedTest;
		
		
		$internetConsequences = new Zend_Form_Element_Textarea("internet_consequences");
		$internetConsequences->setAttrib("rows", "5");
		$elements[] = $internetConsequences;
		
		
		$desktop = new Zend_Form_Element_Checkbox("desktop_computer");
		$desktop->setCheckedValue("yes");
		$elements[] = $desktop;
		
		$os_list = array(""=>"Select OS", "Windows XP"=>"Windows XP", "Windows Vista"=>"Windows Vista", "Windows 7"=>"Windows 7", "Windows 8"=>"Windows 8", "Linux"=>"Linux",  "Mac"=>"Mac");
		$desktop_os = new Zend_Form_Element_Select("desktop_os");
		$desktop_os->class="span2";
		$desktop_os->setMultiOptions($os_list);
		$elements[] = $desktop_os;
		
		$desktop_processor = new Zend_Form_Element_Text("desktop_processor");
		$desktop_processor->placeholder = "Please enter processor model";
		$desktop_processor->class = "span3";
		$elements[] = $desktop_processor;
		
		$desktop_ram = new Zend_Form_Element_Text("desktop_ram");
		$desktop_ram->placeholder = "Please enter size and model";
		$desktop_ram->class = "span3";
		
		$elements[] = $desktop_ram;
		
		$loptop_computer = new Zend_Form_Element_Checkbox("loptop_computer");
		$loptop_computer->setCheckedValue("yes");
		$elements[] = $loptop_computer;

		$loptop_os = new Zend_Form_Element_Select("loptop_os");
		$loptop_os->setMultiOptions($os_list);
		$loptop_os->class = "span2";
		$elements[] = $loptop_os;
		
		$loptop_processor = new Zend_Form_Element_Text("loptop_processor");
		$loptop_processor->class = "span3";
		$loptop_processor->placeholder = "Please enter processor model";
		$elements[] = $loptop_processor;
		
		$loptop_ram = new Zend_Form_Element_Text("loptop_ram");
		$loptop_ram->placeholder = "Please enter size and model";
		$loptop_ram->class = "span3";
		$elements[] = $loptop_ram;
		
		$headset = new Zend_Form_Element_Text("headset");
		$elements[] = $headset;
		
		$headphone = new Zend_Form_Element_Text("headphone");
		$elements[] = $headphone;
		
		
		$printer = new Zend_Form_Element_Text("printer");
		$elements[] = $printer;
		
		$scanner = new Zend_Form_Element_Text("scanner");
		$elements[] = $scanner;
		
		
		$tablet = new Zend_Form_Element_Text("tablet");
		$elements[] = $tablet;
		
		$pen_tablet = new Zend_Form_Element_Text("pen_tablet");
		$elements[] = $pen_tablet;
		
		$noiseLevel = array("quiet/no noise"=>"quiet/no noise", "tricycles"=>"tricycles", "general car traffic"=>"general car traffic","dog/rooster/chicken"=>"dog/rooster/chicken", "children"=>"children", "family members in-house"=>"family members in-house", "street vendors"=>"street vendors","planes"=>"planes", "surrounding construction/home renovations"=>"surrounding construction/home renovations");
		
		$noise_level = new Zend_Form_Element_MultiCheckbox('noise_level');
		$noise_level->setMultiOptions($noiseLevel);
		$noise_level->setAttrib("label_class", "checkbox inline");
		$elements[] = $noise_level;
		
		$this->addElements($elements);
		//get all elements
		$formElements = $this->getElements();
		foreach($formElements as $formElement){
			$formElement->setView($view);
		}
		
	}



}
