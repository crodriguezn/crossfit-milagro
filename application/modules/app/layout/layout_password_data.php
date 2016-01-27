<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_App_Layout_Password extends MY_Form
{
    public $password_current;
    public $password_new;
    public $password_new_repeat;
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->password_current = '';
        $this->password_new = '';
        $this->password_new_repeat = '';
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->password_current    = $MY->input->post('password_current');
        $this->password_new        = $MY->input->post('password_new');
        $this->password_new_repeat = $MY->input->post('password_new_repeat');
        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->password_current) )
        {
            $this->addError('password_current', 'Campo no debe estar vacío');
        }
        
        if( empty($this->password_new) )
        {
            $this->addError('password_new', 'Campo no debe estar vacío');
        }
        elseif($this->password_new != $this->password_new_repeat)
        {
            $this->addError('password_new', 'Comprobación incorrecta');
            $this->addError('password_new_repeat', 'Comprobación incorrecta');
        }
        elseif(strlen($this->password_new) < 6)
        {
            $this->addError('password_new', '6 mínimo tamaño contraseña');
            $this->addError('password_new_repeat', '6 mínimo tamaño contraseña');
        }
        
        return $this->isErrorEmpty();
    }
    
}