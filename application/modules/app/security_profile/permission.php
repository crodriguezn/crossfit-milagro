<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_Profile_Permission extends MY_Permission
{
    public $create              = FALSE;
    public $update              = FALSE;
    public $view_permission     = FALSE;
    public $update_permission   = FALSE;

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}