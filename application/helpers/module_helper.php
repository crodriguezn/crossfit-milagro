<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Module
{
    const OS_UNKNOWN = 1;
    const OS_WIN = 2;
    const OS_LINUX = 3;
    const OS_OSX = 4;

    static public function load( &$controller, $module_folder, $isAjax=FALSE )
    {
        $this->load->file("application/modules/$module_folder/handler_".( !$isAjax ? 'controller' : 'ajax' ).".php");
        
        $folders = preg_split('/\//', strtolower($module_folder));
        
        $module_class_name = 'Module';
        foreach( $folders as $folder )
        {
            $module_class_name = '_' . ucfirst($folder) ;
        }
        
        $controller = new $module_class_name();
    }
}
