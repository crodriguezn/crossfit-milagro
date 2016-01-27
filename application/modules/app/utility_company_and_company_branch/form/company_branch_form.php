<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_Company_Branch extends MY_Form
{
    public $id_company_branch;
    public $name;
    public $address;
    public $phone;
    public $isActive;
    public $id_ciudad;
    public $id_pais;
    public $id_provincia;

    public function __construct($isReadPost = FALSE)
    {
        parent::__construct();
        
        $this->id_company_branch = 0;
        $this->name = '';
        $this->address = '';
        $this->phone = '';
        $this->isActive = 0;
        $this->id_provincia = 1558;
        $this->id_pais = 70;
        $this->id_ciudad = 47949;
        
        if ($isReadPost)
        {
            $this->readPost();
        }
    }

    public function readPost()
    {
        $MY = & MY_Controller::get_instance();
        
        $this->id_company_branch    = $MY->input->post('id_company_branch');
        $this->name                 = $MY->input->post('name');
        $this->address              = $MY->input->post('address');
        $this->phone                = $MY->input->post('phone');
        $this->isActive             = $MY->input->post('isActive');
        $this->id_ciudad            = $MY->input->post('id_ciudad');
    }

    public function isValid()
    {
        $this->clearErrors();
        
        if( empty($this->name) )
        {
            $this->addError('name', 'Campo no debe estar vacío');
        }
        
        if( empty($this->address) )
        {
            $this->addError('address', 'Campo no debe estar vacío');
        }  
        
        if( empty($this->phone) )
        {
            $this->addError('phone', 'Campo no debe estar vacío');
        }  
        
        return $this->isErrorEmpty();
    }

    public function setCompanyBranchEntity( eCompanyBranch $eCompanyBranch )
    {
        $this->id_company_branch    = $eCompanyBranch->id;
        $this->name                 = $eCompanyBranch->name;
        $this->address              = $eCompanyBranch->address;
        $this->phone                = $eCompanyBranch->phone;
        $this->isActive             = $eCompanyBranch->isActive;
        $this->id_ciudad            = $eCompanyBranch->id_ciudad;
    }

    public function getCompanyBranchEntity()
    {
        $eCompanyBranch = new eCompanyBranch(FALSE);
        
        $eCompanyBranch->id         = empty($this->id_company_branch) ? NULL : $this->id_company_branch;
        $eCompanyBranch->name       = $this->name;
        $eCompanyBranch->address    = $this->address;
        $eCompanyBranch->phone      = $this->phone;
        $eCompanyBranch->isActive   = $this->isActive;
        $eCompanyBranch->id_ciudad  = $this->id_ciudad;
        
        return $eCompanyBranch;
    }
}
