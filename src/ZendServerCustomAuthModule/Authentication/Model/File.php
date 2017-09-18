<?php

namespace ZendServerCustomAuthModule\Authentication\Model;


class File {
    
    const COLUMN_ROLE = 0;
    const COLUMN_USER = 1;
    const COLUMN_PASSWORD = 2;
    
    /**
     * @var string
     */
    private $dataFilePath = false;
    
    /**
     * @var array
     */
    private $usersCache = null;
    
    /**
     * Check if the identity and the credential are right
     * @param mixed $username 
     * @param mixed $password 
     * @return array|false
     */
    public function getUser($username, $password) {
        if (is_null($this->usersCache)) {
            // read the whole file and store it locally
            $this->usersCache = file($this->dataFilePath);
        }
        
        // look for the user in the list
        foreach ($this->usersCache as $userRow) {
            // user row format <group>:<username>:<MD5 hashed password>
            $userData = explode(':', trim($userRow));
            
            // basic row validation
            if (empty($userData) || count($userData) != 3) {
                continue;
            }
            
            // compare
            if ($userData[self::COLUMN_USER] == $username && $userData[self::COLUMN_PASSWORD] == md5($password)) {
                return $userData;
            }
        }
        
        return false;
    }
    
    /**
     * @param string $dataFilePath
     */
    public function setDataFilePath($dataFilePath) {
        if (!file_exists($dataFilePath) || !is_readable($dataFilePath)) {
            throw new \Exception('The file "'.$dataFilePath.'" is not accessible');
        }
        
        $this->dataFilePath = $dataFilePath;
    }
    
    /**
     * @return string
     */
    public function getDataFilePath() {
        return $this->dataFilePath;
    }
}