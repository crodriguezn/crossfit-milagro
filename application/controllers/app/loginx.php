<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LoginX extends MY_Controller
{
    protected $name_key = 'login';
    
    function __construct()
    {
        parent::__construct(MY_Controller::SYSTEM_APP);
    }

    public function index()
    {
        $this->process(NULL);
    }

    public function process($action)
    {
        switch( $action )
        {
            case 'check':
                $this->check();
                break;
            case 'recovery-password':
                $this->recoveryPassword();
                break;
            case 'change-password':
                $this->changePassword();
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

    private function check()
    {
        $this->load->file('application/modules/app/login/login_data.php');
        
        $resAjax = new Response_Ajax();
        
        $dataLogin = new Data_App_Login(TRUE);
        $dataLoginError = NULL;
    
        //Helper_Log::write($_SESSION);
        
        try
        {
            $id_company = Helper_Config::getCompanyId();
            
            if( !$dataLogin->isValid( $dataLoginError/*REF*/ ) )
            {
                throw new Exception('Complete correctamente todos los campos 001');
            }
            
            if(ENVIRONMENT!='development')
            {
                if( !Helper_Captcha::isValid($this->name_key, $dataLogin->security) )
                {
                    throw new Exception('Código de seguridad inválido.');
                    //throw new Exception('Complete correctamente todos los campos 002');
                }
            }
            
            
            $oBus = Business_App_User::login($dataLogin->username, $dataLogin->password);
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception( $oBus->message() );
            }
            
            $data = $oBus->data();

            /* @var $eUser eUser */
            $eUser = $data['eUser'];
            
            Helper_App_Session::init($id_company, $eUser->id );
            //Helper_App_Session::buildData();
            
            /*$eSessionActivity = new eSessionActivity();
            $eSessionActivity->id_user = Helper_App_Session::getUserId();
            $eSessionActivity->inUse = 1;
            $eSessionActivity->last_activity = date('Y-m-d H:i:s');
            $eSessionActivity->session_id = Helper_App_Session::getSessionID();
            */
            //Helper_App_Activity::set($eSessionActivity);
            $resAjax->isSuccess(TRUE);
        }
        catch (Exception $ex)
        {
            $resAjax->isSuccess(FALSE);
            $resAjax->message($ex->getMessage());
            
            $resAjax->data('login_error', $dataLoginError->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }

    private function recoveryPassword()
    {
        $this->load->file('application/forms/app/login_recovery_password_form.php');
        
        $resAjax = new Response_Ajax();
        
        //$oBus = new Response_Business();
        
        $frmRecoveryPassword = new Form_App_Login_Recovery_Password(TRUE);
        
        try
        {
            if( !$frmRecoveryPassword->isValid() )
            {
                throw new Exception('Complete Correctamente el campo');
            }
            
            if( !Business_App_Persona::isValidDocument($frmRecoveryPassword->document) )
            {
                throw new Exception("No está permitido usar este número de identificación: " . $frmRecoveryPassword->document);
            }
            
            $link_recovery = base_url( 'app/token/check' );
            
            $oBus = Business_App_User::recoveryPassword($frmRecoveryPassword->document, Helper_Encrypt::decode($frmRecoveryPassword->LOGIN_TYPE), $link_recovery);
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception($oBus->message());
            }
            
            $resAjax->isSuccess(TRUE);
            $resAjax->message($oBus->message());
        } 
        catch (Exception $ex)
        {
            $resAjax->isSuccess(FALSE);
            
            $resAjax->message($ex->getMessage());
            
            $resAjax->form('recoveryPassword', $frmRecoveryPassword->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
    
    private function changePassword()
    {
        $this->load->file('application/forms/app/login_change_password_form.php');
        
        $resAjax = new Response_Ajax();
        
        $oBus = new Response_Business();
        
        $frmChangePassword = new Form_App_Login_Change_Password(TRUE);
        
        try
        {
            if( !$frmChangePassword->isValid() )
            {
                throw new Exception('Complete Correctamente los campo');
            }
            
            $oBus = Business_App_Token::inactivarUserToken(Helper_Encrypt::decode( $frmChangePassword->id_user ), 'id_user');
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception($oBus->message());
            }
            
            $oBus = Business_App_User::updatePassword(Helper_Encrypt::decode( $frmChangePassword->id_user ), $frmChangePassword->new_password);
            
            if( !$oBus->isSuccess() )
            {
                throw new Exception($oBus->message());
            }
            
            $resAjax->isSuccess( TRUE );
            
            $resAjax->message( $oBus->message() );
            
        } 
        catch (Exception $ex)
        {
            $resAjax->isSuccess(FALSE);
            
            $resAjax->message($ex->getMessage());
            
            $resAjax->form('changePassword', $frmChangePassword->toArray());
        }
        
        echo $resAjax->toJsonEncode();
    }
}
