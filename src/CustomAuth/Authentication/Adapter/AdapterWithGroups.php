<?php

namespace CustomAuth\Authentication\Adapter;

use ZendServer\Authentication\Adapter\IdentityGroupsProvider;

/**
 * 
 * @author yonni.m@zend.com
 *
 */
class AdapterWithGroups extends Adapter implements IdentityGroupsProvider {
	
	/**
	 * @var array
	 */
	private $groups;
	
	/*
	 * (non-PHPdoc)
	 * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
	 */
	public function authenticate() {
		/// Used to allow developerLimited users read-only access to particular applications
		/// Groups can also be used to designate an identity's role
		$this->groups = array('administrators');
		
		$result = parent::authenticate();
		$identity = $result->getIdentity();
		$identity->setRole(null);
		$identity->setGroups($this->groups);
		return $result;
	}
	
	/* (non-PHPdoc)
	 * @see \ZendServer\Authentication\Adapter\IdentityGroupsProvider::isGroupsProvider()
	 */
	public function getIdentityGroups() {
		return $this->groups;
	}
}

