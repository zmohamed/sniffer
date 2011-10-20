<?php

class Core_Form_Login extends Zend_Form
{
	public function init()
	{
		$username = new Zend_Form_Element_Text('username');
		$username->setRequired(true)
				 ->addFilter(new Zend_Filter_StripTags)
				 ->addValidator(new Zend_Validate_Alnum)
				 ->addValidator(new Zend_Validate_StringLength(array( 'min' => 4,
				 													  'max' => 30
				 											   ))
				 				);
		
		$password = new Zend_Form_Element_Password('password');
		$password->setRequired(true)
				 ->addValidator(new Zend_Validate_StringLength(array( 'min' => 6,
				 													  'max' => 50
				 											   ))
				 				);
				 				
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setIgnore(true);
		
		$this->addElements(array($username, $password, $submit));
	}
}