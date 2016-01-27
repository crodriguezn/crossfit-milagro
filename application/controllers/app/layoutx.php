<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LayoutX extends MY_Controller
{
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );
    }

    public function index()
    {
        $this->process(NULL);
    }
    
    public function process( $action )
    {
        switch( $action )
        {
            case 'update-password':
                $this->updatePassword();
                break;
            case 'update-profile-session':
                $this->updateProfileSession();
                break;
            case 'update-sede-session':
                $this->updateSedeSession();
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
    
    private function updatePassword()
    {
        $this->load->file('application/modules/app/layout/layout_password_data.php');
        
        $resAjax = new Response_Ajax();
        $data = new Data_App_Layout_Password(TRUE);
        
        try
        {
            
            if( !$data->isValid() )
            {
                throw new Exception('Complete correctamente todos los campos');
            }
            
            
            $id_user = Helper_App_Session::getUserId();
            
            $oBus = Business_App_User::checkPassword( $id_user, $data->password_current );
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $data_isValid   = $oBus->data();
            $isValid        = $data_isValid['isValid'];
            
            
            if( !$isValid )
            {
                throw new Exception('Contraseña incorrecta.');
            }
            
            $oBus2 = Business_App_User::updatePassword($id_user, $data->password_new);
            if( !$oBus2->isSuccess() )
            {
                throw new Exception( $oBus2->message() );
            }
            
            $data_changed   = $oBus2->data();
            $changed        = $data_changed['changed'];

            if( !$changed )
            {
                throw new Exception("No fue posible cambiar la contraseña");
            }
            
            $resAjax->isSuccess(TRUE);
            $resAjax->message("Contraseña cambiada con éxito.");
        }
        catch( Exception $ex )
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message( $ex->getMessage() );
            $resAjax->form('change_password', $data->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    public function updateProfileSession()
    {
        $id_profile = $this->input->post('id_profile');
        
        Helper_App_Session::setProfileId($id_profile);
        
        Helper_App_Session::buildPermissionsByProfile();
        
        Helper_App_Session::debugAll();
        
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess( TRUE );
        $resAjax->message("Cambio Exitoso.<br/>Recargando...");
        
        echo $resAjax->toJsonEncode();
    }
    
    public function updateSedeSession()
    {
        $id_company_branch = $this->input->post('id_company_branch');
        
        Helper_App_Session::setCompanyBranchId($id_company_branch);
        
        Helper_App_Session::debugAll();
        
        $resAjax = new Response_Ajax();
        
        $resAjax->isSuccess( TRUE );
        $resAjax->message("Cambio Exitoso.<br/>Recargando...");
        
        echo $resAjax->toJsonEncode();
    }
}