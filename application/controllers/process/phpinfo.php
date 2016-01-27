<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PhpInfo extends MY_Controller
{
   
    function __construct()
    {
        parent::__construct( self::SYSTEM_PROCESS );
    }

    public function index()
    {
        // Muestra toda la información, por defecto INFO_ALL
        echo phpinfo();

        // Muestra solamente la información de los módulos.
        // phpinfo(8) hace exactamente lo mismo.
        echo phpinfo(INFO_MODULES);
    }
}