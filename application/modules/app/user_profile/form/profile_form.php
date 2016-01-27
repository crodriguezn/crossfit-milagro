<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Profile extends MY_Form
{
    const isUserProfile = 0;
    const AcountUserProfile = 1;
    
    protected $typeForm;
    
    
    public $name;
    public $surname;
    public $tipo_documento;
    public $document;
    public $birthday;
    public $gender;
    public $address;
    public $phone_cell;
    public $email;
    public $estado_civil;
    public $tipo_sangre;
    public $id_ciudad;
    public $id_pais;
    public $id_provincia;
    public $name_profile;


    public function __construct( $isReadPost=FALSE, $typeForm = self::isUserProfile )
    {
        parent::__construct();
        
        
        $this->typeForm = $typeForm;
        
        $this->name             = '';
        $this->surname          = '';
        $this->tipo_documento   = 'TIPO_IDENT_CEDULA';
        $this->document         = '';
        $this->birthday         = '';
        $this->gender           = 'GENDER_MALE';
        $this->address          = '';
        $this->phone_cell       = '';
        $this->email            = '';
        $this->estado_civil     = 'ESTADO_CIVIL_SOLTERO';
        $this->tipo_sangre      = 'TIPO_SANGRE_A+';
        $this->id_provincia     = 1558;
        $this->id_pais          = 70;
        $this->id_ciudad        = 47949;
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        $this->name             = $MY->input->post('name');
        $this->surname          = $MY->input->post('surname');
        $this->tipo_documento   = $MY->input->post('tipo_documento');
        $this->document         = $MY->input->post('document');
        $this->birthday         = $MY->input->post('birthday');
        $this->gender           = $MY->input->post('gender');
        $this->address          = $MY->input->post('address');
        $this->phone_cell       = $MY->input->post('phone_cell');
        $this->email            = $MY->input->post('email');
        $this->estado_civil     = $MY->input->post('estado_civil');
        $this->tipo_sangre      = $MY->input->post('tipo_sangre');
        $this->id_ciudad        = $MY->input->post('id_ciudad');
        
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->name) )
        {
            $this->addError('name', 'Campo no debe estar vacío');
        }
        
        if( empty($this->surname) )
        {
            $this->addError('surname', 'Campo no debe estar vacío');
        }    
        
        if( empty($this->tipo_documento) )
        {
            $this->addError('tipo_documento', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->document) )
        {
            $this->addError('document', 'Campo no debe estar vacío');
        }  
        
        if (empty($this->birthday)) 
        {
            $this->addError('birthday', 'Campo no debe estar vacío');
        }
        else
        {
            if(Helper_Fecha::validar_fecha($this->birthday) === false)
            {
                $this->addError('birthday', 'Ingrese una fecha válida');
            }
        }
        
        if( empty($this->gender) )
        {
            $this->addError('gender', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->address) )
        {
            $this->addError('address', 'Campo no debe estar vacío');
        }  
        
        /*if( empty($this->phone_cell) )
        {
            $this->addError('phone_cell', 'Campo no debe estar vacío');
        }*/
        
        if( empty($this->email) )
        {
            $this->addError('email', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->estado_civil) )
        {
            $this->addError('estado_civil', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->tipo_sangre) )
        {
            $this->addError('tipo_sangre', 'Campo no debe estar vacío');
        }  
        
        return $this->isErrorEmpty();
    }
    
       
    public function getPersonEntity()
    {
        $ePerson = new ePerson(FALSE);
        
        $ePerson->name              = $this->name;
        $ePerson->surname           = $this->surname;
        $ePerson->tipo_documento    = $this->tipo_documento;
        $ePerson->document          = $this->document;
        $ePerson->birthday          = $this->birthday;
        $ePerson->gender            = $this->gender;
        $ePerson->address           = $this->address;
        $ePerson->phone_cell        = $this->phone_cell;
        $ePerson->email             = $this->email;
        $ePerson->estado_civil      = $this->estado_civil;
        $ePerson->tipo_sangre       = $this->tipo_sangre;
        $ePerson->id_ciudad         = empty($this->id_ciudad) ? NULL : $this->id_ciudad ;
        
        return $ePerson;
    }
        
    
    
    public function setPersonEntity(ePerson $ePerson )
    {
        $this->name             = $ePerson->name;
        $this->surname          = $ePerson->surname;
        $this->tipo_documento   = $ePerson->tipo_documento;
        $this->document         = $ePerson->document;
        $this->birthday         = $ePerson->birthday;
        $this->gender           = $ePerson->gender;
        $this->address          = $ePerson->address;
        $this->phone_cell       = $ePerson->phone_cell;
        $this->email            = $ePerson->email;
        $this->estado_civil     = $ePerson->estado_civil;
        $this->tipo_sangre      = $ePerson->tipo_sangre;
        $this->id_ciudad        = $ePerson->id_ciudad;
    }   
    
}
