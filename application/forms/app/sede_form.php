<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_Sede extends MY_Form
{
    public $id_sede;
    public $nombre;
    public $direccion;
    public $telefono;
    public $rector_nacional;
    public $secretaria;
    public $isActive;
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->id_sede = 0;
        $this->nombre = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->rector_nacional = '';
        $this->secretaria = '';
        $this->isActive = 0;
            
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->id_sede          = $MY->input->post('id_sede');
        $this->nombre           = $MY->input->post('nombre');
        $this->direccion        = $MY->input->post('direccion');
        $this->telefono         = $MY->input->post('telefono');
        $this->rector_nacional  = $MY->input->post('rector_nacional');
        $this->secretaria       = $MY->input->post('secretaria');
        $this->isActive         = $MY->input->post('isActive');        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->nombre) )
        {
            $this->addError('nombre', 'Campo no debe estar vacío');
        }
        
        if( empty($this->direccion) )
        {
            $this->addError('direccion', 'Campo no debe estar vacío');
        }
        
        if( empty($this->telefono) )
        {
            $this->addError('telefono', 'Campo no debe estar vacío');
        }
        
        return $this->isErrorEmpty();
    }
    
    public function setSedeEntity( eSede $eSede )
    {
        $this->id_sede = $eSede->id;
        $this->nombre = $eSede->nombre;
        $this->direccion = $eSede->direccion;
        $this->telefono = $eSede->telefono;
        $this->rector_nacional = $eSede->rector_nacional;
        $this->secretaria = $eSede->secretaria;
        $this->isActive = $eSede->isActive;
    }
    
    public function getSedeEntity()
    {
        $eSede = new eSede(FALSE);
        
        $eSede->id = empty($this->id_sede) ? NULL : $this->id_sede;
        $eSede->nombre = $this->nombre;
        $eSede->direccion = $this->direccion;
        $eSede->telefono = $this->telefono;
        $eSede->rector_nacional = $this->rector_nacional;
        $eSede->secretaria = $this->secretaria;
        $eSede->isActive = $this->isActive;
        
        return $eSede;
    }       
}