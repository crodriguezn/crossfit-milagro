<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Response_Flash extends MY_Response
{
    const FLASH_SUCCESS = 0;
    const FLASH_INFO = 1;
    const FLASH_WARNING = 2;
    const FLASH_ERROR = 3;

    protected $flash_type;
    
    public function __construct( $flash_type=NULL )
    {
        parent::__construct();
        
        $this->flash_type = $flash_type;
    }
    
    public function flashType( $flash_type = NULL )
    {
        if( is_null($flash_type) )
        {
            return $this->flash_type;
        }
        
        $this->flash_type = $flash_type;
    }
    
    public function getFlashTypeText()
    {
        $text = '';
        
        switch( $this->flash_type )
        {
            case self::FLASH_SUCCESS:
                $text = 'success';
                break;
            case self::FLASH_INFO:
                $text = 'info';
                break;
            case self::FLASH_WARNING:
                $text = 'warning';
                break;
            case self::FLASH_ERROR:
                $text = 'error';
                break;
            default:
                break;
        }
        
        return $text;
    }
    
    public function isEmpty()
    {
        return is_null($this->flash_type);
    }
}

