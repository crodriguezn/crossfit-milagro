<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_AdvancedX extends MY_Controller
{
    protected $name_key = 'login_advanced';
    
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
            
            if( !$dataLogin->isValid( $dataLoginError/*REF*/, FALSE ) )
            {
                throw new Exception('Complete correctamente todos los campos 001');
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

}
