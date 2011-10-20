<?php 
/**
 * @category Ip
 * @package Ip_Session
 * @subpackage Ip_Session_SaveHandler
 * @author DEV 19 <dev19@cleo-consulting.fr>
 * @copyright DEV 19
 * @version Release:0.1beta (2011-10-17)
 *
 */

/**
 * Gestionnaire d'enregistrement des sessions en base de données
 * @category Ip
 * @package Ip_Session
 * @subpackage Ip_Session_SaveHandler
 * @author DEV 19 <dev19@cleo-consulting.fr>
 * @copyright DEV 19
 * @version Release:0.1beta (2011-10-17)
 *
 */
class Ip_Session_SaveHandler_Db implements Zend_Session_SaveHandler_Interface 
{
	
	private $_db;
	private $_gc_maxlifetime;
	
	/**
	 * Class constructor, sets dbApater
	 * @param Zend_Db $dbAdapter
	 */
	public function __construct($dbAdapter, $gcMaxlifetime) {
		$this->_db = $dbAdapter;
		$this->_gc_maxlifetime = $gcMaxlifetime;
		
	}
	/* (non-PHPdoc)
	 * @see Zend_Session_SaveHandler_Interface::open()
	 */
	public function open($save_path, $name) {
		
		$this->gc($this->_gc_maxlifetime);
		return true;
	}

	/* (non-PHPdoc)
	 * @see Zend_Session_SaveHandler_Interface::close()
	 */
	public function close() {
		$this->gc($this->_gc_maxlifetime);
		return true;
	}

	/* (non-PHPdoc)
	 * @see Zend_Session_SaveHandler_Interface::read()
	 */
	public function read($id) {
		$query = 'SELECT sess_data FROM session WHERE sess_id = :id';
		$data = $this->_db->fetchRow($query, array('id' => $id));
		$hasData = (bool) $data !== null;
		return $hasData ? $data['sess_data'] : '';
	}

	/* (non-PHPdoc)
	 * @see Zend_Session_SaveHandler_Interface::write()
	 */
	public function write($id, $data) {
		
		$session = array( 'sess_id' => $id,
						  'sess_time' => date('Y-m-d H:i:s'),
						  'sess_data' => $data,
						  'sess_ip' => ip2long($_SERVER['REMOTE_ADDR'])
						);
						
		$where = $this->_db->quoteInto('sess_id = ?', $id );
		$rows = $this->_db->update('session', $session, $where);	
		if( $rows != 1) {
			$rows= $this->_db->insert('session', $session);
		}			
		return $rows;
	}

	/* (non-PHPdoc)
	 * @see Zend_Session_SaveHandler_Interface::destroy()
	 */
	public function destroy($id) {
		$where = $this->_db->quoteInto('sess_id = ?', $id );
		$this->_db->delete('session', $where);
		return true;		
	}

	/* (non-PHPdoc)
	 * @see Zend_Session_SaveHandler_Interface::gc()
	 */
	public function gc($maxlifetime) {
		$where = 'sess_time < DATE_SUB(NOW(), INTERVAL ' . $maxlifetime . ' SECOND)';
		$this->_db->delete('session', $where);	
	}

	
	
}