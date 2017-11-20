<?php
class UpdateTaskForm extends Zend_Form{
	public function init(){
		global $db;
		$this->addDecorators(array("ViewHelper"), array("Errors"));
		$view = new Zend_View();
		$view->doctype('XHTML1_TRANSITIONAL');
		$this->setMethod("POST");
		
		$elements = array();
		
		$id = new Zend_Form_Element_Hidden("id");
		$id->setRequired(true);
		$elements[] = $id;
		
		$userid = new Zend_Form_Element_Hidden("userid");
		$userid->setRequired(true);
		$elements[] = $userid;
		$task_id = new Zend_Form_Element_Hidden("task_id");
		$task_id->setRequired(true);
		$elements[] = $task_id;
		
		$options = array();
		$options[""] = "Please Select Ratings";
		for($i=10;$i>=1;$i--){
			$options[$i] = $i;
		}
		
		$ratings = new Zend_Form_Element_Select("ratings");
		$ratings->class = "span2";
		$ratings->setMultiOptions($options);
		$ratings->setRequired(true);
		$elements[] = $ratings;
		
		
		$this->addElements($elements);
		
		$formElements = $this->getElements();
		foreach($formElements as $formElement){
			$formElement->setView($view);
		}
		
		
	}
	
}