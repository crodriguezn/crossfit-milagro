<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_System_Setting_Param extends MY_Form
{
    public $name_system;
    public $name_key_system;
    public $logo;
    public $session_time_limit_min;
    public $session_time_limit_max;
    public $isSaveBinnacle;


    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->name_system = '';
        $this->name_key_system = '';
        $this->logo = '';
        $this->session_time_limit_min = '';
        $this->session_time_limit_max = '';
        $this->isSaveBinnacle = 1;
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->name_system              = $MY->input->post('name_system');
        $this->name_key_system          = $MY->input->post('name_key_system');
//        $this->logo                     = $MY->input->post('logo');
        $this->session_time_limit_min   = $MY->input->post('session_time_limit_min');
        $this->session_time_limit_max   = $MY->input->post('session_time_limit_max');
        $this->isSaveBinnacle           = $MY->input->post('isSaveBinnacle');
        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->name_system) )
        {
            $this->addError('name_system', 'Campo no debe estar vacío');
        }
        if( empty($this->name_key_system) )
        {
            $this->addError('name_key_system', 'Campo no debe estar vacío');
        }
        if( empty($this->session_time_limit_min) )
        {
            $this->addError('session_time_limit_min', 'Campo no debe estar vacío');
        }     
        if( empty($this->session_time_limit_max) )
        {
            $this->addError('session_time_limit_max', 'Campo no debe estar vacío');
        }     
        
        return $this->isErrorEmpty();
    }
    
       
    public function getConfigurationSystemEntity()
    {
        $eConfigurationSystem = new eConfigurationSystem(FALSE);
        
        $eConfigurationSystem->name_system              = $this->name_system;
        $eConfigurationSystem->name_key_system          = $this->name_key_system;
        $eConfigurationSystem->session_time_limit_max   = $this->session_time_limit_max;
        $eConfigurationSystem->session_time_limit_min   = $this->session_time_limit_min;
        $eConfigurationSystem->isSaveBinnacle           = ($this->isSaveBinnacle=='on') ? 1 : 0 ;
        
        return $eConfigurationSystem;
    }
        
    
    public function setConfigurationSystemEntity(eConfigurationSystem $eConfigurationSystem )
    {
        $this->name_system              = $eConfigurationSystem->name_system ;
        $this->name_key_system          = $eConfigurationSystem->name_key_system ;
        $this->session_time_limit_max   = $eConfigurationSystem->session_time_limit_max ;
        $this->session_time_limit_min   = $eConfigurationSystem->session_time_limit_min ;
        $this->isSaveBinnacle           = (empty($eConfigurationSystem->isSaveBinnacle)) ? 0 : 1 ;
        
        if( !file_exists( BASEPATH . '../' .$eConfigurationSystem->logo ) )
        {
            $this->logo = 'resources/img/nologo.png';
        }
        else
        {
            $this->logo = $eConfigurationSystem->logo ;
        }
        
    }   
    
}
