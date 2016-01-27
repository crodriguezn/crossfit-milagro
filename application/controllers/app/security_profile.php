<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Security_Profile extends MY_Controller
{
    protected $name_key = 'security_profile';
    
    /* @var $permission Security_Profile_Permission */
    protected $permission;
    
    function __construct()
    {
        parent::__construct( MY_Controller::SYSTEM_APP );

        $this->load->file('application/modules/app/security_profile/permission.php');
        $this->permission = new Security_Profile_Permission( $this->name_key );
        
        $this->permission->create               = Helper_App_Session::isPermissionForModule($this->name_key,'create');
        $this->permission->update               = Helper_App_Session::isPermissionForModule($this->name_key,'update');
        $this->permission->view_permission      = Helper_App_Session::isPermissionForModule($this->name_key,'view_permissions');
        $this->permission->update_permission    = Helper_App_Session::isPermissionForModule($this->name_key,'update_permissions');
        
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
            Helper_App_Log::write("Profile: intento de acceso");
            $this->redirect('app/dashboard');
            return;
        }
    }

    public function index()
    {
        $oBus = Business_App_Rol::listRol('', NULL, NULL);
        
        $eRols = $oBus->getInData('eRols');

        $combo_rol = Helper_Array::entitiesToIdText($eRols, 'id', 'name', 'value', 'text');
        
        Helper_App_View::layout('app/html/pages/security_profile/page', array(
            'combo_rol' => $combo_rol
        ));
        
    }
    
    public function mvcjs()
    {
        $this->load->file('application/modules/app/security_profile/form/profile_form.php');
        $frm_data = new Form_App_Security_Profile();
        
        $params = array(
            'link' => $this->link,
            'linkx' => $this->linkx,
            'permissions' => $this->permission->toArray(),
            'profile_form_default' => $frm_data->toArray()
        );
        
        Helper_App_JS::showMVC('security_profile', $params);
    }
       
}
