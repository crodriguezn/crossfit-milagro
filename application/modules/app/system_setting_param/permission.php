<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Setting_Param_Permission extends MY_Permission
{
    public $update = FALSE;

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}