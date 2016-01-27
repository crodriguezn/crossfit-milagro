<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_SettingsX extends MY_Controller
{
    protected $name_key = 'user_settings';
    
    /* @var $permission User_Settings_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/user_settings/permission.php');
        $this->permission = new User_Settings_Permission( $this->name_key );
        $this->permission->create = Helper_App_Session::isPermissionForModule($this->name_key,'create');
        $this->permission->update = Helper_App_Session::isPermissionForModule($this->name_key,'update');
        
    }

    public function process( $action )
    {
        if( !Helper_App_Session::isLogin() )
        {
            $this->noaction('Fuera de sesión');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->noaction('Fuera de sesión por Inactividad');
            return;
        }
        
        if( Helper_App_Session::isBlock() )
        {
            $this->noaction('Fuera de session por Bloqueo');
            return;
        }
        
        if( !$this->permission->access )
        {
            $this->noaction('Acceso no permitido');
            return;
        }

        switch( $action )
        {
            case 'list-user-acounts':
                $this->listUserAcounts();
                break;
            case 'load-components':
                $this->loadComponents();
                break;
            case 'load-pais':
                $this->loadPais();
                break;
            case 'load-provincia':
                $this->loadProvincia();
                break;
            case 'load-ciudad':
                $this->loadCiudad();
                break;
            case 'load-acount':
                $this->loadAcount();
                break;
            case 'load-person':
                $this->loadPerson();
                break;
            case 'save-acount':
                $this->saveAcount();
                break;
            default:
                $this->noaction($action);
                break;
        }
    }
    
    private function noaction($action)
    {
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess(FALSE);
        $resAjax->message("No found action: $action");
        
        echo $resAjax->toJsonEncode();
    }
    
    private function listUserAcounts()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter = $this->input->get('sSearch');
        $limit      = $this->input->get('iDisplayLength');
        $offset     = $this->input->get('iDisplayStart');
        
        $oBus = Business_App_User_Settings::listAcounts($txt_filter, $limit, $offset);
        $data = $oBus->data();

        $eUsers = $data['eUsers'];
        $ePersons = $data['ePersons'];
        $count    = $data['count'];
        
        $aaData = array();
        
        if( !empty($eUsers) )
        {
            /* @var $eUser eUser */
            foreach( $eUsers as $num => $eUser )
            {
                $aaData[] = array( trim($ePersons[$num]->document), (trim($ePersons[$num]->surname).' '.trim($ePersons[$num]->name)), trim($eUser->username), trim($eUser->id) );
            }
        }
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadComponents ()
    {
        $resAjax = new Response_Ajax();
        
        $arrType = array('TIPO_IDENT','ESTADO_CIVIL','GENDER', 'TIPO_DE_SANGRE');
        
        try
        {
            $oBus = Business_App_Catalog::listByType($arrType);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $oBus1 = Business_App_Profile::listProfile('', NULL, NULL);
            
            $dataCatalogo = $oBus->data();
            $eCatalogs = $dataCatalogo['eCatalogs'];
            $dataProfile = $oBus1->data();
            $eProfiles = $dataProfile['eProfiles'];
            $eProfiles = Helper_Array::entitiesToIdText($eProfiles, 'id', 'name', 'value', 'text');
            
            $oBus2 = Business_App_Company_Branch::listByCompany(Helper_App_Session::getCompanyId(), 1);
            $dataCompanyBranch = $oBus2->data();
            $eCompanyBranches = $dataCompanyBranch['eCompanyBranchs'];
            $eCompanyBranches = Helper_Array::entitiesToIdText($eCompanyBranches, 'id', 'name', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(array('eCatalogs'=>$eCatalogs,'eProfiles'=>$eProfiles,'eCompanyBranches'=>$eCompanyBranches));
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadPais()
    {
        $resAjax = new Response_Ajax();
        try
        {
            $oBus = Business_App_Pais::listPais($ePaises/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_pais = Helper_Array::entitiesToIdText($ePaises, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-pais' => $combo_pais
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadProvincia()
    {
        $resAjax = new Response_Ajax();
        
        $id_pais = $this->input->post('id_pais');
        
        try
        {
            $oBus = Business_App_Provincia::listProvincia($id_pais, $eProvincias/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_provincia = Helper_Array::entitiesToIdText($eProvincias, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-provincia' => $combo_provincia
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadCiudad()
    {
        $resAjax = new Response_Ajax();
        
        $id_provincia = $this->input->post('id_provincia');
        
        try
        {
            $oBus = Business_App_Ciudad::listCiudad($id_provincia, $eCiudades/*REF*/);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $combo_ciudad = Helper_Array::entitiesToIdText($eCiudades, 'id', 'nombre', 'value', 'text');
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'cbo-ciudad' => $combo_ciudad
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadAcount()
    {
        $this->load->file('application/modules/app/user_settings/form/user_settings_form.php');
        
        $resAjax = new Response_Ajax();
        
        $id_user = $this->input->post('id_user');
        
        try 
        {
            
            //USER
            $oBusUser = Business_App_User::loadUser($id_user);
            if(!$oBusUser->isSuccess())
            {
                throw new Exception($oBusUser->message());
            }
            
            $dataUser = $oBusUser->data();

            /* @var $eUser eUser  */
            $eUser   = $dataUser['eUser'];
            
            
            //PERSON
            $oBusPerson = Business_App_Person::loadByPersonId($eUser->id_person);

            if(!$oBusPerson->isSuccess())
            {
                throw new Exception($oBusPerson->message());
            }
            
            $dataPerson = $oBusPerson->data();

            /* @var $ePerson ePerson  */
            $ePerson   = $dataPerson['ePerson'];
            
            //USER_PROFILE
            $oBusUserProfile = Business_App_User_Profile::loadUserProfile($eUser->id);
            
            if(!$oBusUserProfile->isSuccess())
            {
                throw new Exception($oBusUserProfile->message());
            }
            
            $dataUserProfile = $oBusUserProfile->data();

            /* @var $eUserProfile eUserProfile  */
            $eUserProfile   = $dataUserProfile['eUserProfile'];
            
            //COMPANY_BRANCH
            $oBusCompanyBranch = Business_App_User_Settings::listCompanyBranchsByUserProfile($eUserProfile->id_user, $eUserProfile->id_profile);
            
            if(!$oBusCompanyBranch->isSuccess())
            {
                throw new Exception($oBusCompanyBranch->message());
            }
            
            $dataCompanyBranchs = $oBusCompanyBranch->data();

            $eCompanyBranchs   = $dataCompanyBranchs['eCompanyBranchs'];
            
            $frm_data = new Form_App_User_Settings();

            $frm_data->setUserEntity($eUser);
            $frm_data->setPersonEntity($ePerson);
            $frm_data->setUserProfileEntity($eUserProfile);
            $frm_data->setUserProfile_CompanyBranchEntity($eCompanyBranchs);
            
            $resAjax->isSuccess( TRUE );
        
        } 
        catch (Exception $exc) 
        {
            $resAjax->isSuccess( FALSE );
            $resAjax->message( $exc->getMessage() );
        }

        $resAjax->form('acount', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveAcount()
    {
        $this->load->file('application/modules/app/user_settings/form/user_settings_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_User_Settings(TRUE);
        
        try
        {
            
            if( !$this->permission->update )
            {
                throw new Exception('No tiene permisos para editar/actualizar');
            }
            
            if( !$frm_data->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $ePerson = $frm_data->getPersonEntity();
            $eUser = $frm_data->getUserEntity();
            $eUserProfile = $frm_data->getUserProfileEntity();
            $eUserProfile_CompanyBranches = $frm_data->getUserProfile_CompanyBranchEntity();

            $oBus = Business_App_User_Settings::saveAcount($ePerson, $eUser, $eUserProfile, $eUserProfile_CompanyBranches);
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }

            $resAjax->isSuccess(TRUE);
            $resAjax->message($oBus->message());
        }
        catch( Exception $ex )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message($ex->getMessage());
            $resAjax->form('acount', $frm_data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadPerson()
    {
        
    }
}