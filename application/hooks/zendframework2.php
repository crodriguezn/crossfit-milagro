<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ZendFramework2
{
    public function __construct()
    {
        ;
    }
    
    public function init()
    {
        spl_autoload_register( function($class) {
            if( substr($class, 0, strlen("Zend")) != "Zend"){ return; }

            $path = substr(str_replace('\\', '/', $class), 0);
            $path = BASEPATH . "../application/third_party/zend2/library/".$path . '.php';
            if( file_exists($path) ) { require_once $path; }
            else { echo $path; }
        });
    }
}