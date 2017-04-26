<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_Customer_Crossfit_Permission extends MY_Permission
{
    public $create = FALSE;
    public $update = FALSE;
    public $access_imc = FALSE;
    public $create_imc = FALSE;

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}