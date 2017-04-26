<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_App_User_Settings extends MY_Form
{
    //PERSON
    public $id_person;
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
    
    //USER
    public $id_user;
    public $username;
    public $password_new;
    public $password_new_repeat;
    
    //PROFILE
    public $id_profile;
    public $isActive;
    
    //COMPANY_BRANCH
    public $id_company_branchs;

    public function __construct( $isReadPost=FALSE )
    {
        parent::__construct();
        
        //PERSON
        $this->id_user              = 0;
        $this->id_person            = 0;
        $this->name                 = '';
        $this->surname              = '';
        $this->tipo_documento       = 'TIPO_IDENT_CEDULA';
        $this->document             = '';
        $this->birthday             = '';
        $this->gender               = 'GENDER_MALE';
        $this->address              = '';
        $this->phone_cell           = '';
        $this->email                = '';
        $this->estado_civil         = 'ESTADO_CIVIL_SOLTERO';
        $this->tipo_sangre          = 'TIPO_SANGRE_A+';
        $this->id_provincia         = 1558;
        $this->id_pais              = 70;
        $this->id_ciudad            = 47949;
        
        //USER
        $this->username             = '';
        $this->password_new         = '';
        $this->password_new_repeat  = '';
        
        //PROFILE
        $this->id_profile           = 0;
        $this->isActive             = 1;

        //COMPANY_BRANCH
        $this->id_company_branchs   = NULL;
        
        if( $isReadPost )
        {
            $this->readPost();
        }
    }
    
    public function readPost()
    {
        $MY =& MY_Controller::get_instance();
        
        //PERSON
        $this->id_person            = $MY->input->post('id_person');
        $this->name                 = $MY->input->post('name');
        $this->surname              = $MY->input->post('surname');
        $this->tipo_documento       = $MY->input->post('tipo_documento');
        $this->document             = $MY->input->post('document');
        $this->birthday             = $MY->input->post('birthday');
        $this->gender               = $MY->input->post('gender');
        $this->address              = $MY->input->post('address');
        $this->phone_cell           = $MY->input->post('phone_cell');
        $this->email                = $MY->input->post('email');
        $this->estado_civil         = $MY->input->post('estado_civil');
        $this->tipo_sangre          = $MY->input->post('tipo_sangre');
        $this->id_ciudad            = $MY->input->post('id_ciudad');
        
        //USER
        $this->id_user              = $MY->input->post('id_user');
        $this->username             = $MY->input->post('username');
        $this->password_new         = $MY->input->post('password_new');
        $this->password_new_repeat  = $MY->input->post('password_new_repeat');
        
        //PROFILE
        $this->id_profile           = $MY->input->post('id_profile');
        $this->isActive             = $MY->input->post('isActive');

        //COMPANY_BRANCH
        $this->id_company_branchs   = $MY->input->post('id_company_branchs');
        $this->id_form              = $MY->input->post('id_form');
    }
    
    public function isValid()
    {
        $this->clearErrors();
        
        //PERSON
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
        
        //USER
        if( empty($this->id_user) )
        {
            if( empty($this->username) )
            {
                $this->addError('username', 'Campo no debe estar vacío');
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
        }
        else
        {
            if( !empty($this->password_new) )
            {
                if($this->password_new != $this->password_new_repeat)
                {
                    $this->addError('password_new', 'Comprobación incorrecta');
                    $this->addError('password_new_repeat', 'Comprobación incorrecta');
                }
                elseif(strlen($this->password_new) < 6)
                {
                    $this->addError('password_new', '6 mínimo tamaño contraseña');
                    $this->addError('password_new_repeat', '6 mínimo tamaño contraseña');
                }
            }
        }
        
        
        //PROFILE
        if( empty($this->id_profile) )
        {
            $this->addError('id_profile', 'Campo no debe estar vacío');
        }

        //COMPANY_BRANCH
        if( empty($this->id_company_branchs) )
        {
            $this->addError('id_company_branchs', 'Campo no debe estar vacío');
        }
        
        return $this->isErrorEmpty();
    }
    
    //PERSON
    public function getPersonEntity()
    {
        $ePerson = new ePerson(FALSE);
        
        $ePerson->id                = $this->id_person;
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
        $this->id_person        = empty($ePerson->id) ? 0 : $ePerson->id;
        $this->name             = $ePerson->name;
        $this->surname          = $ePerson->surname;
        if(!empty($ePerson->tipo_documento)) { $this->tipo_documento   = $ePerson->tipo_documento; }
        
        $this->document         = $ePerson->document;
        $this->birthday         = $ePerson->birthday;
        
        if(!empty($ePerson->gender)) { $this->gender   = $ePerson->gender; }

        $this->address          = $ePerson->address;
        $this->phone_cell       = $ePerson->phone_cell;
        $this->email            = $ePerson->email;
        
        if(!empty($ePerson->estado_civil)) { $this->estado_civil   = $ePerson->estado_civil; }
        if(!empty($ePerson->tipo_sangre)) { $this->tipo_sangre   = $ePerson->tipo_sangre; }
        $this->id_ciudad        = $ePerson->id_ciudad;
    }   
       
    //USER
    public function getUserEntity()
    {
        $eUser = new eUser(FALSE);
        
        $eUser->id          = empty($this->id_user) ? 0 : $this->id_user ;
        $eUser->username    = trim($this->username);
        if(!empty($this->password_new_repeat))
        {
            $eUser->password    = trim(md5($this->password_new_repeat));
        }
        
        return $eUser;
    }
    
    public function setUserEntity(eUser $eUser )
    {
        $this->id_user  = empty($eUser->id) ? 0 : $eUser->id ;
        $this->username = $eUser->username;
       
    }   
    
    //PROFILE
    public function getUserProfileEntity()
    {
        $eUserProfile = new eUserProfile(FALSE);
        
        $eUserProfile->id_profile   = empty($this->id_profile) ? 0 : $this->id_profile ;
        $eUserProfile->id_user      = empty($this->id_user) ? 0 : $this->id_user ;
        $eUserProfile->isActive     = $this->isActive;
        
        return $eUserProfile;
    }

    //PROFILE
    public function setUserProfileEntity(eUserProfile $eUserProfile )
    {
        $this->id_profile   = empty($eUserProfile->id_profile) ? 0 : $eUserProfile->id_profile ;
        $this->isActive     = $eUserProfile->isActive;
    }
    
    //COMPANY_BRANCH
    
    public function getUserProfile_CompanyBranchEntity()
    {
        $eUserProfile_CompanyBranches = array();
                  
        if( !empty($this->id_company_branchs) )
        {
            foreach( $this->id_company_branchs as $company_branch ) {

                $eUserProfileCompanyBranch = new eUserProfileCompanyBranch();
                
                $eUserProfileCompanyBranch->id_company_branch = $company_branch;

                $eUserProfile_CompanyBranches[] = $eUserProfileCompanyBranch;
            }
        }
        
        return $eUserProfile_CompanyBranches;
        
    }
    
    public function setUserProfile_CompanyBranchEntity( $eCompanyBranchs )
    {
        
        if( !empty($eCompanyBranchs) )
        {
            /* @var $eCompanyBranch eCompanyBranch */
            foreach( $eCompanyBranchs as $eCompanyBranch )
            {               
                
                $this->id_company_branchs[] = $eCompanyBranch->id;
            }
        }
    }
    
}
