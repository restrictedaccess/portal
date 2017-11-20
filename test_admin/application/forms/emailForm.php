<?php

class emailForm extends Zend_Form {
	
	public function init() {		

		$this->setMethod('get');
		$this->setAttribs(array('id'=>'testform','target'=>'ajaxframe', 'action'=>'index.php?item=newsession'));
		
		
		$fname = $this->createElement('text', 'fname');
		$fname->setLabel('First Name:')
		->setAttrib('style','width:200px;float:left')
		->setAttrib('id','')
		->setIsArray(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Alnum', true, array('allowWhiteSpace'=>true))
		->setAllowEmpty(false)
		->addErrorMessage('Invalid Name String');
		
		$email = $this->createElement('text', 'emailaddr');
		$email->setLabel('Email:')
		->setAttrib('style','width:200px;float:left')
		->setAttrib('id','')
		->setIsArray(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('EmailAddress', true)
		->addErrorMessage('Invalid Email Address.');
		//->setValidators(array(new Zend_Validate_EmailAddress(array('domain'=>true))) );
		
		
		$this->addElements(array($fname, $email));
		//$this->addElement($email);
		
		// element decorators
		$this->setElementDecorators(array(
			'ViewHelper',
			 array('Errors'),
			array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')), 'Label',
			array(array('LabelWrap' => 'HtmlTag'), array('tag' => 'td', 'class' => 'label', 'style'=>'width:80px;')),
			array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
		));
		
		// form decorators
		$this->setDecorators(array(
			'FormElements',
			array('HtmlTag',array('tag' => 'table')),
			'Form'
		));
	}
}