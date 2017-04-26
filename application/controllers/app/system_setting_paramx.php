<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Setting_ParamX extends MY_Controller
{
    protected $name_key = 'system_setting_param';
    
    /* @var $permission System_Setting_Param_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/system/setting_param/permission.php');
        $this->permission = new System_Setting_Param_Permission( $this->name_key );
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
            case 'load-param':
                $this->loadParam();
                break;
            case 'save-param':
                $this->saveParam();
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
    
    private function loadParam()
    {
        $this->load->file('application/modules/app/system/setting_param/form/setting_param_form.php');
        
        $resAjax = new Response_Ajax();
        
        $id_system = Helper_Config::getSystemId();
        
        $oBus = Business_App_Configuration_System::loadConfigurationSystem($id_system);
        
        $data = $oBus->data();
        
        /* @var $eConfigurationSystem eConfigurationSystem  */
        $eConfigurationSystem    = $data['eConfigurationSystem'];
        
        $frm_data = new Form_App_System_Setting_Param();
        
        $frm_data->setConfigurationSystemEntity($eConfigurationSystem);
        
        $resAjax->isSuccess( $oBus->isSuccess() );
        $resAjax->message( $oBus->message() );
        $resAjax->form('setting', $frm_data->toArray());
        
        echo $resAjax->toJsonEncode();
    }
    
    private function saveParam()
    {
        $this->load->file('application/modules/app/system/setting_param/form/setting_param_form.php');
        
        $resAjax = new Response_Ajax();
        $frm_data = new Form_App_System_Setting_Param(TRUE);
        
        $logo       = 'logo';
        $id_system = Helper_Config::getSystemId();
        
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
            
            /*if( !isset( $_FILES[$logo] ) )
            {
                throw new Exception('Ocurrio un error, Intentelo otra vez!');
            }*/
            
            if(!empty($_FILES[$logo]['name']))
            {
                $oBusUploadLogo = Business_App_Configuration_System::uploadLogo($id_system, $logo);
                if( !$oBusUploadLogo->isSuccess() )
                {
                    throw new Exception( $oBusUploadLogo->message() );
                }
            }
            
            $oBusLoadLogo = Business_App_Configuration_System::loadLogo($id_system);
            if( !$oBusLoadLogo->isSuccess() )
            {
                throw new Exception( $oBusLoadLogo->message() );
            }
            $dataLogo = $oBusLoadLogo->data();
            
            $eConfigurationSystem = $frm_data->getConfigurationSystemEntity();
            $eConfigurationSystem->id = $id_system;
            $eConfigurationSystem->logo = $dataLogo['uri'];
            $frm_data->logo = $eConfigurationSystem->logo;
            $oBus = Business_App_Configuration_System::saveConfigurationSystem($eConfigurationSystem);
            
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
            
        }
        $resAjax->form('setting', $frm_data->toArray());
        echo $resAjax->toJsonEncode();
        
    }
    
}