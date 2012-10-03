<?php

namespace CustomAuth\Authentication\Adapter;

use Zend\Authentication\Result;

use Users\Identity;

use ZendServer\Authentication\Adapter\AdapterInterface;

/**
 * 
 * @author yonni.m@zend.com
 * 
 */
class Adapter implements AdapterInterface {
	
	/**
	 * @var Identity
	 */
	private $identity;
	
	/**
	 * @var string
	 */
	private $credential;
	
	/*
	 * (non-PHPdoc)
	 * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
	 */
	public function authenticate() {
		/// Available roles: administrator (full access), developer (read-only for all applications), developerLimited (read only, no application specific data)
		/// You may omit the role parameter if you intend to designate a role using groups to roles mapping
		$identity = new Identity($this->credential, 'administrator');
		$identity->setUsername($this->credential);
		return new Result(Result::SUCCESS, $identity);
	}

	/*
	 * (non-PHPdoc)
	 * @see \ZendServer\Authentication\Adapter\AdapterInterface::setIdentity()
	 */
	public function setIdentity(Identity $identity) {
		$this->identity = $identity;
	}
	
	/*
	 * (non-PHPdoc)
	 * @see \ZendServer\Authentication\Adapter\AdapterInterface::setCredential()
	 */
	public function setCredential($credential) {
		$this->credential = $credential;
	}
}

