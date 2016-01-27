<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Block extends MY_Controller
{
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        Helper_App_Session::setBlock(TRUE);
        
        $this->redirect('app/login_advanced');
        
    }
}