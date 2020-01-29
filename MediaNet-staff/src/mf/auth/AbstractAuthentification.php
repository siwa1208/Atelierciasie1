<?php

namespace mf\auth;

abstract class AbstractAuthentification {

    const ACCESS_LEVEL_NONE = -9999; 
  
    protected $user_login   = null;

    protected $access_level = self::ACCESS_LEVEL_NONE; 

    protected $logged_in    = false;

    public function __get($attr_name) {
        if (property_exists( __CLASS__, $attr_name))
            return $this->$attr_name;
        $emess = __CLASS__ . ": unknown member $attr_name (__get)";
        throw new \Exception($emess);
    }
    
    public function __set($attr_name, $attr_val) {
        if (property_exists( __CLASS__, $attr_name)) 
            $this->$attr_name=$attr_val; 
        else{
            $emess = __CLASS__ . ": unknown member $attr_name (__set)";
            throw new \Exception($emess);
        }
    }

    public function __toString(){
        return json_encode(get_object_vars($this));
    } 

    abstract protected function updateSession($adresse_mail, $level);

    abstract public function logout();
    
    abstract public function checkAccessRight($requested);

    abstract public function login($adresse_mail, $db_pass, $given_pass, $level);
    
    abstract protected function hashPassword($password);

    abstract protected function verifyPassword($password, $hash);
}