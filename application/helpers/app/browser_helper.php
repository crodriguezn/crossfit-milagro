<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_App_Browser
{

    static public function setCookie()
    {
        $MY =& MY_Controller::get_instance();
        
        $cookie = array(
                        'name'   => 'browser',
                        'value'  => Helper_App_Session::isIExplorer() ? 1:0,
                        'expire' => time() + 86500,/* 24 horas */
                        'domain' => '.localhost',
                        'path'   => '/app'
                        //'prefix' => 'app_',
                    );
        
        $MY->libcookie->set( $cookie );
        
    }
    
    static public function getCookie()
    {
        $MY =& MY_Controller::get_instance();
        
        return $MY->libcookie->get( 'browser' );

    }

    static public function deleteCookie()
    {
        $MY =& MY_Controller::get_instance();

        $cookie = array(
                        'name'   => 'browser',
                        'value'  => '',
                        'expire' => '0',
                        'domain' => '.localhost',
                        'prefix' => 'app_'
                    );

        $MY->libcookie->delete( $cookie );
    }

    static public function isCookie()
    {
        print_r($_COOKIE['browser']);
            
        //return self::getCookie() !== FALSE;
    }
    
}
