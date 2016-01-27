<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    function __construct()
    {
        parent::__construct( self::SYSTEM_PUBLIC );
    }

    public function index()
    {
        /*$sql = 'select * from T_ANALYTICS_ZONE_NAME';
        $data = $this->db->query($sql);
        
        print_r($result_array = $data->result_array());*/
        Helper_Public_View::layout('public/html/pages/dashboard');
    }
    
    public function mvcjs( )
    {
        Helper_Public_View::view("public/js/dashboard.js");
    }
    
    
}