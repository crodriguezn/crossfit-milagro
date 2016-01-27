<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autoloader_Hook
{
    public function __construct()
    {
        ;
    }
    
    public function init()
    {
        $this->core();
        $this->business();
        $this->responses();
        $this->helpers();
    }
    
    public function core()
    {
        // class: MY_Business
        // path: application/core/MY_Business.php
        
        spl_autoload_register( function($class) {
            if( substr($class, 0, strlen("MY_") ) != "MY_" ){ return; }
            
            $class = "application/core/" . $class . '.php';
            
            $path = BASEPATH . '../' . $class;
            if( file_exists($path) )
            {
                require_once $path;
                //Helper_Log::write($path);
            }
        });
    }
    
    public function business()
    {
        // class: Business_App_Admision
        // path: application/business/app/admision_business.php
        
        spl_autoload_register( function($class) {
            if( substr($class, 0, strlen("Business") ) != "Business" ){ return; }
            
            //$class = strtolower($class);
            list($business, $folder, $name) = preg_split('/_/', strtolower($class), 3);
            
            $class = "application/$business/$folder/" . $name . '_business.php';
            
            $path = BASEPATH . '../' . $class;
            if( file_exists($path) )
            {
                require_once $path;
                //Helper_Log::write($path);
            }
        });
    }
    
    private function responses()
    {
        // class: Response_Ajax
        // path: application/responses/ajax_response.php
        
        spl_autoload_register( function($class) {
            if( substr($class, 0, strlen("Response") ) != "Response" ){ return; }
            
            //$class = strtolower($class);
            list($response, $name) = preg_split('/_/', strtolower($class), 2);
            
            $class = "application/".$response."s/" . $name . '_response.php';
            
            $path = BASEPATH . '../' . $class;
            if( file_exists($path) )
            {
                require_once $path;
                //Helper_Log::write($path);
            }
        });
    }
    
    private function helpers()
    {
        // class: Helper_Array
        // path: application/helpers/array_helper.php
        
        // class: Helper_App_Session
        // path: application/helpers/app/session_helper.php
        
        spl_autoload_register( function($class) {
            if( substr($class, 0, strlen("Helper") ) != "Helper" ){ return; }
            
            //$class = strtolower($class);
            list($helper, $name) = preg_split('/_/', strtolower($class), 2);
            
            $path = BASEPATH . "../application/".$helper."s/" . $name . '_helper.php';
            if( file_exists($path) )
            {
                require_once $path;
                return;
            }
            
            //$class = strtolower($class);
            list($helper, $folder, $name) = preg_split('/_/', strtolower($class), 3);
            
            $path = BASEPATH . '../' . "application/". $helper ."s/".$folder."/" . $name . '_helper.php';
            if( file_exists($path) )
            {
                require_once $path;
                return;
            }
        });
    }
}
