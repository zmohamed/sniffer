<?php

/**
 * @author Dev19
 *
 */
class Core_Model_User
{
	/**
	 * @var int
	 */
	private $_id;
	/**
	 * @var string
	 */
	private $_name;
	/**
	 * @var string
	 */
	private $_email;
	/**
	 * @var string
	 */
	private $_login;
	/**
	 * @var string
	 */
	private $_password;
	/**
	 * @return the $_id
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @param int $_id
	 */
	public function setId($_id) {
		$this->_id = $_id;
		return $this;
	}

	/**
	 * @return the $_name
	 */
	public function getName() {
		return $this->_name;
	}

	/**
	 * @param string $_name
	 */
	public function setName($_name) {
		$this->_name = $_name;
		return $this;
	}

	/**
	 * @return the $_email
	 */
	public function getEmail() {
		return $this->_email;
	}

	/**
	 * @param string $_email
	 */
	public function setEmail($_email) {
		$this->_email = $_email;
		return $this;
	}

	/**
	 * @return the $_login
	 */
	public function getLogin() {
		return $this->_login;
	}

	/**
	 * @param string $_login
	 */
	public function setLogin($_login) {
		$this->_login = $_login;
		return $this;
	}

	/**
	 * @return the $_password
	 */
	public function getPassword() {
		return $this->_password;
	}

	/**
	 * @param string $_password
	 */
	public function setPassword($_password) {
		$this->_password = $_password;
		return $this;
	}

	
	
	
	
	
	
	
}