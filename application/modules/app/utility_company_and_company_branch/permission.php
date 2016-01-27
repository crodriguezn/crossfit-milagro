<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility_Company_And_Company_Branch_Permission extends MY_Permission
{
    public $access_company = FALSE;
    public $update_company = FALSE;
    public $access_branch = FALSE;
    public $create_branch = FALSE;
    public $update_branch = FALSE;
    public $update_logo_company = FALSE;

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}