<?php

class Core_Model_Mapper_User
{
	/**
	 * @var Core_Model_DbTable_User
	 */
	private $_dbTable;
	
	private function _getDbTable()
	{
		if(!($this->_dbTable instanceof Core_Model_DbTable_User)){
			$this->_dbTable = new Core_Model_DbTable_User;
		}
		return $this->_dbTable;
	}
	
	 
}