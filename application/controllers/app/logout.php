<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends MY_Controller
{
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        //Helper_App_Activity::logout();
        
        Helper_App_Session::logout();
        
        $this->redirect('app/login');
        
    }
}