<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_App_Login extends MY_Data
{
    public $username;
    public $password;
    public $security;
    
    public function __construct( $isReadPost=FALSE )
    {
        $this->username = '';
        $this->password = '';
        $this->security = '';
            
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        /* @var $input CI_Input */
        $input =& $MY->input;
        
        $this->username = $input->post('username');
        $this->password = $input->post('password');
        $this->security = $input->post('security');
    }
    
    public function isValid( &$dataError/*REF*/, $isSecurity = TRUE )
    {
        $isValid = TRUE;
        
        $dataError = new $this();
        
        if( empty($this->username) )
        {
            $dataError->username = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        
        if( empty($this->password) )
        {
            $dataError->password = 'Campo no debe estar vacío'; $isValid=FALSE;
        }
        if($isSecurity)
        {
            if(ENVIRONMENT!='development')
            {
                if( empty($this->security) )
                {
                    $dataError->security = 'Campo no debe estar vacío'; $isValid=FALSE;
                }
            }
        }
        return $isValid;
    }
}