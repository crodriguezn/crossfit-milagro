<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zend extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        echo "ZEND";
    }
    
    public function gdata()
    {
        require_once BASEPATH . '../application/third_party/zend/demos/Zend/Gdata/Docs.php';
    }
}

