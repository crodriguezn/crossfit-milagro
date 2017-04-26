<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_ProfileX extends MY_Controller
{
    protected $name_key = 'security_profile';
    
    /* @var $permission Security_Profile_Permission */
    protected $permission;

    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        $this->load->file('application/modules/app/security/profile/permission.php');
        $this->permission = new Security_Profile_Permission( $this->name_key );
        $this->permission->create = Helper_App_Session::isPermissionForModule($this->name_key,'create');
        $this->permission->update = Helper_App_Session::isPermissionForModule($this->name_key,'update');
        $this->permission->access_permissions    = Helper_App_Session::isPermissionForModule($this->name_key,'access_permissions');
        $this->permission->update_permissions    = Helper_App_Session::isPermissionForModule($this->name_key,'update_permissions');
        
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
            case 'list-profile':
                $this->listProfile();
                break;
            case 'load-profile':
                $this->loadProfile();
                break;
            case 'save-profile':
                $this->saveProfile();
                break;
            case 'save-profile-permission':
                $this->saveProfilePermission();
                break;
            case 'load-components-modal-rol':
                $this->loadComponentsModalRol();
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
    
    private function listProfile()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter = $this->input->get('sSearch');
        $limit      = $this->input->get('iDisplayLength');
        $offset     = $this->input->get('iDisplayStart');
        
        $oBus = Business_App_Profile::listProfile($txt_filter, $limit, $offset);
        $data = $oBus->data();
        
        $eProfiles  = $data['eProfiles'];
        $eRoles     = $data['eRoles'];
        $count      = $data['count'];
        
        $aaData = array();
        
        if( !empty($eProfiles) )
        {
            /* @var $eProfile eProfile */
            foreach( $eProfiles as $num => $eProfile )
            {
                $aaData[] = array( trim($eProfile->name), trim($eRoles[$num]->name), trim($eProfile->isActive), trim($eProfile->id) );
            }
        }
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }     
    
    private function loadProfile()
    {
        $this->load->file('application/modules/app/security/profile/form/profile_form.php');
        
        $resAjax = new Response_Ajax();
        
        $id_profile = $this->input->post('id_profile');
        
        $oBus = Business_App_Profile::loadProfile($id_profile);
        
        $data = $oBus->data();
        
        /* @var $eProfile eProfile  */
        $eProfile   = $data['eProfile'];
        
        $frm_data = new Form_App_Security_Profile();
        
        $frm_data->setIdForm(1);
        
        $frm_data->setProfileEntity($eProfile);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->form('profile', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveProfile()
    {
        $this->load->file('application/modules/app/security/profile/form/profile_form.php');
        
        $resAjax = new Response_Ajax();
        
        $frmData = new Form_App_Security_Profile(TRUE);
        
        try
        {
            if( empty($frmData->id_profile) && !$this->permission->create )
            {
                throw new Exception('No tiene permisos para guardar');
            }

            if( !empty($frmData->id_profile) && !$this->permission->update )
            {
                throw new Exception('No tiene permisos para editar');
            }

            if( !$frmData->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $eProfile = $frmData->getProfileEntity();

            $oBus = Business_App_Profile::saveProfile( $eProfile );

            $resAjax->isSuccess( $oBus->isSuccess() );
            $resAjax->message( $oBus->message() );
        }
        catch( Exception $e )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message( $e->getMessage() );
            $resAjax->form('profile', $frmData->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveProfilePermission()
    {
        $this->load->file('application/modules/app/security/profile/form/permissions_form.php');
        
        $resAjax = new Response_Ajax();
        
        $frmData = new Form_App_Profile_Permission(TRUE);
        
        try
        {
            if( !empty($frmData->id_profile) && !$this->permission->update_permissions )
            {
                throw new Exception('No tiene permisos para editar');
            }

            if( !$frmData->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $eProfilesPermissions   = $frmData->getProfilePermissionEntities();

            $oBus = Business_App_Profile::saveProfilePermission($frmData->id_profile, $eProfilesPermissions);

            $resAjax->isSuccess( $oBus->isSuccess() );
            $resAjax->message( $oBus->message() );
        }
        catch( Exception $e )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message( $e->getMessage() );
            $resAjax->form('permission', $frmData->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function loadComponentsModalRol()
    {
        $resAjax = new Response_Ajax();
        
        $combo_rol = array(array('value'=>0, 'text'=>'<< --ROLES-- >>'));
        
        try
        {
            $oBus = Business_App_Rol::listRol('', NULL, NULL);
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $eRols = $oBus->getInData('eRols');
            
            $combo_rol2 = Helper_Array::entitiesToIdText($eRols, 'id', 'name', 'value', 'text');
            $combo_roles = array_merge($combo_rol, $combo_rol2);
            
            $resAjax->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
           $resAjax->isSuccess(FALSE); 
           $resAjax->message( $e->getMessage() );
        }
        
        $resAjax->data(
                array(
                        'combo-roles' => $combo_roles
                    )
                );
        
        echo $resAjax->toJsonEncode();
    }
    
}