<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Full_Path extends MY_Controller
{
   
    function __construct()
    {
        parent::__construct( self::SYSTEM_PROCESS );
    }

    public function index()
    {
        echo BASEPATH.'../application/';
    }
}