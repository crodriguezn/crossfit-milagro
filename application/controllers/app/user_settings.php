<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Settings extends MY_Controller
{
    protected $name_key = 'user_settings';
    
    /* @var $permission User_Settings_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/user_settings/permission.php');
        $this->permission = new User_Settings_Permission( $this->name_key );
        
        if( !Helper_App_Session::isLogin() )
        {
            $this->redirect('app/login');
            return;
        }
        
        if( !Helper_App_Session::inInactivity() )
        {
            $this->redirect('app/login_advanced');
            return;
        }
               
        if( Helper_App_Session::isBlock() )
        {
            $this->redirect('app/login_advanced');
            return;
        }
        
        if( !$this->permission->access )
        {
            Helper_App_Log::write("Configuración de Cuentas: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/user_settings/page');
    }
    
    public function mvcjs()
    {
        
        $this->load->file('application/modules/app/user_settings/form/user_settings_form.php');
        $data_form= new Form_App_User_Settings();
        
      
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'user_settings_form_default' => $data_form->toArray()
        );
        
        Helper_App_JS::showMVC('user_settings', $params);
    }
}