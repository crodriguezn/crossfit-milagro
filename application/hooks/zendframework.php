<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ZendFramework
{
    public function __construct()
    {
        ;
    }
    
    public function init()
    {
        $paths = array(
            get_include_path(),
            BASEPATH . '../application/third_party/zend/library'
        );

        set_include_path(implode(PATH_SEPARATOR, $paths)); 

        require_once 'Zend/Loader/Autoloader.php';
        Zend_Loader_Autoloader::getInstance();
    }
}