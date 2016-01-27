<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Module extends MY_Controller
{
    protected $name_key = 'system_module';
    
    /* @var $permission System_Module_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/system_module/permission.php');
        $this->permission = new System_Module_Permission( $this->name_key );
        
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
            Helper_App_Log::write("Module: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/system_module/page');
    }
    
    public function mvcjs()
    {
        $this->load->file('application/modules/app/system_module/data/module_data.php');
        $data_module = new Data_App_Module_Module();
        $data_permission = new Data_App_Module_Permission();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'data_module_default' => $data_module->toArray(),
            'data_permission_default' => $data_permission->toArray(),
        );
        
        Helper_App_JS::showMVC('system_module', $params);
    }
}