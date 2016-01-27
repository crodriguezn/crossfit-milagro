<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _Default extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->redirect('app/login');
    }
}