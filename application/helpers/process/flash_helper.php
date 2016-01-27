<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper_Process_Flash
{
    static protected $params_session = array('session_group'=>'process_flash');
    
    static function set(Response_Flash $oFlash, $name_key='_default_' )
    {
        $name_key = "_process_flash_$name_key";
		
        self::setVar($name_key, serialize($oFlash) );
    }
    
    static function get( $name_key='_default_' )
    {
        $name_key = "_process_flash_$name_key";
        $value    = self::getVar($name_key);
        
        self::remVar( $name_key );
        
        /* @var $rFlash Response_Flash */
        $oFlash = ( $value === FALSE ) ? new Response_Flash() : unserialize($value);
        
        return $oFlash;
    }
    
    // *******************************************************
    
    static function getVar( $name_key )
    {
        $MY =& MY_Controller::get_instance();
        
        $MY->libsession->setSessionGroup( self::$params_session['session_group'] );

        return $MY->libsession->get( $name_key );
    }
    
    static function setVar( $name_key, $value )
    {
        $MY =& MY_Controller::get_instance();
        
        $MY->libsession->setSessionGroup( self::$params_session['session_group'] );
        $MY->libsession->set($name_key, $value);
    }
    
    static function remVar( $name_key )
    {
        $MY =& MY_Controller::get_instance();
        
        $MY->load->library('libsession');
        $MY->libsession->setSessionGroup( self::$params_session['session_group'] );
        $MY->libsession->rem( $name_key );
    }
}