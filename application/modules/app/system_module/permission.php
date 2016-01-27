<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Module_Permission extends MY_Permission
{

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}