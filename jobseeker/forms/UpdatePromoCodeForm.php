<?php
class UpdatePromoCodeForm extends Zend_Form{
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
		
		$promocode = new Zend_Form_Element_Text("promocode");
		$promocode->setRequired(true);
		$promocode->class = "span4";
		$elements[] = $promocode;
		
		$this->addElements($elements);
		
		$formElements = $this->getElements();
		foreach($formElements as $formElement){
			$formElement->setView($view);
		}
		
	}
}