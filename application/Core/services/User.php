<?php

final class Core_Service_User 
{
	
	public function create(Core_Model_User $user)
	{
		
	}
	
	public function update(Core_Model_User $user)
	{
		
	}
	
	public function read($userId)
	{
		
	}
	
	public function delete(Core_Model_User $user)
	{
		
	}
	
	public function authenticate($login, $password)
	{
		$authAdapter = new Zend_Auth_Adapter_DbTable();
		$authAdapter->setTableName('user')
					->setIdentityColumn('user_login')
					->setCredentialColumn('user_password')
					->setIdentity($login)
					->setCredential($password);
	    $auth = Zend_Auth::getInstance();
	    
	    $authResult = $auth->authenticate($authAdapter);
	    
	    if( $authResult->isValid()) {
	    	$authData = $authAdapter->getResultRowObject(null, 'user_password');
	    	$auth->getStorage()->write($authData);
	    	return true;
	    } else {
	    	return false;
	    }
	}
}












