<?php
class AddSkillForm extends Zend_Form{
	public function init(){
		global $db;
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$view = new Zend_View();
		$view->doctype('XHTML1_TRANSITIONAL');
		$this->setMethod("POST");
		
		$elements = array();
		
		$userid = new Zend_Form_Element_Hidden("userid");
		$userid->setRequired(true);
		$elements[] = $userid;
		$skill = new Zend_Form_Element_Text("skill");
		$skill->class = "span4";
		$skill->setRequired(true);
		$elements[] = $skill;
		
		$years = array();
		$years[""] = "";
		$years["0.5"] =  "Less than 6 months";
		$years["0.75"] =  "Over 6 months";
		for($i=1;$i<=11;$i++){
			if ($i==1){
				$years["".$i] = "1 year";
			}else if ($i==11){
				$years["".$i] = "More than 10 years";
			}else{
				$years["".$i] = $i." years";
			}
		}
		
		$year = new Zend_Form_Element_Select("experience");
		$year->class = "span4";
		$year->setMultiOptions($years);
		$year->setRequired(true);
		$elements[] = $year;
		
		$levels = array();
		$levels[""] = "";
		$levels["3"] = "Advance";
		$levels["2"] = "Intermediate";
		$levels["1"] = "Beginner";
		
		$proficiency = new Zend_Form_Element_Select("proficiency");
		$proficiency->class = "span4";
		$proficiency->setMultiOptions($levels);
		$proficiency->setRequired(true);
		$elements[] = $proficiency;
		
		
		$this->addElements($elements);
		
		$formElements = $this->getElements();
		foreach($formElements as $formElement){
			$formElement->setView($view);
		}
		
		
	}
	
}
