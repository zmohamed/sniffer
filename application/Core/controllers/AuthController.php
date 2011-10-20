<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
    	
    }

    public function loginAction()
    {
    	$this->_helper->layout()->setLayout('login');
    	$loginForm = new Core_Form_Login();
    	
    	if($this->getRequest()->isPost()) {
    		if($loginForm->isValid($_POST)) {
    			$userService = new Core_Service_User();
    			$login = $loginForm->getValue('username');
    			$password = $loginForm->getValue('password');
    			$result = $userService->authenticate($login, $password);
    			if(!$result) {
    				$this->view->message = 'login_failure';
    				$this->view->loginForm = $loginForm;
    			} else {
    				$this->_redirect($this->view->url(array(), 'index'));
    			}
    		} else {
    			$this->view->loginForm = $loginForm;
    		}
    	} else {
    		$this->view->loginForm = $loginForm;
    	}  
    }


}

