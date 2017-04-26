<?php 
/*
 * @author Carlos Luis Rodriguez Nieto <taylorluis93@gmail.com>
 * @date 15-oct-2016
 * @time 23:15:58
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class libSession
{
    const session_name = 'crossfit';

    protected $session_group = array(self::session_name);

    public function __construct( $params=array() )
    {
        if( isset($params['session_group']) )
        {
            $this->session_group[self::session_name] = $params['session_group'];
        }

        $this->start();
    }

    function start()
    {
        if( !isset($_SESSION) )
        {
            
            @session_start();
            @session_set_cookie_params(0, "/", $HTTP_SERVER_VARS["HTTP_HOST"], 0); //cambiamos la duración a la cookie de la sesión 
            
        }
    }

    function id()
    {
        return session_id();
    }

    function setSessionGroup($session_group)
    {
        $this->session_group[self::session_name] = $session_group;
    }

    function set($key, $value)
    {
        $_SESSION[$this->session_group[self::session_name]][$key] = $value;
        
    }

    function rem($key)
    {
        if( isset($_SESSION[$this->session_group[self::session_name]][$key]) )
        {
            unset($_SESSION[$this->session_group[self::session_name]][$key]);
        }
    }

    function get( $key, $default=FALSE)
    {
        return isset($_SESSION[$this->session_group[self::session_name]][$key]) && !empty($_SESSION[$this->session_group[self::session_name]][$key]) ? $_SESSION[$this->session_group[self::session_name]][$key] : $default;
    }

    function getAll()
    {
        return $_SESSION[$this->session_group[self::session_name]];
    }

    function getFull()
    {
        return $_SESSION;
    }

    function destroy()
    {
        if( !empty($_SESSION[$this->session_group[self::session_name]]) )
        {
            unset($_SESSION[$this->session_group[self::session_name]]);
            //session_destroy();
        }
    }

    function destroyFull()
    {
        unset($_SESSION);
    }
}
