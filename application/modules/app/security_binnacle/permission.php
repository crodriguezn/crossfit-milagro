<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_Binnacle_Permission extends MY_Permission
{
    public $view = FALSE;

    function __construct($module_name_key)
    {
        parent::__construct($module_name_key);
    }
}