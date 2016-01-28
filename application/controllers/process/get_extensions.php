<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_Extensions extends MY_Controller
{
   
    function __construct()
    {
        parent::__construct( self::SYSTEM_PROCESS );
    }

    public function index()
    {
        print_r(get_loaded_extensions());
        print_r(extension_loaded('gd'));
    }
    
    
}