<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Log extends MY_Controller
{
    protected $name_key = 'system_log';
    
    /* @var $permission System_Log_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/system_log/permission.php');
        $this->permission = new System_Log_Permission( $this->name_key );
        
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
            Helper_App_Log::write("Log: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        Helper_App_View::layout('app/html/pages/system_log/page');
    }
    
    public function mvcjs()
    {
        
        $params = array(
            'root' => '',
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
        );
        
        Helper_App_JS::showMVC('system_log', $params);
    }
}