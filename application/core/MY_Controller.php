<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $name_key = '';
    protected $permission = NULL;
    
    protected $link;
    protected $linkx;
    
    const SYSTEM_0 = 0;
    const SYSTEM_ADMINISTRATOR = 1;
    const SYSTEM_APP = 2;
    const SYSTEM_PUBLIC = 3;
    const SYSTEM_PROCESS = 4;
    
    function __construct( $SYSTEM_NAME = MY_Controller::SYSTEM_0 )
    {
        parent::__construct();        

        // application
        $this->lang->load('upload', 'spanish');
        
        // AUTOLOAD
        // libraries: upload, libsession
        // helper: url, encrypt, log, fecha, array, email, file, captcha, request, browser
        // config: cah
        // models: default
        // entities: default/*
        
        if( $SYSTEM_NAME == MY_Controller::SYSTEM_ADMINISTRATOR )
        {
            $this->link  = "administrator/" . $this->name_key;
            $this->linkx = "administrator/" . $this->name_key . 'x';
        }
        else if( $SYSTEM_NAME == MY_Controller::SYSTEM_APP )
        {
            $this->load->database();
            $this->link  = "app/" . $this->name_key;
            $this->linkx = "app/" . $this->name_key . 'x';
        }
        else if( $SYSTEM_NAME == MY_Controller::SYSTEM_PUBLIC )
        {
            $this->load->database();
            $this->link  = "public/" . $this->name_key;
            $this->linkx = "public/" . $this->name_key . 'x';
        }
        else if( $SYSTEM_NAME == MY_Controller::SYSTEM_PROCESS )
        {
            $this->load->database();   
            //$this->load->database('digifort', FALSE, NULL, 'dbd');
            $this->link  = "process/" . $this->name_key;
            $this->linkx = "process/" . $this->name_key . 'x';
        }
    }
    
    public function redirect( $uri )
    {
        redirect($uri);
    }
    
    /*
     * Se imvoca solamente para mandar permisos del modulo a los js del mvc
     */
    public function mvcjs()
	{
        $js_path = str_replace('_', '/', $this->name_key);
        
        $params = array();
        
        Helper_App_JS::showMVC($js_path, $params);
    }
    
    public function permissionCan( $permission_key )
    {
        return in_array($permission_key, $this->Module_Permissions);
    }

    
}