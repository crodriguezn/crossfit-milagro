<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_RolX extends MY_Controller
{
    protected $name_key = 'security_rol';
    
    /* @var $permission Security_Rol_Permission */
    protected $permission;

    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
        
        $this->load->file('application/modules/app/security_rol/permission.php');
        $this->permission = new Security_Rol_Permission( $this->name_key );
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
            case 'list-rol':
                $this->listRol();
                break;
            case 'load-rol':
                $this->loadRol();
                break;
            case 'save-rol':
                $this->saveRol();
                break;
            case 'list-modules':
                $this->listModules();
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
    
    private function listRol()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter = $this->input->get('sSearch');
        $limit      = $this->input->get('iDisplayLength');
        $offset     = $this->input->get('iDisplayStart');
        
        $oBus = Business_App_Rol::listRol($txt_filter, $limit, $offset);
        $data = $oBus->data();
        
        $eRols = $data['eRols'];
        $count    = $data['count'];
        
        $aaData = array();
        
        if( !empty($eRols) )
        {
            /* @var $eRol eRol */
            foreach( $eRols as $num => $eRol )
            {
                $aaData[] = array( trim($eRol->name), trim($eRol->name_key), trim($eRol->id) );
            }
        }
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }     
    
    
    private function loadRol()
    {
        $this->load->file('application/modules/app/security_rol/form/rol_form.php');
        
        $resAjax = new Response_Ajax();
        
        $id_rol = $this->input->post('id_rol');
        
        $oBusRol = Business_App_Rol::loadRol($id_rol);
        
        $oBusRolesModules = Business_App_Rol::listRolesAndModulesAByRol($id_rol);
        
        $dataRol = $oBusRol->data();
        $dataRolesModules = $oBusRolesModules->data();
        
        /* @var $eRol eRol */
        $eRol           = $dataRol['eRol'];
        $eRolesModules  = $dataRolesModules['eRolesModules'];
        
        $frm_data = new Form_App_Security_Rol();
        
        $frm_data->setRolEntity($eRol);
        $frm_data->setRolModuleEntities($eRolesModules);
        
        $resAjax->isSuccess( $oBusRol->isSuccess() );
        $resAjax->message( $oBusRol->message() );
        $resAjax->form('rol', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveRol()
    {
        $this->load->file('application/modules/app/security_rol/form/rol_form.php');
        
        $resAjax = new Response_Ajax();
        
        $frmRol = new Form_App_Security_Rol(TRUE);
        
        try
        {
            if( empty($frmRol->id_rol) && !$this->permission->create )
            {
                throw new Exception('No tiene permisos para guardar');
            }

            if( !empty($frmRol->id_rol) && !$this->permission->update )
            {
                throw new Exception('No tiene permisos para editar');
            }

            if( !$frmRol->isValid() )
            {
                throw new Exception('Debe ingresar la información en todos los campos');
            }
            
            $eRol           = $frmRol->getRolEntity();
            $eRolesModules  = $frmRol->getRolModuleEntities();

            $oBus = Business_App_Rol::saveRolModule($eRol,$eRolesModules);

            $resAjax->isSuccess( $oBus->isSuccess() );
            $resAjax->message( $oBus->message() );
        }
        catch( Exception $e )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message( $e->getMessage() );
            $resAjax->form('rol', $frmRol->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function listModules()
    {
        $resAjax = new Response_Ajax();
        
        $txt_filter = $this->input->get('sSearch');
        $limit      = $this->input->get('iDisplayLength');
        $offset     = $this->input->get('iDisplayStart');
        
        $oBus = Business_App_Rol::listRol($txt_filter, $limit, $offset);
        $data = $oBus->data();
        
        $eRols = $data['eRols'];
        $count    = $data['count'];
        
        $aaData = array();
        
        if( !empty($eRols) )
        {
            /* @var $eRol eRol */
            foreach( $eRols as $num => $eRol )
            {
                $aaData[] = array( trim($eRol->name), trim($eRol->name_key), trim($eRol->id) );
            }
        }
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->datatable($aaData, $count);
        
        echo $resAjax->toJsonEncode();
    }     
    
}