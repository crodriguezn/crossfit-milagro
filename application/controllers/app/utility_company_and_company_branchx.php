<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility_Company_And_Company_BranchX extends MY_Controller
{
    protected $name_key = 'utility_company_and_company_branch';
    
    /* @var $permission Utility_Company_And_Company_Branch_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        $this->load->file('application/modules/app/utility_company_and_company_branch/permission.php');
        $this->permission = new Utility_Company_And_Company_Branch_Permission( $this->name_key );
        $this->permission->access_branch        = Helper_App_Session::isPermissionForModule($this->name_key,'access_branch');
        $this->permission->access_company       = Helper_App_Session::isPermissionForModule($this->name_key,'access_company');
        $this->permission->create_branch        = Helper_App_Session::isPermissionForModule($this->name_key,'create_branch');
        $this->permission->update_branch        = Helper_App_Session::isPermissionForModule($this->name_key,'update_branch');
        $this->permission->update_company       = Helper_App_Session::isPermissionForModule($this->name_key,'update_company');
        $this->permission->update_logo_company  = Helper_App_Session::isPermissionForModule($this->name_key,'update_logo_company');
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
            case 'load-company':
                $this->loadCompany();
                break;
            case 'upload-company-logo':
                $this->uploadCompanyLogo();
                break;
            case 'save-company':
                $this->saveCompany();
                break;
            case 'list-branch':
                $this->listCompanyBranch();
                break; 
            case 'load-company-branch':
                $this->loadCompanyBranch();
                break; 
            case 'save-company-branch':
                $this->saveCompanyBranch();
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
    
    private function loadCompany()
    {
        $this->load->file('application/modules/app/utility_company_and_company_branch/form/company_form.php');
        
        $resAjax = new Response_Ajax();
        
        $id_company = Helper_App_Session::getCompanyId();
        
        $data = new Form_App_Company();
        
        try
        {
            if( !$this->permission->access_company )
            {
                throw new Exception('Acceso no permitido');
            }
            
            $oBus = Business_App_Company::loadCompany($id_company);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $dataCompany = $oBus->data();
            
            /* @var $eCompany eCompany */
            $eCompany = NULL;
            $eCompany   = $dataCompany['eCompany'];
            
            $oBus2 = Business_App_Company::loadLogo($id_company);
            
            $data->setCompanyEntity($eCompany);
            
            $dataURI = $oBus2->data();
            $uri = $dataURI['uri'];

            $resAjax->isSuccess( TRUE );
            $resAjax->message( $oBus->message() );
            $resAjax->form('company', $data->toArray());
            $resAjax->data(array('uri_logo' => $uri));
        }
        catch( Exception $e )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message($e->getMessage());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function uploadCompanyLogo()
    {
        $resAjax = new Response_Ajax();
        
        $id_company = Helper_App_Session::getCompanyId();
        $field_name_post = "logo";
        
        $oBus = Business_App_Company::uploadLogo($id_company, $field_name_post);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->isSuccess() ? 'Subida con Exito': $oBus->message() );
        $resAjax->data( $oBus->data() );
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveCompany()
    {
        $this->load->file('application/modules/app/utility_company_and_company_branch/form/company_form.php');
        
        $resAjax = new Response_Ajax();
        $frmData = new Form_App_Company(TRUE);
        
        try
        {
            
            if( !$this->permission->update_company )
            {
                throw new Exception('No tiene permisos para editar/actualizar');
            }
            
            if( !$frmData->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $eCompany = $frmData->getCompanyEntity();
            $eCompany->id = Helper_App_Session::getCompanyId();

            $oBus = Business_App_Company::saveCompany($eCompany);
            
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
            $resAjax->form('company', $frmData->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function listCompanyBranch()
    {
        $resAjax = new Response_Ajax();
        
        $aaData = array();
        $count = 0;
        try
        {
            if( !$this->permission->access_branch )
            {
                throw new Exception('Acceso no permitido');
            }
            
            $id_company = Helper_App_Session::getCompanyId();
            $text   = $this->input->get('sSearch');
            $limit  = $this->input->get('iDisplayLength');
            $offset = $this->input->get('iDisplayStart');
            
            $oBus = Business_App_Company_Branch::filterCompanyBranch($id_company, $text, $limit, $offset);
            $data = $oBus->data();
            
            $eCompanyBranchs = $data['eCompanyBranches'];
            $count = $data['count'];
            
            $aaData = array();
            if( !empty($eCompanyBranchs) )
            {
                /* @var $eCompanyBranch eCompanyBranch */
                foreach( $eCompanyBranchs as $eCompanyBranch )
                {
                    $aaData[] = array( $eCompanyBranch->name, $eCompanyBranch->address, $eCompanyBranch->phone, $eCompanyBranch->isActive, $eCompanyBranch->id );
                }
            }

            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message($e->getMessage());
        }
        
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadCompanyBranch()
    {
        $this->load->file('application/modules/app/utility_company_and_company_branch/form/company_branch_form.php');
        
        $resAjax = new Response_Ajax();
        
        $id_company_branch = $this->input->post('id_company_branch');
        
        $oBus = Business_App_Company_Branch::loadCompanyBranch($id_company_branch);
        
        $data = $oBus->data();

        /* @var $eCompanyBranch eCompanyBranch */
        $eCompanyBranch = $data['eCompanyBranch'];
        
        $frm_data = new Form_App_Company_Branch();
        
        $frm_data->setCompanyBranchEntity($eCompanyBranch);
        
        /* @var $eCiudad eCiudad */
        $oBus = Business_App_Ciudad::loadCiudad($eCompanyBranch->id_ciudad, $eCiudad/*REF*/);
        
        $frm_data->id_provincia = $eCiudad->id_provincia;
        $frm_data->id_pais = $eCiudad->id_pais;

        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        
        $resAjax->form('company_branch', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveCompanyBranch()
    {
        $this->load->file('application/modules/app/utility_company_and_company_branch/form/company_branch_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_Company_Branch(TRUE);
        
        try
        {
            
            if( !$this->permission->update_branch )
            {
                throw new Exception('No tiene permisos para editar/actualizar');
            }
            
            if( !$frm_data->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $eCompanyBranch = $frm_data->getCompanyBranchEntity();
            $eCompanyBranch->id_company = Helper_App_Session::getCompanyId();

            $oBus = Business_App_Company_Branch::saveCompanyBranch($eCompanyBranch);
            
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
            $resAjax->form('company_branch', $frm_data->toArray());
        }
        
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
}