<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Log_Permission extends MY_Permission
{
    public $new = FALSE;
    public $update = FALSE;
    public $delete = FALSE;

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}