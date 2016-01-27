<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Js extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function core()
    {
        $params = array(
            'site_url' => site_url(),
            'base_url' => base_url(),
            'index_page' => index_page()
        );
        
        Helper_App_View::view("app/js/core.js", $params);
    }
    
    /*public function load( $script )
    {
        //administrator_personal_listing ->administrator/personal/listing
        $js_path = str_replace('_', '/', $script);
        
        Helper_App_View::view("app/js/$js_path/controller.js");
        Helper_App_View::view("app/js/$js_path/model.js");
        Helper_App_View::view("app/js/$js_path/view.js");
    }*/
    
    public function mvc( $js_folder )
    {
        $params = array();
        
        Helper_App_JS::showMVC($js_folder, $params);
    }
}