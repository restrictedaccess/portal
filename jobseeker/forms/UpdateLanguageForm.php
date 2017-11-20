<?php
class UpdateLanguageForm extends Zend_Form{
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
		
		
		$spoken_assessment = new Zend_Form_Element_Hidden("spoken_assessment");
		$elements[] = $spoken_assessment;
		
		$written_assessment = new Zend_Form_Element_Hidden("written_assessment");
		$elements[] = $written_assessment;
		
		$languageOption = array();
		$languages=array("", "Arabic","Bahasa Indonesia","Bahasa Malaysia","Bengali","Chinese","Dutch","English","Filipino","French","German","Hebrew","Hindi","Italian","Japanese","Korean","Portuguese","Russian","Spanish","Tamil","Thai","Vietnamese");
		
		foreach($languages as $language){
			$languageOption[$language] = $language;
		}
		
		$languageControl = new Zend_Form_Element_Select("language");
		$languageControl->setMultiOptions($languageOption);
		$elements[] = $languageControl;
		
		$spoken = new Zend_Form_Element_Select("spoken");
		$spokenOption = array();
		$spokenOption[""] = "";
		for ($i=1;$i<=10;$i++){
			$spokenOption["".$i] = $i;
		}
		$spoken->setMultiOptions($spokenOption);
		$elements[] = $spoken;
		
		$written = new Zend_Form_Element_Select("written");
		
		$writtenOption = array();
		$writtenOption[""] = "";
		for($i=1;$i<=10;$i++){
			$writtenOption["".$i] = $i;
		}
		$written->setMultiOptions($writtenOption);
		$elements[] = $written;
		
		$this->addElements($elements);
		
		$formElements = $this->getElements();
		foreach($formElements as $formElement){
			$formElement->setView($view);
		}
		
	}
	
}
