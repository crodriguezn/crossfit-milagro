<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Security_Rol extends MY_Form
{
    public $id_rol;
    public $name;
    public $name_key;
    public $id_modules;
    
    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        $this->id_rol = 0;
        $this->name = '';
        $this->name_key = '';
        $this->id_modules = array();
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->id_rol       = $MY->input->post('id_rol');
        $this->name         = $MY->input->post('name');
        $this->name_key     = $MY->input->post('name_key');
        $this->id_modules   = $MY->input->post('id_modules');
        $this->id_form      = $MY->input->post('id_form');
        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->name) )
        {
            $this->addError('name', 'Campo no debe estar vacío');
        }
        
        if( empty($this->name_key) )
        {
            $this->addError('name_key', 'Campo no debe estar vacío');
        }       
        
        return $this->isErrorEmpty();
    }
    
       
    public function getRolEntity()
    {
        $eRol = new eRol(FALSE);
        
        $eRol->id = empty($this->id_rol) ? NULL : $this->id_rol;
        $eRol->name = $this->name;
        $eRol->name_key = $this->name_key;
        if(empty($this->id_rol))
        {
            $eRol->isEditable = 1;
        }
        
        return $eRol;
    }
        
    public function getRolModuleEntities()
    {
        $eRolModules = array();
                  
        if( !empty($this->id_modules) )
        {
            foreach( $this->id_modules as $id_module ) 
            {

                $eRolModule             = new eRolModule(FALSE);
                $eRolModule->id_module  = $id_module;
                $eRolModule->id_rol     = $this->id_rol;

                $eRolModules[]=$eRolModule;
            }
        }
        
        return $eRolModules;
    }  
    
    public function setRolEntity(eRol $eRol )
    {
        $this->id_rol = $eRol->id;
        $this->name = $eRol->name ;
        $this->name_key = $eRol->name_key;
    }   
    
    public function setRolModuleEntities( $eRolModules )
    {
        if( !empty($eRolModules) )
        {
            /* @var $eRolModule eRolModule */
            foreach( $eRolModules as $eRolModule )
            {
                $this->id_modules[] = $eRolModule->id_module;
            }
        }
    }
    
    
    
    
}
