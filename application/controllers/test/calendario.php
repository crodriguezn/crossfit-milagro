<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendario extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        print_r(Helper_Calendario::genera_calendario(2016, 01));
        echo "TEST 001";
    }
    
	
}

