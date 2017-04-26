<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class libCookie
{

    public function __construct( )
    {
        $MY =& MY_Controller::get_instance();
        $MY->load->helper('cookie');
    }

    function set( $cookie )
    {
        set_cookie( $cookie );

    }

    function get( $prefixName )
    {
        return get_cookie( $prefixName );
    }

    function delete( $cookie )
    {
        delete_cookie( $cookie );
    }
    
}
