<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Company extends MY_Form
{
    public $name;
    public $name_key;
    public $description;
    public $phone;

    public function __construct($isReadPost = FALSE) 
    {
        parent::__construct();
        
        $this->name = '';
        $this->name_key = '';
        $this->description = '';
        $this->phone = '';
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }

    public function readPost()
    {
        $MY = & MY_Controller::get_instance();
        
        $this->name             = $MY->input->post('name');
        $this->description      = $MY->input->post('description');
        $this->name_key         = $MY->input->post('name_key');
        $this->phone            = $MY->input->post('phone');
    }

    public function isValid( )
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
        
        if( empty($this->description) )
        {
            $this->addError('description', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->phone) )
        {
            $this->addError('phone', 'Campo no debe estar vacío');
        }  
        
        return $this->isErrorEmpty();
    }

    public function setCompanyEntity( eCompany $eCompany )
    {
        $this->name         = $eCompany->name;
        $this->description  = $eCompany->description;
        $this->name_key     = $eCompany->name_key;
        $this->phone        = $eCompany->phone;
    }

    public function getCompanyEntity()
    {
        $eCompany = new eCompany(FALSE);
        
        $eCompany->name         = $this->name;
        $eCompany->description  = $this->description;
        $eCompany->name_key     = $this->name_key;
        $eCompany->phone        = $this->phone;
        
        return $eCompany;
    }
}
