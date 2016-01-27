<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Permission
{
    public $access = TRUE;
    
    public function __construct( $module_name_key='' )
    {
        if( !empty($module_name_key) )
        {
            $this->load($module_name_key);
        }
    }
    
    public function load( $module_name_key )
    {
        $arr = get_class_vars( get_class($this) );
        foreach( $arr as $attr => $value )
        {
            $this->$attr = Helper_App_Session::isPermissionForModule($module_name_key, $attr);
        }
    }
    
    public function toArray()
    {
        return (array) $this;
    }
}