<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class libSession
{
    protected $session_group = 'default';

    public function __construct( $params=array() )
    {
        if( isset($params['session_group']) )
        {
            $this->session_group = $params['session_group'];
        }

        $this->start();
    }

    function start()
    {
        if( !isset($_SESSION) )
        {
            @session_start();
        }
    }

    function id()
    {
        return session_id();
    }

    function setSessionGroup($session_group)
    {
        $this->session_group = $session_group;
    }

    function set($key, $value)
    {
        $_SESSION[$this->session_group][$key] = $value;
    }

    function rem($key)
    {
        if( isset($_SESSION[$this->session_group][$key]) )
        {
            unset($_SESSION[$this->session_group][$key]);
        }
    }

    function get( $key, $default=FALSE)
    {
        return isset($_SESSION[$this->session_group][$key]) && !empty($_SESSION[$this->session_group][$key]) ? $_SESSION[$this->session_group][$key] : $default;
    }

    function getAll()
    {
        return $_SESSION[$this->session_group];
    }

    function getFull()
    {
        return $_SESSION;
    }

    function destroy()
    {
        if( !empty($_SESSION[$this->session_group]) )
        {
            unset($_SESSION[$this->session_group]);
        }
    }

    function destroyFull()
    {
        unset($_SESSION);
    }
}
