<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_Rol extends MY_Controller
{
    protected $name_key = 'security_rol';
    
    /* @var $permission Security_Rol_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/security/rol/permission.php');
        $this->permission = new Security_Rol_Permission( $this->name_key );
        
        $this->permission->create = Helper_App_Session::isPermissionForModule($this->name_key,'create');
        $this->permission->update = Helper_App_Session::isPermissionForModule($this->name_key,'update');
        
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
            Helper_App_Log::write("Rol: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        $arrModulesPermissions = Helper_App_Permission::getMenu2();
        //Helper_Log::write($arrModulesPermissions);
        Helper_App_View::layout('app/html/pages/security/rol/page', array(
            'arrModulesPermissions' => $arrModulesPermissions
        ));
    }
    
    public function mvcjs()
    {
        $this->load->file('application/modules/app/security/rol/form/rol_form.php');
        $frmRol = new Form_App_Security_Rol();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'rol_form_default' => $frmRol->toArray()
        );
        
        Helper_App_JS::showMVC('security/rol', $params);
    }
}