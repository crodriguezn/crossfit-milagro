<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_BackUp_DB_Permission extends MY_Permission
{

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}