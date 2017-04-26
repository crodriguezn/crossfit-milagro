<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management_Class_Scheduling_Permission extends MY_Permission
{
    public $create = FALSE;
    public $update = FALSE;

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}