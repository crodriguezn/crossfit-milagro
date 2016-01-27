<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Torniquete extends MY_Controller
{
   
    function __construct()
    {
        parent::__construct( self::SYSTEM_PROCESS );
    }

    public function index()
    {
        $oRes = Business_Process_Torniquete::listAll($eT_ANALYTICS/*REF*/);
        print_r($eT_ANALYTICS);
    }
}