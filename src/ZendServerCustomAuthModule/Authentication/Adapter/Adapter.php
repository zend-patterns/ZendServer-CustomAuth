<?php

namespace ZendServerCustomAuthModule\Authentication\Adapter;

use Users\Identity;
use ZendServer\Authentication\Adapter\AdapterInterface;
use Application\Module;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AbstractAdapter;

/**
 * 
 * @author yonni.m@zend.com
 * 
 */
class Adapter extends AbstractAdapter {
    
    private $model;
    
    /*
     * (non-PHPdoc)
     * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
     */
    public function authenticate() {
        
        // check if the user exists
        $user = $this->getModel()->getUser($this->getIdentity(), $this->getCredential());
        
        if (!$user) {
            return new Result(Result::FAILURE, new Identity());
        }
        
        // find the role
        // Available roles: Module::ACL_ROLE_ADMINISTRATOR, Module::ACL_ROLE_DEVELOPER
        $role = Module::ACL_ROLE_DEVELOPER;
        if ($user[$this->getModel()::COLUMN_ROLE] == Module::ACL_ROLE_ADMINISTRATOR) {
            $role = Module::ACL_ROLE_ADMINISTRATOR;
        }
        
        // create identity
        $identity = new Identity($this->getIdentity(), $role);
        $identity->setUsername($this->getIdentity());
        
        return new Result(Result::SUCCESS, $identity);
    }

    /**
     * @param  $model
     */
    public function setModel($model) {
        $this->model = $model;
    }
    
    /**
     * @return 
     */
    public function getModel() {
        return $this->model;
    }
}

